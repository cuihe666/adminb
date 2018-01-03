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
class TravelGuideQuery extends TravelGuide
{

    public $stime;
    public $city_name;
    public $account;
    public $nature;
    public $keywords;
    public $aptitude;    //资质名称
    public $nickname;    //昵称

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'identity', 'user_auth', 'sex', 'country', 'province', 'city', 'service_time', 'num', 'is_confirm', 'refund_type', 'status'], 'integer'],
            [['update_time', 'language_other','stime','city_name','account','nature','keywords','aptitude','nickname'], 'safe'],
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
        $query = TravelGuide::find()
            ->select("travel_guide.*,(CASE WHEN travel_guide.identity = 0 THEN c.name ELSE p.name END) AS aptitude,(CASE WHEN travel_guide.identity = 0 THEN c.brandname ELSE p.nick_name END) AS nickname")
            ->leftJoin("travel_person as p","travel_guide.uid = p.uid")
            ->leftJoin("travel_company as c","travel_guide.uid = c.uid")
            ->with('userMobile')
            ->with('cityName');
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

        $query->andWhere(['!=', 'travel_guide.status', 4]);
        $query->andWhere(['!=', 'travel_guide.status', -1]);

        // grid filtering conditions
        $query->andFilterWhere([
            'travel_guide.id' => $this->id,
            'is_confirm' => $this->is_confirm,
            'city' => $this->city,
            'refund_type' => $this->refund_type,
            'travel_guide.uid' => $this->uid,
            'identity' => $this->identity,
            'user_auth' => $this->user_auth,
        ]);

        //2017年6月23日16:49:38        如果搜索条件不为空，读取对应的搜索条件
        if($this->status != ""){
            $query->andWhere([
                'travel_guide.status' => $this->status
            ]);
        }
        if ($this->stime != '') {
            $start = substr($this->stime, 0, 10) . ' 00:00:00';
            $end = substr($this->stime, 13) . ' 23:59:59';
            $query->andWhere(['between', 'travel_guide.create_time', $start, $end]);
        }

        if ($this->city_name != '') {
            $city_code = CommonService::get_city_code1($this->city_name);
            if ($city_code === false) {
                $city_code = 88888;
            }
            $query->andFilterWhere(['city' => $city_code]);
        }

        if ($this->account) {
            $query->andFilterWhere([
                'travel_guide.id' => $this->id,
                'travel_guide.uid' => TravelPerson::getuid($this->account),
            ]);
        }

        if ($this->tag) {
            $query->andWhere(new \yii\db\Expression("find_in_set($this->tag,tag)"));
        }

        if($this->nature != '') {
            //根据资质名称模糊查询所有的个人资质或者企业资质的信息
            $uidArr = TravelCompany::getUidArr($this->nature);
            $query->andWhere(['in', 'travel_guide.uid',$uidArr]);
        }

        //关键词搜索
        if ($this->keywords !="") {
            $query->andWhere([
                'or',
                ['like','travel_guide.title',$this->keywords],
                ['travel_guide.id'=>$this->keywords],
            ]);
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title_pic', $this->title_pic])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'price_in', $this->price_in])
            ->andFilterWhere(['like', 'price_out', $this->price_out])
            ->andFilterWhere(['like', 'refund_note', $this->refund_note])
            ->andFilterWhere(['like', 'note', $this->note]);

//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();

        return $dataProvider;
    }
}
