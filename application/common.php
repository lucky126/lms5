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
use Lcobucci\JWT\ValidationData;

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
 * 判定是否
 */
function getYesOrNo($yesOrNo)
{
    if ((int)$yesOrNo == 1) {
        $str = "<span class=\"YesOrNo\">是</span>";
    } else {
        $str = "";
    }

    return $str;
}

/**
 * 格式化datetime
 * @return string
 */
function datetimeShow($date)
{
    return date('Y年m月d日 H:i', strtotime(str_replace('/', '-', $date)));
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
 * 获得用户Gender html显示内容
 * @return string
 */
function getGenderOption($gender)
{
    $html = '';

    foreach (config('globalConst.GenderNamDesc') as $k => $v) {
        $isCheck = '';
        if ($k == $gender) {
            $isCheck = 'checked';
        }
        $html .= '<input type="radio" name="Gender" id="Gender" class="cbr cbr-blue" value="' . $k . '" ' . $isCheck . '> ' . $v . '  ';
    }

    return $html;
}

/**
 * get token
 * @param $userid
 * @return string
 */
function getToken($userid)
{
    $token = (new Builder())->setIssuer('http://example.com')// Configures the issuer (iss claim)
    ->setAudience('http://example.org')// Configures the audience (aud claim)
    ->setId('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
    ->setIssuedAt(time())// Configures the time that the token was issue (iat claim)
    ->setNotBefore(time() + 0)// Configures the time that the token can be used (nbf claim)
    ->setExpiration(time() + 3600)// Configures the expiration time of the token (nbf claim)
    ->set('uid', $userid)// Configures a new claim, called "uid"
    ->getToken(); // Retrieves the generated token

    return $token;
}

/**
 * check token
 * @param $token
 * @param $userid
 * @return bool
 */
function checkToken($token, $userid){
    $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
    $data->setIssuer('http://example.com');
    $data->setAudience('http://example.org');
    $data->setId('4f1g23a12aa');
//$token->getClaim('uid')
    return $token->validate($data); // false, because we created a token that cannot be used before of `time() + 60`
}