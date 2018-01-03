<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_refund_goods".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $order_id
 * @property integer $refund_id
 * @property string $title
 * @property string $title_pic
 * @property integer $sku_id
 * @property integer $num
 * @property integer $point
 * @property string $price
 * @property integer $pay_type
 * @property string $spec_name
 * @property integer $create_time
 */
class ShopRefundGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_refund_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'order_id', 'refund_id', 'sku_id', 'num', 'point', 'pay_type', 'create_time'], 'integer'],
            [['price'], 'number'],
            [['title', 'title_pic', 'spec_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'order_id' => 'Order ID',
            'refund_id' => 'Refund ID',
            'title' => 'Title',
            'title_pic' => 'Title Pic',
            'sku_id' => 'Sku ID',
            'num' => 'Num',
            'point' => 'Point',
            'price' => 'Price',
            'pay_type' => 'Pay Type',
            'spec_name' => 'Spec Name',
            'create_time' => 'Create Time',
        ];
    }
}
