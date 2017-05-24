<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/4/24
 * Time: 14:42
 */

namespace app\api\controller;

use think\Request;

/**
 * 角色api控制器
 * @package app\api\controller
 */
class Group extends Authority
{
    /**
     * 显示角色资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $service = controller('GroupService', 'Service');
        $data = $service->getList();

        return json($data);
    }

    /**
     * 显示指定的角色资源
     *
     * @param  $id 角色id
     * @return \think\Response
     */
    public function read($id)
    {
        $service = controller('GroupService', 'Service');
        $data = $service->get($id);
        if($data == null)
            return Authority::resourceNotFound();

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
                return json(Base::setResult(-101, $result, null));
            }

            $service = controller('GroupService', 'Service');
            $result = $service->insert($data);

            if ($result != 0) {
                return json(Base::setResult(-100, $result, null));
            }

            return json(Base::setResult(0, "", null));
        } else {
            return json(Base::setResult(-100, "", null));
        }
    }

    /**
     * 保存更新的角色资源
     *
     * @param  $id 角色id
     * @return \think\Response
     */
    public function update($id)
    {
        //must put
        if (request()->isPut()) {
            $data = input('put.');
            $data['id'] = $id;

            //validate
            $result = $this->validate($data, 'Group.edit');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(Base::setResult(-101, $result, null));
            }

            $service = controller('GroupService', 'Service');
            $result = $service->update($data);

            if ($result != 0) {
                return json(Base::setResult(-100, $result, null));
            }

            return json(Base::setResult(0, "", null));
        } else {
            return json(Base::setResult(-100, "", null));
        }
    }

    /**
     * 删除指定角色资源
     *
     * @param  $id 角色id
     * @return \think\Response
     */
    public function delete($id)
    {
        $service = controller('GroupService', 'Service');
        $result = $service->delete($id);

        if ($result < 0) {
            return json(Base::setResult(-201, "存在关联用户", null));
        }

        return json(Base::setResult(0, "", null));
    }

    /**
     * 验证角色名称唯一性
     *
     * @param $id 角色id
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
            $service = controller('GroupService', 'Service');

            if (!$service->checkUnique($data, $id)) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }

        return json(Base::setResult(-100, "", null));
    }

    /**
     * 获得角色权限树
     *
     * @param $id 角色id
     * @return \think\response\Json
     */
    public function getRule($id)
    {
        $service = controller('GroupService', 'Service');
        $data = $service->getRule($id);

        return json($data);
    }

    /**
     * 保存角色权限树
     *
     * @param $id 角色id
     * @return \think\response\Json
     */
    public function saveRule($id)
    {
        if (Request::instance()->put()) {
            $data = input('put.');
            $rule = $data['rules'];

            $service = controller('GroupService', 'Service');
            $result = $service->saveRule($id,$rule);

            if ($result < 0) {
                return json(Base::setResult(-100, "", null));
            }

            return json(Base::setResult(0, "", null));
        } else
            return json(Base::setResult(-100, "", null));
    }

    /**
     * 设置状态
     * @param $id 角色id
     * @param $status 目标状态值
     * @return \think\response\Json
     */
    public function changeStatus($id, $status)
    {
        if (request()->isPut()) {
            $service = controller('GroupService', 'Service');

            $result = $service->changeStatus($id, $status);

            if ($result != 0) {
                return json(Base::setResult(-100, $result, null));
            }

            return json(Base::setResult(0, "", null));
        }

        return json(Base::setResult(-100, "", null));
    }
}