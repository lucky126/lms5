<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/6/5
 * Time: 11:37
 */

namespace app\api\Service;

use app\api\model\Studentbasicinfo;

/**
 * 学生服务类
 * @package app\api\service
 */
class StudentService extends BaseService
{
    /**
     * 新增学生数据
     * @param $data
     * @return int|string
     */
    public function insert($data)
    {
        //make user data
        $userData['loginname'] = $data['loginname'];
        $userData['RealName'] = $data['realname'];
        $userData['Password'] = $data['pwd'];
        $userData['UserType'] = 3;
        $userData['systemid'] = $data['systemid'];
        //insert data
        $userService = controller('UserService', 'Service');
        $uid = $userService->insert($userData, false);

        //make student data
        $student = new Studentbasicinfo;
        $student->studentid = $uid['data'];
        $student->name = $data['realname'];
        $student->gender = $data['gender'];
        $student->photo = '';
        $student->tel = $data['tel'];
        $student->email = $data['email'];
        $student->idtype = $data['idtype'];
        $student->idcode = $data['idcode'];
        $student->systemid = $data['systemid'];

        if ($student->save()) {

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('新增学生： ' . json_encode($student), '新增学生');

            return BaseService::setResult('0', '', '');
        } else {
            return BaseService::setResult('-100', $student->getError(), '');
        }
    }
}