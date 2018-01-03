<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TravelSettlement;

/**
 * TravelSettlementQuery represents the model behind the search form about `backend\models\TravelSettlement`.
 */
class TravelSettlementQuery extends TravelSettlement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'status', 'pay_time'], 'integer'],
            [['settle_id','settle_price'], 'safe'],
            [[ 'total', 'order_total', 'coupon_total', 'bank_data', 'create_time', 'account', 'tg_commission', 'Alipay_num', 'user_name', 'user_mobile'], 'safe'],
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
        $query = TravelSettlement::find();
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
            'travel_settlement.status' => $this->status,
            'travel_settlement.settle_id' => $this->settle_id,
        ]);

//        $query->andFilterWhere(['like', 'name', $this->name]);

        /***** 搜索结算日期 *****/
        if (!empty($this->create_time)) {
            $time_arr = explode('-', $this->create_time);
            $start_time = strtotime(str_replace('.', '-', $time_arr[0]));
            $end_time = strtotime(str_replace('.', '-', $time_arr[1]));
            $query->andFilterWhere(['between', 'create_time', $start_time, $end_time]);
        }
        /****** 支付宝账号查询 ******/
        if (!empty($this->Alipay_num)) {
            $query -> joinWith(['banks']);
            $query->andWhere([
                'account_bankcard.account_number' => $this->Alipay_num,
            ]);
        }
        /****** 查询用户名 *******/
        if (!empty($this->user_name)) {
            $query -> joinWith(['user']);
            $query->andWhere([
                'user_common.nickname' => $this->user_name,
            ]);
        }
        /****** 查询联系电话 *******/
        if (!empty($this->user_mobile)) {
            $query -> joinWith(['user_mobile']);
            $query->andWhere([
                'user.mobile' => $this->user_mobile,
            ]);
        }
        return $dataProvider;
    }
}
