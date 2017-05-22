<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/22
 * Time: 13:04
 */

namespace app\student\service;

/**
 * 服务通用类
 * @package app\apimodule\controller
 */
class BaseService
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
