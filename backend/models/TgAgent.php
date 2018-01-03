<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tg_agent".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $code
 * @property integer $type
 * @property integer $status
 * @property string $true_name
 * @property integer $invite_code
 * @property integer $create_time
 * @property string $email
 */
class TgAgent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tg_agent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'type', 'status', 'invite_code', 'create_time'], 'integer'],
            [['username', 'email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 32],
            [['true_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'true_name' => '姓名',
            'email' => '邮箱',
            'status' => '状态'

        ];
    }


    public function getBank()
    {
        return $this->hasOne(AgentBank::className(), ['agent_id' => 'id']);
    }
}
