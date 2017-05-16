<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-16
 * Time: 22:37
 */

namespace app\api\model;

use think\Model;

/**
 * Class System
 * @package app\api\model
 */
class System extends Model
{
    protected $createTime = 'addtime';
    protected $updateTime = false;

    protected $insert = ['status' => 1];
    protected $update = [];

    protected $type = [
        'addtime' => 'datetime',
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

}