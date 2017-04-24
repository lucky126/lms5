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

    /**
     * 权限新增页
     * @return mixed
     */
    public function Add($pid = 0)
    {
        $this->assign("pid", $pid);
        return $this->fetch();
    }

    /**
     * 权限编辑页
     * @param $id
     * @return mixed
     */
    public function Edit($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }

    /**
     * 角色列表
     *
     * @return \think\Response
     */
    public function group()
    {
        //
        return $this->fetch();
    }

    /**
     * 角色新增页
     * @return mixed
     */
    public function Addgroup()
    {
        return $this->fetch();
    }

    /**
     * 角色编辑页
     * @param $id
     * @return mixed
     */
    public function Editgroup($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }

}
