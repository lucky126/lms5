<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-08
 * Time: 22:07
 */

namespace app\api\validate;

use think\Validate;

/**
 * 学生验证类
 * @package app\api\validate
 */
class Student extends Validate
{
    protected $rule =   [
        'loginname'  => 'require|length:2,50|unique:User',
        'realname'   => 'require|length:2,50',
        'pwd'        => 'require|length:6,50|different:loginname',
        'idtype'     => 'require',
        'idcode'     => 'require|length:2,50',
        'tel'        => 'require|length:11',
        'email'      => 'require|email',
    ];

    protected $message  =   [
        'loginname.require'  => '登录名不能为空',
        'loginname.unique'   => '登录名已经存在',
        'loginname.length'   => '登录名长度必须在2到50个字符',
        'realname.require'   => '真实姓名不能为空',
        'realname.length'    => '真实姓名长度必须在2到50个字符',
        'pwd.require'        => '密码不能为空',
        'pwd.length'         => '密码长度必须在2到50个字符',
        'pwd.different'      => '密码不能和登录名相同',
        'idtype.require'     => '证件类型不能为空',
        'idcode.require'     => '证件号码不能为空',
        'idcode.length'      => '证件号码长度必须在2到50个字符',
        'tel.require'        => '手机号码不能为空',
        'tel.length'         => '手机号码长度必须是11个字符',
        'email.require'      => '邮箱地址不能为空',
        'email.email'        => '邮箱地址格式有误',
    ];

    protected $scene = [
        'edit'  =>  ['realname','UserGroup'],
    ];
}