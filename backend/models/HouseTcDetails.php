<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "house_tc_details".
 *
 * @property string $id
 * @property string $house_id
 * @property string $res_id
 * @property string $pro_id
 * @property string $res_pro_name
 * @property string $increment_log_id
 * @property integer $status
 * @property string $remark
 * @property integer $type
 * @property string $update_time
 * @property string $res_name
 * @property integer $product_unique_id
 */
class HouseTcDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_tc_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'product_unique_id'], 'required'],
            [['id', 'house_id', 'res_id', 'pro_id', 'increment_log_id', 'status', 'type', 'product_unique_id'], 'integer'],
            [['update_time'], 'safe'],
            [['res_pro_name'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 300],
            [['res_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'house_id' => 'House ID',
            'res_id' => 'Res ID',
            'pro_id' => 'Pro ID',
            'res_pro_name' => 'Res Pro Name',
            'increment_log_id' => 'Increment Log ID',
            'status' => 'Status',
            'remark' => 'Remark',
            'type' => 'Type',
            'update_time' => 'Update Time',
            'res_name' => 'Res Name',
            'product_unique_id' => 'Product Unique ID',
        ];
    }
}
