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
        'title'  => 'require|length:2,20|unique:AuthGroup',
    ];

    protected $message  =   [
        'title.require' => '角色名称不能为空',
        'title.unique' => '角色名称已经存在',
        'title.length'     => '角色名称长度必须在2到20个字符',
    ];

    protected $scene = [
        'edit' => ['title'=>'require|length:2,20|unique:AuthGroup,title^id'],
    ];
}