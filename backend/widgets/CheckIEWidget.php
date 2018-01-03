<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/6/7
 * Time: 上午11:43
 */

namespace backend\widgets;

use yii\base\Widget;

class CheckIEWidget extends Widget
{

    public function run(){
        return $this->render('checkIE');
    }

}