<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PlaneTicketSupplier;

/**
 * PlaneTicketSupplierQuery represents the model behind the search form about `backend\models\PlaneTicketSupplier`.
 */
class PlaneTicketSupplierQuery extends PlaneTicketSupplier
{
    /**
     * @公共参数
     */
    public $supplier_note;
    public $insurance_note;
    public $profit;//机票费用/收益管理标记
    public $supplier_name;//机票收益页-代理商名称查询
    public $order_create_time;//订单创建时间
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ticket_genre', 'insurance_genre', 'is_use', 'admin_id'], 'integer'],
            [['name', 'address', 'contacts', 'order_create_time', 'payment_time', 'profit', 'supplier_name', 'contacts_phone', 'create_time', 'update_time', 'supplier_note', 'insurance_note'], 'safe'],
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
        $query = PlaneTicketSupplier::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //查询订单创建时间
        if ($this->order_create_time) {
            $query->with(['order' => function($query) {
                $start_date = substr($this->order_create_time, 0, 10) . ' 00:00:00';
                $end_date = substr($this->order_create_time, 13) . ' 00:00:00';
                $session = Yii::$app->session;
                $session['profit_date'] = [
                    'start_date' => $start_date,
                    'end_date'   => $end_date,
                    'note'       => 'between'
                ];
                $query->andWhere(['between', 'plane_ticket_order.payment_time', $start_date, $end_date]);
            }]);
        } else if (!empty($this->profit)) {
            $query->with(['order' => function ($query) {
                $date = date('Y-m-d');
                $start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', strtotime($date.'-1 day')).'-1 month'));
                $session = Yii::$app->session;
                $session['profit_date'] = [
                    'start_date' => $start_date,
                    'note'       => 'greater'
                ];
                $query->andWhere(['>', 'plane_ticket_order.payment_time', $start_date]);
            }]);
        }
        //区分供应商和保险公司
        if (!empty($this->supplier_note)) {
            $query->where(['insurance_genre' => 0]);//不是保险公司
        }
        if (!empty($this->insurance_note)) {
            $query->where(['ticket_genre' => 0]);//不是机票供应商
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ticket_genre' => $this->ticket_genre,
            'insurance_genre' => $this->insurance_genre,
            'is_use' => $this->is_use,
//            'create_time' => $this->create_time,
//            'update_time' => $this->update_time,
            'admin_id' => $this->admin_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'contacts', $this->contacts])
            ->andFilterWhere(['like', 'contacts_phone', $this->contacts_phone]);
        //查询代理商姓名（机票受益搜索）
        if (!empty($this->supplier_name)) {
            $query->andFilterWhere(['like', 'plane_ticket_supplier.name', $this->supplier_name]);
        }
//        $query->asArray();
//        dd($query->createCommand()->getRawSql());

        return $dataProvider;
    }
}
