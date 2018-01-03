<?php

namespace backend\controllers;

use backend\models\ShopGoods;
use backend\models\ShopGoodsQuery;
use backend\service\CommonService;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ShopGoodsController implements the CRUD actions for ShopGoods model.
 */
class ShopGoodsController extends Controller
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
     * Lists all ShopGoods models.
     * @return mixed
     */
    public function actionIndex()
    {


        $searchModel = new ShopGoodsQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $post = current($_POST['ShopGoods'])['sort'];
            $model = ShopGoods::findOne(['id' => $id]);
            $model->sort = $post;
            $model->save(false);
            $out = Json::encode(['output' => $post, 'message' => '']);
            return $out;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Lists all ShopGoods models.
     * @return mixed
     */
    public function actionShow_recommend()
    {
        $data = Yii::$app->db->createCommand("select r.cid,g.title,r.sort from `shop_recommend` as r JOIN `shop_goods`  as g  ON g.id = r.goods_id")->queryAll();
        return $this->render('show_recommend', compact('data'));
    }


    /**
     * Displays a single ShopGoods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $url = Yii::$app->request->getReferrer();
        $model = ShopGoods::findOne($id);
        $info = Yii::$app->db->createCommand("SELECT principal_phone FROM `shop_info` WHERE admin_id = '{$model->admin_id}'")->queryOne();
        $supplier = Yii::$app->db->createCommand("SELECT admin_username FROM `shop_supplier` WHERE admin_id = '{$model->admin_id}'")->queryOne();
        $check_date = Yii::$app->db->createCommand("SELECT created_at FROM `shop_goods_log` WHERE goods_id = {$id}")->queryScalar();
        $logs = Yii::$app->db->createCommand("SELECT created_at,admin_id FROM `shop_goods_log` WHERE goods_id = {$id}    ORDER  BY id DESC  ")->queryOne();
        $admin = Yii::$app->db->createCommand("SELECT username FROM `user_backend` WHERE id =:id")->bindParam(':id', $logs['admin_id'])->queryScalar();

        $specs = Yii::$app->db->createCommand("SELECT title,stocks,price,code FROM `shop_goods_stocks` WHERE goods_id =$id")->queryAll();
        if ($specs) {

            foreach ($specs as $k => $v) {
                $str = '';
                $title = json_decode($v['title']);
                if ($title) {
                    foreach ($title as $kk => $vv) {
                        $str .= $vv->parent_label . ':' . $vv->label . ',';
                    }

                }
                $str = rtrim($str, ',');

                $specs[$k]['title'] = $str;
            }


        }
        return $this->render('view', ['model' => $model, 'info' => $info, 'supplier' => $supplier, 'check_date' => $check_date, 'logs' => $logs, 'url' => $url, 'admin' => $admin, 'specs' => $specs]);
    }

    /**
     * Creates a new ShopGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new ShopGoods();
        $category = Yii::$app->db->createCommand("select title,id from `shop_category` WHERE  pid = 0")->queryAll();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'category' => $category,
            ]);
        }
    }

    /**
     * Updates an existing ShopGoods model.
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

    /**
     * Deletes an existing ShopGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShopGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopGoods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopGoods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetson()
    {
        if (Yii::$app->request->isAjax) {//是否ajax请求
            $id = Yii::$app->request->post('data')['id'];

            $category = Yii::$app->db->createCommand("select title,id from `shop_category` WHERE  pid = {$id}")->queryAll();
            echo json_encode($category);

        }

    }


    public function actionCheck()
    {
        if (Yii::$app->request->isAjax) {

            $post = Yii::$app->request->post()['data'];
            $id = $post['id'];
            $status = $post['status'];
            $reason = $post['reason'];
            $admin_id = Yii::$app->user->getId();
            $old_status = Yii::$app->db->createCommand("SELECT status FROM `shop_goods` WHERE id ={$id}")->queryScalar();
            if ($status == 30) {
                Yii::$app->cache->delete('shop_index');
                Yii::$app->cache->delete('shop_goods_' . $id);
                //下架banner位
                Yii::$app->db->createCommand("DELETE FROM  `shop_banner`  WHERE  goods_id = {$id}")->execute();
//                Yii::$app->db->createCommand("UPDATE `shop_banner` set is_show = 0 WHERE  goods_id = {$id}")->execute();
                if (!Yii::$app->db->createCommand("SELECT operate_category FROM `shop_goods` WHERE id ={$id}")->queryScalar()) {
                    echo -1;
                    die;
                }

                if (!Yii::$app->db->createCommand("SELECT goods_num FROM `shop_goods`WHERE id = {$id}")->queryScalar()) {
                    $goodsNum = CommonService::get_goods_num();
                    Yii::$app->db->createCommand("UPDATE `shop_goods` SET goods_num = '{$goodsNum}' WHERE id = {$id}")->execute();

                }
//                if ($old_status == 10) {
//                    Yii::$app->db->createCommand("INSERT INTO `shop_goods_log` (old_status,new_status,description,admin_id,goods_id)VALUES({$old_status},{$status},'{$reason}',{$admin_id},{$id})")->execute();
//                }
//


            }

            if (intval($id) && $status) {

                if (Yii::$app->db->createCommand("UPDATE `shop_goods` set status = {$status} WHERE  id = {$id}")->execute() && Yii::$app->db->createCommand("INSERT INTO `shop_goods_log` (old_status,new_status,description,admin_id,goods_id)VALUES({$old_status},{$status},'{$reason}',{$admin_id},{$id})")->execute()) {

                    echo 1;
                } else {
                    echo 0;
                }


            }


        }


    }

    public function actionRecommend()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('data');
            $goodsId = $post['id'];
            $sort = $post['sort'];
            $position = $post['position'];
            Yii::$app->cache->delete('shop_index');
            $cid = ShopGoods::find()->where('id=:id', [':id' => $goodsId])->select('operate_category')->scalar();
            if (Yii::$app->db->createCommand("SELECT id FROM `shop_recommend` WHERE is_home ={$position} AND goods_id={$goodsId} AND sort = {$sort}")->queryScalar()) {
//                此商品已在此推荐们存在
                echo -1;
                die;
            }

            if (Yii::$app->db->createCommand("SELECT id FROM `shop_recommend` WHERE is_home ={$position} AND goods_id !={$goodsId}  AND sort = {$sort}")->queryScalar()) {
                //此位置已存在其它商品
                echo -2;
                die;
            }

            //如果此位置没有商品就直接修改
            if (!Yii::$app->db->createCommand("SELECT id FROM `shop_recommend` WHERE is_home ={$position} AND sort = {$sort} AND goods_id !={$goodsId}")->queryScalar() && Yii::$app->db->createCommand("SELECT id FROM `shop_recommend` WHERE is_home ={$position} AND cid = {$cid} AND sort != {$sort} AND goods_id = {$goodsId}")->queryScalar()) {
                Yii::$app->db->createCommand("UPDATE `shop_recommend` SET sort = {$sort} WHERE is_home = {$position}  AND goods_id = {$goodsId}")->execute();
                echo 1;
                die;

            }


            if (Yii::$app->db->createCommand("INSERT INTO `shop_recommend` (is_home,goods_id,cid,sort)VALUES ({$position},{$goodsId},{$cid},{$sort})")->execute()) {
                echo 1;
                die;
            }


        }

    }


    public function actionTrue_sort()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('data');
            $goods_id = intval($post['goods_id']);
            $position = intval($post['position']);
            $category = ShopGoods::find()->where('id=:id', [':id' => $goods_id])->select('operate_category')->scalar();
            $sort = intval($post['sort']);
            if (Yii::$app->db->createCommand("SELECT id FROM `shop_recommend` WHERE is_home ={$position}  AND sort != {$sort} AND goods_id={$goods_id}")->queryScalar()) {
                Yii::$app->db->createCommand("DELETE FROM `shop_recommend` WHERE is_home ={$position} AND sort = {$sort}")->execute();
                Yii::$app->db->createCommand("UPDATE `shop_recommend` SET sort = {$sort} WHERE is_home = {$position} AND cid ={$category}  AND goods_id = {$goods_id}")->execute();
                echo 1;
                die;
            }
            if (Yii::$app->db->createCommand("UPDATE `shop_recommend` SET goods_id = {$goods_id} WHERE is_home = {$position} AND sort = {$sort}")->execute()) {
                echo 1;
                die;
            }


        }


    }


    public function actionOperate()
    {


        return $this->render('operate');
    }

    public function actionCategory()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post()['data'];
            $goods_id = intval($post['goods_id']);
            $category = intval($post['category']);

            if (intval($goods_id) && intval($category)) {
                if (Yii::$app->db->createCommand("SELECT * FROM  `shop_recommend` WHERE  goods_id = {$goods_id}")->queryOne()) {
//                    Yii::$app->db->createCommand("UPDATE `shop_recommend` SET cid = {$category} WHERE  goods_id = {$goods_id}")->execute();
                    Yii::$app->db->createCommand("UPDATE `shop_banner` SET cid = {$category} WHERE  goods_id = {$goods_id}")->execute();
                    Yii::$app->cache->delete('shop_index');
                }


                if (Yii::$app->db->createCommand("UPDATE `shop_goods` SET operate_category = {$category} WHERE  id = {$goods_id}")->execute()) {
                    echo 1;
                }
            }


        }

    }
}
