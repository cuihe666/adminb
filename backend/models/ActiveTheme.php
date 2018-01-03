<?php

namespace backend\models;

use Yii;

/**
 * @author fuyanfei
 * @time   2017-3-25 13:34:44
 * @desc   active_theme表模型
 *
 * This is the model class for table "active_theme".
 *
 * @property integer $theme_id
 * @property string  $theme_name
 * @property string  $theme_url
 * @property string  $start_date
 * @property integer $end_date
 * @property string  $higo_id_str
 * @property integer $status
 * @property integer $create_time
 * @property integer $create_adminid
 */
class ActiveTheme extends \yii\db\ActiveRecord
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
        return 'active_theme';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        //
        return [
            [['start_date', 'end_date', 'status', 'create_time', 'create_adminid'], 'integer'],
            //[['theme_name','theme_url','stime','status'], 'required'],
            [['theme_name','theme_url'], 'required'],
            [['theme_name', 'theme_url','start_date', 'end_date','higo_id_str', 'status', 'create_time','create_adminid','stime'], 'safe'],
            [['theme_url'],'match','pattern'=>'/^((ht|f)tps?):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/','message'=>'Url格式不正确']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'theme_id'        => 'ID',
            'theme_name'      => '活动主题',
            'theme_url'       => '活动Url',
            'start_date'      => '开始时间',
            'end_date'        => '结束时间',
            'higo_id_str'     => '请选择参与此活动的主题线路',
            'status'          => '状态',
            'create_time'     => '添加时间',
            'create_adminid'  => '添加人',
            'stime'           => '开始日期—结束日期',
        ];
    }
}
