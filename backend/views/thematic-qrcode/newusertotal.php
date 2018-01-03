<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$thematicQrcodeCustomParams = isset($thematicQrcodeInfo['custom_params']) ? $thematicQrcodeInfo['custom_params'] : '';
$thematicQrcodeCustomParams=='default' && ( $thematicQrcodeCustomParams='默认' );

$this->title = '新增用户统计-'.$thematicQrcodeCustomParams;
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
                                <?= Html::beginForm($refreshUrl, 'get', ['class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                        <?php
                                            echo DateRangePicker::widget([
                                                'model' => $searchModel,
                                                'attribute' => 'register_time',
                                                'convertFormat' => true,
                                                'language' => 'zh-CN',
                                                'options' => [
                                                    'placeholder' => '注册时间',
                                                    'class' => 'form-control',
                                                    'readonly' => true,
                                                ],
                                                'pluginOptions' => [
                                                    'timePicker' => false,
                                                    'timePickerIncrement' => 30,
                                                    'locale' => [
                                                        'format' => 'Y-m-d',
                                                        'separator' => '~',
                                                    ]
                                                ]
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'account_number', ['class' => 'form-control input', 'placeholder' => '账号']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary',"style"=>"margin-right:10px;"]) ?>
                                        <?= Html::a("清空",$refreshUrl,['class' => 'btn btn-sm btn-primary',"style"=>"line-height:30px;"]) ?>
                                    </div>
                                </div>
                                <?= Html::endForm() ?>
                            </div>
                        </div>
                        <?php
                        use kartik\export\ExportMenu;
                        $gridColumns = [
                            [
                                'class'     => 'yii\grid\SerialColumn',
                                'header'    => '序号'
                            ],
                            [
                                'header' => '账号',
                                'attribute' => 'user.mobile',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->user['mobile'];
                                },
                            ],
                            [
                                'header' => '昵称',
                                'attribute' => 'common.nickname',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->common['nickname'];
                                },
                            ],
                            [
                                'header' => '注册时间',
                                'attribute' => 'user.create_time',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->user['create_time'];
                                },
                            ],
                            /*
                            //操作
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {operation}
                                </div> ',
                                'buttons' => [
                                    'operation' => function ($url, $model, $key) {
                                        $str =  '';
                                        return $str;
                                    },
                                ],
                            ],
                            */
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
                    <i class="modal_i">H5链接可以用在除APP内的其他地方，目前只支持微信内部微信支付</i>
                </p>
                <p>
                    <label style="float: left">APP链接：</label>
                    <input type="text" class="modal_text app_link" value="" readonly>
                    <i class="modal_i">APP链接只能用在APP内部</i>
                </p>
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

