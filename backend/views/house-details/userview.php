<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '房源列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<script>
    function city(obj) {
        $.get("<?=Url::to(["house-details/getcity"])?>" + "?id=" + $(obj).val(), function (data) {
            $("#bank_city").html(data);
        });

    }

    function area(obj) {
        $.get("<?=Url::to(["house-details/getarea"])?>" + "?id=" + $(obj).val(), function (data) {
            $("#bank_area").html(data);
        });

    }

</script>

<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">


                <?php
                use kartik\export\ExportMenu;

                $gridColumns = [


                    'title',
                    ['attribute' => 'houseserach.city',
                        'value' => function ($model) {
                            return \backend\service\CommonService::get_city_name($model->houseserach['city']);
                            //                                                return $model->status;
                        },],
                    'houseserach.price',

                   'create_time',
                    ['attribute' => 'houseserach.status',
                        'value' => function ($model) {

                            return @$model->is_delete ? '房源已删除' : @Yii::$app->params['house_status'][$model->houseserach['status']];
                        }],


                ];

                // Renders a export dropdown menu
                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns
                ]);

                // You can choose to render your own GridView separately
                // You can choose to render your own GridView separately
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'pager' => [
                        'firstPageLabel' => '首页',
                        'lastPageLabel' => '尾页',
                    ],
                ]);
                ?>

            </div>
        </div>
    </div>
</div>
</div>
<style>
    tr, th {
        text-align: center;
    }

    .pagination {
        float: right;
    }

</style>
