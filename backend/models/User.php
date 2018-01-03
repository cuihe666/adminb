<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $mobile
 * @property string $password
 * @property integer $status
 * @property string $huanxin
 * @property string $token
 * @property integer $is_delete
 * @property string $create_time
 * @property string $update_time
 * @property string $weibo
 * @property string $qq
 * @property string $weixin
 * @property string $weixinIOS
 * @property string $qqIOS
 */
class User extends \yii\db\ActiveRecord
{
    public $nick_name;
    public $brandname;
    public $cname;
    public $name;
    public $pid;
    public $cid;
    public $pstatus;
    public $cstatus;
    public $invite_mobile;
    public $auth;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile'], 'required'],
            [['status', 'is_delete'], 'integer'],
            [['create_time', 'update_time','citycode','areacode','auth'], 'safe'],
            [['mobile', 'huanxin'], 'string', 'max' => 16],
            [['password'], 'string', 'max' => 50],
            [['token', 'weibo', 'qq', 'weixin', 'weixinIOS', 'qqIOS'], 'string', 'max' => 32],
            [['mobile'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户ID',
            'mobile' => '帐号',
            'password' => 'Password',
            'create_time' => '注册时间',
            'citycode'=>'城市',
            'areacode'=>'区域'
        ];
    }


    public function getInfo()
    {
        return $this->hasOne(UserInfo::className(), ['uid' => 'id']);
    }

    public function getCommon()
    {
        return $this->hasOne(UserCommon::className(), ['uid' => 'id']);
    }

    // 获取旅行订单
    public function getTravelOrder(){
        return $this->hasMany(TravelOrder::className(),['order_uid' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

    //获取酒店订单
    public function getHotelOrder(){
        return $this->hasMany(HotelOrder::className(),['order_uid' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

    //获取房源订单
    public function getHouseOrder(){
        return $this->hasMany(OrderDetailStatic::className(),['order_uid' => 'id'])->orderBy(['id' => SORT_DESC]);
    }


    // 获取旅行订单
    public function getTravelTalentOrder(){
        return $this->hasMany(TravelOrder::className(),['travel_uid' => 'id']);
    }

    public function getfancounts(){
        return $this->hasMany(TravelFollow::className(),['da_uid' => 'id'])->where(['roles' => 2]);
    }
    public function getHigocounts(){
        return $this->hasMany(TravelHigo::className(),['uid' => 'id'])->where(['travel_higo.is_del'=>0])->andWhere(['in','travel_higo.status',[1,2]]);
    }
    public function getActivitycounts(){
        return $this->hasMany(TravelActivity::className(),['uid' => 'id'])->where(['travel_activity.is_del'=>0])->andWhere(['in','travel_activity.status',[1,2]]);
    }
    public function getGuidecounts(){
        return $this->hasMany(TravelGuide::className(),['uid' => 'id'])->andWhere(['in','travel_guide.status',[1,2]]);
    }
    public function getImpresscounts(){
        return $this->hasMany(TravelImpress::className(),['uid' => 'id'])->andWhere(['in','travel_impress.status',[1,2]]);
    }
    public function getNotecounts(){
        return $this->hasMany(TravelNote::className(),['uid' => 'id'])->where(['travel_note.is_del'=>0])->andWhere(['in','travel_note.status',[1,2]]);
    }


    /**
     * 获取邀请人的账号
     * @param $uid
     * @return array
     */
    public static function getInviteMobile($uid)
    {
        $userInfo = User::findOne($uid);
        $person = TravelPerson::find()->where(['uid' => $uid])->one();
        $company = TravelCompany::find()->where(['uid' => $uid])->one();
        if ($person && !$company) {
            $auth = 1;
            $id = $person->id;
            $status = $person->status;
        }
        elseif ($company && !$person) {
            $auth = 2;
            $id = $company->id;
            $status = $company->status;
        }
        elseif($person && $company){
            if($person->create_time > $company->create_time){
                $auth = 1;
                $id = $person->id;
                $status = $person->status;
            }
            else{
                $auth = 2;
                $id = $company->id;
                $status = $company->status;
            }
        }
        else{
            $auth = 0;
            $status = 3;
        }
        $res = [
            'auth' => $auth,
            'id' => $id,
            'mobile' => $userInfo->mobile,
            'status' => $status,
        ];
        return $res;
    }

    public static function getTravelGoods($uid){
        $activity = Yii::$app->db->createCommand("SELECT count(id) as num FROM travel_activity WHERE uid = :uid and status =1")->bindValue(":uid",$uid)->queryOne();
        $higo     = Yii::$app->db->createCommand("SELECT count(id) as num FROM travel_higo WHERE uid = :uid and status =1")->bindValue(":uid",$uid)->queryOne();
        $impress  = Yii::$app->db->createCommand("SELECT count(id) as num FROM travel_impress WHERE uid = :uid and status =1")->bindValue(":uid",$uid)->queryOne();
        $note     = Yii::$app->db->createCommand("SELECT count(id) as num FROM travel_note WHERE uid = :uid and status =1")->bindValue(":uid",$uid)->queryOne();
        $guide    = Yii::$app->db->createCommand("SELECT count(id) as num FROM travel_guide WHERE uid = :uid and status =1")->bindValue(":uid",$uid)->queryOne();
        $total = $activity['num'] + $higo['num'] + $impress['num'] + $note['num'] + $guide['num'];
        return $total;

    }
}
