<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/31
 * Time: 16:04
 */

namespace api\model;

use think\Model;

/**
 * Class Activatecode
 * @package api\model
 */
class Activatecode extends Model
{
    //protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'adddate';
    protected $updateTime = false;

    protected $insert = [];
    protected $update = [];

    protected $type = [
        'adddate' => 'datetime',
        'activatedate' => 'datetime',
        'systemid' => 'integer',
    ];
}