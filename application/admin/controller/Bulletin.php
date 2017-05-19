<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/19
 * Time: 17:28
 */

namespace app\admin\controller;


/**
 * 论坛控制器
 * @package app\admin\controller
 */
class Bulletin extends Basic
{
    /**
     * 论坛列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }
}