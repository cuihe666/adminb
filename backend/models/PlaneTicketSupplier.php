<?php

namespace backend\models;

use phpDocumentor\Reflection\Types\Null_;
use Yii;

/**
 * This is the model class for table "plane_ticket_supplier".
 *
 * @property string $id
 * @property string $name
 * @property integer $ticket_genre
 * @property integer $insurance_genre
 * @property string $address
 * @property string $contacts
 * @property string $contacts_phone
 * @property integer $is_use
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin_id
 */
class PlaneTicketSupplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_supplier';
    }
    /**
     * @关联 plane_ticket_order 表
     */
    public function getOrder()
    {
        return $this->hasMany(PlaneTicketOrders::className(), ['ticket_supplier_id' => 'id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ticket_genre', 'insurance_genre', 'is_use', 'admin_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 200],
            [['contacts'], 'string', 'max' => 20],
            [['contacts_phone'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '供应商名称',
            'ticket_genre' => '类别',
            'insurance_genre' => 'Insurance Genre',
            'address' => 'Address',
            'contacts' => '联系人姓名',
            'contacts_phone' => '联系人电话',
            'is_use' => '状态',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'admin_id' => 'Admin ID',
            'charge_request_num' => '接口请求次数'
        ];
    }
}
