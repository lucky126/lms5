<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/2
 * Time: 12:54
 */

namespace app\api\validate;


use think\Validate;
use think\Db;

class Group extends Validate
{
    protected $rule =   [
        'title'  => 'require|max:20|checkName',
    ];

    protected $message  =   [
        'title.require' => '角色名称不能为空',
        'title.max'     => '角色名称最多不能超过20个字符',
    ];

    // 自定义验证规则
    protected function checkName($value,$rule,$data)
    {
        $data = Db::name('AuthGroup')->where('title', $value)->find();

        return $data == null ? true : '角色名称已经存在';
    }
}