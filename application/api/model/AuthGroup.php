<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/17
 * Time: 10:47
 */

namespace app\api\model;

use think\Model;

/**
 * Class AuthGroup
 * @package app\api\model
 */
class AuthGroup extends Model
{
    //protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    protected $createTime = false;
    protected $updateTime = false;

    protected $insert = ['status' => 1];
    protected $update = [];

    protected $type = [
        'status' => 'integer',
    ];

    protected function base($query)
    {
        $query->where('status', '<>', -1);
    }

    public function users()
    {
        return $this->hasMany('AuthGroupAccess', 'group_id', 'id');
    }

    public function getStatusAttr($value)
    {
        return config('globalConst.StatusDesc')[$value];
    }

    /*public function getIssetAttr($data)
    {
        return strlen($data['rules']) == 0 ? '否' : '是';
    }*/
}