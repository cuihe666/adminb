<?php

namespace backend\models;

use common\tools\Helper;
use Yii;

/**
 * This is the model class for table "hotel_supplier_account".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property string $user_name
 * @property integer $mobile
 * @property string $email
 * @property string $bank_name
 * @property string $bank_detail
 * @property string $account_name
 * @property string $account_number
 * @property string $alipay_number
 * @property integer $type
 */
class HotelSupplierAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_supplier_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'type'], 'integer'],
            [['user_name', 'email', 'bank_name', 'bank_detail'], 'string', 'max' => 100],
            [['account_name', 'alipay_number'], 'string', 'max' => 50],
            [['account_number', 'mobile',], 'string', 'max' => 25],
            [['supplier_id','user_name','mobile','bank_name','bank_detail','account_name','account_number','type'],'required'],
            ['email','email'],
            ['mobile','checkPhoneFormat','message' => '手机号格式错误']
        ];
    }

    public function checkPhoneFormat($attribute){
        $mobile = $this->attributes[$attribute];
        //对手机号进行正则验证
        if(!preg_match("/^1[34578]\d{9}$/", $mobile)){
            $this->addError($attribute,'手机号格式不正确');
        }else{
            return true;
        }

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => '关联供应商主表id',
            'user_name' => '财务联系人',
            'mobile' => '联系人手机',
            'email' => '邮箱',
            'bank_name' => '银行名称',
            'bank_detail' => '开户行名称',
            'account_name' => '户名',
            'account_number' => '银行账号',
            'alipay_number' => '支付宝账号',
            'type' => '账户类型',
        ];
    }
}
