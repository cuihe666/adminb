<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/5/10
 * Time: 下午1:36
 */

namespace backend\service;
use backend\models\HotelSupplier;
use common\tools\Helper;
use Yii;

class HotelSupplierService
{
    //写入统计日志
    public static function statusLog($request){
        switch ($request['status']){
            case '1':
                $remark = '通过审核';
                break;
            case '2':
                $remark = '拒绝通过,被拒原因:'.$request['msg'];
                break;
            case '3':
                $remark = '停用供应商';
                break;
            default:
                $remark = '超出范围';
        }

        $info = [
            'id' => $request['id'],
            'old_status' => $request['oldStatus'],
            'status' => $request['status'],
            'remark' => $remark,
            'handler_name' => Yii::$app->user->getIdentity()->username
        ];

        return self::storeStatusLog($info);
    }

    //将结算部分写入统计日志
    public static function settleLog(HotelSupplier $supplier,$type){
        switch ($type){
            case 'status':
                $str = '供应商 %s 已结算';
                break;
            case 'invoice':
                $str = '供应商 %s 已开发票';
                break;
        }
        $remark = sprintf($str,$supplier->name);

        $data = [
            'table_name' => 'hotel_supplier_settlement',
            'record_id' => $supplier->getPrimaryKey(),
            'remark' => $remark,
        ];
        return Helper::log($data);



    }

    public static function storeStatusLog($data){
        return Yii::$app->db->createCommand("INSERT INTO hotel_check_logs (supplier_id,before_status,after_status,remarks,check_adminname,check_time) VALUES(:supplier_id,:before_status,:after_status,:remarks,:check_adminname,:check_time)")
            ->bindValue(":supplier_id", $data['id'])
            ->bindValue(":before_status", $data['old_status'])
            ->bindValue(":after_status", $data['status'])
            ->bindValue(":remarks", $data['remark'])
            ->bindValue(":check_adminname", $data['handler_name'])
            ->bindValue(":check_time", date("Y-m-d H:i:s", time()))
            ->execute();
    }
}