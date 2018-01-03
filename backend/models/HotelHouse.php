<?php

namespace backend\models;

use backend\controllers\QrcodeController;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * @author fuyanfei
 * @time   2017年4月18日13:27:48
 * @desc   hotel表模型
 *
 * This is the model class for table "hotel_house".
 *
 * @property integer $id
 * @property string  $name
 * @property integer $breakfast
 * @property integer $max_num
 * @property integer $room_size
 * @property string  $sale_time
 * @property integer $refund_type
 * @property integer $refund_time
 * @property integer $type
 * @property integer $is_window
 * @property integer $hotel_id
 * @property string  $pic_desc
 * @property string  $pic
 * @property string  $cover_img
 * @property integer $status
 */
class HotelHouse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_house';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['breakfast', 'max_num', 'room_size', 'refund_type','type','is_window','hotel_id','status'], 'integer'],
            [['name','breakfast','type','max_num','room_size','refund_type'], 'required'],
            [['name','breakfast', 'max_num', 'room_size','sale_time', 'refund_type', 'refund_time','type','is_window','hotel_id','pic_desc','pic','cover_img','status'],'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => '酒店ID',
            'name'             => '房型名称',
            'breakfast'        => '早餐',
            'max_num'          => '最大可住人数',
            'room_size'        => '面积',
            'sale_time'        => '售卖时段',
            'refund_type'      => '取消政策',
            'refund_time'      => '取消时间',
            'type'             => '床型',
            'is_window'        => '是否有窗',
            'hotel_id'         => '所属酒店',
            'pic'              => '房型图片',
            'cover_img'        => '房型首图',
            'status'           => '售卖状态',
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
}
