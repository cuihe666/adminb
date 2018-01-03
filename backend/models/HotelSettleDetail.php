<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hotel_settle_detail".
 *
 * @property string $id
 * @property integer $settle_id
 * @property integer $order_id
 * @property string $order_num
 * @property string $create_time
 */
class HotelSettleDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_settle_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['settle_id', 'order_id'], 'integer'],
            [['create_time'], 'safe'],
            [['order_num'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'settle_id' => 'Settle ID',
            'order_id' => 'Order ID',
            'order_num' => 'Order Num',
            'create_time' => 'Create Time',
        ];
    }
    /**
     * @关联订单表
     */
    public function getOrder()
    {
        return $this->hasOne(HotelOrder::className(), ['id' => 'order_id']);
    }

}
