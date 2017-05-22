<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/22
 * Time: 13:06
 */

namespace app\student\service;

/**
 * Class SelectcourseService
 * @package app\api\service
 */
class SelectcourseService extends BaseService
{
    public function getStudentMainPage($uid)
    {
        //获取默认系统信息
        $sysService = controller('api/SystemService', 'Service');
        $system = $sysService->GetDefault();

        //培训班逻辑：报名（插入记录），缴费（ispayment=1），学习（isallowlearning=1），终止（超出培训班起止时间）
        //获取学生培训计划列表
        $stuTrainingService = controller('api/StudenttraningService', 'Service');
        $stuTraining = $stuTrainingService->GetTrainingInfo($uid, $system['id']);

        $returnPage = '';
        //没有报名任何培训班或者没有可以学习的培训班
        if ($stuTraining['studying'] == 0 && $stuTraining['needPay'] == 0) {
            $returnPage = 'Training/RegPayment';
        }

        if ($stuTraining['studying'] > 0) {
            $returnPage = 'main';
        }

        //有培训班，但是存在未缴费的
        if ($stuTraining['needPay'] > 0) {
            $returnPage = 'Finance/Pay';
        }

        return BaseService::getResult('0', '', $returnPage);
    }
}