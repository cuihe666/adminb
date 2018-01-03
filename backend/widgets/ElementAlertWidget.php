<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/4/25
 * Time: 上午11:27
 */

namespace backend\widgets;


use yii\base\Widget;

class ElementAlertWidget extends Widget
{
    public $widget_id = null;
    public function init()
    {
        parent::init();
    }

    public function run(){
        return $this->render('element_alert');
    }

}