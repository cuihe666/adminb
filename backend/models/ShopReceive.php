<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_receive".
 *
 * @property integer $id
 * @property integer $package_id
 * @property integer $order_id
 * @property integer $type
 * @property integer $refund_id
 * @property integer $status
 * @property integer $pay_type
 * @property string $order_num
 * @property string $receive_num
 * @property string $transaction_id
 * @property integer $create_time
 * @property string $receivable
 * @property string $true_receive
 * @property string $wait_receive
 */
class ShopReceive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_receive';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'order_id', 'type', 'refund_id', 'status', 'pay_type', 'create_time'], 'integer'],
            [['receivable', 'true_receive', 'wait_receive'], 'number'],
            [['order_num', 'receive_num', 'transaction_id'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单id',
            'type' => 'Type',
            'refund_id' => '',
            'status' => 'Status',
            'pay_type' => 'Pay Type',
            'order_num' => '订单编号',
            'receive_num' => '收款单号',
            'transaction_id' => 'Transaction ID',
            'create_time' => 'Create Time',
            'receivable' => 'Receivable',
            'true_receive' => 'True Receive',
            'wait_receive' => 'Wait Receive',
        ];
    }

    public static function getUserName($order_id)
    {
        $uid = ShopOrder::find()->where('id=:id', [':id' => $order_id])->select('order_uid')->scalar();
        return User::find()->where('id=:uid', [':uid' => $uid])->select('mobile')->scalar();

    }
}
