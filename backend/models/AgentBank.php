<?php

namespace backend\models;

/**
 * This is the model class for table "agent_bank".
 *
 * @property integer $id
 * @property integer $agent_id
 * @property string $name
 * @property string $account_number
 * @property integer $create_time
 */
class AgentBank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agent_bank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agent_id', 'create_time'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['account_number'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agent_id' => '关联代理商用户表主键id',
            'name' => '开户行',
            'account_number' => '银行卡账号',
            'create_time' => '创建时间',
             'company_name'=>'公司名称'
        ];
    }
}
