<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author GPF <5173180@qq.com>
 * 加载一个辅助插件
 */
class LoadshAsset extends AssetBundle
{
    public $css = [

    ];
    public $js = [
        'https://unpkg.com/lodash@4.13.1/lodash.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
}
