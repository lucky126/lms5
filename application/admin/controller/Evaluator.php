<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/19
 * Time: 17:13
 */

namespace app\admin\controller;

/**
 * 投票控制器
 * @package app\admin\controller
 */
class Evaluator extends Basic
{
    /**
     * 投票列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }
}