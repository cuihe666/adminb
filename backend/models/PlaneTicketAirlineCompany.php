<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "plane_ticket_airline_company".
 *
 * @property string $id
 * @property string $name
 * @property string $pinyin
 * @property string $code
 * @property string $first_letter
 * @property string $short_name
 * @property integer $seas
 * @property integer $is_show
 * @property string $logo_2x
 * @property string $logo_3x
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin_id
 */
class PlaneTicketAirlineCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_airline_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seas', 'is_show', 'admin_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['pinyin'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 6],
            [['first_letter'], 'string', 'max' => 1],
            [['short_name'], 'string', 'max' => 10],
            [['logo_2x', 'logo_3x'], 'string', 'max' => 200],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'pinyin' => 'Pinyin',
            'code' => 'Code',
            'first_letter' => 'First Letter',
            'short_name' => 'Short Name',
            'seas' => 'Seas',
            'is_show' => 'Is Show',
            'logo_2x' => 'Logo 2x',
            'logo_3x' => 'Logo 3x',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'admin_id' => 'Admin ID',
        ];
    }
}
