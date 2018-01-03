<?php
namespace backend\controllers;
use yii\web\Controller;

/**
 * Created by PhpStorm.
 * User: lele
 * Date: 2017/8/4
 * Time: 19:57
 */
class SettlementController extends Controller{
    //    财务管理-退款处理-民宿-待退款订单-全部
    public function actionMs_dtk_all(){
        return $this->render('ms_dtk_all');
    }
    //    财务管理-退款处理-民宿-待退款订单-退款待确认
    public function actionMs_dtk_dqr(){
        return $this->render('ms_dtk_dqr');
    }
    //    财务管理-退款处理-民宿-待退款订单-待退款
    public function actionMs_dtk_dtk(){
        return $this->render('ms_dtk_dtk');
    }
    //    财务管理-退款处理-民宿-已处理订单
    public function actionMs_ycl(){
        return $this->render('ms_ycl');
    }
//    //    财务管理-退款处理-旅行-待退款订单-全部
//    public function actionLx_dtk_all(){
//        return $this->render('lx_dtk_all');
//    }
//    //    财务管理-退款处理-旅行-待退款订单-退款待审核
//    public function actionLx_dtk_dsh(){
//        return $this->render('lx_dtk_dsh');
//    }
//    //    财务管理-退款处理-旅行-待退款订单-待退款
//    public function actionLx_dtk_dtk(){
//        return $this->render('lx_dtk_dtk');
//    }
//    //    财务管理-退款处理-旅行-已处理
//    public function actionLx_ycl(){
//        return $this->render('lx_ycl');
//    }

    //    财务管理-结算处理-国内房东结算-房东待付款-全部
    public function actionJs_cn_fd_all(){
        return $this->render('js_cn_fd_all');
    }
//    //    财务管理-结算处理-国内房东结算-房东待付款-结算待审核
//    public function actionJs_cn_fd_dsh(){
//        return $this->render('js_cn_fd_dsh');
//    }
//    //    财务管理-结算处理-国内房东结算-房东待付款-结算未通过
//    public function actionJs_cn_fd_nopass(){
//        return $this->render('js_cn_fd_nopass');
//    }
//    //    财务管理-结算处理-国内房东结算-房东待付款-结算拒绝
//    public function actionJs_cn_fd_deny(){
//        return $this->render('js_cn_fd_deny');
//    }
//    //    财务管理-结算处理-国内房东结算-房东待付款-结算待确认
//    public function actionJs_cn_fd_dqr(){
//        return $this->render('js_cn_fd_dqr');
//    }
//    //    财务管理-结算处理-国内房东结算-房东待付款-结算待付款
//    public function actionJs_cn_fd_dfk(){
//        return $this->render('js_cn_fd_dfk');
//    }
    //    财务管理-结算处理-国内房东结算-全部结算单
    public function actionJs_cn_alljs(){
        return $this->render('js_cn_alljs');
    }
    //    财务管理-结算处理-国内房东结算-账单明细
    public function actionJs_cn_billdetail(){
        return $this->render('js_cn_billdetail');
    }
    //    财务管理-结算处理-海外房东结算-房东待付款-全部
    public function actionJs_abroad_fd_all(){
        return $this->render('js_abroad_fd_all');
    }
//    //    财务管理-结算处理-海外房东结算-房东待付款-结算待审核
//    public function actionJs_abroad_fd_dsh(){
//        return $this->render('js_abroad_fd_dsh');
//    }
//    //    财务管理-结算处理-海外房东结算-房东待付款-结算未通过
//    public function actionJs_abroad_fd_nopass(){
//        return $this->render('js_abroad_fd_nopass');
//    }
//    //    财务管理-结算处理-海外房东结算-房东待付款-结算拒绝
//    public function actionJs_abroad_fd_deny(){
//        return $this->render('js_abroad_fd_deny');
//    }
//    //    财务管理-结算处理-海外房东结算-房东待付款-结算待确认
//    public function actionJs_abroad_fd_dqr(){
//        return $this->render('js_abroad_fd_dqr');
//    }
//    //    财务管理-结算处理-海外房东结算-房东待付款-结算待付款
//    public function actionJs_abroad_fd_dfk(){
//        return $this->render('js_abroad_fd_dfk');
//    }
    //    财务管理-结算处理-海外房东结算-全部结算单
    public function actionJs_abroad_alljs(){
        return $this->render('js_abroad_alljs');
    }
    //    财务管理-结算处理-海外房东结算-账单明细
    public function actionJs_abroad_billdetail(){
        return $this->render('js_abroad_billdetail');
    }
    //    财务管理-结算处理-合伙人结算-合伙人待付款-全部
    public function actionJs_partner_all(){
        return $this->render('js_partner_all');
    }
//    //    财务管理-结算处理-合伙人结算-合伙人待付款-结算待审核
//    public function actionJs_partner_dsh(){
//        return $this->render('js_partner_dsh');
//    }
//    //    财务管理-结算处理-合伙人结算-合伙人待付款-结算未通过
//    public function actionJs_partner_nopass(){
//        return $this->render('js_partner_nopass');
//    }
//    //    财务管理-结算处理-合伙人结算-合伙人待付款-结算拒绝
//    public function actionJs_partner_deny(){
//        return $this->render('js_partner_deny');
//    }
//    //    财务管理-结算处理-合伙人结算-合伙人待付款-结算待确认
//    public function actionJs_partner_dqr(){
//        return $this->render('js_partner_dqr');
//    }
//    //    财务管理-结算处理-合伙人结算-合伙人待付款-结算待付款
//    public function actionJs_partner_dfk(){
//        return $this->render('js_partner_dfk');
//    }
    //    财务管理-结算处理-合伙人结算-全部结账单
    public function actionJs_partner_alljs(){
        return $this->render('js_partner_alljs');
    }
    //    财务管理-结算处理-合伙人结算-账单明细
    public function actionJs_partner_billdetail(){
        return $this->render('js_partner_billdetail');
    }
//    //    财务管理-结算处理-旅行结算-达人待付款-全部
//    public function actionJs_lxdr_all(){
//        return $this->render('js_lxdr_all');
//    }
//    //    财务管理-结算处理-旅行结算-达人待付款-结算拒绝
//    public function actionJs_lxdr_deny(){
//        return $this->render('js_lxdr_deny');
//    }
//    //    财务管理-结算处理-旅行结算-达人待付款-结算待确认
//    public function actionJs_lxdr_dqr(){
//        return $this->render('js_lxdr_dqr');
//    }
//    //    财务管理-结算处理-旅行结算-达人待付款-结算待付款
//    public function actionJs_lxdr_dfk(){
//        return $this->render('js_lxdr_dfk');
//    }
//    //    财务管理-结算处理-旅行结算-全部结账单
//    public function actionJs_lxdr_alljs(){
//        return $this->render('js_lxdr_alljs');
//    }
//    //    财务管理-结算处理-旅行结算-达人账单明细
//    public function actionJs_lxdr_billdetail(){
//        return $this->render('js_lxdr_billdetail');
//    }

    //    财务管理-对账管理-收款单管理-收款单列表
    public function actionDz_skd_list(){
        return $this->render('dz_skd_list');
    }
    //    财务管理-对账管理-收款单管理-收款单详情
    public function actionDz_skd_detail(){
        return $this->render('dz_skd_detail');
    }
    //    财务管理-对账管理-退款单管理-退款单列表
    public function actionDz_tkd_list(){
        return $this->render('dz_tkd_list');
    }
    //    财务管理-对账管理-退款单管理-退款单详情
    public function actionDz_tkd_detail(){
        return $this->render('dz_tkd_detail');
    }
    //    财务管理-对账管理-付款单管理-付款单列表
    public function actionDz_fkd_list(){
        return $this->render('dz_fkd_list');
    }
    //    财务管理-对账管理-付款单管理-付款单详情
    public function actionDz_fkd_detail(){
        return $this->render('dz_fkd_detail');
    }
    //    财务管理-对账管理-对账单管理-对账单列表全部
    public function actionDz_dzd_listall(){
        return $this->render('dz_dzd_listall');
    }
    //    财务管理-对账管理-对账单管理-对账单详情全部
    public function actionDz_dzd_detailall(){
        return $this->render('dz_dzd_detailall');
    }
    //    财务管理-对账管理-对账单管理-手续费记录
    public function actionDz_dzd_sxf(){
        return $this->render('dz_dzd_sxf');
    }
    //    订单管理-民宿-订单列表
    public function actionDd_ms_list(){
        return $this->render('dd_ms_list');
    }
    //    订单管理-民宿-结算异常订单
    public function actionDd_ms_abnormal(){
        return $this->render('dd_ms_abnormal');
    }
    //    订单管理-民宿-订单详情
    public function actionDd_ms_detail(){
        return $this->render('dd_ms_detail');
    }
    //    订单管理-旅行-结算异常订单-待处理
//    public function actionDd_lx_abnormal_dcl(){
//        return $this->render('dd_lx_abnormal_dcl');
//    }
//    //    订单管理-旅行-结算异常订单-已处理
//    public function actionDd_lx_abnormal_ycl(){
//        return $this->render('dd_lx_abnormal_ycl');
//    }
//    //    订单管理-旅行-订单详情
//    public function actionDd_lx_detail(){
//        return $this->render('dd_lx_detail');
//    }

}