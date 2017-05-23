<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/23
 * Time: 17:12
 */

namespace app\api\model;

use think\Model;

/**
 * Class Studenttraining
 * @package app\api\model
 */
class Studenttraining extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'signintime';
    protected $updateTime = false;

    protected $insert = [];
    protected $update = [];

    protected $type = [
        'signintime' => 'datetime',
        'trainingid' => 'integer',
        'systemid' => 'integer',
        'ispayment' => 'integer',
        'isallowlearning' => 'integer',
        'isclosed' => 'integer',
        'isgetcertificate' => 'integer',
        'loginnum' => 'integer',
        'totalstudytime' => 'integer',
    ];
}