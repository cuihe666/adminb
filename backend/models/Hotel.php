<?php

namespace backend\models;

use backend\controllers\QrcodeController;
use common\tools\Helper;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * @author fuyanfei
 * @time   2017年4月18日13:27:48
 * @desc   hotel表模型
 *
 * This is the model class for table "hotel".
 *
 * @property integer $id
 * @property string  $complete_name
 * @property string  $short_name
 * @property integer $type
 * @property integer $province
 * @property integer $city
 * @property integer $area
 * @property integer $supplier_id
 * @property integer $status
 * @property string  $address
 * @property string  $longitude
 * @property string  $latitude
 * @property string  $mobile_area
 * @property integer $mobile
 * @property integer $fax_area
 * @property string  $fax
 * @property string  $postcode
 * @property integer $opening_year
 * @property integer $renovation_year
 * @property integer $total_stock
 * @property string  $introduction
 * @property string  $feature
 * @property integer $in_time
 * @property integer $out_time
 * @property integer $prompt
 * @property integer $admin_id
 */
class Hotel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'province', 'city', 'area', 'supplier_id','status','mobile','fax','opening_year','renovation_year','total_stock','in_time','out_time','admin_id'], 'integer'],
            [['complete_name','type','province','city','area','address','mobile','introduction','mobile_type'], 'required'],
            [['short_name','supplier_id','status','address','longitude','latitude','mobile_area','fax_area','fax','postcode','opening_year','renovation_year','total_stock','feature','in_time','out_time','prompt','sale_time','admin_id'],'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                 => '酒店ID',
            'complete_name'      => '酒店名称',
            'short_name'         => '酒店简称',
            'type'               => '酒店类型',
            'province'           => '省/市/区',
            'city'               => '省/市/区',
            'area'               => '省/市/区',
            'address'            => '酒店地址',
            'status'             => '状态',
            'check_status'      => '审核状态',
            'mobile_area'        => '电话区号',
            'mobile_area'        => '前台电话区号',
            'mobile'             => '前台电话',
            'fax_area'           => '传真区号',
            'fax'                => '酒店传真',
            'postcode'           => '邮编',
            'opening_year'       => '开业年份',
            'renovation_year'    => '最新装修',
            'total_stock'        => '库存总数',
            'introduction'       => '酒店简介',
            'feature'            => '酒店特色',
            'in_time'            => '入住时间',
            'out_time'           => '离店时间',
            'prompt'             => '发票提示',
            'admin_id'           => '添加人',
            'supplier_id'        => '关联供应商ID',
            'update_time'        => '上线时间',
            'supplier_relation' => '关联状态',
        ];
    }

    public function getSupplier()
    {
        return $this->hasOne(HotelSupplier::className(), ['id' => 'supplier_id']);
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

    //获取城市信息
    public function getCityName(){
        return $this->hasOne(DtCitySeas::className(),['code' => 'city'])->select(['code','name']);
    }

    //获取完整的酒店地址
    public function getWholeAddress(){
        $address_list  = DtCitySeas::find()
            ->where(['IN','code',[$this->province,$this->city,$this->area]])
            ->select(['code','name'])
            ->asArray()
            ->all();
        $address_list = ArrayHelper::map($address_list,'code','name');

        return $address_list[$this->province] . $address_list[$this->city] . $address_list[$this->area] . $this->address;
    }

    //获取完整的酒店电话
    public function getWholeMobile(){
        return $this->mobile_area . '-' . $this->mobile;
    }
}
