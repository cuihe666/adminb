<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_address".
 *
 * @property integer $id
 * @property integer $province
 * @property integer $city
 * @property integer $area
 * @property string $address
 * @property string $mobile
 * @property string $name
 * @property integer $uid
 * @property integer $is_default
 * @property integer $create_time
 */
class ShopAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province', 'city', 'area', 'uid', 'is_default', 'create_time'], 'integer'],
            [['address'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 13],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'address' => 'Address',
            'mobile' => 'Mobile',
            'name' => '买家姓名',
            'uid' => 'Uid',
            'is_default' => 'Is Default',
            'create_time' => 'Create Time',
        ];
    }
}
