<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hotel_date_price".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $hotel_house_id
 * @property string $date_time
 * @property string $price
 * @property string $sale_price
 * @property integer $scale
 */
class HotelDatePrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_date_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'hotel_house_id', 'scale'], 'integer'],
            [['date_time'], 'safe'],
            [['price', 'sale_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hotel_id' => '关联酒店id',
            'hotel_house_id' => '关联酒店房型id',
            'date_time' => '时间',
            'price' => '底价',
            'sale_price' => '售卖价格 = 底价 + 底价 * 佣金比例',
            'scale' => '佣金比例 10=%10  20=%20',
        ];
    }
}
