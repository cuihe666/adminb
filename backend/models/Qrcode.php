<?php

namespace backend\models;

use backend\controllers\QrcodeController;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * @author fuyanfei
 * @time   2017年3月25日13:18:10
 * @desc   qrcode表模型
 *
 * This is the model class for table "qrcode".
 *
 * @property integer $qrcode_id
 * @property integer $theme_id
 * @property integer $city_code
 * @property string  $qrcode_url
 * @property integer $scan_num
 * @property integer $create_time
 * @property integer $create_adminid
 * @property string  $text
 */
class Qrcode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $stime;
    public $activeTheme;
   /* public $city_code1;
    public $city_code2;
    public $city_code3;
    public $city_code4;*/

    /*public static function getDb()
    {
        return \Yii::$app->db1;
    }*/

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qrcode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['theme_id', 'city_code', 'scan_num', 'create_time', 'create_adminid'], 'integer'],
            [['theme_id','city_code'], 'required'],
            [['theme_id', 'city_code','qrcode_url', 'scan_num', 'create_time', 'create_adminid','text','custom1'], 'safe'],
            [['city_code','scan_num'], 'number'],
            [['qrcode_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qrcode_id'       => 'ID',
            'theme_id'        => '活动主题',
            'city_code'       => '区域',
            'qrcode_url'      => '二维码',
            'scan_num'        => '扫描量',
            'create_time'     => '添加时间',
            'create_adminid'  => '添加人',
            'text'            => '二维码',
            'custom1'         => '自定义参数1',
        ];
    }

    /**
     * 获取主题类型，返回数组格式的。
     * @return array
     */
    public static function getActiveTheme()
    {
        $activeTheme = \Yii::$app->db->createCommand("SELECT theme_id,theme_name  FROM `active_theme` WHERE status=1")->queryAll();
        return ArrayHelper::map($activeTheme, 'theme_id', 'theme_name');
    }

    /**
     * 获取所有城市，返回为数组格式的。
     * @return array
     */
    public static function getCity($province=null)
    {
        //筛选条件中包括省份筛选
        if (isset($province) && !empty($province)) {
            //父级code下所有市级信息
            $city = \Yii::$app->db->createCommand("SELECT code,name  FROM `dt_city_seas` WHERE parent={$province}")->queryAll();
        } else {
            $city = \Yii::$app->db->createCommand("SELECT code,name  FROM `dt_city_seas` WHERE level=2")->queryAll();
        }
        return ArrayHelper::map($city, 'code', 'name');
    }
    /**
     * 获取所有省份，返回为数组格式的。
     * @return array
     */
    public static function getProvince()
    {
        $province = \Yii::$app->db->createCommand("SELECT code,name  FROM `dt_city_seas` WHERE level=1")->queryAll();
        return ArrayHelper::map($province, 'code', 'name');
    }

    /**
     * 获取所有城市，返回为数组格式的。
     * @return array
     */
    public static function getRegionName($code)
    {
        $city = \Yii::$app->db->createCommand("SELECT name  FROM `dt_city_seas` WHERE code=".$code)->queryOne();
        return $city['name'];
    }
}
