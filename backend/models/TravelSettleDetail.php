<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_settle_detail".
 *
 * @property integer $id
 * @property integer $settle_id
 * @property integer $order_id
 * @property string $order_num
 * @property integer $travel_id
 * @property integer $create_time
 * @property integer $type
 */
class TravelSettleDetail extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_settle_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['settle_id', 'order_id', 'travel_id', 'create_time', 'type'], 'integer'],
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
            'settle_id' => '申请结算ID',
            'order_id' => '订单ID',
            'order_num' => '订单号',
            'travel_id' => 'Travel ID',
            'create_time' => '申请结算时间',
            'type' => '商品类型',
        ];
    }

}
