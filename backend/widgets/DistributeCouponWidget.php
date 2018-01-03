<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/6/8
 * Time: 下午5:47
 */

namespace backend\widgets;


use kartik\base\Widget;

class DistributeCouponWidget extends Widget
{
    public $with_html = false;
    public $vue_id = null;
    public $title = '发放优惠券';
    public function init()
    {
        parent::init();
    }

    public function run(){
        if(is_null($this->vue_id)){
            $this->vue_id = uniqid();
        }
        return $this->render('distribute-coupon',[
            'with_html' => $this->with_html,
            'vue_id' => $this->vue_id,
            'title' => $this->title
        ]);

    }

}