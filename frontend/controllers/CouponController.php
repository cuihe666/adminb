<?php
namespace frontend\controllers;

use yii\web\Controller;

class CouponController extends Controller
{
    public function init()
    {
        $this->enableCsrfValidation = false;
    }

    public function actionGet()
    {
        $batch_code = '5940a4f9cbf5f_170614104';
        $data = \Yii::$app->db->createCommand("select * from coupon1_batch WHERE batch_code='{$batch_code}' ORDER BY id DESC limit 1")->queryOne();
        if ($data['status'] == 4) {
            return 0;
        }
        $coupon = \Yii::$app->db->createCommand("select * from coupon1 WHERE batch_code='{$batch_code}' AND batch_id={$data['id']} AND uid=0 AND status=1 ORDER BY id DESC limit 1")->queryOne();
        if (empty($coupon)) {
            return 0;
        }
        return $coupon['id'];
    }
}