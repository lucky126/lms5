<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-04-16
 * Time: 22:36
 */

namespace app\api\controller;

use think\Db;
use think\Cookie;

/**
 * 登录api控制器
 * @package app\api\controller
 */
class Login extends Base
{
    /**
     * 管理员登录
     * @param $username
     * @param $password
     * @return array|\think\response\Json
     */
    public function adminlogin($username, $password)
    {
        $map['usertype'] = ['<>', 3];
        return $this::login($username, $password, $map);
    }

    /**
     * 学生登录
     * @param $username
     * @param $password
     * @return \think\response\Json
     */
    public function studentlogin($username, $password)
    {
        $map['usertype'] = ['=', 3];
        return $this::login($username, $password, $map);
    }

    /**
     * 统一登录逻辑
     * @param $username
     * @param $password
     * @param $map
     * @return \think\response\Json
     */
    private function login($username, $password, $map)
    {
        //check loginname
        $map['loginname'] = ['=', $username];
        $data = Db::name('user')->where($map)->find();
        //dump($data);
        if ($data == null) {
            return json(Base::getResult(-201, "用户不存在！", null));
        }
        if ($data['status'] == 0) {
            return json(Base::getResult(-202, "用户已被禁用！", null));
        }

        //get id
        $uid = $data['uid'];
        $id = $data['id'];

        //check password
        if ($data['pwd'] <> getEncPassword($password)) {
            return json(Base::getResult(-203, "密码错误！", null));
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
        //set cookie
        Cookie::set('token', $token, 3600);
        Cookie::set('uid', $uid, 3600);
        Cookie::set('id', $id, 3600);

        //return data
        return json(Base::getResult(0, "", null));
    }

    /**
     * 登出
     * @return \think\response\Json
     */
    public function logout()
    {
        Cookie::delete('token');
        Cookie::delete('uid');

        return json(Base::getResult(0, "", null));
    }
}