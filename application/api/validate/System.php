<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-03
 * Time: 22:21
 */

namespace app\api\validate;

use think\Validate;

/**
 * 系统验证类
 * @package app\api\validate
 */
class System extends Validate
{
    protected $rule =   [
        'systemname'  => 'require|length:2,50|unique:System',
    ];

    protected $message  =   [
        'systemname.require' => '角色名称不能为空',
        'systemname.unique'  => '角色名称已经存在',
        'systemname.length'  => '角色名称长度必须在2到50个字符',
    ];

    protected $scene = [
        'edit' => ['systemname'=>'require|length:2,20|unique:System,systemname^id'],
    ];
}