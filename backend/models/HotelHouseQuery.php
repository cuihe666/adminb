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
 * @desc   hotel_house表模型
 *
 * HotelQuery represents the model behind the search form about `backend\models\HotelHouse`.
 */
class HotelHouseQuery extends HotelHouse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

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
        $query = HotelHouse::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }


        if ($this->hotel_id !="" && intval($this->hotel_id)!=0) {
            $query->andWhere([
                'hotel_id' => $this->hotel_id,
            ]);
        }
        //$query->orderBy('id DESC');

        return $dataProvider;
    }
}
