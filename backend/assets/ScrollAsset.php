<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ScrollAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
      'dist/css/xhhgrogshop.css'
    ];
    public $js = [
        'dist/js/scroll.js',
    ];
}
