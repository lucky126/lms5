<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-08
 * Time: 22:28
 */

namespace app\api\controller;

use think\Controller;

/**
 * api控制器通用类
 * @package app\api\controller
 */
class Base extends Controller
{
    /**
     *  定义返回值结构体
     * @param $code
     * @param $msg
     * @param $data
     * @return array
     */
    protected function getResult($code, $msg, $data)
    {
        $result = array(
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        );

        return $result;
    }
}