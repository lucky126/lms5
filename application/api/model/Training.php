<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-18
 * Time: 21:31
 */

namespace app\api\model;

use think\Model;

/**
 * Class Training
 * @package app\api\model
 */
class Training extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'addtime';
    protected $updateTime = 'updatetime';

    protected $readonly = [];

    //protected $auto = ['name', 'ip'];
    protected $insert = ['status' => 1, 'isopen' => 1];
    protected $update = [];

    protected $type = [
        'traingtype' => 'integer',
        'registrationstarttime' => 'datetime',
        'registrationendtime' => 'datetime',
        'starttime' => 'datetime',
        'endtime' => 'datetime',
        'isopen' => 'integer',
        'trainingcost' => 'integer',
        'allownumberofcourses' => 'integer',
        'status' => 'integer',
        'addtime' => 'datetime',
        'updatetime' => 'datetime',
    ];

    protected function base($query)
    {
        $query->where('status', '<>', -1);
    }

    public function courses()
    {
        return $this->hasMany('trainingcourse', 'trainingid', 'id');
    }

    public function getStatusAttr($value)
    {
        return config('globalConst.StatusDesc')[$value];
    }
}