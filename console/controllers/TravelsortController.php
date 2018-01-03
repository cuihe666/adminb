<?php
/**
 * @author: snowno
 * @info  : 标签排序
 */
namespace console\controllers;
use backend\controllers\TravelHigoManageController;
use backend\service\CommonService;
use Yii;
use yii\base\Exception;

date_default_timezone_set('PRC');

class TravelsortController extends \yii\console\Controller
{

    public function actionChecksort(){
        $travelHigo = Yii::$app->db->createCommand("SELECT * FROM travel_higo WHERE sort_prepare!='0' AND sort_start_date!='' AND sort_end_date!=''")->queryAll();

        $current_date = date('Y-m-d').' 00:00:00';
        $trans = Yii::$app->db->beginTransaction();
        if($travelHigo){
            try{
                foreach($travelHigo as $k=>$v){
                    $id = $v['id'];
                    $sort = $v['sort_prepare'];
                    $sort_start_time = $v['sort_start_date'];
                    $sort_end_time = $v['sort_end_date'];
//                    if(($current_date >= $sort_start_time) && ($current_date < $sort_end_time)){
                    if($current_date == $sort_start_time){//废用以上判断，以避免一条排序每天crontab写入日志
                        $updateHigo = Yii::$app->db->createCommand("UPDATE travel_higo SET  sort='{$sort}' WHERE id=$id")->execute();
                        $remarks = date("Y-m-d H:i:s")."&nbsp;商品管理员：将ID为".$id."的主题线路的排序改为：".$sort."&nbsp;有效期为：".$sort_start_time."&nbsp;至&nbsp;".$sort_end_time;
                        //添加操作日志信息
                        $res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(type,obj_id,create_time,status,reason,remarks) VALUES (:type,:obj_id,:create_time,:status,:reason,:remarks)")
                            ->bindValue(":type",4)
                            ->bindValue(":obj_id",$id)
                            ->bindValue(":create_time",date("Y-m-d H:i:s",time()))
                            ->bindValue(":status",9)
                            ->bindValue(":reason","")
                            ->bindValue(":remarks",$remarks)
                            ->execute();
                    }
                    if($current_date > $sort_end_time){
                        $updateHigoOver = Yii::$app->db->createCommand("UPDATE travel_higo SET  sort='0', sort_prepare='0' WHERE id=$id")->execute();
                        $remarks = "由于排序有效期已过，".date("Y-m-d H:i:s")."&nbsp;商品管理员：将ID为".$id."的主题线路的排序改为：0 ";
                        //添加操作日志信息
                        $res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(type,obj_id,create_time,status,reason,remarks) VALUES (:type,:obj_id,:create_time,:status,:reason,:remarks)")
                            ->bindValue(":type",4)
                            ->bindValue(":obj_id",$id)
                            ->bindValue(":create_time",date("Y-m-d H:i:s",time()))
                            ->bindValue(":status",9)
                            ->bindValue(":reason","")
                            ->bindValue(":remarks",$remarks)
                            ->execute();
                    }
                }
                $trans->commit();

            }catch(Exception $e){
                $higoCatchErrors = $e->getMessage();
                $strArr = array();
                if(!empty($higoCatchErrors)){
                    foreach ($higoCatchErrors as $k => $v) {
                        foreach ($v as $kk => $vv) {
                            $strArr[] = $vv;
                        }
                    }
                }
                if(!empty($strArr)){
                    $str = ''; //记录错误信息
                    foreach ($strArr as $k => $v) {
                        $str .= ($k + 1) . '.' . $v;
                    }
                    //写入操作日志（记录错误reason） snowno add at 2017/09/12 pm
                    $higo_remark = date("Y-m-d H:i:s")."&nbsp;商品管理员：修改主题线路的排序操作失败";
                    $higo_reason = $str;
                    //添加操作日志信息
                    $err_res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(type,obj_id,create_time,status,reason,remarks) VALUES (:type,:obj_id,:create_time,:status,:reason,:remarks)")
                        ->bindValue(":type",4)
                        ->bindValue(":obj_id",'')
                        ->bindValue(":create_time",date("Y-m-d H:i:s",time()))
                        ->bindValue(":status",9)
                        ->bindValue(":reason",$higo_reason)
                        ->bindValue(":remarks",$higo_remark)
                        ->execute();
                }
                $trans->rollBack();
            }
        }
        $travelActivity = Yii::$app->db->createCommand("SELECT * FROM travel_activity WHERE sort_prepare!='0' AND sort_start_date!='' AND sort_end_date!=''")->queryAll();
        if($travelActivity){
            $trans2 = Yii::$app->db->beginTransaction();
            try{
                foreach($travelActivity as $kk=>$vv){
                    $id = $vv['id'];
                    $sort = $vv['sort_prepare'];
                    $sort_start_time = $vv['sort_start_date'];
                    $sort_end_time = $vv['sort_end_date'];
                    if($current_date == $sort_start_time){
                        $updateActivity = Yii::$app->db->createCommand("UPDATE travel_activity SET  sort='{$sort}'  WHERE id=$id")->execute();
                        $remarks = date("Y-m-d H:i:s")."&nbsp;商品管理员：将ID为".$id."的当地活动的排序改为：".$sort."&nbsp;有效期为：".$sort_start_time."&nbsp;至&nbsp;".$sort_end_time;
                        //添加操作日志信息
                        $res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(type,obj_id,create_time,status,reason,remarks) VALUES (:type,:obj_id,:create_time,:status,:reason,:remarks)")
                            ->bindValue(":type",3)
                            ->bindValue(":obj_id",$id)
                            ->bindValue(":create_time",date("Y-m-d H:i:s",time()))
                            ->bindValue(":status",9)
                            ->bindValue(":reason","")
                            ->bindValue(":remarks",$remarks)
                            ->execute();
                    }
                    if($current_date > $sort_end_time){
                        $updateActivityOver = Yii::$app->db->createCommand("UPDATE travel_activity SET  sort='0', sort_prepare='0' WHERE id=$id")->execute();
                        $remarks = "由于排序有效期已过，".date("Y-m-d H:i:s")."&nbsp;商品管理员：将ID为".$id."的当地活动的排序改为：0 ";
                        //添加操作日志信息
                        $res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(type,obj_id,create_time,status,reason,remarks) VALUES (:type,:obj_id,:create_time,:status,:reason,:remarks)")
                            ->bindValue(":type",3)
                            ->bindValue(":obj_id",$id)
                            ->bindValue(":create_time",date("Y-m-d H:i:s",time()))
                            ->bindValue(":status",9)
                            ->bindValue(":reason","")
                            ->bindValue(":remarks",$remarks)
                            ->execute();
                    }
                }
                $trans2->commit();
            }catch(Exception $e){
                $strArr = array();
                $activityCatchErrors = $e->getMessage();
                if(!empty($activityCatchErrors)){
                    foreach ($activityCatchErrors as $k => $v) {
                        foreach ($v as $kk => $vv) {
                            $strArr[] = $vv;
                        }
                    }
                }
                if(!empty($strArr)){
                    $str = ''; //记录错误信息
                    foreach ($strArr as $k => $v) {
                        $str .= ($k + 1) . '.' . $v;
                    }
                    //写入操作日志（记录错误reason） snowno add at 2017/09/12 pm
                    $activity_remark = date("Y-m-d H:i:s")."&nbsp;商品管理员：修改当地活动的排序操作失败";
                    $activity_reason = $str;
                    //添加操作日志信息
                    $err_res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(type,obj_id,create_time,status,reason,remarks) VALUES (:type,:obj_id,:create_time,:status,:reason,:remarks)")
                        ->bindValue(":type",3)
                        ->bindValue(":obj_id",'')
                        ->bindValue(":create_time",date("Y-m-d H:i:s",time()))
                        ->bindValue(":status",9)
                        ->bindValue(":reason",$activity_reason)
                        ->bindValue(":remarks",$activity_remark)
                        ->execute();
                }
                $trans2->rollBack();

            }

        }
        $travelImpress = Yii::$app->db->createCommand("SELECT * FROM travel_impress WHERE sort_prepare!='0' AND sort_start_date!='' AND sort_end_date!=''")->queryAll();
        if($travelImpress){
            $trans3 = Yii::$app->db->beginTransaction();
            try{
                foreach($travelImpress as $a=>$b){
                    $id = $b['id'];
                    $sort = $b['sort_prepare'];
                    $sort_start_time = $b['sort_start_date'];
                    $sort_end_time = $b['sort_end_date'];
                    if($current_date == $sort_start_time){
                        $updateImpress = Yii::$app->db->createCommand("UPDATE travel_impress SET  sort='{$sort}' WHERE id=$id")->execute();
                        $remarks = date("Y-m-d H:i:s")."&nbsp;商品管理员：将ID为".$id."的印象的排序改为：".$sort."&nbsp;有效期为：".$sort_start_time."&nbsp;至&nbsp;".$sort_end_time;
                        //添加操作日志信息
                        $res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(type,obj_id,create_time,status,reason,remarks) VALUES (:type,:obj_id,:create_time,:status,:reason,:remarks)")
                            ->bindValue(":type",5)
                            ->bindValue(":obj_id",$id)
                            ->bindValue(":create_time",date("Y-m-d H:i:s",time()))
                            ->bindValue(":status",9)
                            ->bindValue(":reason","")
                            ->bindValue(":remarks",$remarks)
                            ->execute();
                    }
                    if($current_date > $sort_end_time){
                        $updateImpressOver = Yii::$app->db->createCommand("UPDATE travel_impress SET  sort='0', sort_prepare='0' WHERE id=$id")->execute();
                        $remarks = "由于排序有效期已过，".date("Y-m-d H:i:s")."&nbsp;商品管理员：将ID为".$id."的印象的排序改为：0 ";
                        //添加操作日志信息
                        $res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(type,obj_id,create_time,status,reason,remarks) VALUES (:type,:obj_id,:create_time,:status,:reason,:remarks)")
                            ->bindValue(":type",5)
                            ->bindValue(":obj_id",$id)
                            ->bindValue(":create_time",date("Y-m-d H:i:s",time()))
                            ->bindValue(":status",9)
                            ->bindValue(":reason","")
                            ->bindValue(":remarks",$remarks)
                            ->execute();
                    }
                }
                $trans3->commit();
            }catch(Exception $e){
                $strArr = array();
                $impressCatchErrors = $e->getMessage();
                if(!empty($impressCatchErrors)){
                    foreach ($impressCatchErrors as $k => $v) {
                        foreach ($v as $kk => $vv) {
                            $strArr[] = $vv;
                        }
                    }
                }
                if(!empty($strArr)){
                    $str = ''; //记录错误信息
                    foreach ($strArr as $k => $v) {
                        $str .= ($k + 1) . '.' . $v;
                    }
                    //写入操作日志（记录错误reason） snowno add at 2017/09/12 pm
                    $impress_remark = date("Y-m-d H:i:s")."&nbsp;商品管理员：修改印象的排序操作失败";
                    $impress_reason = $str;
                    //添加操作日志信息
                    $err_res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(type,obj_id,create_time,status,reason,remarks) VALUES (:type,:obj_id,:create_time,:status,:reason,:remarks)")
                        ->bindValue(":type",5)
                        ->bindValue(":obj_id",'')
                        ->bindValue(":create_time",date("Y-m-d H:i:s",time()))
                        ->bindValue(":status",9)
                        ->bindValue(":reason",$impress_reason)
                        ->bindValue(":remarks",$impress_remark)
                        ->execute();
                }
                $trans3->rollBack();
            }

        }

        //游记
        $travelNote = Yii::$app->db->createCommand("SELECT * FROM travel_note WHERE sort_prepare!='0' AND sort_start_date!='' AND sort_end_date!=''")->queryAll();
        if($travelNote){
            $trans4 = Yii::$app->db->beginTransaction();
            try{
                foreach($travelNote as $c=>$d){
                    $id = $d['id'];
                    $sort = $d['sort_prepare'];
                    $sort_start_time = $d['sort_start_date'];
                    $sort_end_time = $d['sort_end_date'];
                    if($current_date == $sort_start_time){
                        $updateNote = Yii::$app->db->createCommand("UPDATE travel_note SET  sort='{$sort}' WHERE id=$id")->execute();
                        $remarks = date("Y-m-d H:i:s")."&nbsp;商品管理员：将ID为".$id."的游记的排序改为：".$sort."&nbsp;有效期为：".$sort_start_time."&nbsp;至&nbsp;".$sort_end_time;
                        //添加操作日志信息
                        $res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(type,obj_id,create_time,status,reason,remarks) VALUES (:type,:obj_id,:create_time,:status,:reason,:remarks)")
                            ->bindValue(":type",6)
                            ->bindValue(":obj_id",$id)
                            ->bindValue(":create_time",date("Y-m-d H:i:s",time()))
                            ->bindValue(":status",9)
                            ->bindValue(":reason","")
                            ->bindValue(":remarks",$remarks)
                            ->execute();
                    }
                    if($current_date > $sort_end_time){
                        $updateNoteOver = Yii::$app->db->createCommand("UPDATE travel_note SET  sort='0', sort_prepare='0' WHERE id=$id")->execute();
                        $remarks = "由于排序有效期已过，".date("Y-m-d H:i:s")."&nbsp;商品管理员：将ID为".$id."的游记的排序改为：0 ";
                        //添加操作日志信息
                        $res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(type,obj_id,create_time,status,reason,remarks) VALUES (:type,:obj_id,:create_time,:status,:reason,:remarks)")
                            ->bindValue(":type",6)
                            ->bindValue(":obj_id",$id)
                            ->bindValue(":create_time",date("Y-m-d H:i:s",time()))
                            ->bindValue(":status",9)
                            ->bindValue(":reason","")
                            ->bindValue(":remarks",$remarks)
                            ->execute();
                    }
                }
                $trans4->commit();
            }catch(Exception $e){
                $strArr = array();
                $noteCatchErrors = $e->getMessage();
                if(!empty($noteCatchErrors)){
                    foreach ($noteCatchErrors as $k => $v) {
                        foreach ($v as $kk => $vv) {
                            $strArr[] = $vv;
                        }
                    }
                }
                if(!empty($strArr)){
                    $str = ''; //记录错误信息
                    foreach ($strArr as $k => $v) {
                        $str .= ($k + 1) . '.' . $v;
                    }
                    //写入操作日志（记录错误reason） snowno add at 2017/09/12 pm
                    $note_remark = date("Y-m-d H:i:s")."&nbsp;商品管理员：修改印象的排序操作失败";
                    $note_reason = $str;
                    //添加操作日志信息
                    $err_res = Yii::$app->db->createCommand("INSERT INTO travel_operation_log(type,obj_id,create_time,status,reason,remarks) VALUES (:type,:obj_id,:create_time,:status,:reason,:remarks)")
                        ->bindValue(":type",6)
                        ->bindValue(":obj_id",'')
                        ->bindValue(":create_time",date("Y-m-d H:i:s",time()))
                        ->bindValue(":status",9)
                        ->bindValue(":reason",$note_reason)
                        ->bindValue(":remarks",$note_remark)
                        ->execute();
                }
                $trans4->rollBack();
            }

        }
    }
}