<?php

namespace backend\service;
use Yii;
/**
 * higo活动路线的service
 */
class HigoService
{
    /**
     * 根据higoid和二维码id获取此活动的点击量
     * @param $higoid
     * @param $qrcodeid
     * @return bool
     */
    public static function getClickNum($higoid,$qrcodeid)
    {
        $data = \Yii::$app->db->createCommand("select click_num from travel_higo_click WHERE  higo_id = ".$higoid." AND qrcode_id=".$qrcodeid)->queryOne();
        if (!$data) {
            return 0;
        }
        return $data['click_num'];
    }




}


