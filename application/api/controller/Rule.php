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
     * 获取指定父节点下的权限
     *
     * @param $pid 父权限id
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
     * @param  int $id 权限id
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

            //validate
            $result = $this->validate($data,'Rule');

            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(base::getResult(-101, $result, null));
            }

            $userdata = [
                'pid' => $data['pid'],
                'name' => $data['name'],
                'title' => $data['title'],
                'icon' => $data['icon'],
                'isshow' => $isshow,
            ];

            $result = Db::name('AuthRule')->insert($userdata);
            return json(base::getResult(0, "", null));
        }
    }

    /**
     * 保存更新的权限资源
     *
     * @param   $id 权限id
     * @return \think\Response
     */
    public function update($id)
    {
        //
        if (Request::instance()->put()) {
            $data = input('put.');
            //set id
            $data['id'] = $id;
            //set isshow
            $isshow = 0;
            if (input('?isshow')) {
                $isshow = 1;
            }
            //dump($isshow);

            //validate
            $result = $this->validate($data,'Rule.edit');

            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(base::getResult(-101, $result, null));
            }

            $result = Db::name('AuthRule')
                ->where('id', $id)
                ->update(['title' => $data['title'],
                    'name' => $data['name'],
                    'icon' => $data['icon'],
                    'isshow' => $isshow]);

            return json(base::getResult(0, "", null));
        }
    }

    /**
     * 删除指定权限资源
     *
     * @param  uuid $id 权限id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
        Db::name('AuthRule')->where('id', $id)->delete();
        return json(base::getResult(0, "", null));
    }

    /**
     * 验证角色名称唯一性
     *
     * @param $id 角色id
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

            if(input('?post.title'))
                $map['title'] = $data['title'];
            if(input('?post.name'))
                $map['name'] = $data['name'];

            if ($id != 0) {
                $map['id'] = ['neq', $id];
            }
            if (Db::name('AuthRule')->where($map)->find() != null) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }
    }
}