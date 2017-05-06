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
class training extends base
{
    /**
     * 显示培训班资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $data = Db::name('training')->where("status", "<>", "-1")->select();

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

            //make user data
            $userdata = [
                'systemid' => 1,
                'trainingname' => $data['trainingname'],
                'trainingcode' => $data['trainingcode'],
                'traingtype' => 1,
                'registrationstarttime' => $data['registrationstarttime'],
                'registrationendtime' => $data['registrationendtime'],
                'starttime' => $data['starttime'],
                'endtime' => $data['endtime'],
                'isopen' => 1,
                'trainingcost' => $data['trainingcost'],
                'allownumberofcourses' => $data['allownumberofcourses'],
                'description' => $data['description'],
                'content' => $data['content'],
                'memeber' => '',
                'notice' => $data['notice'],
                'addtime' => datetime(),
                'status' => 1,
            ];
            //insert data
            $result = Db::name('training')->insert($userdata);
            //get training id
            $tid = Db::name('training')->getLastInsID();

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
                    'trainingid' => $tid,
                    'scormid' => $c_info[0],
                    'isrequired' => $isrequired,
                    'addtime' => datetime(),
                ];

                //insert course setting info
                $result = Db::name("trainingcourse")->insert($course);
            }

            return json(base::getresult(0, "", null));
        }
    }

    /**
     * 显示指定的培训班资源
     *
     * @param  int $id 培训班id
     * @return \think\Response
     */
    public function read($id)
    {
        //get user info
        $data = Db::name('training')->where('id', $id)->find();
        $course = Db::name('trainingcourse')->where('trainingid', $id)->select();

        $returnVal = array('data' => $data, 'courses' => $course);
        //return data
        return json($returnVal);
    }

    /**
     * 保存更新的培训班资源
     *
     * @param int $id 培训班id
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

            //update course info
            $result = Db::name('training')
                ->where('id', $id)
                ->update([
                    'trainingname' => $data['trainingname'],
                    'traingtype' => 1,
                    'registrationstarttime' => $data['registrationstarttime'],
                    'registrationendtime' => $data['registrationendtime'],
                    'starttime' => $data['starttime'],
                    'endtime' => $data['endtime'],
                    'isopen' => 1,
                    'trainingcost' => $data['trainingcost'],
                    'allownumberofcourses' => $data['allownumberofcourses'],
                    'description' => $data['description'],
                    'content' => $data['content'],
                    'memeber' => '',
                    'notice' => $data['notice'],
                ]);


            //delete course setting info
            Db::name("trainingcourse")->where('trainingid', $id)->delete();

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
                    'trainingid' => $id,
                    'scormid' => $c_info[0],
                    'isrequired' => $isrequired,
                    'addtime' => datetime(),
                ];

                //insert course setting info
                $result = Db::name("trainingcourse")->insert($course);
            }

            return json(base::getresult(0, "", null));
        }
    }

    /**
     * 删除指定培训班资源
     *
     * @param  int $id 培训班id
     * @return \think\Response
     */
    public function delete($id)
    {
        //delete course setting info
        Db::name("trainingcourse")->where('trainingid', $id)->delete();
        //delete course info
        Db::name('training')->where('id', $id)->delete();
        return json(base::getresult(0, "", null));
    }

    /**
     * 验证唯一性
     *
     * @param int $id 培训班id
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

            if (input('?post.trainingname'))
                $map['trainingname'] = $data['trainingname'];
            if (input('?post.trainingcode'))
                $map['trainingcode'] = $data['trainingcode'];

            if ($id != 0) {
                $map['id'] = ['neq', $id];
            }
            if (Db::name('training')->where($map)->find() != null) {
                return json($result);
            }

            $result['valid'] = true;
            return json($result);
        }
    }
}