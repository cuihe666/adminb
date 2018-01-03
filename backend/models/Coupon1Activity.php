<?php

namespace backend\models;

use Yii;
use app\models\common\CURDTrait;
/**
 * This is the model class for table "coupon1_activity".
 *
 * @property integer $id
 * @property string  $activity_id
 * @property string  $title
 * @property integer $daily_max
 * @property integer $storage
 * @property integer $net_stock
 * @property string  $start_time
 * @property integer $end_time
 * @property string  $create_at
 * @property string  $update_at
 * @property integer $status
 */
class Coupon1Activity extends \yii\db\ActiveRecord
{
    use CURDTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon1_activity';
    }

    static public function getDb()
    {
        return Yii::$app->db;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'title', 'storage', 'status','create_at'], 'required'],
            [['daily_max', 'net_stock','start_time', 'end_time', 'update_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => '优惠券礼包ID',
            'title' => '优惠券礼包',
            'daily_max' => '每日领取的最大数量',
            'storage' => '优惠券总量',
            'net_stock' => '当前剩余存量',
            'start_time' => '活动开始时间',
            'end_time' => '活动结束时间',
            'create_at' => '创建日期',
            'update_at' => '更新日期',
            'status' => '状态',
        ];
    }
}
