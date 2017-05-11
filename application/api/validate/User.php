<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-03
 * Time: 0:02
 */

namespace app\api\validate;

use think\Validate;

/**
 * 用户验证类
 * @package app\api\validate
 */
class User extends Validate
{
    protected $rule =   [
        'loginname'  => 'require|length:2,50|unique:User',
        'RealName'   => 'require|length:2,50',
        'Password'   => 'require',
        'UserGroup'  => 'require',
        'UserType'   => 'require',
    ];

    protected $message  =   [
        'loginname.require'  => '登录名不能为空',
        'loginname.unique'   => '登录名已经存在',
        'loginname.length'   => '登录名长度必须在2到50个字符',
        'RealName.require'   => '真实姓名不能为空',
        'RealName.length'    => '真实姓名长度必须在2到50个字符',
        'Password.require'   => '密码不能为空',
        'UserGroup.require'  => '用户角色不能为空',
        'UserType.require'   => '用户类型不能为空',
    ];

    protected $scene = [
        'edit'  =>  ['realname','UserGroup'],
    ];
}