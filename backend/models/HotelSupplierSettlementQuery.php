<?php

namespace backend\models;

use backend\controllers\HotelSupplierController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\HotelSupplierSettlement;

/**
 * HotelSupplierSettlementQuery represents the model behind the search form about `backend\models\HotelSupplierSettlement`.
 */
class HotelSupplierSettlementQuery extends HotelSupplierSettlement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hotel_id', 'supplier_id', 'status', 'invoice'], 'integer'],
            [['settle_id', 'create_time', 'pay_time', 'fail_cause', 'supplier_list_note', 'serial_number', 'start_time', 'end_time', 'date_search', 'order_num'], 'safe'],
            [['total', 'order_total', 'coupon_total', 'agent_total', 'tangguo_total'], 'number'],
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
        $query = HotelSupplierSettlement::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 5],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->orderBy('id DESC');
        $query->joinWith('supplier');
//        if (!empty($this->status)) {
//            $query->joinWith('detail');
//        }
        // grid filtering conditions
        $query->andFilterWhere([
            'hotel_supplier_settlement.id' => $this->id,
            'hotel_supplier_settlement.supplier_id' => $this->supplier_id,
            'hotel_supplier_settlement.create_time' => $this->create_time,
            'total' => $this->total,
            'order_total' => $this->order_total,
            'coupon_total' => $this->coupon_total,
            'hotel_supplier_settlement.status' => $this->status,
            'pay_time' => $this->pay_time,
            'agent_total' => $this->agent_total,
            'tangguo_total' => $this->tangguo_total,
//            'start_time' => $this->start_time,
//            'end_time' => $this->end_time,
            'invoice' => $this->invoice,
        ]);
        //酒店账目
        if (!empty($this->hotel_id)) {
            $query->andWhere(['hotel_supplier_settlement.hotel_id' => $this->hotel_id]);
        }

        $query->andFilterWhere(['like', 'hotel_supplier_settlement.settle_id', $this->settle_id])
            ->andFilterWhere(['like', 'fail_cause', $this->fail_cause])
            ->andFilterWhere(['like', 'serial_number', $this->serial_number]);
        //账单周期
        if (!empty($this->start_time)) {
//            $query->joinWith('detail');
            $start_time = substr($this->start_time, 0, 10) . ' 00:00:00';
            $end_time = substr($this->start_time, 13) . ' 23:59:59';
            $query->andWhere(['>=', 'hotel_supplier_settlement.start_time', $start_time])
                ->andWhere(['<=', 'hotel_supplier_settlement.end_time', $end_time]);
        }
        //订单号查询
        if (!empty($this->order_num)) {
            $query->joinWith('detail');
            $query->andWhere(['like', 'order_num', $this->order_num]);
//            $query->with(['detail' => function($query) {
//                $query->Where(['like', 'order_num', $this->order_num]);
//            }]);
        }
        $query->asArray();
//        $data = clone $query;
//        echo $data->createCommand()->getRawSql();die;
        return $dataProvider;
    }
}
