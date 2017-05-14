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
class System extends Authority
{
    /**
     * 显示系统资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $service = controller('SystemService', 'Service');
        $data = $service->GetList();

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
        $service = controller('SystemService', 'Service');
        $data = $service->Get($id);
        if($data == null)
            return Authority::ResourceNotFound();

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
                return json(Base::getResult(-101, $result, null));
            }

            $service = controller('SystemService', 'Service');
            $result = $service->Insert($data);

            if ($result <= 0) {
                return json(Base::getResult(-100, "", null));
            }

            return json(Base::getResult(0, "", null));
        } else
            return json(Base::getResult(-100, "", null));
    }

    /**
     * 保存更新的系统资源
     *
     * @param   int $id 系统id
     * @return \think\Response
     */
    public function update($id)
    {
        //must put
        if (request()->isPut()) {
            $data = input('put.');
            $data['id'] = $id;

            //validate
            $result = $this->validate($data, 'System.edit');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(Base::getResult(-101, $result, null));
            }

            $service = controller('SystemService', 'Service');
            $result = $service->Update($data);

            return json(Base::getResult(0, "", null));
        } else
            return json(Base::getResult(-100, "", null));
    }

    /**
     * 删除指定系统资源
     *
     * @param  int $id 系统id
     * @return \think\Response
     */
    public function delete($id)
    {
        //delete
        $service = controller('SystemService', 'Service');
        $result = $service->Delete($id);

        return json(Base::getResult(0, "", null));
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
            //call user service
            $service = controller('SystemService', 'Service');

            if (!$service->CheckUnique($data, $id)) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }

        return json(Base::getResult(-100, "", null));
    }
}