<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_recommend".
 *
 * @property integer $id
 * @property integer $is_home
 * @property integer $goods_id
 * @property integer $cid
 * @property integer $sort
 */
class ShopRecommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_recommend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_home', 'goods_id', 'cid', 'sort'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_home' => 'Is Home',
            'goods_id' => 'Goods ID',
            'cid' => 'Cid',
            'sort' => 'Sort',
        ];
    }
}
