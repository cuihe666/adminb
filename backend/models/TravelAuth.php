<?php
/**
 * Created by PhpStorm.
 * User: snowno
 * Date: 2017/8/31 0031
 * Time: 13:40
 */
namespace backend\models;
use backend\models\TravelPerson;
use backend\models\TravelCompany;
/*
 * 旅行资质身份认证
 * */
class TravelAuth {

    public static function getUserAuth($uid = ''){
        if($uid){
            $person = TravelPerson::find()->where(['uid' => $uid])->one();
            $company = TravelCompany::find()->with('user')->with('bank')->where(['uid' => $uid])->one();
            $data = [];
            if($person && $company){
                $person_date = $person->create_time;
                $company_date = $person->create_time;
                if($person_date > $company_date){
                    $data['auth'] =  2;//个人
                    $data['model'] =  $person;
                }else{
                    $data['auth'] =  1;//公司
                    $data['model'] =  $company;//公司
                }
            }else if($company){
                $data['auth'] =  1;//公司
                $data['model'] =  $company;//公司
            }else if($person){
                $data['auth'] =  2;//个人
                $data['model'] =  $person;
            }else{
                $data['auth'] =  0;//无认证
            }
            return $data;
        }
    }
}