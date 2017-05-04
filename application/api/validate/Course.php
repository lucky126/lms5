<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-03
 * Time: 23:11
 */

namespace app\api\validate;

use think\Validate;

/**
 * 课程验证类
 * @package app\api\validate
 */
class Course extends Validate
{
    protected $rule = [
        'coursename' => 'require|length:2,50|unique:Course',
        'coursecode' => 'require|length:2,30|alphaNum|unique:Course',
        'coursehours' => 'require|between:1,999',
        'coursefee' => 'require|between:1,999',
        'courseurl' => 'require|length:2,500',
    ];

    protected $message = [
        'coursename.require' => '课程名称不能为空',
        'coursename.unique' => '课程名称已经存在',
        'coursename.length' => '课程名称长度必须在2到50个字符',
        'coursecode.require' => '课程代码不能为空',
        'coursecode.unique' => '课程代码已经存在',
        'coursecode.length' => '课程代码长度必须在2到30个字符',
        'coursehours.require' => '课程学时不能为空',
        'coursehours.between' => '课程学时必须介于1和999之间',
        'coursefee.require' => '课程学费不能为空',
        'coursefee.between' => '课程学费必须介于1和999之间',
        'courseurl.require' => '课程地址不能为空',
        'courseurl.length' => '课程地址长度必须在2到500个字符',
    ];

    protected $scene = [
        'edit' => [
            'coursename' => 'require|length:2,50|unique:Course,coursename^id',
            'coursehours','coursefee','courseurl'
        ],
    ];
}