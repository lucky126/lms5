<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-04-16
 * Time: 22:36
 */

namespace app\api\controller;

use app\apimodule;
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
        $service = controller('UserService', 'Service');
        $result = $service->login($username, $password, true);
        $userInfo = $result['data'];

        Cookie::set('admin', $userInfo['token'], 3600);
        Cookie::set('id', $userInfo['id'], 3600);
        Cookie::set('uid', $userInfo['uid'], 3600);
        return json(Base::getResult($result['code'], $result['msg'], null));
    }

    /**
     * 学生登录
     * @param $username
     * @param $password
     * @return \think\response\Json
     */
    public function studentlogin($username, $password)
    {
        $service = controller('UserService', 'Service');
        $result = $service->login($username, $password, false);
        $userInfo = $result['data'];

        Cookie::set('student', $userInfo['token'], 3600);
        Cookie::set('id', $userInfo['id'], 3600);
        Cookie::set('uid', $userInfo['uid'], 3600);
        return json(Base::getResult($result['code'], $result['msg'], null));
    }

    /**
     * 管理员登出
     * @return mixed
     */
    public function adminlogout()
    {
        Cookie::delete('admin');
        return $this::logout();
    }

    /**
     * 学生登出
     * @return mixed
     */
    public function studentlogout()
    {
        Cookie::delete('student');
        return $this::logout();
    }

    /**
     * 登出
     * @return \think\response\Json
     */
    private function logout()
    {
        return json(Base::getResult(0, "", null));
    }
}