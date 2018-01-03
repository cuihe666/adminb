<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '当地向导';
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
                                <?= Html::beginForm(['travel-guide/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 10px;">
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
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'city_name', ['class' => 'form-control input', 'placeholder' => '按服务城市']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('number', $searchModel, 'account', ['class' => 'form-control input', 'placeholder' => '按帐号', 'onkeyup' => "value=value.replace(/[^1234567890-]+/g,'')"]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'keywords', ['class' => 'form-control input', 'placeholder' => '按ID/标题']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'nature', ['class' => 'form-control input', 'placeholder' => '资质名称']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'identity',Yii::$app->params['impress_identity'], ['class' => 'form-control', 'prompt' => '按性质']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'user_auth', [0 => '未通过', 1 => '已通过'], ['class' => 'form-control', 'prompt' => '按资质审核']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'status', Yii::$app->params['higo_status'], ['class' => 'form-control', 'prompt' => '按状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                                        <?= Html::a("清空",$url = ['travel-guide/index'],$options = ['class' => 'btn btn-sm btn-primary']) ?>
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
                                    if ($model->uid) {
                                        //return \backend\models\TravelPerson::getUser($model->uid)['mobile'] . '(' . \backend\models\TravelPerson::getUserCommon($model->uid)['nickname'] . ')';
                                        return $model->userMobile->mobile;
                                    }
                                }
                            ],
                            ['attribute' => 'identity',
                                'header' => '性质',
                                'value' => function ($model) {
                                    return Yii::$app->params['impress_identity'][$model->identity];
                                }
                            ],
                            ['attribute' => 'create_time',
                                'header' => '资质名称',
                                'value' => function ($model) {
                                    return $model->aptitude;
                                }
                            ],
                            ['attribute' => 'create_time',
                                'header' => '昵称',
                                'value' => function ($model) {
                                    return $model->nickname;
                                }
                            ],
                            ['attribute' => 'create_time',
                                'header' => '上传时间',
                                'value' => function ($model) {
                                    return $model->create_time;
                                }
                            ],
                            ['attribute' => 'title',
                                'header' => '标题',
                                'value' => function ($model) {
                                    return $model->title;
                                }
                            ],
                            ['attribute' => 'city',
                                'header' => '服务城市',
                                'value' => function ($model) {
                                    return $model->cityName->name;
                                }
                            ],
                            ['attribute' => 'tag',
                                'header' => '标签',
                                'value' => function ($model) {
                                    return \backend\models\TravelActivity::gettag($model->tag);
                                }
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '资质审核',
                                //2017年6月23日16:57:59     付燕飞 增加style样式
                                'template' => '<div class="dropdown profile-element group-btn-edit" style="height:34px; line-height: 34px;">
                                     {view}
                                </div> ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
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
                                            case 3;
                                                return "<fond style='color: #999;'>待完善</fond>";
                                                break;
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
                                        $Idents = \backend\models\TravelActivity::getIdentUrl($model->uid);
                                        if (@$Idents[type] == 1 && @$Idents['status'] == 0 && $model->status == 0) {
                                            return Html::a('审核', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-person/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 2 && @$Idents['status'] == 0 && $model->status == 0) {
                                            return Html::a('审核', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-company/view', 'id' => @$Idents['id']], ['class' => 'btn btn-info']);
                                        }


                                        //-------------------2017年6月23日16:45:12     付燕飞 增加 当企业信息或者个人信息资料未完善的时候  资质审核那显示资质待完善，不能点击
                                        if (@$Idents['status'] == 3) {
                                            return  Html::a('资质待完善', ['travel-person/view', 'id' => $Idents['id']], ['class' => 'btn btn-default disabled']);
                                        }
                                        //-------------------结束


                                        if (@$Idents[type] == 1 && @$Idents['status'] == 1 && $model->status == 0) {
                                            return Html::a('审核', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 2 && @$Idents['status'] == 1 && $model->status == 0) {
                                            return Html::a('审核', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 1 && @ $Idents['status'] == 2 && $model->status == 0) {
                                            return Html::a('审核', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 2 && @$Idents['status'] == 2 && $model->status == 0) {
                                            return Html::a('审核', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 1 && @$Idents['status'] == 2 && $model->status == 1) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 2 && @$Idents['status'] == 2 && $model->status == 1) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 1 && @$Idents['status'] == 2 && $model->status == 2) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 2 && @$Idents['status'] == 2 && $model->status == 2) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 1 && @$Idents['status'] == 2 && $model->status == 3) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 2 && @$Idents['status'] == 2 && $model->status == 3) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }


                                        if (@$Idents[type] == 1 && @$Idents['status'] == 1 && $model->status == 3) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 2 && @$Idents['status'] == 1 && $model->status == 3) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }


                                        if (@$Idents[type] == 1 && @ $Idents['status'] == 0 && $model->status == 1) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-person/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }
                                        if (@$Idents[type] == 1 && @$Idents['status'] == 0 && $model->status == 2) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-person/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }
                                        if (@$Idents[type] == 1 && $Idents['status'] == 0 && $model->status == 3) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-person/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }
                                        if (@$Idents[type] == 1 && $Idents['status'] == 0 && $model->status == 4) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-person/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 2 && $Idents['status'] == 0 && $model->status == 1) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-company/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 2 && $Idents['status'] == 0 && $model->status == 2) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-company/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 2 && $Idents['status'] == 0 && $model->status == 3) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-company/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }

                                        if (@$Idents[type] == 2 && $Idents['status'] == 0 && $model->status == 4) {
                                            return Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']) . '&nbsp;' . Html::a('资质审核', ['travel-company/view', 'id' => $Idents['id']], ['class' => 'btn btn-info']);
                                        }


                                        if (@$Idents['status'] == 1 && $model->status == 1) {
                                            return Html::a('下线', "javascript:drop($key);", ['class' => 'btn btn-danger', 'id' => $key]) . Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
                                        }


                                        if (@$Idents['status'] == 1 && $model->status == 2) {
                                            return Html::a('上线', "javascript:online($key);", ['class' => 'btn btn-danger', 'id' => $key]) . Html::a('查看', ['travel-guide/view', 'id' => $key], ['class' => 'btn btn-info']);
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
                $.post("<?=Url::to(["travel-guide/drop"])?>", {
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
                $.post("<?=Url::to(["travel-guide/online"])?>", {
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
