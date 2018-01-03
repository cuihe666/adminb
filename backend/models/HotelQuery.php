<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Qrcode;

/**
 * @author fuyanfei
 * @time   2017年4月18日13:27:48
 * @desc   hotel表模型
 *
 * HotelQuery represents the model behind the search form about `backend\models\Hotel`.
 */
class HotelQuery extends Hotel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['complete_name','short_name','type','city','province', 'status','check_status'],'safe'],
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
        $query = Hotel::find()->with('cityName');
        $query->joinWith(['supplier']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30
            ]
        ]);
        //按照添加顺序降序排列
        $dataProvider->setSort([
            'defaultOrder' => [
                'id' => SORT_DESC
            ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        //酒店2.0，添加省份搜索功能
        if ($this->province != "" && intval($this->province)!=0) {
            $query->andWhere([
                'hotel.province' => $this->province,
            ]);
        }
        if ($this->city !="" && intval($this->city)!=0) {
            $query->andWhere([
                'hotel.city' => $this->city,
            ]);
        }
        if ($this->status !="") {
            $query->andWhere([
                'hotel.status' => $this->status,
            ]);
        }
        if ($this->check_status !="") {
            $query->andWhere([
                'hotel.check_status' => $this->check_status,
            ]);
        }
        if ($this->type !="") {
            $query->andWhere([
                'hotel.type' => $this->type,
            ]);
        }
        if ($this->complete_name !="") {
            $query->andwhere([
                'or',
                ['like','complete_name',$this->complete_name],
                ['like','short_name',$this->complete_name],
                ['hotel.id'=>$this->complete_name],
            ]);
        }

        //$query->orderBy('hotel.id DESC');
//        $commandQuery = clone $query;
//        echo $commandQuery->createCommand()->getRawSql();
        return $dataProvider;
    }
}
