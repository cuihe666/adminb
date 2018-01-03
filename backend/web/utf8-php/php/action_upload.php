<?php
/**
 * 上传附件和上传视频
 * User: Jinqn
 * Date: 14-04-09
 * Time: 上午10:17
 */
include "Uploader.class.php";
require 'yii2-qiniu/autoload.php';
/* 上传配置 */
$base64 = "upload";
switch (htmlspecialchars($_GET['action'])) {
    case 'uploadimage':
        $houzhui = strrchr($_FILES['upfile']['name'], '.');
        $key = 'travel_' . mt_rand(0,1000) . '_' . time() . $houzhui;
        $auth=new \Qiniu\Auth('7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0','XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx');
        $bucket = 'imgs';
        $token = $auth->uploadToken($bucket);
        // 要上传文件的本地路径
        $filePath = $_FILES['upfile']['tmp_name'];
        // 上传到七牛后保存的文件名
        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new \Qiniu\Storage\UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        $config = array(
            "pathFormat" => $CONFIG['imagePathFormat'],
            "maxSize" => $CONFIG['imageMaxSize'],
            "allowFiles" => $CONFIG['imageAllowFiles']
        );
        $fieldName = $CONFIG['imageFieldName'];
        $fullname='http://img.tgljweb.com/'.$key;
        break;
    case 'uploadscrawl':
        $config = array(
            "pathFormat" => $CONFIG['scrawlPathFormat'],
            "maxSize" => $CONFIG['scrawlMaxSize'],
            "allowFiles" => $CONFIG['scrawlAllowFiles'],
            "oriName" => "scrawl.png"
        );
        $fieldName = $CONFIG['scrawlFieldName'];
        $base64 = "base64";
        break;
    case 'uploadvideo':
        $houzhui = strrchr($_FILES['upfile']['name'], '.');
        $key = 'travel_' . mt_rand(0,1000) . '_' . time() . $houzhui;
        $auth=new \Qiniu\Auth('7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0','XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx');
        $bucket = 'imgs';
        $token = $auth->uploadToken($bucket);
        // 要上传文件的本地路径
        $filePath = $_FILES['upfile']['tmp_name'];
        // 上传到七牛后保存的文件名




        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new \Qiniu\Storage\UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        $config = array(
            "pathFormat" => $CONFIG['videoPathFormat'],
            "maxSize" => $CONFIG['videoMaxSize'],
            "allowFiles" => $CONFIG['videoAllowFiles']
        );
        $fieldName = $CONFIG['videoFieldName'];
        $fullname='http://img.tgljweb.com/'.$key;
        break;
    case 'uploadfile':
    default:
        $config = array(
            "pathFormat" => $CONFIG['filePathFormat'],
            "maxSize" => $CONFIG['fileMaxSize'],
            "allowFiles" => $CONFIG['fileAllowFiles']
        );
        $fieldName = $CONFIG['fileFieldName'];
        break;
}

/* 生成上传实例对象并完成上传 */
$up = new Uploader($fieldName, $config, $base64,$fullname);

/**
 * 得到上传文件所对应的各个参数,数组结构
 * array(
 *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
 *     "url" => "",            //返回的地址
 *     "title" => "",          //新文件名
 *     "original" => "",       //原始文件名
 *     "type" => ""            //文件类型
 *     "size" => "",           //文件大小
 * )
 */

/* 返回数据 */
return json_encode($up->getFileInfo());
