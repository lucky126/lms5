<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-08
 * Time: 22:07
 */

namespace app\api\controller;

class Student extends Authority
{
    /**
     * 获取学生课程列表
     * @param $uid 学生uuid
     * @return array
     */
    public function getCourseList($uid)
    {
        //获取默认系统信息
        $sysService = controller('SystemService', 'Service');
        $system = $sysService->GetDefault();

        $service = controller('StudenttrainingService', 'Service');
        $data = $service->getCousreList($uid,$system['id']);

        return $data;
    }
}