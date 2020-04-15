<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/25
 * Time: 14:08
 */

namespace app\api\Service;

use app\api\model\Loginlog;

/**
 * 登录日志服务类
 * @package app\api\Service
 */
class LoginlogService
{
    /**
     * 新增登录日志数据
     * @param $loginname
     * @param $pwd
     * @param $result
     * @param $usertype
     * @return int|string
     */
    public function insert($loginname, $pwd, $result, $usertype)
    {
        $log = new Loginlog();
        $log->usertype = $usertype;
        $log->loginname = $loginname;
        $log->pwd = $pwd;
        $log->operatorip = request()->ip();
        $log->operateresult = $result;

        if ($log->save()) {
            return 0;
        } else {
            return $log->getError();
        }
    }

    /**
     * 获取列表
     * @param $usertype
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getList($usertype)
    {
        //get data
        $log = new Loginlog();

        $data = $log->where('usertype', $usertype)->order('operatordate', 'desc')
            ->select();

        return $data;
    }
}