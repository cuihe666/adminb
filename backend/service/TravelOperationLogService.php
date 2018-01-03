<?php

namespace backend\service;
use Yii;
/**
 * 旅游操作日志的service
 */
class TravelOperationLogService
{
    /**
     * 根据obj_id 和 type 读取相应的操作日志
     * @param int  $obj_id     对应的对象id
     * @param int  $type       对应的对象类型 1=>个人信息，2=>公司信息,3=>'活动'，4=>‘主题’,5=>'印象',6=>'游记',7=>'当地向导'
     * @return array
     */
    public static function getLogList($obj_id,$type)
    {
        if(!$obj_id || !$type){
            return [
                'code' => 1010,
                'msg'  => Yii::$app->params['travel_code']['1010'],
            ];
        }
        $list = Yii::$app->db->createCommand("SELECT * FROM travel_operation_log WHERE TYPE = :type AND obj_id = :obj_id")
            ->bindValue(":type",$type)
            ->bindValue(":obj_id",$obj_id)
            ->queryAll();
        $result = [
            'code' => 1000,
            'msg'  => Yii::$app->params['travel_code']['1000'],
        ];
        $result['list'] = $list;
        return $result;
    }

    /**
     * 添加操作日志
     * @param $type                 类型 1=>个人信息，2=>公司信息,3=>'活动'，4=>‘主题’,5=>'印象',6=>'游记',7=>'当地向导'
     * @param $obj_id               对应对象的id
     * @param $status               状态 -1=>已删除,0=>未审核 1=>上线 2=>下线 3=>未通过 4=>草稿 9=>修改排序
     * @param string $reason        原因
     * @param string $remarks       备注
     * @return array
     * @throws \yii\db\Exception
     */
    public static function insertLog($type,$obj_id,$status,$reason="",$remarks=""){
        if(!$obj_id || !$type || !$status){
            return [
                'code' => 1010,
                'msg'  => Yii::$app->params['travel_code']['1010'],
            ];
        }
        //如果执行的状态为未通过，未通过的原因为必填项。
        if($status==3 && $reason==""){
            return [
                'code' => 1020,
                'msg'  => Yii::$app->params['travel_code']['1020'],
            ];
        }
        //获取当前登录的用户名
        $user = Yii::$app->user->identity['username'];
        $date_time = date("Y-m-d H:i:s",time());
        //添加操作日志信息
        $res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(uname,type,obj_id,create_time,status,reason,remarks) VALUES (:uname,:type,:obj_id,:create_time,:status,:reason,:remarks)")
            ->bindValue(":uname",$user)
            ->bindValue(":type",$type)
            ->bindValue(":obj_id",$obj_id)
            ->bindValue(":create_time",$date_time)
            ->bindValue(":status",$status)
            ->bindValue(":reason",$reason)
            ->bindValue(":remarks",$remarks)
            ->execute();
        if($res){
            $result = [
                'code' => 1000,
                'msg'  => Yii::$app->params['travel_code']['1000'],
            ];
        } else{
            $result = [
                'code' => 1009,
                'msg'  => Yii::$app->params['travel_code']['1009'],
            ];
        }
        $result['res'] = $res;
        return $result;
    }
}


