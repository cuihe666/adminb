<?php

namespace backend\controllers;

use backend\config\Consts;
use backend\models\HouseDetails;
use backend\models\OrderDetailStatic;
use backend\models\OrderDetailStaticQuery;
use backend\models\Submit;
use backend\service\CommonService;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrderDetailStaticController implements the CRUD actions for OrderDetailStatic model.
 */
class OrderDetailStaticController extends Controller
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
     * Lists all OrderDetailStatic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderDetailStaticQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //房源类型map格式
        $houseType = ArrayHelper::map(HouseDetails::getHousetype(), 'id', 'code_name');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'houseType' => $houseType,
        ]);
    }

    /**
     * Displays a single OrderDetailStatic model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $order_data = Yii::$app->db->createCommand("select o.order_type,o.book_house_count,o.book_house_count,o.is_over_fee,o.over_man_fee,o.clean_fee,o.seas_total,o.order_num,o.house_price,s.order_stauts,s.refund_stauts,o.day_num,o.total,o.order_uid,o.house_uid,o.house_id,o.create_time,o.in_time,o.out_time,s.transaction_id,s.pay_platform,s.pay_amount,s.coupon_amount,s.agent_income,s.landlady_income,s.tangguo_income,s.refuse_content,o.national from order_detail_static as o JOIN order_state as s ON o.id=s.order_id WHERE o.id=$id")->queryOne();
        $house_data = Yii::$app->db->createCommand("select h.title,h.id,h.address,u.mobile from house_details as h JOIN user as u ON h.uid=u.id WHERE h.id={$order_data['house_id']}")->queryOne();
        $ruzhu_data = Yii::$app->db->createCommand("select * from order_guests WHERE order_id=$id")->queryAll();
        $xiadan_data = Yii::$app->db->createCommand("select u.mobile,u.id,c.nickname,c.gender from `user` as u JOIN user_common as c ON u.id=c.uid WHERE c.uid={$order_data['order_uid']}")->queryOne();
        $log = Yii::$app->db->createCommand("SELECT admin , remark ,create_time from `house_order_log` WHERE house_id = $id")->queryOne();
        if ($order_data['pay_platform'] == '') {
            $order_data['pay_platform'] = 0;
        }
        if ($order_data['national'] != 10001) {
            $clean = $order_data['clean_fee'] ? $order_data['clean_fee'] : 0;
            if ($order_data['is_over_fee'] == 3) {
//               $order_num=Yii::$app->db->createCommand("select count(*) from order_guests WHERE order_id=$id")->queryScalar();
//               $max_num=Yii::$app->db->createCommand("select maxguest from house_search where house_id={$house_data['id']}")->queryScalar();
                $order_total = $clean + $order_data['over_man_fee'] + $order_data['seas_total'];
            } else {
                $order_total = $order_data['seas_total'] + $clean;
            }
        } else {
            $order_total = $order_data['total'];
        }
        $date_prices = Yii::$app->db->createCommand("select *  from `order_date_price` WHERE order_id  = {$id}")->queryAll();
        return $this->render('view', ['order_total' => $order_total, 'order_data' => $order_data, 'house_data' => $house_data, 'ruzhu_data' => $ruzhu_data, 'xiadan_data' => $xiadan_data, 'date_prices' => $date_prices, 'log' => $log]);
    }


    /**
     * Creates a new OrderDetailStatic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderDetailStatic();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OrderDetailStatic model.
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
     * Deletes an existing OrderDetailStatic model.
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
     * Finds the OrderDetailStatic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderDetailStatic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderDetailStatic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //待处理订单列表
    public function actionPending()
    {
        $searchModel = new OrderDetailStaticQuery();
        $searchModel->type = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('pending', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //财务待处理订单列表
    public function actionFinance()
    {
        $searchModel = new OrderDetailStaticQuery();
        $searchModel->type = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('finance', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //取消订单
    public function actionCancel()
    {
        $order_id = Yii::$app->request->get('order_id');
        if ($order_id) {
            $time = date("Y-m-d H:i:s", time());
            $order_data = Yii::$app->db->createCommand("select order_uid,in_time,out_time,house_title from order_detail_static WHERE id=$order_id")->queryOne();
            $order_user_data = Yii::$app->db->createCommand("select mobile,national_number from user WHERE id={$order_data['order_uid']}")->queryOne();
            $start_time = strtotime($order_data['in_time']);
            $end_time = strtotime($order_data['out_time']);
            $day = ($end_time - $start_time) / 86400;
            $content = sprintf(Consts::ORDER_CANCEL, $order_data['house_title'], date('Y-m-d', $start_time), date('Y-m-d', $end_time), $day);
            CommonService::sendSms($order_user_data['mobile'], $content, $order_user_data['national_number']);
            Yii::$app->db->createCommand("update order_state set order_stauts=3 WHERE order_id=$order_id")->execute();
            Yii::$app->db->createCommand("update order_detail_static set update_time='{$time}' WHERE id=$order_id")->execute();
            $coupon_id = Yii::$app->db->createCommand("select coupon_id from order_coupon WHERE order_id=$order_id")->queryScalar();
            if ($coupon_id) {
                Yii::$app->db->createCommand("delete from coupon1_use WHERE coupon_id=$coupon_id")->execute();
                Yii::$app->db->createCommand("update coupon1 set status=2 WHERE id=$coupon_id")->execute();
            }
            $url = JavaUrl . "/api/order/cancel";
            echo $url;
            $data = array(
                'orderId' => $order_id,
            );
            $obj = new Submit();
            $kucun = $obj->sub_post($url, json_encode($data));
            $admin = Yii::$app->user->identity->username;
            $remark = "后台管理员对订单id为{$order_id}的进行了取消操作";
            $controller = $this->id;
            $action = $this->action->id;
            $time = time();
            $node = $controller . '/' . $action;
            Yii::$app->db->createCommand("insert into  house_order_log(admin,table_name,house_id,remark,create_time,node) VALUES ('{$admin}','order_state',$order_id,'{$remark}',$time,'{$node}')")->execute();
            Yii::$app->session->setFlash('success', '订单取消成功');
            return $this->redirect(['pending']);
        }
    }

    //确认订单
    public function actionConfirm()
    {
        $order_id = Yii::$app->request->get('order_id');
        if ($order_id) {
            $time = date("Y-m-d H:i:s", time());
            $order_data = Yii::$app->db->createCommand("select order_uid,in_time,out_time,house_title from order_detail_static WHERE id=$order_id")->queryOne();
            $order_user_data = Yii::$app->db->createCommand("select mobile,national_number from user WHERE id={$order_data['order_uid']}")->queryOne();
            $start_time = strtotime($order_data['in_time']);
            $end_time = strtotime($order_data['out_time']);
            $day = ($end_time - $start_time) / 86400;
            $content = sprintf(Consts::ORDER_CONFIRM, $order_data['house_title'], date('Y-m-d', $start_time), date('Y-m-d', $end_time), $day);
            CommonService::sendSms($order_user_data['mobile'], $content, $order_user_data['national_number']);
            Yii::$app->db->createCommand("update order_state set order_stauts=11 WHERE order_id=$order_id")->execute();
            Yii::$app->db->createCommand("update order_detail_static set update_time='{$time}' WHERE id=$order_id")->execute();
            Yii::$app->session->setFlash('success', '订单确认成功');
            return $this->redirect(['pending']);
        }
    }

    public function actionRefund()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('order_id');
            if (empty($id)) {
                echo 0;
                die;
            }
            $static_model = OrderDetailStatic::findOne($id);
            $state_data = Yii::$app->db->createCommand("select * from order_state WHERE order_id=$id")->queryOne();
            if (!$static_model or !$state_data) {
                echo 0;
                die;
            }
            if ($state_data['pay_stauts'] != 2 or $state_data['refund_stauts'] != 1) {
                echo 0;
                die;
            }
            $refund_amount = Yii::$app->db->createCommand("select actual_amount from order_refunds_apply WHERE order_id=$id")->queryScalar();
            if ($refund_amount == 0) {
                echo Yii::$app->db->createCommand("update order_state set refund_stauts=5 WHERE order_id=$id")->execute();
                die;
            } else {
                echo Yii::$app->db->createCommand("update order_state set refund_stauts=3 WHERE order_id=$id")->execute();
                die;
            }
        }
    }


    //财务退款到用户账户上
    public function actionCompleteRefund()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('order_id');
            if (empty($id)) {
                $data = [
                    'code' => 0,
                    'msg' => '订单异常'
                ];
                echo json_encode($data);
                die;
            }
            $ip = CommonService::get_client_ip();
            if ($ip != '111.207.107.53' && $ip != '111.198.116.98' && $ip != '111.198.116.101') {
                $data = [
                    'code' => -1,
                    'msg' => 'ip异常'
                ];
                echo json_encode($data);
                die;
            }
            $static_model = OrderDetailStatic::findOne($id);
            $state_data = Yii::$app->db->createCommand("select * from order_state WHERE order_id=$id")->queryOne();
            if (!$static_model or !$state_data) {
                $data = [
                    'code' => 0,
                    'msg' => '订单查询失败'
                ];
                echo json_encode($data);
                die;
            }
            if ($state_data['pay_stauts'] != 2 or $state_data['refund_stauts'] != 3) {
                $data = [
                    'code' => 0,
                    'msg' => '订单状态异常'
                ];
                echo json_encode($data);
                die;
            }
            if ($state_data['pay_platform'] == 1) {
                $refund_amount = Yii::$app->db->createCommand("select actual_amount from order_refunds_apply WHERE order_id=$id")->queryScalar();
                if (empty($refund_amount)) {
                    $data = [
                        'code' => 0,
                        'msg' => '订单金额异常'
                    ];
                    echo json_encode($data);
                    die;
                }
                $return_data = CommonService::alipayreturn($state_data['transaction_id'], $refund_amount);
                if ($return_data->alipay_trade_refund_response->code != 10000) {
                    $data = [
                        'code' => -2,
                        'msg' => $return_data->alipay_trade_refund_response->sub_msg
                    ];
                    echo json_encode($data);
                    die;
                }
            } elseif ($state_data['pay_platform'] == 2) {
                $refund_amount = Yii::$app->db->createCommand("select actual_amount from order_refunds_apply WHERE order_id=$id")->queryScalar();
                if (empty($refund_amount)) {
                    $data = [
                        'code' => 0,
                        'msg' => '订单异常.'
                    ];
                    echo json_encode($data);
                    die;
                }
                $return_data = CommonService::wxreturn($state_data['transaction_id'], $state_data['pay_amount'], $refund_amount, $static_model->order_num);
                if ($return_data['result_code'] != 'SUCCESS' || $return_data['return_code'] != 'SUCCESS') {
                    $data = [
                        'code' => -2,
                        'msg' => $return_data['err_code_des']
                    ];
                    echo json_encode($data);
                    die;
                }
            }
            Yii::$app->db->createCommand("update order_state set refund_stauts=5 WHERE order_id=$id")->execute();
            $data = [
                'code' => 1,
                'msg' => '退款成功'
            ];
            echo json_encode($data);
            die;
        }
    }

    //拒绝退款
    public function actionRefundRefuse()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('order_id');
            if (empty($id)) {
                echo 0;
                die;
            }
            $static_model = OrderDetailStatic::findOne($id);
            $state_data = Yii::$app->db->createCommand("select * from order_state WHERE order_id=$id")->queryOne();
            if (!$static_model or !$state_data) {
                echo 0;
                die;
            }
            if ($state_data['pay_stauts'] != 2 or $state_data['refund_stauts'] != 1) {
                echo 0;
                die;
            }
            $bool = Yii::$app->db->createCommand("update order_state set refund_stauts=6 WHERE order_id=$id")->execute();
            echo $bool;
            die;
        }
    }


    public function actionCreateSettle()
    {
        $time = 1490976000;
        $data = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=32 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time")->queryAll();
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $arr[$v['house_uid']][] = $v;
            }
            foreach ($arr as $k => $v) {
                $order_data = [];
                $order_id = [];
                $order_num = [];
                $house_id = [];
                $pay_amount = 0;
                $order_total = 0;
                $coupon_total = 0;
                $agent_total = 0;
                $tangguo_total = 0;
                foreach ($v as $kk => $vv) {
                    $order_id[] = $vv['order_id'];
                    $pay_amount += $vv['landlady_income'];
                    $order_total += $vv['total'];
                    $coupon_total += $vv['coupon_amount'];
                    $agent_total += $vv['agent_income'];
                    $tangguo_total += $vv['tangguo_income'];
                    $order_num[] = $vv['order_num'];
                    $house_id[] = $vv['house_id'];
                    $order_data[] = array(
                        'order_id' => $vv['order_id'],
                        'order_num' => $vv['order_num'],
                        'house_id' => $vv['house_id']
                    );
                }
                $data_arr[] = [
                    'uid' => $k,
                    'total' => $pay_amount,
                    'order_total' => $order_total,
                    'coupon_total' => $coupon_total,
                    'settle_id' => CommonService::create_settlement($k),
                    'create_time' => time(),
                    'order_data' => $order_data,
                    'agent_total' => $agent_total,
                    'tangguo_total' => $tangguo_total
                ];
            }
            $shiwu = \Yii::$app->db->beginTransaction();
            try {
                foreach ($data_arr as $k => $v) {
                    Yii::$app->db->createCommand("insert into house_settlement(settle_id,uid,create_time,total,order_total,coupon_total,agent_total,tangguo_total) VALUES ('{$v['settle_id']}',{$v['uid']},{$v['create_time']},'{$v['total']}','{$v['order_total']}','{$v['coupon_total']}','{$v['agent_total']}','{$v['tangguo_total']}')")->execute();
                    $insert_id = Yii::$app->db->getLastInsertID();
                    foreach ($v['order_data'] as $kk => $vv) {
                        Yii::$app->db->createCommand("insert into house_settle_detail(settle_id,order_id,order_num,house_id,create_time) VALUES ($insert_id,{$vv['order_id']},'{$vv['order_num']}',{$vv['house_id']},UNIX_TIMESTAMP())")->execute();
                        Yii::$app->db->createCommand("update order_state set order_stauts=34,update_time=date_format(now(),'%Y-%m-%d %H:%i:%s') WHERE order_id={$vv['order_id']}")->execute();
                    }
                }
                $shiwu->commit();
                return true;
            } catch (Exception $e) {
                echo $e->getMessage();
                $shiwu->rollBack();
                return null;
            }
        }
    }

    public function actionCreateAgentSettle()
    {
        $agent = Yii::$app->db->createCommand("select * from tg_agent")->queryAll();
        $time = 1479939200;
        foreach ($agent as $k => $v) {
            if ($v['type'] == 1) {
                $area_code = Yii::$app->db->createCommand("select code from dt_city_seas WHERE parent={$v['code']}")->queryColumn();
                $agent_area_code = Yii::$app->db->createCommand("select code from tg_agent WHERE type=2")->queryColumn();
                $area_arr = array_intersect($area_code, $agent_area_code);
                if (empty($area_arr)) {
                    $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND o.house_city_id={$v['code']} AND s.is_agent_settle=0")->queryAll();
                } else {
                    $area_str = implode(',', $area_arr);
                    $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND o.house_city_id={$v['code']} AND s.is_agent_settle=0 AND o.house_county_id NOT IN ($area_str)")->queryAll();
                }
            }
            if ($v['type'] == 2) {
                $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND o.house_county_id={$v['code']} AND s.is_agent_settle=0")->queryAll();
            }
            if ($v['type'] == 3) {
                $city_code = Yii::$app->db->createCommand("select code from dt_city_seas WHERE parent={$v['code']}")->queryColumn();
                $agent_area_code = Yii::$app->db->createCommand("select code from tg_agent WHERE type=2")->queryColumn();
                $agent_city_code = Yii::$app->db->createCommand("select code from tg_agent WHERE type=1")->queryColumn();
                foreach ($city_code as $kk => $vv) {
                    $area_code[] = Yii::$app->db->createCommand("select code from dt_city_seas WHERE parent=$vv")->queryColumn();
                }
                foreach ($area_code as $kkk => $vvv) {
                    foreach ($v as $kkkk => $vvvv) {
                        $new_area_code[] = $vvvv;
                    }
                }
                $city = array_intersect($agent_city_code, $city_code);
                $area = array_intersect($agent_area_code, $new_area_code);
                if (empty($city) && empty($area)) {
                    $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND o.house_province_id={$v['code']} AND s.is_agent_settle=0")->queryAll();
                }
                if (empty($city) && $area) {
                    $area_str = implode(',', $area);
                    $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND o.house_province_id={$v['code']} AND s.is_agent_settle=0 AND o.house_county_id NOT IN ($area_str)")->queryAll();
                }
                if (empty($area) && $city) {
                    $city_str = implode(',', $city);
                    $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND o.house_province_id={$v['code']} AND s.is_agent_settle=0 AND o.house_city_id NOT IN ($city_str)")->queryAll();
                }
                if ($city && $area) {
                    $area_str = implode(',', $area);
                    $city_str = implode(',', $city);
                    $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND o.house_province_id={$v['code']} AND s.is_agent_settle=0 AND o.house_city_id NOT IN ($city_str) AND o.house_county_id NOT IN ($area_str)")->queryAll();
                }
            }
        }
        foreach ($agent as $k => $v) {
            if (!empty($v['data'])) {
                $order_data = [];
                $order_id = [];
                $order_num = [];
                $house_id = [];
                $pay_amount = 0;
                $order_total = 0;
                $coupon_total = 0;
                $agent_total = 0;
                $tangguo_total = 0;
                foreach ($v['data'] as $kk => $vv) {
                    $order_id[] = $vv['order_id'];
                    $pay_amount += $vv['landlady_income'];
                    $order_total += $vv['total'];
                    $coupon_total += $vv['coupon_amount'];
                    $agent_total += $vv['agent_income'];
                    $tangguo_total += $vv['tangguo_income'];
                    $order_num[] = $vv['order_num'];
                    $house_id[] = $vv['house_id'];
                    $order_data[] = array(
                        'order_id' => $vv['order_id'],
                        'order_num' => $vv['order_num'],
                        'house_id' => $vv['house_id']
                    );
                }
                $data_arr[] = [
                    'agent_id' => $v['id'],
                    'total' => $pay_amount,
                    'order_total' => $order_total,
                    'coupon_total' => $coupon_total,
                    'settle_id' => CommonService::create_settlement($v['id']),
                    'create_time' => time(),
                    'order_data' => $order_data,
                    'agent_total' => $agent_total,
                    'tangguo_total' => $tangguo_total
                ];
            }
        }
        $shiwu = \Yii::$app->db->beginTransaction();
        try {
            foreach ($data_arr as $k => $v) {
                Yii::$app->db->createCommand("insert into agent_settlement(settle_id,agent_id,create_time,total,order_total,coupon_total,landlady_total,tangguo_total) VALUES ('{$v['settle_id']}',{$v['agent_id']},{$v['create_time']},'{$v['agent_total']}','{$v['order_total']}','{$v['coupon_total']}','{$v['total']}','{$v['tangguo_total']}')")->execute();
                $insert_id = Yii::$app->db->getLastInsertID();
                foreach ($v['order_data'] as $kk => $vv) {
                    Yii::$app->db->createCommand("insert into agent_settle_detail(settle_id,order_id,order_num,house_id,create_time) VALUES ($insert_id,{$vv['order_id']},'{$vv['order_num']}',{$vv['house_id']},UNIX_TIMESTAMP())")->execute();
                    Yii::$app->db->createCommand("update order_state set is_agent_settle=1 WHERE order_id={$vv['order_id']}")->execute();
                }
            }
            $shiwu->commit();
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            $shiwu->rollBack();
            return null;
        }
    }
}
