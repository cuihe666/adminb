<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_impress".
 *
 * @property integer $id
 * @property string $name
 * @property string $pic
 * @property integer $type
 * @property string $content
 * @property integer $uid
 * @property integer $status
 * @property string $create_time
 * @property integer $read_count
 * @property string $update_time
 * @property string $music
 * @property integer $city1
 * @property integer $city2
 * @property integer $city3
 * @property integer $province1
 * @property integer $province2
 * @property integer $province3
 * @property integer $country1
 * @property integer $country2
 * @property integer $country3
 */
class TravelImpress extends \yii\db\ActiveRecord
{
    public $start_time;
    public $aptitude;          //付燕飞 2017年7月1日14:32:35 增加 资质
    public $nickname;          //付燕飞 2017年7月1日14:32:35 增加昵称
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_impress';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['type', 'uid', 'status', 'read_count', 'city1', 'city2', 'city3', 'province1', 'province2', 'province3', 'country1', 'country2', 'country3'], 'integer'],
            [['type', 'uid', 'status', 'read_count'], 'integer'],
            [['content'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['pic'], 'string', 'max' => 500],
            [['music'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标题',
            'pic' => '封面图',
            'type' => '0=>人文历史 1=>自然风景 2=>舌尖文化 3=>散文随笔',
            'content' => '印象详情内容',
            'uid' => '印象发布人uid',
            'status' => '状态',
            'province1' => '省',
            'country1' => '国家1',
            'country2' => '国家2',
            'country3' => '国家3',
            'read_count' => '浏览量',
            'sort' => '排序',
        ];
    }
    //获取发布账号的信息----付燕飞 2017-7-1 14:35:59增加
    public function getUserMobile(){
        return $this->hasOne(User::className(),['id' => 'uid'])->select(['id','mobile']);
    }

    //获取出发城市信息----付燕飞 2017-7-1 14:36:29增加
    public function getCityName1(){
        return $this->hasOne(DtCitySeas::className(),['code' => 'city1'])->select(['code','name']);
    }

    //获取出发城市信息----付燕飞 2017-7-1 14:36:29增加
    public function getCityName2(){
        return $this->hasOne(DtCitySeas::className(),['code' => 'city2'])->select(['code','name']);
    }

    //获取出发城市信息----付燕飞 2017-7-1 14:36:29增加
    public function getCityName3(){
        return $this->hasOne(DtCitySeas::className(),['code' => 'city3'])->select(['code','name']);
    }

    //获取当前印象的收藏量----付燕飞 2017年7月3日14:12:00增加
    public function getCollection(){
        return $this->hasMany(Collection::className(),['obj_id' => 'id'])->select(['obj_id'])->where("type = 7 and is_del = 0");
    }

    //获取当前印象的点赞量----付燕飞 2017年7月3日14:12:00增加
    public function getSupport(){
        return $this->hasMany(Support::className(),['obj_id' => 'id'])->select(['obj_id'])->where("type = 7 and is_delete = 0");
    }
}
