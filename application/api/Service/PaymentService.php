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
        $payment->userid = $data['userid'];
        $payment->payobjectid = $data['payobjectid'];
        $payment->payobjecttype = $data['payobjecttype'];
        $payment->paymoney = $data['paymoney'];
        $payment->account = $data['account'];
        $payment->paytype = $data['paytype'];
        $payment->systemid = $data['systemid'];
        $payment->orderno = $data['orderno'];
        $payment->memo = $data['memo'];

        if ($payment->save()) {
            $payid = $payment->getLastInsID();
            //添加交费日志记录
            $paymentlog = new Paymentlog();
            $paymentlog->paymentid = $payid;
            $paymentlog->userid = $data['userid'];
            $paymentlog->paymentobjectid = $data['payobjectid'];
            $paymentlog->paymentobjecttype = $data['payobjecttype'];
            $paymentlog->paymoney = $data['paymoney'];
            $paymentlog->paytype = $data['paytype'];
            $paymentlog->operatoruserid = $data['uid'];
            $paymentlog->operatorip = $data['uip'];
            $paymentlog->systemid = $data['systemid'];

            if ($paymentlog->save()) {
                return BaseService::setResult(0, '', $payid);
            } else {
                $paymentDelete = Payment::get($payid);
                $paymentDelete->delete();
                return BaseService::setResult(-301, '', $payid);
            }
        }

        return BaseService::setResult(-100, '', '');
    }
}