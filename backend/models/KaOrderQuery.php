<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\KaOrder;

/**
 * @author fuyanfei
 * @time   2017年3月17日17:29:22
 * @desc   ka_order表模型
 *
 * TravelNoteQuery represents the model behind the search form about `backend\models\TravelNote`.
 */
class KaOrderQuery extends KaOrder
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
            [['custom_type', 'departure_time', 'adult_num', 'children_num', 'budget', 'stayed_id', 'customized_theme','play_theme', 'tel', 'follow_status', 'add_time','stime','departure','destination','linkman','email'], 'safe'],
            //[['custom_type','departure','destination','departure_time','adult_num','children_num','budget','linkman','tel','email'], 'required'],
            //[['activity_date', 'create_time', 'confirm_time'], 'safe'],
            //[['adult_num', 'children_num', 'budget', 'tel'], 'number'],
            //[['departure'], 'string', 'max' => 20],
            //[['destination'], 'string', 'max' => 50],
            //[['email'], 'string', 'max' => 50],
            //[['stime'],'safe'],
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
        $query = KaOrder::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'follow_status' => $this->follow_status,
        ]);
        if ($this->stime != '') {

            $start = substr($this->stime, 0, 10) . ' 00:00:00';
            $end = substr($this->stime, 13) . ' 23:59:59';
            $query->andWhere(['between', 'add_time', strtotime($start), strtotime($end)]);
        }

        if ($this->custom_type !="" && intval($this->custom_type)!=0) {
            $query->andWhere([
                'custom_type' => $this->custom_type,
            ]);
        }
        if ($this->follow_status !="") {
            $query->andWhere([
                'follow_status' => $this->follow_status,
            ]);
        }
        if(trim($this->linkman) !=""){
            $query->andFilterWhere(['like', 'linkman', trim($this->linkman)]);
        }
        if(trim($this->tel) !=""){
            $query->andFilterWhere(['like', 'tel', trim($this->tel)]);
        }
        $query->orderBy('orderid DESC');

        return $dataProvider;
    }
}
