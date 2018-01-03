<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tag_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $ sort
 */
class TagCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required', 'message' => '名称不能为空'],
            ['desc', 'safe'],
            [['sort'], 'integer'],
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
            'name' => 'Name',
            'desc' => 'Desc',
            ' sort' => 'Sort',
        ];
    }
}
