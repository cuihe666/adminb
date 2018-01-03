<?php

namespace backend\controllers;

use app\controllers\SmspushController;
use backend\config\Consts;
use backend\models\DtCitySeas;
use backend\models\Hotel;
use backend\models\HotelDateStatus;
use backend\models\HotelHouse;
use backend\models\SearchSql;
use backend\service\CommonService;
use backend\traits\AjaxTrait;
use common\tools\Helper;
use Yii;
use backend\models\HotelOrder;
use backend\models\HotelOrderQuery;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HotelOrderController implements the CRUD actions for HotelOrder model.
 */
class HotelOrderController extends Controller
{
    use AjaxTrait;
    public $order_id;

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

    public function init()
    {
        parent::init();
        $this->order_id = Yii::$app->request->get('id', null);
    }

    /**
     * Lists all HotelOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HotelOrderQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView()
    {


        $model = $this->findModel($this->order_id);
        $hotel = $model->getHotel()->one();
        if (is_null($hotel)) {
            return $this->redirectAndMsg('/hotel-order/index', '找不到订单对应的酒店', '');
        }
        $guests = $model->getOrderGuest()->all();
        $user = $model->getUser()->One();
        $orders = $model->getOrderItem()->with('houseName')->all();
        //@2017-11-13 11:28:55 fuyanfei to add hotel_coupon
        $coupon = Yii::$app->db->createCommand("SELECT * FROM hotel_order_coupon WHERE hotel_order_id = :hotel_order_id")
            ->bindValue(":hotel_order_id",$this->order_id)
            ->queryOne();
//        Helper::dd($orders);

        return $this->render('view', compact('model', 'hotel', 'guests', 'user', 'orders','coupon'));

    }

    public function actionCancel()
    {
        if (Yii::$app->request->isPost) {
            $res = $this->cancelOrder();
            if ($res) {
                $sql = "SELECT `hotel_name`,`in_time`,`out_time`,`day_num`,`order_mobile` FROM `hotel_order` WHERE `id`=:id";
                $order_info = Yii::$app->db->createCommand($sql)
                    ->bindValues([
                        ':id' => $this->order_id,
                    ])
                    ->queryOne();
                $in_time = isset($order_info['in_time'])?date('Y-m-d', strtotime($order_info['in_time'])):'';
                $out_time = isset($order_info['out_time'])?date('Y-m-d', strtotime($order_info['out_time'])):'';
                $content = sprintf(Consts::HOTEL_DENY_CODE, str_replace(" ","",$order_info['hotel_name']), $in_time, $out_time, $order_info['day_num']);
                SmspushController::sendSms($order_info['order_mobile'], $content);
                return $this->apiResponse(['code' => 200]);
            } else {
                $msg = Yii::$app->session->getFlash('message');
                return $this->apiResponse(['code' => 400, 'message' => $msg]);
            }
        }


        Helper::dd('actionCancel');

        $model = $this->findModel($this->order_id);

        $model->is_delete = 1;
        if ($model->save()) {
            return $this->redirectAndMsg('/hotel-order/index', '订单已取消', '');
        } else {
            return $this->redirectAndMsg('/hotel-order/index', '服务器繁忙请稍候重试', '');
        }

    }


    public function actionDeny()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->get('id');
            $model = $this->findModel($id);
            $model->is_deny = 0;
            $model->status = 31;
            $this->logStatus($model);
            $this->orderLog($model);
            $model->save(false);

            return $this->apiResponse(['code' => 200]);
        }

    }

    public function actionLog()
    {
        $query = Yii::$app->db
            ->createCommand("SELECT hotel_order_log.desc FROM hotel_order_log WHERE order_id={$this->order_id} ORDER BY created_at DESC ")
            ->queryAll();
        $array = array_map(function ($item) {
            return json_decode($item['desc'], true);
        }, $query);
        if (empty($query)) {
            $data = [
                'code' => 201,
                'data' => []
            ];
        } else {
            $data = [
                'code' => 200,
                'data' => $array
            ];
        }
        return $this->apiResponse($data);
    }

    public function actionConfirm()
    {
        $db = Yii::$app->db->beginTransaction();


        try {
            $res = $this->confirmOrder();
            if ($res) {
                $db->commit();
            } else {
                $db->rollBack();
            }
        } catch (\Exception $e) {
            $res = false;
            $db->rollBack();
        }

        if ($res) {
            $sql = "SELECT `hotel_name`,`in_time`,`out_time`,`day_num`,`order_mobile`,`address`,`mobile_area`,`mobile` FROM `hotel_order` WHERE `id`=:id";
            $order_info = Yii::$app->db->createCommand($sql)
                ->bindValues([
                    ':id' => $this->order_id,
                ])
                ->queryOne();
            $in_time = isset($order_info['in_time'])?date('Y-m-d', strtotime($order_info['in_time'])):'';
            $out_time = isset($order_info['out_time'])?date('Y-m-d', strtotime($order_info['out_time'])):'';
            $hotel_mobil = (isset($order_info['mobile_area'])?($order_info['mobile_area'].'-'):'').$order_info['mobile'];
            $content = sprintf(Consts::HOTEL_CONFIRM_CODE, $order_info['hotel_name'], $in_time, $out_time, $order_info['day_num'], $order_info['address'], $hotel_mobil);
            SmspushController::sendSms($order_info['order_mobile'], $content);
            return $this->redirectAndMsg('/hotel-order/index', '订单已确认', '');
        } else {
            return $this->redirect('/hotel-order/index');
        }
    }


    /**
     * Finds the HotelOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HotelOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HotelOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * 执行确认订单的流程
     * @return bool
     */
    protected function confirmOrder()
    {
        $model = $this->findModel($this->order_id);
        //获取订单订房的详细数据
        $order_price = $model->getOrderItem()->select(['datetime', 'hotel_id', 'hotel_house_id'])->asArray()->all();
        //统计订单总共订了各种类型的几套房
        $house_total = [];
        //用于组合需要查询的条件
        $select_condition = [];
        foreach ($order_price as $item) {
            $time = substr($item['datetime'], 0, 10);
            $key = $item['hotel_id'] . '_' . $item['hotel_house_id'] . '_' . $time;

            if (array_key_exists($key, $house_total)) {
                $house_total[$key] += 1;
            } else {
                $select_condition[] = [
                    'hotel_id' => $item['hotel_id'],
                    'hotel_house_id' => $item['hotel_house_id'],
                    'date_time' => $time
                ];
                $house_total[$key] = 1;
            }
        }

        if (empty($select_condition)) {
            $this->alertMsg('error', '无法匹配到相关订单详细条目,请核对订单');
            return false;
        }

        //根据条件获取酒店房间状态模型
        $house_status = HotelDateStatus::find();
        array_map(function ($condition) use ($house_status) {
            $house_status->orWhere($condition);
        }, $select_condition);
        $house_status_model = $house_status->all();

        //批量调整房间库存
        $error = [];
        foreach ($house_status_model as $status) {
            $res = $this->handleStatus($status, $house_total);
            if (!$res) {
                $error[] = $this->buildKeyName($model);
            }
        }


        //如果$house_total 不为空说明订单中有房间未确认过
        if (!empty($house_total)) {
            $this->alertMsg('error', '查找的房源不存在,不存在的房源有:' . implode('&&', $house_total));
            return false;
        }

        //$error 不为空的时候说明修改间库存的时候存在没修改成功的
        if (!empty($error)) {
            $this->alertMsg('error', '存储发生错误:' . implode('&&', $error));
            return false;
        }

//        $status_type = \Yii::$app->params['hotel_order_status'][$model->status];
//        $remark = <<<str
//当前状态: {$status_type};修改状态为: 确认订单
//str;
//        //操作录入日志
//        Helper::log([
//            'user_id' => $model->order_uid,
//            'table_name' => HotelOrder::tableName(),
//            'record_id' => $model->getPrimaryKey(),
//            'remark' => $remark
//        ]);

        $sql = "SELECT `in_time`,`out_time` FROM `hotel_order` WHERE `id`=:id";
        $order_infos = SearchSql::_SearchOneData($sql, [
            ':id' => $this->order_id
        ]);
        $now_time = time();
        if ($now_time < strtotime($order_infos['in_time'])) {
            $status = 12;//待入住
        }
        if ($now_time >= strtotime($order_infos['in_time'])) {
            $status = 13;//已入住
        }
        if ($now_time >= strtotime($order_infos['out_time'])) {
            $status = 31;//退款中
        }
        $model->status = $status;
        $model->is_deny = 0;
        $model->update_time = date('Y-m-d H:i:s', time());
        $this->logStatus($model);
        $this->orderLog($model, '确认订单');
        return $model->save();
    }

    /**
     * 根据条件来判定是否对房源状态进行修改
     * @param HotelDateStatus $model // 房态模型
     * @param $condition //订单每个组合需要的房间数量的数组
     * @return bool
     */
    protected function handleStatus(HotelDateStatus $model, &$condition)
    {
        $key = $this->buildKeyName($model);
        $used = $condition[$key];

        if ($model->type == 0) {
            return true;
        }

        if ($model->type == 1) {
            $model->stock -= $used;
            //如果扣除库存后出现负数将关闭房源,但是订单继续(这是产品的意思)
            if ($model->stock <= 0) {
                $model->status = 0;
                $model->stock = 0;
            }
        }

        unset($condition[$key]);

        return $model->save();
    }

    //将 model 中的内容组成一个 key
    protected function buildKeyName($model)
    {
        return $model->hotel_id . '_' . $model->hotel_house_id . '_' . substr($model->date_time, 0, 10);
    }

    protected function splitKeyName($key)
    {
        $arr = explode('_', $key);
        $key = ['hotel_id', 'hotel_house_id', 'date'];
        $res = [];
        foreach ($key as $index => $item) {
            $res[$item] = $arr[$index];
        }
        return $res;
    }


    /**
     * 取消订单逻辑
     */
    protected function cancelOrder()
    {
        $model = $this->findModel($this->order_id);


        $error_msg = null;
        switch ($model->status) {
            case 0 :
                //未付款时直接取消订单
                $model->status = 21;
                $error_msg = null;
                break;
            case 11:
                //已付款且待确认时直接退款
                $error_msg = $this->handleAfterPay($model, $this->order_id);
                break;
            case 12:
                //已经确认订单后按照取消政策处理
                $error_msg = $this->handleAfterPay($model, $this->order_id);
                break;
            default:
                return false;
        }


        if (empty($error_msg)) {
            $this->logStatus($model);
            $this->orderLog($model);
            $model->update_time = date('Y-m-d H:i:s', time());
            return $model->save();
        } else {
            Yii::$app->session->setFlash('message', $error_msg);
            return false;
        }
    }

    /**
     * 当是付款情况下进行的取消订单操作
     * @param HotelOrder $model
     * @return null|string
     */
    protected function handleAfterPay(HotelOrder $model, $order_id = NULL)
    {
        if (!empty($model->pay_time)) {
            $model->status = 31;
            $model->is_deny = 0;
            return null;
        }
        return '查询不到支付时间请确认';
    }
    /**
     * @拒单恢复库存
     */
    public static function CancelHandleStock($order_id)
    {
        try{
            $sql = "SELECT `house_num`,`hotel_id`,`hotel_house_id` FROM `hotel_order` WHERE `id`=:id";
            $order_info = SearchSql::_SearchOneData($sql, [
                ':id' => $order_id
            ]);
            $day_stock = $order_info['house_num'];
            $hotel_id = $order_info['hotel_id'];
            $hotel_house_id = $order_info['hotel_house_id'];
            if (empty($day_stock)) {
                throw new \Exception('house_num_null');
            }
            $date_sql = "SELECT `datetime` FROM `hotel_order_date_price` WHERE `oid`=:oid";
            $date_price_info = SearchSql::_SearchAllData($date_sql,[
                ':oid' => $order_id
            ]);
            if (empty($date_price_info)) {
                throw new \Exception('order_date_price_null');
            }
            foreach ($date_price_info as $value) {
                $date = date('Y-m-d', strtotime($value['datetime'])).' 00:00:00';
                $str = "UPDATE `hotel_date_status` SET `stock`=stock+{$day_stock} WHERE `date_time`='$date' AND `hotel_id`='$hotel_id' AND `hotel_house_id`='$hotel_house_id'";
                Yii::$app->db->createCommand($str)->execute();
            }
        }catch (\Exception $e) {
            $errMap = [
                'house_num_null' => '房间数量为空！',
                'order_date_price_null' => '订单价格日历信息为空！',
                'update_sql_abnormal'   => '更新日历库存异常！'
            ];
            return isset($errMap[$e->getMessage()])?false:false;
        }
        return true;
    }


    /**
     * 向管理员操作表中录入信息
     * @param HotelOrder $model
     */
    protected function logStatus(HotelOrder $model)
    {
        $new_type = \Yii::$app->params['hotel_order_status'][$model->status];
        $old_type = \Yii::$app->params['hotel_order_status'][$model->getOldAttribute('status')];
        $remark = <<<str
当前状态: {$old_type};修改状态为: {$new_type}
str;
        Helper::log([
            'user_id' => $model->order_uid,
            'table_name' => HotelOrder::tableName(),
            'record_id' => $model->getPrimaryKey(),
            'remark' => $remark
        ]);
    }


    /**
     * 向订单记录表中录入的信息
     * 复用了 admin_log 的内容,但是这个 log 表只是单独针对订单的操作记录
     */
    protected function orderLog(HotelOrder $model, $msg = null)
    {
        $new_type = \Yii::$app->params['hotel_order_status'][$model->status];
        $old_type = \Yii::$app->params['hotel_order_status'][$model->getOldAttribute('status')];
        $desc = $msg ?: Yii::$app->request->post('desc', '未填写');
        $remark = <<<str
当前状态: {$old_type};修改状态: {$new_type};
备注内容: {$desc};
str;

        $time = time();
        $desc = [
            "handler" => \Yii::$app->getUser()->identity->username,
            "time" => date('Y-m-d H:i:s', $time),
            "content" => $remark,
            "old_type" => "{$model->getOldAttribute('status')}",
            "new_status" => "{$model->status}",
        ];

        $data = [
            'order_id' => $model->id,
            'handler_id' => \Yii::$app->getUser()->identity->id,
            'desc' => json_encode($desc),
            'created_at' => $time,
            'old_status' => $model->getOldAttribute('status'),
            'new_status' => $model->status
        ];

        return \Yii::$app->db->createCommand()->insert('hotel_order_log', $data)->execute();
    }

    /**
     * @酒店订单拒绝退款
     * time:2017/8/7
     * user:ys
     */
    public function actionDenyRefund()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];
            $sql = "SELECT `status`,`pay_total` FROM `hotel_order` WHERE `id`=:id";
            $order_info = SearchSql::_SearchOneData($sql,[
                ':id' => $id
            ]);
            if ($order_info['status'] != 31) {//退款中
                return '订单状态异常！';
            }
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $update_data = [
                    'status'      => 33,//退款失败
                    'update_time' => date('Y-m-d H:i:s'),
                    'refund_price' => $order_info['pay_total'],
                ];
                if (!SearchSql::_UpdateSqlExecute('hotel_order', $update_data, ['id' => $id])) {
                    throw new \Exception('hotel_order_update_abnormal');
                }
                $username = SearchSql::_SearchScalarData("SELECT `username` FROM `user_backend` WHERE `id`=:id", [
                    ':id' => \Yii::$app->user->getId(),
                ]);
                $desc = "后台操作人".$username."对订单ID为".$id."进行了拒绝退款操作";
                $insert_data = [
                    'order_id'     => $id,
                    'handler_id'   => \Yii::$app->user->getId(),
                    'refund_price' => $order_info['pay_total'],
                    'create_time'  => date('Y-m-d H:i:s'),
                    'desc'         => $desc,
                ];
                if (!SearchSql::_InsertSqlExecute('hotel_refund_log', $insert_data)) {
                    throw new \Exception('refund_log_insert_abnormal');
                }
                $transaction->commit();
            }catch (\Exception $e) {
                $transaction->rollBack();
                $errMap = [
                    'hotel_order_update_abnormal' => '订单操作异常！',
                    'refund_log_insert_abnormal'  => '操作记录添加异常！'
                ];
                return isset($errMap[$e->getMessage()])?$errMap[$e->getMessage()]:"服务器异常！";
            }
            return 'success';
        } else {
            return '非法操作！';
        }
    }
    /**
     * @酒店订单确认退款
     * time:2017/8/8
     * user:ys
     */
    public function actionConfirmRefund()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data')['id'];
            $sql = "SELECT `status`,`pay_total`,`pay_platform`,`transaction_id`,`order_num` FROM `hotel_order` WHERE `id`=:id";
            $order_info = SearchSql::_SearchOneData($sql,[
                ':id' => $id
            ]);
            if ($order_info['status'] != 31) {//退款中
                return json_encode('订单异常！');
            }
            //判定IP
            $ip = CommonService::get_client_ip();
//            return json_encode($ip);
            if ($ip != '111.207.107.53' && $ip != '111.198.116.98' && $ip != '111.198.116.101') {
                return json_encode('IP异常');
            }
            //退款操作
            if ($order_info['pay_platform'] == 1) {//支付宝
                $return_data = CommonService::alipayreturn($order_info['transaction_id'], $order_info['pay_total']);
                if ($return_data->alipay_trade_refund_response->code != 10000) {
                    $msg = $return_data->alipay_trade_refund_response->sub_msg;
                    return json_encode($msg);
                }
            } else if ($order_info['pay_platform'] == 2) {//微信
                $return_data = CommonService::wxreturn($order_info['transaction_id'], $order_info['pay_total'], $order_info['pay_total'], $order_info['order_num']);
                if ($return_data['result_code'] != 'SUCCESS' || $return_data['return_code'] != 'SUCCESS') {
                    $msg = $return_data['err_code_des'];
                    return json_encode($msg);
                }
            } else {
                return json_encode('退款方式异常！');
            }
            //退款操作
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $username = SearchSql::_SearchScalarData("SELECT `username` FROM `user_backend` WHERE `id`=:id", [
                    ':id' => \Yii::$app->user->getId(),
                ]);
                $desc = "后台操作人".$username."对订单ID为".$id."进行了完成退款操作";
                $insert_data = [
                    'order_id'     => $id,
                    'handler_id'   => \Yii::$app->user->getId(),
                    'refund_price' => $order_info['pay_total'],
                    'create_time'  => date('Y-m-d H:i:s'),
                    'desc'         => $desc,
                ];
                if (!SearchSql::_InsertSqlExecute('hotel_refund_log', $insert_data)) {
                    throw new \Exception('refund_log_insert_abnormal');
                }
                $update_data = [
                    'status'      => 32,//完成退款
                    'update_time' => date('Y-m-d H:i:s'),
                    'refund_price' => $order_info['pay_total'],
                ];
                if (!SearchSql::_UpdateSqlExecute('hotel_order', $update_data, ['id' => $id])) {
                    throw new \Exception('hotel_order_update_abnormal');
                }
                if (!self::CancelHandleStock($id)) {
                    throw new \Exception('update_stock_abnormal');
                }
                $transaction->commit();
            }catch (\Exception $e) {
                $transaction->rollBack();
                $errMap = [
                    'alipay_refund_abnormal' => '支付宝退款异常！',
                    'weixin_refund_abnormal' => '微信退款异常！',
                    'refund_type_abnormal'   => '退款方式异常！',
                    'refund_log_insert_abnormal'  => '退款记录异常！',
                    'hotel_order_update_abnormal' => '订单状态更新异常！',
                    'update_stock_abnormal'  => '库存恢复异常',
                ];
                $data = isset($errMap[$e->getMessage()])?$errMap[$e->getMessage()]:'服务器异常';
                return json_encode($e->getMessage());
            }
            return json_encode('success');
        } else {
            return '非法请求！';
        }
    }

}
