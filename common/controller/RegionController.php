<?php

namespace backend\controllers;

use backend\models\KaOrder;
use backend\models\KaOrderFollow;
use backend\models\KaOrderQuery;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
/**
 * TravelPersonController implements the CRUD actions for TravelPerson model.
 */
class RegoinController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * 查询所有的未跟进的定制订单
     */
    public function actionGetRegion($level)
    {
        $region = Yii::$app->db->createCommand("select name,code from dt_city_seas where level = 0")->queryAll();
        $result = [];
        if(!empty($region)){
            foreach($region as $key=>$val){
                $result[$val['code']] = $val['name'];
            }
        }
        return $result;
    }
}


