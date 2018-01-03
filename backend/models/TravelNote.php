<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_note".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $name
 * @property string $start_time
 * @property string $end_time
 * @property integer $type
 * @property integer $people_type
 * @property string $price
 * @property string $content
 * @property integer $day_count
 * @property integer $read_count
 * @property integer $praise_count
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_del
 * @property string $pic
 * @property string $music
 * @property integer $status
 * @property string $start_month
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
class TravelNote extends \yii\db\ActiveRecord
{
    public $aptitude;     //2017年7月3日15:43:43 付燕飞增加 资质名称
    public $nickname;     //2017年7月3日15:44:13 付燕飞增加 昵称
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            //[['uid', 'type', 'people_type', 'day_count', 'read_count', 'praise_count', 'is_del', 'status', 'city1', 'city2', 'city3', 'province1', 'province2', 'province3', 'country1', 'country2', 'country3'], 'integer'],
            [['uid', 'type', 'people_type', 'day_count', 'read_count', 'praise_count', 'is_del', 'status'], 'integer'],
            [['start_time', 'end_time', 'create_time', 'update_time'], 'safe'],
            [['price'], 'number'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 30],
            [['pic'], 'string', 'max' => 500],
            [['music'], 'string', 'max' => 200],
            //[['start_month'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户uid',
            'name' => '标题',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'type' => '0=>自由行 1=>半自由 2=>跟团 3=>徒步 4=>自驾 5=>游轮 6=>骑行',
            'people_type' => '0=>一个人 1=>小两口 2=>亲子游 3=>带父母 4=>朋友',
            'price' => '人均价格',
            'content' => '游记内容',
            'day_count' => '天数',
            'read_count' => '浏览量',
            'praise_count' => '点赞量',
            'create_time' => '发布时间',
            'update_time' => '修改时间',
            'is_del' => '是否删除0 未删除 1 已删除',
            'pic' => '标题图',
            'music' => 'Music',
            'status' => '0=>审核中 1=>已上线 2=>已下线 3=>未通过 4=>草稿',
            'start_month' => '开始月份',
            'city1' => 'City1',
            'city2' => 'City2',
            'city3' => 'City3',
            'province1' => '省',
            'province2' => 'Province2',
            'province3' => 'Province3',
            'country1' => '国家1',
            'country2' => '国家2',
            'country3' => '国家3',
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
        return $this->hasMany(Collection::className(),['obj_id' => 'id'])->select(['obj_id'])->where("type = 8 and is_del = 0");
    }

    //获取当前印象的点赞量----付燕飞 2017年7月3日14:12:00增加
    public function getSupport(){
        return $this->hasMany(Support::className(),['obj_id' => 'id'])->select(['obj_id'])->where("type = 8 and is_delete = 0");
    }
}
