<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-11
 * Time: 22:24
 */

namespace app\api\service;

use app\api\model\AuthGroup;
use app\api\model\AuthGroupAccess;
use think\Db;

/**
 * 角色服务类
 * @package app\api\service
 */
class GroupService extends BaseService
{
    /**
     * 获取角色列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getList()
    {
        //get data
        $group = new AuthGroup();

        $data = $group->order('id', 'desc')
            ->select();

        //get user group relation
        $userGroup = Db::name('AuthGroupAccess')
            ->field('group_id,count(uid) AS cnt')
            ->group('group_id')
            ->select();

        //文字转换
        foreach ($data as $row) {
            $row->isset = strlen($row->rules) == 0 ? '否' : '是';
            $row->hasUse = 0;
            foreach ($userGroup as $ku => $vu) {
                if ($userGroup[$ku]['group_id'] == $row->id) {
                    $row->hasUse = $vu['cnt'];
                }
            }
            $row->hasUseDesc = $row->hasUse == 0 ? '否' : '是';
        }

        return $data;
    }

    /**
     * 获取指定角色数据
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function get($id)
    {
        $data = AuthGroup::get($id)->getData();

        return $data;
    }

    /**
     * 新增角色数据
     * @param $data
     * @return int|string
     */
    public function insert($data)
    {
        //make data
        $group = new AuthGroup;
        $group->title = $data['title'];
        $group->rules = '';

        if ($group->save()) {
            return 0;
        } else {
            return $group->getError();
        }
    }

    /**
     * 更新指定角色数据
     * @param $data
     * @return int|string
     */
    public function update($data)
    {
        //update
        $group = AuthGroup::get($data['id']);
        $group->title = $data['title'];

        if ($group->save()) {
            return 0;
        } else {
            return $group->getError();
        }
    }

    /**
     * 删除指定角色数据
     * @param $id
     * @return int -201表示存在关联数据无法删除
     */
    public function delete($id)
    {
        //get user group relation
        $userCount = AuthGroupAccess::where(['group_id' => $id])->count();
        if ($userCount > 0) {
            return -201;
        }

        //delete
        $group = AuthGroup::get($id);
        if ($group->delete()) {
            return 0;
        } else {
            return $group->getError();
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
        $map['title'] = $data['title'];
        if ($id != 0) {
            $map['id'] = ['neq', $id];
        }
        if (Db::name('AuthGroup')->where($map)->find() != null) {
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
    public function changeStatus($id, $status)
    {
        $group = AuthGroup::get($id);
        $group->status = $status;

        if ($group->save()) {
            return 0;
        } else {
            return $group->getError();
        }
    }

    /**
     * 获得角色权限树
     * @param $id 角色id
     * @return array
     */
    public function getRule($id)
    {
        //get rule list
        $ruleList = DB::name('AuthRule')->field('id,pid,name,title,isshow')->select();
        //get group's rule ids
        $groupAccess = Db::name('AuthGroup')->where('id', '=', $id)->find();
        $groupRule = $groupAccess['rules'];

        $data = $this::channelLevel($ruleList, $groupRule, 0);
        return $data;
    }

    /**
     * 保存角色权限树
     * @param $id
     * @param $rule
     * @return int|string
     */
    public function saveRule($id, $rule)
    {
        if (stripos(',' . $rule . ',', ',1,') === false) {
            $rule = '1,' . $rule;
        }

        $group = AuthGroup::get($id);
        $group->rules = $rule;

        if ($group->save()) {
            return 0;
        } else {
            return $group->getError();
        }
    }

    /**
     * 内部递归获取树的函数
     * @param $data 列表数据
     * @param $groupRule 角色权限列表
     * @param $pid 父权限id
     * @return array
     */
    static private function channelLevel($data, $groupRule, $pid = 0)
    {
        if (empty($data)) {
            return array();
        }

        $arr = array();
        foreach ($data as $v) {
            if ($v["pid"] == $pid) {
                $tmp["text"] = $v["title"];
                $tmp["id"] = $v["id"];
                $tmp['state']["checked"] = false;
                if($v['isshow'] == config('globalConst.STATUS_ON'))
                    $tmp['icon'] = 'glyphicon glyphicon-bookmark';
                else
                    $tmp['icon'] = '';

                if (stripos(',' . $groupRule . ',', ',' . $v["id"] . ',') !== false) {
                    $tmp['state']["checked"] = true;
                }
                $tmp["nodes"] = self::channelLevel($data, $groupRule, $v["id"]);
                array_push($arr, $tmp);
            }
        }

        return $arr;
    }
}