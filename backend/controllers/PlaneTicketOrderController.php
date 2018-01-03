<?php

namespace backend\controllers;

use backend\models\PlaneTicketExpressCompany;
use backend\models\PlaneTicketInsuranceGoodsManage;
use backend\models\PlaneTicketOrderEmplane;
use backend\models\PlaneTicketOrderInsurance;
use backend\models\PlaneTicketOrderInsuranceDetails;
use backend\models\PlaneTicketOrderInsurancePay;
use backend\models\PlaneTicketSupplier;
use backend\models\SearchSql;
use backend\models\Submit;
use backend\service\AsyncRequestService;
use Yii;
use backend\models\PlaneTicketOrder;
use backend\models\PlaneTicketOrderQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\traits;

/**
 * PlaneTicketOrderController implements the CRUD actions for PlaneTicketOrder model.
 */
class PlaneTicketOrderController extends Controller
{
    use traits\PlaneTicketInfo;
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
     * Lists all PlaneTicketOrder models.
     * @机票订单列表入口
     */
    public function actionIndex()
    {
        $searchModel = new PlaneTicketOrderQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        dd($dataProvider->getModels());
        $supplier_info = PlaneTicketSupplier::find()
            ->where(['insurance_genre' => 0])
            ->select([
                'id',
                'name'
            ])
            ->asArray()
            ->all();
        $list_info = [];
        foreach ($supplier_info as $value) {
            $list_info[$value['id']] = $value['name'];
        }
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'list_info'    => $list_info,
            'action'       => 'index'
        ]);
    }
    /**
     * @查询第三方单号
     * @ params : $id => 订单ID
     * @ return : string （三方订单号）
     */
    public static function GetOtherTradeOrderNo($id)
    {
        $trade_no_sql = "SELECT `trade_no` FROM `plane_ticket_order_ticket_pay` WHERE `order_id`='$id'";
        $trade_no = Yii::$app->db->createCommand($trade_no_sql)->queryScalar();
        if (empty($trade_no)) {
            return '';
        } else {
            return $trade_no;
        }
    }
    /**
     * @异常订单入口
     */
    public function actionAbnormal()
    {
        $search_name = Yii::$app->request->get('note','');
        if ($search_name == 'two' || empty($search_name)) {//出票超时
            $search_note = 'two';
            $top_css = 'two';
        } else if ($search_name == 'three') {//退款失败
            $search_note = 'three';
            $top_css = 'three';
        } else if ($search_name == 'four') {//出票失败
            $search_note = 'four';
            $top_css = 'four';
        } else if ($search_name == 'five') {//已出票未出保
            $search_note = 'five';
            $top_css = 'five';
        } else if ($search_name == 'six') {//已退票未退保
            $search_note = 'six';
            $top_css = 'six';
        } else {//其他情况 默认为出票失败未退款
            $search_note = 'two';
            $top_css = 'two';
        }
        $searchModel = new PlaneTicketOrderQuery();
        $searchModel['abnormal_status'] = $search_note;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $supplier_info = PlaneTicketSupplier::find()
            ->where(['insurance_genre' => 0])
            ->select([
                'id',
                'name'
            ])
            ->asArray()
            ->all();
        $list_info = [];
        foreach ($supplier_info as $value) {
            $list_info[$value['id']] = $value['name'];
        }
        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'list_info'     => $list_info,
            'action'        => 'abnormal',//异常订单页标记
            'top_css'       => $top_css,//头部点中样式
            'abnormal'      => 'abnormal',//异常订单页面标记
        ]);
    }
    /**
     * @邮寄行程单管理列表
     */
    public function actionPost()
    {
        $searchModel = new PlaneTicketOrderQuery();
        $searchModel['order_status'] = 3;//  已出票
        $searchModel['express_money_post'] = 'post';//去除已出票订单中邮寄费用为0，即未勾选邮寄行程单服务的订单
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //机票供应商
        $supplier_info = PlaneTicketSupplier::find()
            ->where(['insurance_genre' => 0])
            ->select([
                'id',
                'name'
            ])
            ->asArray()
            ->all();
        $list_info = [];
        if (!empty($supplier_info)) {
            foreach ($supplier_info as $value) {
                $list_info[$value['id']] = $value['name'];
            }
        }
        //快递公司
        $express_info = PlaneTicketExpressCompany::find()
            ->asArray()
            ->all();
        $express_list = [];
        if (!empty($express_info)) {
            foreach ($express_info as $val) {
                $express_list[$val['id']] = $val['name'];
            }
        }
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'list_info'    => $list_info,//机票供应商列
            'express_list' => $express_list,//快递公司列
            'action'       => 'post',
        ]);
    }
    /**
     * @订单详情页
     */
    public function actionDetail()
    {
        $id = Yii::$app->request->get('oid', '');
        $note = Yii::$app->request->get('note', '');
        $action = Yii::$app->request->get('action','');
        $handle_note = self::OrderHandlePower($id, $note);
//        dd($handle_note);
        $order_info = PlaneTicketOrder::find()
            ->where(['id' => $id])
            ->asArray()
            ->one();
        $emplane_info = PlaneTicketOrderEmplane::find()
            ->where(['order_id' => $id])
            ->select([
                'id',
                'name',//姓名
                'ticket_type',//票种类型
                'card_type',//证件类型
                'card_no',//证件号码
                'ticket_no',//票号
                'insurance_no',//保单号
                'refund_ticket_status',//申请退票状态（用户操作）
                'refund_insurance_status',//退保状态
                'pre_price',//票面价格
                'insurance_money',//保险金额
                'mb_airport',//机建费用
                'mb_fuel',//燃油费用
                'total_amount',//单人总价
                'refund_ticket_id',//退票申请记录表ID
            ])
            ->asArray()
            ->all();
        $emplane_info = self::RefundInsuranceNote($emplane_info);
        //支付交易记录（包括退款）
        $plane_order_pay_note = self::PlaneOrderPayNote($id, $order_info['pay_platform'], $order_info['ticket_supplier_id']);
        //邮寄才有的操作
        $express_list = [];
        if ($action == 'post') {
            $express_info = PlaneTicketExpressCompany::find()
                ->asArray()
                ->all();
            $express_list = [];
            if (!empty($express_info)) {
                foreach ($express_info as $k => $v) {
                    $express_list[$v['id']] = $v['name'];
                }
            }
        }
        $result_info = [
            'order_info'   => $order_info,//订单基础信息
            'emplane_info' => $emplane_info,//乘机人（投保人）信息
            'plane_order_pay_note' => $plane_order_pay_note,//支付交易记录
            'handle_note'  => $handle_note,//权限标记
            'action'       => $action,//入口标记
            'express_list' => $express_list,//快递公司列表
        ];
//        dd($result_info);
        return $this->render('detail', $result_info);
    }
    /**
     * @订单详情页-申请退票时间
     */
    public static function ApplyPlaneTicketRefundTime($refund_ticket_id)
    {
        $sql = "SELECT `create_time` FROM `plane_ticket_order_refund_ticket` WHERE `id`=:id";
        $refund_time = SearchSql::_SearchScalarData($sql,[
            ':id' => $refund_ticket_id
        ]);
        return $refund_time;
    }
    /**
     * @订单详情页-申请退票时间
     */
    public static function PlaneTicketRefundSuccessTime($refund_ticket_id)
    {
        //当前申请退款记录单下，退款成功的时间
        $sql = "SELECT `create_time` FROM `plane_ticket_order_ticket_refundment` WHERE `refund_ticket_id`=:id AND `refundment_status`=1";
        $refund_time = SearchSql::_SearchScalarData($sql,[
            ':id' => $refund_ticket_id
        ]);
        return (isset($refund_time) ? $refund_time : '');
    }
    /**
     * @订单详情页-支付交易记录
     */
    public static function PlaneOrderPayNote($id, $pay_platform, $ticket_supplier_id)
    {
        if ($pay_platform == 1) {//支付宝
            $pay_info = self::PlaneOrderDetailAliPayNote($id, $ticket_supplier_id);
        } else {//微信
            $pay_info = self::PlaneOrderDetailWeiXinPapNote($id, $ticket_supplier_id);
        }
        return $pay_info;
    }
    /**
     * @支付交易记录-支付宝信息处理
     */
    public static function PlaneOrderDetailAliPayNote($oid, $ticket_supplier_id)
    {
        //支付宝交易记录
        $pay_sql = "SELECT * FROM `plane_ticket_order_alipay_res` WHERE `order_id`=:id";
        $pay_info = SearchSql::_SearchAllData($pay_sql, [
            ':id' => $oid
        ]);
        //没有交易记录，就没有退款记录，返回NULL
        if (empty($pay_info)) {
            return '';
        }
        $result_info =[];
        foreach ($pay_info as $k => $val) {
            $result_info[] = [
                'trade_no' => $val['trade_no'],//第三方支付号
                'type'     => '支付',//支付类型
                'price'    => $val['total_amount'],//支付金额
                'time'     => $val['create_time'],//支付时间
                'supplier_name' => PlaneTicketProfitController::ToSupplierName($ticket_supplier_id),//商家名称
                'status'   => Yii::$app->params['plane_ticket_pay_status'][$val['trade_status']],//状态
            ];
        }
        //支付宝退款记录
        $refund_sql = "SELECT * FROM `plane_ticket_order_alirefund_res` WHERE `order_id`=:id";
        $refund_info = SearchSql::_SearchAllData($refund_sql, [
            ':id' => $oid
        ]);
        if (empty($refund_info)) {
            return $result_info;
        }
        foreach ($refund_info as $ks => $vals) {
            $result_info[] = [
                'trade_no' => $vals['trade_no'],//第三方支付号
                'type'     => '退款',//交易类型
                'price'    => $vals['refund_amount'],//退款金额
                'time'     => $vals['create_time'],//退款时间
                'supplier_name' => PlaneTicketProfitController::ToSupplierName($ticket_supplier_id),//商家名称
                'status'   => Yii::$app->params['plane_ticket_refund_status'][$vals['refund_status']],//状态
            ];
        }
        return $result_info;
    }
    /**
     * @支付交易记录-微信信息处理
     */
    public static function PlaneOrderDetailWeiXinPapNote($oid, $ticket_supplier_id)
    {
        //微信支付记录
        $pay_sql = "SELECT * FROM `plane_ticket_order_wxpay_res` WHERE `order_id`=:id";
        $pay_info = SearchSql::_SearchAllData($pay_sql,[
            ":id" => $oid
        ]);
        if (empty($pay_info)) {
            return '';
        }
        $result_info =[];
        foreach ($pay_info as $val) {
            $result_info[] = [
                'trade_no' => $val['transaction_id'],//第三方支付号
                'type'     => '支付',//支付类型
                'price'    => $val['total_fee'],//支付金额
                'time'     => $val['create_time'],//支付时间
                'supplier_name' => PlaneTicketProfitController::ToSupplierName($ticket_supplier_id),//商家名称
                'status'   => Yii::$app->params['plane_ticket_pay_status'][$val['trade_status']],//状态
            ];
        }
        //微信退款记录
        $refund_sql = "SELECT * FROM `plane_ticket_order_wxrefund_res` WHERE `order_id`=:id";
        $refund_info = SearchSql::_SearchAllData($refund_sql, [
            ':id' => $oid
        ]);
        if (empty($refund_info)) {
            return $result_info;
        }
        foreach ($refund_info as $ks => $vals) {
            $result_info[] = [
                'trade_no' => $vals['transaction_id'],//第三方支付号
                'type'     => '退款',//交易类型
                'price'    => ($vals['refund_fee']/100),//退款金额
                'time'     => $vals['create_time'],//退款时间
                'supplier_name' => PlaneTicketProfitController::ToSupplierName($ticket_supplier_id),//商家名称
                'status'   => Yii::$app->params['plane_ticket_refund_status'][$vals['refund_status']],//状态
            ];
        }
        return $result_info;
    }
    /**
     * @操作权限判定
     */
    public static function OrderHandlePower($oid, $note)
    {
        //查询该订单状态
        $status_info = PlaneTicketOrder::find()
            ->where(['id' => $oid])
            ->select([
                'process_status',//后台订单状态
                'insurance_num',//投保人数量
            ])
            ->asArray()
            ->one();
        $status = $status_info['process_status'];//后台订单状态
        //查询是否存在【出保】失败的乘机人
        $insurance_order_info = PlaneTicketOrderInsurance::find()
            ->where(['order_id' => $oid])
            ->select([
                'id',
                'order_status',//订单状态
            ])
            ->asArray()
            ->one();
        $insurance_id = $insurance_order_info['id'];
        if ($status_info['insurance_num'] > 0 && empty($insurance_id)) {//存在投保失败行为（投保人数量大于0，但是无保单信息）
            $emplane = 1;
        } else {
            if ($insurance_order_info['order_status'] == 6) {//此处新加的状态码6，是由于后台的回贴保号造成的，所以此状态下，订单也能操作回帖保号/人工补出保
                $emplane = 1;
            } else {
                $emplane = null;
            }
        }
        //查询是否存在【退保】失败的乘机人
        $emplane_refund_fail = PlaneTicketOrderInsuranceDetails::find()
            ->where([
                'ins_order_id' => $insurance_id,
            ])
            ->andWhere(['OR',
                ['refund_insurance_status' => 2],//退保失败（0未退保，1退保成功，2退保失败）
                ['refund_insurance_status' => 0]//发生退票行为，但是保险的退保状态还保留为0<无退保>
            ])
            ->select(['id'])
            ->asArray()
            ->all();
        $result_info = [];
        //$note=handle（订单列表页点击了操作） or $note=null（订单列表页点击了查看）
        if (!empty($note)) {//$note=handle，用户点击修改按钮，赋值相应的修改权限
            switch ($status) {
                /**
                 * @回贴票号权限
                 */
                case 21://已支付待出票（待出票-用户已支付,机票待生单）
                    $result_info = [
                        'reset_ticket_note' => 'refund_ticket',//回贴票号权限
                        'post_reset_note' => 'post',//修改邮寄地址权限
                    ];
                    break;
                case 22://已支付待出票（待出票-机票生单成功,机票待支付）
                    $result_info = [
                        'reset_ticket_note' => 'refund_ticket',//回贴票号权限
                        'post_reset_note' => 'post',//修改邮寄地址权限
                    ];
                    break;
                case 23://已支付待出票（待出票-机票支付成功,机票待出票）
                    $result_info = [
                        'reset_ticket_note' => 'refund_ticket',//回贴票号权限
                        'post_reset_note' => 'post',//修改邮寄地址权限
                    ];
                    break;
                case 29://已支付待出票（待出票-机票异步通知成功(机票出票完成),机票部分未出票(机票部分出票失败)）
                    $result_info = [
                        'reset_ticket_note' => 'refund_ticket',//回贴票号权限
                        'post_reset_note' => 'post',//修改邮寄地址权限
                    ];
                    break;
                /**
                 * @人工补票 + 回贴票号
                 */
                case 25://已支付待出票
                    $result_info = [
                        'artificial_ticket_note' => 'refund_ticket',//人工补票
                        'refund_ticket_note' => 'refund_ticket',//退款权限
                        'post_reset_note' => 'post',//修改邮寄地址权限
                    ];
                    break;
                case 26://已支付待出票
                    $result_info = [
                        'artificial_ticket_note' => 'refund_ticket',//人工补票
                        'refund_ticket_note' => 'refund_ticket',//退款权限
                        'post_reset_note' => 'post',//修改邮寄地址权限
                    ];
                    break;
                /**
                 * @人工退款操作权限
                 */
                case 38://已退票未退款
                    if (!empty($emplane)) {//出保失败乘客不为空
                        $result_info = [
                            'add_insurance_code' => 'add_insurance_code',//补出保权限
                            'refund_ticket_note' => 'refund_ticket',//退款权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    } else {
                        $result_info = [
                            'refund_ticket_note' => 'refund_ticket',//退款权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    }
                    break;
                case 47://已退票-全部退票成功,对用户原路退款失败
                    if (!empty($emplane_refund_fail)) {//退保失败乘客不为空
                        $result_info = [
                            'refund_insurance_service' => 'refund_insurance_service',//操作退保权限
                            'refund_ticket_note' => 'refund_ticket',//退款权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    } else {
                        $result_info = [
                            'refund_ticket_note' => 'refund_ticket',//退款权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    }
                    break;
                case 53://已退票未退款
                    $result_info = [
                        'refund_ticket_note' => 'refund_ticket',//退款权限
                        'post_reset_note' => 'post',//修改邮寄地址权限
                    ];
                    break;
                case 27://已退票未退款
                    $result_info = [
                        'refund_ticket_note' => 'refund_ticket',//退款权限
                        'post_reset_note' => 'post',//修改邮寄地址权限
                    ];
                    break;
                /**
                 * @已出票未出保
                 */
                case 24://2.4.待出票-机票异步通知成功(机票全部出票完成),机票出保成功;即 3.1.已出票
                    if (!empty($emplane)) {//出保失败乘客不为空
                        $result_info = [
                            'reset_insurance_note' => 'reset_insurance',//回帖保单号权限
                            'add_insurance_code' => 'add_insurance_code',//补出保权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    } else {
                        $result_info = [
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    }
                    break;
                case 31://已出票-(机票全部出票成功,不管出保是否成功还是失败)
                    if (!empty($emplane)) {//出保失败乘客不为空
                        $result_info = [
                            'reset_insurance_note' => 'reset_insurance',//回帖保单号权限
                            'add_insurance_code' => 'add_insurance_code',//补出保权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    } else {
                        $result_info = [
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    }
                    break;
                case 34://已出票-部分退票成功,等待对用户退款
                    if (!empty($emplane)) {//出保失败乘客不为空
                        $result_info = [
                            'reset_insurance_note' => 'reset_insurance',//回帖保单号权限
                            'add_insurance_code' => 'add_insurance_code',//补出保权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    } else {
                        $result_info = [
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    }
                    break;
                case 35://已出票-部分退票成功,对用户原路退款成功
                    if (!empty($emplane)) {//出保失败乘客不为空
                        $result_info = [
                            'reset_insurance_note' => 'reset_insurance',//回帖保单号权限
                            'add_insurance_code' => 'add_insurance_code',//补出保权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    } else {
                        $result_info = [
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    }
                    break;
                case 36://已出票-部分退票申请失败 (部分退票申请或全部退票申请,若失败,目前可重复申请)--即状态修改为 3.1.已出票
                    if (!empty($emplane)) {//出保失败乘客不为空
                        $result_info = [
                            'reset_insurance_note' => 'reset_insurance',//回帖保单号权限
                            'add_insurance_code' => 'add_insurance_code',//补出保权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    } else {
                        $result_info = [
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    }
                    break;
                case 37://已出票-部分退票申请成功,退票被拒绝(失败=拒绝) (可尝试重复申请退票)
                    if (!empty($emplane)) {//出保失败乘客不为空
                        $result_info = [
                            'reset_insurance_note' => 'reset_insurance',//回帖保单号权限
                            'add_insurance_code' => 'add_insurance_code',//补出保权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    } else {
                        $result_info = [
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    }
                    break;
                case 45://已退票-全部退票申请失败 (部分退票申请或全部退票申请,若被拒绝,目前可重复申请)--即状态修改为 3.1.已出票
                    if (!empty($emplane)) {//出保失败乘客不为空
                        $result_info = [
                            'reset_insurance_note' => 'reset_insurance',//回帖保单号权限
                            'add_insurance_code' => 'add_insurance_code',//补出保权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    } else {
                        $result_info = [
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    }
                    break;
                case 46://已退票-全部退票申请成功,退票被拒绝(失败=拒绝) (可尝试重复申请退票)
                    if (!empty($emplane)) {//出保失败乘客不为空
                        $result_info = [
                            'reset_insurance_note' => 'reset_insurance',//回帖保单号权限
                            'add_insurance_code' => 'add_insurance_code',//补出保权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    } else {
                        $result_info = [
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    }
                    break;
                /**
                 * @已退票未退保
                 */
                case 43://已退票-全部退票成功,等待对用户退款
                    if (!empty($emplane_refund_fail)) {//退保失败乘客不为空
                        $result_info = [
                            'refund_insurance_service' => 'refund_insurance_service',//操作退保权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    } else {
                        $result_info = [
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    }
                    break;
                case 44://已退票-全部退票成功,对用户原路退款成功
                    if (!empty($emplane_refund_fail)) {//退保失败乘客不为空
                        $result_info = [
                            'refund_insurance_service' => 'refund_insurance_service',//操作退保权限
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    } else {
                        $result_info = [
                            'post_reset_note' => 'post',//修改邮寄地址权限
                        ];
                    }
                    break;
                /**
                 * @默认修改邮寄地址权限
                 */
                default:
                    $result_info = [
                        'post_reset_note' => 'post',//修改邮寄地址权限
                    ];
                    break;
            }
        }
        return $result_info;
    }
    /**
     * @追加退保标记
     */
    public static function RefundInsuranceNote($emplane_info)
    {
        foreach ($emplane_info as $k => $value) {
            //查询出乘机人对应的保险状态（是保险状态，不是申请退保状态）
            $insurance_status = PlaneTicketOrderInsuranceDetails::find()
                ->where([
                    'name' => $value['name'],//姓名
                    'cert_code' => $value['card_no'],//证件号码
                ])
                ->select(['refund_insurance_status'])
                ->scalar();
            if ($insurance_status === '0' || $insurance_status === '2') {//可退保状态（正常 + 退保失败）
                $emplane_info[$k]['refund_note'] = 'ys';
            }
        }
        return $emplane_info;
    }
    /**
     * Displays a single PlaneTicketOrder model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PlaneTicketOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PlaneTicketOrder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PlaneTicketOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing PlaneTicketOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PlaneTicketOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PlaneTicketOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlaneTicketOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * @修改订单邮寄地址
     */
    public function actionResetAddress()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('data');
            $update_data = [
                'express_addressee_address' => $data['address'],
                'update_time'               => date('Y-m-d H:i:s'),
                'admin_id'                  => Yii::$app->user->getId()
            ];
            $status = SearchSql::_UpdateSqlExecute('plane_ticket_order', $update_data, ['id' => $data['id']]);
            if ($status) {
                return 'success';
            } else {
                return '修改失败！';
            }
        } else {
            return '非法请求！';
        }
    }
    /**
     * @回贴票号
     */
    public function actionResetTicketCode()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data');
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $update_data = [
                    'ticket_no'   => $data['code'],//机票票号
                    'update_time' => date('Y-m-d H:i:s'),//更改时间yyyy-mm-dd
                    'admin_id'    => Yii::$app->user->getId(),//后台操作人ID
                    'out_ticket_status' => 1,//出票成功
                ];
                $status = SearchSql::_UpdateSqlExecute('plane_ticket_order_emplane', $update_data, ['id' => $data['id']]);
                if (!$status) {
                    throw new \Exception('update_emplane_table_abnormal');
                }
                $order_id = PlaneTicketOrderEmplane::find()
                    ->where(['id' => $data['id']])
                    ->select([
                        'order_id',
                    ])
                    ->asArray()
                    ->scalar();
                $total_info = self::PersonNum($order_id);
                //已贴票的数量
                $ticket_count = self::HandleDNum('ticket', $order_id);
                //只有所有的票数量补齐，保单数量补齐，才会执行订单状态流转的操作
                if ($total_info['guest_num'] <= $ticket_count) {//已贴票号跟乘机人数量一致，且状态为已支付待出票
                    $reset_data = [
                        'process_status' => 31,//出票/出保成功
                        'order_status'   => 3,//已出票
                        'update_time'    => date('Y-m-d H:i:s'),
                        'admin_id'       => Yii::$app->user->getId()
                    ];
                    $reset_status = SearchSql::_UpdateSqlExecute('plane_ticket_order', $reset_data, ['id' => $order_id]);
                    if (!$reset_status) {
                        throw new \Exception('update_order_table_abnormal');
                    }
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                $errInfo = $e->getMessage();
                $errMsg = [
                    'update_emplane_table_abnormal' => '修改失败！',
                    'update_order_table_abnormal'   => '修改失败！',
                    'order_status_abnormal'         => '修改失败！',
                ];
                return isset($errMsg[$errInfo])?$errMsg[$errInfo]:'服务器内部错误！';
            }
            return 'success';
        } else {
            return '非法请求！';
        }
    }
    /**
     * @获取机票订单信息中联系人的手机号 <单条>
     * @$params $oid:订单ID
     */
    public function GetPlaneTicketOrderInfo($oid)
    {
        $order_info = PlaneTicketOrder::find()
            ->where(['id' => $oid])
            ->select([
                'contacts_phone',//联系人手机号
                'fly_start_time',//起飞时间
                'fly_end_time',//降落时间
                'flight_number',//航班号
            ])
            ->one();
        return $order_info;
    }
    /**
     * @回帖保单号
     */
    public function actionResetInsuranceCode()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data');// [code=>保单号，id=>乘机人ID <即plane_ticket_order_emplane.id> ]
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $update_data = [
                    'insurance_no' => $data['code'],//要回帖的保单号
                    'update_time'  => date('Y-m-d H:i:s'),//操作时间yyyy-mm-dd
                    'admin_id'     => Yii::$app->user->getId()//后台操作人ID
                ];
                //------------修改乘机人表---------
                $status = SearchSql::_UpdateSqlExecute('plane_ticket_order_emplane', $update_data, ['id' => $data['id']]);
                if (!$status) {
                    throw new \Exception('update_emplane_table_abnormal');
                }
                //-----------查询归属机票订单ID------
                $ticket_emplane_info = PlaneTicketOrderEmplane::find()
                    ->where(['id' => $data['id']])
                    ->asArray()
                    ->one();
                $order_id = $ticket_emplane_info['order_id'];//机票订单ID
                $plane_order_info = $this->GetPlaneTicketOrderInfo($order_id);
                $insurance_supplier_id = $ticket_emplane_info['insurance_supplier_id'];//保险供应商ID
                $total_info = self::PersonNum($order_id);//返回的信息内包含有多条信息 <1.乘机人数量 2.投保人数量 3.订单详细状态>
                $insurance_count = self::HandleDNum('insurance', $order_id);//已贴保单的数量
                $insurance_id = $insurance_count['insurance_id'];//保险主表ID
                if ($insurance_count['count'] == 0) {//数量为0，说明需要在保险订单表内新加一条数据
                    $insurance_add_data = [
                        'order_id'     => $order_id,//订单ID
                        'supplier_id'  => $insurance_supplier_id,//保险供应商ID
                        'trade_no'     => '',//商户订单号
                        'out_trade_no' => $data['code'],//保险单号
                        'settlement_price' => $ticket_emplane_info['insurance_money'],//保险金额
                        'ins_person'   => $ticket_emplane_info['name'],//投保人
                        'ins_phone'    => $plane_order_info['contacts_phone'],//投保人手机号 <机票订单的联系人手机号>
                        'ins_cert_type'=> self::CardTypeToCerdType($ticket_emplane_info['card_type']),//乘机人证件类型
                        'ins_cert_code'=> $ticket_emplane_info['card_no'],//乘机人证件号
                        'insure_failed_msg' => '',//投保失败原因
                        'refund_insure_failed_msg' => '',//退保失败原因
                        'insurances'   => 'SnowBall',//保单明细
                        'create_time'  => date('Y-m-d H:i:s'),//创建时间
                        'admin_id'     => Yii::$app->user->getId(),//添加人
                        'ins_birth'    => $ticket_emplane_info['birthday'],//投保人生日
                        'order_status' => 6,//保单状态标记为部分出保
                    ];
                    //插入一条新的保险订单信息
                    $insurance_add_status = SearchSql::_InsertSqlExecute('plane_ticket_order_insurance', $insurance_add_data);
                    if (!$insurance_add_status) {
                        throw new \Exception('insert_insurance_table_info_abnormal');
                    }
                    //更新$insurance_id值
                    $insurance_id = Yii::$app->db->getLastInsertID();
                }
                //填充保险详情表前，先判定投保人信息是否已存在（存在的话就修改信息，不存在的话就添加信息）
                $insurance_person_info = PlaneTicketOrderInsuranceDetails::find()
                    ->where([
                        'ins_order_id' => $insurance_id,
                        'name'         => $ticket_emplane_info['name'],//投保人姓名
                        'cert_code'    => $ticket_emplane_info['card_no'],//乘机人证件号
                        'cert_type'    => self::CardTypeToCerdType($ticket_emplane_info['card_type']),//乘机人证件类型
                    ])
                    ->select(['id'])
                    ->asArray()
                    ->scalar();
                //填充（修改）保险订单详情表的数据 即plane_ticket_order_insurance_details表
                $detail_insert_or_update_data = [
                    'ins_order_id' => $insurance_id,//保险订单ID
                    'product_id'   => 114,//保险产品ID
                    'name'         => $ticket_emplane_info['name'],//投保人
                    'cert_type'    => self::CardTypeToCerdType($ticket_emplane_info['card_type']),//乘机人证件类型
                    'cert_code'    => $ticket_emplane_info['card_no'],//乘机人证件号
                    'mobile'       => $ticket_emplane_info['phone'],//手机号
                    'begin_date'   => $plane_order_info['fly_start_time'],//起飞时间
                    'sex'          => $ticket_emplane_info['gender'],//被保人性别
                    'birth'        => $ticket_emplane_info['birthday'],//投保人生日
                    'insurance_type' => 1,//保险类型，默认航意险
                    'end_date'     => $plane_order_info['fly_end_time'],//到达时间
                    'flight_no'    => $plane_order_info['flight_number'],//航班号
                    'insurance_no' => $data['code'],//保险单号
                    'insurance_status' => 1,//已投保
                    'ticket_no'    => $ticket_emplane_info['ticket_no'],//票号
                ];
                if (empty($insurance_person_info)) {//不存在，所以添加
                    //---此处比较已贴保单数量与投保人数量，根据一致和不一致做不同的修改
                    if (($insurance_count['count'] + 1) >= $total_info['insurance_num']) {//投保人数量和已贴保数量一致，修改保险主订单信息（订单状态）
                        $insurance_update_data = [
                            'order_status' => 3,
                            'up_admin_id'  => Yii::$app->user->getId(),//修改人
                            'update_time'  => date('Y-m-d H:i:s'),//修改时间
                        ];
                        $insurance_update_status = SearchSql::_UpdateSqlExecute('plane_ticket_order_insurance', $insurance_update_data, ['id' => $insurance_id]);
                        if (!$insurance_update_status) {
                            throw new \Exception('update_insurance_table_info_abnormal');
                        }
                    }
                    $detail_insert_or_update_data['create_time'] = date('Y-m-d H:i:s');//添加时间
                    $detail_insert_or_update_data['admin_id'] = Yii::$app->user->getId();//添加人
                    $detail_insert_or_update_status = SearchSql::_InsertSqlExecute('plane_ticket_order_insurance_details', $detail_insert_or_update_data);
                    if (!$detail_insert_or_update_status) {
                        throw new \Exception('insert_insurance_detail_table_info_abnormal');
                    }
                } else {//存在，进行修改
                    $detail_insert_or_update_data['update_time'] = date('Y-m-d H:i:s');//修改时间
                    $detail_insert_or_update_data['up_admin_id'] = Yii::$app->user->getId();//修改人
                    $detail_insert_or_update_status = SearchSql::_UpdateSqlExecute('plane_ticket_order_insurance_details',
                        $detail_insert_or_update_data,
                        ['id' => $insurance_person_info]
                    );
                    if (!$detail_insert_or_update_status) {
                        throw new \Exception('insert_insurance_detail_table_info_abnormal');
                    }
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                $errInfo = $e->getMessage();
                $errMsg = [
                    'update_emplane_table_abnormal'          => '修改失败！',
                    'insert_insurance_table_info_abnormal'   => '修改失败！',
                    'update_insurance_table_info_abnormal'   => '修改失败！',
                    'insert_insurance_detail_table_info_abnormal' => '修改失败!',
                ];
                return isset($errMsg[$errInfo])?$errMsg[$errInfo]:'服务器内部错误！';
            }
            return 'success';
        } else {
            return '非法请求！';
        }
    }
    /**
     * @获取订单乘机人总数/保险人总数
     */
    public static function PersonNum($oid)
    {
        $order_info = PlaneTicketOrder::find()
            ->where(['id' => $oid])
            ->select([
                'guest_num',
                'insurance_num',
                'process_status'
            ])
            ->asArray()
            ->one();
        return $order_info;
    }
    /**
     * @获取已贴票号/保单号的人数
     * @$note: ticket => 机票查询 ，insurance => 保险查询
     * @$oid: 订单ID <plane_ticket_order.id>
     */
    public static function HandleDNum($note, $oid)
    {
        if ($note == 'ticket') {//查询机票数
            $where = ['<>', 'ticket_no', ''];
            $count = PlaneTicketOrderEmplane::find()
                ->where(['order_id' => $oid])
                ->andWhere($where)
                ->count();
            return $count;
        } else {
            $insurance_id = PlaneTicketOrderInsurance::find()
                ->where(['order_id' => $oid])
                ->select(['id'])
                ->scalar();
            if (empty($insurance_id)) {//保险订单不存在，此时需要新建了
                $result_data = [
                    'count' => 0,//已投保数量
                    'insurance_id' => $insurance_id,//保险订单主表ID
                ];
                return $result_data;
            }
            $count = PlaneTicketOrderInsuranceDetails::find()
                ->where(['ins_order_id' => $insurance_id])
                ->andWhere(['<>', 'insurance_no', ''])
                ->count();
            $result_data = [
                'count' => $count,//已投保数量
                'insurance_id' => $insurance_id,//保险订单主表ID
            ];
            return $result_data;
        }

    }
    /**
     * @申请退保人信息列表
     */
    public function actionRefundPersonList()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data');
            $id_arr = explode(',', $data['id_str']);
            $emplane_info = PlaneTicketOrderEmplane::find()
                ->where(['in', 'id', $id_arr])
                ->select([
                    'name',
                    'ticket_no',
                    'insurance_no'
                ])
                ->asArray()
                ->all();
            return json_encode($emplane_info);
        } else {
            return '非法操作！';
        }
    }
    /**
     * @人工补票操作
     */
    public function actionPersonTicket()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data');
            $c_time = time();
            $c_sign = $this->ShaPlaneTicketValue($c_time);
            $url = PLANE_TICKET_URL."/adminoperation/supplyticket";
            $data = [
                'c_sign' => $c_sign,
                'c_time' => $c_time,
                'admin_id' => Yii::$app->user->getId(),
                'order_id' => $data['id']
            ];
            $return_info = $this->sub_post($url, $data);
            return json_encode($return_info);
        } else {
            return '非法操作！';
        }
    }
    /**
     * @ 订单退款操作
     */
    public function actionRefundOrderHandle()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data');
            //添加日志信息
            $insert_log_send_remark = PlaneTicketOrder::find()->where(['id' => $data['id']])->asArray()->one();
            $insert_log_send_remark_note = [
                'sys_note'       => 'send_submit',
                'id'             => $insert_log_send_remark['id'],//订单ID
                'order_no'       => $insert_log_send_remark['order_no'],//订单号
                'pay_status'     => $insert_log_send_remark['pay_status'],//支付状态
                'order_status'   => $insert_log_send_remark['order_status'],//订单主状态
                'process_status' => $insert_log_send_remark['process_status'],//详细状态
            ];
            $insert_log_data = [
                'order_id'    => $data['id'],//订单ID
                'remark'      => json_encode($insert_log_send_remark_note),//订单信息（转成json）
                'admin_id'    => Yii::$app->user->getId(),//操作人ID
                'create_time' => date('Y-m-d H:i:s'),//创建时间
            ];
            SearchSql::_InsertSqlExecute('plane_ticket_order_log', $insert_log_data);
            $c_time = time();
            $c_sign = $this->ShaPlaneTicketValue($c_time);
            $url = PLANE_TICKET_URL."/adminoperation/refundment";
            $datas = [
                'c_sign' => $c_sign,
                'c_time' => $c_time,
                'admin_id' => Yii::$app->user->getId(),
                'order_id' => $data['id']
            ];
            $return_info = $this->sub_post($url, $datas);
            if ($return_info['code'] == 0) {//人工退款成功
                try{
                    //获取订单详细状态
                    $plane_process_status = PlaneTicketOrder::find()
                        ->where(['id' => $data['id']])
                        ->select(['process_status'])
                        ->scalar();
                    if (empty($plane_process_status)) {
                        throw new \Exception('plane_ticket_order_process_status_null');//机票订单状态为空
                    }
                    $pay_status_arr = [25, 26];//已支付待出票
                    $refund_status_arr = [38, 47, 53, 27];//已退票未退款
                    if (in_array($plane_process_status, $pay_status_arr)) {//判断订单状态是否为 [已支付待出票状态]
                        $order_status_update_data = [
                            'pay_status'   => 4,//订单支付状态改为取消订单
                            'order_status' => 5,//订单主状态改为已取消
                            'process_status' => 51,//订单详细状态改为已取消
                        ];
                    } else if (in_array($plane_process_status, $refund_status_arr)) {//判断状态是否为 [已退票未退款状态]
                        $order_status_update_data = [
                            'order_status' => 4,//订单主状态改为已退票
                            'process_status' => 44,//已退票-全部退票成功,对用户原路退款成功
                        ];
                    } else {
                        throw new \Exception('plane_ticket_order_process_status_abnormal');//机票订单状态异常（不包含在人工退款操作内）
                    }
                    $order_status_update_data['update_time'] = date('Y-m-d H:i:s');//操作退款时间时间
                    $order_status_update_data['admin_id'] = Yii::$app->user->getId();//后台操作人ID
                    $plane_order_update_status = SearchSql::_UpdateSqlExecute('plane_ticket_order', $order_status_update_data, ['id' => $data['id']]);
                    if (!$plane_order_update_status) {//修改状态出现异常
                        throw new \Exception('plane_ticket_order_update_status_abnormal');
                    }
                    $insert_log_success_remark_note = [
                        'sys_note'       => 'submit_success',
                        'id'             => $data['id'],//订单ID
                        'pay_status'     => $order_status_update_data['pay_status'],//支付状态
                        'order_status'   => $order_status_update_data['order_status'],//订单主状态
                        'process_status' => $order_status_update_data['process_status'],//详细状态
                    ];
                    //添加日志信息
                    $insert_log_success_data = [
                        'order_id'    => $data['id'],//订单ID
                        'remark'      => json_encode($insert_log_success_remark_note),//订单信息（转成json）
                        'admin_id'    => Yii::$app->user->getId(),//操作人ID
                        'create_time' => date('Y-m-d H:i:s'),//创建时间
                    ];
                    SearchSql::_InsertSqlExecute('plane_ticket_order_log', $insert_log_success_data);
                    return json_encode($return_info);
                } catch (\Exception $e) {
                    $insert_log_abnormal_remark = PlaneTicketOrder::find()->where(['id' => $data['id']])->asArray()->one();
                    $insert_log_abnormal_remark_note = [
                        'sys_note'       => 'submit_success_&&_insert_abnormal',
                        'id'             => $insert_log_abnormal_remark['id'],//订单ID
                        'order_no'       => $insert_log_abnormal_remark['order_no'],//订单号
                        'pay_status'     => $insert_log_abnormal_remark['pay_status'],//支付状态
                        'order_status'   => $insert_log_abnormal_remark['order_status'],//订单主状态
                        'process_status' => $insert_log_abnormal_remark['process_status'],//详细状态
                    ];
                    //添加日志信息
                    $insert_log_abnormal_data = [
                        'order_id'    => $data['id'],//订单ID
                        'remark'      => json_encode($insert_log_abnormal_remark_note),//订单信息（转成json）
                        'admin_id'    => Yii::$app->user->getId(),//操作人ID
                        'create_time' => date('Y-m-d H:i:s'),//创建时间
                    ];
                    SearchSql::_InsertSqlExecute('plane_ticket_order_log', $insert_log_abnormal_data);
                    $errMsg = [
                        'plane_ticket_order_process_status_null'     => '订单状态异常！',
                        'plane_ticket_order_process_status_abnormal' => '订单状态异常！',
                        'plane_ticket_order_update_status_abnormal'  => '订单状态异常！',
                    ];
                    $return_data = [
                        'code' => 500,
                        'msg'  => isset($errMsg[$e->getMessage()]) ? $errMsg[$e->getMessage()] : 'service_abnormal',
                        'data' => ''
                    ];
                    return json_encode($return_data);
                }
            } else {//人工退款失败，返回失败信息
                $insert_log_fail_remark = PlaneTicketOrder::find()->where(['id' => $data['id']])->asArray()->one();
                $insert_log_fail_remark_note = [
                    'sys_note'       => 'submit_fial',
                    'id'             => $insert_log_fail_remark['id'],//订单ID
                    'order_no'       => $insert_log_fail_remark['order_no'],//订单号
                    'pay_status'     => $insert_log_fail_remark['pay_status'],//支付状态
                    'order_status'   => $insert_log_fail_remark['order_status'],//订单主状态
                    'process_status' => $insert_log_fail_remark['process_status'],//详细状态
                ];
                //添加日志信息
                $insert_log_fail_data = [
                    'order_id'    => $data['id'],//订单ID
                    'remark'      => json_encode($insert_log_fail_remark_note),//订单信息（转成json）
                    'admin_id'    => Yii::$app->user->getId(),//操作人ID
                    'create_time' => date('Y-m-d H:i:s'),//创建时间
                ];
                SearchSql::_InsertSqlExecute('plane_ticket_order_log', $insert_log_fail_data);
                return json_encode($return_info['data']['msg']);
            }
        } else {
            return '非法操作！';
        }
    }
    /**
     * @邮递公司名 id => name
     */
    public static function PostName($id)
    {
        $name = PlaneTicketExpressCompany::find()
            ->where(['id' => $id])
            ->select(
                ['name']
            )
            ->scalar();
        return $name;
    }
    /**
     * @详情页-回贴快递信息
     */
    public function actionResetPost()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data');
            $update_info = [
                'express_id'   => $data['company'],
                'express_code' => $data['code'],
                'update_time'  => date('Y-m-d H:i:s'),
                'admin_id'     => Yii::$app->user->getId(),
            ];
            $status = SearchSql::_UpdateSqlExecute('plane_ticket_order', $update_info, ['id' => $data['id']]);
            if ($status) {
                return 'success';
            } else {
                return '修改失败！';
            }
        } else {
            return '非法请求！';
        }
    }
    /**
     * @投保状态判定
     */
    public static function JudgeOrderInsuranceStatus($oid)
    {
        //未购保险
        $insurance_total_num = PlaneTicketOrder::find()
            ->where(['id' => $oid])
            ->select(['insurance_num'])
            ->scalar();
        if (empty($insurance_total_num)) {//订单不存在或者订单投保人数量为0 ->未购保险
            return '未购保';
        }
        //获取保险主表ID
        $insurance_info = PlaneTicketOrderInsurance::find()
            ->where(['order_id' => $oid])
            ->select([
                'id',//订单ID
                'order_status',//保险订单状态:1 新预定等待支付,2 支付完成,3 投保完成,4未退保（有申请没有完成的），5有退保（有退保成功的）6部分出保'
            ])
            ->one();
        $insurance_id = $insurance_info['id'];
        //退保失败（存在退保失败的保单）
        $refund_insurance_fail = PlaneTicketOrderInsuranceDetails::find()
            ->where(['ins_order_id' => $insurance_id])//该保险单下
            ->andWhere(['refund_insurance_status' => 2])//退保失败(0未退保，1退保成功，2退保失败)
            ->count();
        if (!empty($refund_insurance_fail)) {//存在退保失败的保单
            return '退保失败';
        }
        //已退保（投保人数为0 && 保险订单内有订单状态为有退保）
        $insurance_order_status = $insurance_info['order_status'];
        if ($insurance_total_num == 0 && $insurance_order_status == 5) {
            return '已退保';
        }
        //出保失败（投保人数为不为0 && 保险订单内没有订单信息）
        if (empty($insurance_id) && $insurance_total_num > 0) {//存在出保失败的保单
            return '出保失败';
        }
        //已出保（存在出保行为）
        if ($insurance_order_status == 3) {//投保成功
            return '已出保';
        }
        //部分出保
        if ($insurance_order_status == 6) {//部分出保
            return '部分出保';
        }
        return '-';
    }
    /**
     * @酒店 2.0 新增
     * @人工补出保
     */
    public function actionAddInsuranceService()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data', '');
            if (empty($data)) {
                return $this->ResponseJson(1,[],'请求异常！');
            }
            $id = $data['id'];//订单ID
            //查询出所有需要补出保的乘机人
            $refund_insurance_info = PlaneTicketOrderEmplane::find()
                ->where(['order_id' => $id])//该订单下所有保单支付信息
                ->andWhere(['<>', 'insurance_supplier_id', 0])//保险供应商ID不为空
                ->andWhere(['<>', 'insurance_money', 0])//保险金额不为0
                ->asArray()
                ->all();
//            dd($refund_insurance_info);
            //查询订单信息
            $order_info = PlaneTicketOrder::find()
                ->where(['id' => $id])
                ->select([
                    'insurance_supplier_id',//保险供应商ID
                    'city_start_name',//出发城市名
                    'city_end_name',//到达城市名称
                    'flight_number',//航班号
                    'fly_start_time',//起飞时间
                    'fly_end_time',//到达时间
                    'order_no',//订单号
                    'insurance_num',//保险总人数
                    'contacts_phone',//联系人手机号
                ])
                ->asArray()
                ->one();
            if (empty($order_info)) {
                return $this->ResponseJson(3,[],'请求异常！');
            }
            if (empty($refund_insurance_info) || empty($order_info['insurance_num'])) {//没有可执行补出保操作的乘机人
                return $this->ResponseJson(4,[],'请求异常！');
            }
            //获取保险产品ID
            $productId = PlaneTicketInsuranceGoodsManage::find()
                ->where([
                    'supplier_id' => $refund_insurance_info[0]['insurance_supplier_id'], //保险供应商ID
                    'type' => $refund_insurance_info[0]['insurance_type'],//保险产品类型
                ])
                ->select(['goods_id'])
                ->scalar();
            //获取保险公司信息（保险公司名，供应商联系人手机号）
            $insurance_supplier_info = PlaneTicketSupplier::find()
                ->where(['id' => $refund_insurance_info[0]['insurance_supplier_id']])//保险供应商ID
                ->select([
                    'name',//供应商名称
                    'contacts_phone',//供应商联系人手机号
                ])
                ->asArray()
                ->one();
            $insurnace_person_list = [];
            //循环填充出保人信息list，$refund_insurance_info为筛选过的乘机人<投保人>信息，对此进行二次整合
            foreach ($refund_insurance_info as $val) {
                //处理证件类型
                $card_type = function () use ($val) {
                    $change_model = self::CardTypeToCerdType($val['card_type']);
                    return $change_model;
                };
                $birth   = $val['birthday'];//投保人生日
                $ids     = $val['card_no'];//证件号
                $id_type = $card_type($val);//0身份证 证件类型
                $name    = $val['name'];//被保人姓名
                //对信息进行整理，整合为投保人list信息数组
                $insurnace_person_list[] = [
                    'productId'     => $productId,
                    'name'          => $name, //被保人姓名
                    'certType'      => $id_type,//0身份证 证件类型
                    'certCode'      => $ids,//证件号
                    'mobile'        => $val['phone'],//手机号
                    'beginDate'     => $order_info['fly_start_time'], //保险起保时间，如果是航意险，对应航班起飞时间，必填项航班起飞时间(Y-m-d H:i:s)
                    'sex'           => $val['gender'],//承保人性别 0 男 =1 女
                    'birthday'      => $birth,//投保人生日,//承保人生日 Y-m-d
                    'insuranceType' => $val['insurance_type'],//保险类型   航意险=1 人身意外险=2 旅游险=3 家财险=4 航延险=6 交通意外险=7
                    'endDate'       => $order_info['fly_end_time'],//到达时间，延误险必填项，对应航班到达目的地时间 航班到达(Y-m-d H:i:s)
                    'flightNo'      => $order_info['flight_number'],//航班号
                    'startAddress'  => $order_info['city_start_name'],//出发地
                    'endAddress'    => $order_info['city_end_name'],//到达地
                    'pnr'           => 'pnr',
                    'ticketNo'      => $val['ticket_no'],//票号
                    'param'         => [],
                ];
            }
            $pay_type = PLANE_INSURANCE_PAY_TYPE;//1= 自动支付 2= 不自动支付
            $orderNum = createOrderNo21();//保险订单号
            $mobile   = $order_info['contacts_phone'];//联系人手机号（机票订单联系人手机号）
            //整理为请求数据
            $params = [
                'agencyCode' => PLANE_INSURANCE_COMPANY_CODE,
                'sign' => strtolower(md5(PLANE_INSURANCE_COMPANY_CODE.$birth.$ids.$id_type.$name.$pay_type.$orderNum.$mobile.PLANE_INSURANCE_COMPANY_SAFE_CODE)),
                'outPolicyNo' => $orderNum,
                'insurancePerson' => $name,
                'phone' => $mobile,
                'birthday' => $birth,
                'certType' => $id_type,
                'certCode' => $ids,
                'orderUrl' => '106.14.16.252 ',//订单变更url 必填项 第三方暂不可用
                'isPay' => $pay_type,
                'insurances' => $insurnace_person_list,
                'isDetails' => 1,
                'param' => [],
            ];
            //此处调用PHP-planeticket端口框架中出保接口
            $c_time = time();
            $c_sign = $this->ShaPlaneTicketValue($c_time);
            $url = PLANE_TICKET_URL."/insurance/create-order-by-insure";//此接口只会调用第三方的出保接口，但是业务逻辑处理还是需要后台操作
            $data = [
                'c_sign' => $c_sign,//加密token
                'c_time' => $c_time,//请求时间戳
                'params' => $params,//请求参数
            ];
            $json_info = $this->sub_post($url, $data);
            //--------------测试数据----------------
//            $json_info = [
//                'code' => 0,
//                'msg'  => 'success',
//                'data' => [
//                    'returnCode' => 'S',
//                    'insurances' => [
//                        "beginDate"=> "2017-12-31 07:25:00",
//                        "birthday" => "19930304",
//                        "certCode" => "13020319930304452X",
//                        "certType" => 1,
//                        "endDate" => "2017-12-31 07:25:00",
//                        "insuranceNo" => "007369419374158",
//                        "insuranceStatus" => 1,
//                        "insuranceType" => 1,
//                        "name" => "测试",
//                        "param" => [],
//                        "productId" => 114,
//                        "ticketNo" => "111"
//                    ],
//                    'orderNo'=> 'BX201711261528544926694926',
//                    'orderStatus' => 1,
//                    'outOrderNo' => '20171126773d7b71dd105',
//                    'param' => [
//
//                    ],
//                    'settlementPrice' => 4.5
//                ]
//            ];
            //判断请求接口是否成功（code判定请求接口是否成功，returnCode判断补出保是否成功）
            if ($json_info['code'] == 0 && $json_info['data']['returnCode'] === 'S') {//请求补出保成功，添加保险订单信息，保险订单详情信息
                $transaction = Yii::$app->db->beginTransaction();
                try{
                    //插入保险订单表 plane_ticket_order_insurance 表一条数据
                    $insurance_add_data = [
                        'order_id'     => $id,//订单ID
                        'supplier_id'  => $order_info['insurance_supplier_id'],//保险供应商ID
                        'trade_no'     => $json_info['data']['outOrderNo'],//保险商户订单号（我方生成的保险单号）
                        'out_trade_no' => $json_info['data']['orderNo'],//第三方保险单号（三方保险公司生成的保险单号）
                        'settlement_price' => $json_info['data']['settlementPrice'],//保险金额
                        'ins_person'   => $name,//投保人
                        'ins_phone'    => $mobile,//投保人手机号 <机票订单的联系人手机号>
                        'ins_cert_type'=> $id_type,//乘机人证件类型
                        'ins_cert_code'=> $ids,//乘机人证件号
                        'insure_failed_msg' => '',//投保失败原因
                        'refund_insure_failed_msg' => '',//退保失败原因
                        'insurances'   => json_encode($json_info['data']['insurances'], JSON_UNESCAPED_UNICODE),//保单明细
                        'create_time'  => date('Y-m-d H:i:s'),//创建时间
                        'admin_id'     => Yii::$app->user->getId(),//添加人
                        'ins_birth'    => $birth,//投保人生日
                        'order_status' => 3,//保单状态：1 新预定等待支付,2 支付完成,3 投保完成,4未退保（有申请没有完成的），5有退保（有退保成功的） 6部分出保<后台回帖保号专用>
                        'request_data' => json_encode($params, JSON_UNESCAPED_UNICODE),//请求参数
                        'ins_price'    => $refund_insurance_info[0]['insurance_money'],//保费金额
                    ];
                    $insurance_add_status = SearchSql::_InsertSqlExecute('plane_ticket_order_insurance', $insurance_add_data);
                    if (!$insurance_add_status) {
                        throw new \Exception('insert_insurance_table_info_abnormal');
                    }
                    //获取刚添加的数据信息的id值，即 plane_ticket_order_insurance.id
                    $insurance_id = Yii::$app->db->getLastInsertID();
                    //----填充保险订单详情表的数据 即plane_ticket_order_insurance_details表-----
                    //处理需要填充 name 数组
                    $detail_insert_name_data = [
                        'ins_order_id',//保险订单ID
                        'product_id',//保险产品ID
                        'name',//投保人
                        'cert_type',//乘机人证件类型
                        'cert_code',//乘机人证件号
                        'mobile',//手机号
                        'begin_date',//起飞时间
                        'sex',//被保人性别
                        'birth',//投保人生日
                        'insurance_type',//保险类型，默认航意险
                        'end_date',//到达时间
                        'flight_no',//航班号
                        'insurance_no',//保险单号
                        'ticket_no',//票号
                        'pnr',//如果是航意险、航延险填写 pnr
                        'start_address',//出发地
                        'end_address',//目的地
                        'insurance_status',//投保状态: 0未投保 1已投保 2投保失败
                        'create_time',//添加时间
                        'admin_id',//添加人
                    ];
                    //整合每个人对应的个人数据（性别、手机号）
                    $person_info = [];
                    foreach ($insurnace_person_list as $item) {
                        $sha_key = $this->CodeNameToShaPersonInfo($item['name'], $item['certCode']);//获取唯一个人信息识别码（姓名+证件号）
                        $person_info = [
                            $sha_key => [
                                'sex'    => $item['sex'],//性别
                                'mobile' => $item['mobile'],//手机号
                            ]
                        ];
                    }
                    //此处处理数组，返回的insurance信息，如果是一个投保人，就会是一个对象，即一维数组，如果是一人以上，则是一个二维数组，因此要将一维数组转化为二维数组
                    if (count($json_info['data']['insurances']) == count($json_info['data']['insurances'], 1)) {
                        $json_info_insurance = [];
                        $json_info_insurance[] = $json_info['data']['insurances'];
                    } else {
                        $json_info_insurance = $json_info['data']['insurances'];
                    }
                    //整理需要填充的数据数组
                    $detail_insert_value_data = [];
                    foreach ($json_info_insurance as $value) {
                        $detail_insert_value_data[] = [
                            $insurance_id,//保险订单ID
                            $productId,//保险产品ID
                            $value['name'],//投保人姓名
                            $value['certType'],//证件类型
                            $value['certCode'],//证件号
                            $person_info[$this->CodeNameToShaPersonInfo($value['name'], $value['certCode'])]['mobile'],//手机号
                            $order_info['fly_start_time'],//起飞时间
                            $person_info[$this->CodeNameToShaPersonInfo($value['name'], $value['certCode'])]['sex'],//性别
                            date('Y-m-d', strtotime($value['birthday'])),//投保人生日
                            $value['insuranceType'],//保险类型
                            $order_info['fly_end_time'],//到达时间
                            $order_info['flight_number'],//航班号
                            $value['insuranceNo'],//保险单号
                            $value['ticketNo'],//票号
                            (($value['insuranceType'] == 1 || $value['insuranceType'] == 6) ? 'pnr' : ''),//pnr 如果是航意险(1)、航延险(6)填写pnr
                            $order_info['city_start_name'],//出发城市（汉字）
                            $order_info['city_end_name'],//到达城市（汉字）
                            1,//投保状态 <0未投保 1已投保 2投保失败>
                            date('Y-m-d H:i:s'),//添加时间
                            Yii::$app->user->getId(),//后台添加人
                        ];
                        //修改乘机人表内的保单信息字段，即 plane_ticket_order_emplane.insurance_no（修改条件：[该航班下]的[某某人]及其[证件信息]）
                        $emplane_insurance_no_update_data = [
                            'insurance_no' => $value['insuranceNo'],//保险单号
                            'update_time'  => date('Y-m-d H:i:s'),//修改时间
                            'admin_id'     => Yii::$app->user->getId(),//后台修改人
                        ];
                        $emplane_insurance_no_update_status = SearchSql::_UpdateSqlExecute('plane_ticket_order_emplane',
                            $emplane_insurance_no_update_data,
                            [
                                'name'      => $value['name'],//乘机人姓名
                                'ticket_no' => $value['ticketNo'],//乘机票号
                                'card_no'   => $value['certCode']//证件号码
                            ]
                        );
                        if (!$emplane_insurance_no_update_status) {
                            throw new \Exception('update_plane_emplane_table_info_abnormal');
                        }
                    }
                    //将数据添加至 plane_ticket_order_insurance_detail 表
                    $insurance_detail_insert_status = SearchSql::_InsertManySqlExecute('plane_ticket_order_insurance_details',
                        $detail_insert_name_data,//键名信息
                        $detail_insert_value_data//键值信息
                    );
                    if (!$insurance_detail_insert_status) {
                        throw new \Exception('insert_insurance_detail_table_info_abnormal');
                    }
                    //以上全部无异常，发送补出保成功短信，提示相关乘机人出保成功
                    foreach ($json_info_insurance as $val) {
                        $sms_data = [
                            'insurance_name' => $insurance_supplier_info['name'],//保险公司名称
                            'emplane_name'   => $val['name'],//投保人姓名（乘机人姓名）
                            'insurance_code' => $val['insuranceNo'],//保险单号
                            'supplier_mobile' => $insurance_supplier_info['contacts_phone'],//保险公司咨询电话
                            'emplane_mobile'  => $person_info[$this->CodeNameToShaPersonInfo($val['name'], $val['certCode'])]['mobile'],//手机号
                        ];
                        $this->AddInsuranceSuccessSendSms($sms_data);
                    }
                    $transaction->commit();
                    $msg = '出保成功！';
                } catch (\Exception $e) {//请求补出保接口成功，系统内部操作异常，发送邮件通知相关负责人
                    $transaction->rollBack();
                    $errorMsg = $e->getMessage();
//                    dd($e->getLine());
                    dd($e->getMessage());
                    $MsgList = [
                        'insert_insurance_table_info_abnormal'        => '补出保失败！',
                        'insert_insurance_detail_table_info_abnormal' => '补出保失败！',
                        'update_plane_emplane_table_info_abnormal'    => '补出保失败！',
                    ];
                    $msg = isset($MsgList[$errorMsg]) ? $MsgList[$errorMsg] : '服务器异常！';
                    //请求补出保接口成功，但是出保失败，发送邮件通知相关负责人
                    //补出保已成功，但是修改相关保险信息时出现错误，记录错误信息，并发送通知邮件
                    $post_content = [
                        'fail_type'     => '请求补出保接口成功，修改保险信息异常（服务器内部异常）',//失败类型
                        'admin_id'      => Yii::$app->user->getId().'（后台操作人ID）',//操作人ID
                        'handle_date'   => date('Y-m-d H:i:s').'（操作时间）',//操作时间
                        'order_no'      => $order_info['order_no'].'（订单号）',//订单号
                        'abnormal_file' => $e->getFile(),//错误文件
                        'abnormal_line' => $e->getLine(),//错误位置
                        'fail_desc'     => $errorMsg,//错误描述（补出保失败原因）
                    ];
                    $post_data = [
                        'title' => '人工补出保请接口异常',
                        'content' => $post_content,
                    ];
                    $post_status = $this->SendPlaneInsuranceHandleAbnormalPost($post_data);
                    //邮件发送失败，写入日志系统
                    if (!$post_status) {
                        $this->PlaneTicketPostAbnormalWriteLogs($post_data, 'PlaneInsurancePostAbnormal/Add');
                    }
                }
                return $this->ResponseJson(0, [], $msg);
            } else {//请求补出保接口失败，发送邮件通知相关负责人
                //补出保失败原因
                $abnormalMsg = $json_info['data']['returnMessage'];
                $post_content = [
                    'fail_type'    => '请求补出保接口失败',//失败类型
                    'admin_id'     => Yii::$app->user->getId().'（后台操作人ID）',//操作人ID
                    'handle_date'  => date('Y-m-d H:i:s').'（操作时间）',//操作时间
                    'order_no'     => $order_info['order_no'].'（订单号）',//订单号
                    'fail_desc'    => $abnormalMsg.'（错误原因）',//错误描述（补出保失败原因）
                ];
                $post_data = [
                    'title' => '人工补出保请接口异常',
                    'content' => $post_content,
                ];
                $post_status = $this->SendPlaneInsuranceHandleAbnormalPost($post_data);
                //邮件发送失败，写入日志系统
                if (!$post_status) {
                    $this->PlaneTicketPostAbnormalWriteLogs($post_data, 'PlaneInsurancePostAbnormal/Add');
                }
                return $this->ResponseJson(0, [], '接口请求异常！');
            }
        } else {
            return '非法请求！';
        }
    }
    /**
     * @酒店 2.0 新增
     * @人工退保
     */
    public function actionRefundInsuranceService()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data');
            if (empty($data)) {
                return $this->ResponseJson(1, [], '请求异常！');
            }
            $id = $data['id'];//订单ID
            //乘机人ID（将字符串打散为数组）
            $emplane_id_arr = explode(',', $data['id_str']);
            //此处进行模拟post请求数据的拼装
            $request_data = [
                'orderId'          => $id,//订单ID
                'emplaneIdArr' => $emplane_id_arr,//乘机人emplne表id拼接成的array数组
            ];
            $c_time = time();
            $c_sign = $this->ShaPlaneTicketValue($c_time);
            $url = PLANE_TICKET_URL."/test-ins/go-refund";
            $data = [
                'c_sign' => $c_sign,//加密token
                'c_time' => $c_time,//请求时间戳
                'params' => $request_data,//请求参数
            ];
            $json_info = $this->sub_post($url, $data);
            if ($json_info['code'] == 0 && $json_info['data']['returnStatus'] === "Success") {//退保成功
                $code = 0;
                $msg = '操作成功！';
            } else {//请求退保接口失败，发送邮件通知相关负责人
                $code = 5;
                $msg = '退保失败！';
            }
            //判断是否所有出保失败的乘机人订单都已补出保成功（true:补出保成功，false:不出保失败）
            return $this->ResponseJson($code, [], $msg);
        } else {
            return '非法请求！';
        }
    }
}
