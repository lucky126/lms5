<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/12
 * Time: 17:15
 */

namespace app\api\service;

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
        //$map['status'] = ['<>', '0'];
        $data = Db::name('Course')->select();

        //文字转换
        foreach ($data as $k => $v) {
            $data[$k]['isopenselectiondesc'] = config('globalConst.YesOrNoDesc')[$v['isopenselection']];
            $data[$k]['isscormcoursedesc'] = config('globalConst.YesOrNoDesc')[$v['isscormcourse']];
        }

        return $data;
    }

    /**
     * 获取指定课程数据
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function Get($id)
    {
        //get user info
        $data = Db::name('Course')->where('id', $id)->find();
        $setting = Db::name('coursesetting')->where('id', $id)->find();

        $returnVal = array('data' => $data, 'setting' => $setting);

        return $returnVal;
    }

    /**
     * 新增课程数据
     * @param $data
     * @param $dataSetting
     * @return int|string
     */
    public function Insert($data, $dataSetting)
    {
        //make user data
        $userdata = [
            'systemid' => 1,
            'coursecode' => $data['coursecode'],
            'coursename' => $data['coursename'],
            'typeid' => $data['typeid'],
            'courseurl' => $data['courseurl'],
            'democourseurl' => $data['democourseurl'],
            'coursehours' => $data['coursehours'],
            'coursefee' => $data['coursefee'],
            'isscormcourse' => $data['isscormcourse'],
            'isopenselection' => $data['isopenselection'],
            'coursedescription' => $data['coursedescription'],
            'isrecommand' => 0,
            'addtime' => datetime(),
            'status' => 1,
        ];
        //insert data
        $result = Db::name('Course')->insert($userdata);

        if ($result > 0) {
            //get course id
            $cid = Db::name('Course')->getLastInsID();

            //make user group info
            $coursesetting = [
                'id' => $cid,
                'isbulletin' => $dataSetting['isbulletin'],
                'isresource' => $dataSetting['isresource'],
                'isqa' => $dataSetting['isqa'],
                'isevaluator' => $dataSetting['isevaluator'],
                'istest' => $dataSetting['istest'],
                'ishomework' => $dataSetting['ishomework'],
            ];
            //insert course setting info
            $result = Db::name("coursesetting")->insert($coursesetting);
        }

        return $result;
    }

    /**
     * 更新指定课程数据
     * @param $data
     * @param $dataSetting
     * @return int|string
     */
    public function Update($data, $dataSetting)
    {
        //update course info
        $result = Db::name('Course')
            ->where('id', $data['id'])
            ->update([
                'coursename' => $data['coursename'],
                'typeid' => $data['typeid'],
                'courseurl' => $data['courseurl'],
                'democourseurl' => $data['democourseurl'],
                'coursehours' => $data['coursehours'],
                'coursefee' => $data['coursefee'],
                'isscormcourse' => $data['isscormcourse'],
                'isopenselection' => $data['isopenselection'],
                'coursedescription' => $data['coursedescription']
            ]);

        if ($result >= 0) {
            //update course setting info
            $result = Db::name('coursesetting')
                ->where('id', $data['id'])
                ->update([
                    'isbulletin' => $dataSetting['isbulletin'],
                    'isresource' => $dataSetting['isresource'],
                    'isqa' => $dataSetting['isqa'],
                    'isevaluator' => $dataSetting['isevaluator'],
                    'istest' => $dataSetting['istest'],
                    'ishomework' => $dataSetting['ishomework'],
                ]);
        }

        return $result;
    }

    /**
     * 删除指定课程数据
     * @param $id
     * @return int
     */
    public function Delete($id)
    {
        //delete course setting info
        $result = Db::name("coursesetting")->where('id', $id)->delete();
        if ($result > 0) {
            //delete course info
            $result = Db::name('Course')->where('id', $id)->delete();
        }

        return $result;
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