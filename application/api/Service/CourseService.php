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
    public function GetList()
    {
        //get data
        $course = new Course();

        $data = $course->order('id', 'desc')
            ->select();

        return $data;
    }

    /**
     * 获取指定课程数据
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function Get($id)
    {
        //get info
        $data = Course::get($id, 'setting')->getData();
        return $data;
    }

    /**
     * 新增课程数据
     * @param $data
     * @param $dataSetting
     * @return int|string
     */
    public function Insert($data, $dataSetting)
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
    public function Update($data, $dataSetting)
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

            return 0;
        } else {
            return $course->getError();
        }
    }

    /**
     * 删除指定课程数据
     * @param $id
     * @return int
     */
    public function Delete($id)
    {
        $course = Course::get($id);
        if ($course->delete()) {
            // 删除关联数据
            $course->setting->delete();
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
    public function CheckUnique($data, $id)
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
}