<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class VueAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'http://cdn.bootcss.com/vue/2.2.6/vue.min.js',
        'http://cdn.bootcss.com/vue-resource/1.2.1/vue-resource.js',
        'http://cdn.bootcss.com/axios/0.16.1/axios.js',
//        'https://unpkg.com/lodash@4.13.1/lodash.js',
        'https://cdn.bootcss.com/lodash.js/4.13.1/lodash.js',
//        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js',
        'https://cdn.bootcss.com/moment.js/2.18.1/moment.min.js',

//        'https://unpkg.com/element-ui/lib/index.js',
        'https://cdn.bootcss.com/element-ui/1.4.2/index.js',
        '/js/custom_validator_rule.js?version=2',
        '/js/common_methods.js?version=2'

    ];
    public $css = [
//        'http://cdn.bootcss.com/element-ui/1.2.9/theme-default/index.css'
//        'http://cdn.bootcss.com/element-ui/1.3.1/theme-default/index.css',
        'https://cdn.bootcss.com/element-ui/1.4.2/theme-default/index.css',
        'http://cdn.bootcss.com/animate.css/3.5.2/animate.min.css'
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
}
