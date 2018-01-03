<?php

namespace backend\models;

use common\tools\Helper;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "hotel_supplier".
 *
 * @property integer $id
 * @property string $name
 * @property integer $city
 * @property integer $province
 * @property integer $country
 * @property string $address
 * @property integer $postcode
 * @property integer $type
 * @property string $brand
 * @property integer $settle_type
 * @property integer $status
 * @property integer $invoice_status
 * @property string $start_time
 * @property string $end_time
 * @property string $business_license
 * @property string $license
 * @property string $agreement
 * @property string $other
 * @property string $create_time
 */
class HotelSupplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city', 'province', 'country', 'postcode', 'type', 'settle_type', 'status'], 'integer'],
            [['start_time', 'end_time', 'create_time'], 'safe'],
            ['invoice_status' ,'string','max'=>11],
            ['name', 'string', 'max' => 100],
            [['business_license', 'license', 'agreement', 'other'], 'string', 'max' => 2000],
            [['address'], 'string', 'max' => 200],
            [['brand'], 'string', 'max' => 50],
            ['name','required'],
            ['city','required'],
            ['province','required'],
            ['country','required'],
            ['address','required'],
            ['type','required'],
            ['settle_type','required'],
        ];
    }

    //获取关联酒店信息 仅限五条
    public function getHotels(){
        return $this->hasMany(Hotel::className(),['supplier_id' => 'id'])->where(['supplier_relation' => 1,'status'=>1])->select(['id','complete_name','short_name','supplier_id','status']);
    }
    //获取城市信息
    public function getCityName(){
        return $this->hasOne(DtCitySeas::className(),['code' => 'city'])->select(['code','name']);
    }

    //获取供应商的城市列表
    public function hotelList(){
        $arr = $this->getHotels()->select(['id','complete_name'])->asArray()->all();
        $arr = ArrayHelper::map($arr,'id','complete_name');
        return $arr;
    }

    //获取供应商的结算记录
    public function getSettleList($condition=[]){
        $query =  $this->hasMany(HotelSupplierSettlement::className(),['supplier_id' => 'id']);

        if(!empty($condition)){
            $query->where($condition);
        }else{
            $lastMonth = Helper::lastMonth();
            $lastWeek = Helper::lastWeek();
            $query->orWhere([
                'start_time' => $lastMonth[0],
                'end_time' => $lastMonth[1],
            ])->orWhere([
                'start_time' => $lastWeek[0],
                'end_time' => $lastWeek[1],
            ])->orderBy(['id' => SORT_DESC]);
        }
        return $query;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '供应商ID',
            'name' => '供应商名称',
            'city' => '城市编码',
            'province' => '省市编码',
            'country' => '国家编码',
            'address' => '详细地址',
            'postcode' => '邮政编码',
//            'type' => '1=>个体工商,2=>集团连锁,3=>管理公司,4=>平台',
            'type' => '供应商类型',
            'brand' => '供应商品牌',
//            'settle_type' => '0=>周结 1=>月结',
            'settle_type' => '结算周期',
            'status' => '0=>待审核 1=>已用过 2=>拒绝 3=>停用',
            'invoice_status' => '账单结算状态',
            'start_time' => '协议有效开始时间',
            'end_time' => '协议有效结束时间',
            'business_license' => '营业执照',
            'license' => '许可证',
            'agreement' => '合作协议',
            'other' => '其它',
            'create_time' => '创建时间',
            'hotels' => '关联酒店'
        ];
    }

    public function startTime(){
        return substr($this->start_time,0,10);
    }

    public function endTime(){
        return substr($this->end_time,0,10);
    }

}
