<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '专题活动优惠券列表';
$this->params['breadcrumbs'][] = $this->title;

?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<style>
    #w5-success{display: none;}
    .btn-group, .btn-group-vertical{margin-top: 10px;}
    .name_a{ cursor: pointer}
</style>
<?php
if (Yii::$app->session->hasFlash('success')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('success')?>")</script>
<?php } ?>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix" style="margin: -50px 0 0 20px;">
                            <div class="search-item">
                                <?= Html::beginForm(['thematic-coupon/index','id'=>$thematicId], 'get', ['class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <?= Html::a('添加优惠券', ['create','id'=>$thematicId], ['class' => 'btn btn-success','style'=>"float:left; margin-right:20px; margin-top:10px;"]) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::activeInput('text', $searchModel, 'title', ['class' => 'form-control input', 'placeholder' => '请输入名称']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'status', Yii::$app->params['coupon_activity_status'], ['class' => 'form-control', 'prompt' => '状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary',"style"=>"margin-right:10px;"]) ?>
                                        <?= Html::a("清空",$url = ['thematic-coupon/index','id'=>$thematicId],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:30px;"]) ?>
                                    </div>
                                </div>
                                <?= Html::endForm() ?>
                            </div>
                        </div>
                        <?php
                        use kartik\export\ExportMenu;
                        $gridColumns = [
                            /*[//活动ID
                                'header' => '活动ID',
                                'attribute' => 'id',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->id;
                                },
                            ],*/
                            [//活动名称
                                'header' => '名称',
                                'attribute' => 'name',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->title;
                                },
                            ],
                            [//预设库存量
                                'header' => '预设库存量',
                                'attribute' => 'storage',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->storage;
                                },
                            ],
                            [//每日领取最大数量
                                'header' => '每日领取最大数量',
                                'attribute' => 'daily_max',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if($model->daily_max==0)
                                        return "不限量";
                                    else
                                        return $model->daily_max;
                                },
                            ],
                            [//剩余库存
                                'header' => '剩余库存',
                                'attribute' => 'net_stock',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->net_stock;
                                },
                            ],
                            [//发放对象
                                'header' => '发放对象',
                                'attribute' => 'net_stock',
                                'format' => 'raw',
                                'value' => function ($model) use ($thematicInfo){
                                    $couponJson = $thematicInfo->coupon_activity_id;
                                    //json转换为数组格式（包括all，old，new三个二维数组）
                                    $couponArr = json_decode($couponJson,true);

                                    if(in_array($model->activity_id,$couponArr['all']))
                                        return "所有用户";
                                    if(in_array($model->activity_id,$couponArr['old']))
                                        return "老用户";
                                    if(in_array($model->activity_id,$couponArr['new']))
                                        return "新用户";
                                },
                            ],
                            [//开始时间
                                'header' => '开始时间',
                                'attribute' => 'start_time',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->start_time;
                                },
                            ],
                            [//结束时间
                                'header' => '结束时间',
                                'attribute' => 'end_time',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->end_time;
                                },
                            ],
                            [//创建时间
                                'header' => '创建时间',
                                'attribute' => 'create_time',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->create_at;
                                },
                            ],
                            [//修改时间
                                'header' => '修改时间',
                                'attribute' => 'update_at',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if($model->update_at=='0000-00-00 00:00:00'){
                                        return "未设置";
                                    }
                                    else
                                        return $model->update_at;
                                },
                            ],
                            [//状态
                                'header' => '状态',
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if($model->status == 0){
                                        $style = "color:#00FF33";
                                    }
                                    else{
                                        $style = "color:#CCCCCC";
                                    }
                                    return "<span style='".$style."'>".Yii::$app->params['coupon_activity_status'][$model->status]."</span>";
                                },
                            ],
                            //操作
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {operation}
                                </div> ',
                                'buttons' => [
                                    'operation' => function ($url, $model, $key) use($thematicId) {
                                        $update=Url::toRoute(['update','id'=>$key,'tid'=>$thematicId]);
                                        $str="<a href=$update class='operation_status' style='color: #337ab7;' id='$key-y'>修改</a>";
                                        return $str;
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
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .modal-content{width:700px; left:20%;}
    .modal-body p{ line-height: 32px; margin-bottom:10px;}
    .modal-body p label{ width:140px; display: inline-block; text-align: right; font-weight: normal; padding-right:5px;}
    .modal_text{ width:400px; height:30px; line-height: 30px; border:1px solid #ccc; padding:0 4px;}
    .modal-footer{ text-align: center;}
    .close_1{ margin: 0 auto; display: inline-block; width: 120px;}
    .t_name{ text-align: center; margin-bottom: 30px;}
    .modal_i{ display: block; font-style: normal; font-size: 12px; color: #FF0000;}
    .clear{ clear: both;}
</style>
<div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="more_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title t_name" id="myLargeModalLabel"></h4>-->
            </div>
            <div class="modal-body" style="overflow: hidden;">
                <h4 class="modal-title t_name" id="myLargeModalLabel"></h4>
                <p>
                    <label style="float: left">H5链接：</label>
                    <input type="text" class="modal_text h5_link" value="" readonly>
                    <!--                    <i class="modal_i">H5链接可以用在除APP内的其他地方，目前只支持微信内部微信支付</i>-->
                </p>
                <!--
                                <p>
                                    <label style="float: left">APP链接：</label>
                                    <input type="text" class="modal_text app_link" value="" readonly>
                                    <i class="modal_i">APP链接只能用在APP内部</i>
                                </p>
                -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary close_1" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<script>
    /*******************上线操作********************/
    function online(id,start_time,end_time){
        var now_time = <?= time()?>;
        console.log(typeof(now_time));
        console.log(typeof(start_time));
        console.log(typeof(end_time));
        if(now_time >= start_time && now_time <=end_time) {
            layer.confirm('确认要将此活动上线吗？', {icon: 3, title: '友情提示'}, function (index) {
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::toRoute(['thematic/online']) ?>",
                    data: {id: id},
                    success: function (data) {
                        if(data == -1){
                            layer.alert('参数错误', {icon: 2});
                        }
                        else if (data == 1) {
                            location.reload();
                        } else {
                            layer.alert('上线失败', {icon: 2, title: '友情提示'});
                        }
                    }
                })
            });
        }
        else{
            layer.alert('不在开始和结束时间内，无法上线', {icon: 2, title: '友情提示'});
        }
    }
    /*******************下线操作********************/
    function unline(id){
        layer.confirm('确定要将此活动下线吗？', {icon: 3, title: '友情提示'}, function (index) {
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::toRoute(['thematic/unline']) ?>",
                data: {id: id},
                success: function (data) {
                    if(data == -1){
                        layer.alert('参数错误', {icon: 2});
                    }
                    else if (data == 1) {
                        location.reload();
                    } else {
                        layer.alert('下线失败', {icon: 2});
                    }
                }
            })
        });
    }


    /*******************点击专题名称 弹出框 ********************/
    $(".name_a").click(function(){
        var id = $(this).attr("data");
        $.ajax({
            type: 'post',
            url: "<?php echo \yii\helpers\Url::toRoute(['thematic/get-link']) ?>",
            data: {id: id},
            success: function (data) {
                $("#more_modal").modal("show");
                if(data==-1){
                    layer.alert('参数有误', {icon: 2});
                }
                else{
                    data = eval("(" + data + ")");
                    $(".modal-body .t_name").text(data.name);
                    $(".modal-body .h5_link").val(data.h5_link);
                    $(".modal-body .app_link").val(data.app_link);
                }
            }
        })
    })
</script>

