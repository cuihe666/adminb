<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TravelPerson;

/**
 * TravelPersonQuery represents the model behind the search form about `backend\models\TravelPerson`.
 */
class TravelPersonQuery extends TravelPerson
{

    public $start_time;
    public $account;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'constellation', 'sex', 'is_login', 'status'], 'integer'],
            [['profession', 'recommend', 'card', 'card_pic_zheng', 'card_pic_fan', 'guide_pic', 'name','nick_name', 'start_time', 'account','mobile'], 'safe'],
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
        $query = TravelPerson::find();

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

        if ($this->start_time != '') {

            $start = substr($this->start_time, 0, 10) . ' 00:00:00';
            $end = substr($this->start_time, 13) . ' 00:00:00';
            $query->andWhere(['between', 'create_time', $start, $end]);
        }
        if ($this->account) {
            $query->andFilterWhere([
                'id' => $this->id,
                'uid' => TravelPerson::getuid($this->account),
            ]);

        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'constellation' => $this->constellation,
            'mobile' => $this->mobile,
            'sex' => $this->sex,
            'is_login' => $this->is_login,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'profession', $this->profession])
            ->andFilterWhere(['like', 'recommend', $this->recommend])
            ->andFilterWhere(['like', 'card', $this->card])
            ->andFilterWhere(['like', 'card_pic_zheng', $this->card_pic_zheng])
            ->andFilterWhere(['like', 'card_pic_fan', $this->card_pic_fan])
            ->andFilterWhere(['like', 'guide_pic', $this->guide_pic])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'nick_name', $this->nick_name]);

        //2017-5-27 14:43:24 付燕飞 添加------------保存中-待审核的不予展示
        $query->andWhere(['<>','status',3]);
        /*$commandQuery = clone $query;
        echo $commandQuery->createCommand()->getRawSql();*/
        return $dataProvider;
    }
}
