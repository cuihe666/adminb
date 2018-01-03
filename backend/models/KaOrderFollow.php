<?php

namespace backend\models;

use Yii;

/**
 * @author fuyanfei
 * @time   2017年3月20日13:19:22
 * @desc   ka_order_follow表模型
 *
 * @property integer $followid
 * @property integer $orderid
 * @property integer $follow_time
 * @property string  $follow_adminname
 * @property string  $follow_remark
 * @property string  $follow_logs
 * @property integer $follow_status
 * @property string  $follow_file
 */
class KaOrderFollow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ka_order_follow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderid','follow_time','follow_adminname','follow_status','follow_logs'],'required'],
            [['follow_file'],'file'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'followid'         => 'ID',
            'orderid'          => '订单ID',
            'follow_time'      => '跟进时间',
            'follow_adminname' => '跟进人',
            'follow_remark'    => '跟进内容',
            'follow_status'    => '跟进状态',
            'follow_logs'      => '操作内容',
            'follow_file'      => '附件'
        ];
    }
}
