<?php
namespace backend\models;

use yii\base\Model;

class HandleHotelSettle extends Model
{
    /**
     * @查询获取 周结/月结 酒店供应商信息
     */
    public static function GetSupplierInfo($type)
    {
        $supplier_info = HotelSupplier::find()
            ->where(['settle_type' => $type])
            ->select(['id'])
            ->asArray()
            ->column();
        if (empty($supplier_info)) {
            return false;
        }
        return $supplier_info;
    }
    /**
     * @获取下层酒店信息-相关订单
     */
    public static function HotelOrderInfo($type, $supplier_info)
    {
        //查询该供应商下的所有酒店
        $hotel_info = Hotel::find()
            ->where(['IN', 'supplier_id', $supplier_info])
            ->select([
                'id',
                'supplier_id',
                //酒店2.1，查询结果增加结算打款对象字段 settle_obj
                'settle_obj',
            ])
            ->asArray()
            ->all();
//        dd($hotel_info);
        if (empty($hotel_info)) {
            return NULL;
        }
        //获取订单结算的限定时间段（$type <0.周结 1.月结>）
        //获取到的结果：月结=前一天再往前推一个月，周结=前一天再往前推一周
        $date_data = self::GetWeekMonth($type);
        $result_order = [];
        $hotel_account_result_order = [];
        foreach ($hotel_info as $k => $val) {
            //酒店2.1 把打款至酒店账户的酒店及对应订单信息抽出来
            if ($val['settle_obj'] != 1) {//---打款至供应商账户------
                //查询出 [指定时间段内] 的酒店下的 [已离店、已点评、退款失败] 的 [未结算] 的订单
                $order_info = HotelOrder::find()
                    ->where(['hotel_id' => $val['id']])
                    ->andWhere(['between', 'out_time', $date_data['start_date'], $date_data['end_date']])
                    ->andWhere(['is_settle' => 0])
                    ->andWhere(['OR',
                        ['status' => 14],//已离店
                        ['status' => 15],//已点评
                        ['status' => 33],//退款失败
                    ])
                    ->select([
                        'id',//订单ID
                        'order_num',//订单号
                        'order_total',//订单总额
                        'pay_total',//实际支付
                        'hotel_income',//酒店收入
                        'tango_income',//棠果收入
                        'order_uid',//下单人uid
                    ])
                    ->asArray()
                    ->all();
                if (!empty($order_info)) {
                    $order_info['supplier_id'] = $val['supplier_id'];
                    $result_order[$val['id']] = $order_info;//当前酒店下的订单（key是代理商）
                }
            } else {//---打款至酒店账户-------
                //查询出 [指定时间段内] 的酒店下的 [已离店、已点评、退款失败] 的 [未结算] 的订单
                $account_order_info = HotelOrder::find()
                    ->where(['hotel_id' => $val['id']])
                    ->andWhere(['between', 'out_time', $date_data['start_date'], $date_data['end_date']])
                    ->andWhere(['is_settle' => 0])
                    ->andWhere(['OR',
                        ['status' => 14],//已离店
                        ['status' => 15],//已点评
                        ['status' => 33],//退款失败
                    ])
                    ->select([
                        'id',//订单ID
                        'order_num',//订单号
                        'order_total',//订单总额
                        'pay_total',//实际支付
                        'hotel_income',//酒店收入
                        'tango_income',//棠果收入
                        'order_uid',//下单人uid
                    ])
                    ->asArray()
                    ->all();
                if (!empty($account_order_info)) {
                    $account_order_info['supplier_id'] = $val['supplier_id'];//酒店供应商的ID，因为订单中没有记录供应商的ID，存储备用
                    $hotel_account_result_order[$val['id']] = $account_order_info;//当前酒店下的订单（key是酒店ID，对应的键值是整理后的酒店下的订单信息所组成的数组）
                }
            }
        }
        if (empty($result_order) && empty($hotel_account_result_order)) {//打款至供应商的订单信息和打款至酒店的订单信息同时为空，返回null值
            return NULL;
        }
        //如果打款至供应商的订单信息不为空
        $settlement_sql = [];
        if (!empty($result_order)) {
            foreach ($result_order as $key => $value) {
                $pay_total = 0;//结算总金额
                $order_total = 0;//订单总额
                $agent_total = 0;//供应商收入
                $tangguo_total = 0;//棠果收入
                foreach ($value as $ks => $values) {
                    if ($ks !== 'supplier_id') {
                        $pay_total     += $values['pay_total'];
                        $order_total   += $values['order_total'];
                        $agent_total   += $values['hotel_income'];
                        $tangguo_total += $values['tango_income'];
                    }
                }
                $settlement_sql[] =[
                    'settle_id'     => self::create_settlement(),
                    'hotel_id'      => $key,
                    'supplier_id'   => $value['supplier_id'],
                    'create_time'   => date('Y-m-d H:i:s'),
                    'total'         => $agent_total,
                    'order_total'   => $order_total,
                    'agent_total'   => $agent_total,
                    'tangguo_total' => $tangguo_total,
                    'start_time'    => $date_data['start_date'],
                    'end_time'      => $date_data['end_date']
                ];
            }
        }
        //如果打款至酒店的订单信息不为空
        $hotel_account_settlement_sql = [];
        if (!empty($hotel_account_result_order)) {
            foreach ($hotel_account_result_order as $keyc => $valuec) {
                $pay_total = 0;//结算总金额
                $order_total = 0;//订单总额
                $agent_total = 0;//供应商收入
                $tangguo_total = 0;//棠果收入
                foreach ($valuec as $ksc => $valuecs) {
                    if ($ksc !== 'supplier_id') {
                        $pay_total     += $valuecs['pay_total'];
                        $order_total   += $valuecs['order_total'];
                        $agent_total   += $valuecs['hotel_income'];
                        $tangguo_total += $valuecs['tango_income'];
                    }
                }
                $hotel_account_settlement_sql[] =[
                    'settle_id'     => self::create_settlement(),
                    'hotel_id'      => $keyc,
                    'supplier_id'   => $valuec['supplier_id'],
                    'create_time'   => date('Y-m-d H:i:s'),
                    'total'         => $agent_total,
                    'order_total'   => $order_total,
                    'agent_total'   => $agent_total,
                    'tangguo_total' => $tangguo_total,
                    'start_time'    => $date_data['start_date'],
                    'end_time'      => $date_data['end_date'],
                    'settle_obj'    => 1,//指定结算对象为酒店账户
                ];
            }
        }


        $result_data = [
            'result_order'   => ($result_order + $hotel_account_result_order),//保留原数组键名，因为键名是酒店ID，要在后期插入数据库时，跟结算单里面的酒店ID字段关联使用
            'settlement_sql' => array_merge($settlement_sql, $hotel_account_settlement_sql),//这里面是纯粹的酒店结算单信息，键名无需保留
        ];
        return $result_data;
    }
    /**
     * @获取 周/月 时间间隔
     */
    public static function GetWeekMonth($type)
    {
        if ($type == \Yii::$app->params['handle_hotel_settle_type']['month']) {//月结
            $start_date = date('Y-m-d', strtotime('-1month -1day')).' 00:00:00';
        } else {//周结
            $start_date = date('Y-m-d', strtotime('-1week -1day')).' 00:00:00';
        }
        $end_date = date('Y-m-d', strtotime('-1day')).' 23:59:59';
        $date_info = [
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ];
        return $date_info;
    }
    /**
     * @生成结算ID单号
     */
    //生成结算id
    public static function create_settlement()
    {
        $date = date('His');
        return $date . mt_rand(0, 9) . time() . mt_rand(1000, 9999);
    }
    /**
     * @插入结算表
     */
    public static function HandleSettleTable($sql_info)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $settle_detail = [];
            $point_log = [];
            foreach ($sql_info['settlement_sql'] as $k => $val) {
                if (!SearchSql::_InsertSqlExecute('hotel_supplier_settlement', $val)) {
                    throw new \Exception('settlement_table_inset_error');
                }
                $settle_id = \Yii::$app->db->getLastInsertId();
                foreach ($sql_info['result_order'] as $key => $value) {
                    unset($value['supplier_id']);
                    if ($val['hotel_id'] == $key) {
                        foreach ($value as $kes => $values) {
                            //结算详情
                            $settle_detail[] = [
                                $settle_id,//结算ID
                                $values['id'],//订单ID
                                $values['order_num'],//订单号
                                date('Y-m-d H:i:s'),//创建时间
                            ];
                            //积分log记录
                            $point = round($values['order_total']/10);
                            $uid = $values['order_uid'];
                            $point_log[] = [
                                $uid,//下单Uid
                                2,//获取
                                6,//酒店
                                $values['id'],//订单ID
                                $point,//积分
                                time(),//创建时间
                            ];
                            //修改用户积分
                            $point_sql = "UPDATE `user` SET point_total=point_total+{$point} WHERE `id`={$uid}";
                            \Yii::$app->db->createCommand($point_sql)->execute();
                        }
                    }
                }
            }
            $name_data = ['settle_id', 'order_id', 'order_num', 'create_time'];
            if (!SearchSql::_InsertManySqlExecute('hotel_settle_detail', $name_data, $settle_detail)) {
                throw new \Exception('settle_detail_insert_error');
            }
            $name_info = ['uid', 'type', 'order_type', 'order_id', 'point', 'create_time'];
            if (!SearchSql::_InsertManySqlExecute('shop_point_log', $name_info, $point_log)) {
                throw new \Exception('shop_point_log_insert_error');
            }
            foreach ($sql_info['result_order'] as $vv) {
                unset($vv['supplier_id']);
                foreach ($vv as $vals) {
                    if (!SearchSql::_UpdateSqlExecute('hotel_order', ['is_settle' => 1], ['id' => $vals['id']])) {
                        throw new \Exception('update_order_settle_status_abnormal');
                    }
                }
            }
            $transaction->commit();
        }catch (\Exception $e) {
            $transaction->rollBack();
            $errMap = [
                'settlement_table_inset_error' => false,
                'settle_detail_insert_error'   => false,
                'shop_point_log_insert_error'  => false,
                'update_order_settle_status_abnormal' => false,
                'update_user_point_abnormal'   => false,
            ];
            return isset($errMap[$e->getMessage()])?$errMap[$e->getMessage()]:false;
        }
        return 'success';
    }
    /**
     * @查询单结订单
     */
    public static function OrderSettleInfo($supplier_info)
    {
        $hotel_info = Hotel::find()
            ->where(['IN', 'supplier_id', $supplier_info])
            ->select(['id', 'supplier_id', 'settle_obj'])
            ->asArray()
            ->all();
        if (empty($hotel_info)) {
            return NULL;
        }
        $result_order = [];
        $settle_arr = [];
        foreach ($hotel_info as $k => $val) {
            $settle_arr[$val['id']] = $val['settle_obj'];
            $order_info = HotelOrder::find()
                ->where(['hotel_id' => $val['id']])
                ->andWhere(['is_settle' => 0])
                ->andWhere(['OR',
                    ['status' => 14],//已离店
                    ['status' => 15],//已点评
                    ['status' => 33],//退款失败
                ])
                ->select([
                    'id',//订单ID
                    'order_num',//订单号
                    'order_total',//订单总额
                    'pay_total',//实际支付
                    'hotel_income',//酒店收入
                    'tango_income',//棠果收入
                    'order_uid',//下单人uid
                ])
                ->asArray()
                ->all();
            if (!empty($order_info)) {
                $order_info['supplier_id'] = $val['supplier_id'];
                $result_order[$val['id']] = $order_info;//当前酒店下的订单（key是代理商）
            }
        }
//        dd($settle_arr);
//        dd($result_order);
        if (empty($result_order)) {
            return NULL;
        }
        //----HandleHotelSettleController中顶部注释提及的位置 ↓----
        $settle_sql_info = [];
        foreach ($result_order as $ks => $vals) {
            foreach ($vals as $keys => $value) {
                if ($keys !== 'supplier_id') {
                    $ccc = [
                        'settle_id'     => self::create_settlement(),//结算ID单号
                        'hotel_id'      => $ks,//酒店ID
                        'supplier_id'   => $vals['supplier_id'],//供应商ID
                        'create_time'   => date('Y-m-d H:i:s'),//创建时间
                        'total'         => $value['hotel_income'],//结算金额
                        'order_total'   => $value['order_total'],//订单金额
                        'agent_total'   => $value['hotel_income'],//酒店收入
                        'tangguo_total' => $value['tango_income'],//棠果收入
                        'start_time'    => date('Y-m-d H:i:s'),//开始时间
                        'end_time'      => date('Y-m-d H:i:s'),//结束时间
                        'order_id'      => $value['id'],//订单id
                        'order_num'     => $value['order_num'],//订单号
                        'order_uid'     => $value['order_uid'],//下单人uid
                    ];
                    if ($settle_arr[$ks] == 1) {//打款至酒店账户
                        $ccc['settle_obj'] = 1;//标记为打款至酒店账户
                    }
                    $settle_sql_info[] = $ccc;
                }
            }
        }
        return $settle_sql_info;
    }
    /**
     * @单结插入结算表
     */
    public static function HandleOrderSettleTable($sql_info)
    {
        foreach ($sql_info as $k => $val) {
            $detail_data = [
                'order_id' => $val['order_id'],
                'order_num' => $val['order_num'],
                'create_time' => date('Y-m-d H:i:s'),
            ];
            //积分log数据
            $point = round($val['order_total']/10);
            $uid = $val['order_uid'];
            $log_data = [
                'uid'         => $uid,//下单人ID
                'type'        => 2,//获取
                'order_type'  => 6,//酒店
                'order_id'    => $val['order_id'],//订单ID
                'point'       => $point,//积分
                'create_time' => time()//创建时间
            ];
            unset($val['order_id']);
            unset($val['order_num']);
            unset($val['order_uid']);
            $transaction = \Yii::$app->db->beginTransaction();
            try{
                $id_status = SearchSql::_InsertSqlExecute('hotel_supplier_settlement', $val);
                if (!$id_status) {
                    throw new \Exception('settlement_insert_abnormal');
                }
                $detail_data['settle_id'] = \Yii::$app->db->getLastInsertID();
                $status = SearchSql::_InsertSqlExecute('hotel_settle_detail', $detail_data);
                if (!$status) {
                    throw new \Exception('settle_detail_insert_abnormal');
                }
                $update_status = SearchSql::_UpdateSqlExecute('hotel_order', ['is_settle' => 1], ['id' => $detail_data['order_id']]);
                if (!$update_status) {
                    throw new \Exception('hotel_order_update_abnormal');
                }
                //积分log记录
                if (!SearchSql::_InsertSqlExecute('shop_point_log', $log_data)) {
                    throw new \Exception('shop_point_log_insert_error');
                }
                //修改用户积分
                $point_sql = "UPDATE `user` SET point_total=point_total+{$point} WHERE `id`={$uid}";
                \Yii::$app->db->createCommand($point_sql)->execute();
                $transaction->commit();
            }catch (\Exception $e) {
                $transaction->rollBack();
                $errMap = [
                    'settlement_insert_abnormal'    => false,
                    'settle_detail_insert_abnormal' => false,
                    'hotel_order_update_abnormal'   => false,
                    'shop_point_log_insert_error'   => false,
                ];
                return isset($errMap[$e->getMessage()])?$e->getMessage():false;
            }
        }
        return true;
    }
    /**
     * @查询获取 <特殊结算> 酒店供应商信息
     * @ ps: 此处的酒店供应商id是写死的，注意修改
     * @ update_time：2017/11/27
     * @ supplier.id: 20
     * @ handle_person: ys
     */
    public static function SpecialGetSupplierInfo()
    {
        $supplier_info = HotelSupplier::find()
            ->where(['id' => 144])  //此处的酒店供应商id是写死的，注意修改
//            ->where(['id' => 20])  //此处的酒店供应商id是写死的，注意修改
            ->select(['id'])
            ->asArray()
            ->column();
        if (empty($supplier_info)) {
            return false;
        }
        return $supplier_info;
    }
    /**
     * @查询单结订单
     */
    public static function SpecialOrderSettleInfo($supplier_info)
    {
        $hotel_info = Hotel::find()
            ->where(['IN', 'supplier_id', $supplier_info])
            //---------------此处自定义了相应的酒店id-----id已写死--------
            ->andWhere(['id' => 138])
//            ->andWhere(['id' => 83])
            ->select(['id', 'supplier_id', 'settle_obj'])
            ->asArray()
            ->all();
        if (empty($hotel_info)) {
            return NULL;
        }
        $result_order = [];
        $settle_arr = [];
        foreach ($hotel_info as $k => $val) {
            $settle_arr[$val['id']] = $val['settle_obj'];
            $order_info = HotelOrder::find()
                //-----------此处定义需要修改的订单--------订单号已写死-------
                ->where(['OR',
                    ['order_num' => 'H1959400475708354'],
                    ['order_num' => 'H1959401609311830']
                ])
//                ->where(['OR',
//                    ['order_num' => 'H4596801574129966'],
//                    ['order_num' => 'H4596801051650170']
//                ])
                ->andwhere(['hotel_id' => $val['id']])
                ->andWhere(['is_settle' => 0])
                ->andWhere(['OR',
                    ['status' => 14],//已离店
                    ['status' => 15],//已点评
                    ['status' => 33],//退款失败
                ])
                ->select([
                    'id',//订单ID
                    'order_num',//订单号
                    'order_total',//订单总额
                    'pay_total',//实际支付
                    'hotel_income',//酒店收入
                    'tango_income',//棠果收入
                    'order_uid',//下单人uid
                ])
                ->asArray()
                ->all();
            if (!empty($order_info)) {
                $order_info['supplier_id'] = $val['supplier_id'];
                $result_order[$val['id']] = $order_info;//当前酒店下的订单（key是代理商）
            }
        }
//        dd($settle_arr);
//        dd($result_order);
        if (empty($result_order)) {
            return NULL;
        }
        //----HandleHotelSettleController中顶部注释提及的位置 ↓----
        $settle_sql_info = [];
        foreach ($result_order as $ks => $vals) {
            foreach ($vals as $keys => $value) {
                if ($keys !== 'supplier_id') {
                    $ccc = [
                        'settle_id'     => self::create_settlement(),//结算ID单号
                        'hotel_id'      => $ks,//酒店ID
                        'supplier_id'   => $vals['supplier_id'],//供应商ID
                        'create_time'   => date('Y-m-d H:i:s'),//创建时间
                        'total'         => $value['hotel_income'],//结算金额
                        'order_total'   => $value['order_total'],//订单金额
                        'agent_total'   => $value['hotel_income'],//酒店收入
                        'tangguo_total' => $value['tango_income'],//棠果收入
                        'start_time'    => date('Y-m-d H:i:s'),//开始时间
                        'end_time'      => date('Y-m-d H:i:s'),//结束时间
                        'order_id'      => $value['id'],//订单id
                        'order_num'     => $value['order_num'],//订单号
                        'order_uid'     => $value['order_uid'],//下单人uid
                    ];
                    if ($settle_arr[$ks] == 1) {//打款至酒店账户
                        $ccc['settle_obj'] = 1;//标记为打款至酒店账户
                    }
                    $settle_sql_info[] = $ccc;
                }
            }
        }
        return $settle_sql_info;
    }
    
}