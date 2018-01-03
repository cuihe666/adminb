<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TravelOrderQuery represents the model behind the search form about `backend\models\TravelOrder`.
 */
class TravelOrderTwoQuery extends TravelOrder
{
    public $qrcode_id;  //付燕飞 2017年3月27日15:54:26添加  并在rules中设置qrcode_id 为safe
    public $is_first;
    public $is_firsts;
    public $ware_city;//商品城市
    public $local_type;//当地入口标记
    public $higo_type;//higo标记
    public $wait;//待处理标记
    public $already;//已完成标记
    public $contact_person;//总联系人标记
    public $order_state;//订单状态
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_uid', 'travel_uid', 'travel_id', 'adult', 'child', 'type', 'anum', 'refund_day', 'theme_type'], 'integer'],
            [['order_no', 'ware_city', 'contact_person', 'order_state', 'wait', 'already','refund_stauts', 'user_mobile', 'pay_platform','local_type','higo_type', 'is_confirm','theme_tag','user_name','trade_no', 'settle','refund_note', 'user_info', 'total_num', 'state', 'pay_state', 'activity_date', 'travel_name', 'title_pic', 'contacts', 'mobile_phone', 'create_time', 'confirm_time', 'close_account','qrcode_id','is_first','is_firsts'], 'safe'],
            [['coupon_amount', 'pay_amount', 'total', 'price'], 'number'],
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
        $query = TravelOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20,],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
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
            'travel_uid' => $this->travel_uid,
            'travel_id' => $this->travel_id,
//            'activity_date' => $this->activity_date,
//            'state' => $this->state,
//            'refund_stauts' => $this->refund_stauts,
            'adult' => $this->adult,
            'child' => $this->child,
            'coupon_amount' => $this->coupon_amount,
            'pay_amount' => $this->pay_amount,
            'total' => $this->total,
//            'pay_platform' => ,
            //'type' => $this->type,
//            'is_confirm' => $this->is_confirm,
//            'create_time' => $this->create_time,
            'anum' => $this->anum,
            'price' => $this->price,
            'confirm_time' => $this->confirm_time,
            'refund_day' => $this->refund_day,
            'theme_type' => $this->theme_type,
            'close_account' => $this->close_account
        ]);
        $query->andFilterWhere(['like', 'trade_no', $this->trade_no])
            ->andFilterWhere(['like', 'title_pic', $this->title_pic])
            ->andFilterWhere(['like', 'contacts', $this->contacts])
            ->andFilterWhere(['like', 'mobile_phone', $this->mobile_phone]);
        //refund_note(处理退款中订单)
//        if (empty($this->refund_note)) {
//            $query->andFilterWhere(['refund_stauts' => $this->refund_stauts]);
//        } else {
//            $query->andFilterWhere(['<>', 'refund_stauts', 52]);
//        }
        //结算订单详情
//        if (!empty($this->settle)) {
//            $query -> joinWith(['details']);
//            $query -> andWhere(['travel_settle_detail.settle_id' => $params['id']]);
//        }
        //待处理订单
        if (!empty($this->wait)) {
            //存在状态筛选
            if (!empty($this->state)) {
                if ($this->state == 31) {//待确认
                    $query->andWhere(['state' => 21, 'travel_order.is_confirm' => 1, 'refund_stauts' => '0']);
                } else if ($this->state == 11) {//待支付
                    $query->andWhere(['state' => '11']);
                } else if ($this->state == 51) {//待退款
                    $query->andWhere(['refund_stauts' => '51']);
                } else {
                    $query->andWhere(['state' => 21, 'travel_order.is_confirm' => 1, 'refund_stauts' => '0'])//待确认
                    ->orWhere(['state' => '11'])//待支付
                    ->orWhere(['refund_stauts' => '51']);//待退款
                }
            } else {
                $query->andWhere(['state' => 21, 'travel_order.is_confirm' => 1, 'refund_stauts' => '0'])//待确认
                ->orWhere(['state' => '11'])//待支付
                ->orWhere(['refund_stauts' => '51']);//待退款
            }
        }
        //总联系人
        if (!empty($this->contact_person)) {
            $query->andWhere(['travel_order.travel_name' => $params['travel_name']]);
        }
        if (!empty($this->order_state)) {
            $arr_info = explode('.', $this->order_state);
            $status = $arr_info[1];
            if ($arr_info[0] == 's') {//支付流程
                if ($status == 21) {//已支付
                    $query->andWhere(['travel_order.state' => $status, 'travel_order.is_confirm' => 0, 'travel_order.refund_stauts' => '0']);
                } else if ($status == 31) {//待确认
                    $query->andWhere(['travel_order.state' => 21, 'travel_order.is_confirm' => 1, 'travel_order.refund_stauts' => '0']);
                } else {
                    $query->andFilterWhere(['travel_order.state' => $status, 'travel_order.refund_stauts' => '0']);
                }
            } else {//退款流程
                $query->andFilterWhere(['travel_order.refund_stauts' => $status]);
            }
        }
        //已完成订单
        if (!empty($this->already)) {
            $query->andWhere(['or', ['refund_stauts' => 53], ['refund_stauts' => 54]]);
        }
        //当地活动
        if($this->type==2){
            $query->joinWith(['activity']);
            $query->andWhere(['travel_order.type' => 2]);
        }
        //主题线路
        if($this->type==3){
            $query->joinWith(['higo']);
            $query->andWhere(['travel_order.type' => 3]);
        }
        //当地向导
        if($this->type==5){
            $query->joinWith(['guide']);
            $query->andWhere(['travel_order.type' => 5]);
        }
        //支付方式
        if (!empty($this->pay_platform) || $this->pay_platform === '0') {
            $query->andWhere(['travel_order.pay_platform' => $this->pay_platform]);
        }
        //支付状态
        if (!empty($this->pay_state)) {
            if ($this->pay_state == 1) {
                $query->andWhere(['travel_order.trade_no' => '']);
            } else {
                $query->andWhere(['<>', 'travel_order.trade_no', '']);
            }
        }
        //用户电话
        if (!empty($this->user_mobile)) {
            $query -> joinWith(['user']);
            $query -> andWhere(['like','user.mobile', $this->user_mobile]);
        }
        //订单号查询
        if (!empty($this->order_no)) {
            $query->andWhere(['like', 'travel_order.order_no', $this->order_no]);

        }
        //用户昵称
        if (!empty($this->user_name)) {
            $query -> joinWith(['common']);
            $query -> andWhere(['like','user_common.nickname', $this->user_name]);
        }
        //商品名称
        if (!empty($this->travel_name)) {
            $query->andFilterWhere(['like', 'travel_order.travel_name', $this->travel_name]);
        }
        //是否确认
        if (!empty($this->is_confirm) || $this->is_confirm === '0') {
            $query->andWhere(['travel_order.is_confirm' => $this->is_confirm]);
        }
        //搜索城市
        if (!empty($this->theme_tag)) {
            $query -> joinWith(['activity']);
            $query -> joinWith(['higo']);
            $query -> andWhere(['OR', ['travel_higo.end_city' => $this->theme_tag ],['travel_activity.city_code' => $this->theme_tag]]);
        }
        //下单时间
        if (!empty($this->create_time)) {
            $start_date = substr($this->create_time, 0, 10) . ' 00:00:00';
            $end_date = substr($this->create_time, 13) . ' 00:00:00';
            $query->andFilterWhere(['between', 'travel_order.create_time', $start_date, $end_date]);
        }
        //体验日期
        if (!empty($this->activity_date)) {
            $start_time = substr($this->activity_date, 0, 10).' 00:00:00';
            $end_time = substr($this->activity_date, 13).' 00:00:00';
            $query->andFilterWhere(['between', 'travel_order.activity_date', $start_time, $end_time]);
        }
//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();die;
        return $dataProvider;
    }

}
