<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/22
 * Time: 15:26
 */

namespace app\student\controller;

/**
 * Class Finance
 * @package app\student\controller
 */
class Finance extends Basic
{
    /**
     * 缴费培训计划列表
     * @return mixed
     */
    public function paylist()
    {
        return $this->fetch();
    }

    /**
     * 缴费类型选择
     * @param $id
     * @return mixed
     */
    public function paytype($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }

    /**
     * 激活码页面
     * @param $id
     * @return mixed
     */
    public function activationcode($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }

    /**
     * 在线支付页面
     * @param $id
     * @return mixed
     */
    public function onlinepay($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }
}