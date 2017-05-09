<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-08
 * Time: 22:07
 */

namespace app\api\controller;

use think\Db;

/**
 * 学生注册api控制器
 * @package app\api\controller
 */
class Register extends Base
{
    /**
     * 保存新建的学生资源
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
            $result = $this->validate($data, 'Student');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(Base::getResult(-101, $result, null));
            }

            //make user data
            $uid = getGuid();
            $userdata = [
                'uid' => $uid,
                'loginname' => $data['loginname'],
                'realname' => $data['realname'],
                'pwd' => getEncPassword($data['pwd']),
                'usertype' => 3,
                'registiontime' => datetime(),
                'addtime' => datetime(),
                'systemid' => 1,
                'status' => 1,
            ];
            //insert data
            $result = Db::name('user')->insert($userdata);
            //get user id
            $userId = Db::name('user')->getLastInsID();

            //make student data
            $student = [
                'uid' => $uid,
                'userid' => $userId,
                'name' => $data['realname'],
                'gender' => $data['gender'],
                'photo' => '',
                'tel' => $data['tel'],
                'email' => $data['email'],
                'idtype' => $data['idtype'],
                'idcode' => $data['idcode'],
                'addtime' => datetime(),
                'systemid' => 1,
                'status' => 1,
            ];

            $result = Db::name("studentbasicinfo")->insert($student);

            return json(Base::getResult(0, "", null));
        }
    }

    /**
     * 验证登录名唯一性
     *
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
            $map['loginname'] = $data['loginname'];

            if (Db::name('user')->where($map)->find() != null) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }
    }
}