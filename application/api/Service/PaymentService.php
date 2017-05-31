<?php
/**
 * Created by PhpStorm.
 * User: sl982
 * Date: 2017-05-31
 * Time: 21:48
 */

namespace app\api\Service;

use api\model\Paymentlog;
use app\api\model\Payment;

/**
 * 交费服务类
 * @package app\api\service
 */
class PaymentService extends BaseService
{
    /**
     * 新增交费数据
     * @param $data
     * @return int|string
     */
    public function insert($data)
    {
        //添加交费信息记录
        $payment = new Payment();
        $payment->userid = '';
        $payment->payobjectid = '';
        $payment->payobjecttype = '';
        $payment->paymoney = '';
        $payment->account = '';
        $payment->paytype = '';
        $payment->systemid = '';
        $payment->orderno = '';
        $payment->memo = '';

        if ($payment->save()) {
            //添加交费日志记录
            $paymentlog = new Paymentlog();
            $paymentlog->paymentid = '';
            $paymentlog->userid = '';
            $paymentlog->paymentobjectid = '';
            $paymentlog->paymentobjecttype = '';
            $paymentlog->paymoney = '';
            $paymentlog->paytype = '';
            $paymentlog->operatoruserid = '';
            $paymentlog->operatorip = '';
            $paymentlog->systemid = '';

            if ($paymentlog->save()) {

            }
        }
    }
}