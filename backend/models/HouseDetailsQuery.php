<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\HouseDetails;
use backend\service\CommonService;

/**
 * HouseDetailsQuery represents the model behind the search form about `backend\models\HouseDetails`.
 */
class HouseDetailsQuery extends HouseDetails
{
    /**
     * @inheritdoc
     */
    public $start_time;
    public $s_status;
    public $city_name;
    public $mobile;
    public $province;
    public $city;
    public $area;
    public $tango_weight;
    public $type;
    public $low_price;
    public $height_price;
    public $country;
    public $house_type;
    public $house_id;

    public function rules()
    {
        return [
            [['id', 'minday', 'roomsize', 'deposit', 'is_deposit', 'is_welcome', 'uid', 'lbs_id', 'total_stock', 'is_realtime', 'intime', 'outtime', 'over_man', 'province', 'city', 'area'], 'integer'],
            [['title', 'introduce', 'cover_img', 'tel', 'longitude', 'latitude', 'address', 'vague_addr', 'doornum', 'create_time', 'update_date', 'notice', 'secret_notice', 'start_sell', 'end_sell', 'start_time', 'city_name', 'type', 'low_price', 'height_price', 'country', 'house_type','salesman'], 'safe'],
            [['clean_fee', 'over_fee', 's_status', 'mobile', 'low_price', 'height_price','up_type','house_id'], 'number'],
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
        $query = HouseDetails::find();

        $query->joinWith(['user']);
//        $query->joinWith(['househotel']);
        $query->joinWith(['houseserach']);
        $query->select("user.*, house_search.*,house_search.create_time, house_search.tango_weight as tango_weight,house_details.*,,dt_house_type.`type_name`,dt_house_type_code.`code_name`");
        $query->leftJoin("dt_house_type","house_search.`roomtype` = dt_house_type.`id`");
        $query->leftJoin("dt_house_type_code","dt_house_type.`code` = dt_house_type_code.`id`");


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'house_details.create_time',
                'tango_weight' => [
                    'asc' => ['house_search.tango_weight' => SORT_ASC],
                    'desc' => ['house_search.tango_weight' => SORT_DESC],
                    'label' => '排序值'
                ],
//                'sort' => [
//                    'asc' => ['sort' => SORT_ASC],
//                    'desc' => ['sort' => SORT_DESC],
//                    'label' => '排序值'
//                ],
                /*=============*/
            ],
            'defaultOrder' => [
                'house_details.create_time' => SORT_DESC,
            ]


        ]);

        $this->load($params);
        if (isset($params['id'])) {
            $query->andFilterWhere([
                'house_search.uid' => $params['id'],

            ]);

        }
        if($this->house_id != ''){
            $house_id_arr = explode(',',trim($this->house_id,','));
//            var_dump($house_id_arr);exit;
            $query->andFilterWhere(['in','house_details.id',$house_id_arr]);
        }
//        echo $query->createCommand()->getRawSql();exit;
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'minday' => $this->minday,
            'roomsize' => $this->roomsize,
            'deposit' => $this->deposit,
            'create_time' => $this->create_time,
            'update_date' => $this->update_date,
            'is_deposit' => $this->is_deposit,
            'is_welcome' => $this->is_welcome,
            'uid' => $this->uid,
            'lbs_id' => $this->lbs_id,
            'total_stock' => $this->total_stock,
            'is_realtime' => $this->is_realtime,
            'intime' => $this->intime,
            'outtime' => $this->outtime,
            'start_sell' => $this->start_sell,
            'end_sell' => $this->end_sell,
            'clean_fee' => $this->clean_fee,
            'over_man' => $this->over_man,
//            'house_search.status' => $this->s_status,
            'house_search.province' => $this->province,
            'house_search.city' => $this->city,
            'house_search.area' => $this->area,
        ]);
        if($this->house_type)
        {
            $query->andFilterWhere([
                'dt_house_type.code' => $this->house_type,
            ]);
            /*$query->andFilterWhere([
                'house_search.roomtype' => $this->house_type,
            ]);*/
        }
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'introduce', $this->introduce])
            ->andFilterWhere(['like', 'cover_img', $this->cover_img])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'longitude', $this->longitude])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'vague_addr', $this->vague_addr])
            ->andFilterWhere(['like', 'doornum', $this->doornum])
            ->andFilterWhere(['like', 'notice', $this->notice])
            ->andFilterWhere(['like', 'secret_notice', $this->secret_notice]);

        if ($this->s_status == -1) {
            $query->andWhere(['house_search.status' => -1]);
        }

        if ($this->s_status == 4) {
            $query->andWhere(['house_search.status' => 4]);
        }

        if ($this->s_status == 2) {
            $query->andWhere(['house_search.online' => 0]);
            $query->andWhere(['house_search.status' => 1]);
        }

        if ($this->s_status == 1) {
            $query->andWhere(['house_search.online' => 1]);
            $query->andWhere(['house_search.status' => 1]);
//            $query->andWhere(['house_search.is_delete' => 0]);
        }

        if ($this->s_status == 6) {
            $query->andWhere(['house_search.status' => 0]);

        }

        if ($this->s_status == 3) {
            $query->andWhere(['house_search.status' => 3]);

        }
        if ($this->country == 1) {
            $query->andWhere(['house_search.national' => 10001]);
        }

        if ($this->country == 2) {
            $query->andWhere((['!=', 'house_search.national', 10001]));
        }
        //增加上传方式筛选
        if($this->up_type != ''){
            $query->andWhere(['=','house_details.up_type',$this->up_type]);
        }
        //增加房源管理员筛选
        if($this->salesman != ''){
//            $query->andWhere(['=','house_details.salesman',$this->salesman]);
            $query->andWhere(['like', 'house_details.salesman', $this->salesman]);
        }
        //增加房源ID筛选

        if($this->house_id != ''){
            $house_id_arr = explode(',',trim($this->house_id,','));
//            var_dump($house_id_arr);exit;
            $query->andFilterWhere(['in','house_details.id',$house_id_arr]);
        }


//        $query->andWhere(['!=', 'house_search.is_delete', 1]);
//        $query->andWhere(['!=', 'house_search.status', -1]);


        if ($this->start_time && $this->type) {

            $start = substr($this->start_time, 0, 10) . ' 00:00:00';
            $end = substr($this->start_time, 13) . ' 00:00:00';

            switch ($this->type) {
                case 1:
                    $query->andWhere(['between', 'house_details.create_time', $start, $end]);
                    break;
                case 2:
                    $query->andWhere(['between', 'house_details.update_date', $start, $end]);
                    break;
                case 3:
                    $query->andWhere(['between', 'house_details.check_time', $start, $end]);
                    break;
            }
        }

        if ($this->city_name != '') {
            $city_code = CommonService::get_city_code($this->city_name);
            if ($city_code === false) {
                $city_code = 88888;
                $query->andFilterWhere(['house_search.city' => $city_code]);
            } else {
                foreach ($city_code as $k => $v) {
                    if ($v['level'] == 2) {
                        $city_arr[] = $v['code'];
                    }
                    if ($v['level'] == 3) {
                        $area[] = $v['code'];
                    }
                }
                if (isset($city_arr) && $city_arr) {
                    $query->andWhere(['in', 'house_search.city', $city_arr]);
                } elseif (isset($area) && $area) {

                    $query->andWhere(['in', 'house_search.area', $area]);
                } elseif ((isset($city_arr) && $city_arr) && (isset($area) && $area)) {
                    $query->andWhere(['or', ['in', 'house_search.city', $city_arr], ['in', 'house_search.area', $area]]);
                }

            }
        }
        if ($this->mobile != '') {
            $uid = CommonService::get_uid($this->mobile);
            if ($uid === false) {
                $uid = 0;
            }
            $query->andFilterWhere(['house_details.uid' => $uid]);
        }

        if ($this->low_price != '' && $this->height_price != '') {
            $query->andWhere(['between', 'house_search.price', $this->low_price, $this->height_price]);


        }

        if ($this->low_price != '' && $this->height_price == '') {
            $query->andWhere(['>=', 'price', $this->low_price]);


        }
        if ($this->low_price == '' && $this->height_price != '') {
            $query->andWhere(['<=', 'price', $this->height_price]);


        }

        $query->andWhere(['house_search.is_delete'=>0]);
//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();

        return $dataProvider;
    }

    /*
     * 下架操作查询
     * */
    public function mutisearch($params)
    {
//        var_dump($params);
//        $params = $params['HouseDetailsQuery'];
        $query = HouseDetails::find();

        $query->joinWith(['user']);

        $query->joinWith(['houseserach']);
        $query->select("user.*, house_search.*,house_search.create_time, house_search.tango_weight as tango_weight,house_details.*");


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10000,
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'house_details.create_time',
                'tango_weight' => [
                    'asc' => ['house_search.tango_weight' => SORT_ASC],
                    'desc' => ['house_search.tango_weight' => SORT_DESC],
                    'label' => '排序值'
                ],
            ],
            'defaultOrder' => [
                'house_details.create_time' => SORT_DESC,
            ]


        ]);
//        var_dump($params);exit;

        $this->load($params);
        if (isset($params['id'])) {
            $query->andFilterWhere([
                'house_search.uid' => $params['id'],
            ]);

        }
//var_dump($params['type']);exit;
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'minday' => $this->minday,
            'roomsize' => $this->roomsize,
            'deposit' => $this->deposit,
            'create_time' => $this->create_time,
            'update_date' => $this->update_date,
            'is_deposit' => $this->is_deposit,
            'is_welcome' => $this->is_welcome,
            'uid' => $this->uid,
            'lbs_id' => $this->lbs_id,
            'total_stock' => $this->total_stock,
            'is_realtime' => $this->is_realtime,
            'intime' => $this->intime,
            'outtime' => $this->outtime,
            'start_sell' => $this->start_sell,
            'end_sell' => $this->end_sell,
            'clean_fee' => $this->clean_fee,
            'over_man' => $this->over_man,
//            'house_search.status' => $this->s_status,
            'house_search.province' => $this->province,
            'house_search.city' => $this->city,
            'house_search.area' => $this->area,
        ]);
        if($this->house_type)
        {

            $query->andFilterWhere([
                'house_search.roomtype' => $this->house_type,
            ]);
        }
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'introduce', $this->introduce])
            ->andFilterWhere(['like', 'cover_img', $this->cover_img])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'longitude', $this->longitude])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'vague_addr', $this->vague_addr])
            ->andFilterWhere(['like', 'doornum', $this->doornum])
            ->andFilterWhere(['like', 'notice', $this->notice])
            ->andFilterWhere(['like', 'secret_notice', $this->secret_notice]);
        //标题搜索
//        if (!empty($this->title)) {
//            $search_title = $this->title;
//            if (strpos($this->title, '_') !== false) {//标题中包含'_'，可能为同程房源标题搜索，做特殊处理
//                //将酒店名、房型名拆分开来
//                $title_data = explode('_', $this->title);
//                //只对房型名称进行修改
//                $search_title = $title_data[1];
//            }
//            $query->andFilterWhere(['like', 'title', $search_title]);
//
//        }

        if ($this->s_status == -1) {
            $query->andWhere(['house_search.status' => -1]);
        }

        if ($this->s_status == 4) {
            $query->andWhere(['house_search.status' => 4]);
        }

        if ($this->s_status == 2) {
            $query->andWhere(['house_search.online' => 0]);
            $query->andWhere(['house_search.status' => 1]);
        }

        if ($this->s_status == 1) {
            $query->andWhere(['house_search.online' => 1]);
            $query->andWhere(['house_search.status' => 1]);
//            $query->andWhere(['house_search.is_delete' => 0]);
        }

        if ($this->s_status == 6) {
            $query->andWhere(['house_search.status' => 0]);

        }

        if ($this->s_status == 3) {
            $query->andWhere(['house_search.status' => 3]);

        }
        if ($this->country == 1) {
            $query->andWhere(['house_search.national' => 10001]);
        }

        if ($this->country == 2) {
            $query->andWhere((['!=', 'house_search.national', 10001]));
        }
//        var_dump($params['up_type']);exit;
        //增加上传方式筛选
        if($this->up_type != ''){
            $query->andWhere(['=','house_details.up_type',$this->up_type]);
        }
        //增加房源管理员筛选
        if($this->salesman != ''){
//            $query->andWhere(['=','house_details.salesman',$this->salesman]);
            $query->andWhere(['like', 'house_details.salesman', $this->salesman]);
        }
        //增加房源ID筛选
        if($this->house_id != ''){
            $query->andWhere(['=','house_details.id',$this->house_id]);
        }


//        $query->andWhere(['!=', 'house_search.is_delete', 1]);
//        $query->andWhere(['!=', 'house_search.status', -1]);


        if ($this->start_time && $this->type) {

            $start = substr($this->start_time, 0, 10) . ' 00:00:00';
            $end = substr($this->start_time, 13) . ' 00:00:00';

            switch ($this->type) {
                case 1:
                    $query->andWhere(['between', 'house_details.create_time', $start, $end]);
                    break;
                case 2:
                    $query->andWhere(['between', 'house_details.update_date', $start, $end]);
                    break;
                case 3:
                    $query->andWhere(['between', 'house_details.check_time', $start, $end]);
                    break;
            }
        }

        if ($this->city_name != '') {
            $city_code = CommonService::get_city_code($this->city_name);
            if ($city_code === false) {
                $city_code = 88888;
                $query->andFilterWhere(['house_search.city' => $city_code]);
            } else {
                foreach ($city_code as $k => $v) {
                    if ($v['level'] == 2) {
                        $city_arr[] = $v['code'];
                    }
                    if ($v['level'] == 3) {
                        $area[] = $v['code'];
                    }
                }
                if (isset($city_arr) && $city_arr) {
                    $query->andWhere(['in', 'house_search.city', $city_arr]);
                } elseif (isset($area) && $area) {

                    $query->andWhere(['in', 'house_search.area', $area]);
                } elseif ((isset($city_arr) && $city_arr) && (isset($area) && $area)) {
                    $query->andWhere(['or', ['in', 'house_search.city', $city_arr], ['in', 'house_search.area', $area]]);
                }

            }
        }
        if ($this->mobile != '') {
            $uid = CommonService::get_uid($this->mobile);
            if ($uid === false) {
                $uid = 0;
            }
            $query->andFilterWhere(['house_details.uid' => $uid]);
        }

        if ($this->low_price != '' && $this->height_price != '') {
            $query->andWhere(['between', 'house_search.price', $this->low_price, $this->height_price]);


        }

        if ($this->low_price != '' && $this->height_price == '') {
            $query->andWhere(['>=', 'price', $this->low_price]);


        }
        if ($this->low_price == '' && $this->height_price != '') {
            $query->andWhere(['<=', 'price', $this->height_price]);


        }

        $query->andWhere(['house_search.is_delete'=>0]);
        return $dataProvider;
    }
}
