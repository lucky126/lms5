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
        //must post
        if (request()->isPost()) {
            $data = input('post.');

            //validate
            $result = $this->validate($data, 'User');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(base::getResult(-101, $result, null));
            }

            //make user data
            $userdata = [
                'uid' => getGuid(),
                'loginname' => $data['LoginName'],
                'realname' => $data['RealName'],
                'pwd' => getEncPassword($data['Password']),
                'usertype' => $data['UserType'],
                'registiontime' => datetime(),
                'addtime' => datetime(),
                'systemid' => 1,
            ];
            //insert data
            $result = Db::name('user')->insert($userdata);
            //get user id
            $userId = Db::name('user')->getLastInsID();

            //make user group info
            $group = [
                'uid' => $userId,
                'group_id' => $data['UserGroup'],
            ];
            //insert user group info
            $result = Db::name("AuthGroupAccess")->insert($group);

            return json(base::getResult(0, "", null));
        }
    }

    /**
     * 显示指定的用户资源
     *
     * @param  uuid $id
     * @return \think\Response
     */
    public function read($id)
    {
        //get user info
        $data = Db::name('user')->where('uid', $id)->find();
        //get user group info
        $group = Db::name("AuthGroupAccess")->where('uid', $data['id'])->find();
        //set user group info into user info
        $data['usergroup'] = $group == null ? "" : $group['group_id'];
        //return data
        return json($data);
    }

    /**
     * 保存更新的用户资源
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
            $result = $this->validate($data, 'User.edit');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(base::getResult(-101, $result, null));
            }

            //update user info
            $result = Db::name('user')
                ->where('uid', $id)
                ->update(['realname' => $data['RealName'], 'usertype' => $data['UserType']]);
            //get user id
            $user = Db::name('user')->where('uid', $id)->find();
            $user_id = $user['id'];
            //update user group info
            $result = Db::name("AuthGroupAccess")
                ->where('uid', $user_id)
                ->update(['group_id' => $data['UserGroup']]);

            return json(base::getResult(0, "", null));
        }
    }

    /**
     * 删除指定用户资源
     *
     * @param  uuid $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
        Db::name('user')->where('uid', $id)->delete();
        return json(base::getResult(0, "", null));
    }

    /**
     * 验证登录名唯一性
     *
     * @param $id 用户id
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
            $map['loginname'] = $data['LoginName'];
            if ($id != 0) {
                $map['id'] = ['neq', $id];
            }
            if (Db::name('user')->where($map)->find() != null) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }
    }
}
