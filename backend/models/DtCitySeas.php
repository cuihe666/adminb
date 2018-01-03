<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dt_city_seas".
 *
 * @property integer $code
 * @property string $name
 * @property integer $parent
 * @property integer $level
 * @property integer $operation
 * @property integer $version
 * @property string $pinyin
 * @property string $abbre
 * @property integer $country
 * @property string $first_letter
 * @property integer $seas
 * @property integer $display
 * @property integer $travel
 * @property string $time_zone
 */
class DtCitySeas extends \yii\db\ActiveRecord
{
    public $city_name;//国家名
    public $province_name;//省市名
    public $region_name;//地区名
    public $start_name;  //出发城市
    public $end_name;    //目的城市

    public $city1;    //2017年7月3日16:04:58 付燕飞增加   印象/游记 相关城市1；
    public $city2;    //2017年7月3日16:04:58 付燕飞增加   印象/游记 相关城市2；
    public $city3;    //2017年7月3日16:04:58 付燕飞增加   印象/游记 相关城市3；
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dt_city_seas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code', 'parent', 'level', 'operation', 'version', 'country', 'seas', 'display', 'travel', 'is_visiable'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['pinyin'], 'string', 'max' => 2048],
            [['abbre', 'first_letter'], 'string', 'max' => 512],
            [['time_zone'], 'string', 'max' => 20],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => '城市code',
            'name' => '城市名称',
            'parent' => '父节点code',
            'level' => '等级',
            'operation' => 'Operation',
            'version' => 'Version',
            'pinyin' => 'Pinyin',
            'abbre' => 'Abbre',
            'country' => 'Country',
            'first_letter' => 'First Letter',
            'seas' => '默认为0.国内, 1.国外',
            'display' => '0不显示,1.显示',
            'travel' => '默认1.旅游业务:(不要添加其他)',
            'time_zone' => '时区',
            'is_visiable' => '0默认不展示，1展示',
        ];
    }

    public static  function getFirstCharter($str){
        if(empty($str))
        {
            return '';
        }
        $fchar=ord($str{0});
        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
        $s1=iconv('UTF-8','gb2312',$str);
        $s2=iconv('gb2312','UTF-8',$s1);
        $s=$s2==$str?$s1:$str;
        $asc=ord($s{0})*256+ord($s{1})-65536;
        if($asc>=-20319&&$asc<=-20284) return 'A';
        if($asc>=-20283&&$asc<=-19776) return 'B';
        if($asc>=-19775&&$asc<=-19219) return 'C';
        if($asc>=-19218&&$asc<=-18711) return 'D';
        if($asc>=-18710&&$asc<=-18527) return 'E';
        if($asc>=-18526&&$asc<=-18240) return 'F';
        if($asc>=-18239&&$asc<=-17923) return 'G';
        if($asc>=-17922&&$asc<=-17418) return 'H';
        if($asc>=-17417&&$asc<=-16475) return 'J';
        if($asc>=-16474&&$asc<=-16213) return 'K';
        if($asc>=-16212&&$asc<=-15641) return 'L';
        if($asc>=-15640&&$asc<=-15166) return 'M';
        if($asc>=-15165&&$asc<=-14923) return 'N';
        if($asc>=-14922&&$asc<=-14915) return 'O';
        if($asc>=-14914&&$asc<=-14631) return 'P';
        if($asc>=-14630&&$asc<=-14150) return 'Q';
        if($asc>=-14149&&$asc<=-14091) return 'R';
        if($asc>=-14090&&$asc<=-13319) return 'S';
        if($asc>=-13318&&$asc<=-12839) return 'T';
        if($asc>=-12838&&$asc<=-12557) return 'W';
        if($asc>=-12556&&$asc<=-11848) return 'X';
        if($asc>=-11847&&$asc<=-11056) return 'Y';
        if($asc>=-11055&&$asc<=-10247) return 'Z';
        return null;
    }

    public static function getName($code){
//        var_dump($code);exit;
        if($code){
            $name = '';
            if(is_array($code)){
                foreach($code as $k=>$v){
                    $sql = "select name from dt_city_seas  WHERE code = {$v}";
                    $name .= Yii::$app->db->createCommand($sql)->queryOne()['name'].',';
                }
            }else{
                $sql = "select name from dt_city_seas  WHERE code = {$code}";
                $name = Yii::$app->db->createCommand($sql)->queryOne()['name'].',';
            }

            return $name;
        }
    }

    //根据城市统计当地活动的数量
    public static function getActivityCount($code,$status="9"){
        $sql = "SELECT count(id) as total FROM travel_activity WHERE city_code = '".$code."'";
        if($status == 9){
            $sql .= " AND status != -1";
        } else{
            $sql .= " AND status = '".$status."'";
        }
        $activity = Yii::$app->db->createCommand($sql)->queryOne();
        return $activity['total'];
    }

    //根据城市统计主题线路的数量
    public static function getHigoCount($code,$status="9"){
        $sql = "SELECT count(id) as total FROM travel_higo WHERE (start_city = '".$code."' or end_city = '".$code."')";
        if($status == 9){
            $sql .= " AND status != -1";
        } else{
            $sql .= " AND status = '".$status."'";
        }
        $activity = Yii::$app->db->createCommand($sql)->queryOne();
        return $activity['total'];
    }

    //根据城市统计印象的数量
    public static function getImpressCount($code,$status="9"){
        $sql = "SELECT count(id) as total FROM travel_impress WHERE (city1 = '".$code."' or city2 = '".$code."' or city3 = '".$code."')";
        if($status == 9){
            $sql .= " AND status != -1";
        } else{
            $sql .= " AND status = '".$status."'";
        }
        $activity = Yii::$app->db->createCommand($sql)->queryOne();
        return $activity['total'];
    }

    //根据城市统计游记的数量
    public static function getNoteCount($code,$status="9"){
        $sql = "SELECT count(id) as total FROM travel_note WHERE (city1 = '".$code."' or city2 = '".$code."' or city3 = '".$code."')";
        if($status == 9){
            $sql .= " AND status != -1";
        } else{
            $sql .= " AND status = '".$status."'";
        }
        $activity = Yii::$app->db->createCommand($sql)->queryOne();
        return $activity['total'];
    }
}
