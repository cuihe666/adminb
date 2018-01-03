<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ShopBanner;

/**
 * ShopBannerQuery represents the model behind the search form about `backend\models\ShopBanner`.
 */
class ShopBannerQuery extends ShopBanner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_home', 'type', 'goods_id', 'cid', 'sort'], 'integer'],
            [['img_url'], 'safe'],
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
        $query = ShopBanner::find();

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
            'is_home' => $this->is_home,
            'type' => $this->type,
            'goods_id' => $this->goods_id,
            'cid' => $this->cid,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'img_url', $this->img_url]);

        return $dataProvider;
    }
}
