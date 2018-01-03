<?php
namespace backend\models;

use yii\db\ActiveRecord;


class OrderRefund extends ActiveRecord
{
    public static function tableName()
    {
        return 'order_refunds_apply';
    }

    public static function getmoney($order_id)
    {
        return \Yii::$app->db->createCommand("select actual_amount from order_refunds_apply WHERE order_id=$order_id")->queryScalar();
    }

}