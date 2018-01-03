<?php

namespace backend\controllers;

use Yii;
use backend\models\TravelCompany;
use backend\models\TravelCompanyQuery;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TravelCompanyController implements the CRUD actions for TravelCompany model.
 */
class TravelCompanyController extends Controller
{
    /**
     * @inheritdoc
    //     */
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }

    /**
     * Lists all TravelCompany models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelCompanyQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TravelCompany model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $logs = Yii::$app->db->createCommand("select * from `travel_operation_log` WHERE type = 2 And obj_id = {$id}")->queryAll();
        $this->layout = 'view';
        $model = TravelCompany::find()->joinWith('bank')->where('travel_company.id=:id', [':id' => $id])->one();
        return $this->render('view', [
            'model' => $model,
            'logs' => $logs
        ]);
    }

    /**
     * Creates a new TravelCompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TravelCompany();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCheck()
    {
        $user = Yii::$app->user->identity['username'];
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post()['data'];
            $status = $data['status'];
            $des = str_replace("\n","<br>",$data['des']);
            $id = $data['id'];
            //@2017-7-18 14:46:08 fuyanfei to update. 只有审核未通过时才有原因，其他状态没有操作原因，只有备注。
            if($status==2)
                $reason = str_replace("\n","<br>",$data['reason']);
            else
                $reason = "";
            //2017-09-19 snowno增加事务和异常捕获
            $return_data = [];
            $trans = Yii::$app->db->beginTransaction();
            try{
                $uid = Yii::$app->db->createCommand("select uid from `travel_company` WHERE id ={$id} ")->queryScalar();
                if ($status == 1) {
                    Yii::$app->db->createCommand("UPDATE  `user_common` SET is_daren = 1  WHERE  uid ={$uid}  ")->execute();
                }
                Yii::$app->db->createCommand("INSERT INTO `travel_operation_log` SET uname = '{$user}',type =2 ,obj_id = {$id}, status ={$status},reason='{$reason}',remarks = '{$des}'")->execute();
                Yii::$app->db->createCommand("UPDATE  `travel_company` SET status = {$status}, remarks = '{$des}',reason = '{$reason}'  WHERE  id ={$id}  ")->execute();

                if ($status == 1) {
                    Yii::$app->db->createCommand("UPDATE  `travel_activity` SET user_auth = 1  WHERE  uid ={$uid}  ")->execute();

                    Yii::$app->db->createCommand("UPDATE  `travel_higo` SET user_auth = 1  WHERE  uid ={$uid}  ")->execute();
                }
                //@2017-11-30 18:12:28 fuyanfei to add[如果审核未通过，将主题线路、当地活动的user_auth改为2]
                if ($status == 2) {
                    Yii::$app->db->createCommand("UPDATE  `travel_activity` SET user_auth = 2  WHERE  uid ={$uid}  ")->execute();

                    Yii::$app->db->createCommand("UPDATE  `travel_higo` SET user_auth = 2  WHERE  uid ={$uid}  ")->execute();
                }
                $trans->commit();
                $return_data['status'] = 1;

            }catch(Exception $e){
                $errors = $e->getMessage();
                $errors = addslashes($errors);
                $trans->rollBack();
                $data = Yii::$app->request->post()['data'];
                if($data && !empty($data)){
                    $id = $data['id'];
                    $status = $data['status'];
                }else{
                    $id = '';
                    $status = '';
                }
                Yii::$app->db->createCommand("INSERT INTO `travel_operation_log` SET uname = '{$user}',type =2 ,obj_id = {$id}, status ={$status},reason='{$errors}'")->execute();
                $return_data['status'] = 2;
            }
            return json_encode($return_data);
        }

    }


    /**
     * Finds the TravelCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TravelCompany the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TravelCompany::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
