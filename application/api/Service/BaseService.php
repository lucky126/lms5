<?php

namespace app\api\service;

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
    protected function setResult($code, $msg, $data)
    {
        $result = array(
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        );

        return $result;
    }
}
