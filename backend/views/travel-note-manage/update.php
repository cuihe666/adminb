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
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/commodity-change/uploadify/uploadify.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/commodity-change/css/travel-impress-manage-change.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/shenhe.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/commodity-change/uploadify/jquery.uploadify.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/commodity-change/js/zm-canvas-crop2.js"></script>
<script language="javascript" type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/commodity-change/js/My97DatePicker/WdatePicker.js"></script>
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
    .cont-img img{
        float:left;
        margin-bottom:10px;
    }
    .label{
        color:#000000 !important;
    }

    .contgl span{
        width:auto !important;
    }
    .contgl img{
        max-width:100% !important;

    }
    .part_two{
        height:auto;
    }
    #edui1_iframeholder{
        height: 594px!important;
    }
    #edui1_iframeholder .view{
        overflow-y: auto!important;
    }
    textarea{outline:none;resize:none;}

    .part_two .right-r{
        float:inherit;
    }
    .part_two .right-l{
        float:inherit;
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
/*2017年5月17日17:53:53 xhh修改了旅游审核的视频宽度*/
    video{
        width:100%;
    }
    /*2017年5月18日12:11:11 xhh查看图片插件样式*/
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
    /*.layer5{*/
    /*position:relative;*/
    /*}*/
    .layer5 .btn_sf{
        position:absolute;
        left:0;
        bottom:15%;
        width:100%;
        z-index:5;

    }
    .layer5 .btn_sf button{
        /*display:none;*/
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
    #city1{
        margin-left: 20px;
        margin-top: -14px;
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
<body>
<div class="shenhe-sxh">
    <div class="left">

    </div>
    <div class="right">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="part_one">
                <div class="top">
                    <p>
                        <b>
                            ID:<?php echo $model['id'] ?>
                        </b>
                    </p>
                </div>
                <div class="rignt-con">
                    <div class="div-sxh2 zp">
                        <span>封面图片</span>
                            <span style="width:80%;" class="cont-img">
                                <input type="hidden" name="TravelNote[first_pic]" id="hidden_canvas" value="<?=$model['first_pic']?>" >
                                <ul class="dowebok1" style="margin: 0 0 10px 8px;">
                                    <?php
                                    $title_pics = explode(',', $model['pic']);
                                    if ($model['pic']) {
                                        ?>
                                    <?php
                                        foreach ($title_pics as $k => $v) { ?>
                                                <li class="total_div tg_st">
                                                    <img data-original="<?php echo $v ?>" src="<?php echo $v ?>" alt="">
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
                    <div style="clear:both;"></div>
                    <p style="margin-top:20px;">
                        <span>攻略名称</span>
                        <input maxlength="30" name="TravelNote[name]" style="min-width:65%;" type="text" value="<?php echo htmlspecialchars($model['name']) ?>">
                    </p>
                    <div style="height: 30px; line-height: 30px; margin-bottom: 20px; clear: both;  position:relative;">
                        <span class="tg_title" style="float: left; width: 60px; text-align: right;">相关城市</span>
                        <div class="add-address" style="float:left;">
                            <div style="float:left; margin-right:10px;" class="tg_city1">
                                <input type="text" id="TravelNote[city1]" class="city1" name="city1" value="<?php echo \backend\models\TravelActivity::getcity($model->city1)?>" style="width: 280px;" maxlength="30" placeholder="请输入城市名称（必填）" autoComplete= "Off" />
                                <input type="hidden" name="TravelNote[city1]" class="cityhid" value="<?php echo $model->country1.",".$model->province1.",".$model->city1?>" <?php echo intval($model->city1) != 0 ? 'tg="1"' : 'tg="0"'?>  />
                                <i style="margin-left:0;"><?= Html::error($model, 'city1') ?></i>
                            </div>
                            <div style="float:left; margin-right:10px;" class="tg_city2">
                                <input type="text" id="" class="city1" name="city2" value="<?php echo \backend\models\TravelActivity::getcity($model->city2)?>" style="width: 280px;" maxlength="30" placeholder="请输入城市名称（选填）" autoComplete= "Off" />
                                <input type="hidden" name="TravelNote[city2]" class="cityhid" value="<?php echo $model->country2.",".$model->province2.",".$model->city2?>" <?php echo intval($model->city1) != 0 ? 'tg="1"' : 'tg="0"'?>  />
                            </div>
                            <div style="float:left;" class="tg_city3">
                                <input type="text"  id="" class="city1" name="city3" value="<?php echo \backend\models\TravelActivity::getcity($model->city3)?>" style="width: 280px;" maxlength="30" placeholder="请输入城市名称（选填）" autoComplete= "Off" />
                                <input type="hidden" name="TravelNote[city3]" class="cityhid" value="<?php echo $model->country3.",".$model->province3.",".$model->city3?>" <?php echo intval($model->city3) != 0 ? 'tg="1"' : 'tg="0"'?>  />
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
                                tgCity("input[name='TravelNote[city1]']",".tg_city1");
                                tgCity("input[name='TravelNote[city2]']",".tg_city2");
                                tgCity("input[name='TravelNote[city3]']",".tg_city3");
                            </script>
                        </div>
                    </div>


                    <p>
                        <span>出游时间</span>
                        <input readonly id="d4311" name="TravelNote[start_time]" value="<?php echo  substr($model->start_time,0,10); ?>" class="Wdate inp1" type="text"  onFocus="WdatePicker({minDate: new Date(), maxDate: $('#data-date').attr('end-date')})"/>
                        到
                        <input readonly id="d4312" name="TravelNote[end_time]" value="<?php echo  substr($model->end_time,0,10); ?>" class="Wdate" type="text" onFocus="WdatePicker({minDate: '#F{$dp.$D(\'d4311\')}',maxDate: $('#data-date').attr('end-date')})"/>
                        共
                        <input readonly id="mistiming" name="TravelNote[day_count]" style="text-align: center;width: 80px;" type="text" value="<?php echo ( strtotime($model->end_time) - strtotime($model->start_time))/60/60/24 +1 ?>">
                        天
                    </p>
                    <script>
                        $("#d4311").on("blur", function(){
    //                        console.log(new Date($(this).val()).getTime())
                            if(new Date($(this).val()).getTime() > new Date($("#d4312").val()).getTime()){
                                $(this).css("color", "red");
                                $("#mistiming").val(0);
                            }else{
                                $(this).css("color", "black");
                                $("#d4312").css("color", "black");
                                var start = new Date($(this).val()).getTime();
                                var end = new Date($("#d4312").val()).getTime();
                                $("#mistiming").val(parseInt((end - start) / (1000 * 60 * 60 * 24)))
                            }
                        })
                        $("#d4312").on("blur", function(){
                            if(new Date($(this).val()).getTime() < new Date($("#d4311").val()).getTime()){
                                $(this).css("color", "red");
                                $("#mistiming").val(0)
                            }else{
                                $(this).css("color", "black");
                                $("#d4311").css("color", "black");
                                var start = new Date($("#d4311").val()).getTime();
                                var end = new Date($(this).val()).getTime();
                                $("#mistiming").val(parseInt((end - start) / (1000 * 60 * 60 * 24)))
                            }
                        })
                    </script>
                    <p>
                        <span>出游形式</span>
                        <?= Html::activeDropDownList($model, 'type', [0 => '自由行', 1 => '半自由', 2 => '跟团', 3 => '徒步',4 => '自驾',5 => '游轮',6 => '骑行'], ['class' => 'mess-select']) ?>
                    </p>

                    <p>
                        <span>人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;物</span>
                        <?= Html::activeDropDownList($model, 'people_type', [0 => '一个人', 1 => '小两口', 2 => '亲子游', 3 => '带父母',4 => '好朋友',5 => '其他'], ['class' => 'mess-select']) ?>
                    </p>
                    <p>
                        <span>人均价格</span>
                        <input name="TravelNote[price]" style="width: 80px;" type="number" value="<?php echo $model['price'] ?>"><span style="margin-left: 10px;">元</span>
                    </p>
                    <script>
                        $("input[name='TravelNote[price]']").on("keyup", function(){
                            if($("input[name='TravelNote[price]']").val().length > 7){
                                $("input[name='TravelNote[price]']").val(999999.99)
                            }
                        })
                    </script>
                    <div>
                        <span style="float: left; width: 80px;">攻略内容</span>
                        <div style=" float:left;width:1000px;" class="contgl">
                            <textarea style="height: 700px;" name="TravelNote[content]" id="editor"><?=$model->content?></textarea>
                        </div>
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
<script>
    $(".submit").on("click", function(){
        var facepic_num = $(".zp ul li").length;
        var note_name = $("input[name='TravelNote[name]']").val();
        var note_city1 = $("input[name='TravelNote[city1]']").val();
        var note_price = $("input[name='TravelNote[price]']").val();

        if(facepic_num < 2){
            layer.alert("至少上传一张照片!");
            return false;
        }
        if(note_name == ""){
            layer.alert("游记名称不能为空!");
            return false;
        }
        if(note_city1 == ""){
            layer.alert("第一个城市为必填!");
            return false;
        }
        if(note_price == ""){
            layer.alert("人均价格不能为空!");
            return false;
        }
    })
    //    加载富文本编辑器
      var ue = UE.getEditor("editor");

    $(".contgl").find("img").css({
        "height":"auto"
    })
</script>
