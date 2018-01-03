<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/4/26
 * Time: 下午5:30
 */
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = '关联酒店';
\backend\assets\ScrollAsset::register($this);

$gridColumns = [
    'id',
    'complete_name',
    [
        'label' => '所属城市',
        'value' => function($model){
            return $model->cityName->name;
        }
    ],
    [
        'label' => '是否启用',
        'value' => function($model){
            return Yii::$app->params['hotel_status'][$model->status];
        },
    ],
    [
        'label' => '关联状态',
        'value' => function($model){
            return Yii::$app->params['hotel_relation_status'][$model->supplier_relation];
        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => '操作',
        'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {show}
                                    {bundle}
                                </div> ',
        'buttons' => [
            'show' => function ($url, $model, $key) {
                $url = '/hotel/update?id='.$key;
                return Html::a('查看', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white','target'=>'_blank']);
            },

            'bundle' => function ($url, $model, $key) {
                $url = "/hotel-supplier/bundle?id={$model->supplier_id}&hotel_id={$key}";
                if($model->supplier_relation == 1){
                    return Html::a('解除关联', "$url", ['class' => 'delnode btn btn-danger btn-sm', 'style' => 'color:white']);
                }else{
                    return Html::a('关联', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                }
            },

        ]
    ],
];


\backend\assets\HotelAsset::register($this);
?>
<?= \backend\widgets\ElementAlertWidget::widget() ?>

<section class="content" >
    <div class="rummery_top">
<?= \backend\widgets\HotelSupplierListWidget::widget([
    'current_url' => Yii::$app->controller->action->id,
    'body' =>Yii::$app->params['hotel_supplier_nav'],
    'query' => Yii::$app->getRequest()->queryString,
]) ?>
    </div>


<div class="hotel-supplier-index">



    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">

            </div>
        </div>
    </div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'pager' => [
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
        ],
    ]); ?>

</div>
</section>