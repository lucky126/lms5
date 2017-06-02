<?php
/**
 * Created by PhpStorm.
 * User: lucky
 * Date: 2017/5/31
 * Time: 16:01
 */

namespace app\api\controller;

/**
 * 激活码api控制器
 * @package app\api\controller
 */
class Activatecode extends Authority
{
    /**
     * 显示激活码资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        //获取默认系统信息
        $sysService = controller('api/SystemService', 'Service');
        $system = $sysService->GetDefault();

        $service = controller('ActivatecodeService', 'Service');
        $data = $service->getList($system['id']);

        return json($data);
    }

    /**
     * 保存新建的激活码资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save()
    {
        //must post
        if (request()->isPost()) {
            $data = input('post.');
            $data['batchcode'] = date('YmdHis');
            //validate

            $result = $this->validate($data, 'Activatecode');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(Base::setResult(-101, $result, null));
            }

            //获取默认系统信息
            $sysService = controller('api/SystemService', 'Service');
            $system = $sysService->GetDefault();
            $data['systemid'] = $system['id'];

            $service = controller('ActivatecodeService', 'Service');
            $result = $service->insert($data);

            return json($result);
        }
    }
}