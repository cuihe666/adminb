<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '代理商结算列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/yulan/js/jquery-1.9.1.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <?= Html::beginForm(['agent-settlement/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                        <div class="search-box clearfix" style="margin: -65px 0 0 20px;">
                            <div class="search-item" style="width: 200px;margin-right: 5px;">

                                <?= Html::activeDropDownList($searchModel, 'status', Yii::$app->params['settle_status'], ['class' => 'form-control', 'prompt' => '打款状态']) ?>
                            </div>
                            <div class="search-item">
                                <div class="input-group" style="width: 280px; float: left;margin-right: 18px;">

                                    <!--                                    <button type="button" class="btn btn-sm btn-primary"> 搜索</button>-->
                                    <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                </div>
                            </div>
                            <?= Html::endForm() ?>
                        </div>
                    </div>


                    <?php

                    $gridColumns = [

                        'settle_id',
                        'bank.company_name',
                        'bank.name',
//                        'bank.account_number',
                        ['attribute' => '打款账号',
                            'value' => function ($model) {

                                return ' ' . $model->bank['account_number'];
                            },],

                        ['attribute' => 'agent.code',
                            'value' => function ($model) {
                                return \backend\service\CommonService::get_city_name($model->agent['code']);
                            },],
                        ['attribute' => 'create_time',
                            'value' => function ($model) {
                                return date("Y-m-d", $model->create_time);
                            },],
                        ['attribute' => 'pay_time',
                            'value' => function ($model) {
                                return $model->pay_time ? date("Y-m-d", $model->pay_time) : '暂无';
                            },],
                        ['attribute' => 'status',
                            'value' => function ($model) {
                                return Yii::$app->params['settle_status'][$model->status];
                            },],
                        'serial_number',
                        'fail_cause',
                        'total',
                        'tangguo_total',
                        'landlady_total',
                        'order_total',
                        'coupon_total',
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => '操作',
                            'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {view}
                                    {transfer}
                                </div> ',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('查看', "$url");
                                },
                                'transfer' => function ($url, $model, $key) {
                                    if ($model->bank['account_number'] && $model->status != 1) {
                                        return Html::a('打款到支付宝', "javascript:pay($key);");
                                    }
                                },
                            ],],
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
<script>
    function pay(id) {
        layer.confirm('确认要执行此操作吗？', {icon: 3, title: '友情提示'}, function (index) {
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['transfer']) ?>",
                data: {id: id},
                success: function (data) {
                    data = $.parseJSON(data);
                    if (data.code == 1) {
                        layer.alert('打款成功', {icon: 1});
                    } else {
                        layer.alert(data.msg, {icon: 2});
                    }
                    layer.close(index);
                    location.reload();
                }
            })
        });
    }
</script>
