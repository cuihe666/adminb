<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ShopOrder;

/**
 * ShopOrderQuery represents the model behind the search form about `backend\models\ShopOrder`.
 */
class ShopOrderQuery extends ShopOrder
{
    public $account;
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_uid', 'admin_id', 'address_id', 'point_total', 'num_total', 'status', 'refund_status', 'coupon_id', 'update_time', 'account'], 'integer'],
            [['price_total'], 'number'],
            [['order_num', 'remark', 'create_time', 'name'], 'safe'],
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
        $query = ShopOrder::find();
        $query->joinWith(['customer']);
        $query->joinWith(['receive']);

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
            $query->andWhere(['between', 'shop_order.create_time', $start, $end]);

        }
        if ($this->account != '') {
            $uid = CommonService::get_uid($this->account);
            if ($uid === false) {
                $uid = 0;
            }
            $query->andFilterWhere(['order_uid' => $uid]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_uid' => $this->order_uid,
            'admin_id' => $this->admin_id,
            'address_id' => $this->address_id,
            'point_total' => $this->point_total,
            'price_total' => $this->price_total,
            'num_total' => $this->num_total,
            'shop_order.status' => $this->status,
            'refund_status' => $this->refund_status,
            'coupon_id' => $this->coupon_id,
            'update_time' => $this->update_time,
            'shop_address.name' => $this->name,
            'shop_order.order_num' => $this->order_num
        ]);

        $query->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
