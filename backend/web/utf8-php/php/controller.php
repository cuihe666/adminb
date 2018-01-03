<?php
//header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
date_default_timezone_set("Asia/chongqing");
error_reporting(E_ERROR);
header("Content-Type: text/html; charset=utf-8");
//require 'yii2-qiniu/autoload.php';
$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
$action = $_GET['action'];

switch ($action) {
    case 'config':
        $result =  json_encode($CONFIG);
        break;

    /* 上传图片 */
    case 'uploadimage':
//        $houzhui = strrchr($_FILES['upfile']['name'], '.');
//        $key = 'travel_' . 15 . '_' . time() . $houzhui;
//        $auth=new \Qiniu\Auth('7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0','XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx');
//        $bucket = 'imgs';
//        $token = $auth->uploadToken($bucket);
//        // 要上传文件的本地路径
//        $filePath = $_FILES['upfile']['tmp_name'];
//        // 上传到七牛后保存的文件名
//        // 初始化 UploadManager 对象并进行文件的上传
//        $uploadMgr = new \Qiniu\Storage\UploadManager();
//        // 调用 UploadManager 的 putFile 方法进行文件的上传
//        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
//        break;
    /* 上传涂鸦 */
    case 'uploadscrawl':
    /* 上传视频 */
    case 'uploadvideo':
    /* 上传文件 */
    case 'uploadfile':
        $result = include("action_upload.php");
        break;

    /* 列出图片 */
    case 'listimage':
        $result = include("action_list.php");
        break;
    /* 列出文件 */
    case 'listfile':
        $result = include("action_list.php");
        break;

    /* 抓取远程文件 */
    case 'catchimage':
        $result = include("action_crawler.php");
        break;

    default:
        $result = json_encode(array(
            'state'=> '请求地址出错'
        ));
        break;
}
/* 输出结果 */
if (isset($_GET["callback"])) {
    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
    } else {
        echo json_encode(array(
            'state'=> 'callback参数不合法'
        ));
    }
} else {
    echo $result;
}