<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TravelImpress;

/**
 * TravelImpressQuery represents the model behind the search form about `backend\models\TravelImpress`.
 */
class TravelImpressQuery extends TravelImpress
{
    /**
     * @inheritdoc
     */
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

    public function rules()
    {
        return [
            [['type', 'uid', 'status', 'read_count', 'city1', 'city2', 'city3', 'province1', 'province2', 'province3', 'country1', 'country2', 'country3'], 'integer'],
            [['name', 'pic', 'content', 'create_time', 'update_time', 'music', 'stime', 'account', 'scity', 'identity', 'id','nature','aptitude','nickname','status_arr','ctime','keywords','resource'], 'safe'],
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
        $query = TravelImpress::find()->select("travel_impress.*,(CASE WHEN travel_impress.identity = 0 THEN c.name ELSE p.name END) AS aptitude,(CASE WHEN travel_impress.identity = 0 THEN c.brandname ELSE p.nick_name END) AS nickname")
            ->leftJoin("travel_person as p","travel_impress.uid = p.uid")
            ->leftJoin("travel_company as c","travel_impress.uid = c.uid")
            ->with('userMobile')
            ->with('cityName1')
            ->with('cityName2')
            ->with('cityName3')
            ->with('collection')
            ->with('support');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 30,],
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

        // grid filtering conditions
        $query->andFilterWhere([
            'travel_impress.id' => $this->id,
            'travel_impress.type' => $this->type,
            'travel_impress.uid' => $this->uid,
            'travel_impress.create_time' => $this->create_time,
            'read_count' => $this->read_count,
            'update_time' => $this->update_time,
            'city1' => $this->city1,
            'city2' => $this->city2,
            'city3' => $this->city3,
            'identity' => $this->identity,

        ]);
        if($this->nature != ''){
            //@2017-7-21 14:10:43 fuyanfei to update 根据资质名称模糊查询所有的个人资质或者企业资质的信息
            //$query->andFilterWhere(['travel_impress.uid' => TravelCompany::getUid($this->nature)]);
            $uidArr = TravelCompany::getUidArr($this->nature);
            $query->andWhere(['in', 'travel_impress.uid',$uidArr]);
        }

        if ($this->stime != '') {

            $start = substr($this->stime, 0, 10) . ' 00:00:00';
            $end = substr($this->stime, 13) . ' 23:59:59';
            $query->andWhere(['between', 'travel_impress.create_time', $start, $end]);
        }
        //2017年7月5日13:27:28 付燕飞增加按照审核时间查询
        if($this->ctime != ""){
            $start = substr($this->ctime, 0, 10) . ' 00:00:00';
            $end = substr($this->ctime, 13) . ' 23:59:59';
            $sql = "select obj_id from travel_operation_log where type = 5 and create_time BETWEEN '".$start."' and '".$end."' GROUP BY obj_id";
            $obj_id = Yii::$app->db->createCommand($sql)->queryAll();
            $obj_id_arr = [-1];
            if(!empty($obj_id)){
                foreach($obj_id as $key=>$val){
                    $obj_id_arr[] = $val['obj_id'];
                }
            }
            $query->andWhere(['in','travel_impress.id', $obj_id_arr]);
        }
        if ($this->account) {
            $query->andFilterWhere([
                'travel_impress.id' => $this->id,
                'travel_impress.uid' => TravelPerson::getuid($this->account),
            ]);
        }

        //关键词搜索  付燕飞 2017年7月3日15:59:11 增加
        if ($this->keywords !="") {
            $query->andWhere([
                'or',
                ['like','travel_impress.name',$this->keywords],
                ['travel_impress.id'=>$this->keywords],
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

        $query->andFilterWhere(['like', 'travel_impress.name', $this->name])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'music', $this->music]);

        //2017年6月23日16:20:58        如果搜索条件不为空，读取对应的搜索条件
        if($this->status != ""){
            $query->andFilterWhere([
                'travel_impress.status' => $this->status
            ]);
        }
        //2017年6月23日16:20:58        付燕飞 修改 查询数据时不读取状态为草稿和删除状态的印象
        $query->andWhere(['!=', 'travel_impress.status', 4]);
        $query->andWhere(['!=', 'travel_impress.status', -1]);

        //2017年7月3日10:35:50 付燕飞增加 旅游商品管理只读取上下线的活动
        if($this->status_arr){
            $query->andWhere(['in','travel_impress.status', $this->status_arr]);
        }

        //@2017-7-21 14:40:40 fuyanfei to add 来源，如果resource==1 ，则是商品管理，需要读取资质审核通过的线路
        if($this->resource==1){
            $query->andWhere([
                'or',
                ['c.status'=>1],
                ['p.status'=>1],
            ]);
        }

//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();

        return $dataProvider;
    }
}
