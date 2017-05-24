<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/18
 * Time: 11:11
 */

namespace app\api\controller;


/**
 * 注册学员api控制器
 * @package app\api\controller
 */
class Reguser extends Authority
{
    /**
     * 显示注册学员资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $service = controller('UserService', 'Service');
        $data = $service->getList(false);

        return json($data);
    }
}