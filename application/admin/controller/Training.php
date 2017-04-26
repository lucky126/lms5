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

    /**
     * 培训班新增页
     * @return mixed
     */
    public function Add()
    {
        return $this->fetch();
    }

    /**
     * 培训班编辑页
     * @param $id
     * @return mixed
     */
    public function Edit($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }
}
