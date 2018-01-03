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

<!-- 百度上传图片 -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webuploader/webuploader.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/webuploader/style.css"/>
<script>
    var upload_type = "thematic";
    var upload_id   = "title_pic";
</script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/webuploader.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/upload_thematic_titpic.js"></script>

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

<!--查看图片控件-->
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/viewer.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>

<style>
    .uploader .placeholder{ padding-top:40px;}
    .uploader .filelist li p.progress{ bottom:-28px;}
    .uploader .filelist li .success{top:70px;}
    .uploader .filelist div.file-panel{bottom:0px;}

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
<?php
if (Yii::$app->session->hasFlash('success')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('success')?>")</script>
<?php } ?>
<div class="booking-index">
    <div class="wrapper-content fadeInRight">
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
                    <li><a href="###" class="current">头图模块</a></li>
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
                <div class="config_r_title">头图模块</div>
                <p class="tips">提示：可配置相应头图，上传的轮播图尺寸必须统一，宽度建议750px。</p>
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
                    <ul class="c_ul">
                        <li><span>图片</span><span>操作</span></li>
                    </ul>
                    <div class="clear"></div>
                    <ul class="c_ul_img">
                        <?php
                        if($model['title_pic']!=""){
                            $titpicArr = explode(",",$model['title_pic']);
                            foreach($titpicArr as $key=>$val):
                        ?>
                        <li class="dowebok1">
                            <span class="c_span_img"><img src="<?=Yii::$app->params['imgUrl'].$val?>" data-original="<?=Yii::$app->params['imgUrl'].$val;?>" /></span>
                            <span><a data="<?=$activity['id']?>" class="c_del_img">删除</a></span>
                        </li>
                        <?php
                            endforeach;
                        }
                        ?>
                    </ul>
                    <div class="clear"></div>
                    <div id="container" class="c_uploader_img">
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
                    <i class="error_title_pic"></i>
                    <!--提交按钮-->
                    <div class="c_submit">
                        <input type="hidden" name="thematic_id" value="<?=$activity['id']?>">
                        <a class="c_button button_cancel c_a_button"
                           href="<?php echo \yii\helpers\Url::to(['title-pic', 'id' => $activity['id']]) ?>">取消</a>
                        <button class="c_button button_sure button_pic">保存</button>
                    </div>
                    <?= Html::endForm();?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //删除头图
    $(".c_del_img").on("click",function(){
        var thematic_id = $(this).attr("data");
        var _this = $(this);
        layer.confirm('您确定操作吗？', {
            btn: ['确定','取消'], //按钮
            shade: false //不显示遮罩
        }, function(index){
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['del-title-pic']) ?>",
                data: {
                    thematic_id_a: thematic_id,
                },
                success: function (data) {
                   if(data==-1){
                        layer.alert("参数错误");
                    }else{
                        _this.parents(".c_ul_img").remove();
                        //location.href = "<?php echo \yii\helpers\Url::to(['title-pic','id'=>$activity['id']]) ?>";
                    }
                    layer.close(index);
                }
            });
        });
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

    /*2017年5月24日14:53:29 xhh 上传失败后添加一个删除按钮删除图片*/
    $("#uploader").on("click",".error_del",function(){
        var li = $(this).parents(".filelist").find("li").attr('id');
        $(this).parents(".filelist").find("li").remove();
        $("#dndArea").removeClass("element-invisible");
        $(".statusBar").css("display","none");
        uploader.removeFile(li );
    })
</script>


