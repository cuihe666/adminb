<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_common".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $nickname
 * @property string $avatar
 * @property string $background
 * @property integer $sex
 * @property integer $age
 * @property string $profession
 * @property integer $is_tenant
 * @property integer $is_homemaking
 * @property integer $is_landlord
 * @property integer $is_delete
 */
class UserCommon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_common';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'nickname', 'avatar'], 'required'],
            [['uid', 'gender', 'age', 'is_tenant', 'is_homemaking', 'is_landlord', 'is_delete'], 'integer'],
            [['nickname'], 'string', 'max' => 32],
            [['avatar', 'background'], 'string', 'max' => 128],
            [['profession'], 'string', 'max' => 16],
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
            'nickname' => '昵称',
            'avatar' => 'Avatar',
            'background' => 'Background',
            'gender' => '性别',
            'age' => '年龄',
            'profession' => 'Profession',
            'is_tenant' => 'Is Tenant',
            'is_homemaking' => 'Is Homemaking',
            'is_landlord' => 'Is Landlord',
            'is_delete' => 'Is Delete',
        ];
    }

    //获取用户账号
    public function getAccount(){
        $query = \Yii::$app->db->createCommand("SELECT mobile FROM user WHERE id={$this->uid}")->queryOne();
        return $query['mobile'];
    }
    /**
     * @inheritdoc
     * @return UserCommonQuery the active query used by this AR class.
     */
//    public static function find()
//    {
//        return new UserCommonQuery(get_called_class());
//    }

    public function getUser(){
        return $this->hasOne(User::className(),['id' => 'uid']);
    }
}
