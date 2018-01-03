<?php

namespace backend\models;

/**
 * This is the model class for table "plane_ticket_order_refund_ticket".
 *
 * @property string $id
 * @property string $order_no
 */
class PlaneTicketOrderRefundTicket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_order_refund_ticket';
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
}
