<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_higo".
 *
 * @property integer $id
 * @property string $name
 * @property string $tag
 * @property string $start_city
 * @property integer $start_province
 * @property integer $start_country
 * @property string $end_city
 * @property integer $end_province
 * @property integer $end_country
 * @property string $profiles
 * @property string $high_light
 * @property integer $is_confirm
 * @property string $start_time
 * @property string $end_time
 * @property string $price_in
 * @property string $price_out
 * @property integer $refund_type
 * @property string $refund_note
 * @property string $note
 * @property integer $read_count
 * @property string $read_link
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $is_del
 * @property integer $uid
 * @property string $title_pic
 * @property integer $close_day
 * @property integer $status
 * @property integer $step
 * @property integer $tango
 * @property string $auth_name
 * @property string $auth_recommend
 * @property string $auth_license
 * @property string $auth_operation
 * @property integer $num
 */
class TravelHigo extends \yii\db\ActiveRecord
{
    public $click_num;
    public $aptitude;          //付燕飞 2017年6月30日11:29:58 增加 资质
    public $nickname;         //付燕飞 2017-6-30 11:30:13 增加昵称

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_higo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_province', 'start_country', 'end_province', 'end_country', 'is_confirm', 'refund_type', 'read_count', 'is_del', 'uid', 'close_day', 'status', 'step', 'tango', 'num'], 'integer'],
            [['start_time', 'end_time','click_num','start_city','end_city'], 'safe'],
            [['name', 'read_link'], 'string', 'max' => 100],
            [['start_city', 'end_city'], 'string', 'max' => 30],
            [['profiles', 'high_light'], 'string', 'max' => 450],
            [['price_in', 'price_out', 'title_pic'], 'string', 'max' => 1000],
            [['refund_note', 'note'], 'string', 'max' => 2000],
            [['auth_name', 'auth_license', 'auth_operation'], 'string', 'max' => 600],
            [['auth_recommend'], 'string', 'max' => 600],
            [['is_confirm', 'refund_type','name', 'tag','profiles', 'high_light','price_in', 'price_out','note','close_day'], 'required', 'on' => 'adminupdate'],
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
            'tag' => 'Tag',
            'start_city' => '出发城市编码',
            'start_province' => '开始省',
            'start_country' => '开始国家',
            'end_city' => '目的地城市编码',
            'end_province' => '结束省',
            'end_country' => '结束国家',
            'profiles' => '领队简介',
            'high_light' => '活动亮点',
            'is_confirm' => '是否商家确认 0=>不需要  1=>需要',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'price_in' => '费用包含',
            'price_out' => '费用不包含',
            'refund_type' => '退订政策 0=>不可退款 1=>1天 2=>2天 3=>3天',
            'refund_note' => '退订说明',
            'note' => '预订须知',
            'read_count' => '点击阅读量',
            'read_link' => '详细介绍H5链接',
            'create_time' => '发布时间',
            'update_time' => '修改时间',
            'is_del' => '是否删除0 未删除 1 已删除',
            'uid' => '用户id',
            'title_pic' => '标题图',
            'close_day' => '提前几天关团',
            'status' => '0=>审核中 1=>已上线 2=>已下线 3=>未通过 4=>草稿',
            'step' => '步骤',
            'tango' => '棠果排序',
            'auth_name' => '公司名称（临时认证）',
            'auth_recommend' => '公司推荐（临时认证）',
            'auth_license' => '营业执照副本（临时认证）',
            'auth_operation' => '旅行社经营许可证（临时认证）',
            'num' => '数量',
            'click_num' => '浏览量',
            'sort' => '排序',
        ];
    }

    /**
     * higo表和click表关联【一对一的关系】
     * @author: 付燕飞
     * @date:   2017年3月28日11:13:38
     * @return \yii\db\ActiveQuery
     */
    public function getClick()
    {
        return $this->hasOne(TravelHigoClick::className(), ['higo_id' => 'id']);
    }

    //获取发布账号的信息----付燕飞 2017年6月30日09:41:43增加
    public function getUserMobile(){
        return $this->hasOne(User::className(),['id' => 'uid'])->select(['id','mobile']);
    }

    //获取出发城市信息----付燕飞 2017年6月30日09:51:43增加
    public function getStartCityName(){
        return $this->hasOne(DtCitySeas::className(),['code' => 'start_city'])->select(['code','name as start_name']);
    }

    //获取目的城市信息----付燕飞 2017年6月30日09:51:43增加
    public function getEndCityName(){
        return $this->hasOne(DtCitySeas::className(),['code' => 'end_city'])->select(['code','name as end_name']);
    }

    //获取个人信息----付燕飞 2017年6月30日10:52:09增加
    public function getPerson(){
        return $this->hasOne(TravelPerson::className(),['uid' => 'uid'])->select(['id','name as person_name','nick_name']);
    }
    //获取目的城市信息----付燕飞 2017年6月30日09:51:43增加
    public function getCompany(){
        return $this->hasOne(TravelCompany::className(),['uid' => 'uid'])->select(['id','name as company_name','brandname']);
    }
}
