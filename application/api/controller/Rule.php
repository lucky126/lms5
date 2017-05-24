<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-04-22
 * Time: 21:07
 */

namespace app\api\controller;

/**
 * 权限api控制器
 * @package app\api\controller
 */
class Rule extends Authority
{
    /**
     * 显示权限资源列表
     *
     * @return \think\Response
     */
    public function index($pid = 0)
    {
        //
        $service = controller('RuleService', 'Service');
        $data = $service->getList($pid);

        return json($data);
    }

    /**
     * 显示指定的权限资源
     *
     * @param  $id 权限id
     * @return \think\Response
     */
    public function read($id)
    {
        //
        $service = controller('RuleService', 'Service');
        $data = $service->get($id);
        if($data == null)
            return Authority::resourceNotFound();

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
        if (request()->isPost()) {
            $data = input('post.');
            $data['isshow'] = 0;
            if (input('?isshow')) {
                $data['isshow'] = 1;
            }

            //validate
            $result = $this->validate($data, 'Rule');

            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(Base::setResult(-101, $result, null));
            }

            $service = controller('RuleService', 'Service');
            $result = $service->insert($data);

            if ($result != 0) {
                return json(Base::setResult(-100, $result, null));
            }

            return json(Base::setResult(0, "", null));
        }else {
            return json(Base::setResult(-100, "", null));
        }
    }

    /**
     * 保存更新的权限资源
     *
     * @param  $id 权限id
     * @return \think\Response
     */
    public function update($id)
    {
        //
        if (request()->isPut()) {
            $data = input('put.');
            //set id
            $data['id'] = $id;
            //set isshow
            $data['isshow'] = 0;
            if (input('?isshow')) {
                $data['isshow'] = 1;
            }

            //validate
            $result = $this->validate($data, 'Rule.edit');

            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(Base::setResult(-101, $result, null));
            }

            $service = controller('RuleService', 'Service');
            $result = $service->update($data);

            if ($result != 0) {
                return json(Base::setResult(-100, $result, null));
            }

            return json(Base::setResult(0, "", null));
        }else {
            return json(Base::setResult(-100, "", null));
        }
    }

    /**
     * 删除指定权限资源
     *
     * @param  $id 权限id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
        $service = controller('RuleService', 'Service');
        $result = $service->delete($id);

        if($result==-201){
            return json(Base::setResult(-201, "存在子权限", null));
        }

        return json(Base::setResult(0, "", null));
    }

    /**
     * 验证角色名称唯一性
     *
     * @param $id 权限id
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
            $service = controller('RuleService', 'Service');

            if (!$service->checkUnique($data, $id)) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }

        return json(Base::setResult(-100, "", null));
    }

    /**
     * 设置状态
     * @param $id 权限id
     * @param $status 目标状态值
     * @return \think\response\Json
     */
    public function changeStatus($id, $status)
    {
        if (request()->isPut()) {
            $service = controller('RuleService', 'Service');

            $result = $service->changeStatus($id, $status);

            if ($result != 0) {
                return json(Base::setResult(-100, $result, null));
            }

            return json(Base::setResult(0, "", null));
        }

        return json(Base::setResult(-100, "", null));
    }
}