<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\HotelSupplierQuery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hotel-supplier-search">

    <?= Html::beginForm(['hotel-supplier/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'serachForm']) ?>
    <div class="ibox">
        <div class="ibox-content" style="margin-bottom: 20px;">
            <div class="search-box clearfix">

                <div class="search-item">

                    <div class="search-item" style="width: 200px;margin-right: 5px;">
                        <div class="input-group" style="width: 150px; float: left;margin-right: 18px;">
                            <?= Html::activeDropDownList($searchModel, 'status', Yii::$app->params['hotel_supplier_status'], ['class' => 'form-control' ,'prompt' => '全部供应商状态']) ?>
                        </div>
                    </div>
                    <div class="search-item">
                        <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                            <?= \kartik\daterange\DateRangePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'start_time',
                                'convertFormat' => true,
                                'language' => 'zh-CN',
                                'options' => [
                                    'placeholder' => '请选择有效期',
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
                            ]);$searchModel
                            ?>
                        </div>
                        <?= Html::activeHiddenInput($searchModel,'city',[ 'v-model' => 'city_value']) ?>
                    </div>
                    <div class="search-item">
                        <div class="input-group" style="width: 150px; float: left;margin-right: 18px;">
                            <?= Html::activeDropDownList($searchModel, 'type',  Yii::$app->params['hotel_supplier_type'] , ['class' => 'form-control', 'prompt' => '全部供应商类型']) ?>
                        </div>
                    </div>
                    <div class="search-item">
                        <div class="input-group" style="width: 150px; float: left;margin-right: 18px;">
                            <el-select
                                v-model="city_value"
                                filterable
                                remote
                                placeholder="<?= \backend\controllers\HotelSupplierController::getCityName($searchModel->city) ?>"
                                :remote-method="remoteMethod"
                                :loading="loading">
                                <el-option
                                    v-for="item in options"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="search-item">
                        <div class="input-group" style="width: 150px; float: left;margin-right: 18px;">
                            <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '供应商名称/ID']) ?>
                        </div>
                    </div>

                    <div class="search-item">
                        <div class="input-group" style="width: 150px; float: left;margin-right: 18px;">
                            <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary','style'=>'line-height: 34px;margin-right: 10px;']) ?>
                            <?= Html::a('重置','index' ,['class' => 'btn btn-sm btn-info', 'style'=>'    height: 34px;line-height: 34px;padding: 0px 15px;']) ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?= Html::endForm() ?>
</div>
