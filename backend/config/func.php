<?php
/**
 * Created by PhpStorm.
 * User: ys
 * Date: 2017/8/31
 * Time: 14:25
 */
function dd($data){
    echo '<pre>';
    print_r($data);die;
}
//生成21位订单号,强唯一
function createOrderNo21(){
    return date('Ymd').uniqidReal(13);//年月日+uniqidReal的13位值,长度是21位
}

//生成uniqid(for循环10000次,无重复)-强唯一,推荐使用这个做唯一值处理,如订单号
function uniqidReal($lenght = 13) {
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } else
        if (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new \Exception("no cryptographically secure random function available");
        }
    return substr(bin2hex($bytes), 0, $lenght);
}