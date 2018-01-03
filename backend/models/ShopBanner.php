<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_banner".
 *
 * @property integer $id
 * @property string $img_url
 * @property integer $is_home
 * @property integer $type
 * @property integer $goods_id
 * @property integer $cid
 * @property integer $sort
 */
class ShopBanner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_home', 'type', 'goods_id', 'cid', 'sort'], 'integer'],
            [['img_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '标题'
        ];
    }
}
