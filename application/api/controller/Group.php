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
        //
        $data = Db::name('AuthGroup')->where("status", "<>", "0")->select();

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
        //
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
        //
        if (Request::instance()->post()) {
            $data = input('post.');

            //validate
            $valid = $this->validate(
                [
                    'title' => $data['title'],
                ],
                [
                    'title' => 'require|max:25',
                ]);
            if (true !== $valid) {
                // 验证失败 输出错误信息
                return json(base::getResult(-101, $valid, null));
            }

            $userdata = [
                'title' => $data['title'],
                'rules' => '',
            ];

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
        //
        if (Request::instance()->put()) {
            $data = input('put.');
            //dump($data);

            //validate
            $valid = $this->validate(
                [
                    'title' => $data['title'],
                ],
                [
                    'title' => 'require|max:25',
                ]);
            if (true !== $valid) {
                // 验证失败 输出错误信息
                return json(base::getResult(-101, $valid, null));
            }


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
        //
        Db::name('AuthGroup')->where('id', $id)->delete();
        return json(base::getResult(0, "", null));
    }

    /**
     * @param $id
     * @return \think\response\Json
     */
    public function GetRule($id)
    {
        $rule = DB::name('AuthRule')->field('id,pid,name,title')->select();
        //return json($rule);
        $data = $this::channelLevel($rule);
        return json($data);
    }

    /**
     *
     * @param $data
     * @param int $pid
     * @return array
     */
    static private function channelLevel($data, $pid = 0)
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
                $tmp["nodes"] = self::channelLevel($data, $v["id"]);
                array_push($arr, $tmp);
            }
        }

        return $arr;
    }
}