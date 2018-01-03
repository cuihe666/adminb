<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "coupon1_batch".
 *
 * @property integer $id
 * @property string $title
 * @property integer $type
 * @property integer $is_forever
 * @property integer $mode
 * @property integer $amount
 * @property integer $num
 * @property integer $max_num
 * @property integer $rule
 * @property string $start_time
 * @property string $end_time
 * @property string $create_name
 * @property integer $status
 * @property string $update_time
 * @property string $create_time
 */
class CouponBatch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon1_batch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['type', 'is_forever', 'mode', 'amount', 'num', 'max_num', 'rule', 'status'], 'integer'],
//            [['start_time', 'end_time', 'update_time', 'create_time'], 'safe'],
//            [['title', 'create_name'], 'string', 'max' => 100],
//            ['batch_code' ,'string','max'=>25],
            [['type', 'is_forever', 'mode', 'amount', 'num', 'max_num', 'rule', 'status', 'platform','rule_type'], 'integer'],
            [['start_time', 'end_time', 'update_time', 'create_time'], 'safe'],
            [['batch_code'], 'string', 'max' => 25],
            [['title', 'create_name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],

            [['is_forever','mode'], 'in','range'=> [0,1]],
            ['type', 'in','range'=> [0,1,2,3]],
            ['rule_type', 'in' ,'range' => [0,1,2]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batch_code' => '优惠券批次编码',
            'title' => '优惠券标题名称',
            'type' => '优惠券类型',
            'is_forever' => '优惠券期限',
            'mode' => '是否可导出',
            'amount' => '优惠券金额',
            'num' => '发放数量',
            'max_num' => '每个账号最多领取多少张',
            'rule' => '订单满减规则',
            'start_time' => '优惠券开始时间',
            'end_time' => '优惠券结束时间',
            'create_name' => '资源供给方',
            'status' => '状态',
            'update_time' => '状态最后修改时间',
            'create_time' => '创建时间',
            'platform' => '使用平台',
            'description' => '优惠券描述',
            'rule_type' => '折扣类型'
        ];
//        return [
//            'id' => 'ID',
//            'batch_code' => '优惠券批次编码',
//            'title' => '优惠券标题名称',
//            'biz_type' => '优惠券业务类型',
//            'type' => '优惠券类型',
//            'is_forever' => '期限',
//            'mode' => '0=>无兑换码 1=>有兑换码',
//            'amount' => '优惠券金额',
//            'num' => '发放数量',
//            'max_num' => '每个账号最多领取多少张',
//            'rule' => '满减规则',
//            'start_time' => '优惠券开始时间',
//            'end_time' => '优惠券结束时间',
//            'create_name' => '资源供给方',
//            'status' => '状态',
//            'update_time' => '状态最后修改时间',
//            'create_time' => '创建时间',
//            'platform' => '0=>通用,1=>APP 专享,2=>H5专享',
//            'description' => '优惠券描述',
//        ];
    }

    public function getCoupon(){
        return $this->hasMany(Coupon::className(),['batch_id' => 'id','batch_code' => 'batch_code']);
    }
}
