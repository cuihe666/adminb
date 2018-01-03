<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "local_serve".
 *
 * @property integer $id
 * @property string $serve_price
 * @property string $serve_name
 * @property string $serve_content
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_delete
 * @property integer $serve_way
 * @property string $cover_img
 * @property string $serve_img
 * @property integer $serve_type_id
 * @property integer $uid
 */
class LocalServe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'local_serve';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['serve_price'], 'number'],
            [['status', 'is_delete', 'serve_way', 'serve_type_id', 'uid'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['serve_name'], 'string', 'max' => 50],
            [['serve_content'], 'string', 'max' => 4000],
            [['cover_img'], 'string', 'max' => 100],
            [['serve_img'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '服务商品ID',
            'serve_price' => '服务价格',
            'serve_name' => '服务名称',
            'serve_content' => '服务内容',
            'status' => '状态',
            'create_time' => '发布时间',
            'update_time' => '修改时间',
            'is_delete' => '删除标记(0 未删除 1 已删除)',
            'serve_way' => '服务方式（0 免费、1 收费）',
            'cover_img' => '服务首图',
            'serve_img' => '服务图片',
            'serve_type_id' => '类型id',
            'uid' => '房东id',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    public function getServicecategory()
    {
        return $this->hasOne(ServiceCategory::className(), ['id' => 'serve_type_id']);
    }

    public  static  function getCategory()
    {
        return ServiceCategory::find()->asArray()->all();

    }


}
