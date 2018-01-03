<?php
/**
 * fileupload.php
 * 重新编写百度上传控件的逻辑。
 * 将上传的文件直接传到七牛服务器
 * @author : 付燕飞
 * @date   : 2017-4-7 15:21:50
 */

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit; // finish preflight CORS requests here
}

if (!empty($_REQUEST['debug'])) {
    $random = rand(0, intval($_REQUEST['debug']));
    if ($random === 0) {
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    }
}

//设置最大执行时间
@set_time_limit(5 * 60);

include "./Uploader.class.php";
require_once './qiniu/autoload.php';

$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds

$img_size = getimagesize($_FILES['file']['tmp_name']);

//将获取到的file文件的tmp_name赋值到$_REQUEST中
$_REQUEST['tmp_name'] = $_FILES['file']['tmp_name'];
$_REQUEST['width']=$img_size[0];
$_REQUEST['height']=$img_size[1];
//实例化Uploader
$up = new Uploader($_REQUEST);


/* 返回数据 */
die(json_encode($up->getFileInfo()));
