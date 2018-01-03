<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_supplier".
 *
 * @property integer $id
 * @property integer $admin_id
 * @property string $admin_username
 * @property integer $status
 * @property string $company_name
 * @property string $bank_num
 * @property string $bank_name
 * @property string $bank_branch_name
 * @property string $account_name
 * @property string $legal
 * @property string $legal_id_code
 * @property string $start_time
 * @property string $end_time
 * @property integer $is_combine
 * @property integer $long_time
 * @property string $uscc_code
 * @property string $occ_code
 * @property string $tax_id
 * @property string $business_scope
 * @property string $shop_admin_datacol
 * @property string $images
 */
class ShopSupplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'admin_id'], 'required'],
            [['id', 'admin_id', 'status', 'is_combine', 'long_time'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['admin_username', 'bank_num', 'bank_name', 'bank_branch_name', 'account_name', 'legal', 'uscc_code', 'occ_code', 'tax_id'], 'string', 'max' => 45],
            [['company_name'], 'string', 'max' => 100],
            [['legal_id_code'], 'string', 'max' => 25],
            [['business_scope'], 'string', 'max' => 255],
            [['images'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admin_username' => '商家帐号',
            'company_name' => '公司名称',
            'legal_id_code' => '身份证',
            'created_at'=>'注册时间',

        ];
    }


    public function getInfo()
    {
        return $this->hasOne(ShopInfo::className(), ['admin_id' => 'admin_id']);
    }
}
