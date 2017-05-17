<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/12
 * Time: 17:02
 */

namespace app\api\service;

use app\api\model\AuthRule;
use think\Db;

/**
 * 权限服务类
 * @package app\api\service
 */
class RuleService extends BaseService
{
    /**
     * 获取指定父节点下的权限
     * @param int $pid 父权限id
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function GetList($pid)
    {
        //get data
        $rule = new AuthRule();

        $data = $rule->where("pid", "=", $pid)
                ->order('id', 'desc')
                ->select();

        return $data;
    }

    /**
     * 获取指定权限数据
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function Get($id)
    {
        $data = AuthRule::get($id)->getData();

        return $data;
    }

    /**
     * 新增权限数据
     * @param $data
     * @return int|string
     */
    public function Insert($data)
    {
        $rule = new AuthRule;
        $rule->pid = $data['pid'];
        $rule->name = $data['name'];
        $rule->title = $data['title'];
        $rule->icon = $data['icon'];
        $rule->isshow = $data['isshow'];

        if ($rule->save()) {
            return 0;
        } else {
            return $rule->getError();
        }

        return $result;
    }

    /**
     * 更新指定权限数据
     * @param $data
     * @return int|string
     */
    public function Update($data)
    {
        //update
        $rule = AuthRule::get($data['id']);
        $rule->name = $data['name'];
        $rule->title = $data['title'];
        $rule->icon = $data['icon'];
        $rule->isshow = $data['isshow'];

        if ($rule->save()) {
            return 0;
        } else {
            return $rule->getError();
        }
    }

    /**
     * 删除指定权限数据
     * @param $id
     * @return int
     */
    public function Delete($id)
    {
        //delete
        $rule = AuthRule::get($id);
        if ($rule->delete()) {
            return 0;
        } else {
            return $rule->getError();
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
        if (input('?post.title'))
            $map['title'] = $data['title'];
        if (input('?post.name'))
            $map['name'] = $data['name'];

        if ($id != 0) {
            $map['id'] = ['neq', $id];
        }

        if (Db::name('AuthRule')->where($map)->find() != null) {
            return false;
        }

        return true;
    }

    /**
     * 设置状态
     * @param $id 权限id
     * @param $status 目标状态值
     * @return int|string
     */
    public function ChangeStatus($id, $status)
    {
        $rule = AuthRule::get($id);
        $rule->status = $status;

        if ($rule->save()) {
            return 0;
        } else {
            return $rule->getError();
        }
    }
}