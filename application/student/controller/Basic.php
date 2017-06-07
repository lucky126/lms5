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

        //make menu
        $menu = $this::getMenu($url);
        $this->assign("menu", $menu);
    }

    /**
     * 得到用户菜单
     * @param $url 当前url
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function getMenu($url)
    {
        //id,pid,name,title,icon
        $rule = Array(
            '0' => Array('id' => '1', 'pid' => '0', 'name' => '', 'title' => '我的信息', 'icon' => 'fa fa-user'),
            '1' => Array('id' => '2', 'pid' => '1', 'name' => 'student/user/profile', 'title' => '查看信息', 'icon' => ''),
            '2' => Array('id' => '3', 'pid' => '1', 'name' => 'student/user/changepwd', 'title' => '修改密码', 'icon' => ''),
            '3' => Array('id' => '4', 'pid' => '0', 'name' => 'student/training/signup', 'title' => '我要报名', 'icon' => 'fa fa-sign-in'),
            '4' => Array('id' => '5', 'pid' => '0', 'name' => '', 'title' => '缴费信息', 'icon' => 'fa fa-credit-card-alt'),
            '5' => Array('id' => '6', 'pid' => '5', 'name' => 'student/finance/pay', 'title' => '我要交费', 'icon' => ''),
            '6' => Array('id' => '7', 'pid' => '5', 'name' => 'student/finance/paidinfo', 'title' => '已交费记录', 'icon' => ''),
            '7' => Array('id' => '8', 'pid' => '0', 'name' => '', 'title' => '学习交流', 'icon' => 'fa fa-comments'),
            '8' => Array('id' => '9', 'pid' => '8', 'name' => 'student/class/resource', 'title' => '学习资料', 'icon' => ''),
            '9' => Array('id' => '10', 'pid' => '8', 'name' => 'student/class/qa', 'title' => '课程问答', 'icon' => ''),
            '10' => Array('id' => '11', 'pid' => '8', 'name' => 'student/class/bulletin', 'title' => '交流论坛', 'icon' => ''),
            '11' => Array('id' => '12', 'pid' => '0', 'name' => '', 'title' => '成绩查询', 'icon' => 'fa fa-reorder'),
            '12' => Array('id' => '13', 'pid' => '12', 'name' => 'student/studyrecord/current', 'title' => '当前记录', 'icon' => ''),
            '13' => Array('id' => '14', 'pid' => '12', 'name' => 'student/studyrecord/history', 'title' => '历史记录', 'icon' => ''),
            '14' => Array('id' => '15', 'pid' => '0', 'name' => 'student/notic/index', 'title' => '系统公告', 'icon' => 'fa fa-info-circle'),
            '15' => Array('id' => '16', 'pid' => '0', 'name' => 'student/alert/index', 'title' => '重要提醒', 'icon' => 'fa fa-bell'),
        );

        $data = channelLevel($rule, $url);

        return $data;
    }
}