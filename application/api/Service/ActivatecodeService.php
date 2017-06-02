<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/31
 * Time: 16:15
 */

namespace app\api\service;

use app\api\model\Activatecode;
use app\api\model\Activatecodelog;
use think\Db;

/**
 * 激活码服务类
 * @package app\api\service
 */
class ActivatecodeService extends BaseService
{
    /**
     * 获取激活码列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getList($systemId)
    {
        //get data
        $map['ac.systemid'] = ['=', $systemId];

        //搜索筛选
        if (input('?get.activatecode') && input('get.activatecode') != '') {
            $map['activatecode'] = ['LIKE', '%' . input('get.activatecode') . '%'];
        }
        if (input('?get.batchcode') && input('get.batchcode') != '') {
            $map['batchcode'] = ['LIKE', '%' . input('get.batchcode') . '%'];
        }
        if (input('?get.training') && input('get.training') != '') {
            $map['objectid'] = ['=', input('get.training')];
        }
        if (input('?get.status') && input('get.status') == '1') {
            $map['ac.studentid'] = ['<>', ''];
        }
        if (input('?get.status') && input('get.status') == '2') {
            $map['ac.studentid'] = ['=', ''];
        }

        //查询数据
        $data = Db::name('Activatecode')
            ->alias('ac')
            ->field('activatecode,activatedate,adddate,batchcode,ac.systemid,ac.studentid,objectid,objecttype,name,trainingname')
            ->join('Studentbasicinfo stu', 'ac.studentid = stu.studentid', 'LEFT')
            ->join('Training t', 'ac.objectid = t.id', 'LEFT')
            ->where($map)
            ->select();

        return $data;
    }

    /**
     * 新增激活码数据
     * @param $data
     * @return int|string
     */
    public function insert($data)
    {
        //设置交费对象类型（0-非用户交费，1-选培训班交费，2-选课交费）
        $objecttype = 1;
        //获得日志保存用的数据json
        $loginfo = '';
        //记录生成激活码成功数量
        $createCnt = 0;

        //1、根据数量生成指定数量的激活码
        for ($i = 0; $i < $data['account']; $i++) {
            //create mode
            $code = new Activatecode();
            $code->activatecode = str_replace('-', '', getGuid());
            $code->batchcode = $data['batchcode'];
            $code->systemid = $data['systemid'];
            $code->studentid = '';
            $code->objectid = $data['trainingclass'];
            $code->objecttype = $objecttype;

            //make json
            $loginfo .= json_encode($code) . '|';

            //save
            if ($code->save()) {
                $createCnt++;
            }
        }

        //如果生成数量不符合指定数量则回滚
        if ($createCnt != $data['account']) {
            $codeDelete = User::get(['batchcode' => $data['batchcode']]);
            $codeDelete->delete();
            return BaseService::setResult('-204', '生成激活码数量没达到要求数量', '');
        }

        //get login user info
        $userInfo = getLoginUserInfo();

        $paydata['userid'] = '';
        $paydata['payobjectid'] = $data['trainingclass'];
        $paydata['payobjecttype'] = $objecttype;
        $paydata['paymoney'] = $data['paymentmoney'];
        $paydata['account'] = $data['account'];
        $paydata['paytype'] = 3;
        $paydata['systemid'] = $data['systemid'];
        $paydata['orderno'] = '';
        $paydata['memo'] = '';
        $paydata['uid'] = $userInfo['uid'];
        $paydata['uip'] = request()->ip();
        //make json
        $loginfo .= json_encode($paydata) . '|';
        //保存财务信息
        $paymentService = controller('PaymentService', 'Service');
        $payresult = $paymentService->insert($paydata);
        //财务信息保存失败
        if ($payresult['code'] != 0) {
            $codeDelete = User::get(['batchcode' => $data['batchcode']]);
            $codeDelete->delete();
            return BaseService::setResult('-203', '保存交费信息和交费日志失败', '');
        }

        //保存激活码日志
        $codelog = new Activatecodelog();
        $codelog->generatenum = $data['account'];
        $codelog->batchcode = $data['batchcode'];
        $codelog->systemid = $data['systemid'];
        $codelog->objectid = $data['trainingclass'];
        $codelog->objecttype = $objecttype;
        $codelog->paymentmoney = $data['paymentmoney'];
        $codelog->userid = $userInfo['uid'];
        $codelog->operatorip = request()->ip();;
        $codelog->paymentid = $payresult['data'];
        //make json
        $loginfo .= json_encode($codelog);

        if ($codelog->save()) {

            //保存操作日志
            $logService = controller('OperatelogService', 'Service');
            $logService->insert('生成激活码： ' . $loginfo, '生成激活码');

            return BaseService::setResult(0, '', '');
        } else {
            return BaseService::setResult('-202', '保存激活码日志失败', '');
        }
    }
}