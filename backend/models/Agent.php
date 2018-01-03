<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agent".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $last_login
 * @property integer $status
 * @property string $city_code
 * @property string $auth_key
 * @property string $area_code
 * @property string $true_name
 * @property integer $type
 * @property integer $invite_code
 * @property integer $create_time
 */
class Agent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_login', 'status', 'type', 'invite_code', 'create_time'], 'integer'],
            [['username'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 32],
            [['city_code', 'auth_key', 'area_code', 'true_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '代理商帐号',
            'city_code' => '城市代码',
            'area_code' => '区域代码',
            'true_name' => '真实姓名',
            'invite_code' => '邀请码',
        ];
    }

    public function getBank()
    {
        return $this->hasOne(AccountBankcard::className(), ['uid' => 'uid']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
}
