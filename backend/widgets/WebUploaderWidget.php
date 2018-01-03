<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/4/25
 * Time: 上午11:27
 */

namespace backend\widgets;


use yii\base\Widget;

class WebUploaderWidget extends Widget
{
    public $widget_id = null;
    public function init()
    {
        parent::init();

        $this->widget_id = $this->widget_id?: uniqid();
    }

    public function run(){


        return $this->render('web_upload_block',[
            'widget_id' => $this->widget_id
        ]);
    }

}