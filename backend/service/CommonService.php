<?php

namespace backend\service;

use backend\config\Consts;


class CommonService
{
    const APPID = 'wx373b9fece4c811d0';
    const MCHID = '1368449102';
    const KEY = 'tglj1593571415926535897932384626';

    public static function get_city_name($id)
    {

        $data = \Yii::$app->redis->get('city_new_name');
        if (!$data) {
            $city_data = \Yii::$app->db->createCommand("select * from dt_city_seas")->queryAll();
            $key = array_column($city_data, 'code');
            $value = array_column($city_data, 'name');
            $data = array_combine($key, $value);
            $arr = serialize($data);
            \Yii::$app->redis->set('city_new_name', $arr);
            return $data[$id];
        }
        $data = unserialize($data);
        $bool = array_key_exists($id, $data);
        if (!$bool) {
            return '';
        }
        return $data[$id];
    }

    public static function get_city_code($city_name)
    {
        $data = \Yii::$app->db->createCommand("select * from dt_city_seas WHERE name LIKE '%{$city_name}%' AND (level=2 OR level=3)")->queryAll();
        if (!$data) {
            return false;
        }
        return $data;
    }

    public static function get_city_code1($city_name)
    {
        $data = \Yii::$app->db->createCommand("select * from dt_city_seas WHERE name LIKE '%{$city_name}%' AND level=2")->queryOne();
        if (!$data) {
            return false;
        }
        return $data['code'];
    }


    public static function get_uid($account)
    {
        $uid = \Yii::$app->db->createCommand("select id from user WHERE mobile=$account")->queryScalar();
        if (!$uid) {
            return false;
        }
        return $uid;
    }

    //三级联动获得省

    public static function get_province()
    {
        $data = \Yii::$app->db->createCommand("select code,name  from `dt_city` WHERE parent=0")->queryAll();
        return $data;
    }

//    通过省传入的code 获得市
    public static function get_city($id = 0)
    {

        $data = \Yii::$app->db->createCommand("select code,name  from `dt_city` WHERE parent={$id}")->queryAll();
        return $data;
    }

    public static function get_client_ip($type = 0, $adv = false)
    {
        $type = $type ? 1 : 0;
        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) unset($arr[$pos]);
                $ip = trim($arr[0]);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
            if ($ip == '127.0.0.1') {
                $ip = self::get_client_ip(0, true);
            }
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }


    //微信退款
    public static function wxreturn($transaction_id, $total_fee, $refund_fee, $order_num)
    {
        $input = new \WxPayRefund();
        $input->SetTransaction_id($transaction_id);
        $input->SetTotal_fee($total_fee * 100);
        $input->SetRefund_fee($refund_fee * 100);
        $input->SetOut_refund_no($order_num . '_' . time());
        $input->SetOp_user_id(\WxPayConfig::MCHID);
        $input->SetRefund_account('REFUND_SOURCE_RECHARGE_FUNDS');
        return \WxPayApi::refund($input);
    }

//    //微信退款(旅游H5花期退款)
    public static function wxtravelruturn($transaction_id, $total_fee, $refund_fee, $order_num)
    {
        $url = 'http://106.14.16.252:9966/order/wxreturn';
        $data = [
            'transaction_id' => $transaction_id,
            'total_fee' => $total_fee,
            'refund_fee' => $refund_fee,
            'order_num' => $order_num
        ];
        return self::curl($url, $data);
    }


    public static function wxqueryrefund($transaction_id)
    {
        $input = new \WxPayRefundQuery();
        $input->SetTransaction_id($transaction_id);
        return \WxPayApi::refundQuery($input);
    }

    public static function wxquery($transaction_id)
    {
        $input = new \WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        return \WxPayApi::orderQuery($input);
    }

    //支付宝退款
    public static function alipayreturn($transaction_id, $total)
    {
        $aop = new \AopClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = ALIPAY_APPID;
//        $aop->rsaPrivateKeyFilePath='./alipay/key/rsa_private_key.pem';
        $aop->alipayrsaPublicKey=ALIPAY_PUBLIC_KEY;
//        $aop->appId = '2016121904424825';
        $aop->rsaPrivateKey = ALIPAY_PRIVATE_KEY;
//        $aop->alipayrsaPublicKey = Consts::ALIPAY_PUBLIC_KEY;
        $aop->signType = 'RSA';
        $aop->format = 'json';
        $request = new \AlipayTradeRefundRequest();
        $arr = ['trade_no' => $transaction_id, 'refund_amount' => $total, 'out_request_no' => $transaction_id . '_' . time()];
        $request->setBizContent(json_encode($arr));
        $result = $aop->execute($request);
        return $result;
    }

    //打款到支付宝账户
    //$settle_id:结算单号  $account:支付宝账号  $total:结算金额   $remark:转账备注
    public static function alipaytransfer($settle_id, $account, $total, $remark, $name)
    {
        $aop = new \AopClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = '2016121904424825';
        $aop->rsaPrivateKey = Consts::ALIPAY_PRIVATE_KEY;
        $aop->alipayrsaPublicKey = Consts::ALIPAY_PUBLIC_KEY;
        $aop->signType = 'RSA';
        $aop->format = 'json';
        $request = new \AlipayFundTransToaccountTransferRequest();
        $arr = ['out_biz_no' => $settle_id, 'payee_type' => 'ALIPAY_LOGONID', 'payee_account' => $account, 'amount' => $total, 'remark' => $remark, 'payee_real_name' => $name];
        $request->setBizContent(json_encode($arr));
        $result = $aop->execute($request);
        return $result;
    }

    //支付宝转账查询
    //$order_id:第三方返回来流水号
    public static function alipayQuery($order_id)
    {
        $aop = new \AopClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = '2016121904424825';
        $aop->rsaPrivateKey = Consts::ALIPAY_PRIVATE_KEY;
        $aop->alipayrsaPublicKey = Consts::ALIPAY_PUBLIC_KEY;
        $aop->signType = 'RSA';
        $aop->format = 'json';
        $request = new \AlipayFundTransOrderQueryRequest ();
        $arr = ['order_id' => $order_id];
        $request->setBizContent(json_encode($arr));
        $result = $aop->execute($request);
        return $result;
    }


    //生成结算id
    public static function create_settlement($uid)
    {
        return $uid . time() . mt_rand(1000, 9999);
    }

    /**
     * 行为日志方法
     * @param int $user_id 用户id
     * @param int $admin_id 管理员id
     * @param string $table 表名
     * @param int $record_id 操作数据id
     * @param string $remark 日志备注
     */
    public static function log($user_id = 0, $admin_id = 0, $table = '', $record_id = 0, $remark = '', $node = '')
    {
        $time = time();
        return \Yii::$app->db->createCommand("insert into admin_log(user_id,admin_id,table_name,record_id,remark,create_time,node) VALUES ($user_id,$admin_id,'{$table}',$record_id,'{$remark}',$time,'{$node}')")->execute();
    }

    public static function curl($url, $data, $header = false, $method = "POST")
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $ret = curl_exec($ch);
        return $ret;
    }


    public static function sub_post($url, $data)
    {
        $login_curl = curl_init();
        //设置资源相关选项
        curl_setopt($login_curl, CURLOPT_URL, $url);
        curl_setopt($login_curl, CURLOPT_POST, 1);//当前是post请求
        curl_setopt($login_curl, CURLOPT_POSTFIELDS, $data);
        //获取返回的内容 不输出
        curl_setopt($login_curl, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($login_curl, CURLOPT_HTTPHEADER, array(
//                'Content-Type: application/json',
//                'Content-Length: ' . strlen($data))
//        );
        //发出请求
        $interface = curl_exec($login_curl);
        return $interface;
    }

    /**
     * 获取两个日期之间的所有日期
     */
    public static function getDate($start, $end)
    {
        $dt_start = strtotime($start);
        $dt_end = strtotime($end);
        while ($dt_start <= $dt_end) {
            $arr[] = date('Y-m-d', $dt_start);
            $dt_start = strtotime('+1 day', $dt_start);
        }
        return $arr;
    }

    public static function getcountry()
    {
        $prolist = \Yii::$app->db->createCommand("select name,code,time_zone from dt_city_seas where level = 0 AND display=1")->queryAll();

        ?>
        <option value="0">请选择国家</option>
        <?php
        foreach ($prolist as $v) {
            ?>
            <option time_zone="<?= $v['time_zone'] ? $v['time_zone'] : '' ?>"
                    value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

        }

    }

    public static function updatecountry($id)
    {
        if ($id != 10001) {
            $prolist = \Yii::$app->db->createCommand("select name,code,time_zone from dt_city_seas where level = 0 AND seas=1 AND display=1")->queryAll();
        } else {
            $prolist = \Yii::$app->db->createCommand("select name,code,time_zone from dt_city_seas where level = 0 AND seas=0 AND display=1")->queryAll();
        }
        ?>
        <?php
        foreach ($prolist as $v) {
            ?>
            <option time_zone="<?= $v['time_zone'] ? $v['time_zone'] : '' ?>" <?php if ($id == $v['code']) {
                echo 'selected';
            } ?> value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

        }

    }

    public static function updateprovince($id = 0, $national)
    {

        $prolist = \Yii::$app->db->createCommand("select name,code from dt_city_seas where parent=$national AND level=1")->queryAll();
        ?>
        <?php

        foreach ($prolist as $v) {
            ?>
            <option <?php if ($id == $v['code']) {
                echo 'selected';
            } ?> value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

        }

    }

    public static function updatecity($id = 0, $province)
    {

        $prolist = \Yii::$app->db->createCommand("select name,code from dt_city_seas where parent=$province AND level=2")->queryAll();
        ?>
        <?php

        foreach ($prolist as $v) {
            ?>
            <option <?php if ($id == $v['code']) {
                echo 'selected';
            } ?> value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

        }

    }

    public static function updatearea($id = 0, $city)
    {

        $prolist = \Yii::$app->db->createCommand("select name,code from dt_city_seas where parent=$city AND level=3")->queryAll();
        ?>
        <?php

        foreach ($prolist as $v) {
            ?>
            <option <?php if ($id == $v['code']) {
                echo 'selected';
            } ?> value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

        }

    }

    public function actionGetprovince($id = 0)
    {
        if ($id == '') {
            return '<option value="0">请选择省份</option>';
        }

        $prolist = \Yii::$app->db->createCommand("select name,code from dt_city_seas where parent={$id}")->queryAll();
        ?>
        <option value="0">请选择省份</option>
        <?php

        foreach ($prolist as $v) {
            ?>
            <option value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php

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

    public static function sendSms($mobile, $content, $country_code = '86')
    {
        if ($country_code == '86') {
            $username = Consts::USER_GUONEI;
            $pwd = Consts::PWD_GUONEI;
            $url = "http://sms.253.com/msg/send?un={$username}&pw={$pwd}&phone={$mobile}&msg={$content}&rd=1";
            $res = self::_request($url);
            $res_arr = self::execResult($res);
            if (isset($res_arr[1]) && $res_arr[1] == 0) {
                return true;
            } else {
//                $error_time = date("Y-m-d H:i:s", time());
//                \Yii::$app->db->createCommand("insert into sms_error(mobile,code,ctime) VALUES ('{$mobile}',$res_arr[1],'{$error_time}')")->execute();
                return false;
            }
        } else {
            $mobile = $country_code . $mobile;
            $username = Consts::USER_GUOWAI;
            $pwd = Consts::PWD_GUOWAI;
            $isreport = 1;
            $param = 'un=' . $username . '&pw=' . $pwd . '&sm=' . urlencode($content) . '&da=' . $mobile . '&rd=' . $isreport . '&rf=2&tf=3';
            $url = 'http://222.73.117.140:8044/mt' . '?' . $param;//单发接口
            $res = self::_request($url);
            $res_arr = json_decode($res, true);
            if (array_key_exists('r', $res_arr)) {
//                $error_time = date("Y-m-d H:i:s", time());
//                Yii::$app->db->createCommand("insert into sms_error(mobile,code,ctime) VALUES ('{$mobile}',{$res_arr['r']},'{$error_time}')")->execute();
                return false;
            } else {
                return true;
            }
        }
    }

    public static function get_goods_num()
    {
        return '0901' . date('Ymd') . mt_rand(10000000, 99999999);
    }


    //获取城市名
    public static function getCityName($id)
    {

        $data = \Yii::$app->redis->get('city_shop_name');
        if (!$data) {
            $city_data = \Yii::$app->db->createCommand("select * from prov_city_area")->queryAll();
            $key = array_column($city_data, 'areano');
            $value = array_column($city_data, 'areaname');
            $data = array_combine($key, $value);
            $arr = serialize($data);
            \Yii::$app->redis->set('city_shop_name', $arr);
            return $data[$id];
        }
        $data = unserialize($data);
        $bool = array_key_exists($id, $data);
        if (!$bool) {
            return '';
        }
        return $data[$id];
    }

}