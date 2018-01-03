<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TravelNote;

/**
 * TravelNoteQuery represents the model behind the search form about `backend\models\TravelNote`.
 */
class TravelNoteQuery extends TravelNote
{
    public $stime;
    public $account;
    public $scity;
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
            [['uid', 'type', 'people_type', 'day_count', 'read_count', 'praise_count', 'is_del', 'status', 'city1', 'city2', 'city3', 'province1', 'province2', 'province3', 'country1', 'country2', 'country3'], 'integer'],
            [['name', 'start_time', 'end_time', 'content', 'create_time', 'update_time', 'pic', 'music', 'start_month', 'stime', 'account', 'scity', 'identity', 'id', 'nature','aptitude','nickname','status_arr','ctime','keywords','resource'], 'safe'],
            [['price'], 'number'],
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
        $query = TravelNote::find()->select("travel_note.*,(CASE WHEN travel_note.identity = 0 THEN c.name ELSE p.name END) AS aptitude,(CASE WHEN travel_note.identity = 0 THEN c.brandname ELSE p.nick_name END) AS nickname")
            ->leftJoin("travel_person as p","travel_note.uid = p.uid")
            ->leftJoin("travel_company as c","travel_note.uid = c.uid")
            ->with('userMobile')
            ->with('cityName1')
            ->with('cityName2')
            ->with('cityName3')
            ->with('collection')
            ->with('support');

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
        $query->andWhere(['!=', 'travel_note.status', 4]);
        $query->andWhere(['!=', 'travel_note.status', -1]);
        // grid filtering conditions
        $query->andFilterWhere([
            'travel_note.id' => $this->id,
            'travel_note.uid' => $this->uid,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'type' => $this->type,
            'people_type' => $this->people_type,
            'price' => $this->price,
            'day_count' => $this->day_count,
            'read_count' => $this->read_count,
            'praise_count' => $this->praise_count,
            'travel_note.create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'is_del' => $this->is_del,
            'city1' => $this->city1,
            'city2' => $this->city2,
            'city3' => $this->city3,
            'identity' => $this->identity,
        ]);

        //2017年6月23日17:02:03        如果搜索条件不为空，读取对应的搜索条件
        if($this->status != ""){
            $query->andFilterWhere([
                'travel_note.status' => $this->status
            ]);
        }

        //2017年7月3日15:40:23 付燕飞增加 旅游商品管理只读取上下线的活动
        if($this->status_arr){
            $query->andWhere(['in','travel_note.status', $this->status_arr]);
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
            $query->andWhere(['between', 'travel_note.create_time', $start, $end]);
        }
        //2017年7月5日13:28:58 付燕飞增加按照审核时间查询
        if($this->ctime != ""){
            $start = substr($this->ctime, 0, 10) . ' 00:00:00';
            $end = substr($this->ctime, 13) . ' 23:59:59';
            $sql = "select obj_id from travel_operation_log where type = 6 and create_time BETWEEN '".$start."' and '".$end."' GROUP BY obj_id";
            $obj_id = Yii::$app->db->createCommand($sql)->queryAll();
            $obj_id_arr = [-1];
            if(!empty($obj_id)){
                foreach($obj_id as $key=>$val){
                    $obj_id_arr[] = $val['obj_id'];
                }
            }
            $query->andWhere(['in','travel_note.id', $obj_id_arr]);
        }


        if ($this->nature != '') {
            //@2017-7-21 14:15:48 fuyanfei to update 根据资质名称模糊查询所有的个人资质或者企业资质的信息
            //$query->andFilterWhere(['travel_note.uid' => TravelCompany::getUid($this->nature)]);
            $uidArr = TravelCompany::getUidArr($this->nature);
            $query->andWhere(['in', 'travel_note.uid',$uidArr]);
        }

        if ($this->account) {
            $query->andFilterWhere([
                'travel_note.id' => $this->id,
                'travel_note.uid' => TravelPerson::getuid($this->account),
            ]);
        }

        //关键词搜索  付燕飞 2017年7月3日15:59:11 增加
        if ($this->keywords !="") {
            $query->andWhere([
                'or',
                ['like','travel_note.name',$this->keywords],
                ['travel_note.id'=>$this->keywords],
            ]);
        }

        if ($this->scity != '') {
            $city_code = CommonService::get_city_code1($this->scity);
            if ($city_code === false) {
                $city_code = 88888;
            }
            $query->where(['=', 'city1', $city_code]);
            $query->orWhere(['=', 'city2', $city_code]);
            $query->orWhere(['=', 'city3', $city_code]);

        }

        $query->andFilterWhere(['like', 'travel_note.name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'music', $this->music])
            ->andFilterWhere(['like', 'start_month', $this->start_month]);


//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();

        return $dataProvider;
    }
}
