<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-14
 * Time: 22:39
 */

namespace app\api\service;

use app\api\model\Training;
use app\api\model\Trainingcourse;
use think\Db;

/**
 * 培训班服务类
 * @package app\api\service
 */
class TrainingService extends BaseService
{
    /**
     * 获取培训班列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getList()
    {
        //
        $training = new Training();

        $data = $training->order('id', 'desc')
            ->select();

        return $data;
    }

    /**
     * 获取指定培训班数据
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function get($id)
    {
        $data = Training::get($id, 'courses')->getData();

        return $data;
    }

    /**
     * 获取指定培训班课程数据
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function GetCourses($id)
    {
        $data = Db::view('trainingcourse', 'trainingid,isrequired')
            ->view('course', 'coursecode,coursename,coursefee', 'course.id=trainingcourse.scormid AND course.systemid=trainingcourse.systemid', 'LEFT')
            ->where('trainingid', '=', $id)
            ->select();

        return $data;
    }

    /**
     * 新增培训班数据
     * @param $data
     * @return int|string
     */
    public function insert($data)
    {
        //make user data
        $training = new Training;
        $training->systemid = 1;
        $training->trainingname = $data['trainingname'];
        $training->trainingcode = $data['trainingcode'];
        $training->traingtype = 1;
        $training->registrationstarttime = $data['registrationstarttime'];
        $training->registrationendtime = $data['registrationendtime'];
        $training->starttime = $data['starttime'];
        $training->endtime = $data['endtime'];
        $training->isopen = 1;
        $training->trainingcost = $data['trainingcost'];
        $training->allownumberofcourses = $data['allownumberofcourses'];
        $training->description = $data['description'];
        $training->content = $data['content'];
        $training->memeber = '';
        $training->notice = $data['notice'];

        if ($training->save()) {
            //get all courses info
            $courses = explode(",", $data['courses']);

            foreach ($courses as $c) {
                $c_info = explode("_", $c);
                $isrequired = 0;
                if (count($c_info) > 1) {
                    $isrequired = 1;
                }

                $trainingcourse = new Trainingcourse;
                $trainingcourse->systemid = 1;
                $trainingcourse->scormid = $c_info[0];
                $trainingcourse->isrequired = $isrequired;
                $trainingcourse->addtime = datetime();
                $training->courses()->save($trainingcourse);
            }

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('新增培训班： ' . json_encode($training) .' & '. json_encode($data['courses']), '新增培训班');

            return 0;
        } else {
            return $training->getError();
        }
    }

    /**
     * 更新指定培训班数据
     * @param $data
     * @return int|string
     */
    public function update($data)
    {
        //update training info
        $training = Training::get($data['id']);
        $training->trainingname = $data['trainingname'];
        $training->trainingcode = $data['trainingcode'];
        $training->traingtype = 1;
        $training->registrationstarttime = $data['registrationstarttime'];
        $training->registrationendtime = $data['registrationendtime'];
        $training->starttime = $data['starttime'];
        $training->endtime = $data['endtime'];
        $training->isopen = 1;
        $training->trainingcost = $data['trainingcost'];
        $training->allownumberofcourses = $data['allownumberofcourses'];
        $training->description = $data['description'];
        $training->content = $data['content'];
        $training->memeber = '';
        $training->notice = $data['notice'];

        if ($training->save()) {
            //delete course setting info
            Db::name("trainingcourse")->where('trainingid', $data['id'])->delete();

            //get all courses info
            $courses = explode(",", $data['courses']);

            foreach ($courses as $c) {
                $c_info = explode("_", $c);
                $isrequired = 0;
                if (count($c_info) > 1) {
                    $isrequired = 1;
                }
                $course = [
                    'systemid' => 1,
                    'trainingid' => $data['id'],
                    'scormid' => $c_info[0],
                    'isrequired' => $isrequired,
                    'addtime' => datetime(),
                ];

                //insert course setting info
                Db::name("trainingcourse")->insert($course);
            }

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('更新培训班： ' . json_encode($training) .' & '. json_encode($data['courses']), '更新培训班');

            return 0;
        } else {
            return $training->getError();
        }
    }

    /**
     * 删除指定培训班数据
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        $training = Training::get($id);
        if ($training->delete()) {
            // 删除关联数据
            $training->courses->delete();

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('删除培训班： ' . json_encode($training), '删除培训班');

            return 0;
        } else {
            return $training->getError();
        }
    }

    /**
     * 检查字段是否唯一
     * @param $data
     * @param $id
     * @return bool
     */
    public function checkUnique($data, $id)
    {
        if (input('?post.trainingname'))
            $map['trainingname'] = $data['trainingname'];
        if (input('?post.trainingcode'))
            $map['trainingcode'] = $data['trainingcode'];

        if ($id != 0) {
            $map['id'] = ['neq', $id];
        }
        if (Db::name('training')->where($map)->find() != null) {
            return false;
        }

        return true;
    }

    /**
     * 设置状态
     * @param $id 培训班id
     * @param $status 目标状态值
     * @return int|string
     */
    public function changeStatus($id, $status)
    {
        $training = Training::get($id);
        $training->status = $status;

        if ($training->save()) {

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $memo = '更新培训班ID为 ' . $id . ' 的状态为' . $status;
            $logService->insert($memo, '更新培训班状态');

            return 0;
        } else {
            return $training->getError();
        }
    }
}