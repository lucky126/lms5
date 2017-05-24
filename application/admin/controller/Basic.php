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
        if (!Cookie::has('admin')) {
            $this->redirect("/admin/login");
        }
        //get uid
        $token = Cookie::get('admin');
        $this->uid = getTokenInfo($token, 'uid');
        //set uid to view
        $this->assign("uid", $this->uid);
        //get current url
        $url = getUrl();
        //check admin
        $id = getTokenInfo($token, 'id');
        $service = controller('api/UserService', 'Service');
        $isAdmin = $service->checkAdmin($id);
        //check auth
        if (!$isAdmin && !$this::checkAuth($url, $id)) {
            $this->error('您没有权限访问');
        }
        //make menu
        $menu = $this::getMenu($url, $isAdmin, $id);
        $this->assign("menu", $menu);
    }

    /**
     * 判断权限
     * @param $url
     * @param $id
     * @return bool
     */
    protected function checkAuth($url, $id)
    {
        //make auth
        $auth = new \think\Auth();

        //check auth
        $result = $auth->check($url, $id);
        return $result;
    }

    /**
     * 得到用户菜单
     * @param $url 当前url
     * @param $isAdmin 是否管理员
     * @param $id 用户id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function getMenu($url, $isAdmin, $id)
    {
        $groupRule = Db::view('AuthGroupAccess', 'uid')
            ->view('AuthGroup', 'rules', 'AuthGroup.id=AuthGroupAccess.group_id')
            ->where('uid', '=', $id)
            ->where('status', '=', config('globalConst.STATUS_ON'))
            ->find();

        if (!$isAdmin)
            $map['id'] = ['in', $groupRule['rules']];

        $map['isshow'] = ['=', '1'];
        $map['status'] = ['=', config('globalConst.STATUS_ON')];
        $rule = DB::name('AuthRule')->where($map)->field('id,pid,name,title,icon')->select();

        $data = channelLevel($rule, $url);

        return $data;
    }


}