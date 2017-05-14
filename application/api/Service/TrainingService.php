<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-14
 * Time: 22:39
 */

namespace app\api\service;


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
        $data = Db::name('training')->where("status", "<>", "-1")->select();

        return $data;
    }

    /**
     * 获取指定培训班数据
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function Get($id)
    {
        $map['status'] = ['<>', '-1'];
        $map['id'] = ['=', $id];
        $data = Db::name('training')->where($map)->find();
        $course = Db::name('trainingcourse')->where('trainingid', $id)->select();

        $returnVal = array('data' => $data, 'courses' => $course);

        return $returnVal;
    }

    /**
     * 新增培训班数据
     * @param $data
     * @return int|string
     */
    public function Insert($data)
    {
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
        if ($result > 0) {
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
        }

        return $result;
    }

    /**
     * 更新指定培训班数据
     * @param $data
     * @return int|string
     */
    public function Update($data)
    {
        //update training info
        $result = Db::name('training')
            ->where('id', $data['id'])
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
            $result = Db::name("trainingcourse")->insert($course);
        }

        return $result;
    }

    /**
     * 删除指定培训班数据
     * @param $id
     * @return int
     */
    public function Delete($id)
    {
        //delete course setting info
        $result = Db::name("trainingcourse")->where('trainingid', $id)->delete();
        //delete course info
        $result = Db::name('training')->where('id', $id)->delete();

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
}