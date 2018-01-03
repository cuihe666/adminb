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
 * @property integer $order_source
 * @property integer $pay_platform
 * @property integer $pay_status
 * @property integer $order_status
 * @property integer $process_status
 * @property string $dis_amount
 * @property string $pay_amount
 * @property string $total_amount
 * @property string $payment_time
 * @property string $city_start_code
 * @property string $city_end_code
 * @property string $airline_company_code
 * @property string $flight_number
 * @property string $flight_model
 * @property string $flight_name
 * @property string $fly_start_time
 * @property string $fly_end_time
 * @property string $fly_start_airport
 * @property string $fly_end_airport
 * @property string $have_meals
 * @property string $fly_duration
 * @property string $stop_over_city
 * @property string $stop_over_desc
 * @property string $seat_code
 * @property string $seat_policy_id
 * @property string $contacts
 * @property string $contacts_phone
 * @property string $express_money
 * @property string $express_addressee
 * @property string $express_addressee_address
 * @property string $express_addressee_tel
 * @property integer $express_id
 * @property string $express_code
 * @property string $changeback_stipulate
 * @property integer $guest_num
 * @property integer $insurance_num
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin_id
 */
class PlaneTicketOrders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_uid', 'ticket_supplier_id', 'insurance_supplier_id', 'order_source', 'pay_platform', 'pay_status', 'order_status', 'process_status', 'express_id', 'guest_num', 'insurance_num', 'admin_id'], 'integer'],
            [['dis_amount', 'pay_amount', 'total_amount', 'express_money'], 'number'],
            [['payment_time', 'fly_start_time', 'fly_end_time', 'create_time', 'update_time'], 'safe'],
            [['changeback_stipulate'], 'string'],
            [['order_no'], 'string', 'max' => 100],
            [['city_start_code', 'city_end_code', 'airline_company_code', 'seat_code'], 'string', 'max' => 6],
            [['flight_number', 'flight_model', 'flight_name', 'fly_start_airport', 'fly_end_airport', 'seat_policy_id', 'express_addressee', 'express_code'], 'string', 'max' => 50],
            [['have_meals', 'fly_duration', 'stop_over_city', 'stop_over_desc', 'contacts'], 'string', 'max' => 20],
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
            'id' => 'ID',
            'order_no' => 'Order No',
            'order_uid' => 'Order Uid',
            'ticket_supplier_id' => 'Ticket Supplier ID',
            'insurance_supplier_id' => 'Insurance Supplier ID',
            'order_source' => 'Order Source',
            'pay_platform' => 'Pay Platform',
            'pay_status' => 'Pay Status',
            'order_status' => 'Order Status',
            'process_status' => 'Process Status',
            'dis_amount' => 'Dis Amount',
            'pay_amount' => 'Pay Amount',
            'total_amount' => 'Total Amount',
            'payment_time' => 'Payment Time',
            'city_start_code' => 'City Start Code',
            'city_end_code' => 'City End Code',
            'airline_company_code' => 'Airline Company Code',
            'flight_number' => 'Flight Number',
            'flight_model' => 'Flight Model',
            'flight_name' => 'Flight Name',
            'fly_start_time' => 'Fly Start Time',
            'fly_end_time' => 'Fly End Time',
            'fly_start_airport' => 'Fly Start Airport',
            'fly_end_airport' => 'Fly End Airport',
            'have_meals' => 'Have Meals',
            'fly_duration' => 'Fly Duration',
            'stop_over_city' => 'Stop Over City',
            'stop_over_desc' => 'Stop Over Desc',
            'seat_code' => 'Seat Code',
            'seat_policy_id' => 'Seat Policy ID',
            'contacts' => 'Contacts',
            'contacts_phone' => 'Contacts Phone',
            'express_money' => 'Express Money',
            'express_addressee' => 'Express Addressee',
            'express_addressee_address' => 'Express Addressee Address',
            'express_addressee_tel' => 'Express Addressee Tel',
            'express_id' => 'Express ID',
            'express_code' => 'Express Code',
            'changeback_stipulate' => 'Changeback Stipulate',
            'guest_num' => 'Guest Num',
            'insurance_num' => 'Insurance Num',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'admin_id' => 'Admin ID',
        ];
    }
}
