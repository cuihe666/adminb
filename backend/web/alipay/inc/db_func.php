<?php
if (!defined('IN_AMAP'))
    logger(302);

/**
 * 根据订单号、金额查询待支付订单
 *
 * @param $out_trade_no 订单号
 * @param $total_fee 金额
 * @return array
 */
function getOrder($out_trade_no, $total_fee)
{
    if (empty($out_trade_no) || empty($total_fee)) {
        return false;
    }
    global $empire;
    $list = $empire->select("select house_title,order_id,order_uid,house_id,house_uid,order_num,total,in_time,out_time,house_city,day from `order` where status = 0 and order_num = '" . $out_trade_no . "' and total = '" . $total_fee . "' limit 1");
    if (empty($list)) {
        return false;
    }
    return $list;
}

//根据订单号，金额查询待支付的旅游团订单
function get_travel_order($out_trade_no, $total_fee)
{
    if (empty($out_trade_no) || empty($total_fee)) {
        return false;
    }
    global $empire;
    $list = $empire->select("select * from `group_order` WHERE state=1 AND order_no='" . $out_trade_no . "' and actual_pay='" . intval($total_fee) . "' limit 1");
    if (empty($list)) {
        return false;
    }
    return $list;
}

//根据订单号，金额查询待支付的票务订单
function get_ticket_order($out_trade_no, $total_fee)
{
    if (empty($out_trade_no) || empty($total_fee)) {
        return false;
    }
    global $empire;
    $list = $empire->select("select * from `order_ticket` WHERE state=1 AND order_no='" . $out_trade_no . "' and total_price='" . intval($total_fee) . "' limit 1");
    if (empty($list)) {
        return false;
    }
    return $list;
}

function mysqli_db($house_id)
{
    $link = mysqli_connect('127.0.0.1', 'root', '123456', 'tangguo') or die('db error');
    mysqli_set_charset($link, 'UTF8');
    $sql1 = "select in_time,out_time,status,house_id,order_id,order_uid,house_title from `order` WHERE house_id={$house_id} AND (status=0 OR status=-1)";
    $res1 = mysqli_query($link, $sql1);
    if ($res1 && $res1->num_rows > 0) {
        while ($row = mysqli_fetch_array($res1, MYSQL_ASSOC)) {
            $arr[] = $row;
        }
        if (!empty($arr)) {
            $sql2 = "select not_time from house_disable where house_id={$house_id}";
            $res2 = mysqli_query($link, $sql2);
            if ($res2 && $res2->num_rows > 0) {
                $house_disable = $res2->fetch_assoc();
                $house_disable['not_time'] = ltrim($house_disable['not_time'], ',');
                $house_disable = explode(',', $house_disable['not_time']);
                foreach ($arr as $k => $v) {
                    $time = get_time($v['in_time'], $v['out_time']);
                    $bool = array_intersect($time, $house_disable);
                    if (!empty($bool)) {
                        $order_id[] = $v['order_id'];
                        $udata[] = $v;
                    }
                }
                foreach ($udata as $k => $v) {
                    $res3 = mysqli_query($link, "select account from user WHERE uid={$v['order_uid']}");
                    if ($res3 && $res3->num_rows > 0) {
                        $udata[$k]['account'] = $res3->fetch_row()[0];
                    }
                }
                if (!empty($order_id)) {
                    $order_id = implode(',', $order_id);
                    $sql3 = "update `order` set status=6,`describe`='房源被占用,订单已失效' WHERE order_id in(" . $order_id . ")";
                    mysqli_query($link, $sql3);
                    foreach ($udata as $k => $v) {
                        $content1 = sprintf(get_msg(200), $v['house_title']);
                        $content2 = sprintf(get_msg(201), $v['house_title']);
                        push_sms($v['account'], $content1);
                        send_sms($v['account'], $content2);
                    }
                }
            }
        }
    }
    mysqli_close($link);
}

function get_msg($num)
{
    $arr = array(
        200 => '【棠果旅居】您预订的%s被其他用户抢先预订，请重新寻找房源，给您带来的不便尽请谅解',
        201 => '【棠果旅居】您预订的%s被其他用户抢先预订，请登陆棠果APP重新寻找房源，给您带来的不便尽请谅解'
    );
    return $arr[$num];
}


function get_time($in_time, $out_time)
{
    $notTime = "";
    $arrTime = [];
    $strtotime_in = strtotime(str_replace(".", "-", $in_time));
    $strtotime_out = strtotime(str_replace(".", "-", $out_time));
    $day = intval(($strtotime_out - $strtotime_in) / 86400);
    for ($i = 0; $i < $day; $i++) {
        $t = date("Y.m.d", $strtotime_in + 86400 * $i);
        $notTime .= "," . $t;
        array_push($arrTime, $t);
    }
    return $arrTime;
}

/**
 * 更新order、house、house_ids
 * 写入pay
 *
 * @param $out_trade_no 订单号
 * @param $total_fee 金额
 * @param $trade_status 第三方状态
 * @param $house_id 房源ID
 * @param $trade_no 第三方订单号
 * @param $order_uid 下单人UID
 * @param $house_uid 房东UID
 * @param $plat 支付宝0微信1
 * @return bloon
 */
function upOrder($out_trade_no, $total_fee, $trade_status, $house_id, $in_time, $out_time, $trade_no, $order_uid, $house_uid, $plat)
{
    if (empty($out_trade_no) || empty($total_fee) || empty($house_id) || empty($in_time) || empty($out_time)) {
        return 607;
    }
    global $empire;
    $sql3 = "";
    //获取不可能用时间表
    $notTime = "";
    $arrTime = [];
    $strtotime_in = strtotime(str_replace(".", "-", $in_time));
    $strtotime_out = strtotime(str_replace(".", "-", $out_time));
    $day = intval(($strtotime_out - $strtotime_in) / 86400);
    $status_bool = 0;
    $stock_bool = 0;
    for ($i = 0; $i < $day; $i++) {
        $t = $strtotime_in + 86400 * $i;
        array_push($arrTime, $t);
    }
    foreach ($arrTime as $k => $v) {
        $bool = $empire->select("select * from special_status WHERE date_time=$v AND house_id=$house_id AND status=0 limit 1");
        if ($bool) {
            $status_bool = 1;
        }
    }
    foreach ($arrTime as $k => $v) {
        $bool = $empire->select("select * from special_stock WHERE date_time=$v AND house_id=$house_id AND stock=0 limit 1");
        if ($bool) {
            $stock_bool = 1;
        }
    }
    if ($status_bool == 1 || $stock_bool == 1) {
        return 601;
    }
    foreach ($arrTime as $k => $v) {
        $old_data = $empire->select("select * from special_stock WHERE date_time=$v AND house_id=$house_id AND stock>0 limit 1");
        $detault_stock = $empire->select("select totalStock from house WHERE house_id=$house_id limit 1");
        if ($old_data && !empty($old_data[0])) {
            if ($old_data[0]['stock'] - 1 == $detault_stock[0]['totalStock']) {
                $sql1 = "delete from special_stock WHERE id={$old_data[0]['id']}";
            } else {
                $new_stock = $old_data[0]['stock'] - 1;
                $sql1 = "update special_stock set stock=$new_stock WHERE id={$old_data[0]['id']}";
            }
        } else {
            $new_stock = $detault_stock[0]['totalStock'] - 1;
            $sql1 = "INSERT INTO `special_stock` (house_id,date_time,stock) VALUES ($house_id,$v,$new_stock)";
        }
    }
    mysql_query("BEGIN");
    //更新order表
    $ruzhu_time = strtotime(date("Y-m-d") . ' ' . '14:00');
    if ($in_time == date("Y.m.d", time()) && time() > $ruzhu_time) {
        $sql2 = "update `order` set status = 2, update_time = '" . time() . "', pay_time = '" . time() . "', Payment = 0 where order_num = '" . $out_trade_no . "'";
    } else {
        $sql2 = "update `order` set status = 1, update_time = '" . time() . "', pay_time = '" . time() . "', Payment = 0 where order_num = '" . $out_trade_no . "'";
    }
    //更新house
    $sql3 = "update house set sale = sale+1, status_update_time = '" . time() . "' where house_id = '" . $house_id . "'";
    //更新house_disable
    //更新 pay
    $sql4 = "INSERT INTO `pay` (order_id, order_num, plat,play_status,money,uid,profit_uid,type,ctime)
VALUES ('" . $trade_no . "', '" . $out_trade_no . "', $plat,'" . $trade_status . "','" . $total_fee . "',$order_uid,$house_uid,0," . time() . ")";
    $order_data = $empire->select("select order_id from `order` where order_num = '" . $out_trade_no . "' limit 1");
    $order_id = $order_data[0]['order_id'];
    $money = intval($total_fee);
    $sql5 = "INSERT INTO `account_detail` (user_id,money,ctime,type,event_id) VALUES ($order_uid,$money,'" . time() . "',3,$order_id)";
    $res = mysql_query($sql1);
    $res1 = mysql_query($sql2);
    $res2 = mysql_query($sql3);
    $res3 = mysql_query($sql4);
    $res4 = mysql_query($sql5);
    if ($res && $res1 && $res2 && $res3 && $res4) {
        mysql_query("COMMIT");
        mysql_query("END");
        return true;
    } else {
        mysql_query("ROLLBACK");
        mysql_query("END");
        return 608;
    }
}

//旅游团更新订单操作 trade_no 第三方订单号
function up_travel_order($out_trade_no, $total_fee, $trade_status, $trade_no, $msg)
{
    if (empty($out_trade_no) || empty($total_fee) || empty($trade_status) || empty($trade_no)) {
        return 607;
    }
    global $empire;
    mysql_query("BEGIN");
    $time = time();
    $date = date("Y-m-d H:i:s", $time);
    $msg = json_encode($msg);
    $sql1 = "update `group_order` set state=2,update_date=$time,trade_no='{$trade_no}' WHERE order_no='{$out_trade_no}' AND state=1";
    $sql2 = "insert into `order_flow_pay` (order_no,trade_no,trade_status,return_msg,total_fee,create_date,pay_type) VALUES ('{$out_trade_no}','{$trade_no}','{$trade_status}','{$msg}','{$total_fee}','{$date}',0)";
    $res1 = mysql_query($sql1);
    $res2 = mysql_query($sql2);
    if ($res1 && $res2) {
        mysql_query("COMMIT");
        mysql_query("END");
        return true;
    } else {
        mysql_query("ROLLBACK");
        mysql_query("END");
        return 608;
    }
}

//票务更新订单操作 trade_no 第三方订单号
function up_ticket_order($out_trade_no, $total_fee, $trade_status, $trade_no, $msg)
{
    if (empty($out_trade_no) || empty($total_fee) || empty($trade_status) || empty($trade_no)) {
        return 607;
    }
    global $empire;
    mysql_query("BEGIN");
    $time = time();
    $date = date("Y-m-d H:i:s", $time);
    $msg = json_encode($msg);
    $sql1 = "update `order_ticket` set state=2,trade_no='{$trade_no}' WHERE order_no='{$out_trade_no}' AND state=1";
    $sql2 = "insert into `order_flow_pay` (order_no,trade_no,trade_status,return_msg,total_fee,create_date,pay_type) VALUES ('{$out_trade_no}','{$trade_no}','{$trade_status}','{$msg}','{$total_fee}','{$date}',0)";
    $res1 = mysql_query($sql1);
    $res2 = mysql_query($sql2);
    if ($res1 && $res2) {
        mysql_query("COMMIT");
        mysql_query("END");
        return true;
    } else {
        mysql_query("ROLLBACK");
        mysql_query("END");
        return 608;
    }
}

/*
 * 有订单 & 退款操作
 */
function refunds($out_trade_no, $total_fee, $trade_status, $house_id, $in_time, $out_time, $trade_no, $order_uid, $house_uid, $plat)
{

    if (empty($out_trade_no) || empty($total_fee) || empty($house_id) || empty($in_time) || empty($out_time)) {
        return 607;
    }
    global $empire;
    mysql_query("BEGIN");
    $sql1 = "update `order` set status = 4 ,Payment=0, update_time = '" . time() . "' where order_num = '" . $out_trade_no . "'";
    $sql2 = "INSERT INTO `pay` (order_id, order_num, plat,play_status,money,uid,profit_uid,type,ctime)
VALUES ('" . $trade_no . "', '" . $out_trade_no . "', $plat,'','" . $total_fee . "',$order_uid,$house_uid,1," . time() . ")";
    //处理处理房源占用时间
    $arrTime = [];
    $strtotime_in = strtotime(str_replace(".", "-", $in_time));
    $strtotime_out = strtotime(str_replace(".", "-", $out_time));
    $day = intval(($strtotime_out - $strtotime_in) / 86400);
    for ($i = 0; $i < $day; $i++) {
        $t = $strtotime_in + 86400 * $i;
        array_push($arrTime, $t);
    }
    foreach ($arrTime as $k => $v) {
        $old_data = $empire->select("select * from special_stock WHERE date_time=$v AND house_id=$house_id AND stock>0 limit 1");
        $detault_stock = $empire->select("select totalStock from house WHERE house_id=$house_id limit 1");
        if ($old_data && !empty($old_data[0])) {
            if ($old_data[0]['stock'] + 1 == $detault_stock[0]['totalStock']) {
                $sql3 = "delete from special_stock WHERE id={$old_data[0]['id']}";
            } else {
                $new_stock = $old_data[0]['stock'] + 1;
                $sql3 = "update special_stock set stock=$new_stock WHERE id=$old_data[0]['id']";
            }
        } else {
            $new_stock = $detault_stock[0]['totalStock'] + 1;
            $sql3 = "INSERT INTO `special_stock` (house_id,date_time,stock) VALUES ($house_id,$v,$new_stock)";
        }
    }

    $res = mysql_query($sql1);
    $res1 = mysql_query($sql2);
    $res2 = mysql_query($sql3);
    if ($res && $res1 && $res2) {
        mysql_query("COMMIT");
        mysql_query("END");
        return true;
    } else {
        mysql_query("ROLLBACK");
        mysql_query("END");
        return 608;
    }
}

/*
 * 无订单 & 退款操作
 */
function notRefunds($out_trade_no, $trade_no, $total_fee, $trade_status, $plat)
{
    global $empire;
    $sql2 = "INSERT INTO `pay` (order_id, order_num, plat,play_status,money,type,ctime)
VALUES ('" . $trade_no . "', '" . $out_trade_no . "', $plat,'" . $trade_status . "','" . $total_fee . "',1," . time() . ")";
    mysql_query($sql2);
    return true;
}

//旅游团支付异常自动退款
function travel_refunds($out_trade_no, $total_fee)
{
    if (empty($out_trade_no) || empty($total_fee)) {
        return 607;
    }
    $time = time();
    $sql = "update `group_order` set state=4,update_date=$time WHERE order_no=$out_trade_no AND total_price=$total_fee";
    mysql_query($sql);
    return true;
}

//票务支付异常自动退款
function ticket_refunds($out_trade_no, $total_fee)
{
    if (empty($out_trade_no) || empty($total_fee)) {
        return 607;
    }
    $sql = "update `order_ticket` set state=4 WHERE order_no=$out_trade_no AND total_price=$total_fee";
    mysql_query($sql);
    return true;
}

function getUser($uid)
{
    global $empire;
    $user = $empire->select("select account from `user` WHERE uid=$uid limit 1");
    if (!$user) {
        return false;
    }
    return $user[0]['account'];
}

function getUserName($uid)
{
    global $empire;
    $user = $empire->select("select `name` from `user` WHERE uid=$uid limit 1");
    if (!$user) {
        return false;
    }
    return $user[0]['name'];
}

function getAddress($house_id)
{
    global $empire;
    $user = $empire->select("select address from `house` WHERE house_id=$house_id limit 1");
    if (!$user) {
        return false;
    }
    return $user[0]['address'];
}

function getHouseStartTime($house_id)
{
    global $empire;
    $house = $empire->select("select start_time from `house` WHERE house_id=$house_id limit 1");
    return $house[0]['start_time'];
}

function send_sms($mobile, $content)
{
    global $empire;
    $bool = $empire->select("select mobile from `verify_blocked` WHERE mobile={$mobile} limit 1");
    if ($bool) {
        return true;
    }

    $username = 'tgkj';
    $pwd = 'DKVxhO9z';
    $url = 'http://api.app2e.com/smsBigSend.api.php';
    $arr = array(
        'username' => $username,
        'pwd' => md5($pwd),
        'p' => $mobile,
        'msg' => $content,
        'charSetStr' => 'utf',
    );
    $res = http_post($url, $arr);
    $res = json_decode($res, true);
    if ($res['status'] == 100) {
        return true;
    } else {
        global $sms_msg;
        $msg = $sms_msg[$res['status']];
        $time = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `sms_error`(mobile,code,msg,ctime) VALUES ($mobile,{$res['status']},'{$msg}','{$time}')";
        mysql_query($sql);
        return false;
    }
}

function push_sms($account, $content = '123', $m_type = 'http', $m_txt = 'http://www.iqujing.com/', $m_time = '86400')
{
    $base64 = base64_encode("2b252282054b464e6643c822:18379bed1c1027f6980bfe4f");
    $header = array("Authorization:Basic $base64", "Content-Type:application/json");
    $data = array();
    $data['platform'] = 'all';          //目标用户终端手机的平台类型android,ios,winphone
    $data['audience'] = array('alias' => array($account));

    $data['notification'] = array(
        //统一的模式--标准模式
        "alert" => $content,
        //安卓自定义
        "android" => array(
            "alert" => $content,
            "title" => "",
            "builder_id" => 1,
            "extras" => array("type" => $m_type, "txt" => $m_txt)
        ),
        //ios的自定义
        "ios" => array(
            "alert" => $content,
            "badge" => "1",
            "sound" => "default",
            "extras" => array("type" => $m_type, "txt" => $m_txt)
        ),
    );

    //苹果自定义---为了弹出值方便调测
    $data['message'] = array(
        "msg_content" => $content,
        "extras" => array("type" => $m_type, "txt" => $m_txt)
    );

    //附加选项
    $data['options'] = array(
        "sendno" => time(),
        "time_to_live" => $m_time, //保存离线时间的秒数默认为一天
        "apns_production" => 0,        //指定 APNS 通知发送环境：0开发环境，1生产环境。
    );
    $param = json_encode($data);
    $res = push_curl($param, $header);
    if ($res) {
        //得到返回值--成功已否后面判断
        return $res;
    } else {          //未得到返回值--返回失败
        return false;
    }
}

//推送的Curl方法
function push_curl($param = "", $header = "")
{
    if (empty($param)) {
        return false;
    }
    $postUrl = "https://api.jpush.cn/v3/push";
    $curlPost = $param;
    $ch = curl_init();                                      //初始化curl
    curl_setopt($ch, CURLOPT_URL, $postUrl);                 //抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);           // 增加 HTTP Header（头）里的字段
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    $data = curl_exec($ch);                                 //运行curl
    curl_close($ch);
    return $data;
}


function http_post($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

