<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/4/24
 * Time: 14:42
 */

namespace app\api\controller;

use think\Request;
use think\Db;

/**
 * 角色api控制器
 * @package app\api\controller
 */
class Group extends base
{
    /**
     * 显示角色资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //get data
        $data = Db::name('AuthGroup')->where("status", "<>", "0")->select();

        //文字转换
        foreach ($data as $k => $v) {
            $data[$k]['isset'] = strlen($v['rules']) == 0 ? '否' : '是';
        }

        return json($data);
    }

    /**
     * 显示指定的角色资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //find data
        $data = Db::name('AuthGroup')->where('id', $id)->find();

        return json($data);
    }

    /**
     * 保存新建的角色资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save()
    {
        //must post
        if (request()->isPost()) {
            $data = input('post.');

            //validate
            $result = $this->validate($data, 'Group');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(base::getResult(-101, $result, null));
            }

            //make data
            $userdata = [
                'title' => $data['title'],
                'rules' => '',
            ];

            //insert
            $result = Db::name('AuthGroup')->insert($userdata);

            return json(base::getResult(0, "", null));
        }
    }

    /**
     * 保存更新的角色资源
     *
     * @param   $id
     * @return \think\Response
     */
    public function update($id)
    {
        //must put
        if (request()->isPut()) {
            $data = input('put.');
            $data['id'] = $id;
            //dump($data);

            //validate
            $result = $this->validate($data, 'Group.edit');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(base::getResult(-101, $result, null));
            }

            //update
            $result = Db::name('AuthGroup')
                ->where('id', $id)
                ->update(['title' => $data['title']]);

            return json(base::getResult(0, "", null));
        }
    }

    /**
     * 删除指定角色资源
     *
     * @param  uuid $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //delete
        Db::name('AuthGroup')->where('id', $id)->delete();
        return json(base::getResult(0, "", null));
    }

    /**
     * 验证角色名称唯一性
     * @param $id
     * @return bool
     */
    public function Unique($id)
    {
        //must post
        if (request()->isPost()) {
            $result = array(
                'valid' => false
            );

            $data = input('post.');
            $map['title'] = $data['title'];
            if ($id != 0) {
                $map['id'] = ['neq', $id];
            }
            if (Db::name('AuthGroup')->where($map)->find() != null) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }
    }

    /**
     * 获得角色权限树
     * @param $id
     * @return \think\response\Json
     */
    public function GetRule($id)
    {
        //get rule list
        $ruleList = DB::name('AuthRule')->field('id,pid,name,title')->select();
        //get group's rule ids
        $groupAccess = Db::name('AuthGroup')->where('id', '=', $id)->find();
        $groupRule = $groupAccess['rules'];

        $data = $this::channelLevel($ruleList, $groupRule, 0);
        return json($data);
    }

    /**
     * 保存角色权限树
     * @param $id
     * @return \think\response\Json
     */
    public function SaveRule($id)
    {
        if (Request::instance()->put()) {
            $data = input('put.');
            $rule = $data['rules'];

            if (stripos(',' . $rule . ',', ',1,') === false) {
                $rule = '1,' . $rule;
            }

            $result = Db::name('AuthGroup')
                ->where('id', $id)
                ->update(['rules' => $rule]);

            return json(base::getResult(0, "", null));
        }
    }

    /**
     * 内部递归获取树的函数
     * @param $data
     * @param $groupRule
     * @param int $pid
     * @return array
     */
    static private function channelLevel($data, $groupRule, $pid = 0)
    {
        if (empty($data)) {
            return array();
        }
        // dump($data);
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