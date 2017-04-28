<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-04-18
 * Time: 20:45
 */

namespace app\api\controller;

use think\Controller;
use think\exception\HttpResponseException;
use think\Response;
use think\Cookie;

/**
 * api控制器基类
 * @package app\api\controller
 */
class base extends Controller
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

    /**
     * 构造函数，用于判断是否有权限访问API
     */
    public function _initialize()
    {
        if (!Cookie::has('token')) {
            //$this->result("error","401","","json");
            $result = $this->getResult(401, "invalid token", null);
            $response = Response::create($result, "json", 401)->header([]);
            throw new HttpResponseException($response);
        }
    }
}