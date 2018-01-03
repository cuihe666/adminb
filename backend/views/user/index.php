<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员列表';
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>

<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-title"><h5>用户列表</h5></div>
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">
                            <div class="search-item">
                                <div class="search-item">
                                    <?= Html::beginForm(['user/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 280px; float: left;margin-right: 18px;">
                                            <?php
                                            echo DateRangePicker::widget([
                                                'model' => $searchModel,
                                                'attribute' => 'start_time',
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
                                                        'format' => 'Y-m-d'
                                                    ]
                                                ]
                                            ]);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 280px; float: left;margin-right: 18px;">
                                            <?= Html::activeInput('text', $searchModel, 'mobile', ['class' => 'form-control input', 'placeholder' => '请输入帐号搜索']) ?>
                                        </div>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                            <?= Html::activeInput('text', $searchModel, 'city_name', ['class' => 'form-control input', 'placeholder' => '按城市名搜索']) ?>
                                        </div>
                                    </div>
                                    <!-- 民宿317添加【用户类型筛选功能】-user:ys time:2017/11/1 -->
                                    <div class="search-item">
                                        <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                            <?= Html::activeDropDownList($searchModel, 'user_vip_type',Yii::$app->params['house']['house_user_auth_option'], ['class' => 'form-control user_vip_type', 'prompt' => '用户类型']) ?>
                                        </div>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                            <?= Html::activeDropDownList($searchModel, 'user_check_type',Yii::$app->params['house']['house_auth_status'], ['class' => 'form-control user_check_type','disabled'=> $searchModel->user_vip_type == 1 ? false : true, 'prompt' => '全部']) ?>
                                        </div>
                                    </div>
                                    <!-- 完 -->
                                    <div class="search-item">
                                        <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                            <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                                            <?= Html::a("清空",$url = ['user/index'],$options = ['class' => 'btn btn-sm btn-primary']) ?>
                                        </div>
                                    </div>
                                    <?= Html::endForm() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    use kartik\export\ExportMenu;
                    $gridColumns = [
                        'id',
                        'mobile',
                        'common.nickname',
                        'create_time',
                        ['attribute' => 'citycode',
                            'value' => function ($model) {
                                $city_name = \backend\service\CommonService::get_city_name($model->citycode);
                                return $city_name ? $city_name : '暂无';
                            },
                        ],
                        ['attribute' => 'areacode',
                            'value' => function ($model) {
                                $areaname = \backend\service\CommonService::get_city_name($model->areacode);
                                return $areaname ? $areaname : '暂无';
                            },
                        ],
                        ['attribute' => 'status',
                            'header' => '状态',
                            'value' => function ($model) {
                                if ($model->status == 4) {
                                    return '房源已下线';
                                }
                                return '正常';
                            },
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => '操作',
                            'template' => '<div class="dropdown profile-element group-btn-edit">
                                  {drop}{check}{view}
                                </div> ',
                            'buttons' => [
                                'drop' => function ($url, $model, $key) {
                                    if ($model->status != 4) {
                                        return Html::a("下线房源", "javascript:changestatus($key);", ['id' => $key])."&nbsp;&nbsp;";
                                    } else {
                                        return '';
                                    }
                                },
                                'check' => function($url,$model,$key){
                                    if($model->auth==1)
                                        return Html::a("审核",['view', 'id' => $key])."&nbsp;&nbsp;";
                                },
                                'view' => function($url,$model,$key){
                                    if($model->auth!=1)
                                        return Html::a("查看", ['view', 'id' => $key]);
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

<script>
    function changestatus($key) {
        layer.confirm('确认要进行此操作吗?', {icon: 3, title: '友情提示'}, function (index) {
            $.post("<?=\yii\helpers\Url::to(["house-details/drop"])?>", {
                "PHPSESSID": "<?php echo session_id();?>",
                "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                data: {id: $key},
            }, function (data) {
                if (data == -1) {
                    layer.alert('非法操作');
                    window.location.reload();
                }
                if (data == 1) {
                    layer.alert('操作成功');
                    window.location.reload();
                }
                if (data == -2) {
                    layer.alert('该帐号下没有可下线的房源');
                    window.location.reload();
                }
            });
        });
    }

    $(".user_vip_type").change(function(){
        var type = $(this).val();
        if(type==1){
            $(".user_check_type").attr("disabled",false);
        }else{
            $(".user_check_type").attr("disabled","true");
        }
    })

</script>