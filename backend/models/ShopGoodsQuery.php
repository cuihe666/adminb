<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ShopGoodsQuery represents the model behind the search form about `backend\models\ShopGoods`.
 */
class ShopGoodsQuery extends ShopGoods
{

    public $principal;
    public $admin_username;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'status', 'stocks', 'logistics_tpl_id', 'admin_id'], 'integer'],
            [['category_name', 'title', 'code', 'barcode', 'post_image', 'images', 'attributes', 'description', 'packing_list', 'warranty', 'config', 'created_at', 'update_at', 'operate_category', 'principal', 'admin_username', 'goods_num'], 'safe'],
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
        $query = ShopGoods::find();

        $query->joinWith(['info']);
        $query->joinWith(['upplier']);

        $query->select("shop_goods.*, shop_info.name,shop_info.principal as principal,shop_supplier.admin_username");
//        $query->select("shop_goods.*, shop_info.*,shop_supplier.*");


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([

            'defaultOrder' => [
                'created_at' => SORT_DESC,
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
            'category_id' => $this->category_id,
            'shop_goods.status' => $this->status,
            'price' => $this->price,
            'stocks' => $this->stocks,
            'logistics_tpl_id' => $this->logistics_tpl_id,
            'admin_id' => $this->admin_id,
            'update_at' => $this->update_at,
            'operate_category' => $this->operate_category,
            'goods_num' => $this->goods_num
        ]);

        $query->andWhere(['!=', 'is_delete', 1]);


        if ($this->created_at) {

            $start = substr($this->created_at, 0, 10) . ' 00:00:00';
            $end = substr($this->created_at, 13) . ' 00:00:00';
            $query->andWhere(['between', 'shop_goods.created_at', $start, $end]);

        }

        $query->andFilterWhere(['like', 'category_name', $this->category_name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'barcode', $this->barcode])
            ->andFilterWhere(['like', 'post_image', $this->post_image])
            ->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'attributes', $this->attributes])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'packing_list', $this->packing_list])
            ->andFilterWhere(['like', 'warranty', $this->warranty])
            ->andFilterWhere(['like', 'shop_supplier.admin_username', $this->admin_username])
            ->andFilterWhere(['like', 'shop_info.principal', $this->principal])
            ->andFilterWhere(['like', 'config', $this->config]);


        return $dataProvider;
    }


}
