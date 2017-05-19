<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/19
 * Time: 17:13
 */

namespace app\admin\controller;

/**
 * 考试控制器
 * @package app\admin\controller
 */
class Exam extends Basic
{
    /**
     * 考试列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }
}