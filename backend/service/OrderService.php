<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12 0012
 * Time: 14:47
 */

namespace backend\service;
use app\models\TravelOrder;
use app\models\TravelOrderCoupon;

/**
 * 关于订单的逻辑代码
 * Class OrderService
 * @package app\service
 * @author:付燕飞
 * @date : 2017年4月12日14:48:27
 */
class OrderService
{
    /**
     * 根据订单编号获取订单信息
     * @return array
     */
    public static function getOrderNoInfo($orderNo){
        $order = \Yii::$app->db->createCommand("SELECT * FROM travel_order WHERE order_no = :orderno")->bindParam(":orderno",$orderNo)->queryOne();
        return $order;
    }


    /**
     * 根据订单id获取订单信息
     * @return array
     */
    public static function getOrderInfoById($oid){
        $order = \Yii::$app->db->createCommand("SELECT * FROM travel_order WHERE id = :id")->bindParam(":id",$oid)->queryOne();
        return $order;
    }
}