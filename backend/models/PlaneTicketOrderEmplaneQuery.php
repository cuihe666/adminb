<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PlaneTicketOrderEmplane;

/**
 * PlaneTicketOrderEmplaneQuery represents the model behind the search form about `backend\models\PlaneTicketOrderEmplane`.
 */
class PlaneTicketOrderEmplaneQuery extends PlaneTicketOrderEmplane
{
    /**
     * @公共搜索变量
     */
    public $supplier_name;
    public $order_date;
    public $insurance_detail_note;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'ticket_supplier_id', 'insurance_supplier_id', 'ticket_type', 'insurance_type', 'card_type', 'refund_ticket_status', 'admin_id'], 'integer'],
            [['pre_price', 'insurance_money', 'mb_fuel', 'ticket_commision', 'insurance_commision'], 'number'],
            [['name', 'phone', 'card_no', 'ticket_no', 'profit_detail', 'insurance_no', 'insurance_detail_note', 'create_time', 'update_time', 'supplier_name', 'order_date', 'refund_insurance_status'], 'safe'],
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
        $query = PlaneTicketOrderEmplane::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);
        //按照时间降序排列
        $dataProvider->setSort([
            'defaultOrder' => [
                'create_time' => SORT_DESC
            ]
        ]);

        //关联 plane_ticket_order 表
        $query->joinWith('order');
        //关联 plane_ticket_supplier 表
        $query->joinWith('supplier');
        //关联 plane_ticket_order_insurance_pay 表
        $query->joinWith('pay');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'plane_ticket_order_emplane.ticket_supplier_id' => $this->ticket_supplier_id,
        ]);
        //去除未下保单的乘机人
        if (!empty($this->insurance_detail_note)) {
            $query->andWhere(['<>', 'plane_ticket_order_emplane.insurance_type', 0]);
        }
        $query->andFilterWhere(['like', 'name', $this->name]);
        //供应商名称搜索
        if (!empty($this->supplier_name)) {
            $query->andFilterWhere(['plane_ticket_order_emplane.insurance_supplier_id' => $this->supplier_name]);
        }
        //订单时间
        if (!empty($this->order_date)) {
            $start_date = substr($this->order_date, 0, 10) . ' 00:00:00';
            $end_date = substr($this->order_date, 13) . ' 00:00:00';
            $query->andFilterWhere(['between', 'plane_ticket_order.create_time', $start_date, $end_date]);
        }
        //保单状态查询
        if (!empty($this->refund_insurance_status)) {
            if ($this->refund_insurance_status == 2) {//退保
                $query->andWhere(['refund_insurance_status' => 2]);
            } else {//未退保
                $query->andWhere(['<>', 'refund_insurance_status', 2]);
            }
        }
        //机票费用及收益佣金详情页
        if (!empty($this->profit_detail)) {
            $session = Yii::$app->session;
            if (!isset($session['profit_date'])) {
                $query->andWhere(['>', 'plane_ticket_order.payment_time', $session['profit_date']['start_date']]);
            } else if ($session['profit_date']['note'] == 'between') {
                $query->andWhere(['between', 'plane_ticket_order.payment_time', $session['profit_date']['start_date'], $session['profit_date']['end_date']]);
            } else {
                $query->andWhere(['>', 'plane_ticket_order.payment_time', $session['profit_date']['start_date']]);
            }
        }

//        dd($query->createCommand()->getRawSql());
//        $query->asArray();
        return $dataProvider;
    }
}
