<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "travel_company".
 *
 * @property integer $id
 * @property string $name
 * @property string $recommend
 * @property string $license
 * @property string $operation
 * @property integer $uid
 * @property integer $status
 * @property integer $type
 * @property integer $obj_id
 * @property integer $is_login
 * @property string $create_time
 */
class TravelCompany extends \yii\db\ActiveRecord
{
    public $company_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'status', 'type', 'obj_id', 'is_login'], 'integer'],
            [['create_time','reg_city','reg_county'], 'safe'],
            [['travel_avatar','company_address','name','reg_country','reg_province','recommend','brandname','business_name','business_tel','business_email','finance_name','finance_tel','finance_email'],'required'],
            [['name'], 'string', 'max' => 200],
            [['recommend'], 'string', 'max' => 300],
            [['license', 'operation'], 'string', 'max' => 100],
            [['license','operation','policy','proposer_a','proposer_b','finance_name','finance_email','finance_tel'],'required','on'=>'addtwo'],
            [['corporation_id_a','corporation_id_b','tax_certificate'],'safe','on'=>'addtwo'],
            [['reg_file','corporation_id_a','corporation_id_b','proposer_a','proposer_b','finance_name','finance_email','finance_tel'],'required','on'=>'addtwoabis'],
            [['trade_license','travel_insurance','tax_certificate'],'safe','on'=>'addtwoabis'],
            [['license','proposer_a','proposer_b','finance_name','finance_email','finance_tel'],'required','on'=>'addtwocnnot'],
            [['corporation_id_a','corporation_id_b'],'safe','on'=>'addtwocnnot'],
            [['reg_file','corporation_id_a','corporation_id_b','proposer_a','proposer_b','finance_name','finance_email','finance_tel'],'required','on'=>'addtwoabroadnot'],
            ['business_tel','checkbusinesstellength'],
            ['finance_tel','checkfinancetellength'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '公司名称',
            'recommend' => '公司推荐',
            'license' => '营业执照副本',
            'operation' => '旅行社经营许可证',
            'uid' => '用户id',
            'status' => '0=>未审核 1=>审核中 2=>未通过 3=>已通过',
            'type' => '1=>主题嗨Go  2=>门票',
            'obj_id' => '临时认证关联主题嗨go或门票主键id',
            'is_login' => '是否登录',
            'create_time' => '上传时间',
            'reg_addr_type' => '公司注册地类型',
            'reg_country' => '公司注册国家',
            'reg_province' => '公司注册省',
            'reg_city' => '公司注册城市',
            'reg_county' => '公司注册区域',
            'group_type' => '类型',
            'company_address' => '公司地址',
            'brandname' => '主页品牌名称',
            'business_name' => '业务联系人姓名',
            'business_tel' => '业务人电话',
            'business_email' => '业务人邮箱',
            'proposer_a' => '申请人身份证A面',
            'proposer_b' => '申请人身份证B面',
            'policy' => '旅行社责任保险单',
            'corporation_id_a' => '企业法人身份证A面',
            'corporation_id_b' => '企业法人身份证 B面',
            'tax_certificate' => '税务许可证明',
            'finance_name' => '财务人姓名',
            'finance_tel' => '财务人电话',
            'finance_email' => '财务人邮箱',
            'reg_file' => '公司登记注册文件',
            'trade_license' => '行业经营许可证',
            'travel_insurance' => '旅游保险证明',
            'account_type' => '账户类型',
        ];
    }

    public static function getCompany($uid)
    {
        return Yii::$app->db->createCommand("select * from travel_company where uid = {$uid}")->queryOne();
    }

    public static function getUid($str)
    {
        $cuid = Yii::$app->db->createCommand("select uid from travel_company where name  LIKE '%{$str}%'")->queryScalar();
        $puid = Yii::$app->db->createCommand("select uid from travel_person where name  LIKE '%{$str}%'")->queryScalar();
        if ($cuid) {
            return $cuid;
        }
        if ($puid) {
            return $puid;
        }
        return 0;
    }

    //@2017-7-21 11:20:37 fuyanfei to add 根据资质名称获取资质id
    public static function getUidArr($str)
    {
        //根据资质名称查询公司资质
        $company = Yii::$app->db->createCommand("select uid from travel_company where name  LIKE '%{$str}%'")->queryAll();
        //根据资质名称查询个人资质
        $person  = Yii::$app->db->createCommand("select uid from travel_person where name  LIKE '%{$str}%'")->queryAll();
        //合并数组
        $merge = array_merge($company,$person);
        $result = [];
        if($merge){
            foreach($merge as $key=>$val){
                $result[] = $val['uid'];
            }
        }
        //数组  去重
        $res = array_unique($result);
        if($res)
            return $res;
        else
            return 0;
    }

    public function getBank()
    {

        return $this->hasOne(TravelAccountBank::className(), ['uid' => 'uid']);
    }

    public  function getUser(){
        return $this->hasOne(User::className(),['id' => 'uid']);
    }

    public function checkbusinesstellength(){
        if(strlen($this->business_tel)>20){
            return  $this->addError('mobile', '业务联系人电话不正确');
        }
    }
    public function checkfinancetellength(){
        if(strlen($this->finance_tel)>20){
            return  $this->addError('mobile', '财务联系人电话不正确');
        }
    }

}
