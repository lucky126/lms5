<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/25
 * Time: 14:40
 */

namespace app\api\controller;

/**
 * 日志api控制器
 * @package app\api\controller
 */
class Log extends Authority
{
    /**
     * 管理端登录日志列表
     *
     * @return \think\Response
     */
    public function adminloginlog()
    {
        //
        $service = controller('LoginlogService', 'Service');
        $data = $service->getList(0);

        return json($data);
    }

    /**
     * 管理端操作日志列表
     *
     * @return \think\Response
     */
    public function adminoperatelog()
    {
        //
        $service = controller('OperatelogService', 'Service');
        $data = $service->getList(0);

        return json($data);
    }
}