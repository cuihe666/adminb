<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TravelTag;

/**
 * TravelActivityQuery represents the model behind the search form about `backend\models\TravelActivity`.
 */
class TravelTagNoteQuery extends TravelTag
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status', 'sort'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['desc'], 'string', 'max' => 255],
            [['status','desc','sort'], 'safe'],
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

        $query = TravelTagNote::find();
        $query->joinWith('tag');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => [
                'sort' => SORT_DESC
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
