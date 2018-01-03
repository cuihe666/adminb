<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ShopGoods;

/**
 * GoodsSearch represents the model behind the search form about `app\models\ShopGoods`.
 */
class GoodsSearch extends ShopGoods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'operate_category', 'category_id', 'status', 'stocks', 'logistics_tpl_id', 'admin_id', 'is_more'], 'integer'],
            [['category_breadcrumbs', 'category_name', 'title', 'code', 'barcode', 'post_image', 'images', 'attributes', 'description', 'packing_list', 'warranty', 'config', 'created_at', 'update_at', 'introduction'], 'safe'],
            [['price'], 'number'],
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
        $query = ShopGoods::find()
            ->select(['id','title','post_image','category_breadcrumbs','price','stocks','created_at','status','code'])
            ->orderBy(['id' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
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
            'operate_category' => $this->operate_category,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'price' => $this->price,
            'stocks' => $this->stocks,
            'logistics_tpl_id' => $this->logistics_tpl_id,
            'admin_id' => $this->admin_id,
            'created_at' => $this->created_at,
            'update_at' => $this->update_at,
            'is_more' => $this->is_more,
        ]);

        $query->andFilterWhere(['like', 'category_breadcrumbs', $this->category_breadcrumbs])
            ->andFilterWhere(['like', 'category_name', $this->category_name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'barcode', $this->barcode])
            ->andFilterWhere(['like', 'post_image', $this->post_image])
            ->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'attributes', $this->attributes])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'packing_list', $this->packing_list])
            ->andFilterWhere(['like', 'warranty', $this->warranty])
            ->andFilterWhere(['like', 'config', $this->config])
            ->andFilterWhere(['like', 'introduction', $this->introduction]);

        return $dataProvider;
    }
}
