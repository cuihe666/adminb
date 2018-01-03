<?php

use yii\helpers\Html;

use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">

                            <div class="search-item">

                                <?= Html::beginForm(['comment/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                    </div>
                                </div>
                                <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                    <?= Html::activeDropDownList($searchModel, 'state', [0 => '未审核', 1 => '已审核'], ['class' => 'form-control', 'prompt' => '请选择状态']) ?>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 280px; float: left;margin-right: 18px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary', 'style' => 'width:140px;height:34px;']) ?>
                                    </div>
                                </div>


                                <?= Html::endForm() ?>
                            </div>
                        </div>
                    </div>
                </div>


                <?= GridView::widget(['dataProvider' => $dataProvider,
                    "options" => ["class" => "grid-view", "style" => "overflow:auto", "id" => "grid"],
                    'columns' => [

                        [
                            "class" => 'yii\grid\CheckboxColumn',
                            "name" => "id",

                        ],
                        ['attribute' => 'housedetails.title',
                            'value' => function ($model) {
                                return $model->housedetails['title'];
                            },],


                        [
                            'header' => '房东信息',
                            'value' => function ($model) {
                                return $model->houseusernickname['nickname'] . '/' . $model->houseusermoblie['mobile'];
                            },],


                        [
                            'header' => '用户信息',
                            'value' => function ($model) {
                                return $model->usercommon['nickname'] . '/' . $model->user['mobile'];
                            },],

                        [
                            'header' => '内容',
                            'value' => function ($model) {
                                return mb_substr($model->content, 0, 20) . '......';
                            },],
                        [
                            'header' => '评论时间',
                            'value' => function ($model) {
                                return $model->create_time;
                            },],


                    ],
                    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer'],
                    'summaryOptions' => ['class' => 'pagination'],
                    'pager' => [

                        'options' => ['class' => 'pagination', 'style' => 'visibility: visible;'],


                        'nextPageLabel' => '下页',

                        'prevPageLabel' => '上页',

                        'firstPageLabel' => '首页',

                        'lastPageLabel' => '末页'

                    ],


                ]);


                ?>
                <?php echo Html::a("批量审核", "javascript:void(0);", ["class" => "btn btn-primary check"]) ?>
                <?php echo Html::a("批量删除", "javascript:void(0);", ["class" => "btn btn-primary del"]) ?>
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
    $('.check').click(function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        if (keys.length == 0) {
            layer.alert("请先选择要删除的数据");
            return false;
        }
        layer.confirm('审核通过后，将在前台显示,是否继续？', {icon: 3, title: '友情提示'}, function (index) {
            $.post("<?=Url::to(["comment/changestatus"])?>", {
                    "PHPSESSID": "<?php echo session_id();?>",
                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                    data: keys,
                    dataType: "json",
                },
                function (data) {
                    if (data == 1) {
                        layer.alert("审核成功！");
                        location.reload();
                    }
                }
            )

        })
        ;

    })

    $('.del').click(function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        if (keys.length == 0) {
            layer.alert("请先选择要删除的数据");
            return false;
        }
        layer.confirm('删除后数据不可恢复，您确定吗？', {icon: 3, title: '友情提示'}, function (index) {
            $.post("<?=Url::to(["comment/del"])?>", {
                    "PHPSESSID": "<?php echo session_id();?>",
                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                    data: keys,
                    dataType: "json",
                },
                function (data) {
                    if (data == 1) {
                        layer.alert("删除成功！");
                        location.reload();
                    }
                }
            )

        })
        ;

    })
</script>
