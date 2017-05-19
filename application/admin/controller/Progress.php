<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/19
 * Time: 17:15
 */

namespace app\admin\controller;

/**
 * 学习情况控制器
 * @package app\admin\controller
 */
class Progress extends Basic
{
    /**
     * 学习情况列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }
}