<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "plane_ticket_order_emplane".
 *
 * @property string $id
 * @property integer $order_id
 * @property integer $ticket_supplier_id
 * @property integer $insurance_supplier_id
 * @property integer $ticket_type
 * @property string $pre_price
 * @property integer $insurance_type
 * @property string $insurance_money
 * @property string $mb_fuel
 * @property string $name
 * @property string $phone
 * @property integer $card_type
 * @property string $card_no
 * @property integer $refund_ticket_status
 * @property integer $refund_insurance_status
 * @property string $ticket_no
 * @property string $insurance_no
 * @property string $ticket_commision
 * @property string $insurance_commision
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin_id
 */
class PlaneTicketOrderEmplane extends \yii\db\ActiveRecord
{
    public $profit_detail;//机票费用收益详情页标记
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_order_emplane';
    }
    /**
     * @关联 plane_ticket_order 表
     */
    public function getOrder()
    {
        return $this->hasOne(PlaneTicketOrder::className(), ['id' => 'order_id']);
    }
    /**
     * @关联 plane_ticket_supplier 表
     */
    public function getSupplier()
    {
        return $this->hasOne(PlaneTicketSupplier::className(), ['id' => 'ticket_supplier_id']);
    }
    /**
     * @关联 plane_ticket_order_insurance_pay 表
     */
    public function getPay()
    {
        return $this->hasOne(PlaneTicketOrderInsurancePay::className(), ['order_id' => 'order_id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'ticket_supplier_id', 'insurance_supplier_id', 'ticket_type', 'insurance_type', 'card_type', 'refund_ticket_status', 'refund_insurance_status', 'admin_id'], 'integer'],
            [['pre_price', 'insurance_money', 'mb_fuel', 'ticket_commision', 'insurance_commision'], 'number'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['phone'], 'string', 'max' => 16],
            [['card_no', 'ticket_no', 'insurance_no'], 'string', 'max' => 50],
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
            'ticket_supplier_id' => 'Ticket Supplier ID',
            'insurance_supplier_id' => 'Insurance Supplier ID',
            'ticket_type' => 'Ticket Type',
            'pre_price' => 'Pre Price',
            'insurance_type' => 'Insurance Type',
            'insurance_money' => 'Insurance Money',
            'mb_fuel' => 'Mb Fuel',
            'name' => '被保人姓名',
            'phone' => 'Phone',
            'card_type' => 'Card Type',
            'card_no' => 'Card No',
            'refund_ticket_status' => 'Refund Ticket Status',
            'refund_insurance_status' => 'Refund Insurance Status',
            'ticket_no' => '票号',
            'insurance_no' => 'Insurance No',
            'ticket_commision' => 'Ticket Commision',
            'insurance_commision' => 'Insurance Commision',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'admin_id' => 'Admin ID',
        ];
    }
}
