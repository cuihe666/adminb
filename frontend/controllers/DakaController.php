<?php
namespace frontend\controllers;

use backend\models\Submit;
use yii\web\Controller;

class DakaController extends Controller
{
//下线大咖 原本是Index
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
}