<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/25
 * Time: 14:36
 */

namespace app\admin\controller;

/**
 * 日志控制器
 * @package app\admin\controller
 */
class Log extends Basic
{
    /**
     * 管理端登录日志
     *
     * @return \think\Response
     */
    public function adminloginlog()
    {
        //
        return $this->fetch();
    }

    /**
     * 管理端操作日志
     *
     * @return \think\Response
     */
    public function adminoperatelog()
    {
        //
        return $this->fetch();
    }
}