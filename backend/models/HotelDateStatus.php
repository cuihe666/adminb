<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hotel_date_status".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $hotel_house_id
 * @property string $date_time
 * @property integer $status
 * @property integer $stock
 * @property integer $type
 */
class HotelDateStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_date_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'hotel_house_id', 'status', 'stock', 'type'], 'integer'],
            [['date_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hotel_id' => '酒店id',
            'hotel_house_id' => '房型id',
            'date_time' => '日期',
            'status' => '0=>关闭 1=>打开',
            'stock' => '库存',
            'type' => '0=>没设置库存  1=>有设置库存',
        ];
    }
}
