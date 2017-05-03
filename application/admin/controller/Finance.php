<?php

namespace app\admin\controller;

/**
 * 财务控制器
 * @package app\admin\controller
 */
class Finance extends Basic
{
    /**
     * 财务列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }
}
