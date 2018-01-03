<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_refund".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $admin_id
 * @property integer $uid
 * @property integer $goods_id
 * @property string $refund_num
 * @property string $title
 * @property string $title_pic
 * @property integer $sku_id
 * @property integer $num
 * @property string $cancel_reason
 * @property string $refund_reason
 * @property integer $point
 * @property string $refund_money
 * @property integer $status
 * @property integer $update_time
 * @property integer $create_time
 */
class ShopRefund extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_refund';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'admin_id', 'uid', 'sku_id', 'num', 'point', 'status', 'update_time', 'create_time'], 'integer'],
            [['refund_money'], 'number'],
            [['refund_num'], 'string', 'max' => 32],
            [['title', 'title_pic'], 'string', 'max' => 255],
            [['cancel_reason', 'refund_reason'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_num' => '变更单号',
            'order_id' => '订单号',
            'status' => '变更单状态',
            'create_time' => '创建时间',
            'update_time' => '审核时间'
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(ShopOrder::className(), ['id' => 'order_id'])->select(['id', 'order_num']);

    }


    public function getPurchase()
    {
        return $this->hasOne(ShopPurchase::className(), ['order_id' => 'order_id'])->select(['order_id', 'purchase_num']);
    }

    public static function getAdminId($name)
    {
        return ShopSupplier::find()->where(["admin_username" => $name])->select('admin_id')->scalar();


    }
}
