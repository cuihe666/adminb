<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "service_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 */
class ServiceCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'desc'], 'string', 'max' => 255],
            ['name', 'required', 'message' => '名称不能为空'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名称',
            'desc' => '描述',
        ];
    }
}
