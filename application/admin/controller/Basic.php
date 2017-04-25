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

        //make auth
        $auth = new \think\Auth();
        $request = Request::instance();
        //get url
        $m = $request->module();
        $c = $request->controller();
        $a = $request->action();
        $rule_name = $m . '/' . $c . '/' . $a;
        //check auth
        $result = $auth->check($rule_name, Cookie::get('id'));
        if (!$result) {
            $this->error('您没有权限访问');
        }
        //make menu
        $menu = $this::getMenu($this->uid);
        $this->assign("menu", $menu);
    }

    /**
     * 得到用户菜单
     * @param $id
     * @return array
     */
    public function getMenu($id)
    {
        //get user info
        $user = Db::name('user')->where('uid', $id)->find();
        $groupaccess = DB::name('AuthGroupAccess')->where('uid', $user['id'])->find();
        $group = DB::name('AuthGroup')->where('id', $groupaccess['group_id'])->find();

        $map['id'] = ['in', $group['rules']];
        $map['isshow'] = ['=', '1'];

        $rule = DB::name('AuthRule')->where($map)->field('id,pid,name,title,icon')->select();

        $data = $this::channelLevel($rule);

        return $data;
    }

    /**
     *
     * @param $data
     * @param int $pid
     * @param string $fieldPri
     * @param string $fieldPid
     * @param int $level
     * @return array
     */
    static public function channelLevel($data, $pid = 0, $fieldPri = 'id', $fieldPid = 'pid', $level = 1)
    {
        if (empty($data)) {
            return array();
        }
        // dump($data);
        $arr = array();
        foreach ($data as $v) {
            if ($v[$fieldPid] == $pid) {
                $arr[$v[$fieldPri]] = $v;
                $arr[$v[$fieldPri]]['_level'] = $level;
                $arr[$v[$fieldPri]]["_data"] = self::channelLevel($data, $v[$fieldPri], $fieldPri, $fieldPid, $level + 1);
            }
        }
        // dump($arr);
        return $arr;
    }
}