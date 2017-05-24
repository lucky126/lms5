<?php
/**
 * Created by Phpstorm.
 * User: lucky
 * Date: 2017/4/26
 * time: 16:13
 */

namespace app\api\controller;

use think\Request;
use think\Db;

/**
 * 培训班api控制器
 * @package app\api\controller
 */
class training extends Authority
{
    /**
     * 显示培训班资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $service = controller('TrainingService', 'Service');
        $data = $service->getList();

        return json($data);
    }

    /**
     * 保存新建的培训班资源
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
            $result = $this->validate($data, 'training');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(base::getresult(-101, $result, null));
            }

            $service = controller('TrainingService', 'Service');
            $result = $service->insert($data);

            if ($result != 0) {
                return json(Base::setResult(-100, $result, null));
            }

            return json(base::getresult(0, "", null));
        } else
            return json(Base::setResult(-100, "", null));
    }

    /**
     * 显示指定的培训班资源
     *
     * @param  $id 培训班id
     * @return \think\Response
     */
    public function read($id)
    {
        //find data
        $service = controller('TrainingService', 'Service');
        $data = $service->get($id);
        if ($data == null || $data['courses'] == null)
            return Authority::resourceNotFound();

        //return data
        return json($data);
    }

    /**
     * 显示指定的培训班课程资源
     *
     * @param  $id 培训班id
     * @return \think\Response
     */
    public function courses($id)
    {
        //find data
        $service = controller('TrainingService', 'Service');
        $data = $service->GetCourses($id);
        if ($data == null)
            return Authority::resourceNotFound();

        //return data
        return json($data);
    }

    /**
     * 保存更新的培训班资源
     *
     * @param $id 培训班id
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
            $result = $this->validate($data, 'training.edit');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(base::getresult(-101, $result, null));
            }

            $service = controller('TrainingService', 'Service');
            $result = $service->update($data);

            if ($result != 0) {
                return json(Base::setResult(-100, $result, null));
            }

            return json(Base::setResult(0, "", null));
        } else
            return json(Base::setResult(-100, "", null));
    }

    /**
     * 删除指定培训班资源
     *
     * @param  $id 培训班id
     * @return \think\Response
     */
    public function delete($id)
    {
        //delete
        $service = controller('TrainingService', 'Service');
        $result = $service->delete($id);

        return json(base::getresult(0, "", null));
    }

    /**
     * 验证唯一性
     *
     * @param $id 培训班id
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

            $service = controller('TrainingService', 'Service');

            if (!$service->checkUnique($data, $id)) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }
    }

    /**
     * 设置状态
     * @param $id 培训班id
     * @param $status 目标状态值
     * @return \think\response\Json
     */
    public function changeStatus($id, $status)
    {
        if (request()->isPut()) {
            $service = controller('TrainingService', 'Service');

            $result = $service->changeStatus($id, $status);

            if ($result != 0) {
                return json(Base::setResult(-100, $result, null));
            }

            return json(Base::setResult(0, "", null));
        }

        return json(Base::setResult(-100, "", null));
    }
}