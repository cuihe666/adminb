<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ActiveTheme;

/**
 * @author fuyanfei
 * @time   2017-3-25 13:38:17
 * @desc   active_theme表模型
 *
 * ActiveThemeQuery represents the model behind the search form about `backend\models\ActiveTheme`.
 */
class ActiveThemeQuery extends ActiveTheme
{
    public $stime;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['theme_name', 'theme_url','start_date', 'end_date', 'status', 'create_time','create_adminid','stime'], 'safe'],
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
        $query = ActiveTheme::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->stime != '') {

            $start = substr($this->stime, 0, 10) . ' 00:00:00';
            $end = substr($this->stime, 13) . ' 23:59:59';
            $query->andWhere(['between', 'end_date', strtotime($start), strtotime($end)]);
        }

        if(trim($this->theme_name) !=""){
            $query->andFilterWhere(['like', 'theme_name', trim($this->theme_name)]);
        }
        if ($this->status !="") {
            $query->andWhere([
                'status' => $this->status,
            ]);
        }
        $query->orderBy('theme_id DESC');

        return $dataProvider;
    }
}
