<?php

namespace backend\models;

use Yii;
use yii\web\User;

/**
 * This is the model class for table "travel_settlement".
 *
 */
class TravelSettlement extends \yii\db\ActiveRecord
{
    public $user_name;//联系人
    public $user_mobile;//联系电话
    public $tg_commission;//棠果佣金
    public $Alipay_num;//支付宝账号
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_settlement';
    }
    /**
     * @关联`account_bankcard`
     */
    public function getBanks()
    {
        return $this->hasOne(AccountBankcard::className(), ['uid'=>'uid']);
    }
    /**
     * @关联`user_common`
     * 查询用户名
     */
    public function getUser()
    {
        return $this->hasOne(UserCommon::className(), ['uid'=>'uid']);
    }
    /**
     * @关联`user_common`
     * 查询用户名
     */
    public function getUser_mobile()
    {
        return $this->hasOne(\backend\models\User::className(), ['id'=>'uid']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'create_time', 'status', 'pay_time'], 'integer'],
            [['settle_id',], 'string'],
            [[ 'total', 'order_total', 'coupon_total', 'tangguo_total','settle_price'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'settle_id'    => '结算申请ID',
            'uid'          => '结算人ID',
            'create_time'  => '申请结算日期',
            'total'        => '实际支付金额',
            'order_total'  => '订单总额',
            'settle_price' => '结算总金额',
            'coupon_total' => '优惠券总额',
            'status'       => '打款状态',
            'pay_time'     => '打款时间',
            'user_name'    => '联系人',
            'user_mobile'  => '联系电话',
            'tangguo_total'=> '棠果收入',
            'Alipay_num'   => '支付宝账号',
            'account_number' => '支付宝账号',
        ];
    }

}
