<?php
namespace backend\models;
require_once '../../common/tools/yii2-qiniu/autoload.php';
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class Qiniu
{
    public static function upload($name,$uid,$tmp,$type='xxxx')
    {
            $houzhui = strrchr($name, '.');
            switch ($type) {
                case 'city';
                    $key = 'city_manage_' . $uid . '_' . time() . $houzhui;
                    break;
                case 'house_type';
                    $key = 'houseType_manage_' . $uid . '_' . time() . $houzhui;
                    break;
                case 'home';
                    $key = 'home_manage_' . $uid . '_' . time() . $houzhui;
                    break;
                case 'activity':
                    $key = 'activity_manage_' . $uid . '_' . microtime(true) . $houzhui;
                    break;
                case 'impress':
                    $key = 'impress_manage_' . $uid . '_' . microtime(true) . $houzhui;
                    break;
                case 'roomfacilities':
                    $key = 'roomfacilities_manage_' . $uid . '_' . microtime(true) . $houzhui;
                    break;
                case 'column':
                    $key = 'column_manage_' . $uid . '_' . time() . $houzhui;
                    break;
                case 'special':
                    $key = 'special_manage_' . $uid . '_' . time() . $houzhui;
                    break;
                case 'travel':
                    $key = 'travel_manage_' . $uid . '_' . time() . $houzhui;
                    break;
                case 'ticket':
                    $key = 'ticket_manage_' . $uid . '_' . time() . $houzhui;
                    break;
                case 'indexbanner':
                    $key = 'indexbanner_manage_' . $uid . '_' . time() . $houzhui;
                    break;
                default:
                    $key = 'mp3_manage_' . $uid . '_' . time() . $houzhui;
                    break;
            }
            $auth = new Auth(\Yii::$app->params['qiniu']['access_key'], \Yii::$app->params['qiniu']['secret_key']);
            $bucket = 'imgs';
            $token = $auth->uploadToken($bucket);
            // 要上传文件的本地路径
            $filePath = $tmp;
            // 上传到七牛后保存的文件名
            // 初始化 UploadManager 对象并进行文件的上传
            $uploadMgr = new UploadManager();

            // 调用 UploadManager 的 putFile 方法进行文件的上传
            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);

            if ($err !== null) {
               return false;
            } else {
                return $ret['key'];
            }

    }
    public  static function musictype(){
        return ['audio/mp3','audio/mpeg','audio/mp4'];
    }

    public static function verifyType($arr){
        if(in_array($arr,self::musictype())){
            return true;
        }
        return false;

    }
}