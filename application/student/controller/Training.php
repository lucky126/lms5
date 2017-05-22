<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/22
 * Time: 15:25
 */

namespace app\student\controller;

/**
 * Class Training
 * @package app\student\controller
 */
class Training extends Basic
{
    /**
     * 报名培训班
     * @return mixed
     */
    public function RegPayment()
    {
        return $this->fetch();
    }

    /**
     * 培训班详细
     * @return mixed
     */
    public function detail($id)
    {
        $this->assign("id", $id);
        return $this->fetch();
    }
}