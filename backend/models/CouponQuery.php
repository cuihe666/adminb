<?php

namespace backend\models;

use common\tools\Helper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Coupon;

/**
 * CouponQuery represents the model behind the search form about `backend\models\Coupon`.
 */
class CouponQuery extends Coupon
{
    public $mobile;
    public $order_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'rule', 'amount', 'is_forever', 'mode', 'type', 'uid', 'batch_id', 'status', 'platform'], 'integer'],
            [['title', 'redeem_code', 'start_time', 'end_time', 'batch_code', 'update_time', 'create_time','mobile','order_id'], 'safe'],
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
    public function search($params,$coupon = null)
    {
        if(is_null($coupon)){
            $query = Coupon::find();
        }else{
            $query = $coupon;
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if(is_null($params)) return $dataProvider;

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        if($this->mobile){
            $user = User::find()->where(['mobile' => $this->mobile])->select(['id','mobile'])->one();
            $this->uid = $user ? $user->id :  1;
        }

        if($this->order_id){
            $order = CouponUsed::find()->where(['order_id' => $this->order_id])->select(['id','coupon_id'])->one();
            $this->id = $order ? $order->coupon_id : 1;
        }



        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'rule' => $this->rule,
            'amount' => $this->amount,
            'is_forever' => $this->is_forever,
            'mode' => $this->mode,
            'type' => $this->type,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'uid' => $this->uid,
            'batch_id' => $this->batch_id,
            'status' => $this->status,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
            'platform' => $this->platform,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'redeem_code', $this->redeem_code])
            ->andFilterWhere(['like', 'batch_code', $this->batch_code]);

        return $dataProvider;
    }
}
