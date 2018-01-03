<?php

use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '变更单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">

                            <div class="search-item">

                                <?= Html::beginForm(['shop-refund/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>


                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'refund_num', ['class' => 'form-control input', 'placeholder' => '变更单号']) ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                        <?php


                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'create_time',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '创建时间',
                                                'class' => 'form-control',
                                                'readonly' => true,
                                            ],
                                            'pluginOptions' => [
                                                'timePicker' => false,
                                                'timePickerIncrement' => 30,
                                                'locale' => [
                                                    'format' => 'Y-m-d'
                                                ]
                                            ]
                                        ]);

                                        ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'admin_account', ['class' => 'form-control input', 'placeholder' => '卖家帐号']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'order_num', ['class' => 'form-control input', 'placeholder' => '订单号']) ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'purchase_num', ['class' => 'form-control input', 'placeholder' => '采购单号']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                        <?php


                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'update_time',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '审核时间',
                                                'class' => 'form-control',
                                                'readonly' => true,
                                            ],
                                            'pluginOptions' => [
                                                'timePicker' => false,
                                                'timePickerIncrement' => 30,
                                                'locale' => [
                                                    'format' => 'Y-m-d'
                                                ]
                                            ]
                                        ]);

                                        ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 280px; float: left;margin-right: 18px;">

                                        <!--                                    <button type="button" class="btn btn-sm btn-primary"> 搜索</button>-->
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                    </div>
                                </div>


                                <?= Html::endForm() ?>
                            </div>
                        </div>
                    </div>
                </div>


                <?php

                $gridColumns = [
                    'refund_num',
                    'order.order_num',
                    'purchase.purchase_num',
                    ['header' => '变更单状态',
                        'value' => function ($model) {

                            return Yii::$app->params['shop']['refund_status'][$model->status];


                        }],

                    ['header' => '创建时间',
                        'value' => function ($model) {

                            return date("Y-m-d H:i:s", $model->create_time);


                        }],

                    ['header' => '审核时间',
                        'value' => function ($model) {

                            return date("Y-m-d H:i:s", $model->update_time);


                        }],

                    ['class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {view}
                                </div> ',
                        'buttons' => ['view' => function ($url, $model, $key) {


                                return Html::a('查看', ['view', 'id' => $key]);

                        },],],];

                echo GridView::widget(['dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'pager' => ['firstPageLabel' => '首页',
                        'lastPageLabel' => '尾页',],]);
                ?>

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

<script>


    function drop($key) {
        layer.confirm('确认要下线吗', {icon: 3, title: '友情提示'}, function (index) {
            $.post("<?=Url::to(["travel-impress/drop"])?>", {
                "PHPSESSID": "<?php echo session_id();?>",
                "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                data: {id: $key},
            }, function (data) {
                if (data == 1) {
                    layer.alert('操作成功');
                    window.location.reload();


                }


            });
        });
    }

    function online($key) {
        layer.confirm('确认要上线吗', {icon: 3, title: '友情提示'}, function (index) {
            $.post("<?=Url::to(["travel-impress/online"])?>", {
                "PHPSESSID": "<?php echo session_id();?>",
                "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                data: {id: $key},
            }, function (data) {
                if (data == 1) {
                    layer.alert('操作成功');
                    window.location.reload();


                }


            });
        });
    }

</script>

