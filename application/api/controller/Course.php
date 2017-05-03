<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-03
 * Time: 23:10
 */

namespace app\api\controller;

use think\Request;
use think\Db;

/**
 * 课程api控制器
 * @package app\api\controller
 */
class Course extends base
{
    /**
     * 显示课程资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //get data
        //$map['status'] = ['<>', '0'];
        $data = Db::name('Course')->select();

        return json($data);
    }
}