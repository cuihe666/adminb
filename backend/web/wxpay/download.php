<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
define( 'IN_AMAP' , true );
require_once "lib/WxPay.Api.php";
require_once "lib/WxPay.Data.php";
$inc_path = dirname ( __FILE__ ) . '/';
require $inc_path . 'inc/init.php';
require $inc_path . 'inc/db_func.php';
		$input = new WxPayDownloadBill();
		$input->SetBill_date('20160827');
        $input->SetBill_type('SUCCESS');
		$result = WxPayApi::downloadBill($input);
$log = str_replace(","," ",$result);//,号替换成空白
$log = explode("`",$log);//根据`分割成数组
$k = 1;
$j = count($log)-6;
$Fornum = (count($log)-6)/6;
for($i=0;$i<$Fornum-1;$i++){
    for($s=$k;$s<$j;$s++){
        $data2[$i]['time'] = $log[$s];#交易时间
        $data2[$i]['ghid'] = $log[$s+1];#公众账号ID
        $data2[$i]['mchid'] = $log[$s+2];#商户号
        $data2[$i]['submch'] = $log[$s+3];#子商户号
        $data2[$i]['deviceid'] = $log[$s+4];#设备号
        $data2[$i]['wxorder'] = $log[$s+5];#微信订单号
        $data2[$i]['bzorder'] = $log[$s+6];#商户订单号
        $data2[$i]['openid'] = $log[$s+7];#用户标识
        $data2[$i]['tradetype'] = $log[$s+8];#交易类型
        $data2[$i]['tradestatus'] = $log[$s+9];#交易状态
        $data2[$i]['bank'] = $log[$s+10];#付款银行
        $data2[$i]['currency'] = $log[$s+11];#货币种类
        $data2[$i]['totalmoney'] = $log[$s+12];#总金额
        $data2[$i]['redpacketmoney'] = $log[$s+13];#企业红包总金额
        $data2[$i]['commodityname'] = $log[$s+14];#商品名称
        $data2[$i]['datapacket'] = $log[$s+15];#商户数据包
        $data2[$i]['fee'] = $log[$s+16];#手续费
        $data2[$i]['rate'] = $log[$s+17];#费率
        $k = $k+18;
        break;
    }
}
print_r($data2);

