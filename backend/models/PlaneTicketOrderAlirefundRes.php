<?php

namespace backend\models;

/**
 * This is the model class for table "plane_ticket_order_alirefund_res".
 *
 * @property string $id
 * @property string $order_no
 */
class PlaneTicketOrderAlirefundRes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_order_alirefund_res';
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
