<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_higo".
 *
 * @property integer $id
 * @property string $name
 * @property string $tag
 * @property string $start_city
 * @property integer $start_province
 * @property integer $start_country
 * @property string $end_city
 * @property integer $end_province
 * @property integer $end_country
 * @property string $profiles
 * @property string $high_light
 * @property integer $is_confirm
 * @property string $start_time
 * @property string $end_time
 * @property string $price_in
 * @property string $price_out
 * @property integer $refund_type
 * @property string $refund_note
 * @property string $note
 * @property integer $read_count
 * @property string $read_link
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $is_del
 * @property integer $uid
 * @property string $title_pic
 * @property integer $close_day
 * @property integer $status
 * @property integer $step
 * @property integer $tango
 * @property string $auth_name
 * @property string $auth_recommend
 * @property string $auth_license
 * @property string $auth_operation
 * @property integer $num
 */
class TravelHigoContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_higo_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['higo_id'], 'integer'],
            [['pic', 'pic_explain'], 'safe'],
            [['title'], 'string', 'max' => 60],
            [['introduce'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'higo_id' => '主题id',
            'title' => '标题',
            'introduce' => '介绍',
            'pic' => '行程图片',
            'pic_explain' => '图片描述',
            'create_time' => '创建时间',
        ];
    }


}
