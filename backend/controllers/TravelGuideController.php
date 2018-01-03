<?php

namespace backend\controllers;

use backend\models\TravelGuide;
use backend\models\TravelGuideQuery;
use backend\service\TravelOperationLogService;
use Yii;
use backend\models\TravelActivity;
use backend\models\TravelActivityQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TravelGuideController implements the CRUD actions for TravelActivity model.
 */
class TravelGuideController extends Controller
{
    /**
     * Lists all TravelActivity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelGuideQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TravelActivity model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        //首先判断有没有id传值
        $id = intval(trim(Yii::$app->request->get("id")));
        if($id==0){
            return $this->redirect(['error/index','code'=>1010,'msg'=>Yii::$app->params['travel_code']['1010']]);
        }
        //获取向导基本信息
        $model = TravelGuide::findOne($id);
        //获取向导服务内容图文信息
        $imgs = Yii::$app->db->createCommand("SELECT * FROM travel_guide_imgs WHERE guide_id = :guide_id and status = 1")
            ->bindValue(":guide_id",$id)
            ->queryAll();
        //获取操作日志
        $logs = TravelOperationLogService::getLogList($id,7);
        return $this->render('view', [
            'id'    => $id,
            'model' => $model,
            'imgs'  => $imgs,
            'logs'  => $logs
        ]);
    }

    public static function getvents($id)
    {
        $data = Yii::$app->db->createCommand("select * from travel_guide_date_price WHERE guide_id = {$id}")->queryAll();
        return $data;
    }

    public function actionCheck()
    {
        $user = Yii::$app->user->identity['username'];
        if (Yii::$app->request->isAjax) {
            $trans = Yii::$app->db->beginTransaction();
            try{
                $data = Yii::$app->request->post()['data'];
                $status = $data['status'];
                $des = $data['des'];
                $id = $data['id'];
                $reason = $data['reason'];
                $uid = Yii::$app->db->createCommand("select uid from `travel_guide` WHERE id ={$id} ")->queryScalar();
                //如果向导审核通过后
                if ($status == 1) {
                    //向导所属的会员设置为达人
                    Yii::$app->db->createCommand("UPDATE  `user_common` SET is_daren = 1  WHERE  uid ={$uid}  ")->execute();
                    //向导涉及到的城市
                    $citycode = Yii::$app->db->createCommand("select city from `travel_guide` WHERE id = {$id}")->queryScalar();
                    if ($citycode) {
                        Yii::$app->db->createCommand("update `dt_city_seas` set display = 1 WHERE code = {$citycode}")->execute();
                    }
                }
                //修改达人的审核信息
                Yii::$app->db->createCommand("UPDATE  `travel_guide` SET status = {$status}, remarks = '{$des}',reason = '{$reason}'  WHERE  id ={$id}  ")->execute();
                //记录操作日志
                TravelOperationLogService::insertLog(7,$id,$status,$reason,$des);
                $trans->commit();
                echo 1;
            }
            catch(\Exception $e){
                $trans->rollBack();
                echo -1;
            }
        }
    }

    public function actionDrop()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $id = Yii::$app->request->post()['data']['id'];
            $bool = Yii::$app->db->createCommand("UPDATE  `travel_guide` SET  status  =2  WHERE id ={$id}")->execute();
            if ($bool) {
                echo 1;
            }
        }
    }

    public function actionOnline()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $id = Yii::$app->request->post()['data']['id'];
            $bool = Yii::$app->db->createCommand("UPDATE  `travel_guide` SET  status  =1  WHERE id ={$id}")->execute();
            if ($bool) {
                echo 1;
            }
        }
    }


    public static function getcountry()
    {
        return Yii::$app->db->createCommand("select name,code from dt_city_seas where level = 0")->queryAll();
    }

    public function actionGetprovince($id = 0)
    {
        if ($id == '') {
            return '<option value="0">请选择省份</option>';
        }
        $prolist = Yii::$app->db->createCommand("select name,code from dt_city_seas where parent={$id}")->queryAll();
        ?>
        <option value="0">请选择省份</option>
        <?php
        foreach ($prolist as $v) {
            ?>
            <option value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php
        }
    }

    public function actionGetcity($id = 0)
    {
        if ($id == '') {
            return '<option value="0">请选择城市</option>';
        }
        $prolist = Yii::$app->db->createCommand("select name,code from dt_city_seas where parent={$id}")->queryAll();
        ?>
        <?php
        foreach ($prolist as $v) {
            ?>
            <option value="<?= $v['code'] ?>"><?= $v['name'] ?></option>
            <?php
        }
    }
}
