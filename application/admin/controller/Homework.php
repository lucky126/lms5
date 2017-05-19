<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/19
 * Time: 17:13
 */

namespace app\admin\controller;

/**
 * 作业控制器
 * @package app\admin\controller
 */
class Homework extends Basic
{
    /**
     * 作业列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }
}