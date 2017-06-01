<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-06-01
 * Time: 15:23
 */

namespace app\api\model;

use think\Model;

/**
 * Class Activatecodelog
 * @package app\api\model
 */
class Activatecodelog extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'adddate';
    protected $updateTime = false;

    protected $insert = [];
    protected $update = [];

    protected $type = [
        'adddate' => 'datetime',
        'generatenum' => 'integer',
        'objectid' => 'integer',
        'systemid' => 'integer',
        'objecttype' => 'integer',
        'paymentmoney' => 'integer',
        'paymentid' => 'integer',
    ];
}