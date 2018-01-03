<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/4/18
 * Time: 下午6:40
 */

namespace backend\common;

use mdm\admin\models\Assignment;

class Helper
{
    public static $permission;
    public static $lastMonth;
    public static $lastWeek;
    //打断点函数
    public static function dd(){
        $param = func_get_args();

        echo '<pre>'.PHP_EOL;
        foreach($param as $item){
            if(class_exists('Symfony\Component\VarDumper\VarDumper')){
                \Symfony\Component\VarDumper\VarDumper::dump($item);
            }else{
                print_r($item);
            }
            echo PHP_EOL;
        }
        die();
    }


    //获取表单提交 request_payload 内容
    public static function requestPayload(){
        $request_payload = file_get_contents('php://input');
        return json_decode($request_payload,true);
    }

    //批量赋值到 model 中
    public static function loadModel(&$model,$data){
        if (empty($model) || empty($data)){
            return false;
        }
        $allow = $model->attributeLabels();
        foreach ($data as $key => $item){
            if(array_key_exists($key,$allow)){
                $model->$key = $item;
            }
        }
        return true;
    }
    //重置 model 内容
    public static function resetModel(&$model){
        $allow = $model->attributeLabels();
        foreach ($allow as $key => $item){
            if($model->$key){
                $model->$key = null;
            }
        }
        return true;
    }

    //通过后缀判定是不是图片后缀
    public static function isImageExt($filename){
        $ext = substr(strrchr($filename, "."), 1);
        $ext = strtolower($ext);

        return in_array($ext,['bmp','jpg','jpeg','png','gif']);
    }

    /**
     * 存入 log 信息
     * @param array $custom
     */
    public static function log($custom = []){
        $auto = [
            'user_id'=>0,'table_name'=> null,'record_id'=>0,'remark' => '',
            'node' => \Yii::$app->request->getPathInfo(),
            'admin_id' => \Yii::$app->getUser()->identity->username,
            'create_time' => time()
        ];
        $arr = array_merge($auto,$custom);
        $arr = array_filter($arr,function($k){
            $allow = ['user_id','table_name','record_id','remark','node','admin_id','create_time'];
            return in_array($k,$allow);
        },ARRAY_FILTER_USE_KEY);

        return \Yii::$app->db->createCommand()->insert('admin_log',$arr)->execute();
    }


    //获取上周的起始日期和截止日期
    public static function lastWeek($hours = false,$fmt = 'Y-m-d'){
        if(!$hours && self::$lastWeek){
            return self::$lastWeek;
        }
        //判定当天是周几 如果是周日的话就变成7
        $today = date('w');
        $today = $today? $today : 7;
        $last_sunday = date($fmt,strtotime("-{$today} day"));
        $last_monday = date($fmt,strtotime("-". ($today+6) ." day"));
        if(!$hours){
            self::$lastWeek = [$last_monday . ' 00:00:00', $last_sunday . ' 23:59:59'];
        }

        return $hours? [$last_monday,$last_sunday] : self::$lastWeek;
    }

    //获取上月的起始日期和截止日期
    public static function lastMonth($hours = false,$fmt = 'Y-m-d'){
        if(!$hours && self::$lastMonth){
            return self::$lastMonth;
        }
        $date = date('Y-n-d');
        $date = explode('-',$date);

        //日期长短的判断
        $role = [1,3,5,7,8,10,12];
        if($date[1] != 3){
            $last_month = ($date[1] == 1)? 12 : $date[1] - 1;
            $day_count = (in_array($last_month,$role))? 31 : 30;
        }else{
            //闰年判定
            $day_count = ($date[0]%4 == 0)? 29 : 28;
        }


        $last_month_end = date($fmt,strtotime("-{$date[2]} day"));
        $last_month_start = date($fmt,strtotime("-". ($date[2] + $day_count - 1) ." day"));

        if(!$hours){
            self::$lastMonth = [$last_month_start . ' 00:00:00', $last_month_end . ' 23:59:59'];
        }

        return $hours? [$last_month_start,$last_month_end] : self::$lastMonth;
    }

    //获取当天到本周一的时间段
    public static function thisWeek($hours = false){
        //判定当天是周几 如果是周日的话就变成7
        $today = date('w');
        //当月第一天和当周第一天都不返回字段
        if($today == 1) {
            $today = date('Y-m-d');
            if($hours){
                return [$today,$today];
            }
            return [
                $today . ' 00:00:00',
                $today . ' 23:59:59'
            ];
        }
        $today = $today? $today : 7;

        $today -= 1;

        $this_week_start = date('Y-m-d',strtotime("-{$today} day"));
        $yesterday = date('Y-m-d',strtotime("-1 day"));


        return $hours? [$this_week_start,$yesterday] : [$this_week_start . ' 00:00:00', $yesterday . ' 23:59:59'];
    }

    //获取当天到本月一号的时间短
    public static function thisMonth($hours = false){
        $today = date('d');

        //当月第一天和当周第一天都不返回字段
        if($today == 1) {

            $today = date('Y-m-d');
            if($hours){
                return [$today,$today];
            }
            return [
                $today . ' 00:00:00',
                $today . ' 23:59:59'
            ];
        }

        $today -= 1;
        $this_month_start = date('Y-m-d',strtotime("-{$today} day"));
        $yesterday = date('Y-m-d',strtotime("-1 day"));

        return $hours? [$this_month_start,$yesterday] : [$this_month_start . ' 00:00:00', $yesterday . ' 23:59:59'];
    }

    //检测用户权限
    public static function checkPermission($permission){
        if(self::$permission == null){
            $permissions = \Yii::$app->getAuthManager()->getPermissionsByUser(\Yii::$app->user->id);
            $permissions = array_keys($permissions);
            self::$permission = $permissions;
        }


        return in_array($permission,self::$permission);
    }

    //检测手机号正则
    public static function isPhone($phone){
        $g = "/^1[34578]\d{9}$/";
        return preg_match($g,$phone);
    }

    //检测密码是否在 ASCII 编码范围内
    public static function isPassword($password){
        $g = "/^[\x00-\xff]+$/";
        return preg_match($g,$password);
    }

    public static function getErrors($validate){
        $errors = [];
        foreach($validate as $key => $item){
            $errors[] = implode(',',$item);
        }
        return $errors;
    }


    /**
     * 分配权限
     * @param $role     string    分配角色名
     * @param $user_id  int       用户 id
     */
    public static function assignRole($role,$user_id){
        $model = new Assignment($user_id);
        return $model->assign([$role]);

    }

    public static function getAdminId(){
        return \Yii::$app->getUser()->identity->admin_id;
    }

}