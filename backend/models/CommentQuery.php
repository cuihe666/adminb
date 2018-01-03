<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Comment;

/**
 * CommentQuery represents the model behind the search form about `backend\models\Comment`.
 */
class CommentQuery extends Comment
{

    public $order_no;
    public $mobile;
    public $order_create_time;
    public $img_num;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'obj_id', 'order_id', 'obj_type', 'state', 'is_delete', 'is_read', 'child_id'], 'integer'],
            [['content', 'pic', 'create_time', 'update_time','order_no','mobile','order_create_time','img_num','obj_name','obj_sub_type'], 'safe'],
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
        $query = Comment::find();
        $query->with('user','houseusernickname','housedetails','houseusermoblie');
//        $query->joinWith(['user']);
//        $query->joinWith(['housedetails']);
//        $query->joinWith(['houseusernickname']);
//        $query->joinWith(['houseusermoblie']);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'obj_id' => $this->obj_id,
            'order_id' => $this->order_id,
            'obj_type' => $this->obj_type,
            'state' => $this->state,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'is_delete' => $this->is_delete,
            'is_read' => $this->is_read,
            'child_id' => $this->child_id,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'pic', $this->pic]);



        return $dataProvider;
    }

    public function dosearch($params)
    {
        $query = Comment::find();
        $query->joinWith('travelorder');
        $query->joinWith('user');
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
//        $query->is_delete= 0;
        // grid filtering conditions
        $query->andFilterWhere([
            'comment.id' => $this->id,
            'comment.uid' => $this->uid,
            'comment.obj_id' => $this->obj_id,
            'comment.order_id' => $this->order_id,
//            'obj_type' => $this->obj_type,
            'comment.obj_type' => 3,
            'comment.is_delete' => 0,
            'comment.state' => $this->state,
            'comment.obj_sub_type' => $this->obj_sub_type,
            'comment.obj_name' => $this->obj_name,
            'comment.update_time' => $this->update_time,
            'comment.is_read' => $this->is_read,
            'comment.child_id' => $this->child_id,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'pic', $this->pic]);

        $query->andFilterWhere(['=', 'travel_order.order_no', $this->order_no]);
        $query->andFilterWhere(['=', 'user.mobile', $this->mobile]);
        if ($this->order_create_time) {
            $start = substr($this->order_create_time, 0, 10) . ' 00:00:00';
            $end = substr($this->order_create_time, 13) . ' 00:00:00';
            $query->andWhere(['between', 'travel_order.create_time', $start, $end]);
        }
        if ($this->create_time) {
            $start = substr($this->create_time, 0, 10) . ' 00:00:00';
            $end = substr($this->create_time, 13) . ' 00:00:00';
            $query->andWhere(['between', 'comment.create_time', $start, $end]);
        }

        return $dataProvider;
    }
}
