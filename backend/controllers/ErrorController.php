<?php
namespace backend\controllers;

use yii\web\Controller;
use Yii;

class ErrorController extends Controller
{
    public function actionIndex()
    {
        /*$res = FinanceTravelController::actionCreate_arr(2);
        $r = FinanceTravelController::actionAdd_table_sql($res);
        dump($res);
        dump($r);
        exit;*/

        $code = trim(Yii::$app->request->get('code')) ? trim(Yii::$app->request->get('code')) : Yii::$app->params['error_defaule']['code'];
        $msg  = trim(Yii::$app->request->get('msg')) ? trim(Yii::$app->request->get('msg')) : Yii::$app->params['error_defaule']['msg'];
        return $this->render('index', ['code' => $code,'msg'=>$msg]);
    }
}