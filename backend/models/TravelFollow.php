<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_follow".
 *
 * @property integer $id
 * @property integer $da_uid
 * @property integer $fans_uid
 * @property integer $roles
 * @property string $create_time
 */
class TravelFollow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_follow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['da_uid', 'fans_uid', 'roles'], 'integer'],
            [['fans_uid'], 'required'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'da_uid' => 'Da Uid',
            'fans_uid' => 'Fans Uid',
            'roles' => 'Roles',
            'create_time' => 'Create Time',
        ];
    }
}
