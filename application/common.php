<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use think\Request;

// 应用公共文件
/**
 * GUID
 */
function getGuid()
{
    $charid = strtoupper(md5(uniqid(mt_rand(), true)));

    $hyphen = chr(45);// "-"
    $uuid = substr($charid, 0, 8) . $hyphen
        . substr($charid, 8, 4) . $hyphen
        . substr($charid, 12, 4) . $hyphen
        . substr($charid, 16, 4) . $hyphen
        . substr($charid, 20, 12);
    return $uuid;
}

/**
 * 得到加密后的密码
 */
function getEncPassword($password)
{
    return md5(config('globalConst.AUTH_CODE') . md5($password));
}

/**
 * 生成datetime
 * @return string
 */
function datetime()
{
    return date('Y-m-d H:i:s');
}


/**
 * 时间差计算
 *
 * @param Timestamp $time
 * @return String Time Elapsed
 * @author Shelley Shyan
 * @copyright http://phparch.cn (Professional PHP Architecture)
 */
function time2Units($time)
{
    $year = floor($time / 60 / 60 / 24 / 365);
    $time -= $year * 60 * 60 * 24 * 365;
    $month = floor($time / 60 / 60 / 24 / 30);
    $time -= $month * 60 * 60 * 24 * 30;
    $week = floor($time / 60 / 60 / 24 / 7);
    $time -= $week * 60 * 60 * 24 * 7;
    $day = floor($time / 60 / 60 / 24);
    $time -= $day * 60 * 60 * 24;
    $hour = floor($time / 60 / 60);
    $time -= $hour * 60 * 60;
    $minute = floor($time / 60);
    $time -= $minute * 60;
    $second = $time;
    $elapse = '';

    $unitArr = array('年' => 'year', '个月' => 'month', '周' => 'week', '天' => 'day',
        '小时' => 'hour', '分钟' => 'minute', '秒' => 'second'
    );

    foreach ($unitArr as $cn => $u) {
        if ($$u > 0) {
            $elapse = $$u . $cn;
            break;
        }
    }

    return $elapse;
}

/**
 * 返回论坛楼数
 * @param $cnt 排序
 * @return string
 */
function getDiscussCount($cnt)
{
    switch ($cnt) {
        case 1:
            $txt = '楼主';
            break;
        case 2:
            $txt = '沙发';
            break;
        case 3:
            $txt = '板凳';
            break;
        default:
            $txt = $cnt . '楼';
            break;
    }
    return $txt;

}

/**
 * get token
 * @param $uid
 * @param $id
 * @return string
 */
function getToken($uid, $id)
{
    $token = (new Builder())->setIssuer('http://lms.5iexam.com')// Configures the issuer (iss claim)
    ->setAudience('http://lms.5iexam.com')// Configures the audience (aud claim)
    ->setId('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
    ->setIssuedAt(time())// Configures the time that the token was issue (iat claim)
    ->setNotBefore(time() + 0)// Configures the time that the token can be used (nbf claim)
    ->setExpiration(time() + 3600)// Configures the expiration time of the token (nbf claim)
    ->set('uid', $uid)// Configures a new claim, called "uid"
    ->set('id', $id)// Configures a new claim, called "id"
    ->getToken(); // Retrieves the generated token

    return $token;
}

/**
 * get token param info
 * @param $token
 * @param $param
 * @return mixed
 */
function getTokenInfo($token, $param)
{
    $token = (new Parser())->parse((string) $token);
    return $token->getClaim($param);
}

/**
 * check token
 * @param $token
 * @param $userid
 * @return bool
 */
function checkToken($token, $userid)
{
    $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
    $data->setIssuer('http://example.com');
    $data->setAudience('http://example.org');
    $data->setId('4f1g23a12aa');
//$token->getClaim('uid')
    return $token->validate($data); // false, because we created a token that cannot be used before of `time() + 60`
}

/**
 *
 * @param $data
 * @param $path
 * @param int $pid
 * @param string $fieldPri
 * @param string $fieldPid
 * @param int $level
 * @return array
 */
function channelLevel($data, $path = '', $pid = 0, $fieldPri = 'id', $level = 1)
{
    if (empty($data)) {
        return array();
    }
    // dump($data);
    $arr = array();
    foreach ($data as $v) {
        if ($v["pid"] == $pid) {
            $selected = 0;
            if (strtolower($path) == strtolower($v["name"])) {
                $selected = 1;
            }
            $arr[$v[$fieldPri]] = $v;
            $arr[$v[$fieldPri]]['_level'] = $level;
            $arr[$v[$fieldPri]]['_selected'] = $selected;
            $arr[$v[$fieldPri]]["_data"] = channelLevel($data, $path, $v[$fieldPri], $fieldPri, $level + 1);

            foreach ($arr[$v[$fieldPri]]["_data"] as $child) {
                if ($child["_selected"] == 1) {
                    $arr[$v[$fieldPri]]['_selected'] = 1;
                    break;
                }
            }
        }
    }


    return $arr;
}

/**
 * 得到当前访问路径
 * @return string
 */
function getUrl()
{
    $request = Request::instance();
    //get url
    $m = $request->module();
    $c = $request->controller();
    $a = $request->action();
    $rule_name = $m . '/' . $c . '/' . $a;

    return $rule_name;
}