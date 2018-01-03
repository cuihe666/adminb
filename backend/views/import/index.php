<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '旅游城市统计';
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
                        </div>
<!--
                        <div class="search-box clearfix">
                            <div class="search-item">
                                <?/*= Html::beginForm(['import/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) */?>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?/*= Html::activeDropDownList($searchModel, 'identity',Yii::$app->params['impress_identity'], ['class' => 'form-control', 'prompt' => '按性质']) */?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?/*= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) */?>&nbsp;
                                        <?/*= Html::a("清空",$url = ['travel-talent-count/order-count'],$options = ['class' => 'btn btn-sm btn-primary']) */?>
                                    </div>
                                </div>
                                <?/*= Html::endForm() */?>
                            </div>
                        </div>
                        -->
                        <?php
                        use kartik\export\ExportMenu;
                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn',
                                'header' => '编号'],
                            'code',

                            ['attribute' => 'account',
                                'header' => '城市名称',
                                'value' => function ($model) {
                                    return $model->name;
                                }
                            ],
                            [
                                'header' => '是否显示',
                                'value' => function ($model) {
                                    if($model->display==1)
                                        return "显示";
                                    if($model->display==0)
                                        return "不显示";

                                }
                            ],
                            [
                                'header' => '当地活动总数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getActivityCount($model->code,9);
                                }
                            ],
                            /*[
                                'header' => '当地活动草稿数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getActivityCount($model->code,4);
                                }
                            ],
                            [
                                'header' => '当地活动待审核数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getActivityCount($model->code,0);
                                }
                            ],
                            [
                                'header' => '当地活动审核未通过数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getActivityCount($model->code,3);
                                }
                            ],*/
                            [
                                'header' => '当地活动上线数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getActivityCount($model->code,1);
                                }
                            ],
                            [
                                'header' => '当地活动下线数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getActivityCount($model->code,2);
                                }
                            ],
                            [
                                'header' => '主题线路总数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getHigoCount($model->code,9);
                                }
                            ],
                            /*[
                                'header' => '主题线路草稿数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getHigoCount($model->code,4);
                                }
                            ],
                            [
                                'header' => '主题线路待审核数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getHigoCount($model->code,0);
                                }
                            ],
                            [
                                'header' => '主题线路审核未通过数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getHigoCount($model->code,3);
                                }
                            ],*/
                            [
                                'header' => '主题线路上线数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getHigoCount($model->code,1);
                                }
                            ],
                            [
                                'header' => '主题线路下线数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getHigoCount($model->code,2);
                                }
                            ],
                            [
                                'header' => '印象总数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getImpressCount($model->code,9);
                                }
                            ],
                            /*[
                                'header' => '印象草稿数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getImpressCount($model->code,4);
                                }
                            ],
                            [
                                'header' => '印象待审核数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getImpressCount($model->code,0);
                                }
                            ],
                            [
                                'header' => '印象审核未通过数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getImpressCount($model->code,3);
                                }
                            ],*/
                            [
                                'header' => '印象上线数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getImpressCount($model->code,1);
                                }
                            ],
                            [
                                'header' => '印象下线数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getImpressCount($model->code,2);
                                }
                            ],
                            [
                                'header' => '游记总数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getNoteCount($model->code,9);
                                }
                            ],
                            /*[
                                'header' => '游记草稿数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getNoteCount($model->code,4);
                                }
                            ],
                            [
                                'header' => '游记待审核总数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getNoteCount($model->code,0);
                                }
                            ],
                            [
                                'header' => '游记未通过数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getNoteCount($model->code,3);
                                }
                            ],*/
                            [
                                'header' => '游记上线数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getNoteCount($model->code,1);
                                }
                            ],
                            [
                                'header' => '游记下线数',
                                'value' => function ($model){
                                    return \backend\models\DtCitySeas::getNoteCount($model->code,2);
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


