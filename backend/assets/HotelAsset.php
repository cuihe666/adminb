<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class HotelAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'hotel/css/gobal.css?v=2',
        'hotel/css/rummery.css',
        'hotel/css/xhhgrogshop.css',
//        'hotel/css/webuploader.css',
        'hotel/css/style.css',
        'My97DatePicker/skin/default/datepicker.css'
    ];
    public $js = [
        'hotel/js/gobal.js?v=4333443',
        'hotel/js/rummery.js?v=3444',
        'My97DatePicker/WdatePicker.js',
//        'hotel/js/webuploader.js',
//        'hotel/js/upload5.js?v=3',
//        'hotel/js/upload6.js?v=3',
//        'hotel/js/upload7.js?v=3',
//        'hotel/js/upload8.js?v=3',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
