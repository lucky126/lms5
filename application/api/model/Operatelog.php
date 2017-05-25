<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/25
 * Time: 10:28
 */

namespace app\api\model;

use think\Model;

/**
 * Class Operatelog
 * @package api\model
 */
class Operatelog extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'operatordate';
    protected $updateTime = false;

    protected $insert = [];
    protected $update = [];

    protected $type = [
        'operatordate' => 'datetime',
        'usertype' => 'integer',
    ];
}