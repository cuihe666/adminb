<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PlaneTicketOrderTicketRefundment;

/**
 * PlaneTicketOrderQuery represents the model behind the search form about `backend\models\PlaneTicketOrderTicketRefundmentQuery`.
 */
class PlaneTicketOrderTicketRefundmentQuery extends PlaneTicketOrderTicketRefundment
{
    public $refund_account;//退款报表页标记
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'ticket_supplier_id', 'refund_ticket_id', 'refundment_type', 'refundment_status', 'refundment_money',
                'refundment_desc', 'refundment_full_detail', 'create_time', 'update_time', 'admin_id'], 'safe'],
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
        $query = PlaneTicketOrderTicketRefundment::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        /**
         * @退款报表页标记
         */
        if (!empty($this->refund_account)) {
            $query->joinWith('planeRefundTicket');//关联退票记录表
            $query->joinWith('planeOrder');//关联机票订单表
            $query->joinWith('planeTicketPay');//关联机票支付记录表
            $query->joinWith('planeInsurancePay');//关联保险支付记录表

            $query->andWhere(['refundment_status' => 1]);//退款成功
        }
        //退款时间
        //下单时间查询
        if (!empty($this->create_time)) {
            $start_date = substr($this->create_time, 0, 10) . ' 00:00:00';
            $end_date = substr($this->create_time, 13) . ' 23:59:59';
            $query->andFilterWhere(['between', 'plane_ticket_order_ticket_refundment.create_time', $start_date, $end_date]);
        }

//        $query->asArray();
//        dd($query->createCommand()->getRawSql());
        return $dataProvider;
    }
}
