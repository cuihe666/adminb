<?php

namespace backend\models;

use common\tools\Helper;
use Yii;

/**
 * This is the model class for table "hotel_order".
 *
 * @property integer $id
 * @property string $order_num
 * @property string $transaction_id
 * @property integer $hotel_id
 * @property string $hotel_name
 * @property integer $hotel_house_id
 * @property string $hotel_house_name
 * @property integer $hotel_type
 * @property integer $status
 * @property integer $pay_platform
 * @property integer $refund_rule
 * @property integer $bed_type
 * @property integer $breakfast
 * @property integer $order_uid
 * @property string $order_mobile
 * @property string $prompt
 * @property string $preference
 * @property string $in_time
 * @property string $out_time
 * @property integer $province
 * @property integer $city
 * @property integer $area
 * @property string $address
 * @property string $mobile_area
 * @property integer $mobile
 * @property string $order_total
 * @property string $pay_total
 * @property string $hotel_income
 * @property string $tango_income
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_delete
 * @property string $pay_time
 */
class HotelOrder extends \yii\db\ActiveRecord
{
    public $money;       //@2017-11-13 11:45:01 fuyanfei to add hotel_coupon.money
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'hotel_house_id', 'hotel_type', 'status', 'pay_platform', 'refund_rule', 'bed_type', 'breakfast', 'order_uid', 'province', 'city', 'area', 'mobile', 'is_delete'], 'integer'],
            [['in_time', 'out_time', 'create_time', 'update_time', 'pay_time'], 'safe'],
            [['order_total', 'pay_total', 'hotel_income', 'tango_income'], 'number'],
            [['order_num', 'order_mobile'], 'string', 'max' => 20],
            [['transaction_id'], 'string', 'max' => 32],
            [['hotel_name', 'hotel_house_name', 'prompt', 'address'], 'string', 'max' => 100],
            [['preference'], 'string', 'max' => 50],
            [['mobile_area'], 'string', 'max' => 10],
        ];
    }

    //获取关联酒店的名字
    public function getHotel(){
        return $this->hasOne(Hotel::className(),['id' => 'hotel_id'])->select([
            'id',
            'complete_name',
            'province',
            'city',
            'area',
            'address',
            'mobile_area',
            'mobile'
        ]);
    }

    //获取城市信息
    public function getCityName(){
        return $this->hasOne(DtCitySeas::className(),['code' => 'city'])->select(['code','name']);
    }

    //获取下单人
    public function getUser(){
        return $this->hasOne(UserCommon::className(),['uid' => 'order_uid'])->select(['uid','nickname','gender']);
    }

    //获取订单详细条目
    public function getOrderItem(){
        return $this->hasMany(HotelOrderDatePrice::className(),['oid' => 'id']);
    }

    //获取入住人信息
    public function getOrderGuest(){
        return $this->hasMany(HotelOrderGuests::className(),['order_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '订单ID',
            'order_num' => '订单号',
            'transaction_id' => '第三方唯一订单号',
            'hotel_id' => '酒店id',
            'hotel_name' => '酒店名称',
            'hotel_house_id' => '关联酒店房型id',
            'hotel_house_name' => '酒店房型名称',
            'hotel_type' => '酒店类型',
            'status' => '订单状态',
            'pay_platform' => '1=>支付宝  2=>微信',
            'refund_rule' => '退订政策',
            'bed_type' => '0=>大床 1=>双床',
            'breakfast' => '0=>不含早餐,1=>双早,2=>单早,3=>资助,4=>收费',
            'order_uid' => '下单人uid',
            'order_mobile' => '订单联系人手机号',
            'prompt' => '发票提示',
            'preference' => '住客偏好',
            'in_time' => '入住时间',
            'out_time' => '离店时间',
            'province' => '省',
            'city' => '城市',
            'area' => '区',
            'address' => '酒店地址',
            'mobile_area' => '酒店前台座机区号',
            'mobile' => '酒店前台电话',
            'order_total' => '订单总价',
            'pay_total' => '实际支付总价',
            'hotel_income' => '酒店收入',
            'tango_income' => '棠果收入',
            'create_time' => '创建时间',
            'update_time' => '订单状态最后更新时间',
            'is_delete' => '是否删除 0 正常 1 删除',
            'pay_time' => '支付时间',
        ];
    }
}
