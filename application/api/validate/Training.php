<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/5
 * time: 15:49
 */

namespace app\api\validate;

use think\Validate;

/**
 * 培训计划验证类
 * @package app\api\validate
 */
class training extends Validate
{
    protected $rule = [
        'trainingname' => 'require|length:2,50|unique:training',
        'trainingcode' => 'require|length:2,30|alphaNum|unique:training',
        'registrationtime' => 'require',
        'trainingtime' => 'require',
        'trainingcost' => 'require|between:1,999',
        'allownumberofcourses' => 'require|between:0,999',
        'notice' => 'require',
    ];

    protected $message = [
        'trainingname.require' => '培训计划名称不能为空',
        'trainingname.unique' => '培训计划名称已经存在',
        'trainingname.length' => '培训计划名称长度必须在2到50个字符',
        'trainingcode.require' => '培训计划编号不能为空',
        'trainingcode.unique' => '培训计划编号已经存在',
        'trainingcode.length' => '培训计划编号长度必须在2到30个字符',
        'registrationtime.require' => '报名起止时间不能为空',
        'trainingtime.require' => '培训计划起止时间不能为空',
        'trainingcost.require' => '培训费不能为空',
        'trainingcost.between' => '培训费必须介于1和999之间',
        'allownumberofcourses.require' => '允许选课数不能为空',
        'allownumberofcourses.between' => '允许选课数必须介于0和999之间',
        'notice.require' => '课程地址不能为空',
    ];

    protected $scene = [
        'edit' => [
            'trainingname' => 'require|length:2,50|unique:training,trainingname^id',
            'registrationtime','trainingtime','trainingcost','allownumberofcourses','notice'
        ],
    ];
}