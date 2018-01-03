<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TravelOrder;

/**
 * TravelOrderQuery represents the model behind the search form about `backend\models\TravelOrder`.
 */
class TravelOrderQuery extends TravelOrder
{
    public $qrcode_id;  //付燕飞 2017年3月27日15:54:26添加  并在rules中设置qrcode_id 为safe
    public $is_first;
    public $is_firsts;
    public $ware_city;//商品城市
    public $local_type;//当地入口标记
    public $higo_type;//higo标记
    public $wait;//待处理标记
    public $travel_account;   //发布账号

    //@add 2017.07.07 14:47 pengyang
    public $COMMON_CALLEDTAG    = null;//凭该参数标记,做出对应的操作,可数组,可字符串
    public $COMMON_THEME_TYPE   = null;//专题活动ID
    public $COMMON_QRCODE_ID    = null;//专题活动下的二维码数据id
    public $idstr;        //订单id拼接

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_uid', 'travel_uid', 'travel_id', 'adult', 'child', 'pay_platform', 'type', 'anum', 'refund_day', 'theme_type'], 'integer'],
            [['order_no', 'ware_city', 'wait', 'refund_stauts', 'user_mobile', 'local_type', 'higo_type', 'is_confirm', 'theme_tag', 'user_name', 'trade_no', 'settle', 'refund_note', 'user_info', 'total_num', 'state', 'pay_state', 'activity_date', 'travel_name', 'title_pic', 'contacts', 'mobile_phone', 'create_time', 'confirm_time', 'close_account', 'qrcode_id', 'is_first', 'is_firsts','travel_account','idstr'], 'safe'],
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
            'pay_platform' => $this->pay_platform,
            'type' => $this->type,
//            'is_confirm' => $this->is_confirm,
//            'create_time' => $this->create_time,
            'anum' => $this->anum,
            'price' => $this->price,
            'confirm_time' => $this->confirm_time,
            'refund_day' => $this->refund_day,
            //'theme_type' => $this->theme_type,
            'close_account' => $this->close_account
        ]);

        $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'trade_no', $this->trade_no])
            ->andFilterWhere(['like', 'travel_name', $this->travel_name])
            ->andFilterWhere(['like', 'title_pic', $this->title_pic])
            ->andFilterWhere(['like', 'contacts', $this->contacts])
            ->andFilterWhere(['like', 'mobile_phone', $this->mobile_phone]);
        //待处理订单
//        if (!empty($this->wait)) {
//            //待确认
//            $query -> joinWith(['activity']);
//            $query -> joinWith(['higo']);
//            $query->andWhere(['travel_order.state' => 21])
//                ->andWhere(['travel_order.is_confirm' => 1])
//                ->andFilterWhere(['travel_order.refund_stauts' => '0'])
//                ->orWhere(['travel_order.refund_stauts' => '52'])//退款中
//                ->orWhere(['travel_order.refund_stauts' => '51']);//待退款
//        }

        //是否确认
        if (!empty($this->is_confirm)) {
            if (!empty($this->local_type)) {
                if ($this->is_confirm == 1) {
                    $query->andWhere(['travel_order.is_confirm' => 0]);
                } else {
                    $query->andWhere(['travel_order.is_confirm' => 1]);
                }
            } else if (!empty($this->higo_type)) {
                if ($this->is_confirm == 1) {
                    $query->andWhere(['travel_order.is_confirm' => 0]);
                } else {
                    $query->andWhere(['travel_order.is_confirm' => 1]);
                }
            } else {
                if ($this->is_confirm == 1) {
                    $query->andWhere(['travel_order.is_confirm' => 0]);
                } else {
                    $query->andWhere(['travel_order.is_confirm' => 1]);
                }
            }
        }
        //当地活动
        if (!empty($this->local_type)) {
            $query->joinWith(['activity']);
            $query->joinWith(['higo']);
            $query->andWhere(['travel_order.type' => 2]);
        }
        //主题线路
        if (!empty($this->higo_type)) {
            $query->joinWith(['activity']);
            $query->joinWith(['higo']);
            $query->andWhere(['travel_order.type' => 3]);
        }
        //用户电话
        if (!empty($this->user_mobile)) {
            $query->joinWith(['user']);
            $query->andWhere(['like', 'user.mobile', $this->user_mobile]);
        }
        //用户昵称
        if (!empty($this->user_name)) {
            $query->joinWith(['common']);
            $query->andWhere(['like', 'user_common.nickname', $this->user_name]);
        }
        //支付状态
        if (!empty($this->pay_state)) {
            if ($this->pay_state == 1) {
                $query->andWhere(['trade_no' => '']);
            } else {
                $query->andWhere(['<>', 'trade_no', '']);
            }
        }
        //订单状态
        if (!empty($this->state)) {
            $arr_info = explode('.', $this->state);
            $status = $arr_info[1];
            if (!empty($this->local_type)) {//当地活动
                if ($arr_info[0] == 's') {//支付流程
                    if ($status == 21) {//已支付
                        $query->andFilterWhere(['travel_order.state' => $status])
                            ->andWhere(['travel_order.is_confirm' => 0])
                            ->andFilterWhere(['travel_order.refund_stauts' => '0']);
                    } else if ($status == 31) {//待确认
                        $query->andWhere(['travel_order.state' => 21])
                            ->andWhere(['travel_order.is_confirm' => 1])
                            ->andFilterWhere(['travel_order.refund_stauts' => '0']);
                    } else {
                        $query->andFilterWhere(['travel_order.state' => $status])
                            ->andFilterWhere(['travel_order.refund_stauts' => '0']);
                    }
                } else {//退款流程
                    $query->andFilterWhere(['travel_order.refund_stauts' => $status]);
                }
            } else if (!empty($this->higo_type)) {//主题线路
                if ($arr_info[0] == 's') {//支付流程
                    if ($status == 21) {//已支付
                        $query->andFilterWhere(['travel_order.state' => $status])
                            ->andWhere(['travel_order.is_confirm' => 0])
                            ->andFilterWhere(['travel_order.refund_stauts' => '0']);
                    } else if ($status == 31) {//待确认
                        $query->andWhere(['travel_order.state' => 21])
                            ->andWhere(['travel_order.is_confirm' => 1])
                            ->andFilterWhere(['travel_order.refund_stauts' => '0']);
                    } else {
                        $query->andFilterWhere(['travel_order.state' => $status])
                            ->andFilterWhere(['travel_order.refund_stauts' => '0']);
                    }
                } else {//退款流程
                    $query->andFilterWhere(['travel_order.refund_stauts' => $status]);
                }
            } else {
                if ($arr_info[0] == 's') {//支付流程
                    if ($status == 21) {//已支付
                        $query->andFilterWhere(['state' => $status])
                            ->andWhere(['is_confirm' => 0])
                            ->andFilterWhere(['refund_stauts' => '0']);
                    } else if ($status == 31) {//待确认
                        $query->andWhere(['state' => 21])
                            ->andWhere(['is_confirm' => 1])
                            ->andFilterWhere(['refund_stauts' => '0']);
                    } else {
                        $query->andFilterWhere(['state' => $status])
                            ->andFilterWhere(['refund_stauts' => '0']);
                    }
                } else {//退款流程
                    $query->andFilterWhere(['refund_stauts' => $status]);
                }
            }
        }
        //refund_note(处理退款中订单)
        if (empty($this->refund_note)) {
            $query->andFilterWhere(['refund_stauts' => $this->refund_stauts]);
        } else {
            $query->andFilterWhere(['<>', 'refund_stauts', 52]);
        }
        //结算订单详情
        if (!empty($this->settle)) {
            $query->joinWith(['details']);
            $query->andWhere(['travel_settle_detail.settle_id' => $params['id']]);
        }
        //体验日期
        if (!empty($this->activity_date)) {
            $start_time = substr($this->activity_date, 0, 10) . ' 00:00:00';
            $end_time = substr($this->activity_date, 13) . ' 00:00:00';
            $query->andFilterWhere(['between', 'travel_order.activity_date', $start_time, $end_time]);
        }
        //下单时间
        if (!empty($this->create_time)) {
            $start_date = substr($this->create_time, 0, 10) . ' 00:00:00';
            $end_date = substr($this->create_time, 13) . ' 00:00:00';
            $query->andFilterWhere(['between', 'travel_order.create_time', $start_date, $end_date]);
        }
        //搜索城市
        if (!empty($this->theme_tag)) {
            $query->joinWith(['activity']);
            $query->joinWith(['higo']);
            $query->andWhere(['OR', ['travel_higo.end_city' => $this->theme_tag], ['travel_activity.city_code' => $this->theme_tag]]);
        }

        //发布账号
        if (!empty($this->travel_account)) {
            $query->joinwith("travelUser AS travel_user", true, 'LEFT JOIN');
            $query->joinwith("travelCommon AS travel_user_common", true, 'LEFT JOIN');
//@update 2017.07.07 15:23 pengyang 下面的写法造成和 之前(上面代码) 有过的关联user表已重名并造成报错,搜索条件为:用户电话/用户昵称/发布账号 搜索条件都存在时,就会报user表重复的错
//            $query->joinWith(['travelUser']);
//            $query->joinWith(['travelCommon']);
            $query->andWhere([
                'or',
                ['like','travel_user.mobile',$this->travel_account],
                ['like','travel_user_common.nickname',$this->travel_account],
            ]);
        }
        //订单来源
        //@update 2017-.07.07 14:52 pengyang 增加调用该搜索条件逻辑的标记处理
        if(is_string($this->COMMON_CALLEDTAG)){
            switch($this->COMMON_CALLEDTAG){
                //专题活动-专题管理-二维码管理-订单统计-筛选条件使用
                //详见后台控制器:ThematicQrcodeController.actionOrdertotal() 方法需要调用该筛选条件
                case 'ThematicQrcode_Ordertotal':
                    $query->andFilterWhere([
                        'travel_order.theme_type'   =>  $this->COMMON_THEME_TYPE,
                        'travel_order.qrcode_id'    =>  $this->COMMON_QRCODE_ID,
                    ]);
                break;
            }
        }else{
            //echo "bbb---".$this->theme_type."---aaaaaaaa";
            if ($this->theme_type!="") {
                if($this->theme_type==0)
                    $query->andWhere(['travel_order.theme_type' => 0]);
                else
                    $query->andWhere(['>', 'travel_order.theme_type', 0]);
            }
        }

//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();
//        exit;

        return $dataProvider;
    }


    public function searchNew($params)
    {
        $query = TravelOrder::find();
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
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_uid' => $this->order_uid,
            'travel_uid' => $this->travel_uid,
            'travel_id' => $this->travel_id,
            'pay_platform' => $this->pay_platform,
        ]);

        $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'trade_no', $this->trade_no])
            ->andFilterWhere(['like', 'travel_name', $this->travel_name])
            ->andFilterWhere(['like', 'title_pic', $this->title_pic])
            ->andFilterWhere(['like', 'contacts', $this->contacts])
            ->andFilterWhere(['like', 'mobile_phone', $this->mobile_phone]);

        //是否确认
        if (!empty($this->is_confirm)) {
            if ($this->is_confirm == 1) {      //无需确认
                $query->andWhere(['travel_order.is_confirm' => 0]);
            } else {     //需要确认
                $query->andWhere(['travel_order.is_confirm' => 1]);
            }
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

        //用户电话
        if (!empty($this->user_mobile)) {
            $query->joinWith(['user']);
            $query->andWhere(['like', 'user.mobile', $this->user_mobile]);
        }
        //用户昵称
        if (!empty($this->user_name)) {
            $query->joinWith(['common']);
            $query->andWhere(['like', 'user_common.nickname', $this->user_name]);
        }
        //支付状态
        if (!empty($this->pay_state)) {
            if ($this->pay_state == 1) {
                $query->andWhere(['trade_no' => '']);
            } else {
                $query->andWhere(['<>', 'trade_no', '']);
            }
        }
        //订单状态
        if (!empty($this->state)) {
            $arr_info = explode('.', $this->state);
            $status = $arr_info[1];
            if ($arr_info[0] == 's') {//支付流程
                if ($status == 21) {//已支付
                    $query->andFilterWhere(['travel_order.state' => $status])
                        ->andWhere(['travel_order.is_confirm' => 0])
                        ->andFilterWhere(['travel_order.refund_stauts' => '0']);
                } else if ($status == 31) {//待确认
                    $query->andWhere(['travel_order.state' => 21])
                        ->andWhere(['travel_order.is_confirm' => 1])
                        ->andFilterWhere(['travel_order.refund_stauts' => '0']);
                } else {
                    $query->andFilterWhere(['travel_order.state' => $status])
                        ->andFilterWhere(['travel_order.refund_stauts' => '0']);
                }
            } else {//退款流程
                $query->andFilterWhere(['travel_order.refund_stauts' => $status]);
            }
        }
        //refund_note(处理退款中订单)
        if (empty($this->refund_note)) {
            $query->andFilterWhere(['refund_stauts' => $this->refund_stauts]);
        } else {
            $query->andFilterWhere(['<>', 'refund_stauts', 52]);
        }
        //结算订单详情
        if (!empty($this->settle)) {
            $query->joinWith(['details']);
            $query->andWhere(['travel_settle_detail.settle_id' => $params['id']]);
        }
        //体验日期
        if (!empty($this->activity_date)) {
            $start_time = substr($this->activity_date, 0, 10) . ' 00:00:00';
            $end_time = substr($this->activity_date, 13) . ' 23:59:59';
            $query->andFilterWhere(['between', 'travel_order.activity_date', $start_time, $end_time]);
        }
        //下单时间
        if (!empty($this->create_time)) {
            $start_date = substr($this->create_time, 0, 10) . ' 00:00:00';
            $end_date = substr($this->create_time, 13) . ' 23:59:59';
            $query->andFilterWhere(['between', 'travel_order.create_time', $start_date, $end_date]);
        }
        //搜索城市
        if (!empty($this->theme_tag)) {
            $query->joinWith(['activity']);
            $query->joinWith(['higo']);
            $query->andWhere(['OR', ['travel_higo.end_city' => $this->theme_tag], ['travel_activity.city_code' => $this->theme_tag]]);
        }

        //发布账号
        if (!empty($this->travel_account)) {
            $query->joinwith("travelUser AS travel_user", true, 'LEFT JOIN');
            $query->joinwith("travelCommon AS travel_user_common", true, 'LEFT JOIN');
            $query->andWhere([
                'or',
                ['like','travel_user.mobile',$this->travel_account],
                ['like','travel_user_common.nickname',$this->travel_account],
            ]);
        }

        //订单id
        if($this->idstr!=""){
            $idArr = explode(",",$this->idstr);
            $query->andWhere(['in', 'id',$idArr]);
        }
        //订单来源
        //@update 2017-.07.07 14:52 pengyang 增加调用该搜索条件逻辑的标记处理
        if(is_string($this->COMMON_CALLEDTAG)){
            switch($this->COMMON_CALLEDTAG){
                //专题活动-专题管理-二维码管理-订单统计-筛选条件使用
                //详见后台控制器:ThematicQrcodeController.actionOrdertotal() 方法需要调用该筛选条件
                case 'ThematicQrcode_Ordertotal':
                    $query->andFilterWhere([
                        'travel_order.theme_type'   =>  $this->COMMON_THEME_TYPE,
                        'travel_order.qrcode_id'    =>  $this->COMMON_QRCODE_ID,
                    ]);
                    break;
            }
        }else{
            if ($this->theme_type!="") {
                if($this->theme_type==0)
                    $query->andWhere(['travel_order.theme_type' => 0]);
                else
                    $query->andWhere(['>', 'travel_order.theme_type', 0]);
            }
        }

//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();
//        exit;

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchCount($params, $post = [])
    {
        $query = TravelOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20,],
//            'sort' => [
//                'defaultOrder' => [
//                    'id' => SORT_DESC,
//                ]
//            ],
        ]);
        $this->load($post);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //判断qrcode_id是否为空，如果不为空的，查询qrcode_id【二维码id】下的所有订单，付燕飞 2017年3月27日15:54:26添加
        if ($this->qrcode_id != null && intval($this->qrcode_id) != 0) {
            $query->andFilterWhere([
                'qrcode_id' => $this->qrcode_id,
            ]);
        }
        //判断theme_type是否为空，如果不为空的，查询theme_type【活动id】下的所有用户，付燕飞2017年7月7日16:47:23添加
        if($this->theme_type != null && intval($this->theme_type) != 0) {
            $query->andFilterWhere([
                'theme_type' => $this->theme_type,
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_uid' => $this->order_uid,
            'travel_uid' => $this->travel_uid,
            'travel_id' => $this->travel_id,
            'adult' => $this->adult,
            'child' => $this->child,
            'coupon_amount' => $this->coupon_amount,
            'pay_amount' => $this->pay_amount,
            'total' => $this->total,
            'pay_platform' => $this->pay_platform,
            'type' => $this->type,
            'create_time' => $this->create_time,
            'is_confirm' => $this->is_confirm,
            'anum' => $this->anum,
            'price' => $this->price,
            'confirm_time' => $this->confirm_time,
            'refund_day' => $this->refund_day,
            'theme_type' => $this->theme_type,
            'close_account' => $this->close_account
        ]);

        $query->andFilterWhere(['like', 'order_no', trim($this->order_no)])
            ->andFilterWhere(['like', 'trade_no', trim($this->trade_no)])
            ->andFilterWhere(['like', 'travel_name', trim($this->travel_name)])
            ->andFilterWhere(['like', 'title_pic', trim($this->title_pic)])
            ->andFilterWhere(['like', 'contacts', trim($this->contacts)])
            ->andFilterWhere(['like', 'mobile_phone', trim($this->mobile_phone)]);
        //支付状态
        if (!empty($this->pay_state)) {
            if ($this->pay_state == 1) {
                $query->andWhere(['trade_no' => '']);
            } else {
                $query->andWhere(['<>', 'trade_no', '']);
            }
        }
        //订单状态
        if (!empty($this->state)) {
            $arr_info = explode('.', $this->state);
            $status = $arr_info[1];
            if ($arr_info[0] == 's') {//支付流程
                $query->andFilterWhere(['state' => $status])
                    ->andFilterWhere(['refund_stauts' => '0']);
            } else {//退款流程
                $query->andFilterWhere(['refund_stauts' => $status]);
            }
        }
        //refund_note(处理退款中订单)
        if (empty($this->refund_note)) {
            $query->andFilterWhere(['refund_stauts' => $this->refund_stauts]);
        } else {
            $query->andFilterWhere(['<>', 'refund_stauts', 52]);
        }
        //结算订单详情
        if (!empty($this->settle)) {
            $query->joinWith(['details']);
            $query->andWhere(['travel_settle_detail.settle_id' => $params['id']]);
        }
        //查询订单是否首单的数据
        if ($this->is_first != "") {
            $query->andWhere([
                'is_first' => $this->is_first,
            ]);
        }
        $query->orderBy('id DESC');
        return $dataProvider;
    }

    /**
     * 查询相应的订单量
     * @param $params
     * @return ActiveDataProvider
     */
    public function getOrderCount($params)
    {
        $query = TravelOrder::find();
        $this->load($params);

        //判断qrcode_id是否为空，如果不为空的，查询qrcode_id【二维码id】下的所有订单，付燕飞 2017年3月27日15:54:26添加
        if ($this->qrcode_id != null && intval($this->qrcode_id) != 0) {
            $query->andFilterWhere([
                'qrcode_id' => $this->qrcode_id,
            ]);
        }
        //判断theme_type是否为空，如果不为空的，查询theme_type【活动id】下的所有用户，付燕飞2017年7月7日16:47:23添加
        if($this->theme_type != null && intval($this->theme_type) != 0) {
            $query->andFilterWhere([
                'theme_type' => $this->theme_type,
            ]);
        }
        //订单状态
        if (!empty($this->state)) {
            /*$arr_info = explode('.', $this->state);
            $status = $arr_info[1];

            if ($arr_info[0] == 's') {//支付流程
                $query->andFilterWhere(['state' => $status])
                    ->andFilterWhere(['refund_stauts' => '0']);
            } else {//退款流程
                $query->andFilterWhere(['refund_stauts' => $status]);
            }*/
            if($this->state==999){
                //$model->trade_no(['NOT', ['type' => null]])
                $query->andWhere(['NOT', ['trade_no' => '']]);
            }
            else{
                $query->andFilterWhere(['state' => $this->state]);
            }
        }

        //查询订单是否首单的数据
        if (!empty($this->is_firsts)) {
            $query->andWhere([
                'is_first' => $this->is_firsts,
            ]);
        }
        return $query->count();
    }
}
