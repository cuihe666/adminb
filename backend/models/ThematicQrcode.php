<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/4
 * Time: 17:23
 */

namespace backend\models;

use Yii;
use app\models\common\CURDTrait;

class ThematicQrcode extends \yii\db\ActiveRecord
{

    use CURDTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'thematic_qrcode';
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
            [['tid', 'custom_params', 'qrcode_url','creator'], 'required'],
            [['tid','creator'], 'integer'],
            [['custom_params'], 'string', 'max' => 10, 'message' => '自定义参数最大支持10个字符'],
            [['desc'], 'safe'],
            [['desc'], 'string', 'max' => 200, 'message' => '描述最大支持200个字符'],
            [['create_time'],'default','value'=>function(){
                return date('Y-m-d H:i:s');
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                    => '二维码ID',
            'tid'                   => '专题活动ID',
            'custom_params'         => '自定义参数',
            'qrcode_url'            => '二维码访问链接',
            'desc'                  => '描述',
            'request_num'           => '浏览量',
            'creator'               => '创建者',
            'create_time'           => '创建时间',
        ];
    }

}