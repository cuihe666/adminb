<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "plane_ticket_order".
 *
 * @property string $id
 * @property string $order_no
 * @property integer $order_uid
 * @property integer $ticket_supplier_id
 * @property integer $insurance_supplier_id
 * @property integer $pay_platform
 * @property integer $pay_status
 * @property integer $order_status
 * @property integer $process_status
 * @property string $dis_amount
 * @property string $pay_amount
 * @property string $total_amount
 * @property string $payment_time
 * @property integer $city_start_code
 * @property integer $city_end_code
 * @property integer $airline_company_code
 * @property string $flight_number
 * @property string $flight_model
 * @property string $fly_start_time
 * @property string $fly_end_time
 * @property string $fly_start_airport
 * @property string $fly_end_airport
 * @property string $have_meals
 * @property string $stop_over_city
 * @property string $contacts
 * @property string $contacts_phone
 * @property string $express_money
 * @property string $express_addressee
 * @property string $express_addressee_address
 * @property string $express_addressee_tel
 * @property integer $guest_num
 * @property integer $insurance_num
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin_id
 */
class PlaneTicketOrder extends \yii\db\ActiveRecord
{
    public $ticket_note;//票号
    public $emplane_name;//乘机人姓名
    public $supplier_name;//供应商名称
    public $order_create_time;//下单时间
    public $abnormal_search;//异常订单页
    public $express_status;//邮寄状态
    public $abnormal_status;//异常状态的三个模块
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_order';
    }
    /**
     * @关联 plane_ticket_citys 表（出发地）
     */
    public function getCityStart()
    {
        return $this->hasOne(PlaneTicketCitys::className(), ['code' => 'city_start_code']);
    }
    /**
     * @关联 plane_ticket_citys 表（目的地）
     */
    public function getCityEnd()
    {
        return $this->hasOne(PlaneTicketCitys::className(), ['code' => 'city_end_code']);
    }
    /**
     * @关联 plane_ticket_supplier 表
     */
    public function getSupplier()
    {
        return $this->hasOne(PlaneTicketSupplier::className(), ['id' => 'ticket_supplier_id']);
    }
    /**
     * @关联 plane_ticket_airline_company 表
     */
    public function getCompany()
    {
        return $this->hasOne(PlaneTicketAirlineCompany::className(), ['code' => 'airline_company_code']);
    }
    /**
     * @关联 plane_ticket_order_emplane 表
     */
    public function getEmplane()
    {
        return $this->hasMany(PlaneTicketOrderEmplane::className(), ['order_id' => 'id']);
    }
    /**
     * @关联 plane_ticket_order_insurance_pay 表（保险支付信息、出保状态）
     */
    public function getInsurance()
    {
        return $this->hasOne(PlaneTicketOrderInsurancePay::className(), ['order_id' => 'id']);
    }
    /**
     * @关联 plane_ticket_order_insurance 表 和 plane_ticket_order_insurance_details 表
     */
    public function getInsuranceOrder()
    {
        return $this->hasOne(PlaneTicketOrderInsurance::className(), ['order_id' => 'id']);
    }
    public function getInsuranceOrderDetails()
    {
        return $this->hasMany(PlaneTicketOrderInsuranceDetails::className(), ['ins_order_id' => 'id'])
            ->via('insuranceOrder');
    }
    /**
     * @关联 plane_ticket_order_ticket_pay 表
     */
    public function getPlaneOrderPay()
    {
        return $this->hasOne(PlaneTicketOrderTicketPay::className(), ['order_id' => 'id']);
    }
    /**
     * @关联 plane_ticket_order_ticket_refundment 表
     */
    public function getPlaneTicketRefundNot()
    {
        return $this->hasMany(PlaneTicketOrderTicketRefundment::className(), ['order_id' => 'id']);
    }
    /**
     * @关联 plane_ticket_order_refund_ticket 表
     */
    public function getPlaneRefundTicket()
    {
        return $this->hasMany(PlaneTicketOrderRefundTicket::className(), ['order_id' => 'id']);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_uid', 'ticket_supplier_id', 'insurance_supplier_id', 'pay_platform', 'pay_status', 'order_status', 'process_status', 'guest_num', 'insurance_num', 'admin_id'], 'integer'],
            [['dis_amount', 'pay_amount', 'total_amount', 'express_money'], 'number'],
            [['payment_time', 'fly_start_time', 'fly_end_time', 'create_time', 'update_time', 'airline_company_code','city_start_code', 'city_end_code'], 'safe'],
            [['order_no'], 'string', 'max' => 32],
            [['flight_number', 'flight_model', 'fly_start_airport', 'fly_end_airport', 'express_addressee', 'express_code'], 'string', 'max' => 50],
            [['have_meals', 'stop_over_city', 'contacts'], 'string', 'max' => 20],
            [['contacts_phone', 'express_addressee_tel'], 'string', 'max' => 16],
            [['express_addressee_address'], 'string', 'max' => 200],
            [['order_no'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_no' => '订单编号',
            'order_uid' => 'Order Uid',
            'ticket_supplier_id' => 'Ticket Supplier ID',
            'insurance_supplier_id' => 'Insurance Supplier ID',
            'pay_platform' => 'Pay Platform',
            'pay_status' => 'Pay Status',
            'order_status' => 'Order Status',
            'process_status' => 'Process Status',
            'dis_amount' => 'Dis Amount',
            'pay_amount' => '订单支付金额',
            'total_amount' => '订单总额',
            'payment_time' => '支付时间',
            'city_start_code' => 'City Start ID',
            'city_end_code' => 'City End ID',
            'airline_company_code' => 'Airline Company ID',
            'flight_number' => '航班号',
            'flight_model' => 'Flight Model',
            'fly_start_time' => 'Fly Start Time',
            'fly_end_time' => 'Fly End Time',
            'fly_start_airport' => '起飞机场',
            'fly_end_airport' => '降落机场',
            'have_meals' => 'Have Meals',
            'stop_over_city' => 'Stop Over City',
            'contacts' => 'Contacts',
            'contacts_phone' => 'Contacts Phone',
            'express_money' => '快递金额',
            'express_addressee' => 'Express Addressee',
            'express_addressee_address' => 'Express Addressee Address',
            'express_addressee_tel' => 'Express Addressee Tel',
            'guest_num' => 'Guest Num',
            'insurance_num' => 'Insurance Num',
            'create_time' => '生单时间',
            'update_time' => 'Update Time',
            'admin_id' => 'Admin ID',
            'express_code' => '邮递单号',
        ];
    }
    /**
     * @获取城市名（ID => 城市名）
     */
    public static function CityName($code)
    {
        $name = PlaneTicketCitys::find()
            ->where(['code' => $code])
            ->select([
                'name',
            ])
            ->asArray()
            ->scalar();
        return $name;
    }
    /**
     * @获取航空公司名称
     */
    public static function CompanyName($code)
    {
        $name = PlaneTicketAirlineCompany::find()
            ->where(['code' => $code])
            ->select([
                'name'
            ])
            ->asArray()
            ->scalar();
        return $name;
    }
    /**
     * @获取航班飞行时长
     */
    public static function TimeLength($startdate, $enddate)
    {
        $date = floor((strtotime($enddate)-strtotime($startdate))/86400);
        $hour = floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
        $minute = floor((strtotime($enddate)-strtotime($startdate))%86400%3600/60);
        $time_length = (empty($date)?'':($date.'d')).(empty($hour)?'':($hour.'h')).(empty($minute)?'':($minute.'m'));
        return $time_length;
    }
}
