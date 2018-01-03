<?php

namespace backend\models;

use Yii;

/**
 * @author fuyanfei
 * @time   2017年3月17日17:29:22
 * @desc   ka_order表模型
 *
 * This is the model class for table "ka_order".
 *
 * @property integer $orderid
 * @property integer $custom_type
 * @property integer $departure
 * @property integer $destination
 * @property string $departure_time
 * @property string $adult_num
 * @property string $children_num
 * @property string $budget
 * @property string $stayed_id
 * @property integer $theme_id
 * @property integer $linkman
 * @property string $tel
 * @property string $email
 * @property integer $follow_status
 * @property integer $add_time
 */
class KaOrder extends \yii\db\ActiveRecord
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
        return 'ka_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['custom_type', 'departure_time', 'adult_num', 'children_num', 'budget', 'stayed_id', 'theme_id', 'tel', 'follow_status', 'add_time'], 'integer'],
            [['custom_type','departure','destination','departure_time','adult_num','children_num','budget','linkman','tel','email'], 'required'],
            //[['activity_date', 'create_time', 'confirm_time'], 'safe'],
            [['adult_num', 'children_num', 'budget', 'tel'], 'number'],
            [['departure'], 'string', 'max' => 20],
            [['destination'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orderid'          => 'ID',
            'custom_type'      => '定制类型',
            'departure'        => '出发地',
            'destination'      => '目的地',
            'departure_time'   => '预计出发时间',
            'adult_num'        => '成人人数',
            'children_num'     => '儿童人数',
            'budget'           => '人均预算',
            'stayed_id'        => '当地住宿',
            'customized_theme' => '定制主题',
            'play_theme'       => '游玩主题',
            'linkman'          => '联系人',
            'tel'              => '手机号',
            'follow_status'    => '跟踪状态',
            'add_time'         => '提交时间'
        ];
    }
}
