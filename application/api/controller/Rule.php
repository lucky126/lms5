<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-04-22
 * Time: 21:07
 */

namespace app\api\controller;

use think\Request;
use think\Db;

/**
 * 权限api控制器
 * @package app\api\controller
 */
class Rule extends base
{
    /**
     * 显示权限资源列表
     *
     * @return \think\Response
     */
    public function index($pid = 0)
    {
        //
        $data = $this->getRule($pid);

        return json($data);
    }

    /**
     * @param $pid
     * @return false|\PDOStatement|string|\think\Collection
     */
    private function getRule($pid)
    {
        //
        $data = Db::name('AuthRule')->where("status", "<>", "0")->where("pid", "=", $pid)->select();

        //文字转换
        foreach ($data as $k => $v) {
            $data[$k]['isshowdesc'] = config('globalConst.YesOrNoDesc')[$v['isshow']];
        }

        return $data;
    }
}