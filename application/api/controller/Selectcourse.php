<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/22
 * Time: 17:08
 */

namespace app\api\controller;

/**
 * 选课api控制器
 * @package app\api\controller
 */
class Selectcourse extends Authority
{
    /**
     * 检查学生培训班权限
     * @param $uid 学生uuid
     * @return array
     */
    public function checkStudentAuth($uid)
    {
        //获取默认系统信息
        $sysService = controller('api/SystemService', 'Service');
        $system = $sysService->GetDefault();

        $returnPage = '';

        if ($system != null) {
            //培训班逻辑：报名（插入记录），缴费（ispayment=1），学习（isallowlearning=1），终止（超出培训班起止时间）
            //获取学生培训计划列表
            $service = controller('api/StudenttrainingService', 'Service');
            $stuTraining = $service->getTrainingInfo($uid, $system['id']);

            //没有报名任何培训班或者没有可以学习的培训班
            if ($stuTraining['studying'] == 0 && $stuTraining['needPay'] == 0) {
                $returnPage = 'Training/reglist';
            }

            if ($stuTraining['studying'] > 0) {
                $returnPage = 'main';
            }

            //有培训班，但是存在未缴费的
            if ($stuTraining['needPay'] > 0) {
                $returnPage = 'Finance/paylist';
            }
        }

        return Base::setResult('0', '', $returnPage);
    }

    /**
     * 获取指定学生可以报名的培训计划列表
     * @param $uid 学生uuid
     * @return array
     */
    public function getAllowRegTrainingList($uid)
    {
        //获取默认系统信息
        $sysService = controller('api/SystemService', 'Service');
        $system = $sysService->GetDefault();

        $service = controller('api/StudenttrainingService', 'Service');
        $list = $service->getAllowRegTrainingList($uid, $system['id']);

        return $list;
    }

    /**
     * 报名培训计划
     * @return \think\response\Json
     */
    public function signIn()
    {
        if (request()->isPost()) {
            $data = input('post.');

            if ($data == null || $data['uid'] == '' || $data['id'] == '') {
                // 验证失败 输出错误信息
                return json(Base::setResult(-101, '', null));
            }

            //获取默认系统信息
            $sysService = controller('api/SystemService', 'Service');
            $system = $sysService->GetDefault();
            $data['sysid'] = $system['id'];

            $service = controller('api/StudenttrainingService', 'Service');
            $result = $service->signIn($data);

            if ($result == -201) {
                return json(Base::setResult(-201, '', null));
            } else if ($result != 0) {
                return json(Base::setResult(-100, $result, null));
            }

            return json(Base::setResult(0, "", null));
        } else
            return json(Base::setResult(-100, "", null));
    }

    /**
     * 获取指定学生需要交费的培训计划列表
     * @param $uid 学生uuid
     * @return array
     */
    public function getNeedPayTrainingList($uid)
    {
        //获取默认系统信息
        $sysService = controller('api/SystemService', 'Service');
        $system = $sysService->GetDefault();

        $service = controller('api/StudenttrainingService', 'Service');
        $list = $service->getNeedPayTrainingList($uid, $system['id']);

        return $list;
    }
}