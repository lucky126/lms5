<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-12
 * Time: 22:41
 */

namespace app\api\service;

use app\api\model\System;
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
        //get data
        $system = new System();

        $data = $system->order('id', 'desc')
            ->select();

        return $data;
    }

    /**
     * 获取指定系统数据
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function Get($id)
    {
        $data = System::get($id)->getData();

        return $data;
    }

    /**
     * 新增系统数据
     * @param $data
     * @return int|string
     */
    public function Insert($data)
    {
        $system = new System;
        $system->systemname = $data['systemname'];
        $system->memo = '';

        if ($system->save()) {
            return 0;
        } else {
            return $system->getError();
        }
    }

    /**
     * 更新指定系统数据
     * @param $data
     * @return int|string
     */
    public function Update($data)
    {
        //update
        $system = System::get($data['id']);
        $system->systemname = $data['systemname'];

        if ($system->save()) {
            return 0;
        } else {
            return $system->getError();
        }
    }

    /**
     * 删除指定系统数据
     * @param $id
     * @return int
     */
    public function Delete($id)
    {
        //delete
        $system = System::get($id);
        if ($system->delete()) {
            return 0;
        } else {
            return $system->getError();
        }
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

    /**
     * 设置状态
     * @param $id 系统id
     * @param $status 目标状态值
     * @return int|string
     */
    public function ChangeStatus($id, $status)
    {
        $system = System::get($id);
        $system->status = $status;

        if ($system->save()) {
            return 0;
        } else {
            return $system->getError();
        }
    }
}