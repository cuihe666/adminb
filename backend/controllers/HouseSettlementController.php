<?php

namespace backend\controllers;

use backend\models\OrderDetailStaticQuery;
use backend\service\CommonService;
use Yii;
use backend\models\HouseSettlement;
use backend\models\HouseSettlementQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HouseSettlementController implements the CRUD actions for HouseSettlement model.
 */
class HouseSettlementController extends Controller
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
     * Lists all HouseSettlement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HouseSettlementQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        dump($dataProvider);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HouseSettlement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new OrderDetailStaticQuery();
        $searchModel->type = 3;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new HouseSettlement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HouseSettlement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HouseSettlement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing HouseSettlement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the HouseSettlement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HouseSettlement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HouseSettlement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionTransfer()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            if (empty($id)) {
                $data = [
                    'code' => 0,
                    'msg' => '结算单异常'
                ];
                echo json_encode($data);
                die;
            }
            $ip = CommonService::get_client_ip();
            if ($ip != '111.207.107.53' && $ip != '111.198.116.101') {
                $data = [
                    'code' => 0,
                    'msg' => 'ip异常'
                ];
                echo json_encode($data);
                die;
            }
            $arr = Yii::$app->db->createCommand("select s.settle_id,s.total,s.status,s.uid,a.account_number,a.type,a.name from house_settlement as s JOIN account_bankcard as a ON s.uid=a.uid WHERE s.id=$id AND a.is_default=1")->queryOne();
            if (empty($arr) || empty($arr['settle_id'])) {
                $data = [
                    'code' => 0,
                    'msg' => '结算单异常'
                ];
                echo json_encode($data);
                die;
            }
            if ($arr['status'] != 0 && $arr['status'] != 2) {
                $data = [
                    'code' => 0,
                    'msg' => '结算单状态异常'
                ];
                echo json_encode($data);
                die;
            }
            if ($arr['type'] != 2 || empty($arr['account_number'])) {
                $data = [
                    'code' => 0,
                    'msg' => '支付宝账户有误'
                ];
                echo json_encode($data);
                die;
            }
            if ($arr['total'] < 0.1) {
                $data = [
                    'code' => 0,
                    'msg' => '打款金额有误'
                ];
                echo json_encode($data);
                die;
            }
            $res = CommonService::alipaytransfer($arr['settle_id'], $arr['account_number'], $arr['total'], '房源结算', $arr['name']);
            $admin_id = Yii::$app->user->getId();
            $remark = "后台管理员对用户id为{$arr['uid']}的进行了打款操作";
            $controller = $this->id;
            $action = $this->action->id;
            CommonService::log($arr['uid'], $admin_id, 'house_settlement', $id, $remark, $controller . '/' . $action);
            if ($res->alipay_fund_trans_toaccount_transfer_response->code != 10000) {
                $fail_cause = $res->alipay_fund_trans_toaccount_transfer_response->sub_msg;
                Yii::$app->db->createCommand("update house_settlement set status=2,fail_cause='{$fail_cause}' WHERE id=$id")->execute();
                $data = [
                    'code' => 0,
                    'msg' => $fail_cause
                ];
                echo json_encode($data);
                die;
            }
            $time = strtotime($res->alipay_fund_trans_toaccount_transfer_response->pay_date);
            $serial_number = $res->alipay_fund_trans_toaccount_transfer_response->order_id;
            Yii::$app->db->createCommand("update house_settlement set status=1,pay_time=$time,serial_number='{$serial_number}',fail_cause='打款成功' WHERE id=$id")->execute();
            Yii::$app->db->createCommand("insert into account_funds_log(uid,serial_number,type,income,description) VALUES ({$arr['uid']},'{$serial_number}',6,'{$arr['total']}','房源结算打款')")->execute();
            $data = [
                'code' => 1,
                'msg' => '转账成功'
            ];
            echo json_encode($data);
        }
    }
}
