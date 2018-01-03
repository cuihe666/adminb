<?php

namespace backend\service;
use Yii;
/**
 * 旅游标签的service
 */
class TravelTagService
{
    /**
     * 根据type类型和note_type游记类目获取所有标签
     * @param int  $type            类型
     * @param int  $note_type       游记类目（选填参数）
     * @return array
     */
    public static function getTagReturnKeyValue($type,$note_type="")
    {
        if($note_type)
            $sql = "select id,title,sort from travel_tag WHERE  type = ".$type." AND note_type=".$note_type." and status = 1";
        else
            $sql = "select id,title,sort from travel_tag WHERE  type = ".$type." AND  status = 1";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        $result = [];
        if($data){
            foreach($data as $key=>$val){
                $result[$val['id']] = $val['title'];
            }
        }
        return $result;
    }


    public static  function getTagById($id,$type=""){
        if($type)
            $sql = "select id,title,sort from travel_tag WHERE  type = ".$type." AND id in (".$id.") and status = 1";
        else
            $sql = "select id,title,sort from travel_tag WHERE  id in (".$id.") AND  status = 1";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        $result = "";
        if($data){
            foreach($data as $key=>$val){
                $result .= $val['title'].",";
            }
        }
        $res = rtrim($result,",");
        return $res;
    }




}


