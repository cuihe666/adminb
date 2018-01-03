<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agent_settlement".
 *
 * @property integer $id
 * @property string $settle_id
 * @property integer $agent_id
 * @property integer $create_time
 * @property string $total
 * @property string $order_total
 * @property string $coupon_total
 * @property integer $status
 * @property integer $pay_time
 * @property string $landlady_total
 * @property string $tangguo_total
 */
class AgentSettlement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agent_settlement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agent_id', 'create_time', 'status', 'pay_time'], 'integer'],
            [['total', 'order_total', 'coupon_total', 'landlady_total', 'tangguo_total'], 'number'],
            [['settle_id'], 'string', 'max' => 30],
            [['serial_number','fail_cause'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'settle_id' => '结算id',
            'agent_id' => '代理商用户id',
            'create_time' => '申请结算时间',
            'total' => '结算金额',
            'order_total' => '订单总额',
            'coupon_total' => '优惠券总额',
            'status' => '打款状态',
            'pay_time' => '打款时间',
            'landlady_total' => '房东总收入',
            'tangguo_total' => '棠果总收入',
            'bank.name'=>'开户行',
            'bank.account_number'=>'打款账号',
            'agent.code'=>'地区',
            'serial_number'=>'转账流水号',
            'fail_cause'=>'转账信息'
        ];
    }

    public function getBank()
    {
        return $this->hasOne(AgentBank::className(), ['agent_id' => 'agent_id']);
    }

    public function getAgent()
    {
        return $this->hasOne(TgAgent::className(), ['id' => 'agent_id']);
    }
}
