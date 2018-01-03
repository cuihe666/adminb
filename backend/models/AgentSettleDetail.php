<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agent_settle_detail".
 *
 * @property integer $id
 * @property integer $settle_id
 * @property integer $order_id
 * @property string $order_num
 * @property integer $house_id
 * @property integer $create_time
 */
class AgentSettleDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agent_settle_detail';
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
            'settle_id' => '关联代理商结算id',
            'order_id' => '订单id',
            'order_num' => '订单号',
            'house_id' => '房源id',
            'create_time' => '创建时间',
        ];
    }
}
