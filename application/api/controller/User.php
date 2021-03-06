<?php

namespace app\api\controller;

/**
 * 用户api控制器
 * @package app\api\controller
 */
class User extends Authority
{
    /**
     * 显示用户资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $service = controller('UserService', 'Service');
        $data = $service->getList(true);

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
                return json(Base::setResult(-101, $result, null));
            }

            //获取默认系统信息
            $sysService = controller('api/SystemService', 'Service');
            $system = $sysService->GetDefault();
            $data['systemid'] = $system['id'];

            //call user service
            $service = controller('UserService', 'Service');
            $result = $service->insert($data, true);

            if ($result['code'] != 0) {
                return json(Base::setResult($result['code'], $result['msg'], null));
            }

            return json(Base::setResult(0, "", null));
        } else
            return json(Base::setResult(-100, "", null));
    }

    /**
     * 显示指定的用户资源
     *
     * @param  string $id 用户uid
     * @return \think\Response
     */
    public function read($id)
    {
        //call user service
        $service = controller('UserService', 'Service');
        $data = $service->get($id);
        if ($data == null)
            return Authority::resourceNotFound();

        //return data
        return json($data);
    }

    /**
     * 保存更新的用户资源
     *
     * @param  string $id 用户uid
     * @return \think\Response
     */
    public function update($id)
    {
        //must put
        if (request()->isPut()) {
            $data = input('put.');
            $data['uid'] = $id;

            //validate
            $result = $this->validate($data, 'User.edit');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(Base::setResult(-101, $result, null));
            }

            //call user service
            $service = controller('UserService', 'Service');
            $result = $service->update($data);

            if ($result != 0) {
                return json(Base::setResult(-100, $result, null));
            }


            return json(Base::setResult(0, "", null));
        } else
            return json(Base::setResult(-100, "", null));
    }

    /**
     * 删除指定用户资源
     *
     * @param  string $id 用户uid
     * @return \think\Response
     */
    public function delete($id)
    {
        //call user service
        $service = controller('UserService', 'Service');
        $service->delete($id);

        return json(Base::setResult(0, "", null));
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

            //call user service
            $service = controller('UserService', 'Service');

            if (!$service->checkUnique($data)) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }
    }

    /**
     * 设置状态
     * @param $id 用户id
     * @param $status 目标状态值
     * @return \think\response\Json
     */
    public function changeStatus($id, $status)
    {
        if (request()->isPut()) {
            $service = controller('UserService', 'Service');

            $result = $service->changeStatus($id, $status);

            if ($result != 0) {
                return json(Base::setResult(-100, $result, null));
            }

            return json(Base::setResult(0, "", null));
        }

        return json(Base::setResult(-100, "", null));
    }
}
