<?php
namespace backend\controllers;
use yii\web\Controller;

/**
 * Created by cuihe.
 * User: admin
 * Date: 2017/12/14
 * Time: 14:20
 */
class HaoqiaoController extends Controller{
    //    同程-房源-订单
    public function actionHq_hotellist(){
        return $this->render('hq_hotellist');
    }
    //    同程-房源-失败
    public function actionHq_order(){
        return $this->render('hq_order');
    }
    //    同程-房源-配置
    public function actionHq_setting(){
        return $this->render('hq_setting');
    }
}