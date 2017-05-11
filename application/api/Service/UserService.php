<?php

namespace app\api\service;

use think\Db;

/**
 * 用户服务类
 * @package app\apimodule\controller
 */
class UserService extends BaseService
{
    /**
     * 统一登录逻辑
     * @param $username
     * @param $password
     * @param $map
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
        $token = getToken($uid);
        //set userinfo
        $userInfo =  array(
            'uid' => $uid,
            'id' => $id,
            'token' => $token
        );

        //return success data
        return BaseService::getResult(0, "", $userInfo);
    }

    /**
     * 判断是否是管理员
     * @param $id
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
}
