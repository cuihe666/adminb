<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\LocalServe;

/**
 * LocalServeQuery represents the model behind the search form about `backend\models\LocalServe`.
 */
class LocalServeQuery extends LocalServe
{
    public $s;

    public $mobile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'is_delete', 'serve_way', 'serve_type_id', 'uid'], 'integer'],
            [['serve_price'], 'number'],
            [['serve_name', 'serve_content', 'create_time', 'update_time', 'cover_img', 'serve_img', 's', 'mobile'], 'safe'],
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
        $query = LocalServe::find();
        $query->joinWith(['user']);
        $query->joinWith(['servicecategory']);
        $query->select("local_serve.*,local_serve.id,user.id as user_id,user.mobile,service_category.id as service_category_id ,service_category.name");

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
        if ($this->s || $this->s == 0) {
            $query->andFilterWhere([
                'local_serve.status' => $this->s,

            ]);

        }
        $query->andFilterWhere([
            'local_serve.is_delete' => 0,

        ]);

        if ($this->mobile != '') {
            $uid = CommonService::get_uid($this->mobile);
            if ($uid === false) {
                $uid = 0;
            }
            $query->andFilterWhere(['uid' => $uid]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'serve_price' => $this->serve_price,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'is_delete' => $this->is_delete,
            'serve_way' => $this->serve_way,
            'serve_type_id' => $this->serve_type_id,
            'uid' => $this->uid,
        ]);

        $query->andFilterWhere(['like', 'serve_name', $this->serve_name])
            ->andFilterWhere(['like', 'serve_content', $this->serve_content])
            ->andFilterWhere(['like', 'cover_img', $this->cover_img])
            ->andFilterWhere(['like', 'serve_img', $this->serve_img]);
        return $dataProvider;
    }


}
