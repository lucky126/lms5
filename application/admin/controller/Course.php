<?php

namespace app\admin\controller;

/**
 * 课程控制器
 * @package app\admin\controller
 */
class Course extends Basic
{
    /**
     * 课程列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }

    /**
     * 课程新增页
     * @return mixed
     */
    public function Add()
    {
        return $this->fetch();
    }

    /**
     * 课程编辑页
     * @param $id
     * @return mixed
     */
    public function Edit($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }
}
