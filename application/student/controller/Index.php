<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/9
 * Time: 15:08
 */

namespace app\student\controller;

/**
 * Class Index
 * @package app\student\controller
 */
class Index extends Basic
{
    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
        $service = controller('api/Selectcourse', 'controller');
        $data = $service->checkStudentAuth($this->uid);

        if($data['data'] == 'main')
            return $this->fetch();
        else
            return $this->redirect($data['data']);
    }

    /**
     * 菜单
     * @return mixed
     */
    public function menu()
    {
        return $this->fetch();
    }

    /**
     * 顶部提示消息
     * @return mixed
     */
    public function message()
    {
        return $this->fetch();
    }

    /**
     * 顶部个人信息
     * @return mixed
     */
    public function topinfo()
    {
        return $this->fetch();
    }
}