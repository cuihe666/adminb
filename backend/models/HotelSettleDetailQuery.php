<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\HotelSettleDetail;

/**
 * HotelSettleDetailQuery represents the model behind the search form about `backend\models\HotelSettleDetail`.
 */
class HotelSettleDetailQuery extends HotelSettleDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'settle_id', 'order_id'], 'integer'],
            [['order_num', 'create_time'], 'safe'],
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
        $query = HotelSettleDetail::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20,],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('order');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'settle_id' => $this->settle_id,
            'order_id' => $this->order_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'hotel_settle_detail.order_num', $this->order_num]);

//        $query->asArray();
//        $data = clone $query;
//        echo $data->createCommand()->getRawSql();die;
        return $dataProvider;
    }
}
