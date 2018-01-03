<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PlaneTicketBanner;

/**
 * PlaneTicketBannerQuery represents the model behind the search form about `backend\models\PlaneTicketBanner`.
 */
class PlaneTicketBannerQuery extends PlaneTicketBanner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'turn_type', 'sort', 'status', 'admin_id'], 'integer'],
            [['desc', 'img_url', 'turn_data', 'share_data', 'start_time', 'end_time', 'create_time', 'update_time'], 'safe'],
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
        $query = PlaneTicketBanner::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);
        //按照添加顺序降序排列
        $dataProvider->setSort([
            'defaultOrder' => [
                'sort' => SORT_DESC
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
            'turn_type' => $this->turn_type,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'sort' => $this->sort,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'admin_id' => $this->admin_id,
        ]);

        $query->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'img_url', $this->img_url])
            ->andFilterWhere(['like', 'turn_data', $this->turn_data])
            ->andFilterWhere(['like', 'share_data', $this->share_data]);

        return $dataProvider;
    }
}
