<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/31
 * Time: 16:08
 */

namespace api\validate;

use think\Validate;

/**
 * 激活码验证类
 * @package app\api\validate
 */
class Activatecode extends Validate
{
    protected $rule =   [
        'trainingclass'   => 'require',
        'paymentmoney'  => 'require|number|egt:1',
        'account' => 'require|number|egt:1',
    ];

    protected $message  =   [
        'trainingclass.require'   => '请选择培训班',
        'paymentmoney.require'  => '交费金额不能为空',
        'paymentmoney.number'  => '交费金额必须是数字',
        'paymentmoney.egt'  => '交费金额必须大于1',
        'account.require' => '生成数量不能为空',
        'account.number'  => '交费金额必须是数字',
        'account.egt'  => '交费金额必须大于1',
    ];
}