<?php
namespace backend\controllers;

use backend\service\CommonService;
use yii\base\Exception;
use yii\web\Controller;

class AreaController extends Controller
{
    public function actionAdd()
    {
        if (\Yii::$app->request->isAjax) {
            $city_code=\Yii::$app->request->post('city');
            $area=\Yii::$app->request->post('area');
            $bool=\Yii::$app->db->createCommand("select * from dt_city_seas WHERE name LIKE '%{$area}%' AND level=3 AND parent=$city_code")->queryOne();
            if($bool){
                echo -1;die;
            }
            $max_version=\Yii::$app->db->createCommand("select max(version) from dt_city_seas")->queryScalar();
            $max_code=\Yii::$app->db->createCommand("select max(code) from dt_city_seas WHERE parent=$city_code AND level=3")->queryScalar();
            $shiwu = \Yii::$app->db->beginTransaction();
            try {
                \Yii::$app->db->createCommand("update dt_version set maxversion=$max_version+1 WHERE type=11500")->execute();
                \Yii::$app->db->createCommand("insert into dt_city_seas(code,name,parent,level,operation,version) VALUES ($max_code+1,'{$area}',$city_code,3,1,$max_version+1)")->execute();
                $shiwu->commit();
                echo 1;die;
            } catch (Exception $e) {
                $shiwu->rollBack();
                echo 0;die;
            }
        }
        $province = CommonService::get_province();
        return $this->render('add', ['province' => $province]);
    }
}