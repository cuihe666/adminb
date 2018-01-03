<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '订单统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<?php if (Yii::$app->session->hasFlash('succ')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('succ')?>", {time: 0,})</script>
<?php } ?>
<style>
    .tit{
        height: 42px;
        border-bottom: 2px solid #1888F8;
        width: 100%;
        margin: 10px auto;
    }
    .tit a{
        display: inline-block;
        width: 120px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        background: #efefef;
        color: black;
    }
    .tit a:hover{
        cursor: pointer;
    }
    .sty{
        background: #1888F8!important;
        color: white!important;
    }
</style>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="tit">
                            <a href="data-count" style="margin-right: 30px;">数据统计</a>
                            <a href="order-count" class="sty">订单统计</a>
                        </div>

                        <div class="search-box clearfix">
                            <div class="search-item">
                                <?= Html::beginForm(['travel-talent-count/order-count'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 10px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'stime',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请选择时间',
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
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'identity',Yii::$app->params['impress_identity'], ['class' => 'form-control', 'prompt' => '按性质']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'mobile', ['class' => 'form-control input', 'placeholder' => '按账号','maxlength' => 50]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '按名称','maxlength' => 50]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'keywords', ['class' => 'form-control input', 'placeholder' => '按主页昵称/品牌名称','maxlength' => 50]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                                        <?= Html::a("清空",$url = ['travel-talent-count/order-count'],$options = ['class' => 'btn btn-sm btn-primary']) ?>
                                    </div>
                                </div>
                                <?= Html::endForm() ?>
                            </div>
                        </div>
                        <?php
                        use kartik\export\ExportMenu;
                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn',
                                'header' => '编号'],
                            ['attribute' => 'account',
                                'header' => '帐号',
                                'value' => function ($model) {
                                    if ($model->id) {
                                        return $model->mobile;
                                    }
                                }
                            ],
                            [   'header' => '名称',
                                'value' => function ($model) {
                                    $identity = \backend\models\TravelActivity::getidentity($model->id);
                                    if($model->name!='' && $identity=="个人性质")
                                        return $model->name;
                                    elseif($model->cname!="" && $identity=="公司性质")
                                        return $model->cname;
                                    else
                                        return "";
                                }
                            ],
                            [
                                'header' => '全部订单数量',
                                'value' => function ($model) use ($stime) {
                                    return \backend\models\TravelOrder::getTravelTalentOrderCount($model->id,$stime)['count'];
                                }
                            ],
                            [
                                'header' => '全部订单金额（元）',
                                'value' => function ($model) use ($stime) {
                                    return \backend\models\TravelOrder::getTravelTalentOrderCount($model->id,$stime)['sum_total'];
                                }
                            ],
                            [
                                'header' => '未支付订单数量',
                                'value' => function ($model) use ($stime) {
                                    return \backend\models\TravelOrder::getTravelTalentOrderCount($model->id,$stime,11)['count'];
                                }
                            ],
                            [
                                'header' => '未支付订单金额（元）',
                                'value' => function ($model) use ($stime) {
                                    return \backend\models\TravelOrder::getTravelTalentOrderCount($model->id,$stime,11)['sum_total'];
                                }
                            ],
                            [
                                'header' => '已支付订单数量',
                                'value' => function ($model) use ($stime) {
                                    return \backend\models\TravelOrder::getTravelTalentOrderCount($model->id,$stime,21)['count'];
                                }
                            ],
                            [
                                'header' => '已支付订单金额（元）',
                                'value' => function ($model) use ($stime) {
                                    return \backend\models\TravelOrder::getTravelTalentOrderCount($model->id,$stime,21)['sum_total'];
                                }
                            ],
                            /*[
                                'header' => '已退款订单数量',
                                'value' => function ($model) use ($stime) {
                                    return \backend\models\TravelOrder::getTravelTalentOrderCount($model->id,$stime,53)['count'];
                                }
                            ],
                            [
                                'header' => '已退款订单金额（元）',
                                'value' => function ($model) use ($stime) {
                                    return \backend\models\TravelOrder::getTravelTalentOrderCount($model->id,$stime,53)['sum_total'];
                                }
                            ],*/
                            [
                                'header' => '已完成订单数量',
                                'value' => function ($model) use ($stime) {
                                    return \backend\models\TravelOrder::getTravelTalentOrderCount($model->id,$stime,50)['count'];
                                }
                            ],
                            [
                                'header' => '已完成订单金额（元）',
                                'value' => function ($model) use ($stime) {
                                    return \backend\models\TravelOrder::getTravelTalentOrderCount($model->id,$stime,50)['sum_total'];
                                }
                            ],
                        ];
                        // Renders a export dropdown menu
                        echo ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns
                        ]);
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
</div>


