<?php
/**
 * Created by PhpStorm.
 * User: ys
 * Date: 2017/7/25
 */
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = '酒店结算';
\backend\assets\ScrollAsset::register($this);

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn', 'header' =>'序号'],
    'settle_id',
    [
        'label' => '账单周期',
        'value' => function($model){
            return (date('Y-m-d', strtotime($model['start_time'])).'至'.date('Y-m-d', strtotime($model['end_time'])));
        }
    ],
    [
        'label' => '结算周期',
        'value' => function($model){
            return Yii::$app->params['hotel_supplier_settle_type'][$model['supplier']['settle_type']];
        }
    ],
    [
        'label' => '订单数',
        'value' => function($model){
            return count($model['detail']);
        }
    ],
    'total',
    [
        'label' => '状态',
        'value' => function($model){
            return Yii::$app->params['hotel_settle_status'][$model['status']];
        }
    ],
    [
        'label' => '来源酒店',
        'value' => function($model){
            return \backend\controllers\HotelSettlementController::HotelName($model['hotel_id']);
        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => '账号信息',
        'template' => '<div class="dropdown profile-element group-btn-edit">{account_info}</div> ',
        'buttons' => [
            'account_info' => function ($url, $model, $key) {
                return Html::a('查看', "#", ['class' => 'delnode btn btn-primary btn-sm look_settle_account', 'style' => 'color:white', 'MyAttr'=> $model['id']]);
            },
        ]
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => '详情',
        'template' => '<div class="dropdown profile-element group-btn-edit">{view}</div> ',
        'buttons' => [
            'view' => function ($url, $model, $key) {
                return Html::a('查看账单', "#", ['class' => 'delnode btn btn-primary btn-sm look_account', 'style' => 'color:white', 'MyAttr'=> $model['id']]);
            },
        ]
    ],
];


\backend\assets\HotelAsset::register($this);
?>
<?= \backend\widgets\ElementAlertWidget::widget() ?>
<script src="<?= Yii::$app->request->baseUrl ?>/common/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl?>/layer/layer.js"></script>
<section class="content" >
    <div class="rummery_top">
        <?= \backend\widgets\HotelSupplierListWidget::widget([
            'current_url' => Yii::$app->controller->action->id,
            'body' =>Yii::$app->params['hotel_supplier_nav'],
            'query' => Yii::$app->getRequest()->queryString,
        ]) ?>
    </div>


    <div class="hotel-supplier-index">

        <div class="wrapper-content animated" style="padding-bottom: 10px; padding-top: 10px;">
            <div class="row">
                <?= Html::beginForm(['hotel-supplier/settlement'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'hotel_form']) ?>
                <input type="hidden" name="id" id="supplier_id" value="<?= isset($supplier_id)?$supplier_id:''?>">
                <div class="col-sm-12">
                    <?php if (!empty($hotel_select)) :?>
                    <div class="search-item">
                        <div class="input-group" style="float: left;">
                            <?= Html::activeDropDownList($searchModel, 'hotel_id', $hotel_select, ['class' => 'form-control', 'prompt' => '请选择酒店', 'id' => 'hotel_id']) ?>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
                <div class="col-sm-12">
                    <span>总计：<em>￥<?= empty($top_total)?0:$top_total?>.00</em></span>
                    <span style="margin-left: 20px;">已打款：<em>￥<?= empty($top_settle)?0:$top_settle?>.00</em></span>
                    <span style="margin-left: 20px;">未打款：<em>￥<?= empty($top_total - $top_settle)?0:($top_total - $top_settle)?>.00</em></span>
                </div>
            </div>
            <script>
                $("#hotel_id").change(function () {
                    $("#hotel_form").submit();
                });
            </script>
        </div>
        <div class="wrapper-content animated" style="padding-bottom: 10px; padding-top: 10px;">
            <div class="row">
                <div class="col-sm-12">
                    <div class="search-item">
                        <div class="search-item">
                            <div class="input-group" style="width:165px;float:left;">
                                <?php
                                echo \kartik\daterange\DateRangePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'start_time',
                                    'convertFormat' => true,
                                    'language' => 'zh-CN',
                                    'options' => [
                                        'placeholder' => '请输入初始时间',
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
                            <div class="search-item" style="display:inline-block;margin-left:20px;">
                                <div class="input-group" style="float: left;">
                                    <?= Html::activeDropDownList($searchModel, 'status', Yii::$app->params['hotel_settle_status'], ['class' => 'form-control', 'prompt' => '状态']) ?>
                                </div>
                            </div>
                            <div class="search-item" style="display:inline-block;margin-left:20px;">
                                <div class="input-group">
                                    <?= Html::activeInput('text', $searchModel, 'order_num', ['class' => 'form-control input', 'placeholder' => '请输入订单号']) ?>
                                </div>
                            </div>
                            <div class="search-item" style="display:inline-block;margin-left:20px;margin-top:3px;">
                                <div class="input-group" style="width:140px;">
                                    <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
        <div class="wrapper-content animated" style="padding-bottom: 5px; padding-top: 5px;">
            <div class="row">
                <div class="col-sm-12">
                    <span>总计：<em>￥<?= empty($hotel_price['total'])?0:$hotel_price['total']?>.00</em></span>
                    <span style="margin-left: 20px;">已打款：<em>￥<?= empty($hotel_price['settle'])?0:$hotel_price['settle']?>.00</em></span>
                    <span style="margin-left: 20px;">未打款：<em>￥<?= empty($hotel_price['total'] - $hotel_price['settle'])?0:($hotel_price['total'] - $hotel_price['settle'])?>.00</em></span>
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
<!-- 编辑用户 -->
<div class="modal fade" id="account_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">账户信息</h4>
            </div>
            <div class="modal-body">

                <div class="form-group" style="margin-left: 30px;">
                    <table class="table table-bordered" id="settle_account_content_detail">

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color: #1888f8;color:white;">确定</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".look_settle_account").click(function () {
        var id = $(this).attr("MyAttr");
        $.post("<?= \yii\helpers\Url::to(['hotel-supplier/look-account-data'])?>", {
            "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
            data:{id:id},
            jsonType:'json'
        }, function (data) {
            var info = jQuery.parseJSON(data);
            console.log(info);
            if (info.code == 0) {
                $("#settle_account_content_detail").html("");
                $("#settle_account_content_detail").append('<tbody>' +
                    '<tr>' +
                    '<td style="width:120px;text-align: right">户名：</td>' +
                    '<td>'+ info.data['account_name'] +'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="text-align: right">开户银行：</td>' +
                    '<td>'+ info.data['bank_detail'] +'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="text-align: right">银行账号：</td>' +
                    '<td>'+ info.data['account_number'] +'</td> ' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="text-align: right">账户类型：</td>' +
                    '<td>'+ info.data['type'] +'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="text-align: right">支付宝账号：</td>' +
                    '<td>'+ info.data['alipay_number'] +'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="text-align: right">财务联系人：</td>' +
                    '<td>'+ info.data['user_name'] +'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="text-align: right">联系人邮箱：</td>' +
                    '<td>'+ info.data['email'] +'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="text-align: right">联系人手机：</td>' +
                    '<td>'+ info.data['mobile'] +'</td>' +
                    '</tr> ' +
                    '</tbody>');
                $("#account_model").modal('show');
            } else {
                layer.alert(info.data, {
                    icon: 2,
                    skin: 'layer-ext-moon'
                });
            }
        });
    });
    $(".look_account").click(function () {
        var id = $(this).attr("MyAttr");
        location.href="<?= \yii\helpers\Url::to(['hotel-settle-detail/index'])?>?settle_id="+id;
    });
</script>
