<?php

namespace app\admin\controller;

/**
 * 培训班控制器
 * @package app\admin\controller
 */
class Training extends Basic
{
    /**
     * 培训班列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }


}
