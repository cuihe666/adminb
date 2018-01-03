<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_order".
 *
 * @property integer $id
 * @property integer $package_id
 * @property integer $order_uid
 * @property integer $admin_id
 * @property integer $address_id
 * @property integer $point_total
 * @property string $price_total
 * @property integer $num_total
 * @property string $order_num
 * @property integer $status
 * @property integer $refund_status
 * @property integer $coupon_id
 * @property string $remark
 * @property integer $update_time
 * @property integer $create_time
 */
class ShopOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_uid', 'admin_id', 'address_id', 'point_total', 'num_total', 'status', 'refund_status', 'coupon_id', 'update_time', 'create_time'], 'integer'],
            [['price_total'], 'number'],
            [['order_num'], 'safe'],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_num' => '订单编号',
            'id' => '订单id'
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    //获得收件人信息

    public function getCustomer()
    {
        return $this->hasOne(ShopAddress::className(), ['id' => 'address_id']);

    }

    public function getReceive()
    {
        return $this->hasMany(ShopReceive::className(), ['order_id' => 'id'])->select(['order_id', 'receive_num', 'type']);
    }
}
