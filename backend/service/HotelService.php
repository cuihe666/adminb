<?php

namespace backend\service;
use Yii;
/**
 * 酒店相关信息的service
 * @author  : 付燕飞
 * @date    : 2017-4-19 10:08:39
 */
class HotelService
{
    /**
     * 获取酒店设施的map格式
     * @param  : int $type
     * @return : array
     */
    public static function getFacilitiesByType($type)
    {
        $facilities = Yii::$app->db->createCommand("select * from hotel_facilities where type_id = :type_id")
            ->bindValue(":type_id",$type)
            ->queryAll();
        $result = [];
        if(!empty($facilities)){
            foreach($facilities as $key=>$val){
                $result[$val['id']] = $val['facilities_name'];
            }
        }
        return $result;
    }

    /**
     * 获取酒店设施的map格式
     * @return : array
     */
    public static function getAllFacilities()
    {
        $facilities = Yii::$app->db->createCommand("select * from hotel_facilities")->queryAll();
        $result = [];
        if(!empty($facilities)){
            //遍历所有的设施服务，根据type_id分组成为二维数组，二维数组中的每个一维数组的key是设施服务的id，value是设施服务的名称。
            foreach($facilities as $key=>$val){
                $result[$val['type_id']][$val['id']] = $val['facilities_name'];
            }
        }
        return $result;
    }

}


