<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/22
 * Time: 13:33
 */

namespace app\api\service;

use app\api\model\Studentcourse;
use app\api\model\Studenttraining;
use think\Db;

/**
 * 学生培训计划服务类
 * @package app\api\service
 */
class StudenttrainingService
{
    /**
     * 获取学生可以学习和需要交费的培训计划数量
     * @param $uid
     * @param $sysid
     * @return array
     */
    public function getTrainingInfo($uid, $sysid)
    {
        //init param
        $studying = 0;
        $needPay = 0;

        //get data
        $data = Db::view('studenttraining', 'trainingid,ispayment')
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
                $row['starttime'] <= datetime() && $row['endtime'] >= datetime()
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
        $data = $service->getOpenSignupList($sysid, $subQuery);

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
                ['trainingid' => $data['id'], 'systemid' => $data['sysid'], 'studentid' => $data['uid']]);

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

    /**
     * 获取学生可以学习的培训计划列表，仅返回培训计划id
     * @param $uid
     * @param $sysid
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getTrainingList($uid, $sysid)
    {
        //get data
        $data = Db::name('studenttraining', '')
            ->alias('st')
            ->field('t.id')
            ->join('training t', 'st.trainingid = t.id and st.systemid=t.systemid', 'LEFT')
            ->where('studentid', '=', $uid)
            ->where('st.systemid', '=', $sysid)
            ->where('t.isopen', '=', config('globalConst.STATUS_ON'))
            ->where('st.isallowlearning', '=', config('globalConst.STATUS_ON'))
            ->whereTime('starttime', '<=', datetime())
            ->whereTime('endtime', '>=', datetime())
            ->select();

        return $data;
    }

    /**
     * 判断学生是否通过了指定培训班的学习
     * @param $tid
     * @param $uid
     * @param $sysid
     * @return bool
     */
    public function isPassedTraining($tid, $uid, $sysid)
    {
        $pass_score_data = Db::name('studenttraining')
            ->alias('st')
            ->field('t.id')
            ->join('training t', 'st.trainingid = t.id and st.systemid=t.systemid', 'LEFT')
            ->where('st.totalscore', '>=', 't.minpassresult')
            ->where('st.trainingid', '=', $tid)
            ->where('st.systemid', '=', $sysid)
            ->where('st.studentid', '=', $uid)
            ->count();

        if ($pass_score_data > 0) {
            return true;
        }

        return false;
    }


    /**
     * 获取学生指定培训班信息
     * @param $tid
     * @param $uid
     * @param $sysid
     * @return mixed|null
     */
    public function get($tid, $uid, $sysid)
    {
        //get info
        $trainingData = Studenttraining::get(['trainingid' => $tid, 'systemid' => $sysid, 'studentid' => $uid]);
        $trainingCourseData = Studentcourse::get(['trainingid' => $tid, 'systemid' => $sysid, 'studentid' => $uid]);

        if ($trainingData != null && $trainingCourseData != null) {
            $trainingData['courses'] = $trainingCourseData;
            return $trainingData->getData();
        } else {
            return null;
        }
    }

    /**
     * 更新学生培训班
     * @param $tid
     * @param $uid
     * @param $sysid
     * @return int|string
     */
    public function update($tid, $uid, $sysid)
    {
        $trainingData = Studenttraining::get(['trainingid' => $tid, 'systemid' => $sysid, 'studentid' => $uid]);

        $trainingData->isallowlearning = config('globalConst.STATUS_ON');
        $trainingData->ispayment = config('globalConst.STATUS_ON');

        if ($trainingData->save()) {

            Db::execute("UPDATE lms_studentcourse SET isallowlearning=:isallowlearning,ispayment=:ispayment WHERE trainingid=:trainingid AND systemid=:systemid AND studentid=:studentid",
                ['trainingid' => $tid, 'systemid' => $sysid, 'studentid' => $uid, 'isallowlearning' => config('globalConst.STATUS_ON'), 'ispayment' => config('globalConst.STATUS_ON')]);

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('更新学生培训班： ' . json_encode($trainingData), '更新学生培训班');

            return 0;
        } else {
            return $trainingData->getError();
        }
    }

    /**
     * 获取学生课程列表
     * @param $uid
     * @param $sysid
     */
    public function getCousreList($uid, $sysid)
    {
        $data = Db::name('studentcourse')
            ->alias('sc')
            ->field(' c.CourseName,c.coursehours, sc.courseid,ifnull(sc.loginnum,0) AS loginnum,ifnull(sc.totalstudytime,0) AS totalstudytime,ifnull(sc.isallowlearning,0) AS isallowlearning')
            ->join('course c', 'sc.courseid = c.id  AND sc.systemid = c.systemid', 'LEFT')
            ->join('trainingcourse tc', 'tc.scormid = sc.courseid AND tc.systemid = sc.systemid AND tc.trainingid=sc.trainingid', 'LEFT')
            ->where('sc.systemid', '=', $sysid)
            ->where('sc.studentid', '=', $uid)
            ->select();

        return $data;
    }
}