<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/12
 * Time: 17:02
 */

namespace app\api\service;

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
        //
        $data = Db::name('AuthRule')->where("status", "<>", "0")->where("pid", "=", $pid)->select();

        //文字转换
        foreach ($data as $k => $v) {
            $data[$k]['isshowdesc'] = config('globalConst.YesOrNoDesc')[$v['isshow']];
        }

        return $data;
    }

    /**
     * 获取指定权限数据
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function Get($id)
    {
        $map['status'] = ['<>', '-1'];
        $map['id'] = ['=', $id];
        $data = Db::name('AuthRule')->where($map)->find();

        return $data;
    }

    /**
     * 新增权限数据
     * @param $data
     * @return int|string
     */
    public function Insert($data)
    {
        $userdata = [
            'pid' => $data['pid'],
            'name' => $data['name'],
            'title' => $data['title'],
            'icon' => $data['icon'],
            'isshow' => $data['isshow'],
            'status' => 1,
        ];

        $result = Db::name('AuthRule')->insert($userdata);

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
        return Db::name('AuthRule')
            ->where('id', $data['id'])
            ->update(['title' => $data['title'],
                'name' => $data['name'],
                'icon' => $data['icon'],
                'isshow' => $data['isshow']]);

    }

    /**
     * 删除指定权限数据
     * @param $id
     * @return int
     */
    public function Delete($id)
    {
        //delete
        return Db::name('AuthRule')->where('id', $id)->delete();
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
}