<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order_state".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $house_id
 * @property integer $order_uid
 * @property integer $house_uid
 * @property integer $order_stauts
 * @property integer $pay_stauts
 * @property integer $use_stauts
 * @property integer $refund_stauts
 * @property string $pay_amount
 * @property string $coupon_amount
 * @property integer $is_delete
 * @property integer $pay_platform
 * @property string $out_trade_no
 * @property string $transaction_id
 * @property string $trade_type
 * @property string $time_end
 * @property string $pay_time
 * @property string $confirm_time
 * @property integer $visitor_news
 * @property integer $landlord_news
 */
class OrderState extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_state';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'house_id', 'order_uid', 'house_uid', 'use_stauts', 'pay_amount', 'is_delete'], 'required'],
            [['order_id', 'house_id', 'order_uid', 'house_uid', 'order_stauts', 'pay_stauts', 'use_stauts', 'refund_stauts', 'is_delete', 'pay_platform', 'visitor_news', 'landlord_news'], 'integer'],
            [['pay_amount', 'coupon_amount'], 'number'],
            [['pay_time', 'confirm_time'], 'safe'],
            [['out_trade_no', 'transaction_id'], 'string', 'max' => 32],
            [['trade_type'], 'string', 'max' => 16],
            [['time_end'], 'string', 'max' => 14],
            [['order_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'house_id' => 'House ID',
            'order_uid' => 'Order Uid',
            'house_uid' => 'House Uid',
            'order_stauts' => 'Order Stauts',
            'pay_stauts' => 'Pay Stauts',
            'use_stauts' => 'Use Stauts',
            'refund_stauts' => 'Refund Stauts',
            'pay_amount' => 'Pay Amount',
            'coupon_amount' => 'Coupon Amount',
            'is_delete' => 'Is Delete',
            'pay_platform' => 'Pay Platform',
            'out_trade_no' => 'Out Trade No',
            'transaction_id' => 'Transaction ID',
            'trade_type' => 'Trade Type',
            'time_end' => 'Time End',
            'pay_time' => 'Pay Time',
            'confirm_time' => 'Confirm Time',
            'visitor_news' => 'Visitor News',
            'landlord_news' => 'Landlord News',
        ];
    }
}
