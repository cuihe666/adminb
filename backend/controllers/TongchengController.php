<?php
namespace backend\controllers;
use yii\web\Controller;

/**
 * Created by PhpStorm.
 * User: lele
 * Date: 2017/8/4
 * Time: 19:57
 */
class TongchengController extends Controller{
    //    同程-房源-订单
    public function actionTc_order(){
        return $this->render('tc_order');
    }
    //    同程-房源-失败
    public function actionTc_fail(){
        return $this->render('tc_fail');
    }
    //    同程-房源-配置
    public function actionTc_setting(){
        return $this->render('tc_setting');
    }
}