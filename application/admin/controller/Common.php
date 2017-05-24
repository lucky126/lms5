<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-04-18
 * Time: 21:33
 */

namespace app\admin\controller;

use think\Controller;

class Common extends Controller
{
    /**
     * @return mixed
     */
    public function login()
    {
        return $this->fetch();
    }
}