<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/5
 * Time: 15:49
 */

namespace app\api\validate;

use think\Validate;

/**
 * 培训计划验证类
 * @package app\api\validate
 */
class Training extends Validate
{
    protected $rule = [
        'TrainingName' => 'require|length:2,50|unique:Training',
        'TrainingCode' => 'require|length:2,30|alphaNum|unique:Training',
        'RegistrationTime' => 'require',
        'TrainingTime' => 'require',
        'TrainingCost' => 'require|between:1,999',
        'AllowNumberOfCourses' => 'require|between:0,999',
        'Notice' => 'require',
    ];

    protected $message = [
        'TrainingName.require' => '培训计划名称不能为空',
        'TrainingName.unique' => '培训计划名称已经存在',
        'TrainingName.length' => '培训计划名称长度必须在2到50个字符',
        'TrainingCode.require' => '培训计划编号不能为空',
        'TrainingCode.unique' => '培训计划编号已经存在',
        'TrainingCode.length' => '培训计划编号长度必须在2到30个字符',
        'RegistrationTime.require' => '报名起止时间不能为空',
        'TrainingTime.require' => '培训计划起止时间不能为空',
        'TrainingCost.require' => '培训费不能为空',
        'TrainingCost.between' => '培训费必须介于1和999之间',
        'AllowNumberOfCourses.require' => '允许选课数不能为空',
        'AllowNumberOfCourses.between' => '允许选课数必须介于0和999之间',
        'Notice.require' => '课程地址不能为空',
    ];

    protected $scene = [
        'edit' => [
            'TrainingName' => 'require|length:2,50|unique:Training,TrainingName^id',
            'RegistrationTime','TrainingTime','TrainingCost','AllowNumberOfCourses','Notice'
        ],
    ];
}