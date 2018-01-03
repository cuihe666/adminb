<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "star_level".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $obj_id
 * @property integer $order_id
 * @property integer $obj_type
 * @property integer $state
 * @property string $content
 * @property string $pic
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_delete
 * @property integer $is_read
 * @property integer $child_id
 */
class StarLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'star_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'type','sub_type'], 'required'],
            [['uid', 'order_id', 'type','object_id', 'state', 'is_delete', 'child_id'], 'integer'],
            [['create_time','uid','grade_position','grade_facility','grade_sanitation','grade_scheduling','grade_guide','grade_leader_service','grade_describe','grade'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => '订单id',
            'id'       => '星级id',
            'object_id' => '产品id',
            'grade' => '点评评分',
            'create_time' => '点评时间',
            'order_no' => '订单号',
            'obj_type' => '业务线',
            'type' => '类型',
            'grade_scheduling' => '行程安排',
            'grade_guide' => '导游讲解',
            'grade_leader_service' => '领队服务',
            'grade_describe' => '描述相符',
        ];
    }


    public static function starLevelDo(Comment $comment){

        if($comment){
            try{
                $starModel = new StarLevel();
//                var_dump($comment);exit;
//                $starModel->uid = $comment->uid;
                $starModel->object_id = $comment->obj_id;
                $starModel->order_id = $comment->order_id;
                $starModel->grade = $comment->grade;
                $starModel->type = $comment->obj_type;
                $starModel->child_id = $comment->child_id;
                $starModel->sub_type = $comment->obj_sub_type;
                $starModel->state = $comment->state;
                $starModel->grade_scheduling = $comment->grade;
                $starModel->grade_guide = $comment->grade;
                $starModel->grade_leader_service = $comment->grade;
                $starModel->grade_describe = $comment->grade;
                $starModel->c_id = $comment->id;
                $starModel->create_time = date("Y-m-d H:i:s",time());
                $starModel->isNewRecord = true;

                if($starModel->save()){
                    return true;
                }else{
                    $err = $starModel->getErrors();
                    throw new \Exception(json_encode($err));
                }
            }catch(\Exception $e){
                $errors = $e->getMessage();
                return $errors;
            }

        }

    }
}
