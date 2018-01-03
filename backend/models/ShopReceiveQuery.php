<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ShopReceive;

/**
 * ShopReceiveQuery represents the model behind the search form about `backend\models\ShopReceive`.
 */
class ShopReceiveQuery extends ShopReceive
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'type', 'refund_id', 'status', 'pay_type'], 'integer'],
            [['order_num', 'receive_num', 'transaction_id', 'create_time'], 'safe'],
            [['receivable', 'true_receive', 'wait_receive'], 'number'],
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
        $query = ShopReceive::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->setSort([

            'defaultOrder' => [
                'create_time' => SORT_DESC,
            ]


        ]);



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if ($this->create_time) {


            $start = strtotime(substr($this->create_time, 0, 10));
            $end = strtotime(substr($this->create_time, 13));
            $query->andWhere(['between', 'create_time', $start, $end]);

        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'type' => $this->type,
            'refund_id' => $this->refund_id,
            'status' => $this->status,
            'pay_type' => $this->pay_type,
            'receivable' => $this->receivable,
            'true_receive' => $this->true_receive,
            'wait_receive' => $this->wait_receive,
        ]);

        $query->andFilterWhere(['like', 'order_num', $this->order_num])
            ->andFilterWhere(['like', 'receive_num', $this->receive_num])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id]);

        return $dataProvider;
    }
}
