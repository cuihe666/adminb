<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_purchase".
 *
 * @property integer $id
 * @property string $purchase_num
 * @property integer $order_id
 * @property integer $status
 * @property string $sell_name
 * @property string $total
 * @property string $freight
 * @property integer $admin_id
 * @property integer $update_time
 * @property integer $create_time
 */
class ShopPurchase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_purchase';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'status', 'admin_id', 'update_time', 'create_time'], 'integer'],
            [['total', 'freight'], 'number'],
            [['purchase_num'], 'string', 'max' => 32],
            [['sell_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_num' => '采购单号',
            'order_id' => '订单编号',
            'status' => 'Status',
            'sell_name' => 'Sell Name',
            'total' => 'Total',
            'freight' => 'Freight',
            'admin_id' => 'Admin ID',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }

    public function getInfo()
    {
        return $this->hasOne(ShopInfo::className(), ['admin_id' => 'admin_id']);
    }

    public function getOrder()
    {
        return $this->hasOne(ShopOrder::className(), ['id' => 'order_id'])->select(['id', 'order_num']);
    }
}
