<?php

namespace app\api\service;

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
    public function checkAdmin($id)
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
    public function getUserList($isAdmin)
    {
        if ($isAdmin) {
            $map['usertype'] = ['not in', '0,3'];
        } else {
            $map['usertype'] = ['=', '3'];
        }
        $data = Db::name('user')->where($map)->select();

        //文字转换
        foreach ($data as $k => $v) {
            $data[$k]['UseTypeDesc'] = config('globalConst.UserTypelNameDesc')[$v['usertype']];
        }

        return $data;
    }

    /**
     * 新增用户数据
     * @param $data
     * @return int|string
     */
    public function Insert($data)
    {
        //make user data
        $userdata = [
            'uid' => getGuid(),
            'loginname' => $data['loginname'],
            'realname' => $data['RealName'],
            'pwd' => getEncPassword($data['Password']),
            'usertype' => $data['UserType'],
            'registiontime' => datetime(),
            'addtime' => datetime(),
            'systemid' => 1,
            'status' => 1,
        ];
        //insert data
        $result = Db::name('user')->insert($userdata);
        //get user id
        $userId = Db::name('user')->getLastInsID();

        //make user group info
        $group = [
            'uid' => $userId,
            'group_id' => $data['UserGroup'],
        ];
        //insert user group info
        $result = Db::name("AuthGroupAccess")->insert($group);

        return $result;
    }

    /**
     * 根据用户uuid获取用户信息
     * @param $uid
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function Get($uid)
    {
        //get user info
        $data = Db::name('user')->where('uid', $uid)->find();
        //get user group info
        $group = Db::name("AuthGroupAccess")->where('uid', $data['id'])->find();
        //set user group info into user info
        $data['usergroup'] = $group == null ? "" : $group['group_id'];
        //return data
        return $data;
    }

    /**
     * 更新用户数据
     * @param $data
     * @return int|string
     */
    public function Update($data)
    {
        //update user info
        $result = Db::name('user')
            ->where('uid', $data['uid'])
            ->update(['realname' => $data['RealName'], 'usertype' => $data['UserType']]);
        //get user id
        $user = Db::name('user')->where('uid', $data['uid'])->find();
        $id = $user['id'];
        //update user group info
        $result = Db::name("AuthGroupAccess")
            ->where('uid', $id)
            ->update(['group_id' => $data['UserGroup']]);

        return $result;
    }

    /**
     * 删除用户数据
     * @param $uid
     */
    public function Delete($uid)
    {
        //get user id
        $user = Db::name('user')->where('uid', $uid)->find();
        $id = $user['id'];
        //delete user group info
        Db::name('AuthGroupAccess')->where('uid', $id)->delete();

        //delete user info
        Db::name('user')->where('uid', $uid)->delete();
    }

    /**
     * 检查用户名是否唯一
     * @param $map
     * @return bool
     */
    public function CheckUnique($map)
    {
        if (Db::name('user')->where($map)->find() != null) {
            return false;
        }

        return true;
    }
}
