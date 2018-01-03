<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_guide".
 *
 * @property integer id
 * @property integer uid
 * @property integer identity
 * @property integer user_auth
 * @property string title_pic
 * @property string first_pic
 * @property integer sex
 * @property string mobile
 * @property string tag
 * @property string start_date
 * @property string end_date
 * @property string title
 * @property string service_content
 * @property integer country
 * @property integer province
 * @property integer city
 * @property string language
 * @property string language_other
 * @property string time_interval_start
 * @property string time_interval_end
 * @property integer service_time
 * @property integer num
 * @property integer is_confirm
 * @property string price_in
 * @property string price_out
 * @property integer refund_type
 * @property string refund_note
 * @property string note
 * @property integer status
 * @property string create_time
 * @property string update_time
 */
class TravelGuide extends \yii\db\ActiveRecord
{
    public $aptitude;    //资质名称
    public $nickname;    //昵称
    public $remarks;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_guide';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'identity', 'user_auth', 'sex', 'country', 'province', 'city', 'service_time', 'num', 'is_confirm', 'refund_type', 'status'], 'integer'],
            [['update_time', 'language_other'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['service_content'], 'string', 'max' => 200],
            [['price_in', 'price_out'], 'string', 'max' => 550],
            [['refund_note','note'], 'string', 'max' => 2100],
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

    public static function getidentity($uid)
    {
        $person = TravelPerson::find()->where(['uid' => $uid])->one();
        $company = TravelCompany::find()->where(['uid' => $uid])->one();
        if ($person) {
            return '个人';
        }
        if ($company) {
            return '公司';
        }
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
            'uid' => '发布账号',
            'identity' => '发布者类型',
            'user_auth' => '是否认证',
            'title_pic' => '向导照片',
            'first_pic' => '封面首图',
            'sex' => '性别',
            'mobile' => '联系电话',
            'tag' => '个人标签',
            'start_date' => '开始日期',
            'end_date' => '结束日期',
            'title' => '标题',
            'service_content' => '服务内容',
            'country' => '国家',
            'province' => '省份',
            'city' => '城市',
            'language' => '服务语言',
            'language_other' => '服务语言_其他',
            'time_interval_start' => '服务时段_开始',
            'time_interval_end' => '服务时段_结束',
            'service_time' => '服务时长',
            'num' => '接待人数',
            'is_confirm' => '订单确认',
            'price_in' => '费用包含',
            'price_out' => '费用不含',
            'refund_type' => '退订政策',
            'refund_note' => '退订说明',
            'note' => '预定须知',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '修改时间'
        ];
    }

    //获取发布账号的信息
    public function getUserMobile(){
        return $this->hasOne(User::className(),['id' => 'uid'])->select(['id','mobile']);
    }

    //获取出发城市信息
    public function getCityName(){
        return $this->hasOne(DtCitySeas::className(),['code' => 'city'])->select(['code','name']);
    }


}
