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
    protected $rule =   [
        'coursename'  => 'require|length:2,20|unique:Course',
    ];

    protected $message  =   [
        'coursename.require' => '课程名称不能为空',
        'coursename.unique'  => '课程名称已经存在',
        'coursename.length'  => '课程名称长度必须在2到20个字符',
    ];

    protected $scene = [
        'edit' => ['coursename'=>'require|length:2,20|unique:Course,coursename^id'],
    ];
}