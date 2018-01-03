<?php
namespace backend\controllers;

use backend\models\PlaneTicketOrder;
use backend\models\PlaneTicketOrderAlirefundRes;
use backend\models\PlaneTicketOrderQuery;
use backend\models\PlaneTicketOrderTicketRefundmentQuery;
use backend\models\PlaneTicketOrderWxrefundRes;
use yii\web\Controller;

class PlaneTicketAccountController extends Controller
{
    /**
     * @收款报表
     */
    public function actionReceivables()
    {
        $searchModel = new PlaneTicketOrderQuery();
        $searchModel->receivables = 'Receivables';//收款报表标记
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
//        dd($dataProvider->getModels());
        return $this->render('receivables',[
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * @退款报表
     */
    public function actionRefund()
    {
        $searchModel = new PlaneTicketOrderQuery();
        $searchModel->refund_account = 'refund_account';
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
//        dd($dataProvider->getModels());
        return $this->render('refund',[
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * @用户支付第三方流水号（收款/退款报表）
     * @ params: $pay_type 支付方式
     * @ params: $order_id 机票订单ID
     * @ return: 第三方流水号
     */
    public static function UserToTangoPayTradeNo($pay_type, $order_id)
    {
        $trade_no = '';
        if ($pay_type == 1) {//支付宝
            $trade_no_sql = "SELECT `trade_no` FROM `plane_ticket_order_alipay_res` WHERE `order_id`=:order_id";
            $trade_no = \Yii::$app->db->createCommand($trade_no_sql)
                ->bindValues([':order_id' => $order_id])
                ->queryScalar();
        } else if ($pay_type == 2) {//微信
            $trade_no_sql = "SELECT `transaction_id` FROM `plane_ticket_order_wxpay_res` WHERE `order_id`=:order_id";
            $trade_no = \Yii::$app->db->createCommand($trade_no_sql)
                ->bindValues([':order_id' => $order_id])
                ->queryScalar();
        }
        return $trade_no;
    }
    /**
     * @机票实退款 （退款报表）
     * @ params: $order_id 订单id
     * @ params: $pay_type 支付方式
     */
    public static function PlaneTicketRefundFee($order_id, $pay_type)
    {
        $refund_money = 0;
        if ($pay_type == 1) {//支付宝
            $refund_money = PlaneTicketOrderAlirefundRes::find()
                ->where(['order_id' => $order_id])
                ->andWhere(['refund_status' => 1])//退款状态:1 退款成功,2 退款失败
                ->sum('refund_fee');
        } else if ($pay_type == 2) {//微信（微信的金币记录单位是分！！！）
            $re_refund_money = PlaneTicketOrderWxrefundRes::find()
                ->where(['order_id' => $order_id])
                ->andWhere(['refund_status' => 1])//退款状态:1 退款成功,2 退款失败
                ->sum('refund_fee');
            $refund_money = $re_refund_money/100;
        }
        return $refund_money;
    }
    /**
     * @机票实退款时间（给用户）
     * @ params: $order_id 订单id
     * @ params: $pay_type 支付方式
     */
    public static function PlaneTicketRefundDateToUser($order_id, $pay_type)
    {
        $refund_date = '';
        if ($pay_type == 1) {//支付宝
            $trade_no_sql = "SELECT `create_time` FROM `plane_ticket_order_alirefund_res` WHERE `order_id`=:order_id ORDER BY `create_time` DESC";
            $refund_date = \Yii::$app->db->createCommand($trade_no_sql)
                ->bindValues([':order_id' => $order_id])
                ->queryScalar();
        } else if ($pay_type == 2) {//微信
            $trade_no_sql = "SELECT `create_time` FROM `plane_ticket_order_wxrefund_res` WHERE `order_id`=:order_id ORDER BY `create_time` DESC";
            $refund_date = \Yii::$app->db->createCommand($trade_no_sql)
                ->bindValues([':order_id' => $order_id])
                ->queryScalar();
        }
        return $refund_date;
    }
    /**
     * @保险实退款
     */
    public static function PlaneInsuranceRefundFee($model)
    {
        $insurance_fee_number = 0;
        $insurance_money = 0;
        if (!empty($model->emplane)) {
            foreach ($model->insuranceOrderDetails as $values) {
                if ($values['refund_insurance_price_status'] == 4) {//4退保退款成功（异步）
                    $insurance_fee_number += 1;
                }
                //实际退款的单价金额
                if (!empty($values['insurance_money'])) {
                    $insurance_money = $values['insurance_money'];
                }
            }
        }
        // （保单支付总金额 / 总投保人数）* 退保成功人数 = 保险退款
        return ($insurance_money * $insurance_fee_number);
    }
    /**
     * @机票利润（收款报表）
     * @ params: $model 乘机人数据信息
     */
    public static function PlaneTicketProift($model)
    {
        $ticket_profit_sum = 0;
        if (!empty($model->emplane)) {
            foreach ($model->emplane as $vals) {
                if (!empty($vals['ticket_commision'])) {
                    $ticket_profit_sum += $vals['ticket_commision'];
                }
            }
        }
        return $ticket_profit_sum;
    }
}