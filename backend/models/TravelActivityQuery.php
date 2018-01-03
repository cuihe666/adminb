<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TravelActivity;

/**
 * TravelActivityQuery represents the model behind the search form about `backend\models\TravelActivity`.
 */
class TravelActivityQuery extends TravelActivity
{

    public $stime;
    public $city_name;
    public $account;
    public $nature;
    public $aptitude;          //付燕飞 2017年7月1日14:32:35 增加 资质
    public $nickname;          //付燕飞 2017年7月1日14:32:35 增加昵称
    public $status_arr;        //付燕飞 2017年7月1日10:02:24增加状态数组
    public $ctime;             //付燕飞 2017年7月1日14:41:39 增加审核时间
    public $keywords;          //付燕飞 2017年7月1日14:56:40 添加搜索关键词。
    public $resource;          //@2017-7-21 14:47:15 fuyanfei to add 来源

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'type', 'max_num', 'time_length', 'time_unit', 'is_confirm', 'city_code', 'refund_type', 'read_count', 'uid', 'is_del', 'step', 'tango', 'province_code'], 'integer'],
            [['name', 'tag', 'title_pic', 'hot_spot', 'des', 'process', 'mobile', 'start_time', 'end_time', 'active_address', 'set_address', 'shi', 'fen', 'price_in', 'price_out', 'refund_note', 'note', 'read_link', 'des_pic', 'stime','city_name','account','user_auth','identity','id','status','nature','sort','sort_start_date','sort_end_date','aptitude','nickname','status_arr','ctime','keywords','resource'], 'safe'],
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
        $query = TravelActivity::find()
            ->select("travel_activity.*,(CASE WHEN travel_activity.identity = 0 THEN c.name ELSE p.name END) AS aptitude,(CASE WHEN travel_activity.identity = 0 THEN c.brandname ELSE p.nick_name END) AS nickname")
        ->leftJoin("travel_person as p","travel_activity.uid = p.uid")
        ->leftJoin("travel_company as c","travel_activity.uid = c.uid")
        ->with('userMobile')
        ->with('cityName');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //按照添加顺序降序排列
        $dataProvider->setSort([
            'defaultOrder' => [
//                'sort' => SORT_DESC,
                'id' => SORT_ASC
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere(['!=', 'travel_activity.status', 4]);
        $query->andWhere(['!=', 'travel_activity.status', -1]);

        // grid filtering conditions
        $query->andFilterWhere([
            'travel_activity.id' => $this->id,
            'travel_activity.type' => $this->type,
            'max_num' => $this->max_num,
            'time_length' => $this->time_length,
            'time_unit' => $this->time_unit,
            'is_confirm' => $this->is_confirm,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'city_code' => $this->city_code,
            'refund_type' => $this->refund_type,
            'read_count' => $this->read_count,
            'travel_activity.uid' => $this->uid,
            'is_del' => $this->is_del,
            'step' => $this->step,
            'tango' => $this->tango,
            'province_code' => $this->province_code,
            'identity' => $this->identity,
            'user_auth' => $this->user_auth,

        ]);

        //2017年6月23日16:49:38        如果搜索条件不为空，读取对应的搜索条件
        if($this->status != ""){
            $query->andWhere([
                'travel_activity.status' => $this->status
            ]);
        }

        //2017年7月1日14:40:01 付燕飞增加 旅游商品管理只读取上下线的活动
        if($this->status_arr){
            $query->andWhere(['in','travel_activity.status', $this->status_arr]);
        }

        //@2017-7-21 14:40:40 fuyanfei to add 来源，如果resource==1 ，则是商品管理，需要读取资质审核通过的线路
        if($this->resource==1){
            $query->andWhere([
                'or',
                ['c.status'=>1],
                ['p.status'=>1],
            ]);
        }

        if ($this->stime != '') {
            $start = substr($this->stime, 0, 10) . ' 00:00:00';
            $end = substr($this->stime, 13) . ' 23:59:59';
            $query->andWhere(['between', 'travel_activity.create_time', $start, $end]);
        }
        //2017年7月5日13:25:16 付燕飞增加按照审核时间查询
        if($this->ctime != ""){
            $start = substr($this->ctime, 0, 10) . ' 00:00:00';
            $end = substr($this->ctime, 13) . ' 23:59:59';

            $sql = "select obj_id from travel_operation_log where type = 3 and create_time BETWEEN '".$start."' and '".$end."' GROUP BY obj_id";
            $obj_id = Yii::$app->db->createCommand($sql)->queryAll();
            $obj_id_arr = [-1];
            if(!empty($obj_id)){
                foreach($obj_id as $key=>$val){
                    $obj_id_arr[] = $val['obj_id'];
                }
            }
            $query->andWhere(['in','travel_activity.id', $obj_id_arr]);
        }

        if ($this->city_name != '') {
            $city_code = CommonService::get_city_code1($this->city_name);
            if ($city_code === false) {
                $city_code = 88888;
            }
            $query->andFilterWhere(['city_code' => $city_code]);
        }

        if ($this->account) {
            $query->andFilterWhere([
                'travel_activity.id' => $this->id,
                'travel_activity.uid' => TravelPerson::getuid($this->account),
            ]);
        }
        //关键词搜索  付燕飞 2017年7月1日14:57:12 增加
        if ($this->keywords !="") {
            $query->andWhere([
                'or',
                ['like','travel_activity.name',$this->keywords],
                ['travel_activity.id'=>$this->keywords],
            ]);
        }

        if ($this->tag) {
            $query->andWhere(new \yii\db\Expression("find_in_set($this->tag,tag)"));

        }
        if($this->nature != ''){
            //@2017-7-21 14:02:35 fuyanfei to update 根据资质名称模糊查询所有的个人资质或者企业资质的信息
            //$query->andFilterWhere(['travel_activity.uid' => TravelCompany::getUid($this->nature)]);
            $uidArr = TravelCompany::getUidArr($this->nature);
            $query->andWhere(['in', 'travel_activity.uid',$uidArr]);
        }

        $query->andFilterWhere(['like', 'travel_activity.name', $this->name])
            ->andFilterWhere(['like', 'title_pic', $this->title_pic])
            ->andFilterWhere(['like', 'hot_spot', $this->hot_spot])
            ->andFilterWhere(['like', 'des', $this->des])
            ->andFilterWhere(['like', 'process', $this->process])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'active_address', $this->active_address])
            ->andFilterWhere(['like', 'set_address', $this->set_address])
            ->andFilterWhere(['like', 'shi', $this->shi])
            ->andFilterWhere(['like', 'fen', $this->fen])
            ->andFilterWhere(['like', 'price_in', $this->price_in])
            ->andFilterWhere(['like', 'price_out', $this->price_out])
            ->andFilterWhere(['like', 'refund_note', $this->refund_note])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'read_link', $this->read_link])
            ->andFilterWhere(['like', 'des_pic', $this->des_pic]);

        /*$commandQuery = clone $query;
        echo $commandQuery->createCommand()->getRawSql();*/

        return $dataProvider;
    }
}
