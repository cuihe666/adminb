<?php

namespace backend\models;

/**
 * This is the model class for table "shop_payment".
 *
 * @property integer $id
 * @property integer $package_id
 * @property integer $order_id
 * @property integer $type
 * @property integer $status
 * @property integer $pay_type
 * @property string $order_num
 * @property string $receive_num
 * @property string $transaction_id
 * @property integer $create_time
 * @property string $payable
 * @property string $true_pay
 * @property string $wait_pay
 */
class ShopPayment extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'type', 'status', 'pay_type', 'create_time'], 'integer'],
            [['payable', 'true_pay', 'wait_pay'], 'number'],
            [['order_num', 'receive_num', 'transaction_id'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transaction_id' => '第三方订单号',
            'pay_num' => '付款单号'
        ];
    }

    public function getPurchase()
    {
        return $this->hasOne(ShopPurchase::className(), ['order_id' => 'order_id'])->select(['order_id', 'purchase_num']);
    }

    public function getOrder()
    {
        return $this->hasOne(ShopOrder::className(), ['id' => 'order_id'])->select(['id', 'status', 'order_num']);
    }

    public static function getRefund($orderId)
    {
        return \Yii::$app->db->createCommand("select * from `shop_refund` WHERE order_id = {$orderId} AND status  NOT  IN  (20,25) ")->queryAll();

    }


}
