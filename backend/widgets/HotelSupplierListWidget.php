<?php
namespace backend\widgets;
use yii\base\Widget;

/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/4/18
 * Time: 下午4:01
 */
class HotelSupplierListWidget extends Widget
{
    public $current_url;
    public $body;
    public $query;

    public function init()
    {
        parent::init();
        if($this->body == null){
            $this->body = [];
        }

        if(!empty($this->query)){
            $this->query = '?'.$this->query;
        }
    }
    public function run(){
        return $this->render('hotel-supplier-list',[
            'current_url' => $this->current_url,
            'body' => $this->body,
            'query' => $this->query,
        ]);
    }

}