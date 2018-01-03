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

class Coupon1ActivityQuery extends Coupon1Activity
{
    public $stime;   //创建时间
    public $coupon_activity_id;  //优惠券活动id
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status','coupon_activity_id'], 'safe']
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
        $query = Coupon1Activity::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->stime != '') {
            $start = substr($this->stime, 0, 10) . ' 00:00:00';
            $end = substr($this->stime, 13) . ' 23:59:59';
            $query->andWhere(['between', 'end_date', strtotime($start), strtotime($end)]);
        }

        if(trim($this->title) !=""){
            $query->andFilterWhere(['like', 'title', trim($this->title)]);
        }
        if ($this->status !="") {
            $query->andWhere([
                'status' => $this->status,
            ]);
        }
        $query->andWhere(['in','activity_id',$this->coupon_activity_id]);
        $query->orderBy('id DESC');

//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();
        return $dataProvider;
    }

}