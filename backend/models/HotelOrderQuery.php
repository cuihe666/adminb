<?php

namespace backend\models;

use backend\service\CommonService;
use common\tools\Helper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\HotelOrder;

/**
 * HotelOrderQuery represents the model behind the search form about `backend\models\HotelOrder`.
 */
class HotelOrderQuery extends HotelOrder
{
    public $search_type;
    public $start_end;
    public $city_name;
    public $uid_phone;
    public $pay_status;
    public $settle_type; //结算周期(供应商部分使用)
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hotel_id', 'hotel_house_id', 'hotel_type', 'status', 'pay_platform', 'refund_rule', 'bed_type', 'breakfast', 'order_uid', 'province', 'city', 'area', 'mobile', 'is_delete'], 'integer'],
            [['order_num', 'transaction_id', 'hotel_name', 'hotel_house_name', 'order_mobile', 'prompt', 'preference', 'in_time', 'out_time', 'address', 'mobile_area', 'create_time', 'update_time','search_type','start_end','city_name','uid_phone','pay_status'], 'safe'],
            [['order_total', 'pay_total', 'hotel_income', 'tango_income'], 'number'],
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
    public function search($params,$type=null)
    {
        if($type == null){
            $query = HotelOrder::find()->with('hotel','cityName','user');
        }else{
            $query = HotelOrder::find()->with('orderGuest','orderItem');
            //结算状态下的订单
            $query->andWhere(['status' => [15,14]]);
        }

        if(!array_key_exists('sort',$params)){
            $query->orderBy(['id' => SORT_DESC]);
        }
        //@2017年11月13日11:44:18 fuyanfei to add join hotel_order_coupon [查询酒店订单使用的优惠券]
        $query->leftJoin("hotel_order_coupon","hotel_order.id = hotel_order_coupon.hotel_order_id");
        $query->select("hotel_order.*,hotel_order_coupon.money");
        //@2017-11-13 11:44:50 fuyanfei to add end


        $query->andWhere(['is_delete' => 0]);
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



        //筛选时间
        if($this->search_type && $this->start_end){
            $time = explode('-', $this->start_end);
            $start = $time[0] . " 00:00:00";
            $end = $time[1] . " 23:59:59";
            switch ($this->search_type){
                case 1:
                    $column = 'create_time';
                    break;
                case 2:
                    $column = 'in_time';
                    break;
                case 3:
                    $column = 'out_time';
                    break;
                default:
                    $column = 'create_time';
            }
            $query->andWhere(['between',$column,$start,$end]);
        }

        //筛选城市
        if($this->city_name){
            $city_code = CommonService::get_city_code1($this->city_name);
            if ($city_code === false) {
                $city_code = 88888;
            }
            $query->andFilterWhere(['city' => $city_code]);
        }

        //入住人手机号
        if($this->order_mobile){
            $query->andFilterWhere(['order_mobile' => trim($this->order_mobile)]);
        }

        //下单人手机号
        if($this->uid_phone){
            $uid = CommonService::get_uid($this->uid_phone);
            if ($uid === false) {
                $uid = 0;
            }
            $query->andFilterWhere(['order_uid' => $uid]);
        }

        //支付状态
        if($this->pay_status){
            if($this->pay_status == 1){
                $query->andFilterWhere(['status' => 0]);
            }else{
                $query->andFilterWhere(['>','status',0]);
            }
        }



        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'hotel_id' => $this->hotel_id,
            'hotel_house_id' => $this->hotel_house_id,
            'hotel_type' => $this->hotel_type,
//            'status' => $this->status,
            'pay_platform' => $this->pay_platform,
            'refund_rule' => $this->refund_rule,
            'bed_type' => $this->bed_type,
            'breakfast' => $this->breakfast,
            'order_uid' => $this->order_uid,
            'in_time' => $this->in_time,
            'out_time' => $this->out_time,
            'province' => $this->province,
//            'city' => $this->city,
            'area' => $this->area,
            'mobile' => $this->mobile,
            'order_total' => $this->order_total,
            'pay_total' => $this->pay_total,
            'hotel_income' => $this->hotel_income,
            'tango_income' => $this->tango_income,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
//            'is_delete' => $this->is_delete,
        ]);

        $query->andFilterWhere(['like', 'order_num', $this->order_num])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id])
            ->andFilterWhere(['like', 'hotel_name', $this->hotel_name])
            ->andFilterWhere(['like', 'hotel_house_name', $this->hotel_house_name])
            ->andFilterWhere(['like', 'order_mobile', $this->order_mobile])
            ->andFilterWhere(['like', 'prompt', $this->prompt])
            ->andFilterWhere(['like', 'preference', $this->preference])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'mobile_area', $this->mobile_area]);

        //酒店订单状态
        if (!empty($this->status)) {
            if ($this->status == 34) {
                $query->andWhere(['is_deny' => 1]);
            } else {
                $query->andWhere(['status' => $this->status])
                    ->andWhere(['is_deny' => 0]);
            }
        }
//        $data = clone $query;
//        echo $data->createCommand()->getRawSql();die;
        return $dataProvider;
    }
}
