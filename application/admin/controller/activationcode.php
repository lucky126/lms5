<?php

namespace app\admin\controller;

/**
 * 激活码控制器
 * @package app\admin\controller
 */
class activationcode extends Basic
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
    public function Add()
    {
        return $this->fetch();
    }

    /**
     * 激活码编辑页
     * @param $id
     * @return mixed
     */
    public function Edit($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }
}
