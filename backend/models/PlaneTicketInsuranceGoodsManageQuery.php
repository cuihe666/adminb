<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PlaneTicketInsuranceGoodsManage;

/**
 * PlaneTicketInsuranceGoodsManageQuery represents the model behind the search form about `backend\models\PlaneTicketInsuranceGoodsManage`.
 */
class PlaneTicketInsuranceGoodsManageQuery extends PlaneTicketInsuranceGoodsManage
{
    /**
     * @存储查询语句
     */
    public $sql_info = NULL;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'type', 'ratio', 'admin_id'], 'integer'],
            [['price', 'insurance_fee'], 'number'],
            [['create_time', 'update_time', 'goods', 'supplier_name', 'insurance_type'], 'safe'],
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
        $query = PlaneTicketInsuranceGoodsManage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);
        //关联 plane_ticket_supplier 表
        $query->joinWith('supplier');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //保险收益列表 关联 plane_ticket_order 表
//        if (!empty($this->goods)) {
//            $query->joinWith('order');
//        }
        //日期查询
        if (!empty($this->order_pay_time)) {
            $query->with(['order' => function($query) {
                $start_date = substr($this->order_pay_time, 0, 10) . ' 00:00:00';
                $end_date = substr($this->order_pay_time, 13) . ' 00:00:00';
                $query->andWhere(['between', 'plane_ticket_order.payment_time', $start_date, $end_date]);
            }]);
        } else if (!empty($this->goods)) {//没有时间范围要求，默认的是查询-1天的前一个月的信息
            $query->with(['order' => function ($query) {
                $date = date('Y-m-d');
                $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', strtotime($date.'-1 day')).'-1 month'));
                $query->andWhere(['>', 'plane_ticket_order.payment_time', $start_date]);
            }]);
        }
        //类别查询
        if (!empty($this->insurance_type)) {
            $query->andWhere(['type' => $this->insurance_type]);
        }
        //保险供应商查询
        if (!empty($this->supplier_name)) {
            $query->andWhere(['plane_ticket_insurance_goods_manage.supplier_id' => $this->supplier_name]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'supplier_id' => $this->supplier_id,
//            'type' => $this->type,
            'price' => $this->price,
            'insurance_fee' => $this->insurance_fee,
            'ratio' => $this->ratio,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'admin_id' => $this->admin_id,
        ]);
        $this->sql_info = $query->createCommand()->getRawSql();

//        $query->asArray();
//        dd($query->createCommand()->getRawSql());

        return $dataProvider;
    }
}
