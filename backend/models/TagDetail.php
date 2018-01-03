<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tag_detail".
 *
 * @property integer $id
 * @property string $title
 * @property string $pic
 * @property integer $sort
 * @property integer $pid
 */
class TagDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'pid'], 'integer'],
            [['title', 'pic'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'pic' => 'Pic',
            'sort' => 'Sort',
            'pid' => 'Pid',
        ];
    }
}
