<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agent".
 *
 * @property integer $id
 * @property integer $obj_id
 * @property integer $type
 * @property integer $uid
 * @property integer $create_time
 * @property string $update_time
 * @property integer $is_del
 */
class Support extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['obj_id', 'type', 'uid', 'create_time', 'update_time', 'is_del'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'obj_id' => '收藏对象',
            'type' => '类型',
            'uid' => '用户',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'is_del' => '是否删除',
        ];
    }
}
