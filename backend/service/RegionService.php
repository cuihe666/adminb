<?php

namespace backend\service;
use backend\models\HouseCityMdl;
use Yii;
/**
 * 区域操作的service
 */
class RegionService
{
    /**
     * 获取区域的map格式
     * @author : 付燕飞
     * @date   : 2017年3月28日15:55:31
     * @param  : $level
     * @return : array
     */
    public static function getRegion($level,$code)
    {
        $region = Yii::$app->db->createCommand("select name,code from dt_city_seas where level = $level and parent = ".$code)->queryAll();
        $result = [];
        if(!empty($region)){
            foreach($region as $key=>$val){
                $result[$val['code']] = $val['name'];
            }
        } else {
            $result[$code] = '全境';
        }
        return $result;
    }

    /**
     * 根据区域名称获取区域编码
     * @param $city_name
     * @return bool
     */
    public static function get_code($name,$level)
    {
        $data = \Yii::$app->db->createCommand("select * from dt_city_seas WHERE name LIKE '%{$name}%' AND level=".$level)->queryOne();
        if (!$data) {
            return false;
        }
        return $data['code'];
    }

    /**
     * 通过城市code查找城市唯一ID
     */
    public static function getCityCode($id)
    {
        $data = Yii::$app->redis->get('city_code_php');
        if (!$data) {
            $data = HouseCityMdl::find()->where(['arealevel' => 4])->select('areano,areacode')->asArray()->all();
            $key = array_column($data, 'areano');
            $value = array_column($data, 'areacode');
            $data = array_combine($key, $value);
            $arr = serialize($data);
            Yii::$app->redis->set('city_code_php', $arr);
            return $data[$id];
        }
        $data = unserialize($data);
        $bool = array_key_exists($id, $data);
        if (!$bool) {
            return '';
        }
        return $data[$id];
    }

    /**
     * 根据城市编码获取城市名称
     * @param $citycode
     * @return string
     */
    public static function getCityName($citycode){
        //$sql = "select d1.code,d1.name,d2.code as pcode,d2.name as pname,d3.code as gcode,d3.name as gname from dt_city_seas as d1 left join dt_city_seas as d2 on d1.parent = d2.code left join dt_city_seas as d3 on d2.parent = d3.code WHERE d1.code = {$citycode} AND d2.code= {$provicecode} and d3.code = {$countrycode}";
        $sql = "select d1.code,d1.name from dt_city_seas as d1 WHERE d1.code = {$citycode}";
        $data = Yii::$app->db->createCommand($sql)->queryOne();
        $result = "";
        if(!empty($data)){
            $result = $data['name'];
        }
        return $result;
    }

    /**
     * 根据城市名称 模糊查询数据，获取城市+省份(国外的城市+国家)
     * @param string $name
     * @return array
     */
    public static function getCityByName($name){
        $data = \Yii::$app->db->createCommand("select d1.code,d1.name,d2.code as pcode,d2.name as pname,d3.code as gcode,d3.name as gname from dt_city_seas as d1 left join dt_city_seas as d2 on d1.parent = d2.code left join dt_city_seas as d3 on d2.parent = d3.code WHERE d1.name LIKE '%{$name}%' AND d1.level= 2")->queryAll();
        $result = [];
        if(!empty($data)){
            foreach($data as $key=>$val){
                if($val['gcode']=='10001')
                    $result[$val['gcode'].",".$val['pcode'].",".$val['code']] = $val['name'].",".$val['pname'];
                else
                    $result[$val['gcode'].",".$val['pcode'].",".$val['code']] = $val['name'].",".$val['gname'];
            }
        }
        return $result;
    }


}


