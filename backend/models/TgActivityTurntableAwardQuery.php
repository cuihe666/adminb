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
class TgActivityTurntableAwardQuery extends TgActivityTurntableAward
{
    public $stime;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['award_code', 'award_name','award_info', 'uid','create_time', 'activity_turntable_id', 'activity_id','contact_info','stime'], 'safe'],
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
        $query = TgActivityTurntableAward::find();

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
            $query->andWhere(['between', 'create_time', ($start), ($end)]);
        }

        if ($this->activity_turntable_id !="") {
            $query->andWhere([
                'activity_turntable_id' => $this->activity_turntable_id,
            ]);
        }
        $query->orderBy('id DESC');

//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();
        return $dataProvider;
    }
}
