<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */
require_once ( "alipay.config.php" );
require_once ( "lib/alipay_notify.class.php" );
/*DB*/
define( 'IN_AMAP' , true );
$inc_path = dirname ( __FILE__ ) . '/';
require $inc_path . 'inc/init.php';
require $inc_path . 'inc/db_func.php';
require $inc_path . 'inc/config.php';
$link = db_connect ();
$empire = new mysqlquery();
$out_trade_no = $trade_no = $trade_status = "";
//计算得出通知验证结果
$alipayNotify = new AlipayNotify( $alipay_config );
$verify_result = $alipayNotify->verifyNotify ();
$ok = "fail";
if ( $verify_result ) {
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//商户订单号
	$out_trade_no = addslashes($_POST[ 'out_trade_no' ] );
	//支付宝交易号
	$trade_no = addslashes ( $_POST[ 'trade_no' ] );
	//交易状态
	$trade_status = addslashes ( $_POST[ 'trade_status' ] );
	if ( empty( $out_trade_no ) || empty( $trade_no ) || empty( $trade_status ) ) {
		logger(603,$out_trade_no , $trade_status , $_POST , $ok);
		notRefunds ( $out_trade_no ,$trade_no, $total_fee , $trade_status,0);
	} else {
		if ( $trade_status == 'TRADE_FINISHED' ) {
		} else if ( $trade_status == 'TRADE_SUCCESS' ) {
			$first = substr($out_trade_no, 0, 1);
			if (intval($first) == 9) {
				$total_fee = addslashes($_POST['total_fee']);
				$order = getOrder($out_trade_no, $total_fee);
				if (empty($order)) {
					notRefunds($out_trade_no, $trade_no, $total_fee, $trade_status, 0);
					logger(600, $out_trade_no, $trade_status, $_POST, $ok);
				} else {
					$order = $order[0];
					$plat = 0;
					$update = upOrder($out_trade_no, $total_fee, $trade_status, $order['house_id'], $order['in_time'], $order['out_time'], $trade_no, $order['order_uid'], $order['house_uid'], $plat);
					if ($update === true) {
						$ok = 'success';
						$order_account = getUser($order['order_uid']);
						$house_user = getUser($order['house_uid']);
						$name = getUserName($order['order_uid']);
						$address = getAddress($order['house_id']);
						$back_time = strtotime(str_replace(".", "-", $order['in_time']) . ' ' . getHouseStartTime($order['house_id']) . ":00");
						$content1 = sprintf($smsconfig[300], $name, $order['in_time'], $order['house_city'], $order['house_title'], $order['day'], $order['total'], date("Y-m-d H:i:s", $back_time - 72 * 3600), $address, $house_user);
						$content2 = sprintf($smsconfig[400], $order['order_num'], $order['in_time'], $order['out_time'], $order['house_title'], $order_account);
						$res1 = send_sms($order_account, $content1);
						$res2 = send_sms($house_user, $content2);
						logger('alipay-success', $out_trade_no, $trade_status, $_POST, $ok);
					} else {
						refunds($out_trade_no, $total_fee, $trade_status, $order['house_id'], $order['in_time'], $order['out_time'], $trade_no, $order['order_uid'], $order['house_uid'], 0);
						logger($update, $out_trade_no, $trade_status, $_POST, $ok);
					}
				}
			}elseif(intval($first) == 8){
				$total_fee = addslashes($_POST['total_fee']);
				$travel_order = get_travel_order($out_trade_no, $total_fee);
				if(empty($travel_order)){
//            travel_refunds($out_trade_no, $transaction_id, $total_fee, $trade_status, 1);
					logger(601, $out_trade_no, $trade_status, $msg);
				}else{
					$travel_order=$travel_order[0];
					$update=up_travel_order($out_trade_no,$total_fee,$trade_status,$trade_no,$_POST);
					if($update===true){
						$order_account = getUser($travel_order['order_uid']);
						$content=sprintf($smsconfig[500],$travel_order['group_name']);
						send_sms($order_account,$content);
						$ok='success';
						logger('alipay-success', $out_trade_no, $trade_status, $_POST, $ok);
					}else{
						travel_refunds($out_trade_no,$total_fee);
						logger($update, $out_trade_no, $trade_status, $msg, $ok);
					}
				}
			}else{
				$total_fee = addslashes($_POST['total_fee']);
				$ticket_order = get_ticket_order($out_trade_no, $total_fee);
				if(empty($ticket_order)){
//            travel_refunds($out_trade_no, $transaction_id, $total_fee, $trade_status, 1);
					logger(601, $out_trade_no, $trade_status, $msg);
				}else{
					$ticket_order=$ticket_order[0];


					$update=up_ticket_order($out_trade_no,$total_fee,$trade_status,$trade_no,$_POST);
					if($update===true){
						$order_account = getUser($ticket_order['uid']);
						$content=sprintf($smsconfig[500],$ticket_order['spot_name']);
						send_sms($order_account,$content);
						$ok='success';
						logger('alipay-success', $out_trade_no, $trade_status, $_POST, $ok);
					}else{
						ticket_refunds($out_trade_no,$total_fee);
						logger($update, $out_trade_no, $trade_status, $msg, $ok);
					}
				}
			}
		}
	}

} else {
	$ok = "fail";
	logger (606, $out_trade_no , $trade_status , $_POST , $ok );
}
echo $ok;
db_close ();
$empire = null;
?>