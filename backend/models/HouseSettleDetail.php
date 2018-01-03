<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "house_settle_detail".
 *
 * @property integer $id
 * @property integer $settle_id
 * @property integer $order_id
 * @property string $order_num
 * @property integer $house_id
 * @property integer $create_time
 */
class HouseSettleDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_settle_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['settle_id', 'order_id', 'house_id', 'create_time'], 'integer'],
            [['order_num'], 'string', 'max' => 24],
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
            'house_id' => 'House ID',
            'create_time' => 'Create Time',
        ];
    }
}
