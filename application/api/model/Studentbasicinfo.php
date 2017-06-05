<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/6/5
 * Time: 11:41
 */

namespace app\api\model;

use think\Model;

/**
 * Class Studentbasicinfo
 * @package api\model
 */
class Studentbasicinfo extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'addtime';
    protected $updateTime = false;

    protected $insert = ['status' => 1];
    protected $update = [];

    protected $type = [
        'addtime' => 'datetime',
        'status' => 'integer',
        'systemid' => 'integer',
        'id' => 'integer',
        'idtype' => 'integer',
    ];

    protected function base($query)
    {
        $query->where('status', '<>', -1);
    }
}