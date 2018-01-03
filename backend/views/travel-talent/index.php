<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '达人列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<?php if (Yii::$app->session->hasFlash('succ')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('succ')?>", {time: 0,})</script>
<?php } ?>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">
                            <div class="search-item">
                                <?= Html::beginForm(['travel-talent/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 10px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'stime',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请选择注册时间',
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
                                        <?= Html::a("清空",$url = ['travel-talent/index'],$options = ['class' => 'btn btn-sm btn-primary']) ?>
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

                            ['attribute' => 'create_time',
                                'header' => '注册时间',
                                'value' => function ($model) {
                                    return $model->create_time;
                                }
                            ],
                            ['attribute' => 'account',
                                'header' => '帐号',
                                'value' => function ($model) {
                                    if ($model->id) {
                                        return $model->mobile;
                                    }
                                }
                            ],
                            ['attribute' => 'identity',
                                'header' => '性质',
                                'value' => function ($model) {
                                        return \backend\models\TravelActivity::getidentity($model->id);
                                }
                            ],
                            [
                                'header' => '名称',
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
                            ['attribute' => 'create_time',
                                'header' => '主页昵称或品牌名称',
                                'value' => function ($model) {
                                    if($model->nick_name!='')
                                        return $model->nick_name;
                                    elseif($model->brandname!="")
                                        return $model->brandname;
                                    else
                                        return "";
                                }
                            ],
                            //\mdm\admin\components\Helper::

                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                //'template' => '<div class="dropdown profile-element group-btn-edit">{update}{update-status}{view}</div> ',
                                'template' => \mdm\admin\components\Helper::filterActionColumn('{update}{update-status}{view}'),
                                'buttons' =>[
                                    'update' => function ($url, $model, $key) {
                                        if($model->name != "" || $model->cname != ""){
                                            return Html::a('修改', ['update', 'id' => $key], ['class' => 'btn btn-primary', 'id' => $key,'style'=>'margin-right:5px;']);
                                        } else{
                                            return "";
                                        }
                                    },
                                    'update-status' => function ($url, $model, $key) {
                                        if($model->name != "" || $model->cname != ""){
                                            return Html::a('驳回', "javascript:;", ['class' => 'btn btn-danger f_reject', 'id' => $key,'style'=>'margin-right:5px;']);
                                        } else{
                                            return "123";
                                        }
                                    },
                                    'view' => function ($url, $model, $key) {
                                        if($model->name != "" || $model->cname != ""){
                                            return Html::a('查看', ['view', 'id' => $key], ['class' => 'btn btn-primary', 'id' => $key,'style'=>'margin-right:5px;']);
                                        } else{
                                            return "";
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
</div>
<!--弹出框-->
<style>
    .modal-content{width:700px; left:20%;}
    .modal-body p{ line-height: 32px; margin-bottom:10px;}
    .modal-body p label{ width:140px; display: inline-block; text-align: right; font-weight: normal; padding-right:5px;}
    .modal_text{ width:80px; height:30px; line-height: 30px; border:1px solid #ccc; padding:0 4px;}
    .higo_name{ width:500px; height: 30px; line-height: 30px; display: inline-block;}
    .modal-footer{ text-align: center;}
    .close_1,.m_commit{ margin: 0 auto; display: inline-block; width: 120px;}
    .t_name{ text-align: center; margin-bottom: 30px;}
    .modal_i{ display: block; font-style: normal; font-size: 12px; color: #FF0000;}
    .m_remark{ font-style: normal; font-size:12px; color: #FF0000; display: inline-block; margin-left:5px;}
    .clear{ clear: both;}
    .moda1_reject{display: none;}
    .m_reason{width:400px; height:120px;}
</style>
<div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="more_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title t_name" id="myLargeModalLabel"></h4>-->
            </div>
            <!--        驳回弹框            -->
            <div class="moda1_reject">
                <div class="modal-body" style="overflow: hidden;">
                    <h4 class="modal-title t_name" id="myLargeModalLabel">驳回</h4>
                    <p>
                        <label style="float: left">账号：</label>
                        <span class="mobile_r"></span>
                    </p>
                    <p>
                        <label style="float: left">名称：</label>
                        <span class="name_r"></span>
                    </p>
                    <p>
                        <label style="float: left">驳回原因：</label>
                        <textarea name="reason" class="m_reason"></textarea>
                        <em class="m_remark m_reason_e" style="display: block; margin-left: 140px;">请填写驳回原因</em>
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" class="m_user_id" value="" />
                    <button type="button" class="btn btn-primary m_commit_r">提交</button>
                    <button type="button" class="btn btn-default close_1" data-dismiss="modal">关闭</button>
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
    //点击驳回弹出框
    $(".f_reject").click(function(){
        var id = $(this).attr("id");
        $(".moda1_reject").show();
        $("#more_modal").modal("show");
        $(".mobile_r").text($(this).parents("tr").find("td").eq(3).text());
        $(".name_r").text($(this).parents("tr").find("td").eq(5).text());
        $(".moda1_reject .m_user_id").val(id);
    })

    //排序弹框提交按钮ajax处理数据
    $(".m_commit_r").click(function(){
        var m_reason = $(".m_reason").val();
        var user_id = $(".moda1_reject .m_user_id").val();
        if(m_reason==""){
            $(".m_reason_e").text("请填写驳回原因");
            return false;
        }
        $.post("<?=Url::to(["travel-talent/update-status"])?>", {
            "PHPSESSID": "<?php echo session_id();?>",
            "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
            data: {
                "user_id":user_id,
                "status":2,
                "reason":m_reason,
            },
        }, function (data) {
            $("#more_modal").modal("hide");
            if (data > 0) {
                layer.alert('操作成功');
                window.location.reload();
            }
            if(data==-1){
                layer.alert('执行失败');
            }
        });
    })
</script>


