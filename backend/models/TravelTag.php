<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_common".
 *
 * @property integer $id
 * @property string $title
 * @property string $desc
 * @property integer $sort
 * @property integer $status
 * @property integer $type
 */
class TravelTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type'], 'required'],
            [['type', 'status', 'sort'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['desc'], 'string', 'max' => 255],
            [['status','desc','sort'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '主题名称',
            'desc' => '描述',
            'sort' => '排序',
            'status' => '状态',
            'type' => '类型',
        ];
    }


}
