<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '中奖信息管理';
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
                            <a href="index" class="sty" style="margin-right: 30px;">中奖明细</a>
                            <a href="info">中奖概述</a>
                        </div>
                        <div class="search-box clearfix">
                            <div class="search-item">
                                <?= Html::beginForm(['activity-turntable/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 10px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'stime',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请选择活动时间',
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
                                    <div class="input-group" style="width: 240px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'activity_turntable_id',$awardArr, ['class' => 'form-control', 'prompt' => '全部']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                                        <?= Html::a("清空",$url = ['activity-turntable/index'],$options = ['class' => 'btn btn-sm btn-primary']) ?>
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
                            [
                                'attribute' => 'uid',
                                'value' => function ($model) {
                                    return $model->uid;
                                }
                            ],
                            [
                                'header' => '手机号',
                                'attribute' => 'mobile',
                                'value' => function ($model) {
                                    return $model->mobile;
                                }
                            ],
                            [
                                'header' => '奖品',
                                'attribute' => 'award_name',
                                'value' => function ($model) {
                                    return $model->award_name;
                                }
                            ],
                            [
                                'header' => '联系人',
                                'attribute' => 'contact_info',
                                'value' => function ($model) {
                                    return $model->contact_info;
                                }
                            ],
                            ['attribute' => 'create_time',
                                'value' => function ($model) {
                                    return $model->create_time;
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


