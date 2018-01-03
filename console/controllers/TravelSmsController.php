<?php
namespace console\controllers;

use backend\service\SmsService;
use Yii;

date_default_timezone_set('PRC');

class TravelSmsController extends \yii\console\Controller
{

    /**
     * 生成订单未支付5分钟后提示支付
     */
    public function actionOrderunpaysms(){
        $date = date("Y-m-d 00:00:00",time());
        $sql = "SELECT id,order_uid,order_no,activity_date,travel_name,state,contacts,mobile_phone,create_time FROM travel_order WHERE state = 11 AND create_time > '".$date."'";
        $orderList = Yii::$app->db->createCommand($sql)->queryAll();
        if($orderList){
            foreach($orderList as $key=>$val){
                $create_time = strtotime($val['create_time']);
                $time = time();
                //如果提交订单超过5分钟未支付的话，发送短信提醒用户支付
                if(($time-$create_time)>=300){
                    SmsService::orderUnpaySms($val['id']);
                }
            }
        }
    }

    /**
     * 体验日期前一天提醒（发送短信时间：12：00）
     */
    public function actionGobeforesms(){
        //明天的日期
        $tomorrow = date("Y-m-d 00:00:00",strtotime("+1 day"));
        $tomorrow_1 = date("Y-m-d 23:59:59",strtotime("+1 day"));

        $sql = "SELECT * FROM travel_order WHERE state = 21 and refund_stauts = 0 and activity_date >= '".$tomorrow."' and activity_date <= '".$tomorrow_1."'";
        $orderList = Yii::$app->db->createCommand($sql)->queryAll();
        if($orderList){
            foreach($orderList as $key=>$val){
                SmsService::orderGoBeforeSms($val['id']);
            }
        }
    }
}