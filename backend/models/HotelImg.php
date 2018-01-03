<?php

namespace backend\models;

use Yii;


/**
 * @author fuyanfei
 * @time   2017年4月18日13:27:48
 * @desc   hotel_img表模型
 *
 * This is the model class for table "hotel_img".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $hotel_house_id
 * @property string  $pic
 * @property integer $type
 * @property string  $des
 */
class HotelImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'type'], 'integer'],
            [['hotel_id', 'type'], 'required'],
            [['hotel_id', 'type','pic','des'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'hotel_id'         => '酒店ID',
            'hotel_house_id'  => '房型ID',
            'type'             => '图片类型',
            'pic'              => '图片',
            'des'              => '描述',
        ];
    }

}
