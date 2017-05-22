<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/22
 * Time: 13:33
 */

namespace app\api\service;

use think\Db;

/**
 * 学生培训计划服务类
 * @package app\api\service
 */
class StudenttraningService extends BaseService
{
    /**
     * 获取学生培训计划列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function GetTrainingInfo($uid, $sysid)
    {
        //init param
        $studying = 0;
        $needPay = 0;

        //get data
        $data = Db::view('studenttraining', 'trainingid,ispayment,isallowlearning')
            ->view('training', 'isopen,starttime,endtime', 'studenttraining.trainingid=training.id and studenttraining.systemid=training.systemid', 'LEFT')
            ->where('studentid', '=', $uid)
            ->where('studenttraining.systemid', '=', $sysid)
            ->select();

        foreach ($data as $row) {
            if ($row['ispayment'] == config('globalConst.STATUS_OFF')) {
                $needPay++;
            }
            if ($row['ispayment'] == config('globalConst.STATUS_ON') &&
                $row['isopen'] == config('globalConst.STATUS_ON') &&
                $row['starttime'] <= datetime() && $data['endtime'] >= datetime()
            ) {
                $studying++;
            }
        }

        return Array('studying' => $studying, 'needPay' => $needPay);
    }
}