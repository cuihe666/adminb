<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel /*app\models\BookingQuery*/
/* @var $dataProvider yii\data\ActiveDataProvider */
if($type==2){
    $this->title = '个人定制配置';
    $url = 'person';
}
if($type==1){
    $this->title = '企业定制配置';
    $url = 'company';
}
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<style>
    .btn-group, .btn-group-vertical
    {
        margin-top: 10px;
    }
    .tit{
        height: 42px;
        border-bottom: 2px solid #1888F8;
        width: 100%;
        margin: 10px auto;
    }
    .tit a{
        display: inline-block;
        width: 120px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        background: #efefef;
        color: black;
    }
    .tit a:hover{
        cursor: pointer;
    }
    .sty{
        background: #1888F8!important;
        color: white!important;
    }
    .tit span{
        margin-left: 100px;
        display: inline-block;
        width: 100px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        background: #1888F8;
        color: white;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }
    .tit span:hover{
        cursor: pointer;
    }
    .ibox-content{ margin-top:0;}
</style>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">

                        <div class="tit">
                            <a href="<?=$url?>?s=1" <?= $s == 1 ? 'class="sty"' : ''?> style="margin-right: 30px;">有效手机号</a>
                            <a href="<?=$url?>?s=0" <?= $s == 0 ? 'class="sty"' : ''?>>已禁用手机号</a>
                            <span class="add_info">新增手机号</span>
                        </div>

                        <?php
                        use kartik\export\ExportMenu;
                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
                            'id',
                            'name',
                            'tel',
                            ['attribute' => 'create_time',
                                'value' => function ($model) {
                                    return date('Y-m-d H:i:s', $model->create_time);
                                },
                                'visible' => $s==1,
                            ],
                            ['attribute' => 'update_time',
                                'value' => function ($model) {
                                    if($model->update_time)
                                        return date('Y-m-d H:i:s', $model->update_time);
                                    else
                                        return "-";
                                },
                                'visible' => $s==0,
                            ],
                            'remarks',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div>{view}</div> ',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        $model->status == 1 ? $buttonName = "禁用" : $buttonName = "启用";
                                        $model->status == 1 ? $className  = "btn-danger" : $className  = "btn-success";
                                        return Html::a($buttonName,"javascript:;", ['class' => 'btn '.$className.' button_opr','id'=>$model->id,'data'=>$model->status]);
                                    },
                                ],
                                'visible' => $s==1,
                            ],
                        ];

                        // Renders a export dropdown menu
                        echo ExportMenu::widget([
                            'dataProvider' => $dataProvider
                            ,'columns' => $gridColumns
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
</div>

<!--弹出框-->
<style>
    .modal-content{width:700px; left:20%;}
    .modal-body p{ line-height: 32px; margin-bottom:10px;}
    .modal-body p label{ width:140px; display: inline-block; text-align: right; font-weight: normal; padding-right:15px;}
    .modal-body p label em{font-size:12px; color: #aaaaaa; font-style: normal; padding-right: 6px;}
    .modal-body p span em{ display: inline-block; margin-left:10px; font-size:12px; color: #aaaaaa; font-style: normal;}
    .modal-body p span input{ padding:0 5px;}
    .modal-body p span textarea{width:400px; height:120px; resize:none;}
    .note_name{ width:500px; height: 30px; line-height: 30px; display: inline-block;}
    .modal-footer{ text-align: center;}
    .close_1,.m_commit{ margin: 0 auto; display: inline-block; width: 120px;}
    .t_name{ text-align: center; margin-bottom: 30px;}
    .modal_i{ display: block; font-style: normal; font-size: 12px; color: #FF0000;}
    .m_remark{ font-style: normal; font-size:12px; color: #FF0000; display: inline-block; margin-left:5px;}
    .clear{ clear: both;}
    .moda1_sort,.moda1_reject{display: none;}
    .p_remarks{ text-align: center; color: #FF0000;}
</style>
<div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="more_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title t_name" id="myLargeModalLabel">新增手机号</h4>
            </div>

            <!--          排序弹框          -->
            <div class="moda1_sort">
                <div class="modal-body" style="overflow: hidden;">
<!--                    <h4 class="modal-title t_name" id="myLargeModalLabel">新增手机号</h4>-->
                    <p>
                        <label style="float: left">姓名：</label>
                        <span class="note_name"><input type="text" name="name" class="name" maxlength="6" value="" placeholder="请输入姓名" /><em class="name_e">最多6个字</em></span>
                    </p>
                    <p>
                        <label style="float: left">手机号：</label>
                        <span class="note_name"><input type="text" name="tel" class="tel" value="" placeholder="请输入手机号" /><em class="tel_e"></em></span>
                    </p>
                    <p>
                        <label style="float: left">备注：<br><em>非必填</em></label>
                        <span class="note_name"><textarea name="remarks" class="remarks"></textarea></span>
                    </p>
                    <p class="p_remarks">
                        注：新增成功后，用户提交定制，此手机号将收到短信通知
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary m_commit">确定</button>
                    <button type="button" class="btn btn-default close_1" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //点击排序弹出框
    $(".add_info").click(function(){
        $(".moda1_sort").show();
        $("#more_modal").modal("show");
    })

    //点击确定验证信息并提交
    $(".m_commit").click(function(){
        var name = $(".name").val();
        var tel  = $(".tel").val();
        var remarks = $(".remarks").val();
        var reg = /^0?1[3|4|7|5|8][0-9]\d{8}$/;
        var type = '<?=$type?>';
        if(name.length==0){
            $(".name_e").text("请输入姓名");
            $(".name_e").css("color","#ff0000")
            return false;
        }
        else{
            $(".name_e").text("");
        }
        if(tel.length==0) {
            $(".tel_e").text("请输入手机号");
            $(".tel_e").css("color","#ff0000")
            return false;
        }
        else{
            if (!reg.test(tel)) {
                $(".tel_e").text("手机号格式错误");
                $(".tel_e").css("color","#ff0000")
                return false;
            } else {
                var flag = 1;
                $.ajax({
                    type: 'post',
                    url: "<?=Url::to(['ka-config/has-tel']) ?>",
                    async:false,
                    data: {
                        "tel":tel,
                        "type":type,
                    },
                    success: function (data) {
                        if(data>0){
                            $(".tel_e").text("手机号已添加");
                            $(".tel_e").css("color","#ff0000")
                            flag = 1;
                        } else{
                            flag = 0;
                            $(".tel_e").text("");
                        }
                    }
                })
                if(flag==1)
                    return false;
            }
        }
        $.ajax({
            type: 'post',
            url: "<?=Url::to(['ka-config/create']) ?>",
            data: {
                "name":name,
                "tel":tel,
                "remarks":remarks,
                "type":type,
            },
            success: function (data) {
                if(data>=1){
                    layer.alert('操作成功');
                    window.location.href='<?=Url::to(['ka-config/'.$url,'s'=>1]) ?>';
                } else{
                    layer.alert('操作失败');
                }
            }
        })
    })

    //禁用操作
    $(".button_opr").click(function(){
        var _this = $(this);
        layer.confirm('您确定操作吗？', {
            btn: ['确定', '取消'], //按钮
            shade: false //不显示遮罩
        }, function (index) {
            var id = _this.attr("id");      //当前id
            var status = _this.attr("data");   //当前状态
            $.ajax({
                type: 'post',
                async:false,
                url: "<?=Url::to(['ka-config/update-status']) ?>",
                data: {
                    "id":id,
                    "status":status,
                },
                success: function (data) {
                    if(data>=1){
                        layer.alert('操作成功');
                        if(status==1)
                            window.location.href='<?=Url::to(['ka-config/'.$url,'s'=>0]) ?>';
                        else
                            window.location.href='<?=Url::to(['ka-config/'.$url,'s'=>1]) ?>';
                    } else{
                        layer.alert('操作失败');
                    }
                }
            })
        })
    })
</script>

