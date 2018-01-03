<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '当地活动';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/commodity-change/css/higo.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/commodity-change/js/higo.js"></script>
<div class="booking-index">
    <ul class="title">
        <li><a href="<?=\yii\helpers\Url::to(['travel-tag-manage/higo'])?>">主题线路</a></li>
        <li class="on"><a href="<?=\yii\helpers\Url::to(['travel-tag-manage/activity'])?>">当地活动</a></li>
        <li><a href="<?=\yii\helpers\Url::to(['travel-tag-manage/guide'])?>">当地向导</a></li>
        <li><a href="<?=\yii\helpers\Url::to(['travel-tag-manage/impress'])?>">印象</a></li>
        <li><a href="<?=\yii\helpers\Url::to(['travel-tag-manage/note'])?>">游记</a></li>
    </ul>
    <div class="tap-wrap">
<!--        <button id="add">添加</button>-->
        <a href="javascript:;" id="add" class="btn btn-info">添加</a>
    </div>
    <div>
        <?php
        use kartik\export\ExportMenu;

        $gridColumns = [

            /* ['class' => 'yii\grid\SerialColumn',
                 'header' => '编号'],*/

            ['attribute' => 'title',
                'header' => '线路主题',
                'value' => function ($model) {

                    return $model->title;
                }
            ],
            ['attribute' => 'desc',
                'header' => '描述',
                'value' => function ($model) {

                    return $model->desc;
                }
            ],
            ['attribute' => 'sort',
                'header' => '排序',
                'value' => function ($model) {

                    return $model->sort;
                }],

            ['attribute' => 'status',
                'header' => '状态',
                'value' => function ($model) {

                    switch ($model->status) {
                        case 0;
                            return "禁用";
                            break;
                        case 1;
                            return "正常";
                            break;

                        case 2;
                            return "无";
                            break;
                    }


                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {update}{online}
                                </div> ',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return '<a href="javascript:;" id="'.$key.'" data-status="'.$model->status.'" class="btn btn-danger update">修改</a>';
                    },
                    'online' => function($url, $model, $key){
                        if($model->status == 1){
                            return '<a href="javascript:;" id="'.$key.'" mode="'.$model->type.'" class="btn btn-danger line">禁用</a>';
                        }else if($model->status == 0){
                            return '<a href="javascript:;" id="'.$key.'" class="btn btn-danger online">启用</a>';
                        }
                    }
                ],
            ],


        ];


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
                    <label style="float: left">活动主题：</label>
                    <input type="text" class="modal_text h5_link" value="" id="title" >
                    <i class="modal_i">最多6个字</i>
                </p>
                <p>
                    <label style="float: left">描述：</label>
                    <textarea name="" id="desc" cols="55" rows="10"></textarea>
                    <i class="modal_i"></i>
                </p>
                <p>
                    <label style="float: left">排序：</label>
                    <input type="text" class="modal_text app_link" value="" id="sort" >
                    <i class="modal_i"></i>
                </p>
                <p class="is_use">
                    <label style="float: left">是否启用：</label>
                    <input type="radio" class="status" name="status" value="1" id="open" checked >启用
                    <input type="radio" class="status" name="status" value="0" id="close" >禁用
                    <i class="modal_i"></i>
                </p>
            </div>
            <input type="hidden" id="store_type" value="1" >
            <input type="hidden" id="tag_id" value="" >
            <div class="modal-footer">
                <button type="button" class="btn btn-primary close_2" data-dismiss="modal" id="sub" >确定</button>
                <button type="button" class="btn btn-primary close_2" data-dismiss="modal" id="cancel" >取消</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        var str = $(".is_use").html();
        $('#add').click(function(){
            $('#store_type').attr('value',1);
            $("#more_modal").modal("show");
        });
        $('#sub').click(function(){
            var title = $('#title').val();
            var desc = $('#desc').val();
            var sort = $('#sort').val();
            var status = $("input[class='status']:checked").val();
            var type = 2;
            var store_type = $('#store_type').val();
            var id = $('#tag_id').val();

            if(title.length != 0){
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::toRoute(['travel-tag-manage/higo-store']) ?>",
                    data: {title:title,desc:desc,sort:sort,status:status,type:type,store_type:store_type,id:id},
                    success: function (data) {
                        if(data==-1){
                            layer.alert('参数有误', {icon: 2});
                        }else{
                            location.reload();
//                            console.log(data);return false;
//                            data = eval("(" + data + ")");
//                            window.reload();
                        }
                    }
                })
            }

        });
        $('.line').click(function(){//禁用
            var id = $(this).attr('id');
            var type = 0;//禁用
            var return_data = '';
            var mode = $(this).attr('mode');

            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::toRoute(['travel-tag-manage/get-changes']) ?>",
                data: {id:id,mode:mode},
                success: function (data) {
                    data = $.parseJSON(data);
                    if(data.status==-1){
                        layer.alert('参数有误', {icon: 2});
                    }else{
                        if(data.options.length!=0){
                            return_data = data.options;
                            layer.confirm("已有"+data.nums+"篇活动选择此标签，是否将已选标签替换：<select name='change_item' class='change_item'>"+return_data+"</select><p>禁用后此标签在商家后台和APP端将不再显示，确定禁用吗？</p>", {icon: 3, title: '友情提示'}, function (index) {
                                var items = $('.change_item').find('option:selected').val();
                                $.ajax({
                                    type: 'post',
                                    url: "<?php echo \yii\helpers\Url::toRoute(['travel-tag-manage/higo-line']) ?>",
                                    data: {id:id,type:type,items:items,model:mode},
                                    success: function (data) {
                                        if(data==-1){
                                            layer.alert('参数有误', {icon: 2});
                                        }else{
                                            location.reload();
                                        }
                                    }
                                })
                            })
                        }
                    }
                }
            })


        });

        $('.online').click(function(){//启用
            var _this = $(this);
            layer.confirm('启用后此分类将在商家后台和APP端显示，确定启用吗？', {icon: 3, title: '友情提示'}, function (index) {
                var id = _this.attr('id');
                var type = 1;//启用
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::toRoute(['travel-tag-manage/higo-line']) ?>",
                    data: {id:id,type:type},
                    success: function (data) {
                        if(data==-1){
                            layer.alert('参数有误', {icon: 2});
                        }else{
                            location.reload();
                        }
                    }
                })
            })

        })
        $('.update').click(function(){//修改
            var title = $(this).parent().parent().siblings(":first").html();
            var desc = $(this).parent().parent().siblings(":eq(1)").html();
            var sort = $(this).parent().parent().siblings(":eq(2)").html();
            var status = $(this).attr('data-status');
            var id = $(this).parent().parent().parent().attr('data-key');
            $('#tag_id').attr('value',id);
            $('#title').val(title);
            $('#desc').val(desc);
            $('#sort').val(sort);
            $('#store_type').attr('value',2);
            if(status == 1){
                $(".is_use").html("");
                $(".is_use").html(str);
                $('#open').attr('checked','checked');
            }else if(status == 0){
                $(".is_use").html("");
                $(".is_use").html(str);
                $('#close').attr('checked','checked');
            }

            $("#more_modal").modal("show");
        })
    })
</script>