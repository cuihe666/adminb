<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderDetailStaticQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-detail-static-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii1\grid\SerialColumn'],
            'id',
            'order_uid',
            'house_uid',
            'house_id',
            'order_num',
            // 'create_time',
            // 'update_time',
            // 'extra_amount',
            // 'total',
            // 'in_time',
            // 'out_time',
            // 'day_num',
            // 'house_title_pic',
            // 'national',
            // 'house_province_id',
            // 'house_city_id',
            // 'house_county_id',
            // 'remarks',
            // 'house_apartments',
            // 'house_price',
            // 'house_deposit',
            // 'house_title',
            // 'roomnum',
            // 'officenum',
            // 'mobile',
            // 'really_name',
            // 'address',

            ['class' => 'yii1\grid\ActionColumn'],
        ],
    ]); ?>
</div>
