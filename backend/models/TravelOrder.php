<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_order".
 *
 * @property integer $id
 * @property integer $order_uid
 * @property integer $travel_uid
 * @property integer $travel_id
 * @property string $order_no
 * @property string $trade_no
 * @property string $activity_date
 * @property string $travel_name
 * @property string $title_pic
 * @property integer $state
 * @property integer $refund_stauts
 * @property string $contacts
 * @property string $mobile_phone
 * @property integer $adult
 * @property integer $child
 * @property string $coupon_amount
 * @property string $pay_amount
 * @property string $total
 * @property integer $pay_platform
 * @property integer $type
 * @property integer $is_confirm
 * @property string $create_time
 * @property integer $anum
 * @property string $price
 * @property string $confirm_time
 * @property integer $refund_day
 * @property integer $theme_type
 * @property integer $is_first      //付燕飞 2017年3月27日16:49:32 新增字段，并且在rules中将此字段设置为safe
 */
class TravelOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $user_info;//用户/手机号
    public $total_num;//总人数
    public $pay_state;//支付状态
    public $refund_note;//标记（去除退款中状态）
    public $settle;//结算订单详情
    public $theme_tag;//主题
    public $user_mobile;//用户电话
    public $user_name;//用户名
    //public $is_first;//是否为首单
    public $order_num;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_order';
    }
    //关联`travel_settle_detail`,展示结算详情
    public function getDetails()
    {
        return $this->hasMany(TravelSettleDetail::className(),['order_id'=>'id']);
    }
    //关联`user`
    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'order_uid']);
    }
    //关联`user_common`
    public function getCommon()
    {
        return $this->hasOne(UserCommon::className(),['uid'=>'order_uid']);
    }
    //关联`travel_activity`
    public function getActivity()
    {
        return $this->hasOne(TravelActivity::className(),['id'=>'travel_id']);
    }
    //关联`travel_higo`
    public function getHigo()
    {
        return $this->hasOne(TravelHigo::className(),['id'=>'travel_id']);
    }
    //关联`travel_guide`
    public function getGuide()
    {
        return $this->hasOne(TravelGuide::className(),['id'=>'travel_id']);
    }


    //travel_uid关联`user` 获取发布账号信息
    public function getTravelUser()
    {
        return $this->hasOne(User::className(),['id'=>'travel_uid']);
    }
    //travel_uid关联`user_common` 发布账号信息
    public function getTravelCommon()
    {
        return $this->hasOne(UserCommon::className(),['uid'=>'travel_uid']);
    }

    //
    public static function getTravelTalentOrderCount($travel_uid,$stime="",$status = ""){
        $sql = "select total from travel_order where travel_uid = ".$travel_uid;
        //订单状态为已退款时
        if($status==53)
            $sql .= " and refund_stauts = ".$status;
        //订单状态未待付款或者已完成时
        if($status == 11)
            $sql .= " and state in (3,11,42)";
        //订单状态为已完成时
        if($status == 50)
            $sql .= " and trade_no != ''";
        //查询已支付的所有订单
        if($status == 21){
            $sql .= " and state in (21,32,33,43,44,50)";
        }
        if($stime!=""){
            $start = substr($stime, 0, 10) . ' 00:00:00';
            $end = substr($stime, 13) . ' 23:59:59';
            $sql .= " and create_time between '".$start."' and '".$end."'";
        }
        //查询符合条件的所有订单
        $list = Yii::$app->db->createCommand($sql)->queryAll();
        $newList = [];
        if($list){
            foreach($list as $key=>$val){
                $newList[] = $val['total'];
            }
        }
        //计算订单总数
        $count = count($newList);
        //计算订单总金额
        $sum_total = array_sum($newList);
        $result = ['count' => $count,'sum_total'=>$sum_total];
        return $result;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_uid', 'travel_uid', 'travel_id', 'state', 'close_account', 'refund_stauts', 'adult', 'child', 'pay_platform', 'type', 'is_confirm', 'anum', 'refund_day', 'theme_type'], 'integer'],
            [['activity_date'], 'required'],
            [['activity_date', 'create_time', 'confirm_time','is_first', 'tangguo_income'], 'safe'],
            [['coupon_amount', 'pay_amount', 'total', 'price'], 'number'],
            [['order_no'], 'string', 'max' => 20],
            [['trade_no'], 'string', 'max' => 50],
            [['travel_name'], 'string', 'max' => 64],
            [['title_pic'], 'string', 'max' => 200],
            [['contacts'], 'string', 'max' => 32],
            [['mobile_phone'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_uid' => '用户id',
            'travel_uid' => '活动和主题嗨go所属人uid',
            'travel_id' => '商品ID',
            'order_no' => '订单号',
            'trade_no' => '第三方交易号',
            'activity_date' => '体验日期',
            'travel_name' => '商品名称',
            'title_pic' => '封面图',
            'state' => '订单状态',
            'refund_stauts' => '51.待退款 52.退款中 53.已退款 54.退款失败',
            'contacts' => '联系人',
            'mobile_phone' => '联系电话',
            'adult' => '成人数量',
            'child' => '儿童数量',
            'coupon_amount' => '优惠券金额',
            'pay_amount' => '实付金额',
            'total' => '订单总价',
            'pay_platform' => '支付方式',
            'type' => '商品品类',
            'is_confirm' => '订单类型',
            'create_time' => '下单时间',
            'anum' => '人数',
            'price' => '活动属性,价格',
            'confirm_time' => '确认时间',
            'refund_day' => '退订天数',
            'theme_type' => '0.默认,1.花期',
            'user_info' => '用户名/用户电话',
            'total_num' => '人数',
            'pay_state' => '支付状态',
            'close_account' => '结算状态',
            'is_first'      => '是否首单',
            'ware_city'  => '商品城市',
            'theme_tag'  => '主题',
            'tangguo_income' => '棠果收入',
            'tangguo_rate' => '棠果佣金',
            'order_state' => '订单状态',
        ];
    }
}
