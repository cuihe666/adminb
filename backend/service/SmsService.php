<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12 0012
 * Time: 14:47
 */

namespace backend\service;
use backend\components\SmsConsts;
use backend\helper\SmsHelper;
use Yii;

/**
 * 短信服务
 * Class OrderService
 * @package app\service
 * @author:付燕飞
 * @date : 2017年8月4日13:40:31
 */
class SmsService
{

    /**
     * 生成订单未支付5分钟后提示支付
     * @param $oid
     * @return array
     */
    public static function orderUnpaySms($oid){
        try{
            //发送短信时首先判断此订单id是否存在redis中，如果存在的话就不再发送短信【防止用户一直刷新页面】，
            $redis = Yii::$app->redis;
            $redisOidStr = $redis->get("admin_order_unpay_sms_oid");
            $redisOidArr = json_decode($redisOidStr,true);
            //判断 admin_order_unpay_sms_oid 如果存在，并且oid在此数组中的话，就不发送短信
            if($redisOidArr && in_array($oid,$redisOidArr)){
                $res = [
                    'code' => '-1',
                    'msg' => '已发送过短信',
                ];
                return $res;
            } else{
                $redisOidArr[] = $oid;
                $redis->set("admin_order_unpay_sms_oid",json_encode($redisOidArr));
            }
            //读取订单信息
            $orderInfo = OrderService::getOrderInfoById($oid);
            $travel_name = str_replace(" ","",$orderInfo['travel_name']);    //活动名，去掉活动名称中的空格
            $mobile_phone = $orderInfo['mobile_phone'];                      //联系电话
            $order_no = $orderInfo['order_no'];                              //订单号
            $active_date = date('Y-m-d', strtotime($orderInfo['activity_date']));//活动时间
            //$mobile_phone = '18600893445';
            //用户-短信推送
            $contentU = sprintf(SmsConsts::TRAVEL_ORDER_UNPAY_U, $travel_name);
            $resU = SmsHelper::sendSms($mobile_phone,$contentU);
            if($resU){
                $res = [
                    'code' => '200',
                    'msg' => 'success',
                ];
                $status = 1;
            } else{
                $res = [
                    'code' => '1009',
                    'msg' => '短信发送失败',
                ];
                $status = 0;
            }
        } catch(\Exception $e){
            $res = [
                'code' => '1009',
                'msg' => '短信发送失败',
            ];
            $status = 0;
        }
        //记录短信发送日志
        self::insertSmsLog(1,0,$mobile_phone,$contentU,$status);
        return $res;
    }


    /**
     * 体验日期前一天提醒（发送短信时间：12：00）
     * @param $oid
     * @return array
     */
    public static function orderGoBeforeSms($oid){
        try{
            //发送短信时首先判断此订单id是否存在redis中，如果存在的话就不再发送短信【防止用户一直刷新页面】，
            $redis = Yii::$app->redis;
            $redisOidStr = $redis->get("admin_order_go_before_sms_oid");
            $redisOidArr = json_decode($redisOidStr,true);
            //判断 admin_order_go_before_sms_oid 如果存在，并且oid在此数组中的话，就不发送短信
            if($redisOidArr && in_array($oid,$redisOidArr)){
                $res = [
                    'code' => '-1',
                    'msg' => '已发送过短信',
                ];
                return $res;
            } else{
                $redisOidArr[] = $oid;
                $redis->set("admin_order_go_before_sms_oid",json_encode($redisOidArr));
            }
            //读取订单信息
            $orderInfo = OrderService::getOrderInfoById($oid);
            $travel_name = str_replace(" ","",$orderInfo['travel_name']);    //活动名，去掉活动名称中的空格
            $mobile_phone = $orderInfo['mobile_phone'];                      //联系电话
            $order_no = $orderInfo['order_no'];                              //订单号
            $active_date = date('Y-m-d', strtotime($orderInfo['activity_date']));//活动时间
            //$mobile_phone = '18600893445';
            //用户-短信推送
            $contentU = sprintf(SmsConsts::TRAVEL_ORDER_BEFORE_GO_U, $travel_name);
            $resU = SmsHelper::sendSms($mobile_phone,$contentU);
            if($resU){
                $res = [
                    'code' => '200',
                    'msg' => 'success',
                ];
                $status = 1;
            } else{
                $res = [
                    'code' => '1009',
                    'msg' => '短信发送失败',
                ];
                $status = 0;
            }
        } catch(\Exception $e){
            $res = [
                'code' => '1009',
                'msg' => '短信发送失败',
            ];
            $status = 0;
        }
        //记录短信发送日志
        self::insertSmsLog(1,5,$mobile_phone,$contentU,$status);
        return $res;
    }

    /**
     * 确认订单时，给用户发送短信
     * @param $oid
     * @return array
     */
    public static function orderConfirmSms($oid){
        try{
            //发送短信时首先判断此订单id是否存在redis中，如果存在的话就不再发送短信【防止用户一直刷新页面】，
            $redis = Yii::$app->redis;
            //$redis->del("admin_order_confirm_sms_oid");
            $redisOidStr = $redis->get("admin_order_confirm_sms_oid");
            $redisOidArr = json_decode($redisOidStr,true);
            //判断 admin_order_confirm_sms_oid 如果存在，并且oid在此数组中的话，就不发送短信
            if($redisOidArr && in_array($oid,$redisOidArr)){
                $res = [
                    'code' => '-1',
                    'msg' => '已发送过短信',
                ];
                return $res;
            } else{
                $redisOidArr[] = $oid;
                $redis->set("admin_order_confirm_sms_oid",json_encode($redisOidArr));
            }
            //读取订单信息
            $orderInfo = OrderService::getOrderInfoById($oid);
            $travel_name = str_replace(" ","",$orderInfo['travel_name']);    //活动名，去掉活动名称中的空格
            $mobile_phone = $orderInfo['mobile_phone'];                      //联系电话
            $order_no = $orderInfo['order_no'];                              //订单号
            $active_date = date('Y-m-d', strtotime($orderInfo['activity_date']));//活动时间
            //$mobile_phone = '18600893445';
            //用户-短信推送
            $contentU = sprintf(SmsConsts::TRAVEL_ORDER_CONFIRM_U, $travel_name,$order_no,$active_date);
            $resU = SmsHelper::sendSms($mobile_phone,$contentU);
            if($resU){
                $res = [
                    'code' => '200',
                    'msg' => 'success',
                ];
                $status = 1;
            } else{
                $res = [
                    'code' => '1009',
                    'msg' => '短信发送失败',
                ];
                $status = 0;
            }
        } catch(\Exception $e){
            $res = [
                'code' => '1009',
                'msg' => '短信发送失败',
            ];
            $status = 0;
        }
        //记录短信发送日志
        self::insertSmsLog(1,3,$mobile_phone,$contentU,$status);
        return $res;
    }

    /**
     * 拒单取消订单时，给用户发送短信
     * @param $oid
     * @return array
     */
    public static function orderRefuseSms($oid){
        try{
            //发送短信时首先判断此订单id是否存在redis中，如果存在的话就不再发送短信【防止用户一直刷新页面】，
            $redis = Yii::$app->redis;
            //$redis->del("admin_order_refuse_sms_oid");
            $redisOidStr = $redis->get("admin_order_refuse_sms_oid");
            $redisOidArr = json_decode($redisOidStr,true);
            //判断 admin_order_refuse_sms_oid 如果存在，并且oid在此数组中的话，就不发送短信
            if($redisOidArr && in_array($oid,$redisOidArr)){
                $res = [
                    'code' => '-1',
                    'msg' => '已发送过短信',
                ];
                return $res;
            } else{
                $redisOidArr[] = $oid;
                $redis->set("admin_order_refuse_sms_oid",json_encode($redisOidArr));
            }
            //读取订单信息
            $orderInfo = OrderService::getOrderInfoById($oid);
            $travel_name = str_replace(" ","",$orderInfo['travel_name']);    //活动名，去掉活动名称中的空格
            $mobile_phone = $orderInfo['mobile_phone'];                      //联系电话
            $order_no = $orderInfo['order_no'];                              //订单号
            $active_date = date('Y-m-d', strtotime($orderInfo['activity_date']));//活动时间
            //$mobile_phone = '18600893445';
            //用户-短信推送
            $contentU = sprintf(SmsConsts::TRAVEL_ORDER_REFUSE_U, $travel_name,$order_no,$active_date);
            $resU = SmsHelper::sendSms($mobile_phone,$contentU);
            if($resU){
                $res = [
                    'code' => '200',
                    'msg' => 'success',
                ];
                $status = 1;
            } else{
                $res = [
                    'code' => '1009',
                    'msg' => '短信发送失败',
                ];
                $status = 0;
            }
        } catch(\Exception $e){
            $res = [
                'code' => '1009',
                'msg' => '短信发送失败',
            ];
            $status = 0;
        }
        //记录短信发送日志
        self::insertSmsLog(1,4,$mobile_phone,$contentU,$status);
        return $res;
    }


    /**
     * 订单退款失败
     * @param $oid
     * @return array|bool
     */
    public static function refundFailSms($oid){
        try{
            //发送短信时首先判断此订单id是否存在redis中，如果存在的话就不再发送短信【防止用户一直刷新页面】，
            $redis = Yii::$app->redis;
            $redisOidStr = $redis->get("admin_refund_fail_sms_oid");
            $redisOidArr = json_decode($redisOidStr,true);
            //判断 admin_refund_fail_sms_oid 如果存在，并且oid在此数组中的话，就不发送短信
            if($redisOidArr && in_array($oid,$redisOidArr)){
                $res = [
                    'code' => '-1',
                    'msg' => '已发送过短信',
                ];
                return $res;
            } else{
                $redisOidArr[] = $oid;
                $redis->set("admin_refund_fail_sms_oid",json_encode($redisOidArr));
            }
            //读取订单信息
            $orderInfo = OrderService::getOrderInfoById($oid);
            $travel_name = str_replace(" ","",$orderInfo['travel_name']);    //活动名，去掉活动名称中的空格
            $mobile_phone = $orderInfo['mobile_phone'];                      //联系电话
            $order_no = $orderInfo['order_no'];                              //订单号
            $active_date = date('Y-m-d', strtotime($orderInfo['activity_date']));//活动时间
            //$mobile_phone = '18600893445';
            //用户-短信推送
            $contentU = sprintf(SmsConsts::TRAVEL_ORDER_REFUND_FAIL_U, $travel_name, $order_no, $active_date);
            $resU = SmsHelper::sendSms($mobile_phone,$contentU);
            if($resU){
                $res = [
                    'code' => '200',
                    'msg' => 'success',
                ];
                $status = 1;
            } else{
                $res = [
                    'code' => '1009',
                    'msg' => '短信发送失败',
                ];
                $status = 0;
            }
        } catch(\Exception $e){
            $res = [
                'code' => '1009',
                'msg' => '短信发送失败',
            ];
            $status = 0;
        }
        //记录短信发送日志
        self::insertSmsLog(1,8,$mobile_phone,$contentU,$status);
        return $res;
    }

    /**
     * 订单退款成功
     * @param $oid
     * @return array|bool
     */
    public static function refundSuccessSms($oid){
        try{
            //发送短信时首先判断此订单id是否存在redis中，如果存在的话就不再发送短信【防止用户一直刷新页面】，
            $redis = Yii::$app->redis;
            $redisOidStr = $redis->get("admin_refund_success_sms_oid");
            $redisOidArr = json_decode($redisOidStr,true);
            //判断 admin_refund_success_sms_oid 如果存在，并且oid在此数组中的话，就不发送短信
            if($redisOidArr && in_array($oid,$redisOidArr)){
                $res = [
                    'code' => '-1',
                    'msg' => '已发送过短信',
                ];
                return $res;
            } else{
                $redisOidArr[] = $oid;
                $redis->set("admin_refund_success_sms_oid",json_encode($redisOidArr));
            }
            //读取订单信息
            $orderInfo = OrderService::getOrderInfoById($oid);
            $travel_name = str_replace(" ","",$orderInfo['travel_name']);    //活动名，去掉活动名称中的空格
            $mobile_phone = $orderInfo['mobile_phone'];                      //联系电话
            $order_no = $orderInfo['order_no'];                              //订单号
            $active_date = date('Y-m-d', strtotime($orderInfo['activity_date']));//活动时间
            //$mobile_phone = '18600893445';
            //用户-短信推送
            $contentU = sprintf(SmsConsts::TRAVEL_ORDER_REFUND_SUCCESS_U, $travel_name, $order_no, $active_date);
            $resU = SmsHelper::sendSms($mobile_phone,$contentU);
            if($resU){
                $res = [
                    'code' => '200',
                    'msg' => 'success',
                ];
                $status = 1;
            } else{
                $res = [
                    'code' => '1009',
                    'msg' => '短信发送失败',
                ];
                $status = 0;
            }
        } catch(\Exception $e){
            $res = [
                'code' => '1009',
                'msg' => '短信发送失败',
            ];
            $status = 0;
        }
        //记录短信发送日志
        self::insertSmsLog(1,7,$mobile_phone,$contentU,$status);
        return $res;
    }


    /**
     * 添加发送短信日志
     * @param $object
     * @param $scene
     * @param $tel
     * @param $content
     * @param $status
     * @throws \yii\db\Exception
     */
    public static function insertSmsLog($object,$scene,$tel,$content,$status){
        Yii::$app->db->createCommand("INSERT INTO travel_sms_logs(object,scene,tel,content,status,send_time) VALUES(:object,:scene,:tel,:content,:status,:send_time)")
            ->bindValue(":object",$object)
            ->bindValue(":scene",$scene)
            ->bindValue(":tel",$tel)
            ->bindValue(":content",$content)
            ->bindValue(":status",$status)
            ->bindValue(":send_time",date("Y-m-d H:i:s",time()))
            ->execute();
    }
}