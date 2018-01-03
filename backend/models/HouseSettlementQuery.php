<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\HouseSettlement;

/**
 * HouseSettlementQuery represents the model behind the search form about `backend\models\HouseSettlement`.
 */
class HouseSettlementQuery extends HouseSettlement
{
    public $search_type;
    public $start_time;
    public $end_time;
    public $order_num;
    public $type;
    public $mobile;
    public $user_account;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'create_time', 'status', 'pay_time'], 'integer'],
            [['settle_id','account_bankcard.name','fail_cause','serial_number','order_num','mobile','user_account'], 'safe'],
            [['total', 'order_total', 'coupon_total'], 'number'],
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
        $query = HouseSettlement::find();
        $query->joinWith(['account'])->select(['account_bankcard.name','account_bankcard.account_number','house_settlement.*']);
        $query->joinWith(['user'])->select(['account_bankcard.name','house_settlement.*']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'create_time' => $this->create_time,
            'total' => $this->total,
            'order_total' => $this->order_total,
            'coupon_total' => $this->coupon_total,
            'pay_time' => $this->pay_time,
        ]);
        $query->andFilterWhere(['like', 'settle_id', $this->settle_id]);
        if($this->mobile){
            $uid=Yii::$app->db->createCommand("select id from user WHERE mobile=$this->mobile")->queryScalar();
            $query->andWhere(['house_settlement.uid'=>$uid]);
        }
        if($this->user_account){
            $uid=Yii::$app->db->createCommand("select uid from account_bankcard WHERE account_number='{$this->user_account}' AND is_default=1")->queryScalar();
            $query->andWhere(['house_settlement.uid'=>$uid]);
        }
        if($this->status){
            $query->andWhere(['house_settlement.status'=>$this->status]);
        }else{
            $query->andWhere(['house_settlement.status'=>0]);
        }
        return $dataProvider;
    }
}
