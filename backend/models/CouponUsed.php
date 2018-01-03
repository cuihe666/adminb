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
class CouponUsed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon1_use';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'type', 'order_id', 'coupon_id'], 'integer'],
            [['create_time'], 'safe'],
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
            'create_time' => '使用时间',
            'type' => '0=>民宿 1=>当地活动 2=>主题higo 3=>酒店',
            'order_id' => '订单id',
            'coupon_id' => '优惠券id',
        ];
    }
}
