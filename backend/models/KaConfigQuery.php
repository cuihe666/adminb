<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * @author fuyanfei
 * @time   2017-8-14 13:56:15
 * @desc   ka_config表模型
 *
 * TravelNoteQuery represents the model behind the search form about `backend\models\TravelNote`.
 */
class KaConfigQuery extends KaConfig
{
    public $stime;
    /*public $account;
    public $scity;*/

    /*public static function getDb()
    {
        return \Yii::$app->db1;
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tel', 'name'], 'safe'],
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
        $query = KaConfig::find();

        $this->load($params);

        if($this->status==1){
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        'create_time' => SORT_DESC,
                    ]
                ],
            ]);
        } else{
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        'update_time' => SORT_DESC,
                    ]
                ],
            ]);
        }

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andWhere([
            'status' => $this->status,
        ]);

        if ($this->type !="") {
            $query->andWhere([
                'type' => $this->type,
            ]);
        }

        if(trim($this->name) !=""){
            $query->andFilterWhere(['like', 'name', trim($this->name)]);
        }
        if(trim($this->tel) !=""){
            $query->andFilterWhere(['like', 'tel', trim($this->tel)]);
        }
        return $dataProvider;
    }
}
