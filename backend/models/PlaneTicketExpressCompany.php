<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "plane_ticket_express_company".
 *
 * @property string $id
 * @property string $name
 */
class PlaneTicketExpressCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plane_ticket_express_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
