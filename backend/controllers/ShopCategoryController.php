<?php

namespace backend\controllers;

use backend\models\ShopCategory;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ShopCategoryController implements the CRUD actions for ShopCategory model.
 */
class ShopCategoryController extends Controller
{

    public function actionIndex()
    {


//        $searchModel = new ShopCategoryQuery();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new ShopCategory();
        $cates = $model->getTreeList();
        return $this->render('index', [
            'cates' => $cates,
        ]);
    }

    /**
     * Creates a new ShopCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopCategory();
        $list = $model->getOptions();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', '添加成功');
            return $this->redirect(['shop-category/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'list' => $list
            ]);
        }
    }

    /**
     * Updates an existing ShopCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $list = $model->getOptions();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', '修改成功');
            return $this->redirect(['shop-category/index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'list' => $list
            ]);
        }
    }

    /**
     * Deletes an existing ShopCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];


            $data = ShopCategory::find()->where('pid=:pid', [':pid' => $id])->all();
            if ($data) {
                Yii::$app->session->setFlash('info', '该分类下有子分类不能删除');
                echo -1;
                die;
            }
            if ($this->findModel($id)->delete()) {
                Yii::$app->session->setFlash('info', '删除成功');
                echo 1;
                die;
            }

//            return $this->redirect(['index']);

        }


    }

    /**
     * Finds the ShopCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
