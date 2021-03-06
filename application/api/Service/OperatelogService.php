<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/25
 * Time: 10:29
 */

namespace app\api\Service;

use app\api\model\Operatelog;

/**
 * 操作日志服务类
 * @package api\Service
 */
class OperatelogService
{
    /**
     * 新增操作日志数据
     * @param $memo
     * @param $desc
     * @return int|string
     */
    public function insert($memo, $desc)
    {
        $userInfo = getLoginUserInfo();
        $url = getUrl();

        $log = new Operatelog();
        $log->userid = $userInfo['uid'];
        $log->usertype = $userInfo['usertype'];
        $log->operatorip = request()->ip();
        $log->operateurl = $url;
        $log->operatememo = $memo;
        $log->operatedescription = $desc;

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
        $log = new Operatelog();

        $data = $log->where('usertype', $usertype)->order('operatordate', 'desc')
            ->select();

        return $data;
    }

}