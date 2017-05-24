<?php

namespace app\admin\controller;

/**
 * 系统控制器
 * @package app\admin\controller
 */
class System extends Basic
{
    /**
     * 系统列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }

    /**
     * 系统新增页
     * @return mixed
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 系统编辑页
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }
}
