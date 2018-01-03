<?php
namespace backend\service;
use backend\models\TravelCompany;
use backend\models\TravelPerson;
use backend\models\User;
use Yii;
/**
 * 获取当前用户的身份的service
 */
class UserIdentityService
{
    /**
     * 获取当前登录用户的身份信息
     * @param $uid
     * @return array
     */
    public static function getUserIdentityInfo($uid){
        //获取会员信息
        $userInfo = User::findOne($uid);
        //获取个人资质信息
        $person = TravelPerson::find()->where(['uid' => $uid])->one();
        //获取公司资质信息
        $company = TravelCompany::find()->where(['uid' => $uid])->one();
        //判断如果个人资质信息不为空，公司资质信息为空，则为个人资质
        if ($person && !$company) {
            $auth      = 1;                      //当前身份为1：个人资质
            $id        = $person->id;           //个人资质表中的id
            $status    = $person->status;      //个人资质审核状态
            $name      = $person->name;        //个人资质姓名
            $nick_name = $person->nick_name;  //个人资质昵称
        }
        //判断如果公司资质信息不为空，个人资质信息为空，则为公司资质
        elseif ($company && !$person) {
            $auth      = 2;                      //当前身份为2：公司资质
            $id        = $company->id;           //公司资质表中的id
            $status    = $company->status;      //公司资质审核状态
            $name      = $company->name;        //公司资质名称
            $nick_name = $company->brandname;  //公司资质品牌名称
        }
        //如果个人资质和公司资质都不为空
        elseif($person && $company){
            //根据时间判断，如果个人资质的注册时间大于公司资质的注册时间，则取个人资质的信息，否则取公司资质的信息
            if($person->create_time > $company->create_time){
                $auth      = 1;                      //当前身份为1：个人资质
                $id        = $person->id;           //个人资质表中的id
                $status    = $person->status;      //个人资质审核状态
                $name      = $person->name;        //个人资质姓名
                $nick_name = $person->nick_name;  //个人资质昵称
            }
            else{
                $auth      = 2;                      //当前身份为2：公司资质
                $id        = $company->id;           //公司资质表中的id
                $status    = $company->status;      //公司资质审核状态
                $name      = $company->name;        //公司资质名称
                $nick_name = $company->brandname;  //公司资质品牌名称
            }
        }
        //如果公司资质和个人资质都为空的情况下，为普通用户
        else{
            $auth      = 0;
            $status    = 3;
            $name      = "--";
            $nick_name = "--";
        }
        $res = [
            'auth'       => $auth,
            'id'         => $id,
            'mobile'     => $userInfo->mobile,
            "name"       => $name,
            'nick_name' => $nick_name,
            'status'    => $status,
        ];
        return $res;
    }
}


