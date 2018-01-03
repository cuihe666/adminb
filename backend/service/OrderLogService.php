<?php
namespace backend\service;
use Yii;
/**
 * 订单日志的service
 */
class OrderLogService
{
    /**
     * 添加操作日志
     * @author : 付燕飞
     * @date   : 2017-8-9 13:43:27
     */
    /**
     * 添加操作日志
     * @param integer $order_id
     * @param integer $before_status
     * @param integer $status
     * @return int
     * @throws \yii\db\Exception
     */
    public static function insertOrderLog($order_id,$before_status,$status){
        $uid =  Yii::$app->user->getId();   //操作人id
        $uname = Yii::$app->user->identity['username'];   //操作人昵称
        $date = date("Y-m-d H:i:s",time());
        //操作内容
        $des = "平台管理员".$uname."在".$date."将订单状态从【".Yii::$app->params['travel']['order_status'][$before_status]."】改为【".Yii::$app->params['travel']['order_status'][$status]."】";
        $res = Yii::$app->db->createCommand("INSERT INTO travel_order_log(order_id,des,create_date,opt,before_status,after_status,opt_uid,opt_uname,opt_type) VALUES(:order_id,:des,:create_date,:opt,:before_status,:after_status,:opt_uid,:opt_uname,:opt_type)")
            ->bindValue(":order_id",$order_id)
            ->bindValue(":des",$des)
            ->bindValue(":create_date",$date)
            ->bindValue(":opt",2)
            ->bindValue(":before_status",$before_status)
            ->bindValue(":after_status",$status)
            ->bindValue(":opt_uid",$uid)
            ->bindValue(":opt_uname",$uname)
            ->bindValue(":opt_type",3)
            ->execute();
        return $res;
    }
}


