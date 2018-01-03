<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "plane_ticket_order_insurance_pay".
 *
 * @property string $id
 * @property integer $order_id
 * @property integer $supplier_id
 * @property string $trade_no
 * @property string $pay_amount
 * @property integer $pay_status
 * @property string $pay_error
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin_id
 */
class PlaneTicketOrderInsurancePay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_order_insurance_pay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'supplier_id', 'pay_status', 'admin_id'], 'integer'],
            [['pay_amount'], 'number'],
            [['create_time', 'update_time'], 'safe'],
            [['trade_no'], 'string', 'max' => 64],
            [['pay_error'], 'string', 'max' => 100],
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
            'pay_amount' => 'Pay Amount',
            'pay_status' => 'Pay Status',
            'pay_error' => 'Pay Error',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'admin_id' => 'Admin ID',
        ];
    }
}
