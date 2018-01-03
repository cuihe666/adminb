<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_higo_click".
 *
 * @property integer $id
 * @property integer $higo_id
 * @property integer $qrcode_id
 * @property integer $click_num
 */
class TravelHigoClick extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_higo_click';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['higo_id', 'qrcode_id', 'click_num'], 'integer'],
            [['higo_id', 'qrcode_id','click_num'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'higo_id' => '活动线路',
            'qrcode_id' => '二维码',
            'click_num' => '浏览量',
        ];
    }
}
