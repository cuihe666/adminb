<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "plane_ticket_order_insurance".
 *
 * @property string $id
 * @property string $order_id
 * @property integer $supplier_id
 * @property string $trade_no
 * @property string $out_trade_no
 * @property string $settlement_price
 * @property integer $order_status
 * @property string $ins_person
 * @property string $ins_phone
 * @property integer $ins_cert_type
 * @property string $ins_cert_code
 * @property string $insure_failed_msg
 * @property string $refund_insure_failed_msg
 * @property string $insurances
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin_id
 * @property integer $up_admin_id
 * @property string $ins_birth
 * @property string $request_data
 */
class PlaneTicketOrderInsurance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_order_insurance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'order_status', 'ins_cert_type', 'admin_id', 'up_admin_id'], 'integer'],
            [['settlement_price'], 'number'],
            [['insurances'], 'required'],
            [['insurances', 'request_data'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['order_id'], 'string', 'max' => 11],
            [['trade_no', 'out_trade_no', 'ins_phone'], 'string', 'max' => 100],
            [['ins_person', 'ins_birth'], 'string', 'max' => 30],
            [['ins_cert_code'], 'string', 'max' => 200],
            [['insure_failed_msg', 'refund_insure_failed_msg'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'supplier_id' => 'Supplier ID',
            'trade_no' => 'Trade No',
            'out_trade_no' => 'Out Trade No',
            'settlement_price' => 'Settlement Price',
            'order_status' => 'Order Status',
            'ins_person' => 'Ins Person',
            'ins_phone' => 'Ins Phone',
            'ins_cert_type' => 'Ins Cert Type',
            'ins_cert_code' => 'Ins Cert Code',
            'insure_failed_msg' => 'Insure Failed Msg',
            'refund_insure_failed_msg' => 'Refund Insure Failed Msg',
            'insurances' => 'Insurances',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'admin_id' => 'Admin ID',
            'up_admin_id' => 'Up Admin ID',
            'ins_birth' => 'Ins Birth',
            'request_data' => 'Request Data',
        ];
    }
}
