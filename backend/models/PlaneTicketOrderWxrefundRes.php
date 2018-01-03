<?php

namespace backend\models;

/**
 * This is the model class for table "plane_ticket_order_wxrefund_res".
 *
 * @property string $id
 * @property string $order_no
 */
class PlaneTicketOrderWxrefundRes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_order_wxrefund_res';
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
