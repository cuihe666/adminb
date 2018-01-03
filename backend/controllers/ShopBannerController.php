<?php

namespace backend\controllers;

use backend\models\ShopBanner;
use backend\models\ShopBannerQuery;
use backend\models\ShopGoods;
use Qiniu\Auth;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;


/**
 * ShopBannerController implements the CRUD actions for ShopBanner model.
 */
class ShopBannerController extends Controller
{
    public $enableCsrfValidation = false;


    /**
     * Lists all ShopBanner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopBannerQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShopBanner model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ShopBanner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopBanner();


        $this->view->title = '标签修改';
        require_once '../../common/tools/yii2-qiniu/autoload.php';
        $ak = '7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
        $sk = 'XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';
        $bucket = 'imgs';
        $auth = new Auth($ak, $sk);
        $token = $auth->uploadToken($bucket);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('shop_index');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'token' => $token,
            ]);
        }
    }

    /**
     * Updates an existing ShopBanner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $this->view->title = '标签修改';
        require_once '../../common/tools/yii2-qiniu/autoload.php';
        $ak = '7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
        $sk = 'XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';
        $bucket = 'imgs';
        $auth = new Auth($ak, $sk);
        $token = $auth->uploadToken($bucket);
        $model = $this->findModel($id);

        return $this->render('update', compact('model', 'token'));
    }

    /**
     * Deletes an existing ShopBanner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            $id = intval(Yii::$app->request->post('id'));

            Yii::$app->cache->delete('shop_index');
            echo $this->findModel($id)->delete();

        } else {
            echo 0;
        }


    }

    /**
     * Finds the ShopBanner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopBanner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopBanner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public static function getGoods($limit = null)
    {
        if ($limit) {

            return Yii::$app->db->createCommand("select id , title from `shop_goods` WHERE status = 20  AND is_delete = 0     LIMIT {$limit} ")->queryAll();

        }
        return Yii::$app->db->createCommand("select id , title from `shop_goods` WHERE status = 20 AND is_delete = 0 ")->queryAll();
    }


    public static function getEditGoods($id)
    {
        $id = intval($id);

        return Yii::$app->db->createCommand("select id , title from `shop_goods` WHERE id = {$id}")->queryAll();

    }

    public static function getGood($gid)
    {


        return Yii::$app->db->createCommand("select id , title from `shop_goods` WHERE id = {$gid}")->queryAll();

    }


    //通过 ajax 模糊搜索
    public function actionSearchGoods()
    {
        $request = Yii::$app->request->post()['goods_name'];
        $request = trim($request);

        if (empty($request)) {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            return $this->apiResponse([
                ['id' => null, 'title' => '商品不存在']
            ]);
        }

        $data = Yii::$app->db->createCommand("select id,title from shop_goods  where title LIKE '%{$request}%' AND  status = 20 AND is_delete = 0  LIMIT 10")->queryAll();


        if (empty($data)) {
            return $this->apiResponse([
                ['id' => null, 'title' => '商品不存在']
            ]);
        } else {
            return $this->apiResponse($data);
        }
    }

    public function apiResponse($data = [])
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return \Yii::$app->response->data = $data;
    }


    public function actionAdd()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $title = $post['name'];
            $pic = $post['pic'];
            $is_index = $post['is_index'];
            $category = $post['category'];
            $type = 1;
            $goods_id = $post['goods_id'];
            $sort = $post['sort'];
            Yii::$app->cache->delete('shop_index');
            switch ($type) {
                case  1:
                    $cid = ShopGoods::find()->where('id=:id', [':id' => $goods_id])->select('operate_category')->scalar();
                    Yii::$app->db->createCommand("INSERT INTO `shop_banner` (title,img_url,is_home,type,goods_id,sort,cid) VALUES('{$title}','{$pic}',{$is_index},{$type},{$goods_id},{$sort},{$cid})")->execute();
                    echo 1;
                    break;

                case  2:
                    Yii::$app->db->createCommand("INSERT INTO `shop_banner` (title,img_url,is_home,type,cid,sort) VALUES ('{$title}','{$pic}',{$is_index},{$type},{$category},{$sort})")->execute();
                    echo 1;
                    break;
            }
        }

    }

    public function actionEdit()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $id = $post['id'];
            $title = $post['name'];
            $pic = $post['pic'];
            $is_index = $post['is_index'];
            $category = $post['category'];
            $type = 1;
            $goods_id = $post['goods_id'];
            $sort = $post['sort'];
            Yii::$app->cache->delete('shop_index');
            switch ($type) {
                case  1:
                    $cid = ShopGoods::find()->where('id=:id', [':id' => $goods_id])->select('operate_category')->scalar();
                    Yii::$app->db->createCommand("UPDATE `shop_banner` SET title = '{$title}' ,img_url = '{$pic}' ,is_home = {$is_index},type = {$type} ,goods_id = {$goods_id} ,sort = {$sort},cid ={$cid} WHERE id = {$id}")->execute();
                    echo 1;
                    break;

            }
        }

    }
}
