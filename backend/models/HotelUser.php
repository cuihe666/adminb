<?php

namespace backend\models;


/**
 * @author fuyanfei
 * @time   2017年7月24日 苑帅
 * @desc   hotel表模型
 *
 * This is the model class for table "hotel_user".
 */
class HotelUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mobile', 'password', 'name', 'job', 'email', 'last_time', 'status', 'supplier_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户ID',
            'mobile' => '账号（手机号码）',
            'password' => '密码',
            'name'   => '姓名',
            'job' => '职务',
            'email' => 'E-mail',
            'last_time' => '最后登录时间',
            'status' => '状态',
            'supplier_id' => '酒店关联ID',
        ];
    }


}
