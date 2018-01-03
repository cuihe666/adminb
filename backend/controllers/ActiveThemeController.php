<?php

namespace backend\controllers;

use backend\models\ActiveTheme;
use backend\models\ActiveThemeQuery;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
/**
 * @author:fuyanfei
 * @date:2017年3月27日18:00:38
 * @info:活动主题控制器
 * QrcodeController implements the CRUD actions for TravelPerson model.
 */
class ActiveThemeController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * 查询所有的活动主题信息列表
     */
    public function actionIndex()
    {
        //实例化ActiveThemeQuery
        $searchModel=new ActiveThemeQuery();
        //获取活动主题的model
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'method'=>'index',
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
        ]);
    }


    /**
     * 新增活动主题
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ActiveTheme();;
        //判断是否为form表单提交过来的数据
        if ($model->load(Yii::$app->request->post())) {
            #获取post提交
            $params = Yii::$app->request->post();
            /*if ($params['ActiveTheme']['stime'] != '') {

                $start = substr($params['ActiveTheme']['stime'], 0, 10) . ' 00:00:00';
                $end = substr($params['ActiveTheme']['stime'], 13) . ' 23:59:59';
                $model->start_date = strtotime($start);
                $model->end_date = strtotime($end);
            }*/
            $model->create_time = time();    //创建时间
            $model->create_adminid = Yii::$app->user->identity->getId();  //创建人
            if (Yii::$app->request->isPost && $model->validate()) {
                if ($model->save())
                    return $this->redirect(['view', 'id' => $model->theme_id]);
            }
            else{
                dump($model->errors);
            }
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 修改活动主题信息
     * @param int $id  活动主题d
     * @return string
     */
    public function actionUpdate($id)
    {
        #查询活动主题信息
        $model = $this->findModelByKey($id);
        if ($model->load(Yii::$app->request->post())) {
            #获取post提交
            $params = Yii::$app->request->post();
            if ($params['ActiveTheme']['stime'] != '') {

                $start = substr($params['ActiveTheme']['stime'], 0, 10) . ' 00:00:00';
                $end = substr($params['ActiveTheme']['stime'], 13) . ' 23:59:59';
                $model->start_date = strtotime($start);
                $model->end_date = strtotime($end);
            }
            if (Yii::$app->request->isPost && $model->validate()) {
                if ($model->save())
                    return $this->redirect(['view', 'id' => $model->theme_id]);
            }
            else{
                dump($model->errors);
            }
        }
        else{
            $start = date("Y-m-d",$model->start_date);
            $end = date("Y-m-d",$model->end_date);
            $model->stime =$start." - ".$end;
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 查看活动主题信息
     * @param int $id  活动主题d
     * @return string
     */
    public function actionView($id)
    {
        #查询活动主题信息
        $model = $this->findModelByKey($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * 根据id查询单条数据
     * @param integer $id
     * @return TravelPerson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelByKey($id)
    {
        if (($model = ActiveTheme::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}


