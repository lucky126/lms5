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
        } else {
            $map['usertype'] = ['=', 3];
        }

        //check loginname
        $map['loginname'] = ['=', $username];
        $data = Db::name('user')->where($map)->find();

        if ($data == null) {
            return json(BaseService::getResult(-201, "用户不存在！", null));
        }

        if ($data['status'] == 0) {
            return json(BaseService::getResult(-202, "用户已被禁用！", null));
        }

        //get id
        $uid = $data['uid'];
        $id = $data['id'];

        //check password
        if ($data['pwd'] <> getEncPassword($password)) {
            return json(BaseService::getResult(-203, "密码错误！", null));
        }

        //update logininfo
        $userup = [
            'logincount' => $data['logincount'] + 1,
            'lastlogintime' => $data["currentlogintime"],
            'currentlogintime' => datetime()
        ];
        $result = Db::name('user')->where(['id' => $id])->update($userup);

        //get token
        $token = getToken($uid, $id);
        //set userinfo
        $userInfo = array(
            'uid' => $uid,
            'id' => $id,
            'token' => $token
        );

        //return success data
        return BaseService::getResult(0, "", $userInfo);
    }

    /**
     * 判断是否是管理员
     * @param $id 用户ID
     * @return bool
     */
    public function CheckAdmin($id)
    {
        $user = DB::name('User')->where('id', $id)->find();

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
    public function GetList($isAdmin)
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
    public function Get($uid)
    {
        //get user info
        $data = User::get(['uid' => $uid], 'group')->getData();
        //return data
        return $data;
    }

    /**
     * 新增用户数据
     * @param $data
     * @return int|string
     */
    public function Insert($data)
    {
        $user = new User;
        $user->uid = getGuid();
        $user->loginname = $data['loginname'];
        $user->realname = $data['RealName'];
        $user->pwd = getEncPassword($data['Password']);
        $user->usertype = $data['UserType'];
        $user->registiontime = datetime();
        $user->systemid = 1;

        if ($user->save()) {
            $userGroup = new AuthGroupAccess;
            $userGroup->group_id = $data['UserGroup'];

            $user->group()->save($userGroup);
            return 0;
        } else {
            return $user->getError();
        }
    }

    /**
     * 更新用户数据
     * @param $data
     * @return int|string
     */
    public function Update($data)
    {
        $user = User::get(['uid' => $data['uid']]);
        $user->realname = $data['RealName'];
        $user->usertype = $data['UserType'];

        if ($user->save()) {
            $user->group->group_id = $data['UserGroup'];

            $user->group->save();
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
    public function Delete($uid)
    {
        $user = User::get(['uid' => $uid]);
        $user->together('group')->delete();
    }

    /**
     * 检查用户名是否唯一
     * @param $data
     * @return bool
     */
    public function CheckUnique($data)
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
    public function ChangeStatus($id, $status)
    {
        $user = User::get($id);
        $user->status = $status;

        if ($user->save()) {
            return 0;
        } else {
            return $user->getError();
        }
    }
}
