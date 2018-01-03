<?php
namespace backend\service;
use Yii;
/**
 * 异步请求的service
 */
class AsyncRequestService
{
    /**
     * curl发送HTTP请求
     *
     * @param string $url 请求地址
     * @param array  $data 发送数据
     * @param string $method 请求方式 GET/POST，默认的是GET请求
     * @param string $contentType
     * @param string $timeout
     * @param string $proxy
     * @param string $refererUrl 请求来源地址
     * @return boolean
     */
    public static function send_request($url, $data, $method = 'GET', $contentType = 'application/json', $timeout= 30, $proxy = false, $refererUrl = ''){
        $ch = null;
        if('POST' === strtoupper($method)) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER,0 );
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            if ($refererUrl) {
                curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
            }
            if($contentType) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:'.$contentType));
            }
            if(is_string($data)){
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
        } else if('GET' === strtoupper($method)) {
            if(is_string($data)) {
                $real_url = $url. (strpos($url, '?') === false ? '?' : ''). $data;
            } else {
                $real_url = $url. (strpos($url, '?') === false ? '?' : ''). http_build_query($data);
            }
            $ch = curl_init($real_url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:'.$contentType));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            if ($refererUrl) {
                curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
            }
        } else {
            $args = func_get_args();
            return false;
        }

        if($proxy) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        $ret = curl_exec($ch);
        $info = curl_getinfo($ch);
        $contents = array(
                'httpInfo' => array(
                        'send' => $data,
                        'url' => $url,
                        'ret' => $ret,
                        'http' => $info,
                )
        );

        curl_close($ch);
        return $ret;
    }

    /**
     * file_get_contents()模拟get请求
     * @param $url
     * @param $params
     * @return string
     */
    public static function requestGet($url, $params){
        //把参数转换成URL数据
        $params = http_build_query($params);
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $params,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url,false,$context);
        return $result;
    }

    /**
     * file_get_contents()模拟post请求
     * @param $url
     * @param $params
     * @return string
     */
    public static function requestPost($url, $params){
        //把参数转换成URL数据
        $params = http_build_query($params);
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $params,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

}


