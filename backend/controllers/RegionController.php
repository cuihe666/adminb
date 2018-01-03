<?php

namespace backend\controllers;

use backend\models\KaOrder;
use backend\models\KaOrderFollow;
use backend\models\KaOrderQuery;
use backend\service\CommonService;
use backend\service\RegionService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
/**
 * TravelPersonController implements the CRUD actions for TravelPerson model.
 */
class RegionController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 查询所有的未跟进的定制订单
     */
    public function actionGetregion($level,$code)
    {
        $region = RegionService::getRegion(intval($level),intval($code));
        if($region)
            return json_encode($region);
        else
            return null;
    }

    public function actionGetcityno(){
        if (Yii::$app->request->isAjax) {
            $code = Yii::$app->request->post('code');
            $cityNo = RegionService::getCityCode($code);
            echo $cityNo;
        }
    }

    /**
     * 根据城市名称模糊查询城市信息
     * @param string $name
     * @return string
     */
    public function actionGetcity($name)
    {
        $region = RegionService::getCityByName($name);
        return json_encode($region);
    }
}


