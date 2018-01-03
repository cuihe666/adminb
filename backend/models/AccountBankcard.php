<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "account_bankcard".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $name
 * @property string $account_number
 * @property string $bank
 * @property string $bank_branch
 * @property integer $account_type
 * @property integer $type
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_delete
 */
class AccountBankcard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_bankcard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'account_number', 'create_time'], 'required'],
            [['uid', 'account_type', 'type', 'is_delete'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'account_number'], 'string', 'max' => 50],
            [['bank', 'bank_branch'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'name' => 'Name',
            'account_number' => 'Account Number',
            'bank' => 'Bank',
            'bank_branch' => 'Bank Branch',
            'account_type' => 'Account Type',
            'type' => 'Type',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'is_delete' => 'Is Delete',
        ];
    }
}
