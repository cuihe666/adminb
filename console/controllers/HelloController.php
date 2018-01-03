<?php
namespace console\controllers;

use backend\controllers\FinanceTravelController;
use backend\controllers\HandleHotelSettleController;
use backend\models\Hotel;
use backend\models\SearchSql;
use backend\service\CommonService;
use Yii;
use yii\base\Exception;

date_default_timezone_set('PRC');

class HelloController extends \yii\console\Controller
{
    public function actionTst()
    {
        while (true) {
            $str = date("Y-m-d H:i:s", time()) . '--' . "已成功接收\r\n";
            file_put_contents("./test.txt", $str, FILE_APPEND);
            sleep(5);
        }
    }

    public function actionTest()
    {
        $agent = Yii::$app->db->createCommand("select * from tg_agent")->queryAll();
//        $time = 1479939200;
        $time = strtotime('2017-11-01 00:00:00');//开始时间
        $etime = strtotime('2017-11-30 23:59:59');//结束时间
        foreach ($agent as $k => $v) {
            if ($v['type'] == 1) {//1=>城市
                //获取市级代理商下所有区级信息
                $area_code = Yii::$app->db->createCommand("select code from dt_city_seas WHERE parent={$v['code']}")->queryColumn();
                //获取所有区级代理商
                $agent_area_code = Yii::$app->db->createCommand("select code from tg_agent WHERE type=2")->queryColumn();
                $area_arr = array_intersect($area_code, $agent_area_code);//比较键值，返回交集
                if (empty($area_arr)) {
                    //不存在下级代理商，获取所有相关订单信息：
                    //该城市下、已结算、未退款、已支付、创建时间在范围内的、未结算至供应商的订单
                    $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND unix_timestamp(o.create_time)<$etime AND o.house_city_id={$v['code']} AND s.is_agent_settle=0")->queryAll();
                } else {
                    //存在下级代理商，获取所有相关订单信息：
                    //该城市下、已结算、未退款、已支付、创建时间在范围内的、未结算至供应商、在该城市下区级代理商范围内的订单
                    $area_str = implode(',', $area_arr);
                    $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND unix_timestamp(o.create_time)<$etime AND o.house_city_id={$v['code']} AND s.is_agent_settle=0 AND o.house_county_id NOT IN ($area_str)")->queryAll();
                }
            }
            if ($v['type'] == 2) {//2=>区
                $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND unix_timestamp(o.create_time)<$etime AND o.house_county_id={$v['code']} AND s.is_agent_settle=0")->queryAll();
            }
            if ($v['type'] == 3) {//3=>省
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
                    $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND unix_timestamp(o.create_time)<$etime  AND o.house_province_id={$v['code']} AND s.is_agent_settle=0")->queryAll();
                }
                if (empty($city) && $area) {
                    $area_str = implode(',', $area);
                    $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND unix_timestamp(o.create_time)<$etime  AND o.house_province_id={$v['code']} AND s.is_agent_settle=0 AND o.house_county_id NOT IN ($area_str)")->queryAll();
                }
                if (empty($area) && $city) {
                    $city_str = implode(',', $city);
                    $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND unix_timestamp(o.create_time)<$etime  AND o.house_province_id={$v['code']} AND s.is_agent_settle=0 AND o.house_city_id NOT IN ($city_str)")->queryAll();
                }
                if ($city && $area) {
                    $area_str = implode(',', $area);
                    $city_str = implode(',', $city);
                    $agent[$k]['data'] = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_stauts=34 AND s.refund_stauts=0 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time AND unix_timestamp(o.create_time)<$etime  AND o.house_province_id={$v['code']} AND s.is_agent_settle=0 AND o.house_city_id NOT IN ($city_str) AND o.house_county_id NOT IN ($area_str)")->queryAll();
                }
            }
        }
        //上部分是将订单信息筛选整合后，添加到供应商list结构中
        //此部分是将数据整理为批量插入的数据结构（insert_array）
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
        //事务插入数据库
        $shiwu = \Yii::$app->db->beginTransaction();
        try {
            foreach ($data_arr as $k => $v) {
                Yii::$app->db->createCommand("insert into agent_settlement(settle_id,agent_id,create_time,total,order_total,coupon_total,landlady_total,tangguo_total) VALUES ('{$v['settle_id']}',{$v['agent_id']},{$v['create_time']},'{$v['agent_total']}','{$v['order_total']}','{$v['coupon_total']}','{$v['total']}','{$v['tangguo_total']}')")->execute();
                $insert_id = Yii::$app->db->getLastInsertID();
                foreach ($v['order_data'] as $kk => $vv) {
                    Yii::$app->db->createCommand("insert into agent_settle_detail(settle_id,order_id,order_num,house_id,create_time) VALUES ($insert_id,{$vv['order_id']},'{$vv['order_num']}',{$vv['house_id']},UNIX_TIMESTAMP())")->execute();
                    var_dump(Yii::$app->db->createCommand("update order_state set is_agent_settle=1 WHERE order_id={$vv['order_id']}")->execute());
                }
            }
            $shiwu->commit();
            echo 888;
        } catch (Exception $e) {
            echo $e->getMessage();
            $shiwu->rollBack();
            return null;
        }
    }

    //房东结算
    public function actionCreatesettle()
    {
        $time = 1470976000;
        $data = Yii::$app->db->createCommand("select s.order_id,s.house_id,s.order_uid,s.house_uid,s.order_stauts,s.pay_stauts,s.refund_stauts,s.pay_amount,s.coupon_amount,s.pay_platform,o.total,o.in_time,o.out_time,o.create_time,o.order_num,s.agent_income,s.tangguo_income,s.landlady_income from order_state as s JOIN order_detail_static as o ON s.order_id=o.id WHERE s.order_type=0 AND s.order_stauts=32 AND pay_stauts=2 AND unix_timestamp(o.create_time)>$time")->queryAll();
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
                        'house_id' => $vv['house_id'],
                        'landlady_income' => $vv['landlady_income'],
                        'order_uid'=>$vv['order_uid'],
                        'pay_amount'=>$vv['pay_amount']
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
            $str = '';
            try {
                $time = date("Y-m-d H:i:s", time());
                foreach ($data_arr as $k => $v) {
                    Yii::$app->db->createCommand("insert into house_settlement(settle_id,uid,create_time,total,order_total,coupon_total,agent_total,tangguo_total) VALUES ('{$v['settle_id']}',{$v['uid']},{$v['create_time']},'{$v['total']}','{$v['order_total']}','{$v['coupon_total']}','{$v['agent_total']}','{$v['tangguo_total']}')")->execute();
                    $insert_id = Yii::$app->db->getLastInsertID();
                    foreach ($v['order_data'] as $kk => $vv) {
                        $point_data=[
                            'uid'=>$vv['order_uid'],
                            'type'=>2,
                            'order_type'=>1,
                            'order_id'=>$vv['order_id'],
                            'point'=>round($vv['pay_amount']/10),
                            'create_time'=>time()
                        ];
                        Yii::$app->db->createCommand()->insert('shop_point_log',$point_data)->execute();
                        $old_point=Yii::$app->db->createCommand("select point_total from user WHERE id={$vv['order_uid']}")->queryScalar();
                        $new_point=round($vv['pay_amount']/10)+$old_point;
                        Yii::$app->db->createCommand()->update('user',['point_total'=>$new_point],['id'=>$vv['order_uid']])->execute();
                        Yii::$app->db->createCommand("insert into house_settle_detail(settle_id,order_id,order_num,house_id,create_time) VALUES ($insert_id,{$vv['order_id']},'{$vv['order_num']}',{$vv['house_id']},UNIX_TIMESTAMP())")->execute();
                        Yii::$app->db->createCommand("update order_state set order_stauts=34,update_time=date_format(now(),'%Y-%m-%d %H:%i:%s') WHERE order_id={$vv['order_id']}")->execute();
                        $str .= "{$time}订单ID为{$vv['order_id']}的订单已被结算,金额{$vv['landlady_income']}\r\n";
                    }
                }
                $shiwu->commit();
                echo $str;
            } catch (Exception $e) {
                $str = $e->getMessage();
                $shiwu->rollBack();
                echo $str;
            }
        }
    }

    /**
     * @添加结算表
     * travel_settlement/travel_settle_detail
     */
    public function actionAddsettlement()
    {
        $local_activity_data = FinanceTravelController::actionCreate_arr(2);//当地活动
        FinanceTravelController::actionAdd_table_sql($local_activity_data);
        $travel_higo_data = FinanceTravelController::actionCreate_arr(3);//主题线路
        FinanceTravelController::actionAdd_table_sql($travel_higo_data);
        $travel_guide_data = FinanceTravelController::actionCreate_arr(5);//当地向导
        FinanceTravelController::actionAdd_table_sql($travel_guide_data);
        return 'success';

    }

    public function actionDel()
    {
        $data = Yii::$app->db->createCommand("select id,house_id,inside_id,count(*) as count from house_facilities_inside group by house_id,inside_id having count>1")->queryAll();
        foreach ($data as $k => $v) {
            var_dump(Yii::$app->db->createCommand("delete from house_facilities_inside WHERE house_id={$v['house_id']} AND inside_id={$v['inside_id']} AND id !={$v['id']}")->execute());
        }
    }

    /**
     * @酒店-月结算
     */
    public function actionMonthsettle()
    {
        $status = HandleHotelSettleController::MonthSettle();
        echo $status;
    }

    /**
     * @酒店-周结算
     */
    public function actionWeeksettle()
    {
        $status = HandleHotelSettleController::WeekSettle();
        echo $status;
    }

    /**
     * @酒店-单结算
     */
    public function actionOrdersettle()
    {
        $status = HandleHotelSettleController::OrderSettle();
        echo $status;
    }
    /**
     * @酒店-特殊结算
     */
    public function actionSpecialsettle()
    {
        $status = HandleHotelSettleController::SpecialSettle();
        echo $status;
    }
    /**
     * @酒店-脚本：处理酒店政策页面，宠物入住信息和小孩入住信息造成的bug
     */
    public function actionResetbuginfo()
    {
        $hotel_info = Hotel::find()
            ->where(['OR',
                ['pet_in' => 0], 
                ['pet_in' => 1]
            ])
            ->select([
                'id',
                'child_in',
                'pet_in',
            ])
            ->asArray()
            ->all();
        $msg = 'success';
        $transaction = Yii::$app->db->beginTransaction();
        try{
            foreach ($hotel_info as $k => $val) {
                $update_info = [
                    'child_in' => ($val['child_in'] == 1 ? 0 : 1),
                    'pet_in'   => ($val['pet_in'] == 1 ? 0 : 1)
                ];
                $update_status = SearchSql::_UpdateSqlExecute('hotel', $update_info, ['id' => $val['id']]);
                if (!$update_status) {
                    throw new \Exception('update_hotel_info_abnormal');
                }
            }
            $transaction->commit();
        } catch (\Exception $exception) {
            $transaction->rollBack();
            $errMsg = $exception->getMessage();
            $msg = $errMsg;
        }
        echo $msg;
    }
}