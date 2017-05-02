<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/2
 * Time: 12:54
 */

namespace app\api\validate;

use think\Validate;

/**
 * 权限验证类
 * @package app\api\validate
 */
class Rule extends Validate
{
    protected $rule =   [
        'pid'   => 'require',
        'name'  => 'require|unique:AuthRule',
        'title' => 'require|length:2,50|unique:AuthRule',
    ];

    protected $message  =   [
        'pid.require'   => 'pid不能为空',
        'name.require'  => '规则标识不能为空',
        'name.unique'   => '规则标识已经存在',
        'title.max'     => '规则名称长度必须在2到50个字符',
        'title.require' => '规则名称不能为空',
        'title.unique'  => '规则名称已经存在',
    ];

    protected $scene = [
        'edit'  =>  ['name'=> 'require|unique:AuthRule,name^id','title'=>'require|length:2,50|unique:AuthRule,title^id'],
    ];
}