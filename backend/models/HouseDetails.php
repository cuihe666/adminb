<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "house_details".
 *
 * @property integer $id
 * @property string $title
 * @property string $introduce
 * @property string $cover_img
 * @property string $tel
 * @property string $longitude
 * @property string $latitude
 * @property string $address
 * @property string $vague_addr
 * @property string $doornum
 * @property integer $minday
 * @property integer $roomsize
 * @property integer $deposit
 * @property string $create_time
 * @property string $update_date
 * @property integer $is_deposit
 * @property string $notice
 * @property string $secret_notice
 * @property integer $is_welcome
 * @property integer $uid
 * @property integer $lbs_id
 * @property integer $total_stock
 * @property integer $is_realtime
 * @property integer $intime
 * @property integer $outtime
 * @property string $start_sell
 * @property string $end_sell
 * @property double $clean_fee
 * @property integer $over_man
 * @property double $over_fee
 */
class HouseDetails extends \yii\db\ActiveRecord
{

    public $tango_weight;
    public $roomtype;
    public $code_name;
    public $type_name;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['longitude', 'latitude', 'vague_addr', 'minday', 'roomsize', 'uid', 'is_realtime'], 'required'],
            [['minday', 'roomsize', 'deposit', 'is_deposit', 'is_welcome', 'uid', 'lbs_id', 'total_stock', 'is_realtime', 'intime', 'outtime', 'over_man'], 'integer'],
            [['create_time', 'update_date', 'start_sell', 'end_sell', 'sort'], 'safe'],
            [['clean_fee', 'over_fee'], 'number'],
            [['title'], 'string', 'max' => 50],
            [['introduce'], 'string', 'max' => 5000],
            [['cover_img', 'secret_notice'], 'string', 'max' => 200],
            [['tel'], 'string', 'max' => 16],
            [['longitude', 'latitude'], 'string', 'max' => 24],
            [['address', 'vague_addr'], 'string', 'max' => 100],
            [['doornum'], 'string', 'max' => 20],
            [['notice'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '房源ID',
            'title' => '标题',
            'introduce' => 'Introduce',
            'cover_img' => 'Cover Img',
            'tel' => 'Tel',
            'houseserach.price' => '价格',
            'houseserach.comment_count' => '评价数',
            'houseserach.tango_weight' => '排序值',
            'houseserach.status' => '状态',
            'houseserach.city' => '城市',
            'create_time' => '创建时间',
            'update_date' => '修改时间',
            'tango_weight' => '排序值',
            'salesman' => '房屋管理员'
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    public function getHouseserach()
    {
        return $this->hasOne(HouseSearch::className(), ['house_id' => 'id']);
    }

    public static function getType()
    {
        return Yii::$app->db->createCommand("SELECT id,type_name FROM `dt_house_type`")->queryAll();
    }
    //关联 house_tc_details 表
    public function getHousehotel()
    {
        return $this->hasOne(HouseTcDetails::className(),['house_id' => 'id']);
    }

    public static function getDetailsByHid($id){
        if($id){
            return HouseDetails::find()->with('houseserach')->where(['id' => $id])->one();
        }
    }

    //@2017-11-10 13:27:29 fuyanfei to add minsu320[添加新的房源类型]
    public static function getHousetype(){
        return Yii::$app->db->createCommand("SELECT id,code_name FROM `dt_house_type_code`")->queryAll();
    }

}
