<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HotelOrderQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hotel Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Hotel Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'order_num',
            'transaction_id',
            'hotel_id',
            'hotel_name',
            // 'hotel_house_id',
            // 'hotel_house_name',
            // 'hotel_type',
            // 'status',
            // 'pay_platform',
            // 'refund_rule',
            // 'bed_type',
            // 'breakfast',
            // 'order_uid',
            // 'order_mobile',
            // 'prompt',
            // 'preference',
            // 'in_time',
            // 'out_time',
            // 'province',
            // 'city',
            // 'area',
            // 'address',
            // 'mobile_area',
            // 'mobile',
            // 'order_total',
            // 'pay_total',
            // 'hotel_income',
            // 'tango_income',
            // 'create_time',
            // 'update_time',
            // 'is_delete',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
