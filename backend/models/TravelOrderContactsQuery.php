<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TravelOrderQuery represents the model behind the search form about `backend\models\TravelOrder`.
 */
class TravelOrderContactsQuery extends TravelOrderContacts
{
    public $oid;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[], 'integer'],
            [['idcard', 'name', 'order_no', 'activity_date', 'create_time', 'order_id', 'total_person', 'contact_name', 'contact_mobile', 'pay_state', 'order_state','oid'], 'safe'],
            [[], 'number'],
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
        $query = TravelOrderContacts::find();
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
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'     => $this->id,
            'name'   => $this->name,
            'idcard' => $this->idcard
        ]);
//        $query->andFilterWhere(['like', 'name', $this->name]);
        //过滤总参团人
        if (empty($this->total_person)) {
            $query->andWhere(['order_id' => $params['oid']]);
        } else {
            $order_info = TravelOrder::find()
                ->where(['id' => $params['oid']])
                ->select(['travel_id'])
                ->asArray()
                ->one();
            $order_data = TravelOrder::find()
                ->where(['travel_id' => $order_info['travel_id']])
                ->select(['id'])
                ->asArray()
                ->all();
            $id_array = array();
            if (empty($order_data)) {
                $id_array = NULL;
            } else {
                foreach ($order_data as $k => $val) {
                    $id_array[] = $val['id'];
                }
            }
            $query->andWhere(['in', 'order_id', $id_array]);

        }
        //查询订单号
        if (!empty($this->order_no)) {
            $query->joinWith(['order']);
            $query->andWhere(['order_no' => $this->order_no]);
        }
        //查询联系人
        if (!empty($this->contact_name)) {
            $query->joinWith(['order']);
            $query->andWhere(['contacts' => $this->contact_name]);
        }
        //查询联系人电话
        if (!empty($this->contact_mobile)) {
            $query->joinWith(['order']);
            $query->andWhere(['mobile_phone' => $this->contact_mobile]);
        }
        //查询支付状态
        if (!empty($this->pay_state)) {
            $query->joinWith(['order']);
            if ($this->pay_state == 1) {//已支付
                $query->andWhere(['<>', 'trade_no', '']);
            } else {//未支付
                $query->andWhere(['trade_no' => '']);
            }
        }

        //查询订单状态
        if (!empty($this->order_state)) {
            $query -> joinWith(['order']);
            $arr_info = explode('.', $this->order_state);
            $status = $arr_info[1];
            if ($arr_info[0] == 's') {//支付流程
                if ($status == 21) {//已支付
                    $query->andFilterWhere(['travel_order.state' => $status, 'travel_order.is_confirm' => 0, 'travel_order.refund_stauts' => '0']);
                } else if ($status == 31) {//待确认
                    $query->andWhere(['travel_order.state' => 21, 'travel_order.is_confirm' => 1, 'travel_order.refund_stauts' => '0']);
                } else {
                    $query->andFilterWhere(['travel_order.state' => $status, 'travel_order.refund_stauts' => '0']);
                }
            } else {//退款流程
                $query->andFilterWhere(['travel_order.refund_stauts' => $status]);
            }
        }
        //下单时间
        if (!empty($this->create_time)) {
            $query -> joinWith(['order']);
            $start_date = substr($this->create_time, 0, 10) . ' 00:00:00';
            $end_date = substr($this->create_time, 13) . ' 00:00:00';
            $query->andFilterWhere(['between', 'travel_order.create_time', $start_date, $end_date]);
        }
        //体验日期
        if (!empty($this->activity_date)) {
            $query -> joinWith(['order']);
            $start_time = substr($this->activity_date, 0, 10).' 00:00:00';
            $end_time = substr($this->activity_date, 13).' 00:00:00';
            $query->andFilterWhere(['between', 'travel_order.activity_date', $start_time, $end_time]);
        }
//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();
        //die;
        return $dataProvider;
    }
}
