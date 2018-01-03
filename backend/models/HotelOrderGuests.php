<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hotel_order_guests".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $guest_name
 */
class HotelOrderGuests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_order_guests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id'], 'integer'],
            [['guest_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '酒店订单id',
            'guest_name' => '入住人姓名',
        ];
    }
}
