<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "plane_ticket_insurance_goods_manage".
 *
 * @property string $id
 * @property integer $supplier_id
 * @property integer $type
 * @property string $price
 * @property string $insurance_fee
 * @property integer $ratio
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin_id
 */
class PlaneTicketInsuranceGoodsManage extends \yii\db\ActiveRecord
{
    public $goods;
    public $order_pay_time;
    public $supplier_name;
    public $insurance_type;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_insurance_goods_manage';
    }
    /**
     * @关联 plane_ticket_supplier 表
     */
    public function getSupplier()
    {
        return $this->hasOne(PlaneTicketSupplier::className(), ['id' => 'supplier_id']);
    }
    /**
     * @关联 plane_ticket_order 表
     */
    public function getOrder()
    {
        return $this->hasMany(PlaneTicketOrder::className(), ['insurance_supplier_id' => 'supplier_id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'type', 'ratio', 'admin_id'], 'integer'],
            [['price', 'insurance_fee'], 'number'],
            [['create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'price' => '保费',
            'insurance_fee' => '保额',
            'ratio' => 'Ratio',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'admin_id' => 'Admin ID',
        ];
    }
}
