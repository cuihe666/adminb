<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hotel_supplier_settlement".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property string $start_time
 * @property string $end_time
 * @property string $money
 * @property integer $status
 */
class HotelSupplierSettlement extends \yii\db\ActiveRecord
{
    public $date_search;//账单周期
    public $order_num;//订单号
    public $top_total;//总价-顶部
    public $top_settle;//已结算-顶部
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_supplier_settlement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['settle_id', 'hotel_id', 'supplier_id', 'id', 'invoice', 'status'], 'integer'],
            [['start_time', 'end_time', 'create_time', 'total', 'order_total', 'coupon_total', 'pay_time', 'agent_total', 'tangguo_total', 'date_search'], 'safe'],
            [['fail_cause', 'serial_number'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'settle_id' => '结算单ID',
            'date_search' => '账单周期',
            'start_time' => '结算起始日期',
            'end_time' => '结算终止日期',
            'total' => '结算金额',
            'status' => '状态',
            'invoice' => '开票状态:0=>未开票,1=>已开票'
        ];
    }
    //关联供应商
    public function getSupplier()
    {
        return $this->hasOne(HotelSupplier::className(), ['id' => 'supplier_id']);
    }
    //关联结算单详情表
    public function getDetail()
    {
        return $this->hasMany(HotelSettleDetail::className(), ['settle_id' => 'id']);
    }
}
