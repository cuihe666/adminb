<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ShopRefund;

/**
 * ShopRefundQuery represents the model behind the search form about `backend\models\ShopRefund`.
 */
class ShopRefundQuery extends ShopRefund
{
    /**
     * @inheritdoc
     */
    public $order_num;
    public $purchase_num;
    public $admin_account;

    public function rules()
    {
        return [
            [['id', 'order_id', 'admin_id', 'uid', 'status'], 'integer'],
            [['refund_num', 'cancel_reason', 'refund_reason', 'order_num', 'update_time', 'create_time', 'purchase_num', 'admin_account'], 'safe'],
            [['refund_money'], 'number'],
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
        $query = ShopRefund::find();
        $query->joinWith(['order']);
//        $query->joinWith(['goods']);
        $query->joinWith(['purchase']);

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
            $query->andWhere(['between', 'shop_refund.create_time', $start, $end]);

        }

        if ($this->update_time) {
            $start = strtotime(substr($this->update_time, 0, 10));
            $end = strtotime(substr($this->update_time, 13));
            $query->andWhere(['between', 'shop_refund.update_time', $start, $end]);

        }
        if ($this->admin_account) {
            $query->andWhere([
                'shop_refund.admin_id' => ShopRefund::getAdminId($this->admin_account),

            ]);


        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,

            'uid' => $this->uid,
            'refund_money' => $this->refund_money,
            'status' => $this->status,
            'shop_order.order_num' => $this->order_num,
            'shop_purchase.purchase_num' => $this->purchase_num,
        ]);

        $query->andFilterWhere(['like', 'refund_num', $this->refund_num]);
        return $dataProvider;
    }
}
