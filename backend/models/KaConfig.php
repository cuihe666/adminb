<?php

namespace backend\models;

use Yii;

/**
 * @author fuyanfei
 * @time   2017-8-14 13:49:11
 * @desc   ka_config表模型
 *
 * This is the model class for table "ka_config".
 *
 * @property integer $id
 * @property string  $name
 * @property integer $tel
 * @property string  $remarks
 * @property integer $status
 * @property integer $type
 * @property integer $create_time
 * @property integer $update_time
 */
class KaConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $stime;

    /*public static function getDb()
    {
        return \Yii::$app->db1;
    }*/

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ka_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tel', 'status', 'type', 'create_time'], 'integer'],
            [['name','tel','status','type'], 'required'],
            [['tel'], 'number'],
            [['name'], 'string', 'max' => 6],
            [['remarks'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'name'           => '姓名',
            'tel'            => '手机号',
            'remarks'       => '备注',
            'status'        => '状态',
            'type'          => '类型',
            'create_time'  => '创建时间',
            'update_time'  => '修改时间',
        ];
    }
}
