<?php

namespace backend\models;


/**
 * @author snowno
 * @desc   dt_house_type表模型
 *
 * This is the model class for table "dt_house_type".
 */
class DtHouseType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dt_house_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_name', 'type_img', 'sort', 'job', 'operation', 'version', 'top_category'], 'safe'],
        ];
    }


    public static function getTypenameById($id){
        if($id){
            $data = Yii::$app->db->createCommand("SELECT type_name FROM `dt_house_type`")->queryOne();
            if($data){
                return $data['type_name'];
            }
        }
    }

}
