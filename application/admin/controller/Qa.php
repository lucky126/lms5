<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/19
 * Time: 17:13
 */

namespace app\admin\controller;

/**
 * 问答控制器
 * @package app\admin\controller
 */
class Qa extends Basic
{
    /**
     * 问答列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }
}