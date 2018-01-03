<?php

namespace backend\controllers;

use backend\models\AccountBankcard;
use backend\models\TravelOrder;
use backend\models\TravelSettlement;
use backend\models\TravelSettlementQuery;
use backend\models\User;
use backend\models\UserBackend;
use backend\models\UserCommon;
use backend\service\CommonService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FinanceTravelController implements the CRUD actions for TravelSettlement model.
 */
class FinanceTravelController extends Controller
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
     * Lists all TravelSettlement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelSettlementQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $admin_uid = Yii::$app->user->getId();
        $uid_arr = [8, 11];
        if (in_array($admin_uid, $uid_arr)) {
            $admin_note = 'y';
//            $dataProvider['admin_note'] = 'y';
        } else {
            $admin_note = 'n';
//            $dataProvider['admin_note'] = 'n';
        }
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'admin_note'   => $admin_note,
        ]);
    }

    /**
     * Displays a single TravelSettlement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = TravelSettlement::find()->WHERE(['id' => $id])->One();

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new TravelSettlement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TravelSettlement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TravelSettlement model.
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
     * Deletes an existing TravelSettlement model.
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
     * @添加结算表
     * travel_settlement/travel_settle_detail
     */
//    public function actionAdd_settlement()
//    {
//        $local_sql_data = self::actionCreate_arr(2);//当地活动
//        self::actionAdd_table_sql($local_sql_data);
//        $travel_sql_data = self::actionCreate_arr(3);//主题线路
//        self::actionAdd_table_sql($travel_sql_data);
//        return 'success';
//
//    }
    /******* 数据处理（2.当地活动 3.主题嗨go） *********/
    public static function actionCreate_arr($active_type)
    {
        //$now = time();
        $now = strtotime(date("Y-m-d"));
        $time = $now - (1 * 24 * 60 * 60);//一天时差
        //当地活动---未结算(2.当地活动 3.主题嗨go)
        $order_info = TravelOrder::find()
                ->where(['close_account' => 0])//未结算
                ->andWhere(['type' => $active_type])//当地活动 or 主题线路
                ->andWhere(['in','refund_stauts', [0,54]])//不在退款流程或者退款失败
                ->andWhere(['!=','trade_no',''])     //@2017-8-24 11:44:26 fuyanfei to add trade_no!='' 交易编号不为空（即已支付）
                ->asArray()
                ->all();
        //判定数据是否为空
        if (empty($order_info)) {
            $sql_data = NULL;
            return $sql_data;
        }
        //判定结算时间规则（活动开始时间+1）
        if ($active_type == 2) {//当地活动
            foreach ($order_info as $key => $value) {
                if (strtotime($value['activity_date']) > $time) {
                    unset($order_info[$key]);
                }
//                if (empty($value['trade_no'])) {//未支付
//                    unset($order_info[$key]);
//                }
            }
        } else if ($active_type == 3){//主题线路
            foreach ($order_info as $key => $value) {
                if ($value['payment_time'] > ($time * 1000)) {//时间不足1天
                    unset($order_info[$key]);
                }
//                if (empty($value['trade_no'])) {//未支付
//                    unset($order_info[$key]);
//                }
            }
        }

//        $order_info = TravelOrder::find()
//            ->Where(['between', 'payment_time', 1497801600000, 1497888000000])
//            ->asArray()
//            ->all();
//        $now = time();

        $uid_arr = array();
        foreach ($order_info as $k => $val) {
            $uid_arr[] = $val['travel_uid'];
        }
        $uid_info = array_unique($uid_arr);
        sort($uid_info);
        $sql_data = array();
        for ($i = 0; $i < count($uid_info); $i++) {
            $total_money = 0;
            $order_total = 0;
            $total_coupon = 0;
            $tangguo_total = 0;
            $tangguo_rate = 0;
            foreach ($order_info as $keys => $values) {
                if ($uid_info[$i] == $values['travel_uid']){
                    $sql_data[$i]['travel_settle_detail'][] = array(//表`travel_settle_detail`
                        'order_id'    => $values['id'],//订单ID
                        'order_num'   => $values['order_no'],//订单号
                        'travel_id'   => $values['travel_id'],//关联旅游ID
                        'create_time' => $now,//创建时间
                        'type'         => $active_type,//活动类型
                        'order_uid'   => $values['order_uid'],       //@2017-8-21 13:52:48 fuyanfei add count user points
                        'total'        => $values['total'],           //@2017-8-21 13:52:48 fuyanfei add count user points
                    );
                    $total_money += $values['pay_amount'];//实付总金额
                    $order_total += $values['total'];//订单总额
                    $total_coupon += $values['coupon_amount'];//优惠券总额
                    $tangguo_total += $values['tangguo_income'];//棠果收入
                    $tangguo_rate += $values['tangguo_rate'];//棠果佣金
                }
            }
            $sql_data[$i]['uid']         = $uid_info[$i];//账户uid
            $sql_data[$i]['settle_id']   = CommonService::create_settlement($uid_info[$i]);//结算ID
            $sql_data[$i]['create_time'] = $now;//申请结算时间
            $sql_data[$i]['total']       = $total_money;//实付总金额
            $sql_data[$i]['order_total'] = $order_total;//订单金额
            $sql_data[$i]['coupon_total'] = $total_coupon;//优惠券金额
            $sql_data[$i]['tangguo_total'] = $tangguo_total;//棠果收入
            $sql_data[$i]['settle_price'] = $order_total - $tangguo_rate;//结算总额
        }
        return $sql_data;
    }
    /********* 结算插入执行 **********/
    public static function actionAdd_table_sql($sql_data)
    {
        if (empty($sql_data)) {
            return false;
        }
        //@2017-8-21 13:55:05 fuyanfei add beginTranscation and try catch
        $trans = Yii::$app->db->beginTransaction();
        try{
            foreach ($sql_data as $k => $val) {
                $settle_id = $val['settle_id'];
                $total_sql = "INSERT INTO `travel_settlement` (`settle_id`, `uid`, `create_time`, `total`, `order_total`, `coupon_total`, `tangguo_total`, `settle_price`) VALUES ({$val['settle_id']}, {$val['uid']}, {$val['create_time']}, {$val['total']}, {$val['order_total']}, {$val['coupon_total']}, {$val['tangguo_total']}, {$val['settle_price']})";
                Yii::$app->db->createCommand($total_sql)->execute();
                $settlement_data = Yii::$app->db->createCommand("SELECT * FROM `travel_settlement` WHERE `settle_id`='$settle_id'")->queryOne();
                $id = $settlement_data['id'];
                foreach ($val['travel_settle_detail'] as $key => $value) {
                    $order_num = $value['order_num'];
                    //插入`travel_settle_detail`表
                    $list_sql = "INSERT INTO `travel_settle_detail` (`settle_id`, `order_id`, `order_num`, `travel_id`, `create_time`, `type`) VALUES ('$id', {$value['order_id']}, '$order_num', {$value['travel_id']}, {$value['create_time']}, {$value['type']})";
                    Yii::$app->db->createCommand($list_sql)->execute();
                    //修改结算状态
                    $order_id = $value['order_id'];
                    $order_sql = "UPDATE `travel_order` SET `close_account`=1 WHERE `id`='$order_id'";
                    Yii::$app->db->createCommand($order_sql)->execute();

                    /*
                    //计算积分------@2017-8-21 14:11:42 fuyanfei to add update user`s points and add user`s point logs
                    $point = round($value['total']/10);
                    //修改用户的积分
                    Yii::$app->db->createCommand("UPDATE user SET point_total=point_total+:point WHERE id = :id")
                        ->bindValue(":point",$point)
                        ->bindValue(":id",$value['order_uid'])
                        ->execute();
                    //记录积分日志
                    Yii::$app->db->createCommand("INSERT INTO shop_point_log (uid,type,order_type,order_id,point,create_time) VALUES (:uid,:type,:order_type,:order_id,:point,:create_time)")
                        ->bindValue(":uid",$value["order_uid"])
                        ->bindValue(":type",2)
                        ->bindValue(":order_type",$value["type"])
                        ->bindValue(":order_id",$value["order_id"])
                        ->bindValue(":point",$point)
                        ->bindValue(":create_time",time())
                        ->execute();
                    */
                }
            }

            $trans->commit();
            return 333;
        }
        catch(\Exception $e){
            $trans->rollBack();
            return -1;
        }
    }
    /**
     * Finds the TravelSettlement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TravelSettlement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TravelSettlement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /******* 获取联系昵称 **********/
    public static function actionUser_name($uid)
    {
        $user_info = UserCommon::find()
            ->where(['uid' => $uid])
            ->select(['nickname'])
            ->asArray()
            ->one();
        if (empty($user_info)) {
            return '-';
        } else {
            return $user_info['nickname'];
        }
    }
    /****** 获取联系电话 ********/
    public static function actionUser_mobile($uid)
    {
        $user_data = User::find()
            ->where(['id' => $uid])
            ->select(['mobile'])
            ->asArray()
            ->One();
        if (empty($user_data)) {
            return '-';
        } else {
            return $user_data['mobile'];
        }
    }
    /****** 获取银行信息 ******/
    public static function actionBank_data($uid)
    {
        $bank_data = Yii::$app->db->createCommand("SELECT * FROM `account_bankcard` WHERE `uid`='$uid'")->queryOne();
        if (empty($bank_data['account_number'])) {//账户不存在
            return '-';
        } else {
            if ($bank_data['type'] == '3') {//是银行卡
                return $bank_data['name']. '<br/>' .$bank_data['account_number']. '<br/>' .$bank_data['bank_branch'];
            }
            return '-';
        }
    }
    /****** 获取支付宝信息 *******/
    public static function actionAlipay_data($uid)
    {
        $bank_data = AccountBankcard::find()
            ->where(['uid' => $uid])
            ->andWhere(['type' => 2])//支付宝
            ->select(['type', 'account_number'])
            ->asArray()
            ->one();
        if (!empty($bank_data)) {
            return $bank_data['account_number'];
        } else {//账户不存在(不是支付宝账号)
            return '-';
        }
    }
    /****** 获取佣金总额 *******/
    public static function actionBrokerage_total($id)
    {
        $travel_data = Yii::$app->db->createCommand("SELECT * FROM `travel_settle_detail` WHERE `settle_id`='$id'")->queryAll();
        $brokerage_total = 0;
        foreach ($travel_data as $k => $val) {
            $tid = $val['order_id'];
            $order_info = Yii::$app->db->createCommand("SELECT *FROM `travel_order` WHERE `id`='$tid'")->queryOne();
            $brokerage_total = $brokerage_total + $order_info['tangguo_income'];
        }
        return $brokerage_total;
    }
    /****** 打款账号 *********/
    public static function actionAccount($uid, $str)
    {
        $bank_data = Yii::$app->db->createCommand("SELECT * FROM `account_bankcard` WHERE `uid`='$uid'")->queryOne();
        if ($str == 'account') {//打款账号
            return $bank_data['account_number'];
        } else if ($str == 'account_type') {//打款方式
            return Yii::$app->params['play_type'][$bank_data['type']];
        }

    }
    /*******  支付宝打款  ***********/
    public function actionOperation()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data');
            if (empty($id)) {
                $data = [
                    'code' => '1',
                    'msg' => '结算单异常'
                ];
                echo json_encode($data);
                die;
            }
            $ip = CommonService::get_client_ip();
            if ($ip != '111.198.116.99' && $ip != '111.198.116.101') {
                $data = [
                    'code' => '1',
                    'msg' => 'ip异常'
                ];
                echo json_encode($data);
                die;
            }
            $settle_info = Yii::$app->db->createCommand("SELECT * FROM `travel_settlement` WHERE `id`='$id'")->queryOne();
            if (empty($settle_info)) {
                $data = [
                    'code' => '1',
                    'msg' => '结算单异常'
                ];
                echo json_encode($data);
                die;
            }
            if ($settle_info['status'] == '1') {
                $data = [
                    'code' => '1',
                    'msg' => '结算单异常'
                ];
                echo json_encode($data);
                die;
            }
            $uid = $settle_info['uid'];
            $bank_info = AccountBankcard::find()
                ->where(['uid' => $uid])//用户
                ->andWhere(['type' => 2])//支付宝
                ->asArray()
                ->one();
            if (empty($bank_info['account_number'])) {
                $data = [
                    'code' => '1',
                    'msg' => '支付宝账户有误'
                ];
                echo json_encode($data);
                die;
            }
            $settle_num = $settle_info['settle_id'];//结算单号
            $account_number = $bank_info['account_number'];//支付宝账号
            $account_name = $bank_info['name'];//支付账户名
            $total = $settle_info['settle_price'];//结算金额
            $remark = "旅游支付宝转账";
//            $return_data = array($settle_num, $account_number, $account_name, $total);
//            $data = [
//                'code' => '1',
//                'msg' => $return_data
//            ];
//            echo json_encode($data);
//            die;
            $res = CommonService::alipaytransfer($settle_num, $account_number, $total, $remark, $account_name);
            //添加操作日志
            $admin_id = Yii::$app->user->getId();//登录人ID
            $settle_uid = $uid;//用户ID
            $remark = "后台管理员ID为{$admin_id}对用户ID为{$settle_uid}进行了支付宝打款操作（旅游）。";
            $controller = $this->id;
            $action = $this->action->id;
            CommonService::log($settle_uid, $admin_id, 'travel_settlement', $id, $remark, $controller.'/'.$action);
            if ($res->alipay_fund_trans_toaccount_transfer_response->code != 10000) {
                $fail_cause = $res->alipay_fund_trans_toaccount_transfer_response->sub_msg;
                Yii::$app->db->createCommand("update travel_settlement set status=2,fail_cause='{$fail_cause}' WHERE id='$id'")->execute();
                $data = [
                    'code' => '1',
                    'msg' => $fail_cause
                ];
                echo json_encode($data);
                die;
            }
            $time = strtotime($res->alipay_fund_trans_toaccount_transfer_response->pay_date);
            $serial_number = $res->alipay_fund_trans_toaccount_transfer_response->order_id;
            Yii::$app->db->createCommand("update travel_settlement set status=1,pay_time={$time},serial_number='{$serial_number}' WHERE id='$id'")->execute();
            $data = [
                'code' => '0',
                'msg' => '转账成功'
            ];
            echo json_encode($data);
        }
    }
    /*******  打款详情  *********/
    public function actionPay_detail()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data');//结算单ID
            $operation_sql = "SELECT `admin_id` FROM `admin_log` WHERE `table_name`='travel_settlement' AND `record_id`={$id} ORDER BY `id` DESC ";
            $operation_name = Yii::$app->db->createCommand($operation_sql)->queryAll();
            if (empty($operation_name)) {
                $user_name['username'] = '***';
            } else {
                $uid = $operation_name[0]['admin_id'];
                $user_name = UserBackend::find()
                    ->where(['id' => $uid])
                    ->select(['username'])
                    ->asArray()
                    ->one();
            }
            $order_info = TravelSettlement::find()
                ->where(['id' => $id])
                ->select(['total', 'serial_number', 'pay_time'])
                ->asArray()
                ->one();
            if ($order_info['serial_number'] == '***') {
                $pay_type = '线下打款';
            } else {
                $pay_type = '支付宝';
            }
            $return_arr = array(
                'name'     => $user_name['username'],//后台操作人
                'total'    => $order_info['total'],//结算金额
                'order_no' => $order_info['serial_number'],//流水号
                'pay_time' => date('Y-m-d H:i:s', $order_info['pay_time']),//打款时间
                'pay_type' => $pay_type
            );
            echo json_encode($return_arr);
        }
    }
    /********** 改变订单状态（不打款） *************/
    public function actionChangeStatus()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('data');
            if (empty($id)) {
                $data = [
                    'code' => '1',
                    'msg' => '结算单异常'
                ];
                echo json_encode($data);
                die;
            }
//            $ip = CommonService::get_client_ip();
//            if ($ip != '111.198.116.99' && $ip != '111.198.116.101') {
//                $data = [
//                    'code' => '1',
//                    'msg' => 'ip异常'
//                ];
//                echo json_encode($data);
//                die;
//            }
            $settle_info = Yii::$app->db->createCommand("SELECT * FROM `travel_settlement` WHERE `id`='$id'")->queryOne();
            if (empty($settle_info)) {
                $data = [
                    'code' => '1',
                    'msg' => '结算单异常'
                ];
                echo json_encode($data);
                die;
            }
            if ($settle_info['status'] == '1') {
                $data = [
                    'code' => '1',
                    'msg' => '结算单异常'
                ];
                echo json_encode($data);
                die;
            }
            $uid = $settle_info['uid'];
            //添加操作日志
            $admin_id = Yii::$app->user->getId();//登录人ID
            $settle_uid = $uid;//用户ID
            $remark = "后台管理员ID为{$admin_id}对用户ID为{$settle_uid}进行了支付宝打款操作（旅游）。";
            $controller = $this->id;
            $action = $this->action->id;
            CommonService::log($settle_uid, $admin_id, 'travel_settlement', $id, $remark, $controller.'/'.$action);
            $time = time();
            $serial_number = '***';
            Yii::$app->db->createCommand("update travel_settlement set status=1,pay_time={$time},serial_number='{$serial_number}' WHERE id='$id'")->execute();
            $data = [
                'code' => '0',
                'msg' => '转账成功'
            ];
            echo json_encode($data);
        }
    }

}
