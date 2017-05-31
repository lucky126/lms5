<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-31
 * Time: 22:12
 */

namespace api\model;

use think\Model;

/**
 * Class Paymentlog
 * @package api\model
 */
class Paymentlog extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'paytdate';
    protected $updateTime = false;

    protected $insert = [];
    protected $update = [];

    protected $type = [
        'paytdate' => 'datetime',
        'payobjectid' => 'integer',
        'payobjecttype' => 'integer',
        'paymoney' => 'integer',
        'account' => 'integer',
        'paytype' => 'integer',
        'systemid' => 'integer',
    ];
}