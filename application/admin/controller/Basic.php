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
use think\Db;

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

        //check token
        if (!Cookie::has('token')) {
            $this->redirect("/admin/login");
        }
        //get uid
        $this->uid = Cookie::get('uid');
        //set uid
        $this->assign("uid", $this->uid);
        //get currrent url
        $url = $this::getUrl();
        //check admin
        $isAdmin = $this::checkAdmin();
        //check auth
        if (!$isAdmin && !$this::checkAuth($url)) {
            $this->error('您没有权限访问');
        }
        //make menu
        $menu = $this::getMenu($url, $isAdmin);
        $this->assign("menu", $menu);
    }

    /**
     * 判断是否是管理员
     */
    private function checkAdmin()
    {
        $user = DB::name('User')->where('id', Cookie::get('id'))->find();

        $isAdmin = false;
        if ($user['usertype'] == 0) {
            $isAdmin = true;
        }

        return $isAdmin;
    }

    /**
     * 得到当前访问路径
     * @return string
     */
    protected function getUrl()
    {
        $request = Request::instance();
        //get url
        $m = $request->module();
        $c = $request->controller();
        $a = $request->action();
        $rule_name = $m . '/' . $c . '/' . $a;

        return $rule_name;
    }

    /**
     * 判断权限
     * @param $url
     * @return bool
     */
    protected function checkAuth($url)
    {
        //make auth
        $auth = new \think\Auth();

        //check auth
        $result = $auth->check($url, Cookie::get('id'));
        return $result;
    }

    /**
     * 得到用户菜单
     * @param $url
     * @return array
     */
    public function getMenu($url, $isAdmin)
    {
        //$groupaccess = DB::name('AuthGroupAccess')->where('uid', Cookie::get('id'))->find();
        //$group = DB::name('AuthGroup')->where('id', $groupaccess['group_id'])->find();

        $data = Db::view('AuthGroupAccess', 'uid')
            ->view('AuthGroup', 'rules', 'AuthGroup.id=AuthGroupAccess.group_id')
            ->where('uid', '=', Cookie::get('id'))
            ->find();

        if (!$isAdmin)
            $map['id'] = ['in', $data['rules']];

        $map['isshow'] = ['=', '1'];

        $rule = DB::name('AuthRule')->where($map)->field('id,pid,name,title,icon')->select();

        $data = channelLevel($rule, $url);

        return $data;
    }


}