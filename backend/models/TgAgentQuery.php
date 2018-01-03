<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TgAgent;

/**
 * TgAgentQuery represents the model behind the search form about `backend\models\TgAgent`.
 */
class TgAgentQuery extends TgAgent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'code', 'type', 'status', 'invite_code', 'create_time', 'last_ip', 'this_ip'], 'integer'],
            [['username', 'password', 'true_name', 'email'], 'safe'],
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
        $query = TgAgent::find();
        $query->joinWith(['bank']);

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
            'code' => $this->code,
            'type' => $this->type,
            'status' => $this->status,
            'invite_code' => $this->invite_code,
            'create_time' => $this->create_time,
            'last_ip' => $this->last_ip,
            'this_ip' => $this->this_ip,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'true_name', $this->true_name])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
