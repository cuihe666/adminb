<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_refund_log".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $refund_id
 * @property string $reason
 * @property string $detail
 * @property integer $type
 * @property integer $create_time
 */
class ShopRefundLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_refund_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'refund_id', 'type', 'create_time'], 'integer'],
            [['reason', 'detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'refund_id' => 'Refund ID',
            'reason' => 'Reason',
            'detail' => 'Detail',
            'type' => 'Type',
            'create_time' => 'Create Time',
        ];
    }
}
