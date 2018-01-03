<?php
namespace backend\controllers;

use backend\models\DtCitySeasQuery;
use yii\web\Controller;
use Yii;

class ImportController extends Controller
{
    public function actionIndex($type)
    {
        //当地活动
        $activity = Yii::$app->db->createCommand("SELECT DISTINCT city_code FROM travel_activity WHERE status != -1 and city_code!=0")->queryAll();
        //主题线路
        $higo = Yii::$app->db->createCommand("SELECT start_city,end_city FROM travel_higo WHERE status != -1 and (start_city!=0 or end_city != 0)")->queryAll();
        //印象
        $impress = Yii::$app->db->createCommand("SELECT city1,city2,city3 FROM travel_impress WHERE status != -1 and city1 != 0")->queryAll();
        //游记
        $note = Yii::$app->db->createCommand("SELECT city1,city2,city3 FROM travel_note WHERE status != -1 and city1 != 0")->queryAll();
        //当地活动
        $activity_city = [];
        if($activity){
            foreach($activity as $key=>$val){
                $activity_city[] = $val['city_code'];
            }
        }
        //主题线路
        $higo_city_start = [];
        $higo_city_end = [];
        if($higo){
            foreach($higo as $key=>$val){
                $higo_city_start[] = $val['start_city'];
                $higo_city_end[] = $val['end_city'];
            }
        }
        $higo_arr = array_merge($higo_city_start,$higo_city_end);
        $higo_city = array_values(array_unique($higo_arr));

        //印象
        $impress_city1 = [];
        $impress_city2 = [];
        $impress_city3 = [];
        if($impress){
            foreach($impress as $key=>$val){
                if($val['city1']!=0)
                    $impress_city1[] = $val['city1'];
                if($val['city2']!=0)
                    $impress_city2[] = $val['city2'];
                if($val['city3']!=0)
                    $impress_city3[] = $val['city3'];
            }
        }
        $impress_arr = array_merge($impress_city1,$impress_city2,$impress_city3);
        $impress_city = array_values(array_unique($impress_arr));


        //游记
        $note_city1 = [];
        $note_city2 = [];
        $note_city3 = [];
        if($note){
            foreach($note as $key=>$val){
                if($val['city1']!=0)
                    $note_city1[] = $val['city1'];
                if($val['city2']!=0)
                    $note_city2[] = $val['city2'];
                if($val['city3']!=0)
                    $note_city3[] = $val['city3'];
            }
        }
        $note_arr = array_merge($note_city1,$note_city2,$note_city3);
        $note_city = array_values(array_unique($note_arr));
        //合并所有产品的城市
        $citys = array_merge($activity_city,$higo_city,$impress_city,$note_city);
        //去除所有的重复城市
        $city_arr = array_values(array_unique($citys));

        //查询城市信息
        $searchModel = new DtCitySeasQuery();
        $searchModel->city_arr = $city_arr;
        $searchModel->country_type = $type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}