<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "operate_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $status
 */
class OperateCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operate_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'desc'], 'required'],
            [['status'], 'integer'],
            [['name', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '运营位分类名称',
            'desc' => '描述',
            'status' => '0=>正常,1=>禁用',
        ];
    }
}
