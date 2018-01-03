<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "【".$activity['name']."】配置";
$this->params['breadcrumbs'][] = $this->title;

?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/gobal.css" />
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/activity_config.css" />

<script>
    var thematic_id = "<?=$activity['id']?>";
    var add_content_url = "<?php echo \yii\helpers\Url::to(['add-content','id'=>$activity['id']]) ?>";
    var to_content_url = "<?php echo \yii\helpers\Url::to(['content','id'=>$activity['id']]) ?>";
    var add_goods_module_url = "<?php echo \yii\helpers\Url::to(['add-goods-module','id'=>$activity['id']]) ?>";
    var to_goods_module_url = "<?php echo \yii\helpers\Url::to(['goods','id'=>$activity['id'],'module_type'=>1]) ?>";
    var del_module_url = "<?php echo \yii\helpers\Url::to(['del-module','id'=>$activity['id']]) ?>";
    var to_index_url = "<?php echo \yii\helpers\Url::to(['index','id'=>$activity['id']]) ?>";
</script>
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/activity_config.js"></script>
<style>
    .uploader .placeholder{ padding-top:40px;}
    .uploader .filelist li p.progress{ bottom:-28px;}
    .uploader .filelist li .success{top:70px;}
    .uploader .filelist div.file-panel{bottom:0px;}
</style>
<?php
if (Yii::$app->session->hasFlash('success')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('success')?>")</script>
<?php } ?>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <!--title-->
        <div class="config_title">
            <h1>配置</h1>
        </div>
        <!--config 内容-->
        <div class="config_box clearfix">
            <!--左侧tab选择-->
            <div class="config_l fl">
                <ul>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/index','id'=>$activity['id']]) ?>">设置色调</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/title-pic','id'=>$activity['id']]) ?>">头图模块</a></li>
                    <?php
                    if(!empty($add_menu)){
                        foreach ($add_menu as $key => $val):
                            if($val[1]==1){
                                $url = \yii\helpers\Url::to(['thematic-config/goods','id'=>$activity['id'],'mid'=>$val[0],'module_type'=>1]);
                            }
                            elseif($val[1]==2){
                                $url = \yii\helpers\Url::to(['thematic-config/content','id'=>$activity['id'],'mid'=>$val[0]]);
                            }
                            $class = "";
                            if(isset(Yii::$app->request->get()['mid'])){
                                if($val[0]==Yii::$app->request->get()['mid'])
                                    $class = "current";
                                else
                                    $class = "";
                            }
                            ?>
                            <li class="po_re"><a href="<?php echo $url ?>" class="<?=$class?>"><?=$val[2]?></a><span class="del po_ab" data="<?=$val[0]?>" data-key="<?=$key?>" data-type="<?=$val[1]?>">X</span></li>
                            <?php
                        endforeach;
                    }
                    ?>
                    <li><a href="javascript:;" class="add_own">添加自定义内容</a></li>
                    <li><a href="javascript:;" class="add_module">添加商品模块</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/goods-cat','id'=>$activity['id']]) ?>">商品分类模块</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/book-log','id'=>$activity['id']]) ?>">预定记录</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/view','id'=>$activity['id']]) ?>">预览发布</a></li>

                </ul>
            </div>
            <!--右侧内容区-->
            <div class="config_r fl">
                <div class="config_r_title">自定义内容</div>
                <p class="tips">提示：此部分目前只支持文字和图片，图片宽度建议750px</p>
                <!--配置、模板-->
                <div class="config_tab clearfix">
                    <ul class="config_tap fl">
                        <li class="current">配置</li>
                        <!--<li>模板</li>-->
                    </ul>
                    <!--todo 需要添加商品-->
                </div>
                <!--config_con 配置内容区  config_color 设置颜色-->
                <div class="config_con config_color">
                    <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'activity_form']) ?>
                    <div class="c_content">
                        <textarea id="uploadEditor" class="follow_remark" style="width:100%; height:500px; resize: none;" name="content"><?=$content['content']?></textarea>
                        <i class="error_content"></i>
                    </div>
                    <!--提交按钮-->
                    <div class="c_submit">
                        <input type="hidden" name="thematic_id" value="<?=$activity['id']?>">
                        <input type="hidden" name="module_id" value="<?=Yii::$app->request->get()['mid']?>">
                        <a class="c_button button_cancel c_a_button"
                           href="<?php echo \yii\helpers\Url::to(['content', 'id' => $activity['id'],'mid'=>Yii::$app->request->get('mid')]) ?>">取消</a>
                        <button class="c_button button_sure button_content">保存</button>
                    </div>
                    <?= Html::endForm();?>
                </div>
            </div>
        </div>
    </div>
</div>
<!------------上传图片控件-------------------->
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/ueditor/ueditor.all.js"></script>
<!-- 使用ue -->
<script type="text/javascript">
    $(".button_content").on("click",function(){
        if(UE.getEditor('uploadEditor').getContent()==""){
            $(".error_content").text("请填写自定义内容")
            return false;
         }
         else{
            $(".error_content").text("");
            $(".activity_form").submit();
            return true;
         }
    })

    // 实例化编辑器，这里注意配置项隐藏编辑器并禁用默认的基础功能。
    /*var ue = UE.getEditor('uploadEditor');*/

    var uploadEditor = UE.getEditor("uploadEditor", {
        isShow: true,
        focus: false,
        enableAutoSave: true,
        autoSyncData: true,
        autoFloatEnabled:true,
        wordCount: true,
        sourceEditor: false,
        scaleEnabled:false,
        elementPathEnabled:false,
        maximumWords:10000,
        //源码、加粗、文字颜色、字体、字号、左对齐、居中、右对齐、超链接、取消链接、添加图片
        toolbars: [[
            'source','bold','forecolor',
             'fontfamily', 'fontsize',
            'justifyleft', 'justifycenter', 'justifyright',
            'link', 'unlink',
            'simpleupload', 'insertimage', 'imagenone', 'imageleft', 'imageright', 'imagecenter'
           /* 'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
            'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
            'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
            'print', 'preview', 'searchreplace', 'drafts', 'help'*/
        ]]
    });
    //给编辑器传递参数filename和kaid，    付燕飞2017年3月23日10:48:10
    uploadEditor.ready(function() {
        uploadEditor.execCommand('serverparam', function(editor) {
            return {
                'filename': 'thematic',
                'kaid':"content",
            };
        });
    });

    // 监听编辑器输入字数超过最大字数后不允许输入动作   付燕飞2017年3月23日11:41:35添加
    uploadEditor.addListener("keyup", function(type, event) {
        var count = uploadEditor.getContentLength(true);
        if(count>10000){
            var contentText = uploadEditor.getContentTxt();
            uploadEditor.setContent(contentText.substring(0, 10000));
        }
    });

    /*// 监听上传附件组件的插入动作
    uploadEditor.ready(function () {
        uploadEditor.addListener("afterUpfile",_afterUpfile);
    });

    document.getElementById('j_upload_file_btn').onclick = function () {
        var dialog = uploadEditor.getDialog("attachment");
        dialog.title = '附件上传';
        dialog.render();
        dialog.open();
    };

    // 附件上传
    function _afterUpfile(t, result) {
        var fileHtml = '';
        for(var i in result){
            //判断上传附件的路径是否在编辑器的内容当中[编辑器为ifames框架加载，因此需要通过$("#ueditor_0").contents()获取ifames框架中的内容]。
            //如果存在的话，删除找到的a标签的父级元素p标签。
            if($("#ueditor_0").contents().find("a[href='"+result[i].url+"']")){
                $("#ueditor_0").contents().find("a[href='"+result[i].url+"']").parent().remove();
            }
            fileHtml += '<li><a href="'+result[i].url+'" target="_blank">'+result[i].url+'</a></li>';
        }
        $("#upload_file_wrap").append(fileHtml);
    }*/
</script>

