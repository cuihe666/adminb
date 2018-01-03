<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TravelSettleDetail;

/**
 * TravelSettleDetailQuery represents the model behind the search form about `backend\models\TravelSettleDetail`.
 */
class TravelSettleDetailQuery extends TravelSettleDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'settle_id', 'order_id', 'travel_id', 'create_time', 'type'], 'integer'],
            [['order_num',], 'safe'],
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
        $query = TravelSettleDetail::find();
        // add conditions that should always apply here

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
            'settle_id' => $this->settle_id,
            'order_id' => $this->order_id,
            'travel_id' => $this->travel_id,
            'create_time' => $this->create_time,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'order_num', $this->order_num]);

        return $dataProvider;
    }
}
