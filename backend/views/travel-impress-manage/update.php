<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = '修改基本信息';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\ScrollAsset::register($this);
?>

<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/shenhe_sxh.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/viewer.min.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/commodity-change/css/travel-impress-manage-change.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/commodity-change/uploadify/uploadify.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/shenhe.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/commodity-change/uploadify/jquery.uploadify.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/commodity-change/js/zm-canvas-crop2.js"></script>
<!--富文本编辑器-->
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/utf8-php/ueditor.config.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/utf8-php/ueditor.all.js"></script>
<style>
    select {
        height: 30px;
        border: 1px solid #ccc;
        margin-left: 20px;
        border-radius: 2px;
        width: 175px;
    }

    .theme-sxh input {
        width: 80px;
        text-align: center;
        background-color: transparent;
        border-radius: 2px;
    }

    .theme-sxh2 textarea {
        height: 138px;
        border: 1px solid #ccc;
        width: 48%;
        margin-left: 10px;
    }

    /*去掉input[type=number]默认的加减号*/
    input[type='number'] {
        -moz-appearance: textfield;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .theme-sxh3 input {
        width: 60px;
        text-align: center;
    }

    .theme-sxh3 select {
        width: 60px;
        margin-left: 20px;
        margin-right: 5px;

    }

    .theme-sxh4 input {
        width: 90px;
        text-align: center;
        border: none !important;
        background-color: transparent;
    }

    .cont-img img {
        float: left;
        margin-bottom: 10px;
    }

    .div-sxh2 img {
        max-width: 100%;
    }

    .contimg img {
        max-width:100% !important;
    }

    .rignt-con .div-sxh2 img {
        margin-left: 5px;
    }

    td {
        /*padding: 10px 20px;*/
    }

    .part_two .right-r{
        float:inherit;
    }
    .part_two .right-l{
        float:inherit;
    }
    .part_two {
        height: auto;
    }
    textarea{outline:none;resize:none;}
    /*.part_two .right-r {*/
        /*margin-top: 50px;*/
        /*width:50%;*/
        /*!*float:right;*!*/
        /*margin-left:10%;*/
        /*!*margin-right:10px;*!*/
    /*}*/
    .part_two .right-r table{
        /*width:;*/
    }
    .part_two .right-r td{
        /*word-break: break-all;*/
        /*word-wrap:break-word;*/
    }

    .part_two .right-l-btn button {
        margin-left: 120px;
        height: 40px;
        border-radius: 5px;
        width: 120px;
        display: inline-block;
        font-size: 14px;
        font-family: "Microsoft Yahei";
        margin-top: 20px;
    }

    .part_two .right-l-btn button.btn1 {
        background-color: transparent;
        border: 1px solid #555;
    }


    .part_two .right-l-btn button.btn2 {
        background-color: #169bd5;
        color: #fff;
    }
    .part_two .right-r{
        width:100%;
        margin-top:0;
    }
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
    /*2017年6月23日15:21:02 xhh给图片添加放大功能*/
    .layer5 {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;

        background-color: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        display: none;
    }

    .layer5 #div1 {
        display: inline-block;
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        height:80%;
        width:60%;
        text-align: center;
        /*overflow-y: scroll;*/
        transform: translate(-50%,-50%);
        -webkit-transform: translate(-50%,-50%);
        -o-transform: translate(-50%,-50%);
        -moz-transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
    }
    /*.layer5 .record_bj {*/
        /*display: inline-block;*/
        /*position: absolute;*/
        /*left: 50%;*/
        /*top: 50%;*/
        /*z-index: 1;*/
        /*transform: translate(-50%,-50%);*/
        /*-webkit-transform: translate(-50%,-50%);*/
        /*-o-transform: translate(-50%,-50%);*/
        /*-moz-transform: translate(-50%,-50%);*/
        /*-ms-transform: translate(-50%,-50%);*/
    /*}*/
    .layer5 .close {
        position: absolute;
        right: 0;
        top: 0;
        z-index: 3;
        width: 40px;
        transform: translate(-50%, 0);
        -webkit-transform: translate(-50%, 0);
        -o-transform: translate(-50%, 0);
        -moz-transform: translate(-50%, 0);
        -ms-transform: translate(-50%, 0);
    }
    /*2017年6月27日14:15:36 sxh 图片点击放大*/
    .layer5 .btn_sf{
        position:absolute;
        left:0;
        bottom:15%;
        width:100%;
        z-index:5;

    }
    .layer5 .btn_sf img{
        width:30px;
    }
    #div1 img.yin_pic{
        display:none;
    }
    .wrapper{
        width: 100%!important;
    }
    #edui1_iframeholder{
        height: 594px!important;
    }
    #edui1_iframeholder .view{
        overflow-y: auto!important;
    }
    #city1{
        margin-left: 20px;
        margin-top: -20px;
    }

</style>
<script type="text/javascript">
    $(function(){
//            2017年5月6日15:45:11 zjl
        if($(".after_div").find("div").hasClass("xh_shoutu")){
            $(".xh_shoutu").parents(".tg_st").find(".shoutu").hide();
            $(".xh_shoutu").parents(".tg_st").siblings(".tg_st").find(".yincang_tool").hide();
            $(".xh_shoutu").parents(".tg_st").siblings(".tg_st").find(".shotu2").show();
        }
        $("body").on("mouseover",".total_div",function(){
            $(this).children(".tool_div").css("opacity","1")
            $(this).children(".tool_div").children("p").show()
        })
        $("body").on("mouseout",".total_div",function(){
            $(this).children(".tool_div").css("opacity","0")
            $(this).children(".tool_div").children("p").hide()
        })
//        编辑页面后台上传的图片
        $("body").on("mouseover",".after_div",function(){
            $(this).children("p").show()
        })
        $("body").on("mouseout",".after_div",function(){
            $(this).children("p").hide()
        })

//        点击设为首图js
//            2017年5月6日15:40:06 zjl
        $("body").on("click",".shoutu",function(){
            if($(".zp ul li").eq(0).find(".div_shoutu").attr("class") == "div_shoutu current_first"){
                $(".zp ul li").eq(0).find(".div_shoutu").attr("class", "div_shoutu")
            }
//                设为首图 字隐藏 本身的 首图slogan 显示
            $(this).hide().parents(".tg_st").find(".div_shoutu2").find("div").show();
            $(this).hide().parents(".tg_st").find(".div_shoutu").show();
//                设为首图 字隐藏 本身的 首图slogan 显示 其他的slogan隐藏  其他的设为首图四个字 显示
            $(this).hide().parents(".tg_st").siblings(".tg_st").find(".div_shoutu2").find("div").hide();
            $(this).hide().parents(".tg_st").siblings(".tg_st").find(".div_shoutu").hide();
            $(this).hide().parents(".tg_st").siblings(".tg_st").find(".shoutu").show();

            var index = $(".shoutu").index($(this));
            $("#hidden_canvas").val(index)
        })
//        删除js
//            2017年5月6日15:40:06 zjl
        $("body").on('click', '.del', function() {
            //后台设置首图
            var index = $(".tg_st .del").index($(this))
            var val = $("#hidden_canvas").val()
            console.log(index,val,000000)
            //            2017年5月8日17:23:47 zjl 删除首图前方图片隐藏域值减1 问题
            if(val!=0){
                if(index<val) {
                    console.log(index,val,11111)
                    $("#hidden_canvas").val(parseInt(val)-1);
                }else{
                    console.log(index,val,22222)

                }
            }
            //            2017年5月68日 宋杏会 隐藏域赋值修改
            if(index == val){
                console.log(index,val,33333)
                $("#hidden_canvas").val("0");
            }
            $(this).parents(".total_div").remove();
            $(this).parents(".after_div").remove();


        })
    })
</script>
<script type="text/javascript">
    $(function(){
        // 点击删除按钮js
        $("#icon_save img").click(function(){
            $(".layer").hide()
        })

    })
</script>
</head>

<body style="width: 100%;">
<div class="shenhe-sxh">
    <div class="left">

    </div>
    <div class="right">
        <div class="part_one">
            <div class="top">
                <p>
                    <b>
                        ID:<?php echo $model['id'] ?>
                    </b>
                </p>
            </div>
            <div class="rignt-con">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="div-sxh2 zp">
                        <span class="tg_title">封面图片</span>
                        <span style="width:80%;" class="cont-img">
                            <input type="hidden" name="TravelImpress[first_pic]" id="hidden_canvas" value="<?=$model['first_pic']?>" >
                             <ul class="dowebok1" style="margin: 0 0 20px 8px;">
                            <?php
                            $title_pics = explode(',', $model['pic']);
                            if ($model['pic']) {
                                ?>
<!--                                <li class="total_div tg_st">-->
<!--                                    <img data-original="--><?php //echo $title_pics[$model['first_pic']] ?><!--" src="--><?php //echo $title_pics[$model['first_pic']] ?><!--">-->
<!--                                    <div class="tool_div">-->
<!--                                        <p>-->
<!--                                            <span class='del'>删除</span>-->
<!--                                            <span class='shoutu shoutu2'>设为</br>首图</span>-->
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                    <div class='div_shoutu' style="display: block">-->
<!--                                        <i></i>-->
<!--                                        <b>首图</b>-->
<!--                                    </div>-->
<!--                                </li>-->
                                <?php
                                foreach ($title_pics as $k => $v) {?>
                                        <li class="total_div tg_st">
                                            <img data-original="<?php echo $v ?>" src="<?php echo $v ?>" />
                                            <div class="tool_div">
                                                <p>
                                                    <span class='del'>删除</span>
                                                    <span class='shoutu shoutu2'>设为</br>首图</span>
                                                </p>
                                            </div>
                                            <div class='div_shoutu' <?php if ($k == $model['first_pic']){echo 'style="display: block"';} ?>>
                                                <i></i>
                                                <b>首图</b>
                                            </div>
                                        </li>
                                    <input type="hidden" name="title_pic[<?=$k?>]" value="<?=$v?>">
                                 <?php
                                }
                            }
                            ?>
                            <li class="add">
                                <div class="canvas_shangchuan">
                                    <input type="hidden" id="hidden_canvas" name="first_pic" value="0">
                                    <div class="result" id="result_canvas"></div>
                                    <a href="javascript:;" class="meihua">
                                        <input type="file" name="" id="ipt" >
                                        <!--<input type="file" name="" id="ipt">-->
                                    </a>
                                    <div class="layer">
                                        <div class="layer_con_cont" style="margin:0 auto;position:relative">
                                            <div class="canvas-box"></div>
                                            <div class="icon_save" id="icon_save">
                                                <img src="<?= Yii::$app->request->baseUrl ?>/commodity-change/image/dele_pic.png" alt="" style="width:40px;height: 40px;">
                                                <input type="button" id="save" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <i class="canvas_i" style="color:red;font-size:14px;font-style:normal;margin:0 0 0 15px;display:none;text-indent:20px;"></i>
                                </div>
                            </li>
                          </ul>
                        </span>
                    </div>
                    <script type="text/javascript">
                        function saveCallBack(base64) {
                            $(".layer").hide()
                        }
                        var c = new ZmCanvasCrop({
                            fileInput: $('#ipt')[0],
                            saveBtn: $('#save')[0],
                            box_width: 800,  //剪裁容器的最大宽度
                            box_height: 600, //剪裁容器的最大高度
                            min_width: 400,  //上传图片的最小宽度
                            min_height: 300  //上传图片的最小高度
                        }, saveCallBack);
                    </script>
                    <div style="clear: both;"></div>
                    <p>
                        <span class="tg_title">名称</span>
                        <input maxlength="30" type="text" name="TravelImpress[name]" value="<?php echo htmlspecialchars($model['name']) ?>" style="min-width:65%;">
                    </p>
                    <div style="height: 30px; line-height: 30px; margin-bottom: 20px; clear: both;  position:relative;">
                        <span class="tg_title" style="float: left; width: 84px; text-align: right;">相关城市</span>
                        <div class="add-address" style="float:left;">
                            <div style="float:left; margin-right:10px;" class="tg_city1">
                                <input type="text" id="TravelImpress[city1]" class="city1" name="city1" value="<?php echo \backend\models\TravelActivity::getcity($model->city1)?>" style="width: 280px;" maxlength="30" placeholder="请输入城市名称（必填）" autoComplete= "Off" />
                                <input type="hidden" name="TravelImpress[city1]" class="cityhid" value="<?php echo $model->country1.",".$model->province1.",".$model->city1?>" <?php echo intval($model->city1) != 0 ? 'tg="1"' : 'tg="0"'?>  />
                                <i style="margin-left:0;"><?= Html::error($model, 'city1') ?></i>
                            </div>
                            <div style="float:left; margin-right:10px;" class="tg_city2">
                                <input type="text" id="" class="city1" name="city2" value="<?php echo \backend\models\TravelActivity::getcity($model->city2)?>" style="width: 280px;" maxlength="30" placeholder="请输入城市名称（选填）" autoComplete= "Off" />
                                <input type="hidden" name="TravelImpress[city2]" class="cityhid" value="<?php echo $model->country2.",".$model->province2.",".$model->city2?>" <?php echo intval($model->city1) != 0 ? 'tg="1"' : 'tg="0"'?>  />
                            </div>
                            <div style="float:left;" class="tg_city3">
                                <input type="text"  id="" class="city1" name="city3" value="<?php echo \backend\models\TravelActivity::getcity($model->city3)?>" style="width: 280px;" maxlength="30" placeholder="请输入城市名称（选填）" autoComplete= "Off" />
                                <input type="hidden" name="TravelImpress[city3]" class="cityhid" value="<?php echo $model->country3.",".$model->province3.",".$model->city3?>" <?php echo intval($model->city3) != 0 ? 'tg="1"' : 'tg="0"'?>  />
                            </div>
                            <style>
                                .address .add-address input.city1{ background:none; margin-top:12px; padding-left:0;}
                                .region123{ margin-left:0; border:1px solid #efefef; border-top:0; margin-top:-11px; height: 330px; overflow-y: scroll; position:absolute; z-index:9; width:280px; background-color: #fff; top:53px;}
                                .region123 li{ height: 26px; line-height: 26px; cursor: pointer; padding-left:10px;}
                                .address .add-address input.city1{ margin-right:0;}
                            </style>
                            <script>
                                $(".city1").on("input propertychange",function(){
                                    var _this = $(this);
                                    var name = $(this).val();
                                    $(this).siblings(".cityhid").val("");
                                    $(this).siblings(".cityhid").attr("tg",0);
                                    /*reg=/^([\u2E80-\u9FFF])$/
                                     if(!reg.test(name)) {
                                     alert("请输入正确的信息");
                                     return false;
                                     }*/
                                    if(name!=''){
                                        $.ajax({
                                            type: 'GET',
                                            url: '<?= \yii\helpers\Url::toRoute(["region/getcity"])?>',
                                            data: {"name": name},
                                            dataType: 'json',
                                            success: function (data) {
                                                if(data!=""){
                                                    var html = '<ul id="city1" class="form-control region123" name="TravelNote[city1]" >';
                                                    $.each(data, function(index, content){
                                                        html += '<li data="'+index+'">'+content.replace(name, '<b style="color:red; font-weight:normal">'+name+'</b>')+'</li>';
                                                    });
                                                    html += '</ul>';
                                                    _this.next("#city1").remove();
                                                    _this.after(html);
                                                }
                                                else{
                                                    _this.next("#city1").remove();
                                                }

                                            },
                                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                                /*_this.val("");
                                                 _this.blur();*/
                                            }
                                        });
                                    }
                                    else{
                                        $(this).next("#city1").remove();
                                    }
                                });

                                $("body").on("click",".region123 li",function(){
                                    var code = $(this).attr("data");
                                    var name = $(this).text();
                                    var nameArr = name.split(",");
                                    $(this).parent().siblings(".city1").val(nameArr[0]);
                                    $(this).parent().siblings(".cityhid").val(code);
                                    $(this).parent().siblings(".cityhid").attr("tg",1);
                                    $(this).parent().remove();
                                });

                                function tgCity(ev,city){
                                    $(document).on("click",function(){
                                        if($(ev).val()=="" && $(ev).attr("tg")=="0"){
                                            var code = $(city).find("li:first-child").attr("data");
                                            var name = $(city).find("li:first-child").text();
                                            var nameArr = name.split(",");
                                            $(city).find(".city1").val(nameArr[0]);
                                            $(city).find(".cityhid").val(code);
                                            $(city).find("ul").remove();
                                        }

                                    })
                                }
                                tgCity("input[name='TravelImpress[city1]']",".tg_city1");
                                tgCity("input[name='TravelImpress[city2]']",".tg_city2");
                                tgCity("input[name='TravelImpress[city3]']",".tg_city3");
                            </script>
                        </div>
                    </div>

                    <p>
                        <span class="tg_title">类型</span>
                        <?= Html::activeDropDownList($model, 'type', Yii::$app->params['impress_type'], ['class' => 'mess-select']) ?>
    <!--                    <input type="text" value="--><?php //echo Yii::$app->params['impress_type'][$model->type]; ?><!--">-->
                    </p>

                    <span style="float: left;margin-left:25px;" class="tg_title">内容简介</span>
                    <textarea name="TravelImpress[des]" class="cont" onkeyup="$('.zi').html($('.cont').val().length)" style="border: 1px solid #ccc;width:65%;min-height:175px;margin-left:20px;float: left;background: #fff;padding:10px 5px;" maxlength="60"><?php echo str_replace("<br>","\n",$model->des); ?></textarea>
<!--                    <span class="zi" style="position: absolute;left: 500px;top: 100px;">0/60</span>-->
                    <div style="clear:both;"></div>
                    <span style="float: left;margin-left:51px;margin-top:20px;" class="tg_title">内容</span>
                    <div class="conting">
                        <textarea style="height: 700px;" name="TravelImpress[content]" id="editor"><?=$model->content?></textarea>
                    </div>
                    <div class="music address">
                        <input type="hidden" name="_mp3" value="<?=$model->music?>" />
                        <span class="tg_title">背景音乐<br/>(选填一首)</span>
                        <button type="button" class="xuanze">选择音乐</button>
                        <p class="lianjei"></p>
                        <input class="butshanchu" type="button" name="" id="btnClear" style="margin-top:8px;" value="删除"/>
                    </div>
                    <div class="contimg" style="width:375px;margin-left:100px;background: #fff;padding:10px 5px;margin-top:25px;padding-left:6px;padding:0 15px;overflow-x: hidden; ">
                        <p class="div-sxh2">

                            <span></span>
                            <?php if ($model['music']): ?>
                                <audio src="<?php echo $model['music'] ?>

        " controls="controls">
                                    Your browser does not support the audio element.
                                </audio>

                            <?php endif ?>
                        </p>
                    </div>
                    <div style="clear:both;"></div>
                </div>
            </div>
            <div class="submitbtn">
                    <button class="submit" style="background: #169bd5;color: white;border: none;margin-right: 100px;">保存</button>
                    <a href="<?=Url::to('index')?>" class="btn-cancle">取消</a>
            </div>
        </form>

    </div>
</div>
</body>
<div class="activity_layer">
    <div class="layer_con">
        <p class="layer_conp">
            确认删除
        </p>
        <p class="layer_conp layer_conp2">
            确认删除此音乐么？
        </p>
        <div class="foot">
            <button class="left_btn left">取消</button>
            <button class="right_btn right">确定</button>
        </div>
    </div>
</div>
<div class="activity_layer2">
    <div class="layer_con">
        <div class="layer_con2">
            <div class="lianjieyin">
                <span>音乐链接</span>
                <span>本地上传</span>
            </div>
            <!--音乐链接内容-->
            <div class="active">
                <div class="lianjie-bottom">
                    <p class="lianjie-box">
                        <span>音乐链接：</span>
                        <input type="text" id="text1" style="outline: none;" />

                    </p>
                    <p class="foot">
                        <button class="left left1">取消</button>
                        <button class="right right1">确定</button>
                    </p>
                </div>
                <!--本地上传内容-->
                <div class="lianjie-bottom2">
                    <p class="lianjie-box">
                    <p style="background: none;position: relative;">
                    <div class="file-box" style="display: block;width:84%;margin-left:12%;">
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type='button' style="height:30px;" class='btn' value='浏览...' />
                            <input type='text' name='' id='textfield' class='txt' style="width:70%;height:30px;line-height: 30px;" />
                            <input type="file" name="mp3" class="file" id="fileField" size="28"  onchange="document.getElementById('textfield').value=this.value" />
                        </form>
                    </div>
                    </p>
                    </p>
                    <p class="foot">
                        <button class="left left2">取消</button>
                        <button class="right right2">确定</button>
                    </p>
                    <script>
                        $(document).ready(function() {
                            $(".active div").eq(0).addClass("on")
                            $(".lianjieyin span").click(function() {
                                $(".active div").eq($(".lianjieyin span").index(this)).addClass("on").siblings().removeClass('on');
                            });
                        })
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".xuanze").click(function() {
        $(".activity_layer2").addClass("displaynon2")
//				音乐链接取消 确定按钮
        $(".txt").bind("input change", function() {
            alert($(this).val());
        });
        $(".left1").click(function() {
            $(".activity_layer2").removeClass("displaynon2")
        })
        $(".right1").click(function() {
            if($("#text1").val() == ""){
                layer.alert("请添加音乐!")
                return false;
            }
            var text1 = $("#text1").val();
            $(".lianjei").text(text1)
            $(".lianjei").append('<input type="hidden" name="mp3" value="'+text1+'"/>')
            //					test.after(test.clone().val(""));

            $(".activity_layer2").removeClass("displaynon2")
            if(text1 != "") {
                $(".butshanchu").css({
                    "display": "block"
                })
            }
        })
//				本地上传取消确定按钮
        $(".left2").click(function() {
            $(".activity_layer2").removeClass("displaynon2")
        })

        $(".right2").click(function() {
            if($("#textfield").val() == ""){
                layer.alert("请添加音乐!")
                return false;
            }
            var txtval = $(".txt").val();
            var ldot = txtval.lastIndexOf(".");
            var type = txtval.substring(ldot + 1);

            if(type != "mp3"&&type != "flac"&&type != "ape"&&type != "wav"&&type != "aac"&&type != "ogg"&&type != "wma") {
//                        $(".right2").addClass("hui")
                //清除当前所选文件
                layer.open({
                    content: '音乐格式不正确',
                });
                return false;

                //						input.outerHTML = input.outerHTML.replace(/(value=\").+\"/i, "$1\"");
            }else{
                $(".lianjei").html("")
                var text2=$(".txt").clone()
                var text3=$(".file").clone()
                //					test.after(test.clone().val(""));
                $(".lianjei").html(text2)
                $(".lianjei").append(text3)
                $(".activity_layer2").removeClass("displaynon2")
                if($(".txt").val() != "") {
                    $(".butshanchu").css({
                        "display": "block"
                    })
                }
            }

        })

    })
    $("#btnClear").click(function() {
        $(".activity_layer").addClass("displaynon2")

        $(".left_btn").click(function() {
            $(".activity_layer").removeClass("displaynon2")
        })

        $(".right_btn").click(function() {
            $(".lianjei").text('')
            $(".butshanchu").css({
                "display": "none"
            })
            $(".activity_layer").removeClass("displaynon2")
        })

    })
    function getObjectURL(file) {
        var url = null;
        if (window.createObjectURL != undefined) { // basic

            url = window.createObjectURL(file);
        } else if (window.URL != undefined) { // mozilla(firefox)

            url = window.URL.createObjectURL(file);
        } else if (window.webkitURL != undefined) { // webkit or chrome

            url = window.webkitURL.createObjectURL(file);
        }
        return url;
    }
</script>
<script>
    $(".submit").on("click", function(){
        var facepic_num = $(".zp ul li").length;
        var impress_name = $("input[name='TravelImpress[name]']").val();
        var city_name = $("input[name='TravelImpress[city1]']").val();
        var contentdes = $("textarea[name='TravelImpress[des]']").val();

        if(facepic_num < 2){
            layer.alert("最少上传一张封面照片!")
            return false;
        }
        if(impress_name == ""){
            layer.alert("名称不能为空!");
            return false;
        }
        if(city_name == ""){
            layer.alert("第一个城市为必选!");
            return false;
        }
        if(contentdes == ""){
            layer.alert("请填写内容简介!");
            return false;
        }
    })
//    加载富文本编辑器
    var ue = UE.getEditor('editor');

//    2017年5月26日11:51:02 xhh修改了图片变形问题
    $(".contimg").find("img").css({
        "height":"auto"
    })
</script>
