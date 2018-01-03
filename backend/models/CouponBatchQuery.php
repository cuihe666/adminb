<?php

namespace backend\models;

use common\tools\Helper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CouponBatch;

/**
 * CouponBatchQuery represents the model behind the search form about `backend\models\CouponBatch`.
 */
class CouponBatchQuery extends CouponBatch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mode', 'amount', 'num', 'max_num', 'rule', ], 'integer'],
            [['title', 'start_time', 'end_time', 'create_name', 'update_time','create_time','batch_code' ,'status','type','is_forever',], 'safe'],
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
        $query = CouponBatch::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //按照添加顺序降序排列
        $dataProvider->setSort([
            'defaultOrder' => [
                'id' => SORT_DESC
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($this->type){
            $this->filter($query,'type','coupon_type');
        }

        if($this->status){
            $this->filter($query,'status','coupon_status');
        }

        if($this->is_forever){
            $forever = trim($this->is_forever);
            if($forever == '永久有效'){
                $query->andFilterWhere(['is_forever' => 1]);
            }else{
                //验证是否符合 yy-mm-dd => yy-mm-dd 这种时间格式
                $preg = '/^(\d{2}|\d{4})-\d{1,2}-\d{1,2}\s*=>\s*(\d{2}|\d{4})-\d{1,2}-\d{1,2}$/';
                if(preg_match($preg,$forever)){
                    $arr = explode("=>",$forever);
                    $arr[0] = trim($arr[0]);
                    $arr[1] = trim($arr[1]);
                    $condition = [
                        date('Y-m-d H:i:s',strtotime($arr[0])),
                        date('Y-m-d H:i:s',strtotime($arr[1]) + 86400),
                    ];
                    $query->andFilterWhere(['between' ,'end_time',  $condition[0],  $condition[1]]);
                }
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'is_forever' => $this->is_forever,
            'mode' => $this->mode,
            'amount' => $this->amount,
            'num' => $this->num,
            'max_num' => $this->max_num,
            'rule' => $this->rule,
//            'start_time' => $this->start_time,
//            'end_time' => $this->end_time,
//            'type' => $this->type,
//            'status' => $this->status,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'batch_code', $this->batch_code])
            ->andFilterWhere(['like', 'create_name', $this->create_name]);

        return $dataProvider;
    }

    /**
     * 根据状态内容映射出对应的数值去组合查询条件
     * @param $query        CouponBatch 查询模型
     * @param $column       string      需要查询的字段
     * @param $param_key    string      字段对应的 Yii::$app->params 中对应的 key 值
     */
    protected function filter(&$query,$column,$param_key){
        $value = trim($this->$column);
        $list = array_flip(Yii::$app->params[$param_key]);
        if(array_key_exists($value,$list)){
            $query->andFilterWhere([$column => $list[$value]]);
        }
    }
}
