<?php

namespace backend\models;

use Yii;
use app\models\common\CURDTrait;
/**
 * This is the model class for table "thematic_activity".
 *
 * @property integer $id
 * @property string $name
 * @property string $start_time
 * @property string $end_time
 * @property string $share_title
 * @property string $share_content
 * @property string $share_pic
 * @property integer $status
 * @property string $h5_link
 * @property string $app_link
 * @property string $creator
 * @property string $create_time
 * @property string $update_time
 */
class ThematicActivity extends \yii\db\ActiveRecord
{
    use CURDTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'thematic_activity';
    }

    static public function getDb()
    {
        return Yii::$app->db;
    }

    //根据主键d获取数据
    public function getDataById($id,$field='*'){
        return $this->getDataByOne([
            'id' => $id,
        ],$field);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'start_time', 'end_time', 'share_title', 'share_content', 'share_pic', 'creator', 'create_time'], 'required'],
            [['start_time', 'end_time','admin_id', 'create_time', 'update_time'], 'safe'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 15],
            [['share_title'], 'string', 'max' => 25],
            [['share_content'], 'string', 'max' => 80],
            [['share_pic'], 'string', 'max' => 50],
            [['h5_link', 'app_link'], 'string', 'max' => 255],
            [['creator'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '活动ID',
            'name' => '活动名称',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'share_title' => '分享标题',
            'share_content' => '分享内容',
            'share_pic' => '分享图片地址',
            'status' => '活动状态',
            'h5_link' => 'h5链接',
            'app_link' => 'app链接',
            'creator' => '创建者',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
        ];
    }
}
