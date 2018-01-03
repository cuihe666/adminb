<?php

namespace backend\models;

/**
 * This is the model class for table "order_detail_static".
 *
 * @property integer $id
 * @property integer $order_uid
 * @property integer $house_uid
 * @property integer $house_id
 * @property string $order_num
 * @property string $create_time
 * @property string $update_time
 * @property string $extra_amount
 * @property string $total
 * @property string $in_time
 * @property string $out_time
 * @property integer $day_num
 * @property string $house_title_pic
 * @property integer $national
 * @property integer $house_province_id
 * @property integer $house_city_id
 * @property integer $house_county_id
 * @property string $remarks
 * @property string $house_apartments
 * @property double $house_price
 * @property double $house_deposit
 * @property string $house_title
 * @property integer $roomnum
 * @property integer $officenum
 * @property string $mobile
 * @property string $really_name
 * @property string $address
 */
class OrderDetailStatic extends \yii\db\ActiveRecord
{
    public $type_name;
    public $code_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_detail_static';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_uid', 'house_uid', 'house_id', 'order_num', 'create_time', 'total', 'in_time', 'day_num', 'house_title_pic', 'national', 'house_province_id', 'house_city_id', 'house_county_id', 'house_apartments', 'house_price', 'house_title', 'mobile', 'really_name'], 'required'],
            [['order_uid', 'house_uid', 'house_id', 'day_num', 'national', 'house_province_id', 'house_city_id', 'house_county_id', 'roomnum', 'officenum'], 'integer'],
            [['create_time', 'update_time', 'in_time', 'out_time'], 'safe'],
            [['extra_amount', 'total', 'house_price', 'house_deposit'], 'number'],
            [['order_num'], 'string', 'max' => 16],
            [['house_title_pic', 'house_title', 'address'], 'string', 'max' => 200],
            [['remarks'], 'string', 'max' => 128],
            [['house_apartments'], 'string', 'max' => 30],
            [['mobile', 'really_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '订单ID',
            'order_uid' => 'Order Uid',
            'house_uid' => 'House Uid',
            'house_id' => '房源ID',
            'order_num' => '订单号',
            'create_time' => '下单时间',
            'update_time' => 'Update Time',
            'extra_amount' => 'Extra Amount',
            'total' => '订单总价',
            'in_time' => '入住时间',
            'out_time' => '离开时间',
            'day_num' => 'Day Num',
            'house_title_pic' => 'House Title Pic',
            'national' => 'National',
            'house_province_id' => 'House Province ID',
            'house_city_id' => '城市名称',
            'house_county_id' => 'House County ID',
            'remarks' => 'Remarks',
            'house_apartments' => 'House Apartments',
            'house_price' => '单价',
            'house_deposit' => 'House Deposit',
            'house_title' => '标题',
            'roomnum' => 'Roomnum',
            'officenum' => 'Officenum',
            'mobile' => 'Mobile',
            'really_name' => '客户姓名',
            'address' => 'Address',
            'username.name' => '客户姓名',
            'order.order_stauts' => '订单状态',
            'order.transaction_id' => '第三方订单号',
            'order.pay_time' => '支付时间',
            'order.pay_amount' => '实付金额',
            'order.agent_income' => '代理商收入',
            'order.landlady_income' => '房东收入',
            'order.tangguo_income' => '棠果收入',
            'order.coupon_amount' => '优惠券',
            'really_name' => '联系人',
            'refund_money' => '退款金额',
            'day_num' => '间夜',
            'order_type' => '房源来源',
            'book_house_count' => '预订房间数'
        ];
    }

    public function getUsername()
    {
        return $this->hasOne(UserInfo::className(), ['uid' => 'order_uid']);
    }

    public function getOrder()
    {
        return $this->hasOne(OrderState::className(), ['order_id' => 'id']);
    }

    public function getSettle()
    {
        return $this->hasMany(HouseSettleDetail::className(), ['order_id' => 'id']);
    }

    public function getAgentsettle()
    {
        return $this->hasMany(AgentSettleDetail::className(), ['order_id' => 'id']);
    }

}
