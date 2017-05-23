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
    public function GetList()
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
    public function Get($id)
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
    public function Insert($data)
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
    public function Update($data)
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
    public function Delete($id)
    {
        $training = Training::get($id);
        if ($training->delete()) {
            // 删除关联数据
            $training->courses->delete();
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
    public function CheckUnique($data, $id)
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
     * @param $id 系统id
     * @param $status 目标状态值
     * @return int|string
     */
    public function ChangeStatus($id, $status)
    {
        $training = Training::get($id);
        $training->status = $status;

        if ($training->save()) {
            return 0;
        } else {
            return $training->getError();
        }
    }
}