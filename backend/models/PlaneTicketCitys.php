<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "plane_ticket_citys".
 *
 * @property string $id
 * @property integer $city_group_id
 * @property string $name
 * @property string $pinyin
 * @property string $code
 * @property string $first_letter
 * @property string $airport
 * @property integer $seas
 * @property integer $is_hot
 * @property integer $is_show
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin_id
 */
class PlaneTicketCitys extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_citys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_group_id', 'seas', 'is_hot', 'is_show', 'admin_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'airport'], 'string', 'max' => 50],
            [['pinyin'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 6],
            [['first_letter'], 'string', 'max' => 1],
            [['code', 'name'], 'unique', 'targetAttribute' => ['code', 'name'], 'message' => 'The combination of Name and Code has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_group_id' => 'City Group ID',
            'name' => 'Name',
            'pinyin' => 'Pinyin',
            'code' => 'Code',
            'first_letter' => 'First Letter',
            'airport' => 'Airport',
            'seas' => 'Seas',
            'is_hot' => 'Is Hot',
            'is_show' => 'Is Show',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'admin_id' => 'Admin ID',
        ];
    }
}
