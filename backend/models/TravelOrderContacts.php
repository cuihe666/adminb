<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_order".
 *
 * @property integer $id
 */
class TravelOrderContacts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $order_no;//订单号
    public $contact_name;//联系人姓名
    public $contact_mobile;//联系人电话
    public $total_person;//总参团人标记
    public $pay_state;//支付状态
    public $order_state;//订单状态
    public $create_time;//下单时间
    public $activity_date;//体验时间
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_order_contacts';
    }
    /**
     * @关联 `travel_order`
     */
    public  function getOrder()
    {
        return $this->hasOne(TravelOrder::className(),['id'=>'order_id']);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'sex'], 'integer'],
            [[], 'required'],
            [['order_no'], 'safe'],
            [[], 'number'],
            [['name', 'idcard', ''], 'string',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'idcard'   => '证件号码',
            'name'     => '参团人姓名',
            'order_no' => '订单号',
            'sex'      => '性别',
            'type'     => '证件类型',
            'contact_mobile' => '联系人电话',
            'contact_name'   => '联系人',
            'pay_state'      => '支付状态',
            'order_state'    => '订单状态',
            'create_time'    => '下单时间',
            'activity_date'    => '体验日期',
        ];
    }
}
