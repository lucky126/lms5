<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/12
 * Time: 17:15
 */

namespace app\api\service;

use app\api\model\Course;
use app\api\model\Coursesetting;
use app\api\model\Trainingcourse;
use think\Db;

/**
 * 课程服务类
 * @package app\api\service
 */
class CourseService extends BaseService
{
    /**
     * 获取课程列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getList()
    {
        //get data
        $course = new Course();

        $data = $course->order('id', 'desc')
            ->select();

        return $data;
    }

    /**
     * 获取指定课程数据
     * @param $id 课程id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function get($id)
    {
        //get info
        $data = Course::get($id, 'setting');
        $data['setting'] = $data->getData('setting');
        if ($data != null) {
            return $data->getData();
        } else {
            return null;
        }
    }

    /**
     * 新增课程数据
     * @param $data
     * @param $dataSetting
     * @return int|string
     */
    public function insert($data, $dataSetting)
    {
        //make data
        $coursesetting = new Coursesetting;
        $coursesetting->isbulletin = $dataSetting['isbulletin'];
        $coursesetting->isresource = $dataSetting['isresource'];
        $coursesetting->isqa = $dataSetting['isqa'];
        $coursesetting->isevaluator = $dataSetting['isevaluator'];
        $coursesetting->istest = $dataSetting['istest'];
        $coursesetting->ishomework = $dataSetting['ishomework'];

        $course = new Course;
        $course->systemid = 1;
        $course->coursecode = $data['coursecode'];
        $course->coursename = $data['coursename'];
        $course->typeid = $data['typeid'];
        $course->courseurl = $data['courseurl'];
        $course->democourseurl = $data['democourseurl'];
        $course->coursehours = $data['coursehours'];
        $course->coursefee = $data['coursefee'];
        $course->isscormcourse = $data['isscormcourse'];
        $course->isopenselection = $data['isopenselection'];
        $course->coursedescription = $data['coursedescription'];

        //$course->coursesetting = $coursesetting;

        //$result = $course->together('Coursesetting')->save();
        if ($course->save()) {
            $course->setting()->save($coursesetting);

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('新增课程： ' . json_encode($course) . ' & ' . json_encode($coursesetting), '新增课程');

            return 0;
        } else {
            return $course->getError();
        }
    }

    /**
     * 更新指定课程数据
     * @param $data
     * @param $dataSetting
     * @return int|string
     */
    public function update($data, $dataSetting)
    {
        $course = Course::get($data['id']);
        $course->coursename = $data['coursename'];
        $course->typeid = $data['typeid'];
        $course->courseurl = $data['courseurl'];
        $course->democourseurl = $data['democourseurl'];
        $course->coursehours = $data['coursehours'];
        $course->coursefee = $data['coursefee'];
        $course->isscormcourse = $data['isscormcourse'];
        $course->isopenselection = $data['isopenselection'];
        $course->coursedescription = $data['coursedescription'];


        if ($course->save()) {
            // 更新关联数据
            $course->setting->isbulletin = $dataSetting['isbulletin'];
            $course->setting->isresource = $dataSetting['isresource'];
            $course->setting->isqa = $dataSetting['isqa'];
            $course->setting->isevaluator = $dataSetting['isevaluator'];
            $course->setting->istest = $dataSetting['istest'];
            $course->setting->ishomework = $dataSetting['ishomework'];

            $course->setting->save();

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('更新课程： ' . json_encode($course), '更新课程');

            return 0;
        } else {
            return $course->getError();
        }
    }

    /**
     * 删除指定课程数据
     * @param $id 课程id
     * @return int
     */
    public function delete($id)
    {
        //check training use count
        $trainingCount = Trainingcourse::where(['scormid' => $id])->count();
        if ($trainingCount > 0) {
            return -201;
        }

        $course = Course::get($id);
        if ($course->delete()) {
            // 删除关联数据
            $course->setting->delete();

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('删除课程： ' . json_encode($course), '删除课程');

            return 0;
        } else {
            return $course->getError();
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
        if (input('?post.coursename'))
            $map['coursename'] = $data['coursename'];
        if (input('?post.coursecode'))
            $map['coursecode'] = $data['coursecode'];

        if ($id != 0) {
            $map['id'] = ['neq', $id];
        }

        if (Db::name('Course')->where($map)->find() != null) {
            return false;
        }

        return true;
    }

    /**
     * 设置状态
     * @param $id 课程id
     * @param $status 目标状态值
     * @return int|string
     */
    public function changeStatus($id, $status)
    {
        $course = Course::get($id);
        $course->status = $status;

        if ($course->save()) {

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $memo = '更新课程ID为 ' . $id . ' 的状态为' . $status;
            $logService->insert($memo, '更新课程状态');

            return 0;
        } else {
            return $course->getError();
        }
    }
}