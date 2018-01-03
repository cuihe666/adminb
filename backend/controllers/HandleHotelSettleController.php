<?php
namespace backend\controllers;

use backend\models\HandleHotelSettle;
use yii\web\Controller;

class HandleHotelSettleController extends Controller
{
    /**
     * @开发调试接口
     * admin:ys
     * time:2017/11/4
     * ps:
     *   1.调试开发打开注释（actionTest()），上线时请注释掉
     *   2.酒店结算的周结和月结方式是一摸一样的，调通一个即可。
     *   3.单结是后加的，大体结算逻辑也一致，主要区别在数据的压入环节，即 HandleHotelSettle::HandleOrderSettleTable($sql_info) 位置，
     *     以及数据的整理位置，即 HandleHotelSettle::OrderSettleInfo($supplier_info) 中的注释标记位置
     *     这里的逻辑比周结月结更简明，理一下就 OK了
     */
//    public function actionTest()
//    {
//        $result_data = self::SpecialSettle();
//        dd($result_data);
//    }
    /**
     * @酒店结算
     * @月结 1
     */
    public static function MonthSettle()
    {
        try{
            //查询所有设定为月结的酒店供应商
            $supplier_info = HandleHotelSettle::GetSupplierInfo(1);//月结供应商（0.周结供应商 1.月结供应商 2.单结供应商）
            if (!$supplier_info) {
                throw new \Exception('supplier_info_null');
            }
//            dd($supplier_info);
            //查询所有月结供应商下的订单信息，并对信息的数据结构进行调整
            $sql_info = HandleHotelSettle::HotelOrderInfo(1, $supplier_info);
            if (empty($sql_info)) {
                throw new \Exception('order_info_null');
            }
//            dd($sql_info);
            //将订单信息再做整理后，插入到酒店结算表和酒店结算详情表
            $status = HandleHotelSettle::HandleSettleTable($sql_info);
            if (!$status) {
                throw new \Exception('insert_handle_abnormal');
            }
        }catch (\Exception $e) {
            $errMap = [
                'supplier_info_null'     => 'supplier_info_null',
                'order_info_null'        => 'order_info_null',
                'insert_handle_abnormal' => 'insert_handle_abnormal',
            ];
            return isset($errMap[$e->getMessage()])?$errMap[$e->getMessage()]:'the_server_abnormal';
        }
        return 'success';
    }
    /**
     * @酒店结算
     * @周结 0
     */
    public static function WeekSettle()
    {
        try{
            $supplier_info = HandleHotelSettle::GetSupplierInfo(0);//周结供应商
            if (!$supplier_info) {
                throw new \Exception('supplier_info_null');
            }
//            dd($supplier_info);
            $sql_info = HandleHotelSettle::HotelOrderInfo(0, $supplier_info);
            if (empty($sql_info)) {
                throw new \Exception('order_info_null');
            }
//            dd($sql_info);
            $status = HandleHotelSettle::HandleSettleTable($sql_info);
            if (!$status) {
                throw new \Exception('insert_handle_abnormal');
            }
        }catch (\Exception $e) {
            $errMap = [
                'supplier_info_null'     => 'supplier_info_null',
                'order_info_null'        => 'order_info_null',
                'insert_handle_abnormal' => 'insert_handle_abnormal',
            ];
            return isset($errMap[$e->getMessage()])?$errMap[$e->getMessage()]:'the_server_abnormal';
        }
        return 'success';
    }
    /**
     * @酒店结算
     * @单结 2
     */
    public static function OrderSettle()
    {
        try{
            $supplier_info = HandleHotelSettle::GetSupplierInfo(2);//单结供应商
            if (!$supplier_info) {
                throw new \Exception('supplier_info_null');
            }
//            dd($supplier_info);
            $sql_info = HandleHotelSettle::OrderSettleInfo($supplier_info);
            if (empty($sql_info)) {
                throw new \Exception('order_info_null');
            }
            $status = HandleHotelSettle::HandleOrderSettleTable($sql_info);
            if (!$status) {
                throw new \Exception('insert_handle_abnormal');
            }
        }catch (\Exception $e) {
            $errMap = [
                'supplier_info_null'     => 'supplier_info_null',
                'order_info_null'        => 'order_info_null',
                'insert_handle_abnormal' => 'insert_handle_abnormal',
            ];
            return isset($errMap[$e->getMessage()])?$errMap[$e->getMessage()]:'the_server_abnormal';
        }
        return 'success';
    }
    /**
     * @酒店结算
     * @特殊结算
     */
    public static function SpecialSettle()
    {
        try{
            $supplier_info = HandleHotelSettle::SpecialGetSupplierInfo();//单结供应商
            if (!$supplier_info) {
                throw new \Exception('special_supplier_info_null');
            }
//            dd($supplier_info);
            $sql_info = HandleHotelSettle::SpecialOrderSettleInfo($supplier_info);
            if (empty($sql_info)) {
                throw new \Exception('special_order_info_null');
            }
            $status = HandleHotelSettle::HandleOrderSettleTable($sql_info);
            if (!$status) {
                throw new \Exception('special_insert_handle_abnormal');
            }
        }catch (\Exception $e) {
            $errMap = [
                'special_supplier_info_null'     => 'special_supplier_info_null',
                'special_order_info_null'        => 'special_order_info_null',
                'special_insert_handle_abnormal' => 'special_insert_handle_abnormal',
            ];
            return isset($errMap[$e->getMessage()])?$errMap[$e->getMessage()]:'the_server_abnormal';
        }
        return 'success';
    }

}