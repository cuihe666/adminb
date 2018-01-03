<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
$a = 123;
/* @var $this yii\web\View */
/* @var $searchModel /*app\models\BookingQuery*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '酒店管理';

$this->params['breadcrumbs'][] = $this->title;
\backend\assets\ScrollAsset::register($this);

//酒店2.0 添加酒店省份筛选功能
$city_data = (isset($searchModel->province) && !empty($searchModel->province)) ?\backend\models\Qrcode::getCity($searchModel->province) : \backend\models\Qrcode::getCity();
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/xhhgrogshop.css">
<style>
    .btn-group, .btn-group-vertical
    {
        margin-top: 10px;
    }
    .btn-group{
        margin-left:10px;
    }
    .summary{
        margin-left:20px;
    }



</style>

<!-- layer -->
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/layer/skin/default/layer.css"/>
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
<script>
    function getCity(obj) {
        if ($(obj).val() == '') {
            $("#top_city_select").html('<option value="">请选择城市</option>');
        } else {
            $.get("<?=\yii\helpers\Url::to(["house-details/getcity"])?>" + "?id=" + $(obj).val(), function (data) {
                $("#top_city_select").html(data);
            });
        }
    }
</script>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix" style="margin: -65px 0 0 20px;">
                            <div class="search-item">
                                <?= Html::beginForm(['hotel/index'], 'get', ['class' => 'form-horizontal', 'id' => 'addForm','style'=>"float:left;"]) ?>
                                <!-- 酒店2.0 添加省份搜索功能 ys -->
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'province',\backend\models\Qrcode::getProvince(), ['class' => 'form-control', 'prompt' => '省份','value'=>$searchModel->province, 'onchange' => "getCity(this)"]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'city',isset($city_data) ? $city_data : \backend\models\Qrcode::getCity(), ['class' => 'form-control', 'prompt' => '请选择城市','value'=>$searchModel->city, 'id' => 'top_city_select']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'check_status',Yii::$app->params['hotel_check_status'], ['class' => 'form-control', 'prompt' => '酒店审核状态','value'=>$searchModel->check_status]) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'status',Yii::$app->params['hotel_status'], ['class' => 'form-control', 'prompt' => '酒店状态','value'=>$searchModel->status]) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'type',Yii::$app->params['hotel_type'], ['class' => 'form-control', 'prompt' => '酒店类型','value'=>$searchModel->type]) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'complete_name', ['class' => 'form-control input', 'placeholder' => '请输入酒店名称或ID','value'=>$searchModel->complete_name]) ?>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                        <?= Html::a("清空",$url = ['hotel/index'],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:30px;"]) ?>
                                    </div>
                                </div>

                                <?= Html::endForm() ?>
                            </div>
                        </div>


                        <?php
                        use kartik\export\ExportMenu;
                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
                            ['attribute' => 'id',
                                'header' => '酒店ID',
                                'value' => function ($model) {
                                    return $model->id;
                                }
                            ],
                            ['attribute' => 'complete_name',
                                'header' => '酒店名称',
                                'value' => 'complete_name',
                                'headerOptions' => ['style' => 'width:10%;'],
                            ],
                            ['attribute' => 'supplier.brand',
                                'header' => '品牌',
                                'value' => 'supplier.brand',
                            ],
                            ['attribute' => 'type',
                                'header' => '酒店类型',
                                'value' => function ($model) {
                                    return Yii::$app->params['hotel_type'][$model->type];
                                }
                            ],
                            ['attribute' => 'city',
                                'header' => '所属城市',
                                'value' => function ($model) {
                                    return $model->cityName->name;
                                }
                            ],
                            ['attribute' => 'supplier_id',
                                'header' => '关联供应商ID',
                                'value' => 'supplier_id',
                            ],
                            ['attribute' => 'update_time',
                                'header' => '上线时间',
                                'value' => function ($model) {
                                    if($model->status==1)
                                        return $model->update_time;

                                }
                            ],
                            ['attribute' => 'status',
                                'header' => '酒店状态',
                                'value' => function ($model) {
                                    return Yii::$app->params['hotel_status'][$model->status];

                                }
                            ],
                            ['attribute' => 'check_status',
                                'header' => '酒店状态',
                                'value' => function ($model) {
                                    return Yii::$app->params['hotel_check_status'][$model->check_status];

                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div>{update}{check}</div> ',
                                'buttons' => [
                                    /*'view' => function ($url, $model, $key) {
                                        return Html::a('查看', ['hotel/view', 'id' => $key], ['class' => 'btn btn-info','style'=>'margin-right:10px;']);
                                    },*/
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('查看酒店', ['hotel/update', 'id' => $key], ['class' => 'btn btn-info','style'=>'margin-right:10px;','target'=>'_blank']);
                                    },
                                    'check' => function ($url, $model, $key) {
                                        if($model->check_status==1) {
                                            if ($model->status == 1)
                                                return Html::a('停用', 'javascript:;', ['class' => 'btn btn-danger btn_status', 'type' => 0, 'data' => $model->id, 'check' => $model->check_status, 'style' => 'margin-right:10px;']);
                                            if ($model->status == 0)
                                                return Html::a('启用', 'javascript:;', ['class' => 'btn btn-info btn_status', 'type' => 1, 'data' => $model->id, 'check' => $model->check_status, 'style' => 'margin-right:10px;']);
                                        }
                                    },
                                ],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '审核',
                                'template' => '<div><!--{check}-->{view}{update}</div> ',
                                'buttons' => [
                                   /* 'check' => function ($url, $model, $key) {
                                        return Html::a('审核', ['hotel/view', 'id' => $key,'type'=>1], ['class' => 'btn btn-info','style'=>'margin-right:10px;']);
                                    },*/
                                    'view' => function ($url, $model, $key) {
                                        if($model->check_status==1){
                                            return Html::a('通过', 'javascript:;', ['class' => 'btn btn-default','style'=>'margin-right:10px;']);
                                        }else{
                                            return Html::a('通过', 'javascript:;', ['class' => 'btn btn-info price_clk','type'=>1,'data'=>$model->id,'current'=>$model->check_status,'style'=>'margin-right:10px;']);
                                        }

                                    },
                                    'update' => function ($url, $model, $key) {
                                        if($model->check_status==2){
                                            return Html::a('拒绝', 'javascript:;', ['class' => 'btn btn-default','style'=>'margin-right:10px;']);
                                        }else{
                                            return Html::a('拒绝', 'javascript:;', ['class' => 'btn btn-danger price_clk','type'=>2,'data'=>$model->id,'current'=>$model->check_status,'style'=>'margin-right:10px;']);
                                        }

                                    },
                                ],
                            ],
                        ];

                        // Renders a export dropdown menu
                        echo ExportMenu::widget([
                            'dataProvider' => $dataProvider
                            ,'columns' => $gridColumns
                        ]);
                        ?>
                        <?= Html::a('添加酒店', ['add'], ['class' => 'btn btn-success','style'=>" margin-top:20px;"]) ?>
                        <?php
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
    <div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="more_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="width:300px; left:33%;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel">修改审核状态</h4>
                </div>
                <div class="modal-body" style="overflow: hidden;">
                    <?= Html::beginForm(['hotel/index'], 'get', ['class' => 'form-horizontal', 'id' => 'addForm','style'=>"float:left;"]) ?>
                        <p>
                            <label style="float: left">审核状态：</label>
                            <span class="check_status"></span>
                            <!--<select name="check_status" class="form-control check_status" readonly="true"></select>-->
                        </p>
                        <p style="display: none;">
                            <label style="float: left">审核备注：</label>
                            <textarea name="remarks" class="remarks" cols="60" rows="5"></textarea>
                        </p>
                    <?= Html::endForm() ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary check_sub" id="more_fangtai_sure">确定</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <script>

//       $(function(){
//           changeMargin();
//           window.onresize = function(){
//               changeMargin();
//           };
//           function changeMargin(){
//               var wid =  $(window).width();
//              if(wid<1784){
//               $(".wrapper").width("1748px");
//              }else{
//                  $(".wrapper").width("100%");
//              }
//           }
//       })
        /*点击弹出审核状态的模态框*/
        $(document).on('click', '.price_clk', function () {
            var hotel_id = $(this).attr("data");    //当前酒店id
            var oprtype  = $(this).attr("type");    //操作类型 1：通过 2：拒绝
            var current_check_status = $(this).attr("current");  //当前审核状态
            var check_status_params = <?= json_encode(Yii::$app->params['hotel_check_status'])?>;
            if(current_check_status==oprtype){
                $("#more_modal").modal("hide");
                var msg = "";
                if(oprtype==1)
                    msg = "已通过状态";
                if(oprtype==2)
                    msg = "已拒绝状态";
                layer.alert("当前状态即为"+msg+"!操作无效");
                return false;
            }
            $("#more_modal").modal("show");
            /*var html = "";
            $.each(check_status_params, function(index, content){
                var select = "";
                if(index==oprtype)
                    select = "selected";
                html += "<option value='"+index+"' "+select+">"+content+"</option>";
            })*/
            //$(".check_status").append(html);
            var html = <?=json_encode(Yii::$app->params['hotel_check_status'])?>;
            $(".check_status").text(html[oprtype]);
            $(".remarks").nextAll().remove();
            $(".remarks").after("<input type='hidden' name='hotel_id' class='m_hotel_id' value='"+hotel_id+"' />");
            $(".remarks").after("<input type='hidden' name='before_check_status' class='before_check_status' value='"+current_check_status+"' />");
            $(".remarks").after("<input type='hidden' name='after_check_status' class='after_check_status' value='"+oprtype+"' />");

        })

        /*点击修改审核状态*/
        $(document).on('click','.check_sub',function(){
            var parent = $(this).parent().siblings(".modal-body");
            //var check_status  = parent.find(".check_status").val();
            var remarks = parent.find(".remarks").val();
            var hotel_id = parent.find(".m_hotel_id").val();
            var before_check_status = parent.find(".before_check_status").val();
            var after_check_status = parent.find(".after_check_status").val();
            var _this = $(this);

            $.ajax({
                type: 'POST',
                url: '<?= \yii\helpers\Url::toRoute(["check-status"])?>',
                data: {
                    check_status: after_check_status,
                    remarks:remarks,
                    hotel_id:hotel_id,
                    before_check_status:before_check_status,
                },
                dataType: 'json',
                success: function (data) {
                    if(data==1){
//                        location.href = '<?php //echo \yii\helpers\Url::to(['hotel/index']) ?>//';
                        location.reload();
                    }
                    if(data==-1){
                        layer.alert("参数有误");
                    }
                    if(data==-2){
                        layer.alert("操作失败");
                    }
                },
            });
        })

        /*点击修改酒店状态*/
        $(document).on('click','.btn_status',function(){
            var check_status = $(this).attr("check");
            if(check_status!=1){
                layer.alert("当前酒店状态未审核通过，不能启用！");
            }
            else {
                var _this = $(this);
                layer.confirm('您确定操作吗？', {
                    btn: ['确定', '取消'], //按钮
                    shade: false //不显示遮罩
                }, function (index) {
                    var hotel_id = _this.attr("data");    //当前酒店id
                    var oprtype = _this.attr("type");    //操作类型 0：禁用，1：启用
                    $.ajax({
                        type: 'POST',
                        url: '<?= \yii\helpers\Url::toRoute(["update-hotel-status"])?>',
                        data: {
                            status: oprtype,
                            hotel_id: hotel_id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            if (data == 1) {
//                                location.href = '<?php //echo \yii\helpers\Url::to(['hotel/index']) ?>//';
                                location.reload();
                            }
                            if (data == -1) {
                                layer.alert("参数有误");
                            }
                            if (data == -2) {
                                layer.alert("操作失败");
                            }
                        },
                    });


                })
            }
        })
    </script>


