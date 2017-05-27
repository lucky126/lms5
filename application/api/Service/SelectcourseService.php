<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/22
 * Time: 13:33
 */

namespace app\api\service;

use app\api\model\Studenttraining;
use think\Db;

/**
 * 学生培训计划服务类
 * @package app\api\service
 */
class SelectcourseService extends BaseService
{
    /**
     * 获取学生培训计划列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getTrainingInfo($uid, $sysid)
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


    /**
     * 获取可以报名的培训计划
     * @param $uid
     * @param $sysid
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getAllowRegTrainingList($uid, $sysid)
    {
        //get data
        $subQuery = Db::name('studenttraining')
            ->field('trainingid')
            ->where('studentid', '=', $uid)
            ->buildSql();

        $service = controller('TrainingService', 'Service');
        $data = $service->getOpenList($sysid, $subQuery);

        return $data;
    }

    /**
     * 新增培训计划报名信息
     * @param $data
     * @return int
     */
    public function signIn($data)
    {
        $existInfo = Studenttraining::get(['systemid' => $data['sysid'], 'studentid' => $data['uid'], 'trainingid' => $data['id']]);
        //存在报名信息

        if ($existInfo != null) {
            return -201;
        }

        //新增报名信息
        $studenttraining = new Studenttraining();
        $studenttraining->trainingid = $data['id'];
        $studenttraining->systemid = $data['sysid'];
        $studenttraining->studentid = $data['uid'];
        $studenttraining->certificatecode = '';

        if ($studenttraining->save()) {

            Db::execute("INSERT INTO lms_studentcourse (trainingid,systemid,studentid,courseid,selecttime,type) SELECT trainingid,:systemid,:studentid,scormid,now(),2 FROM lms_trainingcourse WHERE trainingid=:trainingid",
                ['trainingid' => $data['id'],'systemid' => $data['sysid'],'studentid' => $data['uid']]);

            return 0;
        } else {
            return $studenttraining->getError();
        }
    }


    /**
     * 获取需要交费的培训计划
     * @param $uid
     * @param $sysid
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNeedPayTrainingList($uid, $sysid)
    {
        //get data
        $subQuery = Db::name('studenttraining')
            ->field('trainingid')
            ->where('studentid', '=', $uid)
            ->where('systemid', '=', $sysid)
            ->where('isallowlearning', '=', 0)
            ->where('ispayment', '=', 0)
            ->buildSql();

        $map['systemid'] = ['=', $sysid];
        $map['starttime'] = ['<=', datetime()];
        $map['endtime'] = ['>=', datetime()];
        $map['id'] = ['not in', $subQuery];

        $data = Db::name('training')
            ->where($map)
            ->select();

        return $data;
    }
}