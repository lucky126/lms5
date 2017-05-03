<?php

namespace app\admin\controller;

/**
 *  学员控制器
 * @package app\admin\controller
 */
class Student extends Controller
{
    /**
     * 学员列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return $this->fetch();
    }

    /**
     * 学员新增页
     * @return mixed
     */
    public function Add()
    {
        return $this->fetch();
    }

    /**
     * 学员编辑页
     * @param $id
     * @return mixed
     */
    public function Edit($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }
}
