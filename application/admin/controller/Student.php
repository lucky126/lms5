<?php

namespace app\admin\controller;

/**
 *  学员控制器
 * @package app\admin\controller
 */
class Student extends Basic
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
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 学员编辑页
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }

    /**
     * 注册用户列表
     *
     * @return \think\Response
     */
    public function regmanager()
    {
        //
        return $this->fetch();
    }

    /**
     * 导入学员账号
     *
     * @return \think\Response
     */
    public function import()
    {
        //
        return $this->fetch();
    }

}
