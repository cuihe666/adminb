<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "comment".
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
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'obj_id','create_by','obj_sub_type','content'], 'required'],
            [['uid', 'obj_id', 'order_id', 'obj_type', 'state', 'is_delete', 'is_read', 'child_id','quintessence'], 'integer'],
            [['create_time', 'update_time','uid','grade','pic','rank','quintessence','nickname','obj_name'], 'safe'],
            [['content'], 'string', 'max' => 500],
            [['pic'], 'string', 'max' => 800],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => '订单id',
            'id'       => '点评id',
            'nickname' => '用户名',
            'obj_id' => '产品id',
            'grade' => '点评评分',
            'create_time' => '点评时间',
            'img_num' => '图片数量',
            'content' => '点评内容',
            'order_no' => '订单号',
            'obj_type' => '业务线',
            'quintessence' => '精华点评',
            'pic' => '图片',
            'obj_sub_type' => '评论对象',

        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid'])->select(['mobile', 'id']);
    }

    public function getHousedetails()
    {
        return $this->hasOne(HouseDetails::className(), ['id' => 'obj_id'])->select(['title', 'id']);
    }

    public function getUsercommon()
    {
        return $this->hasOne(UserCommon::className(), ['uid' => 'uid'])->select(['nickname']);
    }

    public function getHouseusernickname()
    {
        return $this->hasOne(UserCommon::className(), ['uid' => 'uid'])->viaTable('house_details', ['id' => 'obj_id'])->select(['nickname', 'uid']);
    }

    public function getHouseusermoblie()
    {
        return $this->hasOne(User::className(), ['id' => 'uid'])->viaTable('house_details', ['id' => 'obj_id'])->select(['mobile', 'id']);
    }

    public function gettravelorder()
    {
        return $this->hasOne(TravelOrder::className(),['id' => 'order_id']);
    }

    public static function excelTime($date, $time = false) {

        if(function_exists('GregorianToJD')){

            if (is_numeric( $date )) {

                $jd = GregorianToJD( 1, 1, 1970 );

                $gregorian = JDToGregorian( $jd + intval ( $date ) - 25569 );

                $date = explode( '/', $gregorian );

                $date_str = str_pad( $date [2], 4, '0', STR_PAD_LEFT )

                    ."-". str_pad( $date [0], 2, '0', STR_PAD_LEFT )

                    ."-". str_pad( $date [1], 2, '0', STR_PAD_LEFT )

                    . ($time ? " 00:00:00" : '');

                return $date_str;

            }

        }else{

            $date=$date>25568?$date+1:25569;

            /*There was a bug if Converting date before 1-1-1970 (tstamp 0)*/

            $ofs=(70 * 365 + 17+2) * 86400;

            $date = date("Y-m-d",($date * 86400) - $ofs).($time ? " 00:00:00" : '');

        }

        return $date;

    }

    public function getstarlevel(){
        return $this->hasOne(StarLevel::className(),['c_id' => 'id']);
    }
}
