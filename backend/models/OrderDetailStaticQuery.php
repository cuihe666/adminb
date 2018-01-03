<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrderDetailStatic;

/**
 * OrderDetailStaticQuery represents the model behind the search form about `backend\models\OrderDetailStatic`.
 */
class OrderDetailStaticQuery extends OrderDetailStatic
{
    /**
     * @inheritdoc
     */
    public $start_time;
    public $city_name;
    public $user_account;
    public $land_account;
    public $stauts;
    public $refund_stauts;
    public $search_type;
    public $pay_status;
    public $pay_type;
    public $type;
    public $house_laiyuan;

    public function rules()
    {
        return [
            [['id', 'order_uid', 'house_uid', 'house_id', 'day_num', 'national', 'house_province_id', 'house_city_id', 'house_county_id', 'roomnum', 'officenum'], 'integer'],
            [['order_num', 'create_time', 'update_time', 'in_time', 'out_time', 'house_title_pic', 'remarks', 'house_apartments', 'house_title', 'mobile', 'really_name', 'address', 'start_time', 'city_name', 'user_account', 'land_account', 'stauts', 'refund_stauts', 'search_type', 'pay_status', 'pay_type','house_laiyuan','is_realtime'], 'safe'],
            [['extra_amount', 'total', 'house_price', 'house_deposit'], 'number'],
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
        $query = OrderDetailStatic::find();
        if ($this->type == 3) {
            $query->joinWith(['settle']);
            $query->andWhere(['house_settle_detail.settle_id' => $params['id']]);
        }
        if ($this->type == 4) {
            $query->joinWith(['agentsettle']);
            $query->andWhere(['agent_settle_detail.settle_id' => $params['id']]);
            $query->andWhere(['order_state.is_agent_settle' => 1]);
        }
        //@2017-11-8 18:21:41 fuyanfei to update [去掉->select(['order_detail_static.*', 'user_info.name'])]
        $query->joinWith(['username']);
        //@2017-11-8 18:22:08 fuyanfei to update [去掉->select(['order_detail_static.*', 'order_state.order_stauts', 'order_state.refund_stauts', 'order_state.pay_platform'])]
        $query->leftJoin(['order_state' => OrderState::tableName()], 'order_state.order_id = order_detail_static.id');
        //@2017年11月8日18:15:18 fuyanfei to add minsu320[列表页添加房源类型]
        $query->leftJoin("house_search as s","order_detail_static.house_id = s.house_id");
        //@2017-11-10 14:29:35 fuyanfei to add minsu320[列表页添加房源类型--并且修改房源类型]
        $query->leftJoin("dt_house_type","s.roomtype = dt_house_type.id");
        //@2017-11-10 14:32:35 fuyanfei to add minsu320[列表页添加房源类型--并且修改房源类型]
        $query->leftJoin("dt_house_type_code","dt_house_type.code = dt_house_type_code.id");
        //@2017-11-8 18:22:30 fuyanfei to merge username,orderState去掉的select及新添加的house_search
        $query->select(['order_detail_static.*', 'user_info.name', 'order_state.order_stauts', 'order_state.refund_stauts', 'order_state.pay_platform','s.roomtype','dt_house_type.type_name','dt_house_type_code.code_name']);
//        $query->joinWith(['username'])->select(['order_detail_static.*','order_state.order_stauts,',]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'house_uid' => $this->house_uid,
            'order_detail_static.house_id' => $this->house_id,
            'is_realtime' => $this->is_realtime,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'extra_amount' => $this->extra_amount,
            'total' => $this->total,
            'in_time' => $this->in_time,
            'out_time' => $this->out_time,
            'day_num' => $this->day_num,
            'national' => $this->national,
            'house_province_id' => $this->house_province_id,
            'house_city_id' => $this->house_city_id,
            'house_county_id' => $this->house_county_id,
            'house_price' => $this->house_price,
            'house_deposit' => $this->house_deposit,
            'roomnum' => $this->roomnum,
            'officenum' => $this->officenum,
        ]);
        $query->andFilterWhere(['like', 'order_num', $this->order_num])
            ->andFilterWhere(['like', 'house_title_pic', $this->house_title_pic])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'house_apartments', $this->house_apartments])
            ->andFilterWhere(['like', 'house_title', $this->house_title])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'really_name', $this->really_name])
            ->andFilterWhere(['
            like', 'address', $this->address]);

//        if ($this->start_time != '') {
//            $time = explode('-', $this->start_time);
//            $query->andWhere(['between', 'order_detail_static.create_time', $time[0], $time[1]]);
//        }
        if ($this->city_name != '') {
            $city_code = CommonService::get_city_code1($this->city_name);
            if ($city_code === false) {
                $city_code = 88888;
            }
            $query->andFilterWhere(['house_city_id' => $city_code]);
        }
        if ($this->user_account != '') {
            $uid = CommonService::get_uid($this->user_account);
            if ($uid === false) {
                $uid = 0;
            }
            $query->andFilterWhere(['order_detail_static.order_uid' => $uid]);
        }
        if ($this->land_account != '') {
            $uid = CommonService::get_uid($this->land_account);
            if ($uid === false) {
                $uid = 0;
            }
            $query->andFilterWhere(['order_state.house_uid' => $uid]);
        }
        if ($this->stauts != '') {
            $query->andFilterWhere(['order_state.order_stauts' => $this->stauts]);
            $query->andFilterWhere(['order_state.refund_stauts' => 0]);
        }
        if ($this->refund_stauts != '') {
            $query->andFilterWhere(['order_state.refund_stauts' => $this->refund_stauts]);
        }
        if ($this->search_type && $this->start_time) {
            $time = explode('-', $this->start_time);
            $start = $time[0];
            $end = $time[1];
            switch ($this->search_type) {
                case 1:
                    $query->andWhere(['between', 'order_detail_static.create_time', $start, $end]);
                    break;
                case 2:
                    $query->andWhere(['between', 'order_detail_static.in_time', $start, $end]);
                    break;
                case 3:
                    $query->andWhere(['between', 'order_detail_static.out_time', $start, $end]);
                    break;
            }
        }
        if ($this->pay_status) {
            $query->andFilterWhere(['order_state.pay_stauts' => $this->pay_status]);
        }
        if ($this->pay_type) {
            $query->andFilterWhere(['order_state.pay_platform' => $this->pay_type]);
        }
        if($this->house_laiyuan){
            if($this->house_laiyuan==1){
                $query->andFilterWhere(['order_state.order_type'=>0]);//棠果订单
            }else if ($this->house_laiyuan==2) {
                $query->andFilterWhere(['order_state.order_type'=>1]);//番茄来了
            } else {
                $query->andFilterWhere(['order_state.order_type'=>2]);//同程
            }
        }
        if ($this->type == 1) {
            $query->andWhere(['or', ['order_stauts' => [1, 11]], ['refund_stauts' => [1]]]);
        }
        if ($this->type == 2) {
            if($this->refund_stauts){
                $query->andWhere(['refund_stauts' => $this->refund_stauts]);
            }else{
                $query->andWhere(['refund_stauts' => 3]);
            }
        }

        $query->orderBy([
            'id' => SORT_DESC,
        ]);

//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();

        return $dataProvider;
    }
}
