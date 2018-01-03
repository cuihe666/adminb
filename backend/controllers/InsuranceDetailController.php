<?php

namespace backend\controllers;

use backend\models\SearchSql;
use Yii;
use backend\models\PlaneTicketOrderEmplane;
use backend\models\PlaneTicketOrderEmplaneQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InsuranceDetailController implements the CRUD actions for PlaneTicketOrderEmplane model.
 */
class InsuranceDetailController extends Controller
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
     * @列表页保险供应商搜索条件下拉列表
     * @array('id' => 'supplier_name')
     */
    public function InsuranceSupplierList()
    {
        $sql = "SELECT `id`,`name` FROM `plane_ticket_supplier` WHERE `ticket_genre`=0";
        $isurance_info = SearchSql::_SearchAllData($sql);
        $insurance_list = [];
        if (!empty($isurance_info)) {
            foreach ($isurance_info as $k => $value) {
                $insurance_list[$value['id']] = $value['name'];
            }
        }
        $insurance_list[0] = '全部';
        asort($insurance_list);
        return $insurance_list;
    }

    /**
     * Lists all PlaneTicketOrderEmplane models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlaneTicketOrderEmplaneQuery();
        $searchModel['insurance_detail_note'] = 'insurance_detail_note';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        dd($dataProvider->getModels());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'insurance_list' => $this->InsuranceSupplierList(),//列表保险供应商搜索条件下拉列表
        ]);
    }

    /**
     * Displays a single PlaneTicketOrderEmplane model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PlaneTicketOrderEmplane model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PlaneTicketOrderEmplane();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PlaneTicketOrderEmplane model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PlaneTicketOrderEmplane model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PlaneTicketOrderEmplane model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PlaneTicketOrderEmplane the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlaneTicketOrderEmplane::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
