<?php

namespace app\admin\controller;

/**
 * 用户控制器
 * @package app\admin\controller
 */
class User extends Basic
{
    /**
     * 用户管理页
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 用户新增页
     * @return mixed
     */
    public function Add()
    {
        $this->assign('userLevelHtml', $this->getUserTypeOption());
        return $this->fetch();
    }

    /**
     * 用户编辑页
     * @param $id
     * @return mixed
     */
    public function Edit($id)
    {
        $this->assign('userLevelHtml', $this->getUserTypeOption());
        $this->assign("id", $id);
        return $this->fetch();
    }

    public function profile()
    {
        return $this->fetch();
    }

    public function message()
    {
        return $this->fetch();
    }

    public function setting()
    {
        return $this->fetch();
    }

    /**
     * 获得用户等级html显示内容
     * @return string
     */
    private function getUserTypeOption()
    {
        $html = '';

        foreach (config('globalConst.UserTypelNameDesc') as $k => $v) {
            if ($k > 0 && $k < 3) {
                $html .= '<input type="radio" name="UserType" id="UserType" class="cbr cbr-blue" value="' . $k . '" > ' . $v . '  ';
            }
        }

        return $html;
    }
}
