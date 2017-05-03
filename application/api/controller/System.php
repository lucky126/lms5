<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-03
 * Time: 22:11
 */

namespace app\api\controller;

use think\Db;

/**
 * 系统api控制器
 * @package app\api\controller
 */
class System extends base
{
    /**
     * 显示系统资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $data = Db::name('System')->select();

        return json($data);
    }

    /**
     * 显示指定的系统资源
     *
     * @param  int $id 系统id
     * @return \think\Response
     */
    public function read($id)
    {
        //find data
        $data = Db::name('System')->where('id', $id)->find();

        return json($data);
    }

    /**
     * 保存新建的系统资源
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
            $result = $this->validate($data, 'System');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(base::getResult(-101, $result, null));
            }

            //make data
            $userdata = [
                'systemname' => $data['systemname'],
                'memo' => '',
                'addtime' => datetime(),
            ];

            //insert
            $result = Db::name('System')->insert($userdata);

            if ($result <= 0) {
                return json(base::getResult(-100, "", null));
            }

            return json(base::getResult(0, "", null));
        } else
            return json(base::getResult(-100, "", null));
    }

    /**
     * 保存更新的系统资源
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
            $result = $this->validate($data, 'System.edit');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(base::getResult(-101, $result, null));
            }

            //update
            Db::name('System')
                ->where('id', $id)
                ->update(['systemname' => $data['systemname']]);


            return json(base::getResult(0, "", null));
        } else
            return json(base::getResult(-100, "", null));
    }

    /**
     * 删除指定系统资源
     *
     * @param  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //delete
        Db::name('System')->where('id', $id)->delete();
        return json(base::getResult(0, "", null));
    }

    /**
     * 验证系统名称唯一性
     *
     * @param int $id 系统id
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
            $map['systemname'] = $data['systemname'];
            if ($id != 0) {
                $map['id'] = ['neq', $id];
            }
            if (Db::name('System')->where($map)->find() != null) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }

        return json(base::getResult(-100, "", null));
    }
}