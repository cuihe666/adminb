<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '城市列表页';
$this->params['breadcrumbs'][] = $this->title;

?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/dist/js/app.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
<style>
    .search-box .search-item {
        float: left;
        margin: 10px 15px 10px 0;
    }
    .btn-group, .btn-group-vertical {
        margin-top: 10px;
    }

    .btn-primary {
        margin-right: 0;
    }

    #top_select ul li {
        float: left;
        margin-left: 30px;
        height: 40px;
        width: 156px;
    }

    #top_select ul {
        margin-left: -25px;
    }

    .top_select {
        width: 167px;
        height: 38px;
        line-height: 25px;
        font-size: 18px;
        border: solid 1px white;
    }
</style>
<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <div class="search-item" id="top_select">
                    <ul>
                        <li>
                            <a href="#" class='btn btn-sm btn-primary top_select sort'><?= $add_name?></a>
                        </li>
                    </ul>
                </div>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix" style="margin: -65px 0 0 20px;">
                            <div class="search-item">
                                <?= Html::beginForm('', 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '请输入国家/省份/城市/区域名']) ?>
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
                        <?php
                        use kartik\export\ExportMenu;

                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
                            [//区域名
                                'attribute' => $city_name,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->name;
                                },
                            ],
                            //状态操作
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div style="text-align: left; width: 40px;">
                            &nbsp;&nbsp;{tourism}
                            &nbsp;&nbsp;{stay}
                            <li class="fa fa-fw fa-building-o">&nbsp;&nbsp;&nbsp;{view}</li>
                          </div> ',
                                'buttons' => [
                                    'tourism' => function ($url, $model, $key) {
                                        if ($model->level != 0) {
                                            if ($model->display == 1) {//显示
                                                return '<input type="checkbox" name="' . $model->code . '" class="tour_click" checked=checked>&nbsp;旅游';
                                            } else {//不显示
                                                return '<input type="checkbox" name="' . $model->code . '" class="tour_click">&nbsp;旅游';
                                            }
                                        }
                                    },
                                    'stay' => function ($url, $model, $key) {
                                        if ($model->level != 0) {
                                            if ($model->is_visiable == 1) {//显示
                                                return '<input type="checkbox" name="' . $model->code . '" class="stay_click" checked=checked>&nbsp;民宿';
                                            } else {//不显示
                                                return '<input type="checkbox" name="' . $model->code . '" class="stay_click">&nbsp;民宿';
                                            }
                                        }
                                    },
                                    'view' => function ($url, $model, $key) {
                                        if ($model->level < 3) {
                                            return Html::a('查看详情', "$url", ['class' => '']);
                                        } else {
                                            return '';
                                        }
                                    },
                                ],
                            ],

                        ];
                        echo ExportMenu::widget([
                            'dataProvider' => $dataProvider
                            , 'columns' => $gridColumns
                        ]);
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'pager' => [
                                'firstPageLabel' => '首页',
                                'lastPageLabel' => '尾页',
                                'prevPageLabel' => '上一页',
                                'nextPageLabel' => '下一页',
                            ],
                        ]);
                        ?>
                    </div>
                    <script>
                        $(function () {
                            //旅游显示操作
                            $(".tour_click").click(function () {
                                var code = $(this).attr("name");
                                var display = '';
                                if ($(this).is(':checked')) {//选中--显示
                                    display = 1;
                                } else {//取消--隐藏
                                    display = 0;
                                }
                                $.post("<?= Url::to(['city-list/show_hidden'])?>", {
                                    "PHPSESSID": "<?php echo session_id();?>",
                                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                                    dataType: 'json',
                                    data: {"code": code, "display": display, "type": 'tour'}
                                }, function (data) {
//                                    var info = jQuery.parseJSON(data);
//                                    console.log(info);
                                    if (data == 1) {
                                        layer.alert('修改成功');
                                    } else {
                                        layer.alert('修改成功');
                                    }
                                });
                            });
                            //住宿显示操作
                            $(".stay_click").click(function () {
                                var code = $(this).attr("name");
                                var display = '';
                                if ($(this).is(':checked')) {//选中--显示
                                    display = 1;
                                } else {//取消--隐藏
                                    display = 0;
                                }
                                $.post("<?= Url::to(['city-list/show_hidden'])?>", {
                                    "PHPSESSID": "<?php echo session_id();?>",
                                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                                    data: {"code": code, "display": display, "type": 'stay'}
                                }, function (data) {
                                    if (data == 1) {
                                        layer.alert('修改成功');
                                    } else {
                                        layer.alert('修改成功');
                                    }
                                });
                            });
                        })
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sort" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">输入地区名称</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="code_note" value="<?= $code?>">
                    <input type="hidden" id="level_note" value="<?= $level_note?>">
                    父级地区名称：<input type="text" class="form-control" id="" disabled="true" value="<?= $name;?>"><br/><br/>
                    添加地区名称：<input type="text" class="form-control" maxlength="20" id="area_name" ><span style="color: red;margin-left: 10px;">*</span><br/><br/>
                    地区所在时区：<select name="" id="time_area" class="form-control">
                        <option value="GMT+0">零时区</option>
                        <option value="GMT+1">东一区</option>
                        <option value="GMT+2">东二区</option>
                        <option value="GMT+3">东三区</option>
                        <option value="GMT+4">东四区</option>
                        <option value="GMT+5">东五区</option>
                        <option value="GMT+6">东六区</option>
                        <option value="GMT+7">东七区</option>
                        <option value="GMT+8" selected="selected">东八区</option>
                        <option value="GMT+9">东九区</option>
                        <option value="GMT+10">东十区</option>
                        <option value="GMT+11">东十一区</option>
                        <option value="GMT+12">东十二区</option>
                        <option value="GMT-1">西一区</option>
                        <option value="GMT-2">西二区</option>
                        <option value="GMT-3">西三区</option>
                        <option value="GMT-4">西四区</option>
                        <option value="GMT-5">西五区</option>
                        <option value="GMT-6">西六区</option>
                        <option value="GMT-7">西七区</option>
                        <option value="GMT-8">西八区</option>
                        <option value="GMT-9">西九区</option>
                        <option value="GMT-10">西十区</option>
                        <option value="GMT-11">西十一区</option>
                        <option value="GMT-12">西十二区</option>
                    </select><span style="color: red;margin-left: 10px;">*</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary area_add">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.sort').click(function () {
        $('#sort').modal();
    });
    $(".area_add").click(function () {
        $(this).attr("disabled","disabled");
        var code = $("#code_note").val();
        var level_note = $("#level_note").val();
        var area_name = $("#area_name").val();
        var time_area = $("#time_area").val();
        if (area_name.length == 0) {
            layer.alert('添加地区名不能为空！');
            return false;
        }
        $.post("<?= Url::to(['city-list/area_add'])?>", {
            "PHPSESSID": "<?php echo session_id();?>",
            "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
            dataType: 'json',
            data: {"code": code, "level_note": level_note, "area_name": area_name, "time_area": time_area}
        }, function (data) {
            var info = jQuery.parseJSON(data);
            if (info == 'success') {
                location.reload();
            } else {
                layer.alert(info);
            }
        });
    });
</script>

