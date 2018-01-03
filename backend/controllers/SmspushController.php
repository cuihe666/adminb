<?php

namespace app\controllers;

use Yii;

class SmspushController extends \yii\web\Controller
{
    /***** 短信推送 *******/
    public static function sendSms($mobile, $content, $country_code = '86')
    {
        if ($country_code == '86') {
            $username = USER_GUONEI;
            $pwd = PWD_GUONEI;
            $url = "http://sms.253.com/msg/send?un={$username}&pw={$pwd}&phone={$mobile}&msg={$content}&rd=1";
            $res = self::_request($url);
            $res_arr = self::execResult($res);
            if (isset($res_arr[1]) && $res_arr[1] == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $mobile = $country_code . $mobile;
            $username = USER_GUOWAI;
            $pwd = PWD_GUOWAI;
            $isreport = 1;
            $param = 'un=' . $username . '&pw=' . $pwd . '&sm=' . urlencode($content) . '&da=' . $mobile . '&rd=' . $isreport . '&rf=2&tf=3';
            $url = 'http://222.73.117.140:8044/mt' . '?' . $param;//单发接口
            $res = self::_request($url);
            $res_arr = json_decode($res, true);
            if (array_key_exists('r', $res_arr)) {
                $error_time = date("Y-m-d H:i:s", time());
                Yii::$app->db->createCommand("insert into sms_error(mobile,code,ctime) VALUES ('{$mobile}',{$res_arr['r']},'{$error_time}')")->execute();
                return false;
            } else {
                return true;
            }
        }
    }
    public static function execResult($result)
    {
        $result = preg_split("/[,\r\n]/", $result);
        return $result;
    }
    public static function _request($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}