<?php

namespace app\admin\controller;

/**
 * 首页控制器
 * @package app\admin\controller
 */
class Index extends Basic
{
    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 菜单
     * @return mixed
     */
    public function menu()
    {
        return $this->fetch();
    }

    /**
     * 顶部提示消息
     * @return mixed
     */
    public function message()
    {
        return $this->fetch();
    }

    /**
     * 左侧个人信息
     * @return mixed
     */
    public function leftinfo()
    {
        return $this->fetch();
    }

    /**
     * 顶部个人信息
     * @return mixed
     */
    public function topinfo()
    {
        return $this->fetch();
    }

    /**
     * 系统状态
     * @return mixed
     */
    public function serverstatus()
    {
        return $this->fetch();
    }
}
