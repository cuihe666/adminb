<?php

namespace backend\controllers;

use backend\models\KaConfigQuery;
use backend\models\KaOrder;
use backend\models\KaOrderFollow;
use backend\models\KaOrderQuery;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
/**
 * TravelPersonController implements the CRUD actions for TravelPerson model.
 */
class KaConfigController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * 查询ka个人定制配置信息
     */
    public function actionPerson()
    {
        $params = Yii::$app->request->get();
        if(isset($params['s']) && $params['s']!="")
            $s = $params['s'];
        else
            $s = 1;
        $type = 2;
        $searchModel=new KaConfigQuery();
        $searchModel->type=$type;
        $searchModel->status = $s;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('person',[
            'type'=>$type,
            's' => $s,
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * 查询ka企业定制配置信息
     */
    public function actionCompany()
    {
        $params = Yii::$app->request->get();
        if(isset($params['s']) && $params['s']!="")
            $s = $params['s'];
        else
            $s = 1;
        $type = 1;
        $searchModel=new KaConfigQuery();
        $searchModel->type=$type;
        $searchModel->status = $s;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('person',[
            'type'=>$type,
            's' => $s,
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * 添加手机号
     * @return int
     * @throws \yii\db\Exception
     */
    public function actionCreate(){
        if(Yii::$app->request->isAjax){
            $params = Yii::$app->request->post();
            $res = Yii::$app->db->createCommand("INSERT INTO ka_config(name,tel,remarks,status,type,create_time) VALUES (:name,:tel,:remarks,:status,:type,:create_time)")
                ->bindValue(":name",$params['name'])
                ->bindValue(":tel",$params['tel'])
                ->bindValue(":remarks",$params['remarks'])
                ->bindValue(":status",1)
                ->bindValue(":type",$params['type'])
                ->bindValue(":create_time",time())
                ->execute();
            return $res;
        } else{
            return -1;
        }
    }

    /**
     * 验证手机号是否存在
     * @return int
     */
    public function actionHasTel(){
        if(Yii::$app->request->isAjax){
            $params = Yii::$app->request->post();
            $res = Yii::$app->db->createCommand("SELECT * FROM ka_config WHERE tel = :tel AND type = :type AND status = 1")
                ->bindValue(":tel",$params['tel'])
                ->bindValue(":type",$params['type'])
                ->queryAll();
            return count($res);
        } else{
            return -1;
        }
    }

    public function actionUpdateStatus(){
        if(Yii::$app->request->isAjax){
            $params = Yii::$app->request->post();
            if($params['status']==1)
                $status = 0;
            if($params['status']==0)
                $status = 1;
            $res = Yii::$app->db->createCommand("UPDATE ka_config SET status = :status,update_time = :update_time WHERE id = :id")
                ->bindValue(":status",$status)
                ->bindValue(":update_time",time())
                ->bindValue(":id",$params['id'])
                ->execute();
            return $res;
        } else{
            return -1;
        }
    }
}


