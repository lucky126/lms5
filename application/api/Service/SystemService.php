<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-12
 * Time: 22:41
 */

namespace app\api\service;

use think\Db;

/**
 * 系统服务类
 * @package app\api\service
 */

class SystemService extends BaseService
{
    /**
     * 获取系统列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function GetList()
    {
        //
        $data =Db::name('System')->select();

        return $data;
    }

    /**
     * 获取指定系统数据
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function Get($id)
    {
        $map['status'] = ['<>', '-1'];
        $map['id'] = ['=', $id];
        $data =Db::name('System')->where($map)->find();

        return $data;
    }

    /**
     * 新增系统数据
     * @param $data
     * @return int|string
     */
    public function Insert($data)
    {
        //make data
        $userdata = [
            'systemname' => $data['systemname'],
            'memo' => '',
            'addtime' => datetime(),
            'status' => 1,
        ];

        //insert
        $result = Db::name('System')->insert($userdata);

        return $result;
    }

    /**
     * 更新指定系统数据
     * @param $data
     * @return int|string
     */
    public function Update($data)
    {
        //update
        return  Db::name('System')
                ->where('id', $data['id'])
                ->update(['systemname' => $data['systemname']]);
    }

    /**
     * 删除指定系统数据
     * @param $id
     * @return int
     */
    public function Delete($id)
    {
        //delete
        return Db::name('System')->where('id', $id)->delete();
    }

    /**
     * 检查字段是否唯一
     * @param $data
     * @param $id
     * @return bool
     */
    public function CheckUnique($data, $id)
    {
        $map['systemname'] = $data['systemname'];
        if ($id != 0) {
            $map['id'] = ['neq', $id];
        }
        if (Db::name('System')->where($map)->find() != null) {
            return false;
        }

        return true;
    }
}