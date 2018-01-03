<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_spec".
 *
 * @property integer $id
 * @property string $key
 * @property integer $category_id
 */
class ShopSpec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_spec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['key'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => '规格名称',
            'category_id' => '分类 id',
        ];
    }
}
