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

    /**
     * 离线交费确认
     *
     * @return \think\Response
     */
    public function offlineconfirm()
    {
        //
        return $this->fetch();
    }

    /**
     * 财务统计
     *
     * @return \think\Response
     */
    public function stat()
    {
        //
        return $this->fetch();
    }
}
