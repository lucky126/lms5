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
        if (input('?get.end') && input('get.start') != '' && input('get.end') != '') {
            $map['ac.adddate'] = ['between time', [input('get.start'), input('get.end')]];
        }

        //查询数据
        $data = Db::name('Activatecode')
            ->alias('ac')
            ->field('activatecode,activatedate,ac.adddate,batchcode,ac.systemid,ac.studentid,objectid,objecttype,name,trainingname')
            ->join('Studentbasicinfo stu', 'ac.studentid = stu.studentid', 'LEFT')
            ->join('Training t', 'ac.objectid = t.id', 'LEFT')
            ->where($map)
            ->order('adddate', 'desc')
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

        //验证培训计划信息
        $trainingService = controller('TrainingService', 'Service');
        $training = $trainingService->get($data['trainingclass']);

        if ($training == null) {
            return BaseService::setResult('-205', '培训班不存在', '');
        }
        if ($training['isopen'] == 0) {
            return BaseService::setResult('-206', '培训班未开放', '');
        }

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

    /**
     * 更新激活码资源给指定用户
     * @param $data
     * @return int|string
     */
    public function update($data)
    {
        //检查需要报名的培训班是否存在
        $trainingService = controller('TrainingService', 'Service');
        $training = $trainingService->get($data['tid']);

        //培训班不存在
        if ($training == null) {
            return BaseService::setResult('-206', '该培训班还没有生成,不能报名', '');
        }

        //培训班没有课程
        if ($training['courses'] == null) {
            return BaseService::setResult('-207', '该培训班下没有课程,不能报名', '');
        }

        //判断是否是测试用户
        $userService = controller('UserService', 'Service');
        $isTestUser = $userService->isTestUser($data['uid']);

        //非测试用户在培训班结束后无法报名(考虑激活码模式可能会由企业批量提前购买，所以从报名许可期间延长至培训班截至时间)
        if (!$isTestUser && $training['registrationendtime'] >= datetime()) {
            return BaseService::setResult('-208', '该培训班已经结束,不能报名', '');
        }

        //检查该生以前是否有过合格的成绩，如果有，则不允许再次激活
        $pass_score_data = Db::name('studenttraining')
            ->alias('st')
            ->field('t.id')
            ->join('training t', 'st.trainingid = t.id and st.systemid=t.systemid', 'LEFT')
            ->where('st.totalscore', '>=', 't.minpassresult')
            ->where('st.trainingid', '=', $data['tid'])
            ->where('st.systemid', '=', $data['systemid'])
            ->count();

        if ($pass_score_data > 0) {
            return BaseService::setResult('-201', '已经有合格的成绩', '');
        }

        //增加限制，如果已经存在开放的培训班则不允许再激活其他培训班
        $selectcourseService = controller('StudenttrainingService', 'Service');
        $class_list = $selectcourseService->getTrainingList($data['uid'], $data['systemid']);

        if (count($class_list) > 0) {
            return BaseService::setResult('-202', '您当前的培训班还没有结束，不能再激活其它培训班', '');
        }

        //获取激活码信息
        $codeData = $this::get($data['acid']);

        if ($codeData == null) {
            return BaseService::setResult('-204', '该激活码不存在', '');
        }
        if ($codeData['name'] != null) {
            return BaseService::setResult('-205', '此激活码已被 ' . $codeData['name'] . ' 使用', '');
        }

        /*****TODO:目前默认只有培训班学习模式，不存在选课学习模式*****/


    }

    /**
     * 获取指定激活码数据
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function get($id)
    {
        $data = Db::name('activatecode')
            ->alias('ac')
            ->field('ac.*,stu.name')
            ->join('studentbasicinfo stu', 'ac.studentid=stu.studentid', 'LEFT')
            ->where('activatecode', '=', $id)
            ->find();

        if ($data != null) {
            return $data;
        } else {
            return null;
        }
    }
}