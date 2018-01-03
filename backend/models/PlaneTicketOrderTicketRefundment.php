<?php

namespace backend\models;

/**
 * This is the model class for table "plane_ticket_order_ticket_refundment".
 *
 * @property string $id
 * @property string $order_no
 */
class PlaneTicketOrderTicketRefundment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_order_ticket_refundment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }

    /**
     * @关联 plane_ticket_order_refund_ticket 表
     */
    public function getPlaneRefundTicket()
    {
        return $this->hasOne(PlaneTicketOrderRefundTicket::className(), ['id' => 'refund_ticket_id']);
    }
    /**
     * @关联 plane_ticket_order 表
     */
    public function getPlaneOrder()
    {
        return $this->hasOne(PlaneTicketOrder::className(), ['id' => 'order_id']);
    }
    /**
     * @关联 plane_ticket_order_ticket_pay 表
     */
    public function getPlaneTicketPay()
    {
        return $this->hasOne(PlaneTicketOrderTicketPay::className(), ['order_id' => 'order_id']);
    }
    /**
     * @关联 plane_ticket_order_insurance_pay 表
     */
    public function getPlaneInsurancePay()
    {
        return $this->hasOne(PlaneTicketOrderInsurancePay::className(), ['order_id' => 'order_id']);
    }

}
