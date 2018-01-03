<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hotel_order_date_price".
 *
 * @property integer $id
 * @property integer $oid
 * @property integer $hotel_id
 * @property integer $hotel_house_id
 * @property string $datetime
 * @property string $price
 */
class HotelOrderDatePrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_order_date_price';
    }

    //获取房型名称
    public function getHouseName(){
        return $this->hasOne(HotelHouse::className(),['id' => 'hotel_house_id'])->select(['name','id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['oid', 'hotel_id', 'hotel_house_id', 'datetime', 'price'], 'required'],
            [['oid', 'hotel_id', 'hotel_house_id'], 'integer'],
            [['datetime'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'oid' => '订单id',
            'hotel_id' => '酒店id',
            'hotel_house_id' => '酒店房型id',
            'datetime' => '日期',
            'price' => '价格',
        ];
    }
}
