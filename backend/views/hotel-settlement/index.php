<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HotelSupplierSettlementQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '酒店结算';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-supplier-settlement-index">
    <p>
        <?= Html::a('账户信息', \yii\helpers\Url::to(['hotel-settlement/account-detail']), ['class' => 'btn btn-success']) ?>
        <?= Html::a('供应商结算', \yii\helpers\Url::to(['hotel-settlement/index']), ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'header' =>'序号'],
            'settle_id',
            [
                'label' => '账单周期',
                'value' => function($model){
                    return (date('Y-m-d', strtotime($model->start_time)).'至'.date('Y-m-d', strtotime($model->end_time)));
                }
            ],
            [
                'label' => '结算周期',
                'value' => function($model){
                    return Yii::$app->params['hotel_supplier_settle_type'][$model->supplier->settle_type];
                }
            ],
            [
                'label' => '订单数',
                'value' => function($model){
                    return count($model->detail);
                }
            ],
             'total',
            [
                'label' => '状态',
                'value' => function($model){
                    return Yii::$app->params['hotel_settle_status'][$model->status];
                }
            ],
            [
                'label' => '来源酒店',
                'value' => function($model){
                    return \backend\controllers\HotelSettlementController::HotelName($model->hotel_id);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '<div class="dropdown profile-element group-btn-edit">{view}</div> ',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('查看账单', "#", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white', 'MyAttr'=> $model->id]);
                    },
                ]
            ],
        ],
    ]); ?>
</div>
