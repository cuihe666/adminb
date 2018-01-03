<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "house_serve".
 *
 * @property integer $id
 * @property integer $house_id
 * @property integer $serve_id
 * @property integer $uid
 */
class HouseServe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_serve';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'serve_id', 'uid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'house_id' => '房源id',
            'serve_id' => '服务id',
            'uid' => '房东id',
        ];
    }
}
