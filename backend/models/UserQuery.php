<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;
use backend\models\TravelFollow;

use backend\service\CommonService;

/**
 * UserQuery represents the model behind the search form about `backend\models\User`.
 */
class UserQuery extends User
{
    public $start_time;
    public $city_name;
    public $qrcode_id;   //付燕飞 2017年3月27日13:14:26添加  并在rules中设置qrcode_id 为safe
    public $theme_type;  //付燕飞 2017年7月7日16:52:01 添加， 并在rules中设置qrcode_id 为safe
    public $stime;
    public $keywords;
    public $identity;
    public $nick_name;
    public $brandname;
    public $cname;
    public $name;
    public $iscount;
    public $data_count;
    public $order_count;
    public $fid;
    public $pstatus;
    public $cstatus;
    public $pid;
    public $cid;
    public $invite_mobile;
    public $user_vip_type;//用户列表页，用户类型筛选 admin:ys time:2017/11/1
    public $user_check_type;//用户列表页，用户选中‘已填写实名信息’，对审核状态进行筛选; admin:ys time:2017/11/1
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['id', 'status', 'is_delete'], 'integer'],
            [['mobile','order_count', 'password', 'huanxin',
                'token','fid', 'create_time', 'update_time', 'weibo', 'qq',
                'weixin', 'weixinIOS', 'qqIOS', 'start_time', 'mobile', 'city_name',
                'qrcode_id','theme_type','stime','identity','name','keywords','iscount',
                'data_count','invite_uid','pstatus','cstatus','pid','cid',
                'invite_mobile', 'user_vip_type', 'user_check_type','auth'], 'safe'],
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
        $query = User::find()->select("user.*,user_info.auth");
        $query->joinWith(['info']);
        //$query->joinWith(['common']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
//        $dataProvider->setSort(false);
        $this->load($params);

        if($this->iscount==1){
            $dataProvider->setSort([
                'defaultOrder' => [
                    'create_time' => SORT_ASC,
                ]
            ]);
        }
        else{
            $dataProvider->setSort([
                'defaultOrder' => [
                    'create_time' => SORT_DESC,
                ]
            ]);
        }


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //判断qrcode_id是否为空，如果不为空的，查询qrcode_id【二维码id】下的所有用户，付燕飞 2017年3月27日13:14:26添加
        if($this->qrcode_id != null && intval($this->qrcode_id) != 0) {
            $query->andFilterWhere([
                'user_info.qrcode_id' => $this->qrcode_id,
            ]);
        }
        //判断theme_type是否为空，如果不为空的，查询theme_type【活动id】下的所有用户，付燕飞2017年7月7日16:47:23添加
        if($this->theme_type != null && intval($this->theme_type) != 0) {
            $query->andFilterWhere([
                'user_info.theme_type' => $this->theme_type,
            ]);
        }
        //判断需要筛选的用户类型（1.已填写实名信息/2.未填写市名信息） [0.未认证 1.待审核 2.审核通过（已认证）3.审核失败] admin:ys time:2017/11/1
        if (!empty($this->user_vip_type)) {
            if ($this->user_vip_type == 1) {//已填写实名信息
                if (!empty($this->user_check_type)) {//对审核状态进行了条件筛选 （1.待审核 2.审核通过 3.审核未通过）
                    $query->andWhere([
                        'user_info.auth' => $this->user_check_type,
                    ]);
                } else {//未对审核状态进行条件筛选（即审核条件为：待审核 + 审核通过 + 审核未通过）
                    $query->andWhere(['<>', 'user_info.auth', 0]);
                }
                //echo '已填写实名信息';die;
            } else {//未填写市名信息
                $query->andWhere([
                    'user_info.auth' => 0,
                ]);
            }
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'is_delete' => $this->is_delete,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'huanxin', $this->huanxin])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'weibo', $this->weibo])
            ->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'weixin', $this->weixin])
            ->andFilterWhere(['like', 'weixinIOS', $this->weixinIOS])
            ->andFilterWhere(['like', 'qqIOS', $this->qqIOS]);


        if ($this->start_time != '') {
            $start = substr($this->start_time, 0, 10) . ' 00:00:00';
            $end = substr($this->start_time, 13) . ' 00:00:00';
            $query->andWhere(['between', 'user.create_time', $start, $end]);
        }

        if ($this->city_name != '') {
            $city_code = CommonService::get_city_code1($this->city_name);
            if ($city_code === false) {
                $city_code = 88888;
            }
            $query->andFilterWhere(['user.citycode' => $city_code]);
        }
        $query->count();
//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function getCount($params)
    {
        $query = User::find();
        $query->joinWith(['info']);

        $this->load($params);

        //判断qrcode_id是否为空，如果不为空的，查询qrcode_id【二维码id】下的所有用户，付燕飞 2017年3月27日13:14:26添加
        if($this->qrcode_id != null && intval($this->qrcode_id) != 0) {
            $query->andFilterWhere([
                'user_info.qrcode_id' => $this->qrcode_id,
            ]);
        }
        //判断theme_type是否为空，如果不为空的，查询theme_type【活动id】下的所有用户，付燕飞2017年7月7日16:47:23添加
        if($this->theme_type != null && intval($this->theme_type) != 0) {
            $query->andFilterWhere([
                'user_info.theme_type' => $this->theme_type,
            ]);
        }
        $query->count();
        return $query->count();
    }

    /**
     * 旅游达人
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchTalent($params)
    {
        $this->load($params);
        if($this->invite_uid==1){
            $query = User::find()
                ->select("user.id,user.mobile,user.create_time,user.invite_uid,travel_person.id as pid,travel_person.name,travel_person.nick_name,travel_person.status as pstatus,travel_company.id as cid,travel_company.name as cname,travel_company.brandname,travel_company.status as cstatus,invite.mobile as invite_mobile")
                ->leftJoin("travel_person","user.id = travel_person.uid")
                ->leftJoin("travel_company","user.id = travel_company.uid")
                ->leftJoin("user as invite","user.invite_uid = invite.id");
        }else{
            $query = User::find()
                ->select("user.id,user.mobile,user.create_time,user.invite_uid,travel_person.id as pid,travel_person.name,travel_person.nick_name,travel_person.status as pstatus,travel_company.id as cid,travel_company.name as cname,travel_company.brandname,travel_company.status as cstatus")
                ->leftJoin("travel_person","user.id = travel_person.uid")
                ->leftJoin("travel_company","user.id = travel_company.uid")
                ->joinWith(['common']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
//        $dataProvider->setSort(false);

        $dataProvider->setSort([
            'defaultOrder' => [
                'id' => SORT_ASC,
            ]
        ]);
        if($this->data_count == 1 && $this->stime != ''){

            $query->with(['fancounts'=>function($query){
                $start = substr($this->stime, 0, 10) . ' 00:00:00';
                $end = substr($this->stime, 13) . ' 23:59:59';
                $query->andWhere(['between', 'travel_follow.create_time', $start, $end]);
            }]);
            $query->with(['higocounts'=>function($query){
                $start = substr($this->stime, 0, 10) . ' 00:00:00';
                $end = substr($this->stime, 13) . ' 23:59:59';
                $query->andWhere(['between', 'travel_higo.create_time', $start, $end]);
            }]);
            $query->with(['activitycounts'=>function($query){
                $start = substr($this->stime, 0, 10) . ' 00:00:00';
                $end = substr($this->stime, 13) . ' 23:59:59';
                $query->andWhere(['between', 'travel_activity.create_time', $start, $end]);
            }]);
            $query->with(['guidecounts'=>function($query){
                $start = substr($this->stime, 0, 10) . ' 00:00:00';
                $end = substr($this->stime, 13) . ' 23:59:59';
                $query->andWhere(['between', 'travel_guide.create_time', $start, $end]);
            }]);
            $query->with(['impresscounts'=>function($query){
                $start = substr($this->stime, 0, 10) . ' 00:00:00';
                $end = substr($this->stime, 13) . ' 23:59:59';
                $query->andWhere(['between', 'travel_impress.create_time', $start, $end]);
            }]);
            $query->with(['notecounts'=>function($query){
                $start = substr($this->stime, 0, 10) . ' 00:00:00';
                $end = substr($this->stime, 13) . ' 23:59:59';
                $query->andWhere(['between', 'travel_note.create_time', $start, $end]);
            }]);
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
            'status' => $this->status,
        ]);


        if($this->order_count != 1){
            //开始结束时间
            if ($this->stime != '') {
                $start = substr($this->stime, 0, 10) . ' 00:00:00';
                $end = substr($this->stime, 13) . ' 23:59:59';
                $query->andWhere(['between', 'user.create_time', $start, $end]);
            }
        }

        //按性质
        if ($this->identity != '') {
            if($this->identity == 0)      //公司资质
                $query->andWhere(['NOT', ['travel_company.name' => null]]);
            if($this->identity == 1)     //个人资质
                $query->andWhere(['NOT', ['travel_person.name' => null]]);
            if($this->identity == 2) {     //个人资质
                $query->andWhere([
                    'and',
                    ['travel_person.name' => null],
                    ['travel_company.name' => null],
                ]);
            }
        }

        if($this->pstatus != ""){
            $query->andWhere([
                'or',
                ['travel_person.status' => $this->pstatus],
                ['travel_company.status' => $this->pstatus],
            ]);
        }

        //按账号
        $query->andFilterWhere(['like', 'user.mobile', $this->mobile]);

        //名称
        if ($this->name !="") {
            $query->andWhere([
                'or',
                ['like','travel_person.name',$this->name],
                ['like','travel_company.name',$this->name],
            ]);
        }
        //主页昵称or 品牌名称
        if ($this->keywords !="") {
            $query->andWhere([
                'or',
                ['like','travel_person.nick_name',$this->keywords],
                ['like','travel_company.brandname',$this->keywords],
            ]);
        }

        //邀请人账号
        if($this->invite_mobile != ""){
            $query->andWhere(['like','invite.mobile',$this->invite_mobile,]);
        }

        if($this->invite_uid!=1){
            $query->andWhere(["user_common.is_daren"=>1]);
        }
        if($this->iscount == 1){
            $query->andWhere([
                'or',
                ['travel_person.status'=>1],
                ['travel_company.status'=>1],
            ]);
        }

        //达人拉新统计
        if($this->invite_uid==1){
            //$query->joinWith("inviteMobile");
            //查询推荐人id不为空的会员
            $query->andWhere([
                'and',
                ['!=','user.invite_uid',0],
                ['NOT', ['user.invite_uid' => null]]
            ]);
        }

//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();
        return $dataProvider;
    }




}
