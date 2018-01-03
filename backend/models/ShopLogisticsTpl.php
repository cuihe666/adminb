<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_logistics_tpl".
 *
 * @property integer $id
 * @property integer $admin_id
 * @property string $title
 * @property integer $type
 */
class ShopLogisticsTpl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_logistics_tpl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id', 'type'], 'integer'],
            [['title'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => '供应商 id',
            'title' => '模板名称',
            'type' => '0=>自定义运费,1=>卖家承担运费',
        ];
    }
}
