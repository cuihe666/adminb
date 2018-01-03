<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ShopPayment;

/**
 * ShopPaymentQuery represents the model behind the search form about `backend\models\ShopPayment`.
 */
class ShopPaymentQuery extends ShopPayment
{

    public $purchase_num;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'type', 'status', 'pay_type'], 'integer'],
            [['order_num', 'receive_num', 'transaction_id', 'pay_num', 'create_time', 'purchase_num'], 'safe'],
            [['payable', 'true_pay', 'wait_pay'], 'number'],
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
        $query = ShopPayment::find();
        $query->joinWith(['purchase']);
        $query->joinWith(['order']);

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
            $query->andWhere(['between', 'shop_payment.create_time', $start, $end]);

        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'type' => $this->type,
            'shop_payment.status' => $this->status,
            'pay_type' => $this->pay_type,
            'payable' => $this->payable,
            'true_pay' => $this->true_pay,
            'wait_pay' => $this->wait_pay,
            'pay_num' => $this->pay_num,
            'shop_purchase.purchase_num' => $this->purchase_num,
        ]);

        $query->andFilterWhere(['like', 'shop_payment.order_num', $this->order_num])
            ->andFilterWhere(['like', 'receive_num', $this->receive_num])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id]);


        return $dataProvider;
    }
}
