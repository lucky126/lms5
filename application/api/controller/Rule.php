<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-04-22
 * Time: 21:07
 */

namespace app\api\controller;

use think\Request;
use think\Db;

/**
 * 权限api控制器
 * @package app\api\controller
 */
class Rule extends base
{
    /**
     * 显示权限资源列表
     *
     * @return \think\Response
     */
    public function index($pid = 0)
    {
        //
        $data = $this->getRule($pid);

        return json($data);
    }

    /**
     * @param $pid
     * @return false|\PDOStatement|string|\think\Collection
     */
    private function getRule($pid)
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
     * 显示指定的权限资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
        $data = Db::name('AuthRule')->where('id', $id)->find();

        return json($data);
    }

    /**
     * 保存新建的权限资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save()
    {
        //
        if (Request::instance()->post()) {
            $data = input('post.');
            $isshow = 0;
            if (input('?isshow')) {
                $isshow = 1;
            }

            $userdata = [
                'pid' => $data['pid'],
                'name' => $data['name'],
                'title' => $data['title'],
                'icon' => $data['icon'],
                'isshow' => $isshow,
            ];

            $result = Db::name('AuthRule')->insert($userdata);
            return json("success");
        }
    }

    /**
     * 保存更新的权限资源
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
            $isshow = 0;
            if (input('?isshow')) {
                $isshow = 1;
            }
            //dump($isshow);

            $result = Db::name('AuthRule')
                ->where('id', $id)
                ->update(['title' => $data['title'],
                    'name' => $data['name'],
                    'icon' => $data['icon'],
                    'isshow' => $isshow]);
            //echo Db::getLastSql();
            return json("success");
        }
    }

    /**
     * 删除指定权限资源
     *
     * @param  uuid $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
        Db::name('AuthRule')->where('id', $id)->delete();
        return json("success");
    }
}