<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "coupon1".
 *
 * @property integer $id
 * @property string $title
 * @property integer $rule
 * @property integer $amount
 * @property integer $is_forever
 * @property integer $mode
 * @property integer $type
 * @property string $redeem_code
 * @property string $start_time
 * @property string $end_time
 * @property integer $uid
 * @property integer $batch_id
 * @property integer $status
 * @property string $update_time
 * @property string $create_time
 * @property integer $platform
 */
class Coupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rule', 'amount', 'is_forever', 'mode', 'type', 'uid', 'status', 'platform'], 'integer'],
            [['start_time', 'end_time', 'update_time', 'create_time', 'batch_code'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['redeem_code'], 'string', 'max' => 12],
            [['batch_code'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '优惠券名称',
            'rule' => '订单满减条件',
            'amount' => '优惠券金额',
            'is_forever' => '0=>区间内有效 1=>永久有效',
            'mode' => '0=>无兑换码 1=>有兑换码',
            'type' => '优惠券类型 0=>通用，1=>民宿，2=>旅行，3=>酒店',
            'redeem_code' => '兑换码',
            'start_time' => '优惠券开始时间',
            'end_time' => '优惠券结束时间',
            'uid' => '用户id',
            'batch_code' => '关联批次id',
            'status' => '0=>待激活 1=>待使用 2=>占用中 3=>已使用 4=>已失效',
            'update_time' => '优惠券状态最后更新时间',
            'create_time' => '创建时间',
            'platform' => '0=>通用,1=>APP 专享,2=>H5专享',
        ];
    }

    //用户信息
    public function getUsers(){
        return $this->hasOne(User::className(),['id' => 'uid'])->select(['id','mobile']);
    }

    //优惠券订单信息
    public function getUsed(){
        return $this->hasOne(CouponUsed::className(),['coupon_id' => 'id'])->andWhere(['is_delete' => 0])->orderBy(['id' => SORT_DESC]);
    }

    //优惠券领取信息
    public function getReceive(){
        return $this->hasOne(CouponReceive::className(),['coupon_id' => 'id'])->orderBy(['id' => SORT_DESC]);
    }

    //获取批次信息
    public function getBatch(){
        return $this->hasOne(CouponBatch::className(),['batch_code' => 'batch_code']);
    }
}
