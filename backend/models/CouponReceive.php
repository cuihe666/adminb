<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "coupon1_use".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $create_time
 * @property integer $type
 * @property integer $order_id
 * @property integer $coupon_id
 */
class CouponReceive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon1_receive';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'type', 'order_id', 'coupon_id'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户id',
            'created_at' => '领取时间',
            'order_id' => '订单id',
            'coupon_id' => '优惠券id',
        ];
    }
}
