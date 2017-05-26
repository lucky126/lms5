<?php

namespace app\admin\controller;

/**
 * 激活码控制器
 * @package app\admin\controller
 */
class Activationcode extends Basic
{
    /**
     * 激活码列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }

    /**
     * 激活码新增页
     * @return mixed
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 撤销激活码
     * @return mixed
     */
    public function revoke()
    {
        return $this->fetch();
    }
}
