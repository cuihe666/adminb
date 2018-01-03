<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TravelCompany;

/**
 * TravelCompanyQuery represents the model behind the search form about `backend\models\TravelCompany`.
 */
class TravelCompanyQuery extends TravelCompany
{
    public $start_time;
    public $account;
    public $reg_local;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'status', 'type', 'obj_id', 'is_login'], 'integer'],
            [['name', 'recommend', 'license', 'operation', 'create_time', 'account', 'start_time', 'group_type', 'reg_local'], 'safe'],
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
        $query = TravelCompany::find();

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

        if ($this->account) {
            $query->andFilterWhere([
                'id' => $this->id,
                'uid' => TravelPerson::getuid($this->account),
            ]);

        }

        if ($this->start_time != '') {

            $start = substr($this->start_time, 0, 10) . ' 00:00:00';
            $end = substr($this->start_time, 13) . ' 00:00:00';
            $query->andWhere(['between', 'create_time', $start, $end]);
        }
        if ($this->reg_local == 1) {
            $query->andFilterWhere([
                'reg_addr_type' => 1,
            ]);

        }
        if ($this->reg_local == 2) {
            $query->andWhere(['in', 'reg_addr_type', [2, 3, 4]]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'status' => $this->status,
            'type' => $this->type,
            'obj_id' => $this->obj_id,
            'is_login' => $this->is_login,
            'create_time' => $this->create_time,
            'group_type' => $this->group_type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'recommend', $this->recommend])
            ->andFilterWhere(['like', 'license', $this->license])
            ->andFilterWhere(['like', 'operation', $this->operation]);

        //2017-5-27 14:43:24 付燕飞 添加------------保存中-待审核的不予展示
        $query->andWhere(['<>','status',3]);

//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();

        return $dataProvider;
    }
}
