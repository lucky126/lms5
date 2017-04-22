<?php

namespace app\api\controller;

use think\Request;
use think\Db;

/**
 * 用户api控制器
 * @package app\api\controller
 */
class User extends base
{
    /**
     * 显示用户资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $data = Db::name('user')->where("usertype", "<>", "0")->select();

        //文字转换
        foreach ($data as $k => $v) {
            $data[$k]['UseTypeDesc'] = config('globalConst.UserTypelNameDesc')[$v['usertype']];
        }

        return json($data);
    }

    /**
     * 保存新建的用户资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save()
    {
        //
        if (Request::instance()->post()) {
            $data = input('post.');

            $userdata = [
                'id' => getGuid(),
                'loginname' => $data['LoginName'],
                'realname' => $data['RealName'],
                'pwd' => getEncPassword($data['Password']),
                'usertype' => $data['UserType'],
                'registiontime' => datetime(),
                'addtime' => datetime(),
                'systemid' => 1,
            ];

            $result = Db::name('user')->insert($userdata);
            return json("success");
        }
    }

    /**
     * 显示指定的用户资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
        $data = Db::name('user')->where('id', $id)->find();

        return json($data);
    }

    /**
     * 保存更新的用户资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function update($id)
    {
        //
        if (Request::instance()->put()) {
            $data = input('put.');
            //dump($data);

            $result = Db::name('user')
                ->where('id', $id)
                ->update(['loginname' => $data['LoginName'], 'realname' => $data['RealName'], 'usertype' => $data['UserType']]);

            return json("success");
        }
    }

    /**
     * 删除指定用户资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
        Db::name('user')->delete($id);
        return json("success");
    }
}
