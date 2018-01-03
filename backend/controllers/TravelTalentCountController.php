<?php

namespace backend\controllers;

use backend\models\TravelOrder;
use backend\models\UserQuery;
use Yii;
use yii\web\Controller;
/**
 * TravelTalentCountController implements the CRUD actions for TravelTalent model.
 */
class TravelTalentCountController extends Controller
{
    /**
     * 数据统计
     * @return string
     */
    public function actionDataCount()
    {
        $searchModel = new UserQuery();
        $searchModel->data_count = 1;
        $searchModel->order_count = 1;
        $dataProvider = $searchModel->searchTalent(Yii::$app->request->queryParams);
        return $this->render('data-count', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 订单统计
     * @return mixed
     */
    public function actionOrderCount()
    {
        $searchModel = new UserQuery();
        $searchModel->order_count = 1;
        $dataProvider = $searchModel->searchTalent(Yii::$app->request->queryParams);
        return $this->render('order-count', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'stime' => Yii::$app->request->queryParams['UserQuery']['stime'],
        ]);
    }

    /**
     * 拉新统计
     * @return string
     */
    public function actionPullNewCount(){
        $searchModel = new UserQuery();
        $searchModel->invite_uid = 1;
        $dataProvider = $searchModel->searchTalent(Yii::$app->request->queryParams);
        return $this->render('pull-new-count', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'stime' => Yii::$app->request->queryParams['UserQuery']['stime'],
        ]);
    }

    public function actionPageViewCount(){
        //pv统计量
        $info = Yii::$app->db->createCommand("SELECT * FROM travel_activity_info WHERE id = 1")->queryOne();
        //user拉新用户注册量
        $userCount = Yii::$app->db->createCommand("SELECT COUNT(id) as total FROM user WHERE invite_uid IS NOT NULL and invite_uid!=0")->queryOne();
        return $this->render('page-view-count', [
            'info' => $info,
            'userCount' => $userCount['total'],
        ]);
    }
}
