<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/5
 * Time: 10:51
 */

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\models\TravelOrder;
use backend\models\UserInfo;

class ThematicQrcodeQuery extends ThematicQrcode
{

    //以下若有表中的重复字段,则按各个表中的字段注释理解,而不是以这里的注释为主.这里的注释根据各个页面的搜索条件使用的.

    //专题活动ID
    public $tid                     = null;
    //专题活动二维码数据ID
    public $thematic_qrcode_id      = null;
    //注册时间
    public $register_time           = null;
    //账号
    public $account_number          = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['tid','integer','message' => '专题活动ID参数不存在'],
            ['thematic_qrcode_id','integer','message' => '专题活动的二维码数据ID参数不存在'],
            [   [
                    'register_time',
                    'account_number',
                ],
                'safe'
            ],
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
     * 二维码管理-数据列表
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($searchModelParams,$otherParams)
    {
        $tid = isset($otherParams['tid']) ? $otherParams['tid'] : 0;

        $query = ThematicQrcode::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query'         => $query,
            'pagination'    => ['pageSize' => 30,],
        ]);

        //按照添加顺序降序排列
        $dataProvider->setSort([
            'defaultOrder' => [
                'id' => SORT_DESC,
            ]
        ]);

        $this->load($searchModelParams);

        //第一次访问过来时,是url直接访问过来的,如果表单的tid不存在,则使用url的tid
        !isset($this->tid) && ( $this->tid = $tid );

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['tid'=>$this->tid]);

//        $query  ->andFilterWhere(['like', 'name', $this->name])
//                ->andFilterWhere(['like', 'creator', $this->creator]);
        /*
            $query->orderBy([
                'id' => SORT_DESC,
            ]);
            $commandQuery = clone $query;
            echo $commandQuery->createCommand()->getRawSql();
        */

        return $dataProvider;
    }

    //公用参数处理-必须在使用load加载后再调用该方法
    private function _searchOtherParamsAction(array $otherParams){
        $tid                = isset($otherParams['tid']) ? $otherParams['tid'] : 0;
        $thematicQrcodeId   = isset($otherParams['thematic_qrcode_id']) ? $otherParams['thematic_qrcode_id'] : 0;
        $customDefault      = isset($otherParams['custom_default']) ? $otherParams['custom_default'] : 0;

        //第一次访问过来时,是url直接访问过来的,如果表单的tid不存在,则使用url的tid
        !isset($this->tid)                  && ( $this->tid = $tid );
        !isset($this->thematic_qrcode_id)   && ( $this->thematic_qrcode_id = $thematicQrcodeId );

        //若是默认的二维码数据,则不携带自定义参数查询
        $customDefault==1                   && ( $this->thematic_qrcode_id = null );
    }

    //自定义参数-新用户统计-数据列表
    public function newusertotalSearch($searchModelParams,array $otherParams){
        $query = UserInfo::find();

        //即时查询的表数据,和搜索条件有关的都会即时查询
        $query->joinWith('user');
        //延迟查询,即主表查询完毕后,再循环出关联id,去in条件查询关联表,若有搜索条件,则不会起作用
        $query->with('common');

        $dataProvider = new ActiveDataProvider([
            'query'         => $query,
            'pagination'    => ['pageSize' => 30,],
        ]);

        //按照添加顺序降序排列
        $dataProvider->setSort([
            'defaultOrder' => [
                'id' => SORT_DESC,
            ]
        ]);

        $this->load($searchModelParams);

        //其他参数处理
        $this->_searchOtherParamsAction($otherParams);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['theme_type'=>$this->tid]);
        $query->andFilterWhere(['qrcode_id'=>$this->thematic_qrcode_id]);
        $query->andFilterWhere(['like','user.mobile',$this->account_number]);
        if( !empty($this->register_time) ){
            list($startTime,$endTime) = array_map('trim',explode('~',$this->register_time));
            if( strtotime($startTime) && strtotime($endTime) ){
                $query->andFilterWhere(['between','user.create_time',$startTime,$endTime]);
            }
        }

//        $commondQuery = clone $query;
//        echo $commondQuery->createCommand()->getRawSql();
//        exit;

        return $dataProvider;
    }

}