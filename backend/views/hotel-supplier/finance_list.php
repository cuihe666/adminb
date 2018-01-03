<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/5/16
 * Time: 下午4:48
 */
$gridColumns = [
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => '订单ID',
        'template' => '{view}',
        'buttons' => [
            'view' => function($url,$model,$url){
                return Html::a($model->id,'/hotel-order/view?id='.$model->id);
            }
        ]
    ],
    'in_time',
    'out_time',

    [
        'label' => '入住人',
        'value' => function($model){
            $arr = \yii\helpers\ArrayHelper::getColumn($model->orderGuest,'guest_name');
            return implode('/',$arr);
        }
    ],
    [
        'label' => '手机号码',
        'value' => function($model){

            return $model->order_mobile;
        }
    ],

    [
        'label' => '售出房型',
        'value' => function($model){

            return $model->hotel_house_name;
        }
    ],

    [
        'label' => '来源酒店',
        'value' => function($model){
            $hotel = $model->hotel;
            if(is_null($hotel)){
                $name = '未识别';
            }else{
                $name =  $hotel->complete_name;
            }

            return  $name;
        }
    ],

    [
        'label' => '间数',
        'value' => function($model){
            $order = $model->orderItem;
            $arr = \yii\helpers\ArrayHelper::index($order,null,'datetime');

            //同一天内有几间房
            return count(current($arr));
        }
    ],
    [
        'label' => '晚数',
        'value' => function($model){
            $order = $model->orderItem;
            $arr = \yii\helpers\ArrayHelper::index($order,null,'datetime');
            //一共住了几天
            return count($arr);
        }
    ],
    [
        'label' => '总金额',
        'value' => function($model){
            return $model->pay_total;
        }
    ],

    [
        'label' => '佣金率',
        'value' => function($model){
            $arr = \yii\helpers\ArrayHelper::getColumn($model->orderItem,'scale');

            return implode('/',array_unique($arr));
        }
    ],
    [
        'label' => '佣金',
        'value' => function($model){
            return $model->tango_income;
        }
    ],
    [
        'label' => '底价(结算价)',
        'value' => function($model){
            return $model->hotel_income;
        }
    ],

    [
        'class' => 'yii\grid\ActionColumn',
        'header' => '操作',
        'template' => '{view}',
        'buttons' => [
            'view' => function($url,$model,$key){
                return Html::a('查看',"/hotel-order/view?id={$key}",['target'=>'_blank']);
            }
        ]
    ]
];
?>
<div class="row" style="margin: 10px 0px">
    <div class="search-box clearfix">
        <?= Html::beginForm(['/hotel-supplier/finance?id=' . $supplierModel->id . '&show_type=' . Yii::$app->request->get('show_type')], 'get', ['class' => 'form-inline']) ?>

        <div class="form-group" style="margin-right: 30px;width: 150px">
            <label for="inputEmail3">结算周期:</label>
            <input type="text" class="form-control" style="width: 60px;text-align: center"  disabled value="<?= Yii::$app->params['hotel_supplier_settle_type'][$supplierModel->settle_type] ?>">
        </div>

        <div class="form-group" style="margin-right: 30px">
            <?= Html::activeHiddenInput($searchModel,'search_type',['value' => '3']) ?>
            <label for="inputEmail3" >离店日期:</label>
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

        <div class="form-group" style="margin-right: 30px">
            <label for="inputEmail3">来源酒店:</label>
            <?= Html::activeDropDownList($searchModel, 'hotel_id', $supplierModel->hotelList(), ['class' => 'form-control','prompt' => '全部']) ?>
        </div>

        <div class="form-group" style="margin-right: 30px">
            <label for="inputEmail3">订单号:</label>
            <?= Html::activeInput('text', $searchModel, 'order_num', ['class' => 'form-control input', 'placeholder' => '请输入订单号']) ?>
        </div>

        <div class="form-group" style="margin-right: 30px">

            <?= Html::submitButton('提交',['class' => 'btn btn-primary']) ?>
        </div>
        <div class="form-group" style="margin-right: 30px">

            <?= Html::a('重置','/hotel-supplier/finance?id=' . $supplierModel->id . '&show_type=' . Yii::$app->request->get('show_type'),['class' => 'btn btn-primary']) ?>
        </div>

        <?= Html::endForm() ?>
    </div>
</div>
<div class="row" style="margin: 0px">
    <div class="col-md-3">
        <?=
//         Renders a export dropdown menu
         ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns
        ]);

        ?>
    </div>

    <div class="col-md-2">
        总卖价: <?= $countInfo['pay_total'] ?>
    </div>
    <div class="col-md-2">
        总佣金: <?= $countInfo['tango_income'] ?>
    </div>

    <div class="col-md-2">
        供应商结算总价: <?= $countInfo['hotel_income'] ?>
    </div>

    <div class="col-md-2">
        总间夜: <?= $countInfo['order_count'] ?>
    </div>
</div>






<?php

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
