<?php

namespace app\admin\controller;

use think\Request;

/**
 * 权限控制器
 * @package app\admin\controller
 */
class Rule extends Basic
{
    /**
     * 权限列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }

}
