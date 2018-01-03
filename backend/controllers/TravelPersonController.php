<?php

namespace backend\controllers;

use Yii;
use backend\models\TravelPerson;
use backend\models\TravelPersonQuery;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TravelPersonController implements the CRUD actions for TravelPerson model.
 */
class TravelPersonController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TravelPerson models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelPersonQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TravelPerson model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'view';
        //个人审核信息
        $model = $this->findModel($id);
        //日志信息
        $logs = Yii::$app->db->createCommand("select * from `travel_operation_log` WHERE type = 1 And obj_id = {$id}")->queryAll();
        //2017-5-27 14:53:09  付燕飞 添加 查询个人银行账号信息
        $bankInfo = Yii::$app->db->createCommand("select * from travel_account_bank where uid = :uid")
            ->bindValue(":uid",$model->uid)
            ->queryOne();
        $model->recommend = str_replace("<br>","\n",$model->recommend);
        return $this->render('view', [
            'model' => $model,
            'bankInfo' => $bankInfo,
            'logs' => $logs
        ]);
    }

    public function actionCheck()
    {
        $user = Yii::$app->user->identity['username'];
        if (Yii::$app->request->isAjax) {

            //2017/09/22  snowno add 事务 防止审核通过后只有日志 未更改审核状态
            $trans = Yii::$app->db->beginTransaction();
            $returnData = [];
            try{
//                throw new Exception('添加失败');

                $data = Yii::$app->request->post()['data'];
                $status = $data['status'];
                $des = str_replace("\n","<br>",$data['des']);
                $id = $data['id'];
                $uid = Yii::$app->db->createCommand("select uid from `travel_person` WHERE id ={$id} ")->queryScalar();

                if($status == 1)
                {
                    Yii::$app->db->createCommand("UPDATE  `user_common` SET is_daren = 1  WHERE  uid ={$uid}  ")->execute();
                }
                //@2017-7-18 14:46:08 fuyanfei to update. 只有审核未通过时才有原因，其他状态没有操作原因，只有备注。
                if($status == 2)
                    $reason = str_replace("\n","<br>",$data['reason']);
                else
                    $reason = "";
                Yii::$app->db->createCommand("INSERT INTO `travel_operation_log` SET uname = '{$user}',type =1 ,obj_id = {$id}, status ={$status},reason='{$reason}',remarks = '{$des}'")->execute();
                Yii::$app->db->createCommand("UPDATE  `travel_person` SET status = {$status}, remarks = '{$des}',reason = '{$reason}'  WHERE  id ={$id}  ")->execute();
                if ($status == 1) {
                    Yii::$app->db->createCommand("UPDATE  `travel_activity` SET user_auth = 1  WHERE  uid ={$uid}  ")->execute();

                    Yii::$app->db->createCommand("UPDATE  `travel_higo` SET user_auth = 1  WHERE  uid ={$uid}  ")->execute();
                }
                //@2017-11-30 18:12:28 fuyanfei to add[如果审核未通过，将主题线路、当地活动的user_auth改为2]
                if ($status == 2) {
                    Yii::$app->db->createCommand("UPDATE  `travel_activity` SET user_auth = 2  WHERE  uid ={$uid}  ")->execute();

                    Yii::$app->db->createCommand("UPDATE  `travel_higo` SET user_auth = 2  WHERE  uid ={$uid}  ")->execute();
                }

                $returnData['status'] = 1;
                $trans->commit();
            }catch(Exception $e){
                $errors = $e->getMessage();
                $errors = addslashes($errors);
                $data = Yii::$app->request->post()['data'];
                if($data && !empty($data)){
                    $id = $data['id'];
                    $status = $data['status'];
                }else{
                    $id = '';
                    $status = '';
                }
                $trans->rollBack();
                Yii::$app->db->createCommand("INSERT INTO `travel_operation_log` SET uname = '{$user}',type =1 ,obj_id = {$id}, status ={$status},reason='{$errors}'")->execute();

                $returnData['status'] = 2;
            }

            return json_encode($returnData);
        }

    }

    /**
     * Finds the TravelPerson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TravelPerson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TravelPerson::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
