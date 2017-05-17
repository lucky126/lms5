<?php

namespace app\api\model;

use think\Model;

/**
 * Class User
 * @package app\api\model
 */
class User extends Model
{
    protected $createTime = 'addtime';
    protected $updateTime = false;

    protected $insert = ['status' => 1];
    protected $update = [];

    protected $type = [
        'id' => 'integer',
        'systemid' => 'integer',
        'usertype' => 'integer',
        'registiontime' => 'datetime',
        'logincount' => 'integer',
        'lastlogintime' => 'datetime',
        'currentlogintime' => 'datetime',
        'istestuser' => 'integer',
        'addtime' => 'datetime',
        'status' => 'integer',
    ];

    protected function base($query)
    {
        $query->where('status', '<>', -1);
    }

    public function group()
    {
        return $this->hasOne('AuthGroupAccess', 'uid', 'id');
    }

    public function getStatusAttr($value)
    {
        return config('globalConst.StatusDesc')[$value];
    }

    public function getUsertypeAttr($value)
    {
        return config('globalConst.UserTypelNameDesc')[$value];
    }
}
