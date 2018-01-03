<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_person".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $constellation
 * @property string $profession
 * @property integer $mobile
 * @property string $recommend
 * @property integer $sex
 * @property string $card
 * @property string $card_pic_zheng
 * @property string $card_pic_fan
 * @property string $guide_pic
 * @property string $name
 * @property integer $is_login
 * @property integer $status
 */
class TravelPerson extends \yii\db\ActiveRecord
{
    public $person_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'constellation', 'mobile', 'sex', 'is_login', 'status'], 'integer'],
            [['constellation','profession','mobile','recommend','sex','card','card_pic_zheng','card_pic_fan','name','nick_name','email','travel_avatar'],'required'],
            [['profession'], 'string', 'max' => 200],
            [['recommend'], 'string', 'max' => 350,'message'=>'个人简介不得超过300个字'],   //
            [['card'], 'string', 'max' => 20],
            [['card_pic_zheng', 'card_pic_fan', 'guide_pic', 'name'], 'string', 'max' => 100],
            [['profession', 'recommend', 'card', 'card_pic_zheng', 'card_pic_fan', 'guide_pic', 'name','nick_name', 'start_time', 'account','mobile','travel_avatar'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户id',
            'constellation' => '1=>水瓶,2=>双鱼,3=>白羊,4=>金牛,5=>双子,6=>巨蟹,7=>狮子,8=>处女,9=>天枰,10=>天蝎,11=>射手,12=>摩羯',
            'profession' => '职业',
            'mobile' => '电话',
            'recommend' => '自我推荐',
            'sex' => '0=>男 1=>女',
            'card' => '身份证号',
            'card_pic_zheng' => '身份证正面',
            'card_pic_fan' => '身份证反面',
            'guide_pic' => '导游资格证',
            'name' => '姓名',
            'is_login' => 'Is Login',
            'status' => '0=>未审核 1=>审核中 2=>未通过 3=>已通过',
            'create_time' => '上传时间',
            'nick_name'   => '主页昵称',
        ];
    }


    public static function getUser($uid)
    {
        return Yii::$app->db->createCommand("select * from user where id = {$uid}")->queryOne();
    }

    public static function getUserCommon($uid)
    {
        return Yii::$app->db->createCommand("select * from user_common where uid = {$uid}")->queryOne();
    }

    public static function getuid($mobile)
    {
        return Yii::$app->db->createCommand("select id from user WHERE mobile = {$mobile}")->queryScalar();
    }

    public static function getPerson($uid)
    {
        return Yii::$app->db->createCommand("select * from travel_person where uid = {$uid}")->queryOne();
    }
}
