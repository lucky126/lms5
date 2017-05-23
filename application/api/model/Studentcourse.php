<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/23
 * Time: 17:28
 */

namespace app\api\model;


use think\Model;

class Studentcourse extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'selecttime';
    protected $updateTime = false;

    protected $insert = [];
    protected $update = [];

    protected $type = [
        'selecttime' => 'datetime',
        'trainingid' => 'integer',
        'systemid' => 'integer',
        'courseid' => 'integer',
        'type' => 'integer',
        'ispayment' => 'integer',
        'isallowlearning' => 'integer',
        'loginnum' => 'integer',
        'totalstudytime' => 'integer',
    ];
}