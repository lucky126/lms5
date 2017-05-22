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
     * 缴费
     * @return mixed
     */
    public function Pay()
    {
        return $this->fetch();
    }

}