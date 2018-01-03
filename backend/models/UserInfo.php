<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_info".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $birthday
 * @property string $email
 * @property string $number
 * @property integer $type
 * @property string $name
 * @property string $number_pic
 * @property integer $auth
 * @property integer $is_old
 * @property string $about_me
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_delete
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'type', 'auth', 'is_old', 'is_delete'], 'integer'],
            [['birthday', 'create_time', 'update_time'], 'safe'],
            [['email', 'number'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 16],
            [['number_pic', 'about_me'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'birthday' => 'Birthday',
            'email' => 'Email',
            'number' => 'Number',
            'type' => 'Type',
            'name' => 'Name',
            'number_pic' => 'Number Pic',
            'auth' => 'Auth',
            'is_old' => 'Is Old',
            'about_me' => 'About Me',
            'create_time' => '注册时间',
            'update_time' => 'Update Time',
            'is_delete' => 'Is Delete',
        ];
    }

    //关联`user`
    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'uid']);
    }
    //关联`user_common`
    public function getCommon()
    {
        return $this->hasOne(UserCommon::className(),['uid'=>'uid']);
    }
}
