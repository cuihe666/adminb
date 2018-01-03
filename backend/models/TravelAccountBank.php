<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_account_bank".
 *
 * @property integer $id
 * @property integer $account_type
 * @property string $account_name
 * @property string $account_num
 * @property string $account_bank
 * @property integer $uid
 * @property integer $is_del
 * @property integer $create_time
 * @property integer $update_time
 */
class TravelAccountBank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_account_bank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_type', 'uid', 'is_del', 'create_time', 'update_time'], 'integer'],
            [['uid'], 'required'],
            [['account_name', 'account_num'], 'string', 'max' => 30],
            [['account_bank'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_type' => 'Account Type',
            'account_name' => 'Account Name',
            'account_num' => 'Account Num',
            'account_bank' => 'Account Bank',
            'uid' => 'Uid',
            'is_del' => 'Is Del',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
