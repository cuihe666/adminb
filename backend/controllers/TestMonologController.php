<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

class TestMonologController extends Controller{

    public function actionTest(){
        $monologComponent = Yii::$app->monolog;

        $logger = $monologComponent->getLogger();
        $logger->log('info', 'Hello world');
    }


}