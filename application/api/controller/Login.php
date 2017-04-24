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
 * 登录登出api控制器
 * @package app\api\controller
 */
class Login
{
    /**
     * 登录
     * @param $username
     * @param $password
     * @return array|\think\response\Json
     */
    public function index($username, $password)
    {
        $returnModel = array("code" => 0, "message" => "", "data" => null);

        //check loginname
        $data = Db::name('user')->where('loginname', $username)->find();
        //dump($data);
        if ($data == null) {
            $returnModel["code"] = "-201";
            $returnModel["message"] = "用户不存在！";
            return $returnModel;
        }
        //get id
        $uid = $data['uid'];
        $id = $data['id'];

        //check password
        if ($data['pwd'] <> getEncPassword($password)) {
            $returnModel["code"] = "-202";
            $returnModel["message"] = "密码错误！";
            return $returnModel;
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

        //return data
        return json($returnModel);
    }

    /**
     * 登出
     * @return \think\response\Json
     */
    public function logout()
    {
        $returnModel = array("code" => 0, "message" => "", "data" => null);

        Cookie::delete('token');
        Cookie::delete('uid');

        return json($returnModel);
    }
}