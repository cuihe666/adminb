<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "hotel_contact".
 *
 * @property integer $id
 * @property integer $theme
 * @property integer $theme_id
 * @property string $type
 * @property string $name
 * @property string $job
 * @property integer $mobile
 * @property string $email
 * @property string $landline
 */
class HotelContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['theme', 'theme_id', 'mobile'], 'integer'],
            [['theme_id'], 'required'],
            [['type', 'email'], 'string', 'max' => 30],
            [['name', 'job'], 'string', 'max' => 20],
            [['landline'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'theme' => '所属类型 1=>供应商 2=>酒店',
            'theme_id' => '供应商or酒店id',
            'type' => '联系人类型',
            'name' => '姓名',
            'job' => '职务',
            'mobile' => '手机号',
            'email' => '邮箱',
            'landline' => '座机',
        ];
    }
}
