<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/15
 * Time: 16:23
 */

namespace app\api\model;


use think\Model;

class Coursesetting extends Model
{
    protected $type = [
        'isbulletin' => 'integer',
        'isresource' => 'integer',
        'isqa' => 'integer',
        'isevaluator' => 'integer',
        'istest' => 'integer',
        'ishomework' => 'integer',
    ];
}