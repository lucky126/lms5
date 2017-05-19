<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/19
 * Time: 17:13
 */

namespace app\admin\controller;

/**
 * 资源控制器
 * @package app\admin\controller
 */
class Resource extends Basic
{
    /**
     * 资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }
}