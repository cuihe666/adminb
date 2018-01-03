<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ShopPurchase;

/**
 * ShopPurchaseQuery represents the model behind the search form about `backend\models\ShopPurchase`.
 */
class ShopPurchaseQuery extends ShopPurchase
{

    public $principal;
    public $admin_username;
    public $order_num;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'status', 'admin_id', 'update_time'], 'integer'],
            [['purchase_num', 'sell_name', 'create_time', 'principal', 'order_num'], 'safe'],
            [['total', 'freight'], 'number'],
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
        $query = ShopPurchase::find();
        $query->joinWith(['info']);
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
            $query->andWhere(['between', 'shop_purchase.create_time', $start, $end]);

        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'shop_purchase.status' => $this->status,
            'total' => $this->total,
            'freight' => $this->freight,
            'admin_id' => $this->admin_id,
            'shop_info.principal' => $this->principal,
            'shop_order.order_num' => $this->order_num
        ]);

        $query->andFilterWhere(['like', 'purchase_num', $this->purchase_num])
            ->andFilterWhere(['like', 'sell_name', $this->sell_name]);
        return $dataProvider;
    }
}
