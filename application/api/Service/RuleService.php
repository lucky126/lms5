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
    public function getList($pid)
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
    public function get($id)
    {
        $data = AuthRule::get($id);

        if ($data != null) {
            return $data->getData();
        } else {
            return null;
        }
    }

    /**
     * 新增权限数据
     * @param $data
     * @return int|string
     */
    public function insert($data)
    {
        $rule = new AuthRule;
        $rule->pid = $data['pid'];
        $rule->name = $data['name'];
        $rule->title = $data['title'];
        $rule->icon = $data['icon'];
        $rule->isshow = $data['isshow'];

        if ($rule->save()) {

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('新增权限： ' . json_encode($rule), '新增权限');

            return 0;
        } else {
            return $rule->getError();
        }
    }

    /**
     * 更新指定权限数据
     * @param $data
     * @return int|string
     */
    public function update($data)
    {
        //update
        $rule = AuthRule::get($data['id']);
        $rule->name = $data['name'];
        $rule->title = $data['title'];
        $rule->icon = $data['icon'];
        $rule->isshow = $data['isshow'];

        if ($rule->save()) {

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('更新权限： ' . json_encode($rule), '更新权限');

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
    public function delete($id)
    {
        //check sub count
        $subCount = AuthRule::where(['pid' => $id])->count();
        if ($subCount > 0) {
            return -201;
        }
        //delete
        $rule = AuthRule::get($id);
        if ($rule->delete()) {

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('删除权限： ' . json_encode($rule), '删除权限');

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
    public function checkUnique($data, $id)
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
    public function changeStatus($id, $status)
    {
        $rule = AuthRule::get($id);
        $rule->status = $status;

        if ($rule->save()) {
            //单向操作，仅设置为停用时候批量将该id的字节点同步停用
            if ($status == config('globalConst.STATUS_OFF')) {
                $subRule = new AuthRule;
                // save方法第二个参数为更新条件
                $subRule->save([
                    'status' => $status,
                ], ['pid' => $id]);
            }

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $memo = '更新权限ID为 ' . $id . ' 的状态为' . $status;
            $logService->insert($memo, '更新权限状态');

            return 0;
        } else {
            return $rule->getError();
        }
    }
}