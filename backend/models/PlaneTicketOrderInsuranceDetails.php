<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "plane_ticket_order_insurance_details".
 *
 * @property string $id
 * @property integer $ins_order_id
 * @property string $product_id
 * @property string $name
 * @property integer $cert_type
 * @property string $cert_code
 * @property string $mobile
 * @property string $begin_date
 * @property integer $sex
 * @property string $birth
 * @property integer $insurance_type
 * @property string $end_date
 * @property string $flight_no
 * @property string $insurance_no
 * @property string $ticket_no
 * @property string $pnr
 * @property string $start_address
 * @property string $end_address
 * @property string $insure_failed_msg
 * @property string $refund_insure_failed_msg
 * @property integer $insurance_status
 * @property integer $refund_insurance_status
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin_id
 * @property integer $up_admin_id
 */
class PlaneTicketOrderInsuranceDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_order_insurance_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ins_order_id', 'cert_type', 'sex', 'insurance_type', 'insurance_status', 'refund_insurance_status', 'admin_id', 'up_admin_id'], 'integer'],
            [['begin_date', 'birth', 'end_date', 'create_time', 'update_time'], 'safe'],
            [['product_id', 'flight_no'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 100],
            [['cert_code'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 30],
            [['insurance_no', 'ticket_no', 'pnr', 'start_address', 'end_address'], 'string', 'max' => 200],
            [['insure_failed_msg', 'refund_insure_failed_msg'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ins_order_id' => 'Ins Order ID',
            'product_id' => 'Product ID',
            'name' => 'Name',
            'cert_type' => 'Cert Type',
            'cert_code' => 'Cert Code',
            'mobile' => 'Mobile',
            'begin_date' => 'Begin Date',
            'sex' => 'Sex',
            'birth' => 'Birth',
            'insurance_type' => 'Insurance Type',
            'end_date' => 'End Date',
            'flight_no' => 'Flight No',
            'insurance_no' => 'Insurance No',
            'ticket_no' => 'Ticket No',
            'pnr' => 'Pnr',
            'start_address' => 'Start Address',
            'end_address' => 'End Address',
            'insure_failed_msg' => 'Insure Failed Msg',
            'refund_insure_failed_msg' => 'Refund Insure Failed Msg',
            'insurance_status' => 'Insurance Status',
            'refund_insurance_status' => 'Refund Insurance Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'admin_id' => 'Admin ID',
            'up_admin_id' => 'Up Admin ID',
        ];
    }
}
