<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '修改活动';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>

<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/skin/default/datepicker.css"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>

<!-- 百度上传图片 -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webuploader/webuploader.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/webuploader/style.css"/>
<script>
    var upload_type = "thematic";
    var upload_id   = "show";
</script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/webuploader.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/upload_thematic_share.js"></script>
<!--查看图片控件-->
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/viewer.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>


<style>
    <!--
    .hr-border{background-color:green;height:2px;border:none; margin: 0;}
    .clear{clear: both}
    .thematic_form{}
    .thematic_ul{ margin:20px auto; font-size:14px;}
    .thematic_ul li{ list-style: none; line-height: 32px; margin-bottom:10px; overflow: hidden; zoom:1; }
    .thematic_ul li label{ font-weight: normal; display: inline-block; width:120px; text-align: right; padding-right: 10px;}
    .input_text{ width:400px; height: 30px; line-height: 30px; padding:0 2px; border:1px solid #999999}
    .area_text{ width:400px; height: 100px; line-height: 20px; padding: 0 2px; border:1px solid #999999; resize: none;}
    .thematic_ul li i{ font-style: normal; color: #aaaaaa; font-size:12px; display: inline-block; margin-left:5px;}
    .a_button{ width:86px; height: 26px; line-height: 26px; color: #fff; background-color: #3c8dbc; display: inline-block; text-align: center;border-radius:3px; margin-left:10px;}
    .a_button:hover{ color: #fff;}
    .thematic_submit{ margin-left: 120px; margin-top:20px;}

    /*百度编辑器*/
    .uploader .placeholder{ padding-top: 40px;}
    .uploader .filelist li p.progress{ bottom:-28px;}
    .uploader .filelist li .success{top:70px;}
    .uploader .filelist div.file-panel{bottom:0px;}

    .c_update_img{display: inline-block; height: 28px; line-height: 28px; width: 100px; text-align: center; background-color: #3c8dbc; color: #fff; margin-top: 112px; border-radius: 3px; cursor: pointer;}
    .c_upload_img{
        height:0;}

    .c_img_a{display: inline-block; width: 142px; height: 142px; float: left; border:1px solid #ccc; padding: 5px; margin-right: 10px;}

    /*2017年5月18日12:11:11 查看图片插件样式*/
    .dowebok1 li {
        display: inline-block;
        width:200px ;
        height:150px;
        margin:0 10px 0 0;
    }

    .dowebok1 li img {
        width: 100%;
        height:100%;
    }

/*2017年5月24日14:53:29 xhh 上传失败后添加一个删除按钮*/
    .error_del{
        display: inline-block;width:100%;height:20px;background: rgba( 0, 0, 0, 0.5 );position: absolute;top:0;left:0;z-index:200;line-height: 22px;color:#fff;
    }
</style>

<hr class="hr-border">
<div class="user-backend-create">
    <div class="user-backend-form">
        <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'thematic_form']) ?>
        <ul class="thematic_ul">
            <li>
                <label>活动ID：</label>
                <?=$model->id?>
            </li>
            <li>
                <label>活动名称：</label>
                <input type="text" class="input_text" maxlength="15" name="ThematicActivity[name]" value="<?=$model->name?>" />
                <i class="error_name">最多不超过15字</i>
            </li>
            <li>
                <label>活动开始时间：</label>
                <input id="d422" name="ThematicActivity[start_time]" value="<?=$model->start_time?>" class="input_text" type="text" onfocus="var d4312=$dp.$('d4312');WdatePicker({errDealMode:1,readOnly:true,minDate:'%y-%M-{%d} %H:00:00',maxDate:'#F{$dp.$D(\'d4312\')}',dateFmt:'yyyy-MM-dd HH:00:00',onpicked:function(){d4312.focus()}})" placeholder="请设置活动开始时间" readonly="">
                <i class="error_start_time"></i>
            </li>
            <li>
                <label>活动结束时间：</label>
                <input id="d4312" class="input_text" name="ThematicActivity[end_time]" value="<?=$model->end_time?>" type="text" placeholder="请设置活动结束时间" onfocus="WdatePicker({errDealMode:1,minDate:'#F{$dp.$D(\'d422\')}',dateFmt:'yyyy-MM-dd HH:00:00',readOnly:true})" readonly="">
                <i class="error_end_time"></i>
            </li>
            <li>
                <label>创建者：</label>
                <input type="text" class="input_text" maxlength="5" name="ThematicActivity[creator]" value="<?=$model->creator?>" />
                <i class="error_creator">最多不超过5个字</i>
            </li>
            <li>
                <label>分享标题：</label>
                <input type="text" class="input_text" maxlength="25" name="ThematicActivity[share_title]" value="<?=$model->share_title?>" />
                <i class="error_share_title">最多不超过25个字</i>
            </li>
            <li>
                <label style="float: left;">分享副标题：</label>
                &nbsp;<textarea class="area_text" name="ThematicActivity[share_content]" maxlength="45"><?=$model->share_content?></textarea>
                <i class="error_share_content">最多不超过45个字</i>
            </li>
            <li style="overflow: hidden;" class=" dowebok1">
                <label style="float: left; margin-right: 4px;">分享图片：</label>
                <a target="_blank" class="c_img_a">
                    <img src="<?=Yii::$app->params['imgUrl']?><?=$model->share_pic;?>" data-original="<?=Yii::$app->params['imgUrl']?><?=$model->share_pic;?>"  width="130" height="130" />
                </a>
                <span class="c_update_img">修改图片</span>
                <input type="hidden" name="ThematicActivity[share_pic]" value="<?=$model->share_pic?>">
            </li>
            <li class="c_upload_img">
                <label style="float: left; color: #fff; margin-right: 4px;">分享图片：</label>
                <div id="container" style="width:400px; float: left;">
                    <!--头部，相册选择和格式选择-->
                    <div id="uploader" class="uploader">
                        <div class="queueList">
                            <div id="dndArea" class="placeholder">
                                <div id="filePicker"></div>
                                <p style="text-align: center;">请上传分享图片，格式支持.jpg .jpeg .png</p>
                            </div>
                        </div>
                        <div class="statusBar" style="display:none;">
                            <div class="progress">
                                <span class="text">0%</span>
                                <span class="percentage"></span>
                            </div>
                            <div class="info"></div>
                            <div class="btns">
                                <!--<div id="filePicker2" class="filePicker2"></div>-->
                                <div class="uploadBtn">开始上传</div>
                            </div>
                        </div>
                    </div>
                </div>
                <i class="error_share_pic"></i>
            </li>
            <span class="clear"></span>
            <div class="thematic_submit">
                <input type="hidden" name="ThematicActivity[id]" value="<?=$model->id?>">
                <?= Html::a("返回",$url = ['thematic/index'],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:22px;"]) ?>&nbsp;&nbsp;&nbsp;&nbsp;
                <?= Html::submitButton('保存', ['class' => 'btn btn-success sub']) ?>
            </div>
        </ul>
        <?= Html::endForm();?>


    </div>

</div>
<script>
    $(".thematic_submit").on("click",".sub",function(){
        var name = $("input[name='ThematicActivity[name]']").val();
        var start_time = $("input[name='ThematicActivity[start_time]']").val();
        var end_time = $("input[name='ThematicActivity[end_time]']").val();
        var creator = $("input[name='ThematicActivity[creator]']").val();
        var share_title = $("input[name='ThematicActivity[share_title]']").val();
        var share_content = $("textarea[name='ThematicActivity[share_content]']").val();
        var share_pic = $("textarea[name='ThematicActivity[share_pic]']").val();
        var pic = $("#uploader").find(".pic").val();

        if(name.length==0){
            $(".error_name").text("请输入活动名称").css("color","red");
            return false;
        }
        else{
            $(".error_name").text("最多不超过15字").css("color","#aaa");
        }

        if(start_time.length==0){
            $(".error_start_time").text("请选择开始时间").css("color","red");
            return false;
        }
        else{
            $(".error_start_time").text("");
        }

        if(end_time.length==0){
            $(".error_end_time").text("请选择结束时间").css("color","red");
            return false;
        }
        else{
            $(".error_end_time").text("");
        }

        if(creator.length==0){
            $(".error_creator").text("请输入创建者").css("color","red");
            return false;
        }
        else{
            $(".error_creator").text("最多不超过5个字").css("color","#aaa");
        }

        if(share_title.length==0){
            $(".error_share_title").text("请输入分享标题").css("color","red");
            return false;
        }
        else{
            $(".error_share_title").text("最多不超过25个字").css("color","#aaa");
        }

        if(share_content.length==0){
            $(".error_share_content").text("请输入分享副标题").css("color","red");
            return false;
        }
        else{
            $(".error_share_content").text("最多不超过45个字").css("color","#aaa");
        }

        if(typeof(pic)=="undefined" && share_pic.length==0){
            $(".error_share_pic").text("请上传分享图片").css("color","red");
            return false;
        }
        else{
            $(".error_share_pic").text("");
        }

        $(".thematic_form").submit();

    });

/*点击修改图片*/
    $(".c_update_img").on("click",function(){
        $(".c_upload_img").css("height","auto");

    });

/*2017年5月24日14:53:29 xhh 上传失败后添加一个删除按钮删除图片*/
    $("#uploader").on("click",".error_del",function(){
        var li = $(this).parents(".filelist").find("li").attr('id');
       $(this).parents(".filelist").find("li").remove();
        $("#dndArea").removeClass("element-invisible");
        $(".statusBar").css("display","none");
        uploader.removeFile(li );
    })




/*查看图片控件*/
    $(function() {
        var length = $(".dowebok1").length;
        for(var i = 0; i < length; i++) {
            var viewer = new Viewer(document.getElementsByClassName('dowebok1')[i], {
                url: 'data-original'
            });
        }
    })
</script>
