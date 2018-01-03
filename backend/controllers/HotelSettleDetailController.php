<?php

namespace backend\controllers;

use backend\models\HotelDatePrice;
use backend\models\HotelOrderDatePrice;
use backend\models\HotelOrderGuests;
use backend\models\SearchSql;
use Yii;
use backend\models\HotelSettleDetail;
use backend\models\HotelSettleDetailQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HotelSettleDetailController implements the CRUD actions for HotelSettleDetail model.
 */
class HotelSettleDetailController extends Controller
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
     * Lists all HotelSettleDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $settle_id = Yii::$app->request->get('settle_id');
        if (empty($settle_id)) {
            return $this->redirect(['hotel-supplier/index']);
        }
        $searchModel = new HotelSettleDetailQuery();
        $searchModel['settle_id'] = $settle_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        echo '<pre>';
//        print_r($dataProvider->getModels());die;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'date_settle'  => self::DateSettle($settle_id),
            'settle_info'  => self::SettleInfo($settle_id),
            'settle_id'    => $settle_id,
        ]);
    }

    /**
     * Displays a single HotelSettleDetail model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HotelSettleDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HotelSettleDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HotelSettleDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing HotelSettleDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the HotelSettleDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return HotelSettleDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HotelSettleDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * @订单底价
     */
    public static function SalePrice($order_id, $num)
    {
        $total_price = HotelOrderDatePrice::find()
            ->where(['oid' => $order_id])
            ->sum('price');
        return ($total_price * $num);
    }
    /**
     * @入住人
     */
    public static function GuestsStr($order_id)
    {
        $guests_info = HotelOrderGuests::find()
            ->where(['order_id' => $order_id])
            ->select(['guest_name'])
            ->all();
        if (empty($guests_info)) {
            return '';
        }
        $guests_str = '';
        foreach ($guests_info as $value) {
            $guests_str .= $value['guest_name'].'/';
        }
        return rtrim($guests_str, '/');
    }
    /**
     * @结算周期 + 账单总计
     */
    public static function DateSettle($supplier_id)
    {
        $sql = "SELECT `start_time`,`end_time`,`total`,`status` FROM `hotel_supplier_settlement` WHERE `id`=:supplier_id";
        $data = Yii::$app->db->createCommand($sql)->bindValues([':supplier_id' => $supplier_id])->queryOne();
        return $data;
    }
    /**
     * @结算操作
     */
    public function actionSettleHandle()
    {
        if (Yii::$app->request->isAjax) {
            $settle_id = Yii::$app->request->post('data')['settle_id'];
            $update_data = [
                'status'        => 1,
                'pay_time'      => date('Y-m-d H:i:s'),
                'serial_number' => '***',
            ];
            Yii::$app->db->createCommand()
                ->update('hotel_supplier_settlement', $update_data, ['id' => $settle_id])
                ->execute();
            return 'success';
        } else {
            return '非法操作！';
        }
    }
    /**
     * @结算信息
     */
    public static function SettleInfo($settle_id)
    {
        $supplier_sql = "SELECT `supplier_id` FROM `hotel_supplier_settlement` WHERE `id`=:id";
        $supplier_id = SearchSql::_SearchScalarData($supplier_sql, [
            ':id' => $settle_id
        ]);
        $sql = "SELECT `account_number`,`account_name`,`bank_detail`,`mobile` FROM `hotel_supplier_account` WHERE `supplier_id`=:supplier_id";
        $settle_info = Yii::$app->db->createCommand($sql)->bindValues([':supplier_id' => $supplier_id])->queryOne();
        return $settle_info;
    }


}
