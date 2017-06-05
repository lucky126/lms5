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
                return json(Base::setResult(-101, $result, null));
            }

            //获取默认系统信息
            $sysService = controller('api/SystemService', 'Service');
            $system = $sysService->GetDefault();
            $data['systemid'] = $system['id'];

            //insert data
            $userService = controller('StudentService', 'Service');
            $userService->insert($data);

            return json(Base::setResult(0, "", null));
        }
    }

    /**
     * 验证登录名唯一性
     *
     * @param $id
     * @return bool
     */
    public function unique($id)
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