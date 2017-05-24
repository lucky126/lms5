<?php

namespace app\student\controller;

use think\Controller;

class Common extends Controller
{
    /**
     * 学生登录
     * @return mixed
     */
    public function login()
    {
        return $this->fetch();
    }

    /**
     * 学生注册
     * @return mixed
     */
    public function register()
    {
        return $this->fetch();
    }
}
