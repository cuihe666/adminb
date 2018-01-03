<?php

namespace backend\controllers;

use backend\models\PlaneTicketInsuranceGoodsManage;
use backend\models\PlaneTicketInsuranceGoodsManageQuery;
use backend\models\PlaneTicketOrderEmplane;
use backend\models\PlaneTicketOrderInsurance;
use backend\models\PlaneTicketOrderInsuranceDetails;
use backend\models\SearchSql;
use Yii;
use backend\models\PlaneTicketSupplier;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlaneSupplierController implements the CRUD actions for PlaneTicketSupplier model.
 */
class PlaneInsuranceProfitController extends Controller
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
     * @保险供应商
     * @array('id' => 'supplier_name')
     */
    public function SupplierNameList()
    {
        $supplier_sql = "SELECT `id`,`name` FROM `plane_ticket_supplier` WHERE `ticket_genre`=0";
        $supplier_info = SearchSql::_SearchAllData($supplier_sql);
        if (empty($supplier_info)) {
            return [];
        }
        $result_arr = [];
        foreach ($supplier_info as $val) {
            $result_arr[$val['id']] = $val['name'];
        }
        return $result_arr;
    }

    /**
     * @机票供应商管理列表
     *
     */
    public function actionIndex()
    {
        $searchModel = new PlaneTicketInsuranceGoodsManageQuery();
        $searchModel['goods'] = 'goods';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sql_info = $searchModel->sql_info;
//        dd($sql_info);
        $insurance_total_info = SearchSql::_SearchAllData($sql_info);
        $result_data = $this->InsuranceTotalData($insurance_total_info);
//        dd($result_data);
//        dd($dataProvider->getModels());

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'supplierList' => $this->SupplierNameList(),//供应商筛选的数据
            'totalInfo'    => $result_data,//顶部总和信息（总单数/总佣金数）
        ]);
    }
    /**
     * @保险收益列表页
     */
    public function InsuranceTotalData($insurance_total_info)
    {
        //判断是否存在保险产品，不存在返回空
        if (empty($insurance_total_info)) {
            return '';
        }
        $supplier_id_arr = [];
//        dd($insurance_total_info);
        foreach ($insurance_total_info as $k => $value) {
            $supplier_id_arr[] = $value['supplier_id'];
        }
        $supplier_id_arr = array_unique($supplier_id_arr);
//        dd($supplier_id_arr);
        //总的保单数（不包含退款成功的乘机人保单）
        $total_num = PlaneTicketOrderEmplane::find()
            ->where(['insurance_supplier_id' => $supplier_id_arr])//符合查询条件的保险供应商下的乘机人保单
            ->andWhere(['<>', 'refund_insurance_status', 2])//去除退保成功的乘机人保单
            ->andWhere(['<>', 'insurance_type', 0])//保险类型不能为0（0即为保险类型空）
            ->count();
//        dd($total_num->createCommand()->getRawSql());
        //符合条件的保单的收益金额的总和
        $insurance_commision_total_num = PlaneTicketOrderEmplane::find()
            ->where(['insurance_supplier_id' => $supplier_id_arr])//符合查询条件的保险供应商下的乘机人保单
            ->andWhere(['<>', 'refund_insurance_status', 2])//去除退保成功的乘机人保单
            ->andWhere(['<>', 'insurance_type', 0])//保险类型不能为0（0即为保险类型空）
            ->sum('insurance_commision');//保险佣金
        $count_data = [
            'total_num' => $total_num,//总保单数
            'insurance_total' => $insurance_commision_total_num,//保险佣金总额
        ];
//        dd($count_data);
        return $count_data;
    }
    /**
     * Displays a single PlaneTicketSupplier model.
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
     * Deletes an existing PlaneTicketSupplier model.
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
     * Finds the PlaneTicketSupplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PlaneTicketSupplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlaneTicketInsuranceGoodsManage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @投保总量
     */
    public static function NoRefundNum($data, $type)
    {
        $total = 0;
        if (empty($data)) {
            return $total;
        }
//        dd($data);
//        dd($type);
        foreach ($data as $value) {
//            dd($value);
            $num = PlaneTicketOrderEmplane::find()
                ->where(['order_id' => $value['id']])//订单ID
//                ->andWhere(['<>', 'refund_insurance_status', 2])//未退保
                ->andWhere(['insurance_type' => $type])//保险类型
                ->count();
            $total += $num;
        }
        return $total;
    }
    /**
     * @退保数量
     */
    public static function EmplaneInsuranceRefundNum($data, $type)
    {
        $total = 0;
        if (empty($data)) {
            return $total;
        }
        foreach ($data as $value) {
            $num = PlaneTicketOrderEmplane::find()
                ->where(['order_id' => $value['id']])//订单ID
                ->andWhere(['refund_insurance_status' => 2])//退保成功的
                ->andWhere(['insurance_type' => $type])//保险类型
                ->select([
                    'id'
                ])
                ->count();
            $total += $num;
        }
        return $total;
    }
    /**
     * @算取总佣金数
     */
    public static function TotalProfit($data, $type)
    {
        $total = 0;
        if (empty($data)) {
            return $total;
        }
        foreach ($data as $value) {
            $num = PlaneTicketOrderEmplane::find()
                ->where(['order_id' => $value['id']])//订单ID
                ->andWhere(['<>', 'refund_insurance_status', 2])//未退保（2.退保成功）
                ->andWhere(['insurance_type' => $type])//保险类型
                ->sum('insurance_commision');
            $total += $num;
        }
        return $total;
    }

}
