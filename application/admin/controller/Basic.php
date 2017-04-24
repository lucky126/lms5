<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-04-18
 * Time: 21:35
 */

namespace app\admin\controller;

use think\Controller;
use think\Cookie;
use think\Request;

/**
 * 页面控制器基础类
 * @package app\admin\controller
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

        if (!Cookie::has('token')) {
            $this->redirect("/admin/login");
        }

        $this->uid = Cookie::get('uid');

        $this->assign("uid",$this->uid);

        $auth=new \think\Auth();
        $request = Request::instance();
        $m=$request->module();
        $c=$request->controller();
        $a=$request->action();
        $rule_name=$m.'/'.$c.'/'.$a;
/*
        $result=$auth->check($rule_name,session('user')['id']);
        if(!$result){
            $this->error('您没有权限访问');
        }*/
    }
}