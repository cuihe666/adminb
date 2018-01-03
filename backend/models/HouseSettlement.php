<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "house_settlement".
 *
 * @property integer $id
 * @property string $settle_id
 * @property integer $uid
 * @property integer $create_time
 * @property string $total
 * @property string $order_total
 * @property string $coupon_total
 * @property integer $status
 * @property integer $pay_time
 */
class HouseSettlement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_settlement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'create_time', 'status', 'pay_time'], 'integer'],
            [['total', 'order_total', 'coupon_total','agent_total','tangguo_total'], 'number'],
            [['settle_id'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'settle_id' => '结算单号',
            'uid' => '用户id',
            'create_time' => '申请时间',
            'total' => '结算金额',
            'order_total' => '订单总额',
            'coupon_total' => '优惠券总额',
            'status' => '打款状态',
            'pay_time' => '打款时间',
            'account.name'=>'结算人',
            'account.account_number'=>'支付宝账号',
            'user.mobile'=>'联系电话',
            'agent_total'=>'代理商收入',
            'tangguo_total'=>'棠果收入',
            'serial_number'=>'转账流水号',
            'fail_cause'=>'转账状态信息'
        ];
    }

    public function getAccount()
    {
        return $this->hasOne(AccountBankcard::className(), ['uid' => 'uid'])->andWhere(['account_bankcard.is_default'=>1]);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    public function getOrder()
    {
        return $this->hasOne(OrderState::className(),['order_id'=>'id']);
    }
}
