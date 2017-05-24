<?php

namespace app\admin\controller;

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
    public function add($pid = 0)
    {
        $this->assign("pid", $pid);
        return $this->fetch();
    }

    /**
     * 权限编辑页
     * @param $id
     * @return mixed
     */
    public function edit($id)
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
    public function addgroup()
    {
        return $this->fetch();
    }

    /**
     * 角色编辑页
     * @param $id
     * @return mixed
     */
    public function editgroup($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }

    /**
     * 角色权限编辑页
     * @param $id
     * @return mixed
     */
    public function grouprule($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }

}
