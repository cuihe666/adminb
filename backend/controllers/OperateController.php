<?php

namespace backend\controllers;

use backend\models\OperateCategory;
use backend\models\TagCategory;

use backend\models\TagDetail;
use phpDocumentor\Reflection\DocBlock\Tag;
use function Sodium\add;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\data\Pagination;
use Qiniu\Auth;

class OperateController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {

        $query = OperateCategory::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);


    }


    public function actionAdd()
    {

        $model = new OperateCategory();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->name = $post['name'];
            $model->desc = $post['desc'];
            $model->validate();
            if ($model->hasErrors()) {
                $errors = $model->getErrors();
                $str = '';
                foreach ($errors as $k => $v) {
                    $str .= $v[0];
                }
                $str = rtrim($str, ',');
                Yii::$app->session->setFlash('info', $str);
            } else {
                if ($model->save()) {

                    return $this->redirect(['operate/index']);

                }
            }

        }

        return $this->render('add', ['model' => $model]);

    }

    public function actionEdit()
    {
        $this->view->title = '标签修改';
        require_once '../../common/tools/yii2-qiniu/autoload.php';
        $ak = '7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
        $sk = 'XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';
        $bucket = 'imgs';
        $auth = new Auth($ak, $sk);
        $token = $auth->uploadToken($bucket);
        $id = Yii::$app->request->get('id');
        try {
            if (!$id) {
                throw new \Exception('非法请求！');
            }
            $sons = Yii::$app->db->createCommand("SELECT * FROM `tag_detail` WHERE cid = {$id}")->queryAll();

            $cate_data = OperateCategory::findOne($id);
            if (Yii::$app->request->isPost) {
                $post = Yii::$app->request->post();
                $cate_data->name = $post['name'];
                $cate_data->desc = $post['desc'];
                $cate_data->validate();
                if ($cate_data->hasErrors()) {
                    $errors = $cate_data->getErrors();
                    $str = '';
                    foreach ($errors as $k => $v) {
                        $str .= $v[0];
                    }
                    $str = rtrim($str, ',');
                    Yii::$app->session->setFlash('info', $str);
                } else {
                    if ($cate_data->save()) {
                        return $this->redirect(['operate/index']);

                    }
                }

            }


        } catch (\Exception $e) {
            echo $e->getMessage();
            die;

        }

        return $this->render('edit', ['cate_data' => $cate_data, 'token' => $token, 'sons' => $sons]);


    }

    public function actionAddson()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            echo json_encode($post);
            die;
            $cid = intval($post['cid']);
            $title = addslashes($post['title']);
            $desc = addslashes($post['desc']);
            $type = intval($post['type']);
            $url = $post['url'];
            $start_time = $post['start_time'];
            $end_time = $post['end_time'];
            $num = intval($post['num']);
            $pic = $post['pic'];
            if (!$cid || !$title || !$type || !$url || !$start_time || !$end_time || !$pic) {
                echo -1;
                return;
            }


            $bool = Yii::$app->db->createCommand("INSERT INTO `operate_detail`(title,desc,type,obj,start_time,end_time,sort,title_pic,cid)VALUES ('{$title}','{$desc}','{$type}','{$url}','{$start_time}','{$end_time}','{$num}','{$pic}')")->execute();
            if ($bool) {
                echo 1;

            } else {
                echo 0;
            }


        }

    }

    public function actionDelson()
    {
        $url = Yii::$app->request->getReferrer();
        $id = Yii::$app->request->get('id');
        try {
            if (!$id) {
                throw new \Exception('非法请求！');
            }
            $bool = Yii::$app->db->createCommand("DELETE  FROM `tag_detail` WHERE id ={$id}")->execute();
            if ($bool) {
                Yii::$app->session->setFlash('info', '删除成功');
                return $this->redirect($url);
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
            die;

        }

    }

    public function actionChangestatus()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $oldstatus = TagCategory::find()->where('id=:id', [':id' => $id])->one()->status;
            if ($oldstatus == 1) {
                $status = 0;
            }
            if ($oldstatus == 0) {
                $status = 1;
            }

            echo TagCategory::updateAll(['status' => $status], ['id' => $id]);

        }


    }

}


