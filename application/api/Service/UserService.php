<?php

namespace app\api\service;

use app\api\model\AuthGroupAccess;
use app\api\model\User;
use think\Db;

/**
 * 用户服务类
 * @package app\api\service
 */
class UserService extends BaseService
{
    /**
     * 统一登录逻辑
     * @param $username 用户名
     * @param $password 密码
     * @param $isadmin 是否管理员
     * @return array|\think\response\Json
     */
    public function login($username, $password, $isadmin)
    {
        if ($isadmin) {
            $map['usertype'] = ['<>', 3];
            $usertype = 0;
        } else {
            $map['usertype'] = ['=', 3];
            $usertype = 1;
        }

        $login_success = true;
        $result = BaseService::setResult(0, "登录成功", null);

        //check loginname
        $map['loginname'] = ['=', $username];
        $data = Db::name('user')->where($map)->find();

        if ($data == null) {
            $login_success = false;
            $result['code'] = -201;
            $result['msg'] = '用户不存在！';
        }

        if ($data['status'] == 0) {
            $login_success = false;
            $result['code'] = -202;
            $result['msg'] = '用户已被禁用！';
        }

        //get id
        $uid = $data['uid'];
        $id = $data['id'];

        //check password
        if ($data['pwd'] <> getEncPassword($password)) {
            $login_success = false;
            $result['code'] = -203;
            $result['msg'] = '密码错误！';
        }

        if ($login_success) {
            //reset $password
            $password = '******';
            //update logininfo
            $user = User::get($id);
            $user->logincount++;
            $user->lastlogintime = $user->currentlogintime;
            $user->currentlogintime = datetime();

            $user->save();

            //get token
            $token = getToken($uid, $id);
            //set userinfo
            $userInfo = array(
                'uid' => $uid,
                'id' => $id,
                'token' => $token
            );

            $result['data'] = $userInfo;
        }

        //保存登录日志
        $logService = controller('LoginlogService', 'Service');
        $logService->insert($username, $password, $result['msg'], $usertype);

        //return success data
        return $result;
    }

    /**
     * 判断是否是管理员
     * @param $id 用户ID
     * @return bool
     */
    public function checkAdmin($id)
    {
        $user = User::get($id)->getData();

        $isAdmin = false;
        if ($user['usertype'] == 0) {
            $isAdmin = true;
        }

        return $isAdmin;
    }

    /**
     * 获取用户列表
     * @param $isAdmin 是否管理员
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getList($isAdmin)
    {
        //get data
        $user = new User();

        if ($isAdmin) {
            $data = $user->where('usertype', 'not in', '0,3')
                ->order('id', 'desc')
                ->select();
        } else {
            $data = $user->where('usertype', '=', '3')
                ->order('id', 'desc')
                ->select();
        }

        return $data;
    }

    /**
     * 根据用户uuid获取用户信息
     * @param $uid
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function get($uid)
    {
        //get user info
        $data = User::get(['uid' => $uid], 'group');
        //5.0.10修改后，所有hasone hasmany的model层方法均需要手工调用一次getData方法后赋值到数组方可使用
        $data['group'] = $data->getData('group');
        if ($data != null) {
            return $data->getData();
        } else {
            return null;
        }
    }

    /**
     * 新增用户数据
     * @param $data
     * @param $isAdmin
     * @return array
     */
    public function insert($data, $isAdmin)
    {
        $user = new User;
        $user->uid = getGuid();
        $user->loginname = $data['loginname'];
        $user->realname = $data['RealName'];
        $user->pwd = getEncPassword($data['Password']);
        $user->usertype = $data['UserType'];
        $user->registiontime = datetime();
        $user->systemid = $data['systemid'];

        $loginfo = json_encode($user);

        if ($user->save()) {
            if ($isAdmin) {
                $userGroup = new AuthGroupAccess;
                $userGroup->group_id = $data['UserGroup'];

                $user->group()->save($userGroup);

                $loginfo = $loginfo . ' & ' . json_encode($userGroup);
            }

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('新增用户： ' . $loginfo, '新增用户');

            return BaseService::setResult('0', '', $user->uid);
        } else {
            return BaseService::setResult('-100', $user->getError(), '');
        }
    }

    /**
     * 更新用户数据
     * @param $data
     * @return int|string
     */
    public function update($data)
    {
        $user = User::get(['uid' => $data['uid']]);
        $user->realname = $data['RealName'];
        $user->usertype = $data['UserType'];

        if ($user->save()) {
            $user->group->group_id = $data['UserGroup'];

            $user->group->save();

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('更新用户： ' . json_encode($user), '更新用户');

            return 0;
        } else {
            return $user->getError();
        }
    }

    /**
     * 删除用户数据
     * @param $uid
     * @return int|string
     */
    public function delete($uid)
    {
        $user = User::get(['uid' => $uid]);
        $user->together('group')->delete();

        //保存操作日志
        $logService = controller('OperatelogService', 'Service');
        $logService->insert('删除用户： ' . json_encode($user), '删除用户');
    }

    /**
     * 检查用户名是否唯一
     * @param $data
     * @return bool
     */
    public function checkUnique($data)
    {
        $map['loginname'] = $data['loginname'];
        if (Db::name('user')->where($map)->find() != null) {
            return false;
        }

        return true;
    }

    /**
     * 设置状态
     * @param $id 用户id
     * @param $status 目标状态值
     * @return int|string
     */
    public function changeStatus($id, $status)
    {
        $user = User::get($id);
        $user->status = $status;

        if ($user->save()) {

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $memo = '更新用户ID为 ' . $id . ' 的状态为' . $status;
            $logService->insert($memo, '更新用户状态');

            return 0;
        } else {
            return $user->getError();
        }
    }

    /**
     * 判断是否是测试用户
     * @param $id
     * @return bool
     */
    public function isTestUser($id)
    {
        $user = $this->get($id);

        if ($user != null && $user['istestuser'] == config('globalConst.STATUS_ON')) {
            return true;
        }

        return false;
    }
}
