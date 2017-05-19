<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/7
 * Time: 10:01
 */

namespace app\student\controller;

use think\Controller;
use think\Cookie;

/**
 * 学生端页面控制器基础类
 * @package app\student\controller
 */
class Basic extends Controller
{
    //用户id
    protected $uid;

    /**
     * 基础构造函数
     * 用于判断token权限和获得uid
     */
    public function _initialize()
    {
        parent::_initialize();

        //check token
        if (!Cookie::has('student')) {
            $this->redirect("/student/login");
        }
        //get uid
        $token = Cookie::get('student');
        $this->uid = getTokenInfo($token, 'uid');
        //set uid
        $this->assign("uid", $this->uid);
        //get current url
        $url = getUrl();
    }
}