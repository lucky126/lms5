<?php

namespace app\student\controller;

use think\Controller;

class Index extends Controller
{
    public function Login()
    {
        return $this->fetch();
    }

    public function Register()
    {
        return $this->fetch();
    }
}
