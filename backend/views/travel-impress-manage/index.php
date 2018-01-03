<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '印象';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<!--时间控件-->
<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/skin/default/datepicker.css"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
<?php
if (Yii::$app->session->hasFlash('msg')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('msg')?>")</script>
<?php } ?>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">
                            <div class="search-item">
                                <?= Html::beginForm(['travel-impress-manage/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
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
                                    <div class="input-group" style="width: 165px; float: left;margin-right: 10px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'ctime',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请选择审核时间',
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
                                        <?= Html::activeInput('text', $searchModel, 'scity', ['class' => 'form-control input', 'placeholder' => '相关城市']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('number', $searchModel, 'account', ['class' => 'form-control input', 'placeholder' => '发布帐号','onkeyup'=>"value=value.replace(/[^1234567890-]+/g,'')"]) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'keywords', ['class' => 'form-control input', 'placeholder' => 'ID/标题']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'nature', ['class' => 'form-control input', 'placeholder' => '资质名称/昵称']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'identity', Yii::$app->params['impress_identity'], ['class' => 'form-control', 'prompt' => '按性质']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'type', Yii::$app->params['impress_type'], ['class' => 'form-control', 'prompt' => '按类型']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'status',[1=>'上线',2=>'下线'], ['class' => 'form-control', 'prompt' => '按状态']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width:120px; float: left;margin-right: 10px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                                        <?= Html::a("清空",$url = ['travel-impress-manage/index'],$options = ['class' => 'btn btn-sm btn-primary']) ?>
                                    </div>
                                </div>

                                <?= Html::endForm() ?>
                            </div>
                        </div>

                        <?php
                        use kartik\export\ExportMenu;

                        $gridColumns = [

                            /*['class' => 'yii\grid\SerialColumn',
                                'header' => '序号'],*/
                            'id',
                            ['attribute' => 'account',
                                'header' => '发布帐号',
                                'value' => function ($model) {
                                    //2017年6月23日15:59:48   付燕飞加判断。如果$model->uid不为空的时候再调用下面获取账号名称的方法。
                                    if($model->uid){
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
                            [
                                'header' => '资质名称',
                                'value' => function ($model) {
                                    return $model->aptitude;
                                }
                            ],
                            [
                                'header' => '昵称',
                                'value' => function ($model) {
                                    return $model->nickname;
                                }
                            ],

                            ['attribute' => 'create_time',
                                'header' => '上传时间',
                                'value' => function ($model) {
                                    return substr($model->create_time,0,10);
                                }
                            ],

                            ['attribute' => 'name',
                                'header' => '标题',
                                'value' => function ($model) {
                                    return $model->name;
                                }
                            ],
                            ['attribute' => 'city',
                                'header' => '城市',
                                'value' => function ($model) {
                                    return rtrim(($model->cityName1->name.",".$model->cityName2->name.",".$model->cityName3->name),",");
                                }
                            ],

                            ['attribute' => 'type',
                                'header' => '类型',
                                'value' => function ($model) {
                                    //return \backend\service\TravelTagService::getTagById($model->type);
                                    return Yii::$app->params['impress_type'][$model->type];
                                }
                            ],

                            'read_count',

                            ['attribute' => 'type',
                                'header' => '点赞量',
                                'value' => function ($model) {
                                    return count($model->support);
                                }
                            ],
                            ['attribute' => 'type',
                                'header' => '收藏量',
                                'value' => function ($model) {
                                    return count($model->collection);
                                }
                            ],

                            'sort',

                            ['attribute' => 'status',
                                'header' => '状态',
                                'value' => function ($model) {
                                    return Yii::$app->params['travel_status'][$model->status];
                                }
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {sort}{update}{reject}{online}{view}
                                </div> ',
                                'buttons' => [
                                    'sort' => function ($url, $model, $key) {
                                        return Html::a('排序', "javascript:;", ['class' => 'btn btn-primary f_sort', 'id' => $key, 'data' => $model->status,'style'=>'margin-right:5px;']);
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('修改', ['update', 'id' => $key], ['class' => 'btn btn-primary', 'id' => $key,'style'=>'margin-right:5px;']);
                                    },
                                    'reject' => function ($url, $model, $key) {
                                        return Html::a('驳回', "javascript:;", ['class' => 'btn btn-danger f_reject', 'id' => $key,'style'=>'margin-right:5px;']);
                                    },
                                    'online' => function ($url, $model, $key) {
                                        if($model->status==2){
                                            return Html::a("上线", "javascript:;", ['class' => 'btn btn-success m_online', 'id' => $key,'data' => $model->status,'style'=>'margin-right:5px;']);
                                        }

                                    },
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('查看', ['view', 'id' => $key], ['class' => 'btn btn-primary', 'id' => $key,'style'=>'margin-right:5px;']);
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

    <!--弹出框-->
    <style>
        .modal-content{width:700px; left:20%;}
        .modal-body p{ line-height: 32px; margin-bottom:10px;}
        .modal-body p label{ width:140px; display: inline-block; text-align: right; font-weight: normal; padding-right:5px;}
        .modal_text{ width:80px; height:30px; line-height: 30px; border:1px solid #ccc; padding:0 4px;}
        .impress_name{ width:500px; height: 30px; line-height: 30px; display: inline-block;}
        .modal-footer{ text-align: center;}
        .close_1,.m_commit{ margin: 0 auto; display: inline-block; width: 120px;}
        .t_name{ text-align: center; margin-bottom: 30px;}
        .modal_i{ display: block; font-style: normal; font-size: 12px; color: #FF0000;}
        .m_remark{ font-style: normal; font-size:12px; color: #FF0000; display: inline-block; margin-left:5px;}
        .clear{ clear: both;}
        .moda1_sort,.moda1_reject{display: none;}
        .m_reason{width:400px; height:120px;}
    </style>
    <div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="more_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title t_name" id="myLargeModalLabel"></h4>-->
                </div>

                <!--          排序弹框          -->
                <div class="moda1_sort">
                    <div class="modal-body" style="overflow: hidden;">
                        <h4 class="modal-title t_name" id="myLargeModalLabel">修改排序</h4>
                        <p>
                            <label style="float: left">标题名称：</label>
                            <span class="impress_name"></span>
                        </p>
                        <p>
                            <label style="float: left">排序值：</label>
                            <input type="number" class="modal_text app_link impress_sort" name="impress_sort" value="0" oninput="if(value.length>1){value=10}" min="0" max="10" >
                            <em class="m_remark">排序数值为0-10，可重复</em>
                        </p>
                        <p>
                            <label style="float: left">有效时间：</label>
                            <input id="d422" name="sort_start_time" value="" class="input_text sort_start_time" type="text" onfocus="var d4312=$dp.$('d4312');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',maxDate:'#F{$dp.$D(\'d4312\')}',dateFmt:'yyyy-MM-dd',onpicked:function(){d4312.focus()}})" placeholder="开始时间" readonly="">
                            至
                            <input id="d4312" class="input_text sort_end_time" name="sort_end_time" value="" type="text" placeholder="结束时间" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'d422\')}',dateFmt:'yyyy-MM-dd',readOnly:true})" readonly="">
                            <em class="m_remark m_sort_time"></em>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="impress_id" class="m_impress_id" value="" />
                        <input type="hidden" name="m_status" class="m_status" value="" />
                        <button type="button" class="btn btn-primary m_commit">提交</button>
                        <button type="button" class="btn btn-default close_1" data-dismiss="modal">关闭</button>
                    </div>
                </div>
                <!--        驳回弹框            -->
                <div class="moda1_reject">
                    <div class="modal-body" style="overflow: hidden;">
                        <h4 class="modal-title t_name" id="myLargeModalLabel">驳回</h4>
                        <p>
                            <label style="float: left">标题名称：</label>
                            <span class="impress_name_r"></span>
                        </p>
                        <p>
                            <label style="float: left">驳回原因：</label>
                            <textarea name="reason" class="m_reason"></textarea>
                            <em class="m_remark m_reason_e" style="display: block; margin-left: 140px;">请填写驳回原因</em>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="impress_id" class="m_impress_id" value="" />
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
        //点击排序弹出框
        $(".f_sort").click(function(){
            var id = $(this).attr("id");
            var status = $(this).attr("data");
            $.ajax({
                type: 'post',
                url: "<?=Url::to(['travel-impress-manage/get-impress-info']) ?>",
                data: {
                    "impress_id":id,
                },
                success: function (data) {
                    console.log(data);
                    data = eval("("+data+")");
                    $(".moda1_sort .impress_name").text(data.name)
                    $(".moda1_sort .impress_sort").val(data.sort);
                    if(data.sort_start_date)
                        $(".moda1_sort .sort_start_time").val(data.sort_start_date.substr(0,10));
                    else
                        $(".moda1_sort .sort_start_time").val("");
                    if(data.sort_end_date)
                        $(".moda1_sort .sort_end_time").val(data.sort_end_date.substr(0,10));
                    else
                        $(".moda1_sort .sort_end_time").val("");
                    $(".moda1_sort .m_impress_id").val(id);
                    $(".moda1_sort .m_status").val(status);
                }
            })
            $(".moda1_sort").show();
            $(".moda1_reject").hide();
            $("#more_modal").modal("show");
        })

        //排序弹框提交按钮ajax处理数据
        $(".m_commit").click(function(){
            var impress_sort = $(".impress_sort").val();
            var sort_start_time = $(".sort_start_time").val();
            var sort_end_time = $(".sort_end_time").val();
            var impress_id = $(".moda1_sort .m_impress_id").val();
            var status = $(".moda1_sort .m_status").val();
            if(impress_sort>0){
                if(sort_end_time=="" || sort_end_time==""){
                    $(".m_sort_time").text("请选择有效期");
                    return false;
                }
            }
            $.post("<?=Url::to(["travel-impress-manage/update-sort"])?>", {
                "PHPSESSID": "<?php echo session_id();?>",
                "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                data: {
                    "impress_id":impress_id,
                    "impress_sort":impress_sort,
                    "sort_start_time":sort_start_time,
                    "sort_end_time":sort_end_time,
                    "status":status,
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

        //点击驳回弹出框
        $(".f_reject").click(function(){
            var id = $(this).attr("id");
            $(".moda1_sort").hide();
            $(".moda1_reject").show();
            $("#more_modal").modal("show");
            $(".impress_name_r").text($(this).parents("tr").find("td").eq(6).text());
            $(".moda1_reject .m_impress_id").val(id);
        })

        //排序弹框提交按钮ajax处理数据
        $(".m_commit_r").click(function(){
            var m_reason = $(".m_reason").val();
            var impress_id = $(".moda1_reject .m_impress_id").val();
            if(m_reason==""){
                $(".m_reason_e").text("请填写驳回原因");
                return false;
            }
            $.post("<?=Url::to(["travel-impress-manage/update-status"])?>", {
                "PHPSESSID": "<?php echo session_id();?>",
                "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                data: {
                    "impress_id":impress_id,
                    "status":3,
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

        //上下线按钮操作
        $(".m_online").click(function(){
            var _this = $(this);
            var id = $(this).attr("id");
            var data = $(this).attr("data");
            var msg = "";
            var status = 2;
            if(data==1){
                msg = "确定要下线吗？";
                status = 2;
                reason = "";
            }
            if(data==2){
                msg = "确定要上线吗？"
                status = 1;
            }
            layer.confirm(msg, {icon: 3, title: '友情提示'}, function (index) {
                $.post("<?=Url::to(["travel-impress-manage/update-status"])?>", {
                    "PHPSESSID": "<?php echo session_id();?>",
                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                    data: {
                        "impress_id":id,
                        "status":status,
                    },
                }, function (data) {
                    if (data == 1) {
                        layer.alert('操作成功');
                        window.location.reload();
                    }
                });
            });
        })
    </script>

