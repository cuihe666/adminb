<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * @抹蜜post提交
 *
 */
class Submit extends Model
{
    public function sub_post($url, $data)
    {
        $login_curl = curl_init();
        //设置资源相关选项
        curl_setopt($login_curl, CURLOPT_URL, $url);
        curl_setopt($login_curl, CURLOPT_POST, 1);//当前是post请求
        curl_setopt($login_curl, CURLOPT_POSTFIELDS, $data);
        //获取返回的内容 不输出
        curl_setopt($login_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($login_curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($login_curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        //发出请求
        $interface = curl_exec($login_curl);
        //转换json返回的数据
        $json = json_decode($interface, true);
        return $json;
    }

    public function sub_wx_self($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    public function sub_get($url)
    {
        $interface = file_get_contents($url);
        //转换json返回的数据
        $json = json_decode($interface, true);
        return $json;
    }

    public function sub_post_arr($url, $data)
    {
        $login_curl = curl_init();
        //设置资源相关选项
        curl_setopt($login_curl, CURLOPT_URL, $url);
        curl_setopt($login_curl, CURLOPT_POST, 1);//当前是post请求
        curl_setopt($login_curl, CURLOPT_POSTFIELDS, $data);
        //获取返回的内容 不输出
        curl_setopt($login_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($login_curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        //发出请求
        $interface = curl_exec($login_curl);
        //转换json返回的数据
        $str = $interface;
        return $str;
    }
}