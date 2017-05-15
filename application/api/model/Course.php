<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/15
 * Time: 16:16
 */

namespace app\api\model;


use think\Model;

class Course extends Model
{
    protected $createTime = 'addtime';
    protected $updateTime = false;

    protected $readonly = ['coursecode'];

    //protected $auto = ['name', 'ip'];
    protected $insert = ['status' => 1 ,'isrecommand' => 0];
    protected $update = [];

    protected $type = [
        'systemid' => 'integer',
        'typeid' => 'integer',
        'coursehours' => 'integer',
        'coursefee' => 'float',
        'isscormcourse' => 'integer',
        'isopenselection' => 'integer',
        'isrecommand' => 'integer',
        'addtime' => 'datetime',
        'status' => 'integer',
    ];

    public function setting()
    {
        return $this->hasOne('Coursesetting','id','id');
    }

    public function getIsscormcourseAttr($value)
    {
        return config('globalConst.YesOrNoDesc')[$value];
    }

    public function getIsopenselectionAttr($value)
    {
        return config('globalConst.YesOrNoDesc')[$value];
    }
}