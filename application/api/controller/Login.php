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
        $map['usertype'] = ['<>', 3];
        $service = controller('UserService', 'Service');
        $result = $service->login($username, $password, $map);
        return json($result);
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
        $service = controller('UserService', 'Service');
        $result = $service->login($username, $password, $map);
        return json($result);
    }

    /**
     * @return mixed
     */
    public function adminlogout()
    {
        return logout();
    }

    /**
     * @return mixed
     */
    public function studentlogout()
    {
        return logout();
    }

    /**
     * 登出
     * @return \think\response\Json
     */
    private function logout()
    {
        Cookie::delete('token');
        Cookie::delete('uid');

        return json(Base::getResult(0, "", null));
    }
}