<?php

namespace backend\controllers;

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
class KaOrderController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * 查询所有的未跟进的定制订单
     */
    public function actionIndex()
    {
        $searchModel=new KaOrderQuery();
        $searchModel->follow_status=0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'method'=>'index',
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
 * 查询所有的已跟进的定制订单
 */
    public function actionIndexa()
    {
        $searchModel=new KaOrderQuery();
        $searchModel->follow_status=1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'method'=>'indexa',
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * 查询所有的已完成的定制订单
     */
    public function actionIndexb()
    {
        $searchModel=new KaOrderQuery();
        $searchModel->follow_status=2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'method'=>'indexb',
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
        ]);
    }


    /**
     * 查看单条订单详情
     * @param int $id  订单id
     * @return string
     */
    public function actionView($id)
    {
        #查询订单详情信息
        $model = $this->findModelByKey($id);
        #查询订单跟进记录信息
        $follows = Yii::$app->db->createCommand("SELECT * FROM `ka_order_follow` WHERE orderid = {$id}")->queryAll();
        return $this->render('view', [
            'model' => $model,
            'follows'=>$follows
        ]);
    }

    /**
     * 跟进某条订单信息
     * @param int $id  订单id
     * @return string
     */
    public function actionFollow($id)
    {
        #首先判断是否为form表单提交过来的操作
        if(Yii::$app->request->post()){
            #获取post提交
            $params = Yii::$app->request->post();
            #判断是否有上传的附件路径，如果有的话，要把服务器地址去掉后再存到数据库中
            if($params['filePath']!="") {
                $newStr = str_replace(Yii::$app->params['imgUrl'], "", rtrim($params['filePath'],","));
            }
            #实例化model
            $model = new KaOrderFollow();
            $model->orderid = $params['orderid'];
            $model->follow_time = time();
            $model->follow_adminname = Yii::$app->user->identity['username'];
            $model->follow_remark = $params['follow_remark'];
            $model->follow_status = $params['follow_status']!="" ? $params['follow_status'] : 1;
            $model->follow_file = $newStr;
            if($model->follow_status==1){
                $model->follow_logs = "增加跟进记录".date("Y-m-d H:i:s",time());
                $url = "indexa";
            }
            if($model->follow_status==2){
                $model->follow_logs = "选择已完成定制";
                $url = "indexb";
            }


            $result =Yii::$app->db->createCommand('UPDATE ka_order SET follow_status='.$model->follow_status.' WHERE orderid='.$params['orderid'])
                ->execute();

            if($model->save()){
                return $this->redirect(['ka-order/'.$url]);
            }
            else{
                return $this->redirect(Url::current());
            }

        }
        else {
            #查询订单详情信息
            $model = $this->findModelByKey($id);
            #查询订单跟进记录信息
            $follows = Yii::$app->db->createCommand("SELECT * FROM `ka_order_follow` WHERE orderid = {$id}")->queryAll();
            return $this->render('follow', [
                'model' => $model,
                'follows' => $follows
            ]);
        }

    }

    /**
     * Finds the TravelPerson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TravelPerson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelByKey($id)
    {
        if (($model = KaOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}


