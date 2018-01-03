<?php
ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);

require_once "lib/WxPay.Api.php";
require_once "lib/WxPay.Data.php";
define('IN_AMAP', true);
$inc_path = dirname(__FILE__) . '/';
require $inc_path . 'inc/init.php';
require $inc_path . 'inc/db_func.php';
$link = db_connect();
$empire = new mysqlquery();
$config = new WxPayConfig();
$wxdatabase = new WxPayDataBase();
$wxapi = new WxPayApi();
$rs = array(
    "error" => [
        "returnCode" => 1,
        "returnMessage" => "",
        "returnUserMessage" => "查询错误"
    ],
    "data" => []
);
$body = addslashes($_POST['body']);
$out_trade_no = addslashes($_POST['out_trade_no']);
$total_fee = addslashes($_POST['total_fee']);
$ok = 'fail';
if (empty($body) || empty($out_trade_no) || empty($total_fee)) {
    $rs['error']['returnCode'] = 2;
    $rs['error']['returnUserMessage'] = "缺少参数";
} else {
    $first = substr($out_trade_no, 0, 1);
    if (intval($first) == 9) {
        $order = getOrder($out_trade_no, $total_fee);
        if (empty($order)) {
            logger(600, $out_trade_no, "WX_UNIFIEDORDER1", $_POST, $ok);
        } else {
            //统一下单
            $input = new WxPayUnifiedOrder();
            $input->SetBody($body);
            //$input->SetAttach("test");
            $input->SetOut_trade_no($out_trade_no);
            $input->SetTotal_fee($total_fee * 100);
            //$input->SetTime_start(date("YmdHis"));
            //$input->SetTime_expire(date("YmdHis", time() + 600));
            //$input->SetGoods_tag("test");
            $input->SetNotify_url("http://api.tgljweb.com/wxpay/notify.php");
            $input->SetTrade_type("APP");
            $input->SetSpbill_create_ip(get_client_ip());
            $input->SetDetail($order[0]['house_title']);
            //$input->SetOpenid($openId);
            //$input->SetProduct_id($product_id);

            $result = WxPayApi::unifiedOrder($input);
            if (!array_key_exists("appid", $result) ||
                !array_key_exists("mch_id", $result) ||
                !array_key_exists("prepay_id", $result)
            ) {
                $rs['error']['returnCode'] = 1;
                $rs['error']['returnUserMessage'] = "统一下单失败";
                logger(600, $out_trade_no, "WX_SERVER_ERROR", $result, $ok);
            } else {
                $rs['error']['returnCode'] = 0;
                $rs['error']['returnUserMessage'] = "统一下单成功";
                $ok = 'success';
                $rs['data'] = $result;
                $rs['data']['title'] = $order[0]['house_title'];
                logger('wx-success', $out_trade_no, "WX_UNIFIEDORDER2", $result, $ok);
            }
        }
    } elseif(intval($first) == 8){
        $travel_order = get_travel_order($out_trade_no, $total_fee);
        if (empty($travel_order)) {
            logger(600, $out_trade_no, "WX_UNIFIEDORDER", $_POST, $ok);
        } else {
            //统一下单
            $input = new WxPayUnifiedOrder();
            $input->SetBody($body);
            //$input->SetAttach("test");
            $input->SetOut_trade_no($out_trade_no);
            $input->SetTotal_fee($total_fee * 100);
            //$input->SetTime_start(date("YmdHis"));
            //$input->SetTime_expire(date("YmdHis", time() + 600));
            //$input->SetGoods_tag("test");
            $input->SetNotify_url("http://api.tgljweb.com/wxpay/notify.php");
            $input->SetTrade_type("APP");
            $input->SetSpbill_create_ip(get_client_ip());
            $input->SetDetail($travel_order[0]['group_name']);
            //$input->SetOpenid($openId);
            //$input->SetProduct_id($product_id);

            $result = WxPayApi::unifiedOrder($input);
            if (!array_key_exists("appid", $result) ||
                !array_key_exists("mch_id", $result) ||
                !array_key_exists("prepay_id", $result)
            ) {
                $rs['error']['returnCode'] = 1;
                $rs['error']['returnUserMessage'] = "统一下单失败";
                logger(600, $out_trade_no, "WX_SERVER_ERROR", $result, $ok);
            } else {
                $rs['error']['returnCode'] = 0;
                $rs['error']['returnUserMessage'] = "统一下单成功";
                $ok = 'success';
                $rs['data'] = $result;
                $rs['data']['title'] = $travel_order[0]['group_name'];
                logger('wx-success', $out_trade_no, "WX_UNIFIEDORDER", $result, $ok);
            }
        }
    }else{
        $ticket_order = get_ticket_order($out_trade_no, $total_fee);
        if (empty($ticket_order)) {
            logger(600, $out_trade_no, "WX_UNIFIEDORDER", $_POST, $ok);
        } else {
            //统一下单
            $input = new WxPayUnifiedOrder();
            $input->SetBody($body);
            //$input->SetAttach("test");
            $input->SetOut_trade_no($out_trade_no);
            $input->SetTotal_fee($total_fee * 100);
            //$input->SetTime_start(date("YmdHis"));
            //$input->SetTime_expire(date("YmdHis", time() + 600));
            //$input->SetGoods_tag("test");
            $input->SetNotify_url("http://api.tgljweb.com/wxpay/notify.php");
            $input->SetTrade_type("APP");
            $input->SetSpbill_create_ip(get_client_ip());
            $input->SetDetail($ticket_order[0]['spot_name']);
            //$input->SetOpenid($openId);
            //$input->SetProduct_id($product_id);

            $result = WxPayApi::unifiedOrder($input);
            if (!array_key_exists("appid", $result) ||
                !array_key_exists("mch_id", $result) ||
                !array_key_exists("prepay_id", $result)
            ) {
                $rs['error']['returnCode'] = 1;
                $rs['error']['returnUserMessage'] = "统一下单失败";
                logger(600, $out_trade_no, "WX_SERVER_ERROR", $result, $ok);
            } else {
                $rs['error']['returnCode'] = 0;
                $rs['error']['returnUserMessage'] = "统一下单成功";
                $ok = 'success';
                $rs['data'] = $result;
                $rs['data']['title'] = $ticket_order[0]['spot_name'];
                logger('wx-success', $out_trade_no, "WX_UNIFIEDORDER", $result, $ok);
            }
        }
    }
}
echo json_encode($rs);

function get_client_ip()
{
    if ($_SERVER['REMOTE_ADDR']) {
        $cip = $_SERVER['REMOTE_ADDR'];
    } elseif (getenv("REMOTE_ADDR")) {
        $cip = getenv("REMOTE_ADDR");
    } elseif (getenv("HTTP_CLIENT_IP")) {
        $cip = getenv("HTTP_CLIENT_IP");
    } else {
        $cip = "123.12.12.123";
    }
    return $cip;
}


db_close();
$empire = null;
