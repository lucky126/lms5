<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/4/26
 * Time: 16:13
 */

namespace app\api\controller;

use think\Request;
use think\Db;

/**
 * 培训班api控制器
 * @package app\api\controller
 */

class Training extends base
{
    /**
     * 显示培训班资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $data = Db::name('Training')->where("status", "<>", "-1")->select();

        return json($data);
    }
}