<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_activity".
 *
 * @property integer $id
 * @property string $name
 * @property string $tag
 * @property integer $type
 * @property string $title_pic
 * @property string $hot_spot
 * @property string $des
 * @property string $process
 * @property integer $max_num
 * @property integer $time_length
 * @property integer $time_unit
 * @property string $mobile
 * @property integer $is_confirm
 * @property string $start_time
 * @property string $end_time
 * @property integer $city_code
 * @property string $active_address
 * @property string $set_address
 * @property string $shi
 * @property string $fen
 * @property string $price_in
 * @property string $price_out
 * @property integer $refund_type
 * @property string $refund_note
 * @property string $note
 * @property integer $read_count
 * @property string $read_link
 * @property integer $uid
 * @property integer $is_del
 * @property integer $status
 * @property string $des_pic
 * @property integer $step
 * @property integer $tango
 * @property integer $province_code
 */
class TravelActivity extends \yii\db\ActiveRecord
{
    public $aptitude;          //付燕飞 2017年6月30日11:29:58 增加 资质
    public $nickname;         //付燕飞 2017-6-30 11:30:13 增加昵称
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'max_num', 'time_length', 'time_unit', 'is_confirm', 'refund_type', 'read_count', 'uid', 'is_del', 'status', 'step', 'tango', 'province_code'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['name', 'active_address', 'set_address', 'read_link', 'des_pic'], 'string', 'max' => 200],
            [['city_code'], 'string', 'max' => 100],
            [['title_pic', 'price_in', 'price_out'], 'string', 'max' => 500],
            [['hot_spot'], 'string', 'max' => 150],
            [['des', 'process'], 'string', 'max' => 300],
            [['mobile'], 'string', 'max' => 32],
            [['shi', 'fen'], 'string', 'max' => 10],
            [['refund_note', 'note'], 'string', 'max' => 2000],
            [['title_pic','first_pic','name','type','tag','hot_spot','des','process','people_max','time_length','time_unit','mobile','is_confirm'],'required','on' => 'onlineupdate'],
            [['title_pic','first_pic','name','type','tag','hot_spot','des','process','people_max','time_length','time_unit','city_code','active_address','set_address','shi','fen','mobile','is_confirm'],'required','on' => 'lineupdate'],
        ];
    }

    public static function getcity($id=0)
    {
        if ($id == '') {
            return '';
        }
        return Yii::$app->db->createCommand("select name  from dt_city_seas where code ={$id}")->queryScalar();

    }

    public static function gettag($id)
    {
        if (!$id) {
            return '';
        }
        $tag = explode(',', $id);
        $tags = '';
        if (is_array($tag) && !empty($tag)) {
            foreach ($tag as $k => $v) {
                $tags .= Yii::$app->db->createCommand("select title  from travel_tag where id ={$v}")->queryScalar() . ',';
            }
        }
        return rtrim($tags, ',');
    }

    public static function gettagarray($id)
    {
        if (!$id) {
            return '';
        }
        $tag = explode(',', $id);
        $tags = array();
        foreach ($tag as $k => $v) {
            $tags [] = Yii::$app->db->createCommand("select title  from travel_tag where id ={$v}")->queryScalar();
        }
        return $tags;
    }
    public static function gettagidandtitle($id)
    {
        if (!$id) {
            return '';
        }
        $tag = explode(',', $id);
        $tags = array();
        $result = Yii::$app->db->createCommand("select id,title  from travel_tag where FIND_IN_SET(id,'{$id}')")->queryAll();
        return $result;
    }

    public static function getidentity($uid)
    {
        $person = TravelPerson::find()->where(['uid' => $uid])->one();
        $company = TravelCompany::find()->where(['uid' => $uid])->one();
        if ($person && !$company) {
            return '个人性质';
        }
        elseif ($company && !$person) {
            return '公司性质';
        }
        elseif($person && $company){
            if($person->create_time > $company->create_time)
                return "个人性质";
            else
                return "公司性质";
        }
        else
            return "暂无性质";

    }


    public static function getidentitystatus($uid)
    {
        $person = TravelPerson::find()->where(['uid' => $uid])->one();
        if ($person) {
            return $person->status;
        }
        $company = TravelCompany::find()->where(['uid' => $uid])->one();
        if ($company) {
            return $company->status;
        }
    }


    public static function getIdentUrl($uid)
    {
        $data = array();
        $person = TravelPerson::find()->where(['uid' => $uid])->one();
        if ($person) {
            $data['type'] = 1;//个人
            $data['status'] = $person->status;
            $data['id'] = $person['id'];
            return $data;
        }
        $company = TravelCompany::find()->where(['uid' => $uid])->one();
        if ($company) {
            $data['type'] = 2;//公司
            $data['status'] = $company->status;
            $data['id'] = $company['id'];
            return $data;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标题',
            'tag' => '标签id,多个逗号隔开',
            'type' => '0=>线上 1=>线下',
            'title_pic' => '封面图',
            'hot_spot' => '活动亮点',
            'des' => '活动描述',
            'process' => '活动流程',
            'max_num' => '人数上限',
            'time_length' => '时长',
            'time_unit' => '时间单位 0=>小时 1=>分',
            'mobile' => '联系电话',
            'is_confirm' => '是否需要商家确认 0=>无需 1=>需要',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'city_code' => '城市编码',
            'active_address' => '活动地址',
            'set_address' => '集合地址',
            'shi' => '集合时间,单位时',
            'fen' => '集合时间,单位分',
            'price_in' => '费用包含',
            'price_out' => '费用不含',
            'refund_type' => '退订政策 0=>不可退款 1=>1天 2=>2天 3=>3天',
            'refund_note' => '退订说明',
            'note' => '预订须知',
            'read_count' => '点击阅读量',
            'read_link' => '详细介绍H5链接',
            'uid' => '上传人uid',
            'is_del' => '是否删除0 未删除 1 已删除',
            'status' => '0=>审核中 1=>已上线 2=>已下线 3=>未通过 4=>草稿',
            'des_pic' => '描述图',
            'step' => '步骤',
            'tango' => '棠果排序',
            'province_code' => '省编码',
            'sort' => '排序',
            'people_max' => '最多人数',
        ];
    }

    //获取发布账号的信息----付燕飞 2017-7-1 14:35:59增加
    public function getUserMobile(){
        return $this->hasOne(User::className(),['id' => 'uid'])->select(['id','mobile']);
    }

    //获取出发城市信息----付燕飞 2017-7-1 14:36:29增加
    public function getCityName(){
        return $this->hasOne(DtCitySeas::className(),['code' => 'city_code'])->select(['code','name']);
    }

}
