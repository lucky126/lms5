<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-03
 * Time: 23:10
 */

namespace app\api\controller;

/**
 * 课程api控制器
 * @package app\api\controller
 */
class Course extends Authority
{
    /**
     * 显示课程资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $service = controller('CourseService', 'Service');
        $data = $service->GetList();

        return json($data);
    }

    /**
     * 保存新建的课程资源
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
            $result = $this->validate($data, 'Course');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(Base::getResult(-101, $result, null));
            }

            $data['isopenselection'] = 0;
            if (input('?isopenselection')) {
                $data['isopenselection'] = 1;
            }

            $data['isscormcourse'] = 0;
            if (input('?isscormcourse')) {
                $data['isscormcourse'] = 1;
            }

            $dataSetting['isbulletin'] = 0;
            if (input('?isbulletin')) {
                $dataSetting['isbulletin'] = 1;
            }
            $dataSetting['isresource'] = 0;
            if (input('?isresource')) {
                $dataSetting['isresource'] = 1;
            }
            $dataSetting['isqa'] = 0;
            if (input('?isqa')) {
                $dataSetting['isqa'] = 1;
            }
            $dataSetting['isevaluator'] = 0;
            if (input('?isevaluator')) {
                $dataSetting['isevaluator'] = 1;
            }
            $dataSetting['istest'] = 0;
            if (input('?istest')) {
                $dataSetting['istest'] = 1;
            }
            $dataSetting['ishomework'] = 0;
            if (input('?ishomework')) {
                $dataSetting['ishomework'] = 1;
            }

            $service = controller('CourseService', 'Service');
            $result = $service->Insert($data, $dataSetting);

            return json(Base::getResult(0, "", null));
        }
    }

    /**
     * 显示指定的课程资源
     *
     * @param  int $id 课程id
     * @return \think\Response
     */
    public function read($id)
    {
        //get user info
        $service = controller('CourseService', 'Service');
        $returnVal = $service->Get($id);

        //return data
        return json($returnVal);
    }

    /**
     * 保存更新的课程资源
     *
     * @param int $id 课程id
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
            $result = $this->validate($data, 'Course.edit');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(Base::getResult(-101, $result, null));
            }

            $data['isopenselection'] = 0;
            if (input('?isopenselection')) {
                $data['isopenselection'] = 1;
            }

            $data['isscormcourse'] = 0;
            if (input('?isscormcourse')) {
                $data['isscormcourse'] = 1;
            }

            $dataSetting['isbulletin'] = 0;
            if (input('?isbulletin')) {
                $dataSetting['isbulletin'] = 1;
            }
            $dataSetting['isresource'] = 0;
            if (input('?isresource')) {
                $dataSetting['isresource'] = 1;
            }
            $dataSetting['isqa'] = 0;
            if (input('?isqa')) {
                $dataSetting['isqa'] = 1;
            }
            $dataSetting['isevaluator'] = 0;
            if (input('?isevaluator')) {
                $dataSetting['isevaluator'] = 1;
            }
            $dataSetting['istest'] = 0;
            if (input('?istest')) {
                $dataSetting['istest'] = 1;
            }
            $dataSetting['ishomework'] = 0;
            if (input('?ishomework')) {
                $dataSetting['ishomework'] = 1;
            }

            $service = controller('CourseService', 'Service');
            $result = $service->Update($data, $dataSetting);

            return json(Base::getResult(0, "", null));
        }
    }

    /**
     * 删除指定课程资源
     *
     * @param  int $id 课程id
     * @return \think\Response
     */
    public function delete($id)
    {
        $service = controller('CourseService', 'Service');
        $result = $service->Delete($id);

        return json(Base::getResult(0, "", null));
    }

    /**
     * 验证唯一性
     *
     * @param int $id 课程id
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
            $service = controller('CourseService', 'Service');

            if (!$service->CheckUnique($data, $id)) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }
    }
}