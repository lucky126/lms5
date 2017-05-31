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
        //1、根据数量生成指定数量的激活码
        for ($i = 0; $i < $data['account']; $i++) {
            $code = new Activatecode();
            $code->activatecode = getGuid();
            $code->batchcode = '';
            $code->systemid = 1;
            $code->studentid = '';
            $code->objectid = $data['trainingclass'];
            $code->objecttype = 1;

            //$code->save();
        }

        //保存财务信息
        //保存激活码日志

        if (false) {

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            //$logService->insert('生成激活码： ' . json_encode($code), '生成激活码');

            return 0;
        } else {
            return $code->getError();
        }
    }
}