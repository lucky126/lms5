<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/4/24
 * Time: 14:42
 */

namespace app\api\controller;

use think\Request;
use think\Db;

/**
 * 角色api控制器
 * @package app\api\controller
 */
class Group extends base
{
    /**
     * 显示角色资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $data = Db::name('AuthGroup')->where("status", "<>", "0")->select();

        return json($data);
    }

    /**
     * 显示指定的角色资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
        $data = Db::name('AuthGroup')->where('id', $id)->find();

        return json($data);
    }

    /**
     * 保存新建的角色资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save()
    {
        //
        if (Request::instance()->post()) {
            $data = input('post.');

            $userdata = [
                'title' => $data['title'],
                'rules' => '',
            ];

            $result = Db::name('AuthGroup')->insert($userdata);
            return json("success");
        }
    }

    /**
     * 保存更新的角色资源
     *
     * @param   $id
     * @return \think\Response
     */
    public function update($id)
    {
        //
        if (Request::instance()->put()) {
            $data = input('put.');
            //dump($data);

            $result = Db::name('AuthGroup')
                ->where('id', $id)
                ->update(['title' => $data['title']]);

            return json("success");
        }
    }

    /**
     * 删除指定角色资源
     *
     * @param  uuid $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
        Db::name('AuthGroup')->where('id', $id)->delete();
        return json("success");
    }
}