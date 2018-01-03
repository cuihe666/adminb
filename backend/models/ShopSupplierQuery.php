<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ShopSupplier;

/**
 * ShopSupplierQuery represents the model behind the search form about `backend\models\ShopSupplier`.
 */
class ShopSupplierQuery extends ShopSupplier
{
    public $principal;
    public $principal_phone;
    public $start_time;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'admin_id', 'status', 'is_combine', 'long_time'], 'integer'],
            [['admin_username', 'company_name', 'bank_num', 'bank_name', 'bank_branch_name', 'account_name', 'legal', 'legal_id_code', 'start_time', 'end_time', 'uscc_code', 'occ_code', 'tax_id', 'business_scope', 'images', 'principal', 'principal_phone', 'start_time'], 'safe'],
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
        $query = ShopSupplier::find();
        $query->joinWith(['info']);

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
            'admin_id' => $this->admin_id,
            'status' => $this->status,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'is_combine' => $this->is_combine,
            'long_time' => $this->long_time,
            'shop_info.principal_phone' => $this->principal_phone,
        ]);

        if ($this->start_time) {

            $start = substr($this->start_time, 0, 10) . ' 00:00:00';
            $end = substr($this->start_time, 13) . ' 00:00:00';


            $query->andWhere(['between', 'created_at', $start, $end]);

        }

        $query->andFilterWhere(['like', 'admin_username', $this->admin_username])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'bank_num', $this->bank_num])
            ->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'account_name', $this->account_name])
            ->andFilterWhere(['like', 'legal', $this->legal])
            ->andFilterWhere(['like', 'legal_id_code', $this->legal_id_code])
            ->andFilterWhere(['like', 'uscc_code', $this->uscc_code])
            ->andFilterWhere(['like', 'occ_code', $this->occ_code])
            ->andFilterWhere(['like', 'tax_id', $this->tax_id])
            ->andFilterWhere(['like', 'business_scope', $this->business_scope])
            ->andFilterWhere(['like', 'shop_info.principal', $this->principal])
            ->andFilterWhere(['like', 'images', $this->images]);

        return $dataProvider;
    }
}
