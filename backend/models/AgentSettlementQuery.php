<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AgentSettlementQuery represents the model behind the search form about `backend\models\AgentSettlement`.
 */
class AgentSettlementQuery extends AgentSettlement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'agent_id', 'create_time', 'status', 'pay_time'], 'integer'],
            [['settle_id'], 'safe'],
            [['total', 'order_total', 'coupon_total', 'landlady_total', 'tangguo_total'], 'number'],
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
        $query = AgentSettlement::find();
        $query->joinWith(['bank'])->select(['agent_bank.name', 'agent_bank.company_name', 'agent_settlement.*']);
        $query->joinWith(['agent'])->select(['agent_bank.*', 'agent_settlement.*']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        //admin:ys  time:2017/11/15 content:修复点击列标题进行排序时，出现bug的问题
        $dataProvider->setSort([
            'attributes' => [
                'create_time' => [
                    'asc' => ['agent_settlement.create_time' => SORT_ASC],
                    'desc' => ['agent_settlement.create_time' => SORT_DESC],
                    'label' => 'Customer Name'
                ],
            ]
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
            'agent_id' => $this->agent_id,
            'create_time' => $this->create_time,
            'total' => $this->total,
            'order_total' => $this->order_total,
            'coupon_total' => $this->coupon_total,
            'pay_time' => $this->pay_time,
            'landlady_total' => $this->landlady_total,
            'tangguo_total' => $this->tangguo_total,
        ]);
        if ($this->status) {
            $query->andWhere(['agent_settlement.status' => $this->status]);
        } else {
            $query->andWhere(['agent_settlement.status' => 0]);
        }
        $query->andFilterWhere(['like', 'settle_id', $this->settle_id]);

        return $dataProvider;
    }
}
