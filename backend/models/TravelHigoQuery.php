<?php

namespace backend\models;

use backend\service\CommonService;
use backend\service\RegionService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TravelHigo;

/**
 * TravelHigoQuery represents the model behind the search form about `backend\models\TravelHigo`.
 */
class TravelHigoQuery extends TravelHigo
{

    public $stime;
    public $scity;
    public $ecity;
    public $account;
    public $higo_arr;          //付燕飞 2017年3月28日10:39:45 添加 【主要用来统计每个二维码城市下活动线路的点击量】并在rules中设置为safe
    public $click_num;         //付燕飞 2017年3月28日10:40:52 添加 【统计每条线路的点击量】并在rules中设置为safe
    public $qrcode_id;         //付燕飞 2017年3月28日10:56:01 添加 【当前线路绑定的二维码id】
    public $nature;
    public $keywords;          //付燕飞 2017年6月29日17:50:11 添加搜索关键词。
    public $aptitude;          //付燕飞 2017年6月30日11:29:58 增加 资质
    public $nickname;         //付燕飞 2017-6-30 11:30:13 增加昵称
    public $status_arr;       //付燕飞 2017年7月1日10:02:24增加状态数组
    public $ctime;             //付燕飞 2017年7月1日 11:48:56 增加审核时间
    public $resource;         //@2017-7-21 14:40:14 fuyanfei to add 来源

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_province', 'start_country', 'end_province', 'end_country', 'is_confirm', 'refund_type', 'read_count', 'create_time', 'update_time', 'is_del', 'uid', 'close_day', 'status', 'step', 'tango', 'num'], 'integer'],
            [['name', 'tag', 'start_city', 'end_city', 'profiles', 'high_light', 'start_time', 'end_time', 'price_in', 'price_out', 'refund_note', 'note', 'read_link', 'title_pic', 'auth_name', 'auth_recommend', 'auth_license', 'auth_operation', 'stime', 'scity', 'ecity', 'identity', 'user_auth', 'account', 'id', 'higo_arr', 'click_num', 'qrcode_id','nature','keywords','sort','sort_start_date','sort_end_date','status_arr','nickname','ctime','resource'], 'safe'],
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
        //表连接查询资质信息，如果identity=0，取企业资质，identity=1，取的是个人资质
        $query = TravelHigo::find()
            ->select("travel_higo.*,(CASE WHEN travel_higo.identity = 0 THEN c.name ELSE p.name END) AS aptitude,(CASE WHEN travel_higo.identity = 0 THEN c.brandname ELSE p.nick_name END) AS nickname")
            ->leftJoin("travel_person as p","travel_higo.uid = p.uid")
            ->leftJoin("travel_company as c","travel_higo.uid = c.uid")
            ->with('userMobile')
            ->with('startCityName')
            ->with('endCityName');


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            /*'pagination' => [
                'pageSize' => 30
            ]*/
        ]);
        //按照添加顺序降序排列
        $dataProvider->setSort([
            'defaultOrder' => [
                //'sort' => SORT_DESC,
                'id' => SORT_ASC
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($this->stime != '') {
            $start = substr($this->stime, 0, 10) . ' 00:00:00';
            $end = substr($this->stime, 13) . ' 23:59:59';
            $query->andWhere(['between', 'travel_higo.create_time', $start, $end]);
        }

        //2017年7月5日11:34:51 付燕飞增加按照审核时间查询
        if($this->ctime != ""){
            $start = substr($this->ctime, 0, 10) . ' 00:00:00';
            $end = substr($this->ctime, 13) . ' 23:59:59';

            $sql = "select obj_id from travel_operation_log where type = 4 and create_time BETWEEN '".$start."' and '".$end."' GROUP BY obj_id";
            $obj_id = Yii::$app->db->createCommand($sql)->queryAll();
            $obj_id_arr = [-1];
            if(!empty($obj_id)){
                foreach($obj_id as $key=>$val){
                    $obj_id_arr[] = $val['obj_id'];
                }
            }
            $query->andWhere(['in','travel_higo.id', $obj_id_arr]);
        }

        $query->andWhere(['!=', 'travel_higo.status', 4]);
        $query->andWhere(['!=', 'travel_higo.status', -1]);

        // grid filtering conditions
        $query->andFilterWhere([
            'travel_higo.id' => $this->id,
            'start_province' => $this->start_province,
            'start_country' => $this->start_country,
            'end_province' => $this->end_province,
            'end_country' => $this->end_country,
            'is_confirm' => $this->is_confirm,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'refund_type' => $this->refund_type,
            'read_count' => $this->read_count,
            'travel_higo.create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'is_del' => $this->is_del,
            'travel_higo.uid' => $this->uid,
            'close_day' => $this->close_day,
            'step' => $this->step,
            'tango' => $this->tango,
            'num' => $this->num,
            'identity' => $this->identity,
            'user_auth' => $this->user_auth,
        ]);

        //2017年6月23日16:20:58        如果搜索条件不为空，读取对应的搜索条件
        if($this->status != ""){
            $query->andWhere([
                'travel_higo.status' => $this->status
            ]);
        }

        //2017年7月1日 10:03:37 付燕飞增加 旅游商品管理只读取上下线的线路
        if($this->status_arr){
            $query->andWhere(['in','travel_higo.status', $this->status_arr]);
        }

        //@2017-7-21 14:40:40 fuyanfei to add 来源，如果resource==1 ，则是商品管理，需要读取资质审核通过的线路
        if($this->resource==1){
            $query->andWhere([
                'or',
                ['c.status'=>1],
                ['p.status'=>1],
            ]);
        }

        if ($this->scity != '') {
            $city_code = CommonService::get_city_code1($this->scity);
            if ($city_code === false) {
                $city_code = 88888;
            }
            $query->andFilterWhere(['start_city' => $city_code]);
        }

        if ($this->ecity != '') {
            $city_code = CommonService::get_city_code1($this->ecity);
            if ($city_code === false) {
                $city_code = 88888;
            }
            $query->andFilterWhere(['end_city' => $city_code]);
        }

        if ($this->account) {
            $query->andFilterWhere([
                'travel_higo.id' => $this->id,
                'travel_higo.uid' => TravelPerson::getuid($this->account),
            ]);
        }
        //关键词搜索
        if ($this->keywords !="") {
            $query->andWhere([
                'or',
                ['like','travel_higo.name',$this->keywords],
                ['travel_higo.id'=>$this->keywords],
            ]);
        }

        if ($this->tag) {
            $query->andWhere(new \yii\db\Expression("find_in_set($this->tag,tag)"));
        }
        if($this->nature != ''){
            //@2017-7-21 13:45:16 fuyanfei to update 根据资质名称模糊查询所有的个人资质或者企业资质的信息
            //$query->andFilterWhere(['travel_higo.uid' => TravelCompany::getUidStr($this->nature)]);
            $uidArr = TravelCompany::getUidArr($this->nature);
            $query->andWhere(['in', 'travel_higo.uid',$uidArr]);
        }
        $query->andFilterWhere(['like', 'travel_higo.name', $this->name])
            ->andFilterWhere(['like', 'tag', $this->tag])
            ->andFilterWhere(['like', 'start_city', $this->start_city])
            ->andFilterWhere(['like', 'end_city', $this->end_city])
            ->andFilterWhere(['like', 'profiles', $this->profiles])
            ->andFilterWhere(['like', 'high_light', $this->high_light])
            ->andFilterWhere(['like', 'price_in', $this->price_in])
            ->andFilterWhere(['like', 'price_out', $this->price_out])
            ->andFilterWhere(['like', 'refund_note', $this->refund_note])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'read_link', $this->read_link])
            ->andFilterWhere(['like', 'title_pic', $this->title_pic])
            ->andFilterWhere(['like', 'auth_name', $this->auth_name])
            ->andFilterWhere(['like', 'auth_recommend', $this->auth_recommend])
            ->andFilterWhere(['like', 'auth_license', $this->auth_license])
            ->andFilterWhere(['like', 'auth_operation', $this->auth_operation]);

//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();

        return $dataProvider;
    }

    /**
     * 用来统计当前活动在不同二维码城市下的点击量
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchForCount($params)
    {
        $query = TravelHigo::find();
        //$query->joinWith(['click']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->higo_arr)) {
            $query->andWhere(['in', 'travel_higo.id', $this->higo_arr]);
        }
        /*if(intval($this->qrcode_id)!=0){
            $query->andWhere([
                'travel_higo_click.qrcode_id' => $this->qrcode_id,
            ]);
        }*/


        $query->andWhere(['!=', 'status', 4]);
        $query->andWhere(['!=', 'status', -1]);

        if ($this->scity != '') {
            //$city_code = CommonService::get_city_code($this->scity);
            $city_code = RegionService::get_code($this->scity, 2);
            if ($city_code === false) {
                $city_code = 88888;
            }
            $query->andFilterWhere(['start_city' => $city_code]);
        }

        if ($this->ecity != '') {
            //$city_code = CommonService::get_city_code($this->ecity);
            $city_code = RegionService::get_code($this->ecity, 2);
            if ($city_code === false) {
                $city_code = 88888;
            }
            $query->andFilterWhere(['end_city' => $city_code]);
        }


        if ($this->tag) {
            $query->andWhere(new \yii\db\Expression("find_in_set($this->tag,tag)"));

        }




        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tag', $this->tag])
            ->andFilterWhere(['like', 'start_city', $this->start_city])
            ->andFilterWhere(['like', 'end_city', $this->end_city])
            ->andFilterWhere(['like', 'profiles', $this->profiles])
            ->andFilterWhere(['like', 'high_light', $this->high_light])
            ->andFilterWhere(['like', 'price_in', $this->price_in])
            ->andFilterWhere(['like', 'price_out', $this->price_out])
            ->andFilterWhere(['like', 'refund_note', $this->refund_note])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'read_link', $this->read_link])
            ->andFilterWhere(['like', 'title_pic', $this->title_pic])
            ->andFilterWhere(['like', 'auth_name', $this->auth_name])
            ->andFilterWhere(['like', 'auth_recommend', $this->auth_recommend])
            ->andFilterWhere(['like', 'auth_license', $this->auth_license])
            ->andFilterWhere(['like', 'auth_operation', $this->auth_operation]);

        return $dataProvider;
    }

    /**
     * 获取简单的higo活动列表
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchForActive($params)
    {
        $query = TravelHigo::find();
        $query->joinWith(['click']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->higo_arr)) {
            $query->andWhere(['in', 'travel_higo.id', $this->higo_arr]);
        }
        if (intval($this->qrcode_id) != 0) {
            $query->andWhere([
                'travel_higo_click.qrcode_id' => $this->qrcode_id,
            ]);
        }


        $query->andWhere(['!=', 'status', 4]);
        $query->andWhere(['!=', 'status', -1]);

        if ($this->scity != '') {
            //$city_code = CommonService::get_city_code($this->scity);
            $city_code = RegionService::get_code($this->scity, 2);
            if ($city_code === false) {
                $city_code = 88888;
            }
            $query->andFilterWhere(['start_city' => $city_code]);
        }

        if ($this->ecity != '') {
            //$city_code = CommonService::get_city_code($this->ecity);
            $city_code = RegionService::get_code($this->ecity, 2);
            if ($city_code === false) {
                $city_code = 88888;
            }
            $query->andFilterWhere(['end_city' => $city_code]);
        }


        if ($this->tag) {
            $query->andWhere(new \yii\db\Expression("find_in_set($this->tag,tag)"));

        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tag', $this->tag])
            ->andFilterWhere(['like', 'start_city', $this->start_city])
            ->andFilterWhere(['like', 'end_city', $this->end_city])
            ->andFilterWhere(['like', 'profiles', $this->profiles])
            ->andFilterWhere(['like', 'high_light', $this->high_light])
            ->andFilterWhere(['like', 'price_in', $this->price_in])
            ->andFilterWhere(['like', 'price_out', $this->price_out])
            ->andFilterWhere(['like', 'refund_note', $this->refund_note])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'read_link', $this->read_link])
            ->andFilterWhere(['like', 'title_pic', $this->title_pic])
            ->andFilterWhere(['like', 'auth_name', $this->auth_name])
            ->andFilterWhere(['like', 'auth_recommend', $this->auth_recommend])
            ->andFilterWhere(['like', 'auth_license', $this->auth_license])
            ->andFilterWhere(['like', 'auth_operation', $this->auth_operation]);

        return $dataProvider;
    }
}
