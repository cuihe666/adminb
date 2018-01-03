<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\HotelOrderQuery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ibox-content" style="margin-bottom: 20px;">
    <div class="search-box clearfix" style="margin: -65px 0 0 20px;">
        <div class="search-item">
            <div class="search-item">


                <?= Html::beginForm(['hotel-order/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>


                <div class="search-item" style="width: 200px;margin-right: 5px;">

                    <?= Html::activeDropDownList($searchModel, 'search_type', Yii::$app->params['search_type'], ['class' => 'form-control']) ?>
                </div>

                <div class="search-item">
                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                        <?= \kartik\daterange\DateRangePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'start_end',
                            'convertFormat' => true,
                            'language' => 'zh-CN',
                            'options' => [
                                'placeholder' => '请输入起始时间',
                                'class' => 'form-control',
                                'readonly' => true,
                            ],
                            'pluginOptions' => [
                                'timePicker' => false,
                                'timePickerIncrement' => 30,
                                'locale' => [
                                    'format' => 'Y.m.d'
                                ]
                            ]
                        ]);

                        ?>
                    </div>
                </div>

                <div class="search-item">
                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                        <?= Html::activeInput('text', $searchModel, 'city_name', ['class' => 'form-control input', 'placeholder' => '按城市名称搜索']) ?>
                    </div>
                </div>

                <div class="search-item">
                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                        <?= Html::activeInput('text', $searchModel, 'order_mobile', ['class' => 'form-control input', 'placeholder' => '按入住人手机号搜索']) ?>
                    </div>
                </div>


                <div class="search-item">
                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                        <?= Html::activeInput('text', $searchModel, 'uid_phone', ['class' => 'form-control input', 'placeholder' => '按下单人手机号搜索']) ?>
                    </div>
                </div>

                <div class="search-item">
                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                        <?= Html::activeInput('text', $searchModel, 'id', ['class' => 'form-control input', 'placeholder' => ' 按订单ID搜索']) ?>
                    </div>
                </div>

                <div class="search-item">
                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                        <?= Html::activeDropDownList($searchModel, 'hotel_type',  Yii::$app->params['hotel_type'] , ['class' => 'form-control', 'prompt' => '请选择酒店类型']) ?>
                    </div>
                </div>

                <div class="search-item">
                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                        <?= Html::activeDropDownList($searchModel, 'pay_platform',  Yii::$app->params['pay_type'] , ['class' => 'form-control', 'prompt' => '支付方式']) ?>
                    </div>
                </div>

                <div class="search-item">
                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                        <?= Html::activeDropDownList($searchModel, 'pay_status',  Yii::$app->params['pay_status'] , ['class' => 'form-control', 'prompt' => ' 支付状态']) ?>
                    </div>
                </div>


                <div class="search-item">
                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                        <?= Html::activeDropDownList($searchModel, 'status',  Yii::$app->params['hotel_order_status'] , ['class' => 'form-control', 'prompt' => '订单状态']) ?>
                    </div>
                </div>


                <div class="search-item">
                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                        <?= Html::activeInput('text', $searchModel, 'order_num', ['class' => 'form-control input', 'placeholder' => '按订单号搜索']) ?>
                    </div>
                </div>

                <div class="search-item">
                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                    </div>
                </div>

                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>