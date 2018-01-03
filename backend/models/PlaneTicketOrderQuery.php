<?php

namespace backend\models;

use function foo\func;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PlaneTicketOrder;

/**
 * PlaneTicketOrderQuery represents the model behind the search form about `backend\models\PlaneTicketOrder`.
 */
class PlaneTicketOrderQuery extends PlaneTicketOrder
{
    /**
     * @标记
     */
    public $express_money_post;
    public $ys_insurance_status;//订单保险状态
    public $receivables;//收款报表页标记
    public $refund_account;//退款报表页标记
    public $refund_time_search;//退款报表页-退款时间搜索
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_uid', 'ticket_supplier_id', 'insurance_supplier_id', 'order_source', 'pay_platform', 'pay_status', 'order_status', 'process_status', 'guest_num', 'insurance_num', 'admin_id'], 'integer'],
            [['order_no', 'payment_time', 'refund_time_search', 'flight_number', 'express_money_post', 'ys_insurance_status', 'abnormal_status', 'express_status', 'express_id', 'express_code', 'city_end_code', 'order_create_time', 'airline_company_code', 'supplier_name', 'flight_model', 'emplane_name', 'city_start_code', 'fly_start_time', 'fly_end_time', 'fly_start_airport', 'fly_end_airport', 'have_meals', 'stop_over_city', 'contacts', 'contacts_phone', 'express_addressee', 'express_addressee_address', 'express_addressee_tel', 'create_time', 'update_time', 'ticket_note'], 'safe'],
            [['dis_amount', 'pay_amount', 'total_amount', 'express_money'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PlaneTicketOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        //关联 plane_ticket_supplier 表
        $query->joinWith('company');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_uid' => $this->order_uid,
            'ticket_supplier_id' => $this->ticket_supplier_id,
            'insurance_supplier_id' => $this->insurance_supplier_id,
            'order_source' => $this->order_source,
            'pay_platform' => $this->pay_platform,
            'pay_status' => $this->pay_status,
            'order_status' => $this->order_status,
//            'process_status' => $this->process_status,
            'dis_amount' => $this->dis_amount,
            'pay_amount' => $this->pay_amount,
            'total_amount' => $this->total_amount,
//            'payment_time' => $this->payment_time,
            'city_start_code' => $this->city_start_code,
            'city_end_code' => $this->city_end_code,
            'airline_company_code' => $this->airline_company_code,
            'fly_start_time' => $this->fly_start_time,
            'fly_end_time' => $this->fly_end_time,
//            'express_money' => $this->express_money,
            'guest_num' => $this->guest_num,
            'insurance_num' => $this->insurance_num,
            'express_id' => $this->express_id,
//            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'admin_id' => $this->admin_id,
        ]);

        $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'flight_number', $this->flight_number])
            ->andFilterWhere(['like', 'flight_model', $this->flight_model])
            ->andFilterWhere(['like', 'fly_start_airport', $this->fly_start_airport])
            ->andFilterWhere(['like', 'fly_end_airport', $this->fly_end_airport])
            ->andFilterWhere(['like', 'have_meals', $this->have_meals])
            ->andFilterWhere(['like', 'stop_over_city', $this->stop_over_city])
            ->andFilterWhere(['like', 'contacts', $this->contacts])
            ->andFilterWhere(['like', 'contacts_phone', $this->contacts_phone])
            ->andFilterWhere(['like', 'express_addressee', $this->express_addressee])
            ->andFilterWhere(['like', 'express_addressee_address', $this->express_addressee_address])
            ->andFilterWhere(['like', 'express_code', $this->express_code])
            ->andFilterWhere(['like', 'express_addressee_tel', $this->express_addressee_tel]);
        //邮寄行程单列表展示前筛选，去除已出票订单中邮寄费用为0，即未勾选邮寄行程单服务的订单
        if (!empty($this->express_money_post)) {
            $query->andWhere(['<>', 'express_money', 0]);
        }
        //票号查询
        if (!empty($this->ticket_note)) {
            $query->joinWith('emplane');
            $query->andFilterWhere(['like', 'ticket_no', $this->ticket_note]);
        }
        //查询乘机人姓名
        if (!empty($this->emplane_name)) {
            $query->joinWith('emplane');
            $query->andFilterWhere(['like', 'plane_ticket_order_emplane.name', $this->emplane_name]);
        }
        //查询机票供应商
        if (!empty($this->supplier_name)) {
            $query->andFilterWhere(['plane_ticket_order.ticket_supplier_id' => $this->supplier_name]);
        }
        //下单时间查询
        if (!empty($this->order_create_time)) {
            $start_date = substr($this->order_create_time, 0, 10) . ' 00:00:00';
            $end_date = substr($this->order_create_time, 13) . ' 00:00:00';
            $query->andFilterWhere(['between', 'plane_ticket_order.create_time', $start_date, $end_date]);
        }
        //订单状态查询
        if (!empty($this->process_status)) {
            if ($this->process_status == 1) {//待支付
                $query->andWhere(['process_status' => 11]);
            }
            if ($this->process_status == 2) {//已支付待出票
                $query->andWhere(['OR',
                    ['process_status' => 21],
                    ['process_status' => 22],
                    ['process_status' => 23],
                    ['process_status' => 29],
                ]);
            }
            if ($this->process_status == 5) {//待退票
                $query->andWhere(['OR',
                    ['process_status' => 32],
                    ['process_status' => 33],
                    ['process_status' => 41],
                    ['process_status' => 42],
                ]);
            }
            if ($this->process_status == 6) {//出票异常
                $query->andWhere(['OR',
                    ['process_status' => 25],
                    ['process_status' => 26],
                ]);
            }
            if ($this->process_status == 9) {//已退票未退款
                $query->andWhere(['OR',
                    ['process_status' => 43],
                    ['process_status' => 47],
                ]);
            }
            if ($this->process_status == 10) {//出票成功
                $query->andWhere(['OR',
                    ['process_status' => 24],
                    ['process_status' => 31],
                    ['process_status' => 34],
                    ['process_status' => 35],
                    ['process_status' => 36],
                    ['process_status' => 37],
                    ['process_status' => 38],
                    ['process_status' => 45],
                    ['process_status' => 46],
                ]);
            }
            if ($this->process_status == 11) {//订单取消
                $query->andWhere(['OR',
                    ['process_status' => 27],
                    ['process_status' => 28],
                    ['process_status' => 51],
                    ['process_status' => 52],
                    ['process_status' => 53],
                ]);
            }
            if ($this->process_status == 12) {//退款完成
                $query->andWhere(['process_status' => 44]);
            }

        }
        /**
         * @异常订单页查询
         */
        if (!empty($this->abnormal_status)) {
//            dd($this->abnormal_status);
            if ($this->abnormal_status == 'three') {//退款失败
                $query->andWhere(['process_status' => [38, 47, 53]])
                    ->orderBy('plane_ticket_order.create_time DESC');
            } else if ($this->abnormal_status == 'four'){//出票失败
                $query->andWhere(['process_status' => [25, 26]])
                    ->orderBy('plane_ticket_order.create_time DESC');
            } else if ($this->abnormal_status == 'five'){//已出票未出保
                $query->andWhere(['process_status' => [24, 31, 34, 35, 36, 37, 38, 45, 46]])//出票成功
                    ->orderBy('plane_ticket_order.create_time DESC');
                $query->andWhere(['<>' ,'plane_ticket_order.insurance_num' ,0]);//投保数量不为0
                $sql = clone $query;
                $order_id_arr = $sql->select('plane_ticket_order.id')->asArray()->column();//符合（投保数量不为0）条件的订单ID组合[索引数组]
                $insurance_id_arr = PlaneTicketOrderInsurance::find()->where(['order_id' => $order_id_arr])->select('order_id')->asArray()->column();
                $query->andWhere(['NOT IN' ,'plane_ticket_order.id' , array_unique($insurance_id_arr)]);//保险方订单号为空
            } else if ($this->abnormal_status == 'six'){//已退票未退保
                $query->andWhere(['process_status' => [43, 47 ,44]])//已退票未退款、退款成功
                    ->orderBy('plane_ticket_order.create_time DESC');
                $query->joinWith('insuranceOrderDetails');
                $query->andWhere(['refund_insurance_status' => 2]);//退保状态 0未退保，1退保成功，2退保失败
            } else {//出票超时
                $query->andWhere(['process_status' => 212])
                    ->orderBy('plane_ticket_order.create_time ASC');
            }
        } else {
            $query->orderBy('plane_ticket_order.create_time DESC');
        }
        //订单保险状态筛选
        if (!empty($this->ys_insurance_status)) {
            if ($this->ys_insurance_status == 1) {//未购保
                $query->andWhere(['plane_ticket_order.insurance_num' => 0]);//投保数量为0
                $query->andWhere(['plane_ticket_order.pay_status' => 2]);//支付状态 1 待支付(用户行为的待支付),2 支付成功(只有支付成功才会有机票和保险订单数据,其余支付状态没有),3 支付失败,4 取消订单
            } else if ($this->ys_insurance_status == 2) {//已出保
                $query->andWhere(['plane_ticket_order.pay_status' => 2]);
                $query->joinWith('insuranceOrder');
                $query->andWhere(['plane_ticket_order_insurance.order_status' => 3]);//投保状态 1 新预定等待支付,2 支付完成,3 投保完成,4未退保（有申请没有完成的），5有退保（有退保成功的）
            } else if ($this->ys_insurance_status == 3) {//已退保
                $query->andWhere(['plane_ticket_order.pay_status' => 2]);
                $query->andWhere(['plane_ticket_order.insurance_num' => 0]);//投保数量为0
                $query->joinWith('insuranceOrder');
                $query->andWhere(['plane_ticket_order_insurance.order_status' => 5]);
            } else if ($this->ys_insurance_status == 4) {//出保失败
                $query->andWhere(['plane_ticket_order.pay_status' => 2]);
                $query->andWhere(['<>' ,'plane_ticket_order.insurance_num' ,0]);//投保数量不为0
                $sql = clone $query;
                $order_id_arr = $sql->select('plane_ticket_order.id')->asArray()->column();//符合（投保数量不为0）条件的订单ID组合[索引数组]
                $insurance_id_arr = PlaneTicketOrderInsurance::find()->where(['order_id' => $order_id_arr])->select('order_id')->asArray()->column();
                $query->andWhere(['NOT IN' ,'plane_ticket_order.id' , array_unique($insurance_id_arr)]);//保险方订单号为空
//                dd($query->createCommand()->getRawSql());
            } else if ($this->ys_insurance_status == 5) {//退保失败
                $query->andWhere(['OR',
                    ['plane_ticket_order.process_status' => 47],//已退票-全部退票成功,对用户原路退款失败
                    ['plane_ticket_order.process_status' => 43],//已退票-全部退票成功,等待对用户退款
                    ['plane_ticket_order.process_status' => 44],//已退票-全部退票成功,对用户原路退款成功
                ]);
                $query->joinWith('insuranceOrderDetails');
                $query->andWhere(['OR',
                    ['refund_insurance_status' => 2],//退保状态 0未退保，1退保成功，2退保失败
                    ['refund_insurance_status' => 0],//发生退票行为，但是保险的退保状态还保留为0<无退保>
                ]);
            } else {//部分出保
                $query->andWhere(['plane_ticket_order.pay_status' => 2]);
                $query->joinWith('insuranceOrder');
                $query->andWhere(['plane_ticket_order_insurance.order_status' => 6]);//1 新预定等待支付,2 支付完成,3 投保完成,4未退保（有申请没有完成的），5有退保（有退保成功的）6部分出保<后台回帖保号专用>
            }
        }
        //邮寄状态
        if (!empty($this->express_status)) {
            if ($this->express_status == 1) {//已邮寄
                $query->andWhere(['<>', 'express_code', '']);
            } else {//未邮寄
                $query->andWhere(['express_code' => '']);
            }
        }
        /**
         * @收款报表页查询关联标记
         */
        if (!empty($this->receivables)) {
            $query->joinWith('emplane');//关联乘机人表
            $query->joinWith('planeOrderPay');//关联机票支付记录表
            $query->joinWith('insurance');//关联保险支付记录表
            $query->joinWith('insuranceOrder');//关联保险订单主表
            //存在支付行为的(用户支付时间不为空)
            $query->andWhere(['<>', 'payment_time', '']);
        }
        /**
         * @退款报表也查询关联标记
         */
        if (!empty($this->refund_account)) {
            $query->joinWith('emplane');//关联乘机人表
            $query->joinWith('planeOrderPay');//关联机票支付记录表
            $query->joinWith('insurance');//关联保险支付记录表
            //关联机票退款记录表（第三方To Us）
            $query->with(['planeTicketRefundNot' => function ($query) {
                $query->where(['refundment_status' => 1])->orderBy('plane_ticket_order_ticket_refundment.create_time DESC');//退款状态:1 退款成功,2 退款失败
            }]);
            //三表关联，关联保险详情表
            $query->With(['insuranceOrderDetails' => function ($query) {
                $query->orderBy('plane_ticket_order_insurance_details.update_time ASC');
            }]);
            //关联用户申请退票记录表
            $query->with(['planeRefundTicket' => function ($query) {
                $query->orderBy('plane_ticket_order_refund_ticket.create_time ASC');
            }]);
            $query->andWhere(['process_status' => 44]);//已退票-全部退票成功,对用户原路退款成功
        }
        //支付时间筛选
        if (!empty($this->payment_time)) {
            $start_date = substr($this->payment_time, 0, 10) . ' 00:00:00';
            $end_date = substr($this->payment_time, 13) . ' 23:59:59';
            $query->andFilterWhere(['between', 'plane_ticket_order.create_time', $start_date, $end_date]);
        }
        //退款时间筛选
        if (!empty($this->refund_time_search)) {
            $start_date = substr($this->refund_time_search, 0, 10) . ' 00:00:00';
            $end_date = substr($this->refund_time_search, 13) . ' 23:59:59';
            $query->joinWith('planeTicketRefundNot');
            $query->andFilterWhere(['between', 'plane_ticket_order_ticket_refundment.create_time', $start_date, $end_date]);
        }
//        $query->asArray();
//        dd($query->createCommand()->getRawSql());
        return $dataProvider;
    }
}
