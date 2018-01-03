<?php

namespace backend\controllers;

use backend\models\TravelActivity;
use backend\models\TravelHigo;
use backend\models\User;
use backend\models\UserCommon;
use backend\service\CommonService;
use backend\service\OrderLogService;
use backend\service\SmsService;
use Yii;
use backend\models\TravelOrder;
use backend\models\TravelOrderQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TravelOrderController implements the CRUD actions for TravelOrder model.
 */
class TravelOrderController extends Controller
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
     * @待处理订单入口
     *
     */
    public function actionPending()
    {
        $searchModel = new TravelOrderQuery();
        $searchModel['refund_stauts'] = 52;//退款中
        $searchModel['close_account'] = 0;//未结算
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('pending', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @异常订单
     */
    public function actionAbnormal()
    {
        $searchModel = new TravelOrderQuery();
        $searchModel['refund_stauts'] = 52;//退款中
        $searchModel['close_account'] = 1;//已结算
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('abnormal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all TravelOrder models.
     *  @ 旅游订单主入口
     */
    public function actionIndex()
    {
        $searchModel = new TravelOrderQuery();
//        $searchModel['refund_note'] = 'ssr';//屏蔽 退款中订单...
        $searchModel->type = 0;
        $dataProvider = $searchModel->searchNew(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order_type' => '0'
        ]);
    }

    /**
     *  @主题线路
     */
    public function actionTheme()
    {
        $searchModel = new TravelOrderQuery();
        $searchModel->type = 3;
        //$searchModel['higo_type'] = 'higo';
//        $searchModel['refund_note'] = 'ssr';//屏蔽 退款中订单...
        $dataProvider = $searchModel->searchNew(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order_type' => '3'
        ]);
    }

    /**
     *  @当地活动
     */
    public function actionLocal()
    {
        $searchModel = new TravelOrderQuery();
        $searchModel->type = 2;
        //$searchModel['local_type'] = 'local';
//        $searchModel['refund_note'] = 'ssr';//屏蔽 退款中订单...
        $dataProvider = $searchModel->searchNew(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order_type' => '2'
        ]);
    }

    /**
     *  @当地向导
     */
    public function actionGuide()
    {
        $searchModel = new TravelOrderQuery();
        $searchModel->type = 5;
        //$searchModel['guide_type'] = 'guide';
//        $searchModel['refund_note'] = 'ssr';//屏蔽 退款中订单...
        $dataProvider = $searchModel->searchNew(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order_type' => '5'
        ]);
    }

    /**
     *  @旅游待处理订单
     */
    public function actionWait()
    {
//        $searchModel = new TravelOrderQuery();
//        $searchModel['wait'] = 'wait';
////        $searchModel['refund_note'] = 'ssr';//屏蔽 退款中订单...
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel'  => $searchModel,
//            'dataProvider' => $dataProvider,
//            'all'          => 'all'
//        ]);
    }

    /**
     * Displays a single TravelOrder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = TravelOrder::find()->WHERE(['id' => $id])->One();
        $uid = $model['travel_uid'];
        $team_info = Yii::$app->db->createCommand("SELECT * FROM `travel_order_contacts` WHERE `order_id`='$id'")->queryAll();//参团人信息
        $user_info = Yii::$app->db->createCommand("SELECT * FROM `user` WHERE `id`='$uid'")->queryOne();//获取电话
        $user_data['mobile'] = $user_info['mobile'];//达人电话
        $user_arr = Yii::$app->db->createCommand("SELECT * FROM `user_common` WHERE `uid`='$uid'")->queryOne();
        $user_data['nickname'] = $user_arr['nickname'];
        //付燕飞 2017年3月27日17:46:05 增加一下代码！！
        //如果qrcode_id！=0 的话，查询 二维码的信息，获取城市编码
        /* $qrcode_info = null;
         if(intval($model->qrcode_id)!=0){
             $qrcode_info = Yii::$app->db->createCommand("SELECT city_code,qrcode_url FROM `qrcode` WHERE `qrcode_id`='$model->qrcode_id'")->queryOne();
         }*/
        return $this->render('view', [
            'model' => $model,
            'team_info' => $team_info,
            'user_data' => $user_data,
            //'qrcode_info' => $qrcode_info,
        ]);
    }

    /**
     * Creates a new TravelOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TravelOrder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TravelOrder model.
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
     * Deletes an existing TravelOrder model.
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
     * Finds the TravelOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TravelOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TravelOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /******   修改订单状态   ****************/
    public function actionOperation()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data');
            $id_info = explode('-', $data['id']);
            $id = $id_info[0];//订单ID
            $select = $id_info[1];//选择 Y or N
            $status = $data['status'];//订单状态
            $order_info = TravelOrder::find()->where(['id' => $id])->one();
            //判定选择结果
            $result = '';//支付状态
            $return = '';//退款状态
            $sql = "";//操作
            $date = date("Y-m-d H:i:s");
            if ($order_info['refund_stauts'] == 0) {//支付流程
                switch ($status) {
                    case 11://待支付
                        $result = 33;//已取消
                        //付燕飞 2017年3月30日17:54:22增加is_first = 0，如果为待支付的话取消订单，要把is_first=0
                        //$sql = "UPDATE `travel_order` SET `state`='$result' ,is_first = 0  WHERE `id`='$id'";
                        $sql = "UPDATE `travel_order` SET `state`='$result' WHERE `id`='$id'";
                        break;
                    case 21://已支付
                        if ($select == 'y') {
                            $result = 32;//已确认
                            $sql = "UPDATE `travel_order` SET `state`='$result', `confirm_time`='$date' WHERE `id`='$id'";
                        } else {
                            $return = 52;//退款中
                            $result = 52;
                            $sql = "UPDATE `travel_order` SET `refund_stauts`='$return', `confirm_time`='$date' WHERE `id`='$id'";
                        }
                        break;
                    case 31://待确认
                        if ($select == 'y') {
                            $result = 32;//已确认
                            $sql = "UPDATE `travel_order` SET `state`='$result', `confirm_time`='$date' WHERE `id`='$id'";
                        } else {
                            $return = 52;//退款中
                            $result = 52;
                            $sql = "UPDATE `travel_order` SET `refund_stauts`='$return', `confirm_time`='$date' WHERE `id`='$id'";
                        }
                        break;
                    case 32://已确认
                        $return = 52;//退款中
                        $result = 52;
                        $sql = "UPDATE `travel_order` SET `refund_stauts`='$return', `confirm_time`='$date' WHERE `id`='$id'";
                        break;
                    default:
                        break;
                }
            } else {//退款流程
                switch ($status) {
                    case 51://待退款
                        if ($select == 'y') {
                            $return = 52;//退款中
                            $result = 52;
                        } else {
                            $return = 54;//退款失败
                            $result = 54;
                        }
                        $sql = "UPDATE `travel_order` SET `refund_stauts`='$return' WHERE `id`='$id'";
                        break;
                    default:
                        break;
                }
            }
            //数据库操作
            if (!empty($sql)) {
                if ($return == 52) {
                    $admin_id = Yii::$app->user->getId();//登录人ID
                    $order_uid = $order_info['order_uid'];//用户ID
                    $remark = "后台管理员ID为{$admin_id}对用户ID为{$order_uid}进行了确认退款（旅游->退款中）。";
                    $controller = $this->id;
                    $action = $this->action->id;
                    CommonService::log($order_uid, $admin_id, 'travel_order', $id, $remark, $controller . '/' . $action);
                }
                Yii::$app->db->createCommand($sql)->execute();//
                //添加订单操作日志
                $log = OrderLogService::insertOrderLog($id,$status,$result);
                //@2017-8-4 16:02:50 fuyanfei add 如果确认订单，需要给用户发送短信
                if($result==32){
                    $res = SmsService::orderConfirmSms($id);
                }
                //@2017-8-4 16:02:50 fuyanfei add 如果确认订单，需要给用户发送短信
                if($result==33){
                    $res = SmsService::orderRefuseSms($id);
                }
                //@2017-8-4 16:02:50 fuyanfei add 如果拒绝退款，需要给用户发送短信
                if($return==54){
                    $res = SmsService::refundFailSms($id);
                }
                echo 'success';
            } else {
                echo 'fail';
            }
        }
    }

    /******** 完成退款 **********/
    public function actionComplete_refund()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data');
            //判定传值有效性
            if (empty($id)) {
                $data = array(
                    'code' => '1',
                    'msg' => '订单异常'
                );
                echo json_encode($data);
                die;
            }
            //判定IP
            $ip = CommonService::get_client_ip();
            if ($ip != '111.207.107.53' && $ip != '111.198.116.98' && $ip != '111.198.116.101') {
                $data = array(
                    'code' => '1',
                    'msg' => 'IP异常'
                );
                echo json_encode($data);
                die;
            }
            //判定订单是否存在
            $order_info = Yii::$app->db->createCommand("SELECT * FROM `travel_order` WHERE `id`='$id'")->queryOne();
            if (empty($order_info)) {
                $data = array(
                    'code' => '1',
                    'msg' => '订单异常'
                );
                echo json_encode($data);
                die;
            }
            //判定退款状态
            if ($order_info['refund_stauts'] != 52) {
                $data = array(
                    'code' => '1',
                    'msg' => '订单异常'
                );
                echo json_encode($data);
                die;
            }
            //判断调用退款接口
            //$order_type = Yii::$app->redis->get('theme_hyy');     //closed by snowno in 2017/10/10  cause 支付来源取trade_type
            //$theme_arr = explode(',', $order_type);     //closed by snowno in 2017/10/10  cause 支付来源取trade_type
            //$order_info['theme_type'] == 12 || $order_info['theme_type']==4 || $order_info['theme_type']==2 || $order_info['theme_type']==7 || $order_info['theme_type']==5 || $order_info['theme_type']==26
            //@2017-8-4 16:34:31 to add transcation and try catch
            $trans = Yii::$app->db->beginTransaction();
            try{
                //以下代码404-457行 close by snowno in 2017/10/10 cause 支付来源取trade_type
/*                if (in_array($order_info['theme_type'], $theme_arr)) {
                    //判定退款方式(微信、支付宝)
                    if ($order_info['pay_platform'] == 1) {
                        $return_data = CommonService::alipayreturn($order_info['trade_no'], $order_info['pay_amount']);
                        //添加操作日志
                        $admin_id = Yii::$app->user->getId();//登录人ID
                        $order_uid = $order_info['order_uid'];//用户ID
                        $remark = "后台管理员ID为{$admin_id}对用户ID为{$order_uid}进行了支付宝退款操作（旅游）。";
                        $controller = $this->id;
                        $action = $this->action->id;
                        CommonService::log($order_uid, $admin_id, 'travel_order', $id, $remark, $controller . '/' . $action);
                        if ($return_data->alipay_trade_refund_response->code != 10000) {
                            $data = [
                                'code' => '-2',
                                'msg' => $return_data->alipay_trade_refund_response->sub_msg
                            ];
                            echo json_encode($data);
                            die;
                        }
                    } else if ($order_info['pay_platform'] == 2) {//微信
                        $url = 'http://106.14.16.252:9966/login/wxreturn';
                        $data = [
                            'transaction_id' => $order_info['trade_no'],
                            'total_fee' => $order_info['pay_amount'],
                            'refund_fee' => $order_info['pay_amount'],
                            'order_num' => $order_info['order_no']
                        ];
//                    $url=$url.'?transaction_id='.$order_info['trade_no'].'&total_fee='.$order_info['pay_amount'].'&refund_fee='.$order_info['pay_amount'].'&order_num='.$order_info['order_no'];
//                    file_get_contents($url);die;
                        $return_data = CommonService::sub_post($url, $data);
                        $return_data = json_decode($return_data, true);
                        $admin_id = Yii::$app->user->getId();//登录人ID
                        $order_uid = $order_info['order_uid'];//用户ID
                        $remark = "后台管理员ID为{$admin_id}对用户ID为{$order_uid}进行了微信退款操作（旅游）。";
                        $controller = $this->id;
                        $action = $this->action->id;
                        CommonService::log($order_uid, $admin_id, 'travel_order', $id, $remark, $controller . '/' . $action);
                        if ($return_data['result_code'] != 'SUCCESS' || $return_data['return_code'] != 'SUCCESS') {
                            $data = [
                                'code' => '-3',
                                'msg' => $return_data['err_code_des']
                            ];
                            echo json_encode($data);
                            die;
                        }
                    } else {
                        $data = array(
                            'code' => '1',
                            'msg' => '退款方式异常'
                        );
                        echo json_encode($data);
                        die;
                    }
                } else {*/

                    //判定退款方式(微信、支付宝)
                    if ($order_info['pay_platform'] == 1) {//支付宝
                        $return_data = CommonService::alipayreturn($order_info['trade_no'], $order_info['pay_amount']);
                        //添加操作日志
                        $admin_id = Yii::$app->user->getId();//登录人ID
                        $order_uid = $order_info['order_uid'];//用户ID
                        $remark = "后台管理员ID为{$admin_id}对用户ID为{$order_uid}进行了支付宝退款操作（旅游）。";
                        $controller = $this->id;
                        $action = $this->action->id;
                        CommonService::log($order_uid, $admin_id, 'travel_order', $id, $remark, $controller . '/' . $action);
                        if ($return_data->alipay_trade_refund_response->code != 10000) {
                            $data = [
                                'code' => '-4',
                                'msg' => $return_data->alipay_trade_refund_response->sub_msg
                            ];
                            echo json_encode($data);
                            die;
                        }
                    } else if ($order_info['pay_platform'] == 2) {//微信
                        if($order_info['trade_type'] == 'APP'){
                            $return_data = CommonService::wxreturn($order_info['trade_no'], $order_info['pay_amount'], $order_info['pay_amount'], $order_info['order_no']);
                            //$return_data = CommonService::wxtravelruturn($order_info['trade_no'], $order_info['pay_amount'], $order_info['pay_amount'], $order_info['order_no']);
                            //添加操作日志
                            $admin_id = Yii::$app->user->getId();//登录人ID
                            $order_uid = $order_info['order_uid'];//用户ID
                            $remark = "后台管理员ID为{$admin_id}对用户ID为{$order_uid}进行了微信退款操作（旅游）。";
                            $controller = $this->id;
                            $action = $this->action->id;
                            CommonService::log($order_uid, $admin_id, 'travel_order', $id, $remark, $controller . '/' . $action);
                            if ($return_data['result_code'] != 'SUCCESS' || $return_data['return_code'] != 'SUCCESS') {
                                $data = [
                                    'code' => '-5',
                                    'msg' => $return_data['err_code_des']
                                ];
                                echo json_encode($data);
                                die;
                            }

                        }elseif($order_info['trade_type'] == 'JSAPI'){
                            $url = 'http://106.14.16.252:9966/wx/wxreturn';
                            $data = [
                                'transaction_id' => $order_info['trade_no'],
                                'total_fee' => $order_info['pay_amount'],
                                'refund_fee' => $order_info['pay_amount'],
                                'order_num' => $order_info['order_no']
                            ];
                            //$url=$url.'?transaction_id='.$order_info['trade_no'].'&total_fee='.$order_info['pay_amount'].'&refund_fee='.$order_info['pay_amount'].'&order_num='.$order_info['order_no'];
                            //file_get_contents($url);die;
                            $return_data = CommonService::sub_post($url, $data);
                            $return_data = json_decode($return_data, true);
                            $admin_id = Yii::$app->user->getId();//登录人ID
                            $order_uid = $order_info['order_uid'];//用户ID
                            $remark = "后台管理员ID为{$admin_id}对用户ID为{$order_uid}进行了微信退款操作（旅游）。";
                            $controller = $this->id;
                            $action = $this->action->id;
                            CommonService::log($order_uid, $admin_id, 'travel_order', $id, $remark, $controller . '/' . $action);
                            if ($return_data['result_code'] != 'SUCCESS' || $return_data['return_code'] != 'SUCCESS') {
                                $data = [
                                    'code' => '-3',
                                    'msg' => $return_data['err_code_des']
                                ];
                                echo json_encode($data);
                                die;
                            }
                        }
                    } else {
                        $data = array(
                            'code' => '1',
                            'msg' => '退款方式异常'
                        );
                        echo json_encode($data);
                        die;
                    }
//                }   //close by snowno in 2017/10/10 cause 支付来源改取trade_type 取消使用theme_type
                //修改订单状态(53已退款)
                Yii::$app->db->createCommand("UPDATE `travel_order` SET `refund_stauts`=53 WHERE `id`='$id'")->execute();
                //添加订单操作日志
                $log = OrderLogService::insertOrderLog($id,$order_info['refund_stauts'],53);
                //恢复库存
                $travel_id = $order_info['travel_id'];//活动ID
                $active_date = $order_info['activity_date'];//活动日期
                if ($order_info['type'] == 2) {//当地活动
                    $stock_num = $order_info['anum'];
                    $sql = "UPDATE `travel_activity_date_price` SET `stock`=`stock`+{$stock_num} WHERE `activity_id`='$travel_id' AND `date`='$active_date'";
                    $updStock = Yii::$app->db->createCommand($sql)->execute();
                    if (!$updStock) {
                        $data = array(
                            'code' => '1',
                            'msg' => '库存恢复失败'
                        );
                        echo json_encode($data);
                        die;
                    }
                } else if ($order_info['type'] == 3) {//主题higo
                    $stock_num = $order_info['adult'] + $order_info['child'];
                    $updStock = Yii::$app->db->createCommand("UPDATE `travel_higo_date_price` SET `stock`=`stock`+{$stock_num} WHERE `higo_id`='$travel_id' AND `date`='$active_date'")->execute();
                    if (!$updStock) {
                        $data = array(
                            'code' => '1',
                            'msg' => '库存恢复失败'
                        );
                        echo json_encode($data);
                        die;
                    }
                }
                //恢复优惠券
                $coupon_id = Yii::$app->db->createCommand("SELECT `coupon_id` FROM `travel_order_coupon` WHERE `order_id`='$id'")->queryColumn();
                if (!empty($coupon_id)) {
                    $coupon_str = implode(',', $coupon_id);
                    $update_time = date('Y-m-d H:i:s');
                    $couponRes = Yii::$app->db->createCommand("UPDATE `coupon_get` SET `get_status`=0, `update_time`='$update_time' WHERE `id` IN ({$coupon_str})")->execute();
                    if (!$couponRes) {
                        $data = array(
                            'code' => '1',
                            'msg' => '优惠券退还失败'
                        );
                        echo json_encode($data);
                        die;
                    }
                }
                $trans->commit();
                $data = [
                    'code' => '0',
                    'msg' => '退款成功'
                ];
//                echo json_encode($data);
//                die;
            } catch(\Exception $e){
                $trans->rollBack();
                $data = [
                    'code' => '-1',
                    'msg' => '执行失败',
                ];
            }
            if($data['code']==0){
                //退款成功时发送短信
                $res = SmsService::refundSuccessSms($id);
            }
            echo json_encode($data);
            die;
        }
    }
    /*******  异常订单退款  **********/
    public function actionOperation_refund()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data');//ID
            $test = explode('-', $data);
            $id = $test[0];
            $status = $test[1];
            $order_info = Yii::$app->db->createCommand("SELECT * FROM `travel_order` WHERE `id`='$id'")->queryOne();
            if ($status == 'n') {
                $tran = Yii::$app->db->beginTransaction();
                try{
                    Yii::$app->db->createCommand("UPDATE `travel_order` SET `refund_stauts`=54 WHERE `id`='$id'")->execute();
                    //添加操作日志
                    $admin_id = Yii::$app->user->getId();//登录人ID
                    $order_uid = $order_info['order_uid'];//用户ID
                    $remark = "后台管理员ID为{$admin_id}对用户ID为{$order_uid}进行了异常订单驳回退款操作（旅游）。";
                    $controller = $this->id;
                    $action = $this->action->id;
                    CommonService::log($order_uid, $admin_id, 'travel_order', $id, $remark, $controller . '/' . $action);
                    //添加订单操作日志
                    $log = OrderLogService::insertOrderLog($id,$order_info['refund_stauts'],54);
                    //@2017-8-4 17:32:31 fuyanfei to add send sms退款失败，给用户发送短信提醒
                    $res = SmsService::refundFailSms($id);
                    $tran->commit();
                    $data = [
                        'code' => '0',
                        'msg' => '已驳回'
                    ];
                }
                catch(\Exception $e){
                    $tran->rollBack();
                    $data = [
                        'code' => '-1',
                        'msg' => '执行失败',
                    ];
                }
                echo json_encode($data);
                die;
            }
            //判定传值有效性
            if (empty($id)) {
                $data = array(
                    'code' => '1',
                    'msg' => '订单异常'
                );
                echo json_encode($data);
                die;
            }
            //判定IP
            $ip = CommonService::get_client_ip();
            if ($ip != '111.207.107.53' && $ip != '111.198.116.98' && $ip != '111.198.116.101') {
                $data = array(
                    'code' => '1',
                    'msg' => 'IP异常'
                );
                echo json_encode($data);
                die;
            }
            //判定订单是否存在
            if (empty($order_info)) {
                $data = array(
                    'code' => '1',
                    'msg' => '订单异常'
                );
                echo json_encode($data);
                die;
            }
            //判定退款状态
            if ($order_info['refund_stauts'] != 52) {
                $data = array(
                    'code' => '1',
                    'msg' => '订单异常'
                );
                echo json_encode($data);
                die;
            }

            //*******************@2017-8-4 17:33:04 fuyanfei to add begintranscate & try catch*******************/
            $trans = Yii::$app->db->beginTransaction();
            try{
                //跳过退款(异常订单)
                //修改订单状态(53已退款)
                Yii::$app->db->createCommand("UPDATE `travel_order` SET `refund_stauts`=53 WHERE `id`='$id'")->execute();
                //添加订单操作日志
                $log = OrderLogService::insertOrderLog($id,$order_info['refund_stauts'],53);
                //添加操作日志
                $admin_id = Yii::$app->user->getId();//登录人ID
                $order_uid = $order_info['order_uid'];//用户ID
                $remark = "后台管理员ID为{$admin_id}对用户ID为{$order_uid}进行了异常订单完成退款操作（旅游）。";
                $controller = $this->id;
                $action = $this->action->id;
                CommonService::log($order_uid, $admin_id, 'travel_order', $id, $remark, $controller . '/' . $action);

                //恢复库存
                $travel_id = $order_info['travel_id'];//活动ID
                $active_date = $order_info['activity_date'];//活动日期
                if ($order_info['type'] == 2) {//当地活动
                    $stock_num = $order_info['anum'];
                    $sql = "UPDATE `travel_activity_date_price` SET `stock`=`stock`+{$stock_num} WHERE `activity_id`='$travel_id' AND `date`='$active_date'";
                    $stock_res = Yii::$app->db->createCommand($sql)->execute();
                } else if ($order_info['type'] == 3) {//主题higo
                    $stock_num = $order_info['adult'] + $order_info['child'];
                    $sql = "UPDATE `travel_higo_date_price` SET `stock`=`stock`+{$stock_num} WHERE `higo_id`='$travel_id' AND `date`='$active_date'";
                    $stock_res = Yii::$app->db->createCommand($sql)->execute();
                }
                //恢复优惠券
                $coupon_id = Yii::$app->db->createCommand("SELECT `coupon_id` FROM `travel_order_coupon` WHERE `order_id`='$id'")->queryColumn();
                if (!empty($coupon_id)) {
                    $coupon_str = implode(',', $coupon_id);
                    $update_time = date('Y-m-d H:i:s');
                    $coupon_sql = "UPDATE `coupon_get` SET `get_status`=0, `update_time`='$update_time' WHERE `id` IN ({$coupon_str})";
                    $coupon_res = Yii::$app->db->createCommand($coupon_sql)->execute();
                }
                $trans->commit();
                $data = [
                    'code' => '0',
                    'msg' => '退款成功'
                ];
            } catch(\Exception $e){
                $trans->rollBack();
                $data = [
                    'code' => '-1',
                    'msg' => '执行失败',
                ];
            }
            //如果退款成功，给用户发送短信提醒
            if($data['code']==0){
                $res = SmsService::refundSuccessSms($id);
            }
            echo json_encode($data);
            die;
        }
    }

    /****** 商品城市 *******/
    public static function actionWare_city($oid, $type)
    {
        $order_info = TravelOrder::find()
            ->where(['id' => $oid])
            ->select(['travel_id'])
            ->asArray()
            ->one();
        if ($type == 2) {//当地活动
            $active_info = TravelActivity::find()
                ->where(['id' => $order_info['travel_id']])
                ->select(['city_code'])
                ->asArray()
                ->one();
            $city_code = $active_info['city_code'];
        } else if ($type == 3) {//主题线路
            $higo_info = TravelHigo::find()
                ->where(['id' => $order_info['travel_id']])
                ->select(['end_city'])
                ->asArray()
                ->one();
            $city_code = $higo_info['end_city'];
        }
        if (empty($city_code)) {
            return '-';
        } else {
            $area_info = Yii::$app->db->createCommand("SELECT `name` FROM `dt_city_seas` WHERE `code`='$city_code'")->queryScalar();
            return $area_info;
        }
    }

    /***** 商品主题  *******/
    public static function actionTheme_type($oid, $type)
    {
        $order_info = TravelOrder::find()
            ->where(['id' => $oid])
            ->select(['travel_id'])
            ->asArray()
            ->one();
        if ($type == 2) {//当地活动
            $active_info = TravelActivity::find()
                ->where(['id' => $order_info['travel_id']])
                ->select(['tag'])
                ->asArray()
                ->one();
            $tag = $active_info['tag'];
        } else if ($type == 3) {//主题higo
            $higo_info = TravelHigo::find()
                ->where(['id' => $order_info['travel_id']])
                ->select(['tag'])
                ->asArray()
                ->one();
            $tag = $higo_info['tag'];
        }
        if (empty($tag)) {
            return '-';
        } else {
            $tag_info = Yii::$app->db->createCommand("SELECT `title` FROM `travel_tag` WHERE `id` IN ({$tag})")->queryColumn();
            $tag_str = implode(' ', $tag_info);
            return $tag_str;
        }
    }

    /***** 用户名/手机号 ******/
    public static function actionUser_info($uid)
    {
        //手机号
        $user_info = User::find()
            ->where(['id' => $uid])
            ->select(['mobile'])
            ->asArray()
            ->one();
        //用户名
        $user_data = UserCommon::find()
            ->where(['uid' => $uid])
            ->select(['nickname'])
            ->asArray()
            ->one();
        return $user_data['nickname'] . '/' . $user_info['mobile'];
    }

    /******* 城市搜索条件 *********/
    public static function actionCity_code()
    {
        $order_info = TravelOrder::find()
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
        $code_id_info = array_unique($new_arr);
        $code_str = implode(',', $code_id_info);
        $sql = "SELECT `name`,`code` FROM `dt_city_seas` WHERE `code` IN ({$code_str})";
        $code_name_info = Yii::$app->db->createCommand($sql)->queryAll();
        $return_arr = array();
        foreach ($code_name_info as $keys => $values) {
            $return_arr[$values['code']] = $values['name'];
        }
        return $return_arr;
    }

    public function actionAudit()
    {
        if (Yii::$app->request->isAjax) {
            $note = Yii::$app->request->get('audit_note');
            $content = Yii::$app->request->get('content');
            if (empty($content)) {
                $content = '';
            }
            $id = Yii::$app->request->get('id');
            $order_info = Yii::$app->db->createCommand("SELECT * FROM `travel_order` WHERE `id`='$id'")->queryOne();
            if ($note == 'y') {//审核通过
                $sql = "UPDATE `travel_order` SET `is_audit`=1, `audit_des`='$content' WHERE `id`='$id'";
                Yii::$app->db->createCommand($sql)->execute();
                //添加操作日志
                $admin_id = Yii::$app->user->getId();//登录人ID
                $order_uid = $order_info['order_uid'];//用户ID
                $remark = "后台管理员ID为{$admin_id}对用户ID为{$order_uid}进行了旅游退款审核操作（通过）。";
                $controller = $this->id;
                $action = $this->action->id;
                CommonService::log($order_uid, $admin_id, 'travel_order', $id, $remark, $controller . '/' . $action);
            } else {//审核未通过
                Yii::$app->db->createCommand("UPDATE `travel_order` SET `refund_stauts`=54, `is_audit`=1, `audit_des`='$content' WHERE `id`='$id'")->execute();
                //添加订单操作日志
                $log = OrderLogService::insertOrderLog($id,$order_info['refund_stauts'],54);
                //添加操作日志
                $admin_id = Yii::$app->user->getId();//登录人ID
                $order_uid = $order_info['order_uid'];//用户ID
                $remark = "后台管理员ID为{$admin_id}对用户ID为{$order_uid}进行了旅游退款审核操作（未通过）。";
                $controller = $this->id;
                $action = $this->action->id;
                CommonService::log($order_uid, $admin_id, 'travel_order', $id, $remark, $controller . '/' . $action);
            }
            echo 123;
        }
    }

    /*****  结算单详情(ajax)  *****/
    public function actionSettlement_info()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data');
            $order_info = TravelOrder::find()
                ->where(['id' => $id])
                ->select(['order_no', 'pay_platform', 'order_uid', 'pay_amount'])
                ->asArray()
                ->one();
            switch ($order_info['pay_platform']) {
                case 1:
                    $order_info['pay_platform'] = '支付宝';
                    break;
                case 2:
                    $order_info['pay_platform'] = '微信';
                    break;
                default:
                    $order_info['pay_platform'] = '';
                    break;
            }
            $user_info = UserCommon::find()
                ->where(['uid' => $order_info['order_uid']])
                ->select(['nickname'])
                ->asArray()
                ->one();
            $user_data = User::find()
                ->where(['id' => $order_info['order_uid']])
                ->select(['mobile'])
                ->asArray()
                ->one();
            $order_info['nickname'] = $user_info['nickname'];//用户名
            $order_info['mobile'] = $user_data['mobile'];//用户账号(手机号)
            return json_encode($order_info);
        }
    }
}
