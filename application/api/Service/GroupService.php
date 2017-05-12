<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-11
 * Time: 22:24
 */

namespace app\api\service;

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
    public function GetList()
    {
        //get data
        $map['status'] = ['<>', '-1'];
        $data = Db::name('AuthGroup')->where($map)->select();

        //get user group relation
        $userGroup = Db::name('AuthGroupAccess')
            ->field('group_id,count(uid) AS cnt')
            ->group('group_id')
            ->select();

        //文字转换
        foreach ($data as $k => $v) {
            $data[$k]['isset'] = strlen($v['rules']) == 0 ? '否' : '是';
            $data[$k]['hasUse'] = 0;
            foreach ($userGroup as $ku => $vu) {
                if ($userGroup[$ku]['group_id'] == $v['id']) {
                    $data[$k]['hasUse'] = $vu['cnt'];
                }
            }
            $data[$k]['hasUseDesc'] = $data[$k]['hasUse'] == 0 ? '否' : '是';
        }

        return $data;
    }

    /**
     * 获取指定角色数据
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function Get($id)
    {
        $map['status'] = ['<>', '-1'];
        $map['id'] = ['=', $id];
        $data = Db::name('AuthGroup')->where($map)->find();

        return $data;
    }

    /**
     * 新增角色数据
     * @param $data
     * @return int|string
     */
    public function Insert($data)
    {
        //make data
        $userdata = [
            'title' => $data['title'],
            'rules' => '',
            'status' => 1,
        ];

        //insert
        $result = Db::name('AuthGroup')->insert($userdata);

        return $result;
    }

    /**
     * 更新指定角色数据
     * @param $data
     * @return int|string
     */
    public function Update($data)
    {
        //update
        return Db::name('AuthGroup')
            ->where('id', $data['id'])
            ->update(['title' => $data['title']]);
    }

    /**
     * 删除指定角色数据
     * @param $id
     * @return int -201表示存在关联数据无法删除
     */
    public function Delete($id)
    {
        //get user group relation
        $userGroup = Db::name('AuthGroupAccess')->where('group_id', $id)->select();
        if (count($userGroup) > 0) {
            return -201;
        }
        //delete
        return Db::name('AuthGroup')->where('id', $id)->delete();
    }

    /**
     * 检查字段是否唯一
     * @param $data
     * @param $id
     * @return bool
     */
    public function CheckUnique($data, $id)
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
     * 获得角色权限树
     * @param $id 角色id
     * @return array
     */
    public function GetRule($id)
    {
        //get rule list
        $ruleList = DB::name('AuthRule')->field('id,pid,name,title')->select();
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
    public function SaveRule($id, $rule)
    {
        if (stripos(',' . $rule . ',', ',1,') === false) {
            $rule = '1,' . $rule;
        }

        return Db::name('AuthGroup')
            ->where('id', $id)
            ->update(['rules' => $rule]);
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