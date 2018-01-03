<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "serve_img".
 *
 * @property integer $id
 * @property string $img_url
 * @property integer $img_type
 * @property string $create_time
 * @property integer $serve_id
 * @property string $img_desc
 * @property integer $img_first
 * @property integer $sort
 * @property integer $state
 */
class ServeImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'serve_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_type', 'serve_id', 'img_first', 'sort', 'state'], 'integer'],
            [['create_time'], 'safe'],
            [['img_url'], 'string', 'max' => 200],
            [['img_desc'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'img_url' => '图片的url地址',
            'img_type' => '图片类型',
            'create_time' => '创建时间',
            'serve_id' => '服务id(删除后为0)',
            'img_desc' => '图片描述',
            'img_first' => '是否设置为首图：0是，1否',
            'sort' => '排序',
            'state' => '-1：已删除 0:初始化 1:已提审 2:审核通过',
        ];
    }
}
