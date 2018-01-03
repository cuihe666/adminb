<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "house_search".
 *
 * @property integer $id
 * @property integer $house_id
 * @property integer $sex
 * @property string $price
 * @property integer $maxguest
 * @property integer $roommode
 * @property integer $roomtype
 * @property integer $roomnum
 * @property integer $officenum
 * @property integer $bathnum
 * @property integer $kitchenum
 * @property integer $balconynum
 * @property integer $province
 * @property integer $city
 * @property integer $area
 * @property integer $street
 * @property integer $status
 * @property integer $national
 * @property integer $minguest
 * @property integer $bedcount
 * @property integer $online
 * @property integer $toward
 * @property integer $uid
 * @property integer $is_delete
 * @property double $avg_level
 * @property integer $comment_count
 * @property integer $tango_weight
 */
class HouseSearch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_search';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'maxguest', 'roommode', 'roomtype', 'status', 'minguest', 'uid'], 'required'],
            [['house_id', 'sex', 'maxguest', 'roommode', 'roomtype', 'roomnum', 'officenum', 'bathnum', 'kitchenum', 'balconynum', 'province', 'city', 'area', 'street', 'status', 'national', 'minguest', 'bedcount', 'online', 'toward', 'uid', 'is_delete', 'comment_count', 'tango_weight'], 'integer'],
            [['price', 'avg_level'], 'number'],
            ['tango_weight', 'safe', 'on' => 'sort']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'house_id' => 'House ID',
            'sex' => 'Sex',
            'price' => 'Price',
            'maxguest' => 'Maxguest',
            'roommode' => 'Roommode',
            'roomtype' => 'Roomtype',
            'roomnum' => 'Roomnum',
            'officenum' => 'Officenum',
            'bathnum' => 'Bathnum',
            'kitchenum' => 'Kitchenum',
            'balconynum' => 'Balconynum',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'street' => 'Street',
            'status' => 'Status',
            'national' => 'National',
            'minguest' => 'Minguest',
            'bedcount' => 'Bedcount',
            'online' => 'Online',
            'toward' => 'Toward',
            'uid' => 'Uid',
            'is_delete' => 'Is Delete',
            'avg_level' => 'Avg Level',
            'comment_count' => 'Comment Count',
            'tango_weight' => 'Tango Weight',
        ];
    }

    /*
     * 将传过来的房源id字符串进行上佳状态的过滤
     * 返回字符串中有效上架数据id字符串
     * */
    public static function getFileterHid($params){
        $params = trim($params,',');
        $str = '';
        if($params){
            $whole_data = Yii::$app->db->createCommand("select house_id,online,status from house_search where house_id in($params)")->queryAll();
            if(!empty($whole_data)){
                foreach($whole_data as $k=>$v){
                    if($v['online'] == 1 && $v['status'] == 1){
                        $str .= $v['house_id'].',';
                    }
                }
            }
        }
        return trim($str,',');
    }
}
