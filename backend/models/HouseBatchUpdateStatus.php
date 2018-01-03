<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;

/**
 * This is the model class for table "house_batch_update_status".
 *
 * @property integer $id
 * @property string $update_sql
 * @property string $search_query
 * @property string $update_house_id_str
 * @property string $create_time
 * @property integer $admin_uid
 * @property integer $update_type
 */
class HouseBatchUpdateStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_batch_update_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_sql', 'search_query', 'update_house_id_str','search_query_notnull'], 'string'],
            [['admin_uid','update_type'],'integer'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'update_sql' => '更新语句',
            'search_query' => '查询基础',
            'create_time' => '创建日期',
            'admin_uid' => '操作人id',
            'update_house_id_str' => '更新房源id',
            'update_type' => '1=>上线  2=>下线',
            'search_query_notnull' => '有效查询条件',
        ];
    }

    public static function getReason($params){
        if($params){
            $str = '';
            foreach($params as $k=>$v){
                if($k == 'HouseDetailsQuery[type]'){

                    switch ($v){
                        case 1:
                            $str .= '创建时间,';
                        break;
                        case 2:
                            $str .= '修改时间,';
                            break;
                        case 3:
                            $str .= '审核时间,';
                            break;
                    }
                }
                if($k == 'HouseDetailsQuery[start_time]'){
                    $str .= '起始时间:';
                    $str .= $v;
                }
                if($k == 'HouseDetailsQuery[s_status]'){
                    $str .= '房源状态:';
                    switch ($v){
                        case -1:
                            $str .= '待完善,';
                            break;
                        case 1:
                            $str .= '已上架,';
                            break;
                        case 2:
                            $str .= '已下架,';
                            break;
                        case 3:
                            $str .= '审核未通过,';
                            break;
                        case 4:
                            $str .= '待提交,';
                            break;
                        case 6:
                            $str .= '待审核,';
                            break;
                    }
                }

                if($k == 'HouseDetailsQuery[city_name]'){
                    $str .= '按城市或区域模糊查询:';
                    $str .= $v.',';
                }
                if($k == 'HouseDetailsQuery[title]'){
                    $str .= '房源标题:';
                    $str .= $v.',';
                }
                if($k == 'HouseDetailsQuery[mobile]'){
                    $str .= '手机号:';
                    $str .= $v.',';
                }
                if($k == 'HouseDetailsQuery[province]'){
                    $str .= '选择省份:';
                    $str .= CommonService::getCityName($v);
                }
                if($k == 'HouseDetailsQuery[city]'){
                    $str .= '选择城市:';
                    $str .= CommonService::getCityName($v);
                }
                if($k == 'HouseDetailsQuery[area]'){
                    $str .= '选择地区:';
                    $str .= CommonService::getCityName($v);
                }
                if($k == 'HouseDetailsQuery[country]'){
                    $str .= '选择国家:';
                    $str .= CommonService::getCityName($v);
                }
                if($k == 'HouseDetailsQuery[low_price]'){
                    $str .= '最低价格:';
                    $str .= $v.',';
                }
                if($k == 'HouseDetailsQuery[height_price]'){
                    $str .= '最高价格:';
                    $str .= $v.',';
                }
                if($k == 'HouseDetailsQuery[house_id]'){
                    $str .= '房源id:';
                    if(is_array($v)){
                        foreach($v as $kk=>$vv){
                            $str .= $vv.',';
                        }
                    }else{
                        $str .= $v.',';
                    }
                }
                if($k == 'HouseDetailsQuery[salesman]'){
                    $str .= '房管员姓名:';
                    $str .= $v.',';
                }
                if($k == 'HouseDetailsQuery[house_type]'){
                    $str .= '房源类型:';
                    $str .= DtHouseType::getTypenameById($v);
                }
                if($k == 'HouseDetailsQuery[up_type]'){
                    $str .= '上传方式:';
                    switch ($v){
                        case 0:
                            $str .= 'app上传,';
                            break;
                        case 1:
                            $str .= '特殊上传,';
                            break;
                        case 2:
                            $str .= '合伙人,';
                            break;
                        case 3:
                            $str .= 'PC房东,';
                            break;
                        case 4:
                            $str .= '番茄来了,';
                            break;
                        case 6:
                            $str .= '同程,';
                            break;
                    }
                }


            }

            return $str;
        }
    }

    public static function getValid(){
        $data = HouseBatchUpdateStatus::find()->where(['update_type' => 2,'status' => 0])->all();
        return $data;
    }
}
