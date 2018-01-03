<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\KaOrderFollow;

/**
 * @author fuyanfei
 * @time   2017年3月20日13:24:33
 * @desc   ka_order_follow表模型
 */
class KaOrderFollowQuery extends KaOrderFollow
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderid', 'follow_time', 'follow_adminname', 'follow_remark','follow_logs', 'follow_status', 'follow_file'], 'safe'],
            [['follow_file'],'file'],
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
        $query = KaOrderFollow::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'orderid' => $this->orderid,
        ]);

        return $dataProvider;
    }
}
