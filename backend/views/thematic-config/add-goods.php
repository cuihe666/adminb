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

</style>
<?php
if (Yii::$app->session->hasFlash('success')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('success')?>")</script>
<?php } ?>
<?php
if (Yii::$app->session->hasFlash('had')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('had')?>")</script>
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
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/goods-cat','id'=>$activity['id']]) ?>"<?php if(Yii::$app->request->get()['module_type']==2) echo "class='current'"?>>商品分类模块</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/book-log','id'=>$activity['id']]) ?>">预定记录</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/view','id'=>$activity['id']]) ?>">预览发布</a></li>

                </ul>
            </div>
            <!--右侧内容区-->
            <div class="config_r fl">
                <div class="config_r_title">
                    <?php
                    if($module_type==1) echo "商品模块";
                    if($module_type==2){
                        echo "商品管理&nbsp;-&nbsp;".$goods_module['category_name'];
                    }
                    ?>
                </div>
                <p class="tips">提示：提示：此处配置展示的商品。</p>
                <!--配置、模板-->
                <div class="config_tab clearfix">
                    <ul class="config_tap fl">
                        <li class="current">添加</li>
                        <!--<li>模板</li>-->
                    </ul>
                    <!--todo 需要添加商品-->
                </div>
                <!--config_con 配置内容区  config_color 设置颜色-->
                <div class="config_con config_color">
                    <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'activity_form']) ?>
                        <div class="c_box c_bg_box">
                            <div class="c_item c_bg">
                                <span style="float: left;min-width: 80px;">商品类型</span>
                                <div style="display: inline" class="goods_div">
                                    <select style="border:1px solid #ccc;min-width:150px;padding:5px;" class="chooseType" name="goods_type">
                                        <option value="2">主题线路</option>
                                        <option value="1">当地活动</option>
                                    </select>
                                    <span style="position:relative;display: inline-block;" class="keywords" >
                                        <input type="text" placeholder="请输入ID/名称" id="chooseCity" name="ID_name" style="border:1px solid #666;padding:5px; width:500px;" onblur="leave()"  autocomplete="off">
                                        <div class="auto-screening auto-hidden" id="autoScreening" style="display:none;position:absolute;left:0;top:35px;width:100%;border:1px solid #666; z-index:99; height:300px; overflow: scroll;background-color:#fff;"></div>
                                        <img src="<?= Yii::$app->request->baseUrl ?>/dist/images/search.png" class="search_name" alt="" style="position:absolute;right:0;top:0;width:30px;height:33px;">
                                    </span>
                                    <i class="error_tips" style="color:red;font-size: 12px;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="c_box c_bg_box goods_info" style="display: none">
                            <div class="c_item c_bg">
                                <span style="float: left;min-width: 80px;">商品主图</span>
                                <img src="" alt="" style="display:inline;width:200px;height:150px;" class="c_goods_img">
                            </div>
                        </div>
                        <div class="c_box c_btn_box goods_info" style="margin-bottom:50px; display: none">
                            <div class="c_item c_btn">
                                <label for="" style="min-width: 80px;">商品名称</label>
                                <span class="c_goods_name"></span>
                            </div>
                        </div>
                        <div class="c_box c_btn_box goods_info" style="margin-bottom:50px; display: none">
                            <div class="c_item c_btn">
                                <label for="" style="min-width: 80px;">商品价格</label>
                                <span class="c_goods_price"></span>元
                            </div>
                        </div>
                        <!--提交按钮-->
                        <div class="c_submit">
                            <input type="hidden" name="thematic_id" value="<?=$activity['id']?>">
                            <input type="hidden" name="goods_id" class="goods_id" value="" />
                            <a class="c_button button_cancel c_a_button" href="<?php echo \yii\helpers\Url::to(['thematic-config/goods','id'=>$activity['id'],'mid'=>Yii::$app->request->get()['mid'],'module_type'=>Yii::$app->request->get()['module_type']]) ?>">返回</a>
                            <button class="c_button button_sure button_goods">添加</button>
                        </div>
                    <?= Html::endForm();?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .auto-screening-prompt{
        border-bottom:1px solid #555;
        padding:2px;
        background-color: #fff;
    }
    .auto-screening-prompt:last-child{
        border-bottom: none;
    }
    .auto-screening-prompt:hover{
        background-color: #1888f8;
        color:#fff;
    }
</style>
<script>
    function leave(){
        var val = $("input[name='ID_name']").val();
        if(val ==""){
            $(".error_tips").text("请输入ID名称")
            return false;
        }else{
            $(".error_tips").text("")
        }
    }

    $(".button_goods").click(function(){
        var val = $("input[name='ID_name']").val();
        var goods_id = $(".goods_id").val();
        if(val ==""){
            $(".error_tips").text("请输入ID/名称")
            return false;
        }
        else if(goods_id==""){
            $(".error_tips").text("请点击搜索查找相应的产品")
            return false;
        }
        else{
            $(".error_tips").text("")
            $(".activity_form").submit();
        }
    })

</script>

<!--搜索关键字-->
<script>
    $(".search_name").on("click",function(){
        var name = $(this).siblings("#chooseCity").val();
        var type = $(this).parent().siblings(".chooseType").val();
        var _this = $(this);
        if(name==""){
            return false;
        }
        $.ajax({
            type: 'get',
            url: "<?php echo \yii\helpers\Url::to(['get-goods-info']) ?>",
            data: {
                name: name,
                type: type,
            },
            success: function (data) {
                if(data) {
                    var data = eval("(" + data + ")");
                    var html = "";
                    $.each(data, function (index, content) {
                        html += '<div class=auto-screening-prompt value="' + content.id + '">' + content.name.replace(name, '<b style="color:red; font-weight:normal">' + name + '</b>') + '</div>';
                    });
                    $("#autoScreening").empty();
                    $("#autoScreening").show();
                    $("#autoScreening").append(html);
                    $("#autoScreening").removeClass("auto-hidden");
                }
                else{
                    $("#autoScreening").empty();
                    _this.siblings("#chooseCity").val("");
                    layer.msg("没有此产品");
                }
            }
        });
    });

   /* $(".keywords").on("blur",function(){
        alert(22);
        $("#autoScreening").hide();
    })*/


    $(".auto-screening").on("click",".auto-screening-prompt",function(){
        $("#chooseCity").val($(this).text());
        $("#autoScreening").hide()
        $("#autoScreening").addClass("auto-hidden");
        $(".auto-screening-prompt").remove();
        $(".goods_id").val($(this).attr("value"));
        var type = $(".chooseType").val();
        $.ajax({
            type: 'get',
            url: "<?php echo \yii\helpers\Url::to(['get-one-goods-info']) ?>",
            data: {
                id: $(this).attr("value"),
                type: type,
            },
            success: function (data) {
                var data = eval("(" + data + ")");
                console.log(data);
                $(".c_goods_img").attr("src",data.title_pic);
                $(".c_goods_name").text(data.name);
                $(".c_goods_price").text(data.price);
                $(".goods_info").show();
            }
        });
    })

    $("body").click(function(){
        /*$("#chooseCity").val($(".auto-screening-prompt").first().text());*/
        $(".auto-screening").hide()
    })


</script>


