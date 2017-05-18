<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/17
 * Time: 13:29
 */

namespace app\api\model;

use think\Model;

/**
 * Class AuthRule
 * @package app\api\model
 */
class AuthRule extends Model
{
    //protected $resultSetType = 'collection';
    protected $createTime = false;
    protected $updateTime = false;

    protected $insert = ['status' => 1];
    protected $update = [];

    protected $type = [
        'id' => 'integer',
        'pid' => 'integer',
        'type' => 'integer',
        'isshow' => 'integer',
        'status' => 'integer',
    ];

    protected function base($query)
    {
        $query->where('status', '<>', -1);
    }

    public function getStatusAttr($value)
    {
        return config('globalConst.StatusDesc')[$value];
    }

    public function getIsshowAttr($value)
    {
        return config('globalConst.YesOrNoDesc')[$value];
    }

}