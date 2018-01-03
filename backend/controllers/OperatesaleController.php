<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/7/7
 * Time: 下午6:00
 */

namespace backend\controllers;
use yii\web\Controller;

class OperatesaleController extends Controller
{
	public function actionIndex (){
		return $this-> render('index');
	}

}