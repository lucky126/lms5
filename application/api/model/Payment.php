<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-31
 * Time: 21:55
 */

namespace app\api\model;

use think\Model;

/**
 * Class Payment
 * @package app\api\model
 */
class Payment extends Model
{
    //protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'paydate';
    protected $updateTime = false;

    protected $insert = [];
    protected $update = [];

    protected $type = [
        'paydate' => 'datetime',
        'payobjectid' => 'integer',
        'payobjecttype' => 'integer',
        'paymoney' => 'integer',
        'account' => 'integer',
        'paytype' => 'integer',
        'systemid' => 'integer',
    ];
}