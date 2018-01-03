<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "plane_ticket_banner".
 *
 * @property string $id
 * @property string $desc
 * @property string $img_url
 * @property integer $turn_type
 * @property string $turn_data
 * @property string $share_data
 * @property string $start_time
 * @property string $end_time
 * @property integer $sort
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $admin_id
 */
class PlaneTicketBanner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['turn_type', 'sort', 'status', 'admin_id'], 'integer'],
            [['share_data'], 'required'],
            [['share_data'], 'string'],
            [['start_time', 'end_time', 'create_time', 'update_time'], 'safe'],
            [['desc'], 'string', 'max' => 100],
            [['img_url', 'turn_data'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desc' => '广告名称',
            'img_url' => 'Img Url',
            'turn_type' => 'Turn Type',
            'turn_data' => 'Turn Data',
            'share_data' => 'Share Data',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'sort' => '位置数字',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'admin_id' => 'Admin ID',
        ];
    }
}
