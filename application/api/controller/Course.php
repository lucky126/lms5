<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-03
 * Time: 23:10
 */

namespace app\api\controller;

use think\Request;
use think\Db;

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
        //get data
        //$map['status'] = ['<>', '0'];
        $data = Db::name('Course')->select();

        //文字转换
        foreach ($data as $k => $v) {
            $data[$k]['isopenselectiondesc'] = config('globalConst.YesOrNoDesc')[$v['isopenselection']];
            $data[$k]['isscormcoursedesc'] = config('globalConst.YesOrNoDesc')[$v['isscormcourse']];
        }

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

            $isopenselection = 0;
            if (input('?isopenselection')) {
                $isopenselection = 1;
            }

            $isscormcourse = 0;
            if (input('?isscormcourse')) {
                $isscormcourse = 1;
            }

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
                'isscormcourse' => $isscormcourse,
                'isopenselection' => $isopenselection,
                'coursedescription' => $data['coursedescription'],
                'isrecommand' => 0,
                'addtime' => datetime(),
                'status' => 1,
            ];
            //insert data
            $result = Db::name('Course')->insert($userdata);
            //get course id
            $cid = Db::name('Course')->getLastInsID();


            $isbulletin = 0;
            if (input('?isbulletin')) {
                $isbulletin = 1;
            }
            $isresource = 0;
            if (input('?isresource')) {
                $isresource = 1;
            }
            $isqa = 0;
            if (input('?isqa')) {
                $isqa = 1;
            }
            $isevaluator = 0;
            if (input('?isevaluator')) {
                $isevaluator = 1;
            }
            $istest = 0;
            if (input('?istest')) {
                $istest = 1;
            }
            $ishomework = 0;
            if (input('?ishomework')) {
                $ishomework = 1;
            }
            //make user group info
            $coursesetting = [
                'id' => $cid,
                'isbulletin' => $isbulletin,
                'isresource' => $isresource,
                'isqa' => $isqa,
                'isevaluator' => $isevaluator,
                'istest' => $istest,
                'ishomework' => $ishomework,
            ];
            //insert course setting info
            $result = Db::name("coursesetting")->insert($coursesetting);

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
        $data = Db::name('Course')->where('id', $id)->find();
        $setting = Db::name('coursesetting')->where('id', $id)->find();

        $returnVal = array('data' => $data, 'setting' => $setting);
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

            $isopenselection = 0;
            if (input('?isopenselection')) {
                $isopenselection = 1;
            }

            $isscormcourse = 0;
            if (input('?isscormcourse')) {
                $isscormcourse = 1;
            }

            //update course info
            $result = Db::name('Course')
                ->where('id', $id)
                ->update([
                    'coursename' => $data['coursename'],
                    'typeid' => $data['typeid'],
                    'courseurl' => $data['courseurl'],
                    'democourseurl' => $data['democourseurl'],
                    'coursehours' => $data['coursehours'],
                    'coursefee' => $data['coursefee'],
                    'isscormcourse' => $isscormcourse,
                    'isopenselection' => $isopenselection,
                    'coursedescription' => $data['coursedescription']
                ]);


            $isbulletin = 0;
            if (input('?isbulletin')) {
                $isbulletin = 1;
            }
            $isresource = 0;
            if (input('?isresource')) {
                $isresource = 1;
            }
            $isqa = 0;
            if (input('?isqa')) {
                $isqa = 1;
            }
            $isevaluator = 0;
            if (input('?isevaluator')) {
                $isevaluator = 1;
            }
            $istest = 0;
            if (input('?istest')) {
                $istest = 1;
            }
            $ishomework = 0;
            if (input('?ishomework')) {
                $ishomework = 1;
            }
            //update course setting info
            $result = Db::name('coursesetting')
                ->where('id', $id)
                ->update([
                    'isbulletin' => $isbulletin,
                    'isresource' => $isresource,
                    'isqa' => $isqa,
                    'isevaluator' => $isevaluator,
                    'istest' => $istest,
                    'ishomework' => $ishomework
                ]);

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
        //delete course setting info
        Db::name("coursesetting")->where('id', $id)->delete();
        //delete course info
        Db::name('Course')->where('id', $id)->delete();
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

            if (input('?post.coursename'))
                $map['coursename'] = $data['coursename'];
            if (input('?post.coursecode'))
                $map['coursecode'] = $data['coursecode'];

            if ($id != 0) {
                $map['id'] = ['neq', $id];
            }
            if (Db::name('Course')->where($map)->find() != null) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }
    }
}