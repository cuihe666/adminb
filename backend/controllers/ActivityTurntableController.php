<?php

namespace backend\controllers;

use backend\models\ActiveTheme;
use backend\models\TgActivityTurntableAward;
use backend\models\TgActivityTurntableAwardQuery;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
/**
 * @author:fuyanfei
 * @date:2017-10-31 10:46:40
 * @info:大转盘活动
 * ActivityTurntableController implements the CRUD actions for TravelPerson model.
 */
class ActivityTurntableController extends Controller
{
    public $enableCsrfValidation = false;
    public $activity_id = 1;

    /**
     * 查询大转盘活动中奖
     */
    public function actionIndex()
    {
        //实例化TgActivityTurntableAwardQuery
        $searchModel=new TgActivityTurntableAwardQuery();
        $searchModel->activity_id = $this->activity_id;
        //获取中奖信息
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //获取奖品信息
        $awardList = Yii::$app->db->createCommand("SELECT id,award_name FROM tg_activity_turntable WHERE activity_id = :activity_id")
            ->bindValue(":activity_id",$this->activity_id)
            ->queryAll();
        $awardArr = array_column($awardList,"award_name","id");
        return $this->render('index',[
            'method'=>'index',
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
            'awardArr' => $awardArr,
        ]);
    }

    /**
     * 中奖概述
     * @return string
     */
    public function actionInfo(){
        //活动信息
        $activityInfo = Yii::$app->db->createCommand("SELECT * FROM tg_activity WHERE id = :id")
            ->bindValue(":id",$this->activity_id)
            ->queryOne();
        //抽奖记录
        $logs = Yii::$app->db->createCommand("SELECT id FROM tg_activity_turntable_logs WHERE activity_id = :activity_id")
            ->bindValue(":activity_id",$this->activity_id)
            ->queryAll();
        //所有的奖品信息
        $list = Yii::$app->db->createCommand("SELECT award_name,award_stock,residue_stock FROM tg_activity_turntable WHERE activity_id = :activity_id")
            ->bindValue(":activity_id",$this->activity_id)
            ->queryAll();
        $sendNum = 0;
        $surplusNum = 0;
        foreach($list as $key=>$val){
            if($key!=5){
                $sendNum += ($val['award_stock']-$val['residue_stock']);
                $surplusNum += $val['residue_stock'];
            }
        }
        //读取新用户信息
        $newUser = Yii::$app->db->createCommand("SELECT id FROM user WHERE source = :source")
            ->bindValue(":source",$activityInfo['user_source'])
            ->queryAll();
        return $this->render('info',[
            'method'=>'index',
            'activityInfo'=>$activityInfo,
            'drawNum' => count($logs),
            'awardList' => $list,
            'sendNum' => $sendNum,
            'surplusNum' => $surplusNum,
            'newUserNum' => count($newUser),
        ]);
    }

}


