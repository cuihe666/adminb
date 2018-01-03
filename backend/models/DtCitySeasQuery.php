<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TravelOrder;

/**
 * TravelOrderQuery represents the model behind the search form about `backend\models\TravelOrder`.
 */
class DtCitySeasQuery extends DtCitySeas
{
    public $abroad_note;//国外省级查询
    public $city_arr; //导出
    public $country_type;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'parent', 'level', 'operation', 'version', 'country', 'seas', 'display', 'travel', 'name', 'pinyin', 'abbre', 'first_letter', 'time_zone','city_arr','country_type'], 'safe'],
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
        $query = DtCitySeas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20,],
//            'sort' => [
//                'defaultOrder' => [
//                    'id' => SORT_DESC,
//                ]
//            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'code'   => $this->code,
            'level'  => $this->level,
            'abbre'  => $this->abbre,
            'pinyin' => $this->pinyin,
            'first_letter' => $this->first_letter,
            'seas'    => $this->seas,
            'display' => $this->display,
            'travel'  => $this->travel,
            'is_visiable'  => $this->is_visiable,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        if (empty($this->abroad_note)) {
            $query->andFilterWhere(['parent' => $this->parent]);
        } else {
            $city_data = DtCitySeas::find()
                ->where(['parent' => $params['id']])
                ->select(['code'])
                ->asArray()
                ->all();
            if (!empty($city_data)) {
                foreach ($city_data as $val) {
                    $code_info[] = $val['code'];
                }
                $query->andFilterWhere(['in', 'parent', $code_info]);
            } else {
                $query->andFilterWhere(['parent'=> '3']);
            }
        }

        //
        if($this->city_arr!=""){
            $query->andFilterWhere(['in', 'CODE', $this->city_arr]);
            $query->andFilterWhere(['display'=>1]);
        }

        if($this->country_type==1){
            $query->andFilterWhere(['country'=>10001]);
        }
        if($this->country_type==2){
            $query->andFilterWhere(['!=','country',10001]);
        }

//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();die;
        return $dataProvider;
    }
}
