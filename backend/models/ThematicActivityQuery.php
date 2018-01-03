<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TravelActivityQuery represents the model behind the search form about `backend\models\TravelActivity`.
 */
class ThematicActivityQuery extends ThematicActivity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','creator','status'], 'safe'],
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
        $query = ThematicActivity::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 30,],
        ]);
        //按照添加顺序降序排列
        $dataProvider->setSort([
            'defaultOrder' => [
                'status' => SORT_ASC,
                'id' => SORT_DESC,
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
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'creator', $this->creator]);
        /*$query->orderBy([
            'status' => SORT_ASC,
            'id' => SORT_DESC,
        ]);
        $commandQuery = clone $query;
        echo $commandQuery->createCommand()->getRawSql();*/
        return $dataProvider;
    }
}
