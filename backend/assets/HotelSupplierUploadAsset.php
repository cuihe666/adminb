<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class HotelSupplierUploadAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'hotel/css/webuploader.css',
    ];
    public $js = [
        'hotel/js/webuploader.js',
        'hotel/js/upload5.js?v=6',
        'hotel/js/upload6.js?v=6',
        'hotel/js/upload7.js?v=6',
        'hotel/js/upload8.js?v=6',
    ];
    public $depends = [

    ];
}
