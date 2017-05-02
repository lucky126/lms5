<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/2
 * Time: 12:54
 */

namespace app\api\validate;


use think\Validate;

class Rule extends Validate
{
    protected $rule =   [
        'name'  => 'require',
        'title' => 'require|max:50',
    ];

    protected $message  =   [
        'name.require'  => '规则标识不能为空',
        'title.max'     => '规则名称最多不能超过50个字符',
        'title.require' => '规则名称不能为空',
    ];

    protected $scene = [
        'edit'  =>  ['name','age'],
    ];
}