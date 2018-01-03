<?php

namespace backend\controllers;

use backend\models\ShopSupplier;
use backend\models\ShopSupplierQuery;
use backend\models\Submit;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ShopSupplierController implements the CRUD actions for ShopSupplier model.
 */
class ShopSupplierController extends Controller
{


    /**
     * Lists all ShopSupplier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopSupplierQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShopSupplier model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $url = Yii::$app->request->getReferrer();
        $model = ShopSupplier::find()->joinWith('info')->where('shop_supplier.id=:id', [':id' => $id])->one();
        return $this->render('view', [
            'model' => $model,
            'url' => $url,
        ]);
    }

    /**
     * Creates a new ShopSupplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = false;
        $model = new ShopSupplier();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShopSupplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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

//审核
    public function actionCheck()
    {
        if (Yii::$app->request->isAjax) {

            $post = Yii::$app->request->post()['data'];
            $id = $post['id'];
            $status = $post['status'];
            $reason = $post['reason'];
            $admin_id = Yii::$app->user->getId();
            $supplierData = Yii::$app->db->createCommand("SELECT status,admin_id FROM `shop_supplier` WHERE id ={$id}")->queryOne();
            $ShopUserName = Yii::$app->db->createCommand("select username from `shop_admin` WHERE id = {$supplierData['admin_id']}")->queryScalar();
            if (intval($id) && $status) {
                if (Yii::$app->db->createCommand("UPDATE `shop_supplier` set status = {$status} WHERE  id = {$id}")->execute() && Yii::$app->db->createCommand("INSERT INTO `shop_suppliser_log` (old_status,new_status,description,admin_id,supplier_id)VALUES({$supplierData['status']},{$status},'{$reason}',{$admin_id},{$id})")->execute()) {

                    $url = SupplierUrl . '/site/confirm?token=' . self::messageEncode(["username" => $ShopUserName]);

                    if ($status == 2) {
                        $obj = new Submit();
                        $obj->sub_get($url);
                    }
                    echo 1;
                    die;

                } else {
                    echo 0;
                    die;
                }


            }


        }


    }

    /**
     * Deletes an existing ShopSupplier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public
    function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShopSupplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopSupplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = ShopSupplier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public
    static function messageEncode($msg)
    {
        $msg = is_array($msg) ? json_encode($msg) : $msg;
        $msg = base64_encode($msg);
        $msg = strrev($msg);
        //前5个字符倒转
        $front = substr($msg, 0, 5);
        $msg = str_replace($front, strrev($front), $msg);
        return urlencode($msg);
    }

//
    public
    static function messageDecode($msg)
    {
        $front = substr($msg, 0, 5);
        $msg = str_replace($front, strrev($front), $msg);
        $msg = strrev($msg);
        return base64_decode($msg);
    }

}
