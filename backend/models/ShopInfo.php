<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_info".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $admin_id
 * @property string $name
 * @property string $principal
 * @property string $principal_phone
 * @property string $returns
 * @property string $returns_phone
 * @property integer $province
 * @property integer $city
 * @property integer $area
 * @property string $detail
 * @property string $add_ complete
 */
class ShopInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'admin_id', 'province', 'city', 'area'], 'integer'],
            [['name', 'principal', 'principal_phone', 'returns', 'returns_phone'], 'required'],
            [['name', 'principal', 'principal_phone', 'returns', 'returns_phone'], 'string', 'max' => 45],
            [['detail', 'add_ complete'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => 'Supplier ID',
            'admin_id' => 'Admin ID',
            'name' => '店铺名称',
            'principal' => '卖家姓名',
            'principal_phone' => '手机号',
            'returns' => 'Returns',
            'returns_phone' => 'Returns Phone',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'detail' => 'Detail',
            'add_ complete' => 'Add  Complete',
        ];
    }
}
