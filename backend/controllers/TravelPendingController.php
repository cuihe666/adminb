<?php

namespace backend\controllers;

use backend\models\TravelActivity;
use backend\models\TravelHigo;
use backend\models\TravelOrder;
use backend\models\TravelOrderTwoQuery;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * TravelOrderController implements the CRUD actions for TravelOrder model.
 */
class TravelPendingController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Lists all TravelOrder models.
     *  @ 旅游订单主入口
     */
    public function actionIndex()
    {
        $searchModel = new TravelOrderTwoQuery();
        $searchModel['wait'] = 'wait';//待...状态
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_two', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'all'          => 'all'
        ]);
    }

    /**
     *  @已完成订单(退款成功，退款失败)
     */
    public function actionAlready()
    {
        $searchModel = new TravelOrderTwoQuery();
        $searchModel['already'] = 'already';//已退款和退款驳回
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('already', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     *  @主题线路
     */
    public function actionTheme()
    {
        $searchModel = new TravelOrderTwoQuery();
        $searchModel->type = 3;
        $searchModel['wait'] = 'wait';//待...状态
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_two', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'order_type' => '3'
        ]);
    }

    /**
     *  @当地活动
     */
    public function actionLocal()
    {
        $searchModel = new TravelOrderTwoQuery();
        $searchModel->type = 2;
        $searchModel['wait'] = 'wait';//待...状态
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_two', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'order_type' => '2'
        ]);
    }

    /**
     *  @当地向导
     */
    public function actionGuide()
    {
        $searchModel = new TravelOrderTwoQuery();
        $searchModel->type = 5;
        $searchModel['wait'] = 'wait';//待...状态
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_two', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'order_type' => '5'
        ]);
    }
    /**
     *  @城市条件填充
     */
    public static function actionCity_code()
    {
        $order_info = TravelOrder::find()
            ->andWhere(['state' => 21, 'is_confirm' => 1, 'refund_stauts' => '0'])//待确认
            ->orWhere(['state' => 11])//待支付
            ->orWhere(['refund_stauts' => 51])//待退款
            ->select(['travel_id', 'type'])
            ->asArray()
            ->all();
        foreach ($order_info as $k => $val) {
            if ($val['type'] == 2) { //当地活动
                $active_id_arr[] = $val['travel_id'];
            } else if ($val['type'] == 3) { //主题higo
                $higo_id_arr[] = $val['travel_id'];
            }
        }
        $new_arr = array();
        if (empty($active_id_arr)) {
            $new_arr = array();
        } else {
            //当地活动
            $active_id_info = array_unique($active_id_arr);
            sort($active_id_info);
            $active_code = TravelActivity::find()
                ->where(['in', 'id', $active_id_info])
                ->select(['city_code'])
                ->asArray()
                ->all();
            foreach ($active_code as $key => $value) {
                if (($value['city_code'] !== '') || ($value['city_code'] !== NULL)) {
                    $new_arr[] = $value['city_code'];
                }
            }
        }
        if (empty($higo_id_arr)) {
            $new_arr = array();
        } else {
            //主题线路
            $higo_id_info = array_unique($higo_id_arr);
            sort($higo_id_info);
            $higo_code = TravelHigo::find()
                ->where(['in', 'id', $higo_id_info])
                ->select(['end_city'])
                ->asArray()
                ->all();
            foreach ($higo_code as $s => $va) {
                if (($va['end_city'] !== '') || ($va['end_city'] !== NULL)) {
                    $new_arr[] = $va['end_city'];
                }
            }
        }
        if (empty($new_arr)) {
            $return_arr = array();
        } else {
            $code_id_info = array_unique($new_arr);
            $code_str = implode(',', $code_id_info);
            $sql = "SELECT `name`,`code` FROM `dt_city_seas` WHERE `code` IN ({$code_str})";
            $code_name_info = Yii::$app->db->createCommand($sql)->queryAll();
            $return_arr = array();
            foreach ($code_name_info as $keys => $values) {
                $return_arr[$values['code']] = $values['name'];
            }
        }
        return $return_arr;
    }
}
