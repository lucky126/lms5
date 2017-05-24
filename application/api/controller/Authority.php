<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-04-18
 * Time: 20:45
 */

namespace app\api\controller;

use think\exception\HttpResponseException;
use think\Response;
use think\Cookie;

/**
 * api控制器授权类
 * @package app\api\controller
 */
class Authority extends Base
{

    /**
     * 构造函数，用于判断是否有权限访问API
     */
    public function _initialize()
    {
        if (!Cookie::has('admin') && !Cookie::has('student')) {
            //$this->setResult("error","401","","json");
            $result = $this->setResult(401, "invalid token", null);
            $response = Response::create($result, "json", 401)->header([]);
            throw new HttpResponseException($response);
        }
    }

    /**
     * 404
     */
    public function resourceNotFound()
    {
        $result = $this->setResult(404, "not found", null);
        $response = Response::create($result, "json", 404)->header([]);
        throw new HttpResponseException($response);
    }
}