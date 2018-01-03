<?php

namespace backend\models;

use Yii;

/**
 * @author fuyanfei
 * @time   2017年10月31日10:50:23
 * @desc   tg_activity_turntable_award表模型
 */
class TgActivityTurntableAward extends \yii\db\ActiveRecord
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
        return 'tg_activity_turntable_award';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        //
        return [
            [['award_code', 'award_name','award_info', 'uid','create_time', 'activity_turntable_id', 'activity_id','contact_info'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                          => 'ID',
            'award_code'                => '奖品编码',
            'award_name'                => '奖品名称',
            'award_info'                => '中奖信息',
            'uid'                        => '用户id',
            'create_time'               => '领取时间',
            'activity_turntable_id'    => '活动奖品',
            'activity_id'               => '活动id',
            'contact_info'              => '联系信息',
        ];
    }
}
