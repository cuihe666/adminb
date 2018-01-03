<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '活动列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>

<script>
    function test(obj) {
        $.get("<?=Url::to(["activity/getprovince"])?>" + "&id=" + $(obj).val(), function (data) {
            $("#bank_province").html(data);
        });
        $("#bank_city").html('<option value="0">请选择城市</option>');
    }
    function test1(obj) {
        $.get("<?=Url::to(["activity/getcity"])?>" + "&id=" + $(obj).val(), function (data) {
            $("#bank_city").html(data);
        });
    }
</script>
<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">
                            <div class="search-item">
                                <?= Html::beginForm(['travel-activity/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 165px; float: left;margin-right: 10px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'stime',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请选择上传时间',
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
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'city_name', ['class' => 'form-control input', 'placeholder' => '按城市名搜索']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('number', $searchModel, 'account', ['class' => 'form-control input', 'placeholder' => '按帐号查找', 'onkeyup' => "value=value.replace(/[^1234567890-]+/g,'')"]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('number', $searchModel, 'id', ['class' => 'form-control input', 'placeholder' => '按ID查找']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '按标题']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'nature', ['class' => 'form-control input', 'placeholder' => '按资质名称']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'tag', $tag, ['class' => 'form-control', 'prompt' => '按标签']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'type', [0 => '线上', 1 => '线下'], ['class' => 'form-control', 'prompt' => '活动类型']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'status', Yii::$app->params['higo_status'], ['class' => 'form-control', 'prompt' => '按状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'identity', [0 => '公司', 1 => '个人'], ['class' => 'form-control', 'prompt' => '性质']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'user_auth', [0 => '未通过', 1 => '已通过'], ['class' => 'form-control', 'prompt' => '按资质状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"style="width: 110px; float: left;margin-right: 10px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                                        <?= Html::a("清空",$url = ['travel-activity/index'],$options = ['class' => 'btn btn-sm btn-primary']) ?>
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
                            'id',
                            ['attribute' => 'account',
                                'header' => '发布帐号',
                                'value' => function ($model) {
                                    //2017年6月23日16:05:48   付燕飞加判断。如果$model->uid不为空的时候再调用下面获取账号名称的方法。
                                    if ($model->uid) {
                                        return \backend\models\TravelPerson::getUser($model->uid)['mobile'] . '(' . \backend\models\TravelPerson::getUserCommon($model->uid)['nickname'] . ')';
                                    }

                                }],

                            ['attribute' => 'identity',
                                'header' => '性质',
                                'value' => function ($model) {
                                //2017年6月23日16:05:48   付燕飞加判断。如果$model->uid不为空的时候再调用下面获取账号名称的方法。
                                    if ($model->uid) {
                                        switch ($model->identity) {
                                            case 0;
                                                return "公司" . '(' . \backend\models\TravelCompany::getCompany($model->uid)['name'] . ')';
                                                break;
                                            case 1;
                                                return "个人" . '(' . \backend\models\TravelPerson::getPerson($model->uid)['name'] . ')';
                                                break;

                                            case 2;
                                                return "无";
                                                break;
                                        }
                                    }

                                }],

                            ['attribute' => 'create_time',
                                'header' => '上传时间',
                                'value' => function ($model) {

                                    return $model->create_time;
                                }],

                            ['attribute' => 'name',
                                'header' => '标题',
                                'value' => function ($model) {

                                    return $model->name;
                                }],
                            ['attribute' => 'city',
                                'header' => '城市',
                                'value' => function ($model) {

                                    return \backend\models\TravelActivity::getcity($model->city_code);
                                }],

                            ['attribute' => 'type',
                                'header' => '活动类型',
                                'value' => function ($model) {

                                    return $model->type == 0 ? '线上' : '线下';
                                }],

                            ['attribute' => 'tag',
                                'header' => '标签',
                                'value' => function ($model) {
                                    return \backend\models\TravelActivity::gettag($model->tag);
                                }],

                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '资质审核',
                                //2017年6月23日16:57:59     付燕飞 增加style样式
                                'template' => '<div class="dropdown profile-element group-btn-edit" style="height:34px; line-height: 34px;">
                                     {view}
                                </div> ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        //2017年6月23日16:05:48   付燕飞加判断。如果$model->uid不为空的时候再调用下面获取账号名称的方法。
                                        if ($model->uid) {
                                            switch (\backend\models\TravelActivity::getidentitystatus($model->uid)) {
                                                case 0;
                                                    return "<fond style='color: blue'>待审核</fond>";
                                                    break;
                                                case 1;
                                                    return "<fond style='color: black'>已通过</fond>";
                                                    break;
                                                case 2;
                                                    return "<fond style='color: red'>未通过</fond>";
                                                    break;
                                                //2017年6月23日16:58:13 付燕飞 增加 当状态=3的时候为待完善的状态
                                                case 3;
                                                    return "<fond style='color: #999;'>待完善</fond>";
                                                    break;

                                            }
                                        }
                                    },
                                ],
                            ],


                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {view}
                                </div> ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
//                                        $Idents = \backend\models\TravelActivity::getIdentUrl($model->uid);
                                        $Idents = \backend\service\UserIdentityService::getUserIdentityInfo($model->uid);
                                        if (@$Idents['auth'] == 1 && @$Idents['status'] == 0 && $model->status == 0) {
                                            return Html::a('审核', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-person/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 2 && @$Idents['status'] == 0 && $model->status == 0) {
                                            return Html::a('审核', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-company/view', 'id' => @$Idents['id']], ['class' => 'btn btn-info']);
                                        }


                                        //-------------------2017年6月23日16:45:12     付燕飞 增加 当企业信息或者个人信息资料未完善的时候  资质审核那显示资质待完善，不能点击
                                        if (@$Idents['type'] == 1 && @$Idents['status'] == 3 && $model->status == 0) {
                                            return Html::a('审核', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质待完善', ['travel-person/view', 'id' => $Idents['id']], ['class' => 'btn btn-default disabled']);
                                        }

                                        if (@$Idents['type'] == 2 && @$Idents['status'] == 3 && $model->status == 0) {
                                            return Html::a('审核', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质待完善', ['travel-company/view', 'id' => $Idents['id']], ['class' => 'btn btn-default disabled']);
                                        }
                                        //-------------------结束


                                        if (@$Idents['auth'] == 1 && @$Idents['status'] == 1 && $model->status == 0) {
                                            return Html::a('审核', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 2 && @$Idents['status'] == 1 && $model->status == 0) {
                                            return Html::a('审核', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 1 && @ $Idents['status'] == 2 && $model->status == 0) {
                                            return Html::a('审核', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 2 && @$Idents['status'] == 2 && $model->status == 0) {
                                            return Html::a('审核', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 1 && @$Idents['status'] == 2 && $model->status == 1) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 2 && @$Idents['status'] == 2 && $model->status == 1) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 1 && @$Idents['status'] == 2 && $model->status == 2) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 2 && @$Idents['status'] == 2 && $model->status == 2) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 1 && @$Idents['status'] == 2 && $model->status == 3) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 2 && @$Idents['status'] == 2 && $model->status == 3) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }


                                        if (@$Idents['auth'] == 1 && @$Idents['status'] == 1 && $model->status == 3) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 2 && @$Idents['status'] == 1 && $model->status == 3) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }


                                        if (@$Idents['auth'] == 1 && @ $Idents['status'] == 0 && $model->status == 1) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-person/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }
                                        if (@$Idents['auth'] == 1 && @$Idents['status'] == 0 && $model->status == 2) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-person/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }
                                        if (@$Idents['auth'] == 1 && $Idents['status'] == 0 && $model->status == 3) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-person/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }
                                        if (@$Idents['auth'] == 1 && $Idents['status'] == 0 && $model->status == 4) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-person/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 2 && $Idents['status'] == 0 && $model->status == 1) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-company/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 2 && $Idents['status'] == 0 && $model->status == 2) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-company/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 2 && $Idents['status'] == 0 && $model->status == 3) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-company/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents['auth'] == 2 && $Idents['status'] == 0 && $model->status == 4) {
                                            return Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-company/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }


                                        if (@$Idents['status'] == 1 && $model->status == 1) {
                                            return Html::a('下线', "javascript:drop($key);", ['class' => 'btn btn-danger', 'id' => $key]) . Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }


                                        if (@$Idents['status'] == 1 && $model->status == 2) {
                                            return Html::a('上线', "javascript:online($key);", ['class' => 'btn btn-danger', 'id' => $key]) . Html::a('查看', ['travel-activity/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }


                                    },
                                ],
                            ],


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
    <style>
        tr, th {
            text-align: center;
        }

        .pagination {
            float: right;
        }

    </style>

    <script>


        function drop($key) {
            layer.confirm('确认要下线吗', {icon: 3, title: '友情提示'}, function (index) {
                $.post("<?=Url::to(["travel-activity/drop"])?>", {
                    "PHPSESSID": "<?php echo session_id();?>",
                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                    data: {id: $key},
                }, function (data) {
                    if (data == 1) {
                        layer.alert('操作成功');
                        window.location.reload();


                    }


                });
            });
        }

        function online($key) {
            layer.confirm('确认要上线吗', {icon: 3, title: '友情提示'}, function (index) {
                $.post("<?=Url::to(["travel-activity/online"])?>", {
                    "PHPSESSID": "<?php echo session_id();?>",
                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                    data: {id: $key},
                }, function (data) {
                    if (data == 1) {
                        layer.alert('操作成功');
                        window.location.reload();


                    }


                });
            });
        }

    </script>
