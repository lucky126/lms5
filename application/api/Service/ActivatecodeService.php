<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/31
 * Time: 16:15
 */

namespace app\api\service;
use api\model\Activatecode;

/**
 * 激活码服务类
 * @package app\api\service
 */
class ActivatecodeService extends BaseService
{
    /**
     * 新增激活码数据
     * @param $data
     * @return int|string
     */
    public function insert($data)
    {
        //make data
        $code = new Activatecode();
        //$code->title = $data['title'];

        if ($code->save()) {

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('生成激活码： ' . json_encode($code), '生成激活码');

            return 0;
        } else {
            return $code->getError();
        }
    }
}