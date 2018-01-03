<?php
ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);
require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';
/*DB*/
define('IN_AMAP', true);
$inc_path = dirname(__FILE__) . '/';
require $inc_path . 'inc/init.php';
require $inc_path . 'inc/db_func.php';
require $inc_path . 'inc/config.php';
$link = db_connect();
$empire = new mysqlquery();

/****解析XML*****/
$msg = array();
$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
if (empty($postStr)) {
    putXml(0, "未获取到数据");
}
$msg = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
$transaction_id = $msg['transaction_id'];
$out_trade_no = $msg['out_trade_no'];
$total_fee = $msg['total_fee'];
$trade_status = $msg['result_code'];
/****解析XML*****/
if (empty($transaction_id) || empty($out_trade_no) || empty($total_fee)) {
    putXml(0, "缺少参数");
}

$input = new WxPayOrderQuery();
$input->SetTransaction_id($transaction_id);
$result = WxPayApi::orderQuery($input);
if (array_key_exists("return_code", $result)
    && array_key_exists("result_code", $result)
    && $result["return_code"] == "SUCCESS"
    && $result["result_code"] == "SUCCESS"
) {
    $first = substr($out_trade_no, 0, 1);
    if (intval($first) == 9) {
        $total_fee = $total_fee / 100;
        $order = getOrder($out_trade_no, $total_fee);
        if (empty($order)) {
//            $refund=notRefunds($out_trade_no, $transaction_id, $total_fee, $trade_status, 1);
            logger(600, $out_trade_no, $trade_status, $msg, $ok);
            putXml(1, "订单失效");
        } else {
            $order = $order[0];
            $plat = 1;
            $update = upOrder($out_trade_no, $total_fee, $trade_status, $order['house_id'], $order['in_time'], $order['out_time'], $transaction_id, $order['order_uid'], $order['house_uid'], $plat);
            if ($update === true) {
//            mysqli_db($order['house_id']);
                $ok = 'success';
                $order_account = getUser($order['order_uid']);
                $house_user = getUser($order['house_uid']);
                $name = getUserName($order['order_uid']);
                $address = getAddress($order['house_id']);
                $back_time = strtotime(str_replace(".", "-", $order['in_time']) . ' ' . getHouseStartTime($order['house_id']) . ":00");
                $content1 = sprintf($smsconfig[300], $name, $order['in_time'], $order['house_city'], $order['house_title'], $order['day'], $order['total'], date("Y-m-d H:i:s", $back_time - 72 * 3600), $address, $house_user);
                $content2 = sprintf($smsconfig[400], $order['order_num'], $order['in_time'], $order['out_time'], $order['house_title'], $order_account);
                $res1 = send_sms($order_account, $content1);
                $res2 = send_sms1($house_user, $content2);
                logger('wxpay-success', $out_trade_no, $trade_status, $msg, $ok);
                echo 'SUCCESS';die;
//                putXml(1, "SUCCESS");
            } else {
                $bool = refunds($out_trade_no, $total_fee, $trade_status, $order['house_id'], $order['in_time'], $order['out_time'], $transaction_id, $order['order_uid'], $order['house_uid'], 1);
                logger($update, $out_trade_no, $trade_status, $msg, $ok);
                putXml(1, "支付失败");
            }
        }
    }elseif(intval($first) == 8){
        $total_fee = $total_fee / 100;
        $travel_order = get_travel_order($out_trade_no, $total_fee);
        if(empty($travel_order)){
//            travel_refunds($out_trade_no, $transaction_id, $total_fee, $trade_status, 1);
            logger(600, $out_trade_no, $trade_status, $msg);
            putXml(0, "订单失效");
        }else{
            $travel_order=$travel_order[0];
            $update=up_travel_order($out_trade_no,$total_fee,$trade_status,$transaction_id,$msg);
            if($update===true){
                $order_account = getUser($travel_order['order_uid']);
                $content=sprintf($smsconfig[500],$travel_order['group_name']);
                send_sms($order_account,$content);
                $ok='success';
                logger('wxpay-success', $out_trade_no, $trade_status, $msg, $ok);
                putXml(1, "OK");
            }else{
                travel_refunds($out_trade_no,$total_fee);
                logger($update, $out_trade_no, $trade_status, $msg, $ok);
                putXml(0, "支付失败");
            }
        }
    }else{
        $total_fee = $total_fee / 100;
        $ticket_order = get_ticket_order($out_trade_no, $total_fee);
        if(empty($ticket_order)){
//            travel_refunds($out_trade_no, $transaction_id, $total_fee, $trade_status, 1);
            logger(600, $out_trade_no, $trade_status, $msg);
            putXml(0, "订单失效");
        }else{
            $ticket_order=$ticket_order[0];
            $update=up_ticket_order($out_trade_no,$total_fee,$trade_status,$transaction_id,$msg);
            if($update===true){
                $order_account = getUser($ticket_order['uid']);
                $content=sprintf($smsconfig[500],$ticket_order['spot_name']);
                send_sms($order_account,$content);
                $ok='success';
                logger('wxpay-success', $out_trade_no, $trade_status, $msg, $ok);
                putXml(1, "SUCCESS");
            }else{
                ticket_refunds($out_trade_no,$total_fee);
                logger($update, $out_trade_no, $trade_status, $msg, $ok);
                putXml(0, "支付失败");
            }
        }
    }
} else {
    putXml(0, "WX查询订单失败");
}

function putXml($ok = 0, $msg = "未知错误")
{
    header("Content-Type: text/plain");
    $ok = $ok == 0 ? "FAIL" : "SUCCESS";
    $xml = "<xml>
  <return_code><![CDATA[{$ok}]]></return_code>
  <return_msg><![CDATA[{$msg}]]></return_msg>
</xml>";
    echo $xml;
}


db_close();
$empire = null;
