<?php
use yii\helpers\Url;

$this->title = '查看基本信息';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\ScrollAsset::register($this);
?>

<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/shenhe_sxh.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/viewer.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/shenhe.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>
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
        font-weight: "Microsoft Yahei";
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
</style>

</head>

<body>
<!--2017年6月23日15:21:02 xhh给图片添加放大功能-->
<input type="hidden" value="" id="w_input">
<input type="hidden" value="" id="h_input">
<div class="layer5">
    <div class="layer_con">
        <div  id="div1">
<!--            <input name="images1" type="image" id="images1" class="record_bj" src="" align="middle" onmousewheel="return bbimg(this)" border="0">-->
            <img src="" alt="" onmousewheel="return bbimg(this)" class="record_bj" id="images1" >
<!--            <img src="" alt="" class="yin_pic">-->
        </div>
    </div>
    <img src="/images/close.png" alt="" class="close">
    <p align="center" class="btn_sf">
        <button style="margin-right:10px;padding:2px 5px;margin-top:3px;border-radius: 3px;">1:1</button>
        <img src="<?= Yii::$app->request->baseUrl ?>/images/btn_pic_add.png" alt="" onclick="blowup()" style="margin-right:10px;">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/btn_pic_jian.png" alt="" onclick="reduce()">
    </p>

    <script>
//        点击图片放大缩小 sxh 2017年6月27日14:13:46
        function blowup()
        {
            var height = $("#div1 .record_bj").height();
            var width = $("#div1 .record_bj").width();
            console.log(width)


            var div_h = $("#div1").height();
            var div_w = $("#div1").width();
            var radio = height/width;


            if ((height <= height * 2)||(width <= width * 2))
            {
                $("#div1 .record_bj").height(height+20);
                $("#div1 .record_bj").width((height+20)/radio);
                if(height>div_h){
                    $("#div1").css("overflow-y","scroll");
                }
                if(width>div_w){
                    $("#div1").css("overflow-x","scroll");
                }

            }
        }
        function reduce()
        {
            var height = $("#div1 .record_bj").height();
            var width = $("#div1 .record_bj").width();



            var div_h = $("#div1").height();
            var div_w = $("#div1").width();
            var radio = height/width;


            if ((width > 100)||(height > 100))
            {
                $("#div1 .record_bj").height(height-20);
                $("#div1 .record_bj").width((height-20)/radio);

                if(height<div_h){
                    $("#div1").css("overflow-y","inherit")
                }
                if(width<div_w){
                    $("#div1").css("overflow-x","inherit")
                }

            }
        }

        function bbimg(o){
            var zoom=parseInt(o.style.zoom, 10)||100;
            zoom+=event.wheelDelta/12;
            if (zoom>0) o.style.zoom=zoom+'%';
            console.log(o.style.zoom)
            if(o.style.zoom>"200%"){
                $("#div1").css("overflow-x","scroll");
                $("#div1").css("overflow-y","scroll");
            }else{
                $("#div1").css("overflow-x","inherit")
                $("#div1").css("overflow-y","inherit")
            }
            return false;
        }

    </script>

</div>
<div class="shenhe-sxh">
    <div class="left">

    </div>
    <div class="right">
        <div class="part_one">
            <div class="top">
                <p>
                    <b>
                        序号:<?php echo $model['id'] ?>
                    </b>
                </p>
                <hr>
            </div>
            <div class="rignt-con">
                <p class="div-sxh2">
                    <span class="tg_title">封面图片</span>
                    <span style="width:80%;" class="cont-img">
                         <ul class="dowebok1">
                        <?php
                        $title_pics = explode(',', $model['pic']);
                        if ($model['pic']) {
                            ?>
                            <li>
                                <img data-original="<?php echo $title_pics[$model['first_pic']] ?>" src="<?php echo $title_pics[$model['first_pic']] ?>" alt="">
                            </li>
                            <?php
                            foreach ($title_pics as $k => $v) {
                                if ($k != $model['first_pic']) {
                                    ?>
                                    <li><img data-original="<?php echo $v ?>" src="<?php echo $v ?>" alt=""></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                      </ul>
                    </span>
                </p>
                <div style="clear: both;"></div>
                <p>
                    <span class="tg_title">名称</span>
                    <input type="text" value="<?php echo htmlspecialchars($model['name']) ?>" readonly style="min-width:65%;">
                </p>
                <p>
                    <span class="tg_title">相关城市</span>
                    <?php if ($model['city1']): ?>
                        <input type="text"
                               value="<?php echo \backend\models\TravelActivity::getcity($model['city1']) ?>" readonly>
                    <?php endif ?>
                    <?php if ($model['city2']): ?>
                        <input type="text"
                               value="<?php echo \backend\models\TravelActivity::getcity($model['city2']) ?>" readonly>
                    <?php endif ?>
                    <?php if ($model['city3']): ?>
                        <input type="text"
                               value="<?php echo \backend\models\TravelActivity::getcity($model['city3']) ?>" readonly>
                    <?php endif ?>
                </p>

                <p>
                    <span class="tg_title">类型</span>
                    <input type="text" value="<?php echo Yii::$app->params['impress_type'][$model->type]; ?>" readonly>
                </p>

                <span style="float: left;margin-left:25px;" class="tg_title">内容简介</span>
                <textarea
                    style="width:65%;min-height:175px;margin-left:20px;float: left;background: #fff;padding:10px 5px;border: 1px solid #ccc;" readonly><?php echo str_replace("<br>","\n",$model->des); ?></textarea>
                <div style="clear:both;"></div>
                <span style="float: left;margin-left:51px;margin-top:20px;" class="tg_title">内容</span>
                <div class="contimg"
                     style="width:375px;border: 1px solid #ccc;margin-left:100px;background: #fff;padding:10px 5px;margin-top:25px;padding-left:6px;padding:0 15px;overflow-x: hidden; ">
                    <p class="div-sxh2">
                    <div><?php echo $model['content'] ?></div>

                    </p>

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
        <div class="part_two">
            <div class="top">
                <p>
                    <b>
                        操作日志
                    </b>
                </p>
                <hr>
                <div style="clear:both;"></div>
                <?php if (!empty($logs['list'])): ?>
                    <div class="right-r">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td>时间</td>
                                <td>操作人</td>
                                <td>操作内容</td>
                                <td>原因</td>
                                <td>备注</td>
                            </tr>
                            <?php foreach ($logs['list'] as $k => $v): ?>
                                <tr>
                                    <td><?php echo $v['create_time'] ?></td>
                                    <td><?php echo $v['uname'] ?></td>
                                    <td>
                                        <?php
                                        if ($v['status'] == 1) {
                                            echo '通过审核/上线';
                                        } elseif ($v['status'] == 2) {
                                            echo '下线';
                                        } elseif ($v['status'] == 3) {
                                            echo '未通过审核';
                                        } elseif ($v['status'] == 8) {
                                            echo '修改信息';
                                        } elseif ($v['status'] == 9) {
                                            echo '修改排序';
                                        }
                                        ?>
                                    </td>
                                    <td style="word-break: break-all"><?php echo $v['reason'] ?></td>
                                    <td><?php echo $v['remarks'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif ?>
                <div class="right-l-btn">
                    <a href="<?php echo Yii::$app->request->getReferrer() ?>" class="btn1"><button type="button" class="btn1">返回</button></a>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div>
</div>
<script>
//    2017年5月26日11:51:02 xhh修改了图片变形问题
    $(".contimg").find("img").css({
        "height":"auto"
    })
</script>
<script>
//   2017年6月23日15:21:02 xhh给图片添加放大功能
    $(".contimg img").click(function() {
        $(".layer_con img").css({
            "width": "auto",
            "height": "auto"
        })
        var pic_h = $(this).height();
        var pic_w = $(this).width();
        console.log(pic_h)
        console.log(pic_w)
        $(".layer5 .btn_sf button").click(function(){
            $("#div1").css("overflow-x","inherit");
            $("#div1").css("overflow-y","inherit");
            $("#div1 .record_bj").width(pic_w)
            $("#div1 .record_bj").height(pic_h)
        })

        var win_width = $("body").width()
        $(".layer5").show();
        var this_src = $(this).attr("src");
//        $(".layer_con input").attr("src", this_src);
        $(".layer_con img").attr("src", this_src);
        var this_width = $(".record_bj").width();
        var this_height = $(".record_bj").height();
        if(this_width > win_width) {
            if(this_width >= this_height) {
                $(".layer_con img").css({
                    "width": "80%",
                    "height": "auto"
                })
            } else {
                $(".layer_con img").css({
                    "width": "auto",
                    "height": "80%"
                })
            }
        } else {
            if(this_width >= this_height) {
                $(".layer_con img").css({
                    "width": "auto",
                    "height": "auto"
                })
            } else {
                $(".layer_con img").css({
                    "width": "auto",
                    "height": "80%"
                })
            }
        }
        $("body").css("overflow", "hidden");
        $(".close").click(function() {
            $(".layer5").hide();
            $("body").css("overflow", "scroll");
        })
    })

</script>
<!--2017年5月18日11:51:55 替换公司资质和个人资质的图片查看插件-->
<script>
    $(function() {
        var length = $(".dowebok1").length;
        for(var i = 0; i < length; i++) {
            var viewer = new Viewer(document.getElementsByClassName('dowebok1')[i], {
                url: 'data-original'
            });
        }
    })
</script>