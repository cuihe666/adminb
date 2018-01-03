<?php

namespace backend\models;

use backend\controllers\HotelSupplierController;
use common\tools\Helper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\HotelSupplier;

/**
 * HotelSupplierQuery represents the model behind the search form about `backend\models\HotelSupplier`.
 */
class HotelSupplierQuery extends HotelSupplier
{
    public $optype;
    public $settle_status;
    public $settle_invoice;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'city', 'province', 'country', 'postcode', 'type', 'settle_type', 'status', 'invoice_status','settle_status','settle_invoice'], 'integer'],
            [['name', 'address', 'brand', 'start_time', 'end_time', 'business_license', 'license', 'agreement', 'other', 'create_time','optype','settle_status','settle_invoice'], 'safe'],
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
        $query = HotelSupplier::find()->with('hotels','cityName','settleList');
//        Helper::dd($query->all());

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30
            ]
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

        //同时存在账单结算状态和发票状态
        if($this->settle_status && $this->settle_invoice){
            $settle_status = (in_array($this->settle_status,[1,2]))? $this->settle_status -1 : 0;
            $settle_invoice = (in_array($this->settle_invoice,[1,2]))? $this->settle_invoice -1 : 0;
            $lastMonth = date('ymd',strtotime(Helper::lastMonth(true)[0]));
            $lastWeek = date('ymd',strtotime(Helper::lastWeek(true)[0]));
            $monthStatus = $lastMonth . '_' .$settle_status . '_' . $settle_invoice;
            $weekStatus = $lastWeek . '_' .$settle_status . '_' . $settle_invoice;
            $query->andWhere(['invoice_status' => [$monthStatus,$weekStatus]]);
        }
        //只存在发票状态
        if(!$this->settle_status && $this->settle_invoice){
            $settle_invoice = (in_array($this->settle_invoice,[1,2]))? $this->settle_invoice -1 : 0;
            $settle_status = [0,1];
            $period = [
                date('ymd',strtotime(Helper::lastMonth(true)[0])),
                date('ymd',strtotime(Helper::lastWeek(true)[0]))
            ];
            $condition = [];
            foreach ($settle_status as $status){
                foreach($period as $time){
                    $condition[] = $time . '_' . $status . '_' . $settle_invoice;
                }
            }

            $query->andWhere(['invoice_status' => $condition]);
        }

        //只存在结算状态
        if($this->settle_status && !$this->settle_invoice){
            $settle_status = (in_array($this->settle_status,[1,2]))? $this->settle_status -1 : 0;
            $settle_invoices = [0,1];
            $period = [
                date('ymd',strtotime(Helper::lastMonth(true)[0])),
                date('ymd',strtotime(Helper::lastWeek(true)[0]))
            ];
            $condition = [];

            foreach ($settle_invoices as $invoice){
                foreach($period as $time){
                    $condition[] = $time . '_' . $settle_status . '_' . $invoice;
                }
            }
//            Helper::dd($condition);
            $query->andWhere(['invoice_status' => $condition]);
        }


        if($this->start_time){
            $time = explode(" - ",$this->start_time);
            $time[0] = $time[0] . ' 00:00:00';
            $time[1] = $time[1] . ' 00:00:00';
            $query->orFilterWhere(['<=','start_time',$time[0]])->andWhere(['>=','end_time',$time[0]]);
            $query->orFilterWhere(['<=','start_time',$time[1]])->andWhere(['>=','end_time',$time[1]]);
            $query->orFilterWhere(['>=','start_time',$time[0]])->andWhere(['<=','end_time',$time[1]]);
            $query->orFilterWhere(['<=','start_time',$time[0]])->andWhere(['>=','end_time',$time[1]]);

        }
        if ($this->name !="") {
            $query->andwhere([
                'or',
                ['like','name',$this->name],
                ['id'=>$this->name],
            ]);
        }
        else{
            if($this->optype==1 && intval($this->id)==0){
                $query->andwhere([
                    'id'=>0,
                ]);
            }
            if ($this->id !="" && intval($this->id)!=0) {
                $query->andwhere([
                    'id'=>$this->id,
                ]);
            }
        }
        //dump($this);


//        if($this->city){
//            $this->cityName = HotelSupplierController::getCityName($this->city);
//        }


//        Helper::dd($params,$this->start_time);

        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            'city' => $this->city,
            'province' => $this->province,
            'country' => $this->country,
            'postcode' => $this->postcode,
            'type' => $this->type,
            'settle_type' => $this->settle_type,
            'status' => $this->status,
//            'invoice_status' => $this->invoice_status,
            'create_time' => $this->create_time,
        ]);

       /* $commandQuery = clone $query;
        echo $commandQuery->createCommand()->getRawSql();*/
        return $dataProvider;
    }

}
