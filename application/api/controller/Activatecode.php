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

            //validate
            $result = $this->validate($data, 'Activatecode');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return json(Base::setResult(-101, $result, null));
            }

            $service = controller('ActivationcodeService', 'Service');
            $result = $service->insert($data);

            return json(Base::setResult(0, "", null));
        }
    }
}