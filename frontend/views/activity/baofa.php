<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>棠果旅居节 优惠嗨不停</title>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/lvjujie.css"/>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/reset.css"/>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/swiper-3.3.1.min.css"/>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/swiper.jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/lvjujie.js"></script>

    <script type="text/javascript">
        $(function () {
            $(".layer6 .close,.layer5 .close").css("bottom", "1rem");
            $(".layer6 .record_bj，.layer5 .record_bj").css("top", "4.425rem");
        })
        document.addEventListener('plusready', function () {
            //console.log("所有plus api都应该在此事件发生后调用，否则会出现plus is undefined。"

        });
    </script>
</head>

<style>
    /*2017年6月30日18:57:22 sxh 加蒙层*/
    .mongolia {
        position: relative;
        height: 7.5rem;
    }

    .mongolia span {
        position: absolute;
        left: 0;
        top: 0;
        z-index: 2;
        width: 100%;
        display: block;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        text-align: center;
    }

    .mongolia span img {
        width: 75px;
        height: 75px;
        margin-top: 2.5rem;
        margin-left: 40%;
    }

    .mongolia .seal_layer, .mongolia .shop_layer, .mongolia .finish_layer {
        display: none;
    }

    .current_mongolia-show {
        display: block;
    }
</style>
<script>
    //        2017年6月30日19:32:51 sxh 加蒙层
    if ($(".mongolia .seal_layer").hasClass("current_.current_mongolia-show")) {
        $(".price").css("color", "#acacac");
        $(".condition").css("color", "#acacac")
    } else {
        $(".price").css("color", "#ff4c4c");
        $(".condition p").css("color", "#333")
    }
    if ($(".mongolia .shop_layer").hasClass("current_.current_mongolia-show")) {
        $(".price").css("color", "#acacac");
        $(".condition").css("color", "#acacac")
    } else {
        $(".price").css("color", "#ff4c4c");
        $(".condition p").css("color", "#333")
    }
</script>
<script>
    function login(url) {
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1; //android终端
        var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
        if (isdiOS) {
            function showIosToast() {
                window.webkit.messageHandlers.userLogin.postMessage(url);
            }

            showIosToast();
        }
        if (isAndroid) {
            function showAndroidToast() {
//                javascript:jsandroid.alipay();
                window.h5Interface.toLogin();
            }

            showAndroidToast();
        }
    }


    function detail(str) {
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1; //android终端
        var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
        if (isdiOS) {
            function showIosDetail() {
                window.webkit.messageHandlers.showDetail.postMessage(str);
            }

            showIosDetail();
        }
        if (isAndroid) {
            function showAndroidDetail() {
                if (str.type == 1) {
                    window.h5Interface.toDetailActivity(str.type, str.house_id);
                }
                if (str.type == 2) {
                    window.h5Interface.toDetailActivity(str.type, str.local_id);
                }
                if (str.type == 3) {
                    window.h5Interface.toDetailActivity(str.type, str.higo_id);
                }
            }

            showAndroidDetail();
        }
    }
    //        点击优惠券弹出层
    $(function () {
//            $(".stereogram01").click(function(){
//                if($(this).hasClass("over_click")){
//                    $(".layer6").show();
//                    $(".layer6 .layer_con img").attr("src","/images/layer_receive.png")
//                    $(".layer6 .close").click(function(){
//                        $(".layer6").hide();
//                        $(".over_click .finish_layer").show()
//                        $(".over_click .price span").css("color","#acacac");
//                        $(".over_click .condition p").css("color","#acacac")
//                    })
//
//
//                }else{
//                    $(this).addClass("over_click");
//                    $(".layer6").show();
//                    $(".layer6 .close").click(function(){
//                        $(".layer6").hide();
//                        $(".layer6 .layer_con img").attr("src","/images/layer_6.png")
//
//                        $(".over_click .finish_layer").hide()
//                        $(".over_click .price span").css("color","#ff4c4c");
//                        $(".over_click .condition p").css("color","#333")
//                    })
//
//                }
//
//            })
        $('.baopin_no1').click(function () {
            var This = $(this);
            var uid = $('.uid').val();
            var type = $('.mode').val();
            var pro_type = $(this).attr('pro_type');
            var pro_id = $(this).attr('pro_id');
            var baopin1_status = $('.baopin1').val();
            var batch_id = $(this).attr('batch_id');
            if (uid == 0) {
                if (type == 'h5') {
                    location.href = "<?php echo \yii\helpers\Url::to(['user/login']) ?>";
                    return;
                } else {
                    var url = window.location.href;
                    login(url);
                }
            } else {
                if (baopin1_status == 0) {
                    return false;
                }
                if (baopin1_status == 3) {
                    return false;
                }
                if (baopin1_status == 1) {
                    $(".layer6").show();
                    $(".layer6 .layer_con img").attr("src", "/images/layer_receive.png");
                    $(".layer6 .close").click(function () {
                        $(".layer6").hide();
                        $(".price span").css("color", "#acacac");
                        $(".condition p").css("color", "#acacac")
                    })
                    $('.record_bj').click(function () {
                        if (type == 'h5') {
                            if (pro_type == 'travel') {
//                                var url = "http://106.14.16.252:8088/indexdk/detail?higo_id=" + pro_id + '&resource=78';
                                var url="http://lvcheng.tgljweb.com/indexdk/detail?higo_id="+pro_id+'&resource=78';
                                location.href = url;
                                return;
                            } else {
                                location.href = "http://www.xywykj.com/";
                                return;
                            }
                        } else {
                            if (pro_type == 'travel') {
                                var str = {higo_id: pro_id, type: 3};
                                detail(str);
                            } else {
                                var str = {house_id: pro_id, type: 1};
                                detail(str);
                            }
                        }
                    })
                }
                if (baopin1_status == 2) {
                    if ($(this).hasClass("over_click")) {
                        $(".layer6").show();
                        $(".layer6 .layer_con img").attr("src", "/images/layer_receive.png");
                        $('.record_bj').click(function () {
                            if (type == 'h5') {
                                if (pro_type == 'travel') {
//                                    var url = "http://106.14.16.252:8088/indexdk/detail?higo_id=" + pro_id + '&resource=78';
                                    var url="http://lvcheng.tgljweb.com/indexdk/detail?higo_id="+pro_id+'&resource=78';
                                    location.href = url;
                                    return;
                                } else {
                                    location.href = "http://www.xywykj.com/";
                                    return;
                                }
                            } else {
                                if (pro_type == 'travel') {
                                    var str = {higo_id: pro_id, type: 3};
                                    detail(str);
                                } else {
                                    var str = {house_id: pro_id, type: 1};
                                    detail(str);
                                }
                            }
                        })
                    } else {
                        $.ajax({
                            type: 'post',
                            url: "<?php echo \yii\helpers\Url::to(['get-special']) ?>",
                            data: {
                                uid: uid,
                                batch_id: batch_id,
                                "_csrf-frontend": "<?php echo Yii::$app->request->csrfToken ?>"
                            },
                            success: function (data) {
                                if (data == 1) {
                                    This.addClass("over_click");
                                    $(".layer6").show();
                                    $(".layer6 .layer_con img").attr("src", "/images/layer_6.png");
                                    $(".layer6 .close").click(function () {
                                        if (!This.find('.finish_layer').length) {
                                            var obj = '<span class="finish_layer" style="display: block"><img src="/images/baofa_finish.png" ></span>';
                                            This.find('.mongolia').append(obj);
                                        }
                                        $(".layer6").hide();
                                        $('.over_click .price span').css("color", "#acacac");
                                        $(".over_click .condition p").css("color", "#acacac")
                                    })
                                    $('.record_bj').click(function () {
                                        if (type == 'h5') {
                                            if (pro_type == 'travel') {
//                                                var url = "http://106.14.16.252:8088/indexdk/detail?higo_id=" + pro_id + '&resource=78';
                                               var url="http://lvcheng.tgljweb.com/indexdk/detail?higo_id="+pro_id+'&resource=78';
                                                location.href = url;
                                                return;
                                            } else {
                                                location.href = "http://www.xywykj.com/";
                                                return;
                                            }
                                        } else {
                                            if (pro_type == 'travel') {
                                                var str = {higo_id: pro_id, type: 3};
                                                detail(str);
                                            } else {
                                                var str = {house_id: pro_id, type: 1};
                                                detail(str);
                                            }
                                        }
                                    })
                                }
                            }
                        })
                    }
                }
            }
        })


        $('.baopin_no2').click(function () {
            var This = $(this);
            var uid = $('.uid').val();
            var type = $('.mode').val();
            var pro_type = $(this).attr('pro_type');
            var pro_id = $(this).attr('pro_id');
            var baopin2_status = $('.baopin2').val();
            var batch_id = $(this).attr('batch_id');
            if (uid == 0) {
                if (type == 'h5') {
                    location.href = "<?php echo \yii\helpers\Url::to(['user/login']) ?>";
                    return;
                } else {
                    var url = window.location.href;
                    login(url);
                }
            } else {
                if (baopin2_status == 0) {
                    return false;
                }
                if (baopin2_status == 3) {
                    return false;
                }
                if (baopin2_status == 1) {
                    $(".layer6").show();
                    $(".layer6 .layer_con img").attr("src", "/images/layer_receive.png");
                    $(".layer6 .close").click(function () {
                        $(".layer6").hide();
                        $(".price span").css("color", "#acacac");
                        $(".condition p").css("color", "#acacac")
                    })
                    $('.record_bj').click(function () {
                        if (type == 'h5') {
                            if (pro_type == 'travel') {
//                                var url = "http://106.14.16.252:8088/indexdk/detail?higo_id=" + pro_id + '&resource=78';
                                var url="http://lvcheng.tgljweb.com/indexdk/detail?higo_id="+pro_id+'&resource=78';
                                location.href = url;
                                return;
                            } else {
                                location.href = "http://www.xywykj.com/";
                                return;
                            }
                        } else {
                            if (pro_type == 'travel') {
                                var str = {higo_id: pro_id, type: 3};
                                detail(str);
                            } else {
                                var str = {house_id: pro_id, type: 1};
                                detail(str);
                            }
                        }
                    })
                }
                if (baopin2_status == 2) {
                    if ($(this).hasClass("over_click")) {
                        $(".layer6").show();
                        $(".layer6 .layer_con img").attr("src", "/images/layer_receive.png");
                        $('.record_bj').click(function () {
                            if (type == 'h5') {
                                if (pro_type == 'travel') {
//                                    var url = "http://106.14.16.252:8088/indexdk/detail?higo_id=" + pro_id + '&resource=78';
                                    var url="http://lvcheng.tgljweb.com/indexdk/detail?higo_id="+pro_id+'&resource=78';
                                    location.href = url;
                                    return;
                                } else {
                                    location.href = "http://www.xywykj.com/";
                                    return;
                                }
                            } else {
                                if (pro_type == 'travel') {
                                    var str = {higo_id: pro_id, type: 3};
                                    detail(str);
                                } else {
                                    var str = {house_id: pro_id, type: 1};
                                    detail(str);
                                }
                            }
                        })
                    } else {
                        $.ajax({
                            type: 'post',
                            url: "<?php echo \yii\helpers\Url::to(['get-special']) ?>",
                            data: {
                                uid: uid,
                                batch_id: batch_id,
                                "_csrf-frontend": "<?php echo Yii::$app->request->csrfToken ?>"
                            },
                            success: function (data) {
                                if (data == 1) {
                                    This.addClass("over_click");
                                    $(".layer6").show();
                                    $(".layer6 .layer_con img").attr("src", "/images/layer_6.png");
                                    $(".layer6 .close").click(function () {
                                        if (!This.find('.finish_layer').length) {
                                            var obj = '<span class="finish_layer" style="display: block"><img src="/images/baofa_finish.png" ></span>';
                                            This.find('.mongolia').append(obj);
                                        }
                                        $(".layer6").hide();
                                        This.find('.price span').css("color", "#acacac");
                                        $(".condition p").css("color", "#acacac")
                                    })
                                    $('.record_bj').click(function () {
                                        if (type == 'h5') {
                                            if (pro_type == 'travel') {
//                                                var url = "http://106.14.16.252:8088/indexdk/detail?higo_id=" + pro_id + '&resource=78';
                                                var url="http://lvcheng.tgljweb.com/indexdk/detail?higo_id="+pro_id+'&resource=78';
                                                location.href = url;
                                                return;
                                            } else {
                                                location.href = "http://www.xywykj.com/";
                                                return;
                                            }
                                        } else {
                                            if (pro_type == 'travel') {
                                                var str = {higo_id: pro_id, type: 3};
                                                detail(str);
                                            } else {
                                                var str = {house_id: pro_id, type: 1};
                                                detail(str);
                                            }
                                        }
                                    })
                                }
                            }
                        })
                    }
                }
            }
        })

    })
</script>
<script>
    $(document).scroll(function () {
        var top = $(document).scrollTop();
//            console.log(top)
        if (top > 0) {
            $(".x_nav").css("background-color", "rgba(0,0,0,0.4)");
            var u = navigator.userAgent;
            var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
            if (isiOS == true) {
                $(".x_nav").css("padding-top", "20px");
                $(".x_nav").css("top", "0");
            } else {
                $(".x_nav").css("padding-top", "0px")
//                $(".x_nav").css("top", "20px")
            }

        } else {
            $(".x_nav").css("background-color", "transparent")
        }
    })
</script>
<script>
    window.onload = function(){
        var u = navigator.userAgent;
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        if (isiOS == true) {
            $(".x_nav").css("top", "20px")
        }else{
            $(".x_nav").css("top", "0")
        }
    }
//        ios判断

    //    var ua = navigator.userAgent.toLowerCase();
    //    if (/iphone|ipad|ipod/.test(ua)) {
    //        $(".x_nav").css("top","100px")
    //    }
</script>


<body>
<!--弹窗-->
<div class="layer5">
    <div class="layer_con">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/layer.png" alt="" class="record_bj">
    </div>
    <img src="<?= Yii::$app->request->baseUrl ?>/images/close.png" alt="" class="close">
</div>
<!--        sxh 7.06 爆发点击优惠券弹出页面-->
<div class="layer6">
    <div class="layer_con">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/layer_6.png" alt="" class="record_bj">
    </div>
    <img src="<?= Yii::$app->request->baseUrl ?>/images/close.png" alt="" class="close">
</div>

<div class="x_content">
    <!--导航栏-->
    <?php if ($_GET['type'] == 'app') { ?>
        <div class="x_nav" style="position:fixed;width:100%;height:60px;z-index:999;font-size:18px;">
            <div class="nav_left absolete">
                <?php if ($_GET['type'] == 'app') { ?>
                    <img class="img_left fanhui" src="<?= Yii::$app->request->baseUrl ?>/images/fanhui.png" alt=""/>
                <?php } ?>
                <p class="x_title color">
                    <span>棠果旅居节 优惠嗨不停</span>
                </p>
                <?php if ($_GET['type'] == 'app') { ?>
                    <img class="img_right share" src="<?= Yii::$app->request->baseUrl ?>/images/share.png" alt=""/>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <!--banner-->
    <div class="x_head">
        <img class="width" src="<?= Yii::$app->request->baseUrl ?>/images/banner.jpg" alt=""/>
    </div>

    <!--    预热 爆发页面banner图时间轴 sxh 7.20-->
    <script>
        var time = new Date();
        var month = time.getMonth() + 1;
        var date = time.getDate();
        if (month == 7 && date == 24) {
            $(".x_head img").attr("src", "/images/banner.jpg")
        } else if (month == 8 && date == 3) {
            $(".x_head img").attr("src", "/images/banner2.jpg")
        } else if (month == 8 && date == 12) {
            $(".x_head img").attr("src", "/images/banner3.jpg")
        }

    </script>
    <div class="x_bj width" style="height:0px;"></div>
    <!--侧边导航-->
    <div class="fixed_nav">
        <div class="height_fade" style="display: none;"></div>
        <div class="hide_nav">
            <div class="fixed_nav_bj">
                <ul class="nav_cont width">
                    <li style="line-height: 1.8rem; border-radius:0.35rem 0.35rem 0 0 ;">领券</li>
                    <li>抽奖</li>
                    <li>东南亚</li>
                    <li>国内精品</li>
                    <li>短途周边</li>
                    <li style="line-height: 2rem; border-radius:0 0 0.35rem 0.35rem;height: 2rem;">精品民宿</li>
                </ul>
            </div>
            <img class="foot_hide" src="<?= Yii::$app->request->baseUrl ?>/images/shouqi.png" alt=""/>
        </div>
    </div>
    <img class="nav_hide libao_posi" style="display: block;" src="<?= Yii::$app->request->baseUrl ?>/images/nav_03.png"
         alt=""/>
    <img class="new_gift" src="<?= Yii::$app->request->baseUrl ?>/images/new_gift.png"
         alt=""/>

    <!--优惠券专区-->
    <div class="offset_top"></div>
    <div class="x_discount width">
        <div class="x_arck_back">
            <p class="arch_title color">
                优惠券专区
            </p>

            <div class="arch_tu">
                <a href="javascript:;" class="arch_07">
                    <?php if ($coupon_1_status == 0) { ?>
                        <img class="coupon_1_no" src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                    <?php } else {
                        ?>
                        <img class="coupon_1_yes" src="<?= Yii::$app->request->baseUrl ?>/images/i_yhq_10.png" alt=""/>
                        <?php
                    }
                    ?>
                </a>
                <a href="javascript:;" class="arch_09">
                    <?php if ($coupon_2_status == 0) { ?>
                        <img class="coupon_2_no" src="<?= Yii::$app->request->baseUrl ?>/images/arch_09.png" alt=""/>
                    <?php } else {
                        ?>
                        <img class="coupon_2_yes" src="<?= Yii::$app->request->baseUrl ?>/images/i_yhq_30.png" alt=""/>
                        <?php
                    }
                    ?>
                </a>
                <a href="javascript:;" class="arch_11">
                    <?php if ($coupon_3_status == 0) { ?>
                        <img class="coupon_3_no" src="<?= Yii::$app->request->baseUrl ?>/images/arch_11.png" alt=""/>
                    <?php } else {
                        ?>
                        <img class="coupon_3_yes" src="<?= Yii::$app->request->baseUrl ?>/images/i_yhq_50.png" alt=""/>
                        <?php
                    }
                    ?>
                </a>
            </div>
            <p class="x_yanze color">
                优惠券使用原则<img src="<?= Yii::$app->request->baseUrl ?>/images/yuan.png" alt=""/>
            </p>
        </div>
    </div>
    <!--限时抢购专区-->
    <div class="x_bj width"></div>
    <!--品类分会场-->

    <div style="height:13.7rem;">
        <div class="x_dial width position">
            <div class="x_dial_title absolete color">
                品类分会场
            </div>
            <div class=" x_new_bj  width"></div>
            <div class="" style="background: #a521fe;">
                <p class="x_dial_title2 color">
                    精彩旅行 梦幻开始
                </p>
                <ul class="x_travel">
                    <li>
                        <img class="gnxl" src="<?= Yii::$app->request->baseUrl ?>/images/gnxl.png" alt=""/>
                    </li>
                    <li>
                        <img class="tsms" src="<?= Yii::$app->request->baseUrl ?>/images/tsms.png" alt=""/>
                    </li>
                    <li>
                        <img class="jdhc" src="<?= Yii::$app->request->baseUrl ?>/images/jdhc.png" alt=""/>
                    </li>
                    <li>
                        <img class="jwjp" src="<?= Yii::$app->request->baseUrl ?>/images/jwjp.png" alt=""/>
                    </li>
                    <li class="li_go">
                        <img class="dazhuanpan" src="<?= Yii::$app->request->baseUrl ?>/images/i_lottery_draw_icon.png"
                             alt=""/>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div style="clear: both;"></div>
    <!--优惠专区-->
    <div class="offset_top"></div>
    <div class="x_bj width"></div>
    <div class="x_privilege width position">
        <div class="x_dial_title absolete color">
            优惠专区
        </div>

        <p class="x_dial_title2 color">
            超值出游
        </p>
        <div class="x_privilege_bj width"></div>
        <div class="x_privilege_cont">
            <!--超值东南亚-->
            <div class="x_loca">
                <div class="loca_dny backsize">超值东南亚</div>
            </div>
            <ul class="width laca_li">
                <li class="current">千佛之国</li>
                <li>森林氧吧</li>
                <li>乐享海岛</li>
            </ul>
            <div class="laca_cont">
                <ul class="width laca_show on travel">
                    <?php foreach ($qianfu_data as $k => $v): ?>
                        <li>
                            <a href="javascript:;" higo_id="<?php echo $v['id']; ?>">
                                <img id="house"
                                     src="<?php echo $v['title_pic'][$v['first_pic']] . '?imageView2/1/w/200/h/150' ?>"
                                     alt=""/>
                                <p>
                                    <?php echo $v['name'] ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price'] ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="width laca_show travel">
                    <?php foreach ($senlin_data as $k => $v): ?>
                        <li>
                            <a href="javascript:;" higo_id="<?php echo $v['id']; ?>">
                                <img id="house"
                                     src="<?php echo $v['title_pic'][$v['first_pic']] . '?imageView2/1/w/200/h/150' ?>"
                                     alt=""/>
                                <p>
                                    <?php echo $v['name'] ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price'] ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="width laca_show travel">
                    <?php foreach ($lexiang_data as $k => $v): ?>
                        <li>
                            <a href="javascript:;" higo_id="<?php echo $v['id']; ?>">
                                <img id="house"
                                     src="<?php echo $v['title_pic'][$v['first_pic']] . '?imageView2/1/w/200/h/150' ?>"
                                     alt=""/>
                                <p>
                                    <?php echo $v['name'] ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price'] ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div style="clear:both;"></div>
            <!--国内精品线路-->
            <div class="offset_top"></div>
            <div class="x_loca margin_top">
                <div class="loca_dny backsize">国内精品线路</div>
            </div>
            <ul class="width laca_li">
                <li class="current">丝绸探秘</li>
                <li>西部古都</li>
                <li>追梦自然</li>
            </ul>
            <div class="laca_cont">
                <ul class="width laca_show on travel">
                    <?php foreach ($sichou_data as $k => $v): ?>
                        <li>
                            <a href="javascript:;" higo_id="<?php echo $v['id']; ?>">
                                <img id="house"
                                     src="<?php echo $v['title_pic'][$v['first_pic']] . '?imageView2/1/w/200/h/150' ?>"
                                     alt=""/>
                                <p>
                                    <?php echo $v['name'] ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price'] ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="width laca_show travel">
                    <?php foreach ($xibu_data as $k => $v): ?>
                        <li>
                            <a href="javascript:;" higo_id="<?php echo $v['id']; ?>">
                                <img id="house"
                                     src="<?php echo $v['title_pic'][$v['first_pic']] . '?imageView2/1/w/200/h/150' ?>"
                                     alt=""/>
                                <p>
                                    <?php echo $v['name'] ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price'] ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="width laca_show travel">
                    <?php foreach ($ziran_data as $k => $v): ?>
                        <li>
                            <a href="javascript:;" higo_id="<?php echo $v['id']; ?>">
                                <img id="house"
                                     src="<?php echo $v['title_pic'][$v['first_pic']] . '?imageView2/1/w/200/h/150' ?>"
                                     alt=""/>
                                <p>
                                    <?php echo $v['name'] ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price'] ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div style="clear:both;"></div>
            <!--短途周边-->
            <div class="offset_top"></div>
            <div class="x_loca margin_top">
                <div class="loca_dny backsize">短途周边</div>
            </div>
            <ul class="width laca_li">
                <li class="current">户外探险</li>
                <li>魅力古镇</li>
                <li>欢乐游园</li>
            </ul>
            <div class="laca_cont">
                <ul class="width laca_show on travel">
                    <?php foreach ($huwai_data as $k => $v): ?>
                        <li>
                            <a href="javascript:;" higo_id="<?php echo $v['id']; ?>">
                                <img id="house"
                                     src="<?php echo $v['title_pic'][$v['first_pic']] . '?imageView2/1/w/200/h/150' ?>"
                                     alt=""/>
                                <p>
                                    <?php echo $v['name'] ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price'] ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="width laca_show travel">
                    <?php foreach ($guzhen_data as $k => $v): ?>
                        <li>
                            <a href="javascript:;" higo_id="<?php echo $v['id']; ?>">
                                <img id="house"
                                     src="<?php echo $v['title_pic'][$v['first_pic']] . '?imageView2/1/w/200/h/150' ?>"
                                     alt=""/>
                                <p>
                                    <?php echo $v['name'] ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price'] ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="width laca_show travel">
                    <?php foreach ($huanle_data as $k => $v): ?>
                        <li>
                            <a href="javascript:;" higo_id="<?php echo $v['id']; ?>">
                                <img id="house"
                                     src="<?php echo $v['title_pic'][$v['first_pic']] . '?imageView2/1/w/200/h/150' ?>"
                                     alt=""/>
                                <p>
                                    <?php echo $v['name'] ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price'] ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div style="clear:both;"></div>
            <!--精品民宿-->
            <div class="offset_top"></div>
            <div class="x_loca margin_top">
                <div class="loca_dny backsize">精品民宿</div>
            </div>
            <ul class="width laca_li">
                <li class="current">北京</li>
                <li>沈阳</li>
                <li>惠州</li>
            </ul>
            <div style="clear:both;"></div>
            <div class="laca_cont">
                <ul class="width laca_show on house_id">
                    <?php foreach($beijing as $k=>$v): ?>
                    <li>
                        <a href="javascript:;" house_id="<?php echo $v['id']; ?>">
                            <img src="http://img.tgljweb.com/<?php echo $v['cover_img'] ?>?imageView2/1/w/200/h/150"
                                 alt=""/>
                            <p>
                                <?php echo $v['title']; ?>
                            </p>
                            <p class="right">
                                ¥<?php echo $v['price']; ?> <span>起</span>
                            </p>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="width laca_show house_id">
                    <?php foreach($shenyang as $k=>$v): ?>
                        <li>
                            <a href="javascript:;" house_id="<?php echo $v['id']; ?>">
                                <img src="http://img.tgljweb.com/<?php echo $v['cover_img'] ?>?imageView2/1/w/200/h/150"
                                     alt=""/>
                                <p>
                                    <?php echo $v['title']; ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price']; ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="width laca_show house_id">
                    <?php foreach($huizhou as $k=>$v): ?>
                        <li>
                            <a href="javascript:;" house_id="<?php echo $v['id']; ?>">
                                <img src="http://img.tgljweb.com/<?php echo $v['cover_img'] ?>?imageView2/1/w/200/h/150"
                                     alt=""/>
                                <p>
                                    <?php echo $v['title']; ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price']; ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div style="clear: both;"></div>
            <ul class="width laca_li">
                <li class="current">上海</li>
                <li>青岛</li>
                <li>成都</li>
            </ul>
            <div style="clear:both;"></div>
            <div class="laca_cont">
                <ul class="width laca_show on house_id">
                    <?php foreach($shanghai as $k=>$v): ?>
                        <li>
                            <a href="javascript:;" house_id="<?php echo $v['id']; ?>">
                                <img src="http://img.tgljweb.com/<?php echo $v['cover_img'] ?>?imageView2/1/w/200/h/150"
                                     alt=""/>
                                <p>
                                    <?php echo $v['title']; ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price']; ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="width laca_show house_id">
                    <?php foreach($qingdao as $k=>$v): ?>
                        <li>
                            <a href="javascript:;" house_id="<?php echo $v['id']; ?>">
                                <img src="http://img.tgljweb.com/<?php echo $v['cover_img'] ?>?imageView2/1/w/200/h/150"
                                     alt=""/>
                                <p>
                                    <?php echo $v['title']; ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price']; ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="width laca_show house_id">
                    <?php foreach($chengdu as $k=>$v): ?>
                        <li>
                            <a href="javascript:;" house_id="<?php echo $v['id']; ?>">
                                <img src="http://img.tgljweb.com/<?php echo $v['cover_img'] ?>?imageView2/1/w/200/h/150"
                                     alt=""/>
                                <p>
                                    <?php echo $v['title']; ?>
                                </p>
                                <p class="right">
                                    ¥<?php echo $v['price']; ?> <span>起</span>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div style="clear:both;"></div>
            <input type="hidden" value="<?php echo isset($_GET['uid']) ? $_GET['uid'] : 0; ?>" class="uid">
            <input type="hidden" value="<?php echo $_GET['type'] ?>" class="mode">
            <input type="hidden" value="<?php echo $url; ?>" class="url">
            <input type="hidden" value="<?php echo $baopin1_status; ?>" class="baopin1">
            <input type="hidden" value="<?php echo $baopin2_status; ?>" class="baopin2">
            <input type="hidden" value="<?php echo isset($_GET['source']) ? $_GET['source'] : 'default'; ?>" class="source">
        </div>
    </div>
</div>
</body>

</html>
<script type="text/javascript">
    //	轮播图
    var swiper = new Swiper('.container02', {
        pagination: '.swiper-pagination',
        slidesPerView: 1.3,
        paginationClickable: true,
        spaceBetween: 10
    });

    //爆发页面倒计时
    //    var time = new Date();
    //    var sec =time.getSeconds();
    //    var min=time.getMinutes();
    //    var hour = time.getHours();
    //    var idt = window.setInterval("ls();", 1000);
    //    var format = function (str) {
    //        if (parseInt(str) < 10) {
    //            return "0" + str;
    //        }
    //        return str;
    //    };
    //
    //    function ls() {
    //        sec--;
    //        if (sec == 0) {
    //            min--;
    //            sec = 59;
    //        }
    //        if (min < 0 && hour > 0) {
    //            hour--;
    //            min = 59;
    //        }
    //        //                        document.getElementById("rest_time").innerText = format(hour) + ":" + format(min) + ":" + format(sec);
    //        document.getElementById("kuai").innerText = format(hour);
    //        document.getElementById("kuai2").innerText = format(min);
    //        document.getElementById("kuai3").innerText = format(sec);
    //        if (parseInt(hour) == 0 && parseInt(min) == 0 && parseInt(sec) == 0) {
    //            window.clearInterval(idt);
    //            //document.getElementById("btn_ok").click();
    //            alert("抢购活动已结束")
    //        }
    //    }
    onresize = function () {
        document.documentElement.style.fontSize = innerWidth / 16 + 'px';
    };
    document.documentElement.style.fontSize = innerWidth / 16 + 'px';
</script>
<script type="text/javascript">
    onresize = function () {
        document.documentElement.style.fontSize = innerWidth / 16 + 'px';
    };
    document.documentElement.style.fontSize = innerWidth / 16 + 'px';
    function login(url) {
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1; //android终端
        var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
        if (isdiOS) {
            function showIosToast() {
                window.webkit.messageHandlers.userLogin.postMessage(url);
            }

            showIosToast();
        }
        if (isAndroid) {
            function showAndroidToast() {
//                javascript:jsandroid.alipay();
                window.h5Interface.toLogin();
            }

            showAndroidToast();
        }
    }

    function detail(str) {
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1; //android终端
        var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
        if (isdiOS) {
            function showIosDetail() {
                window.webkit.messageHandlers.showDetail.postMessage(str);
            }

            showIosDetail();
        }
        if (isAndroid) {
            function showAndroidDetail() {
                if (str.type == 1) {
                    window.h5Interface.toDetailActivity(str.type, str.house_id);
                }
                if (str.type == 2) {
                    window.h5Interface.toDetailActivity(str.type, str.local_id);
                }
                if (str.type == 3) {
                    window.h5Interface.toDetailActivity(str.type, str.higo_id);
                }
            }

            showAndroidDetail();
        }
    }
    $(function () {
        $(".arch_tu .coupon_1_no").click(function () {
            var uid = $('.uid').val();
            var type = $('.mode').val();
            var source=$('.source').val();
            if (uid == 0) {
                if (type == 'h5') {
                    location.href = "/user/login?source="+source;
                    return;
                } else {
                    var url = window.location.href;
                    login(url);
                }
            } else {
                This = $(this);
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['get-coupon1']) ?>",
                    data: {uid: uid, "_csrf-frontend": "<?php echo Yii::$app->request->csrfToken ?>"},
                    success: function (data) {
                        if (data == -1) {
                            $(".layer5").show();
                            $(".layer_con img").attr("src", "/images/not_yhj.png");
                        }
                        if (data == 1) {
                            $(".layer5").show();
                            $(".layer_con img").attr("src", "/images/succeed.png")
                            $(".close").click(function () {
                                $(".layer5").hide();
                                This.attr("src", '/images/i_yhq_10.png');
                            })
                            This.unbind();
                        }
                    }
                })
            }
        })

        $(".arch_tu .coupon_2_no").click(function () {
            var uid = $('.uid').val();
            var type = $('.mode').val();
            var source=$('.source').val();
            if (uid == 0) {
                if (type == 'h5') {
                    location.href = "/user/login?source="+source;
                    return;
                } else {
                    var url = window.location.href;
                    login(url);
                }
            } else {
                This = $(this);
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['get-coupon2']) ?>",
                    data: {uid: uid, "_csrf-frontend": "<?php echo Yii::$app->request->csrfToken ?>"},
                    success: function (data) {
                        if (data == -1) {
                            $(".layer5").show();
                            $(".layer_con img").attr("src", "/images/not_yhj.png");
                        }
                        if (data == 1) {
                            $(".layer5").show();
                            $(".layer_con img").attr("src", "/images/succeed.png")
                            $(".close").click(function () {
                                $(".layer5").hide();
                                This.attr("src", '/images/i_yhq_30.png');
                            })
                            This.unbind();
                        }
                    }
                })
            }
        })

        $(".arch_tu .coupon_3_no").click(function () {
            var uid = $('.uid').val();
            var type = $('.mode').val();
            var source=$('.source').val();
            if (uid == 0) {
                if (type == 'h5') {
                    location.href = "/user/login?source="+source;
                    return;
                } else {
                    var url = window.location.href;
                    login(url);
                }
            } else {
                This = $(this);
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['get-coupon3']) ?>",
                    data: {uid: uid, "_csrf-frontend": "<?php echo Yii::$app->request->csrfToken ?>"},
                    success: function (data) {
                        if (data == -1) {
                            $(".layer5").show();
                            $(".layer_con img").attr("src", "/images/not_yhj.png");
                        }
                        if (data == 1) {
                            $(".layer5").show();
                            $(".layer_con img").attr("src", "/images/succeed.png")
                            $(".close").click(function () {
                                $(".layer5").hide();
                                This.attr("src", '/images/i_yhq_50.png');
                            })
                            This.unbind();
                        }
                    }
                })
            }
        })

        $('.tsms').click(function () {
            var uid = $('.uid').val();
            var type = $('.mode').val();
            if (uid > 0) {
                window.location.href = "/activity/minsu?type=" + type + '&uid=' + uid;
            } else {
                window.location.href = "/activity/minsu?type=" + type
            }
        })

        $('.gnxl').click(function () {
            var uid = $('.uid').val();
            var type = $('.mode').val();
            if (uid > 0) {
                window.location.href = "/activity/lvxing?type=" + type + '&uid=' + uid;
            } else {
                window.location.href = "/activity/lvxing?type=" + type
            }
        })

        $('.jdhc').click(function () {
            var uid = $('.uid').val();
            var type = $('.mode').val();
            if (uid > 0) {
                window.location.href = "/activity/hotel?type=" + type + '&uid=' + uid;
            } else {
                window.location.href = "/activity/hotel?type=" + type
            }
        })

        $('.jwjp').click(function () {
            var uid = $('.uid').val();
            var type = $('.mode').val();
            if (uid > 0) {
                window.location.href = "/activity/haiwai?type=" + type + '&uid=' + uid;
            } else {
                window.location.href = "/activity/haiwai?type=" + type
            }
        })

        $('.stereogram01 a img').click(function () {
            var myDate = new Date();
            var time = myDate.getHours();
            if (time >= 10 && time <= 19) {

            } else {
                alert('活动暂时没开启');
            }
        })

        $('.share').click(function () {
            var url = $('.url').val() + '?type=h5';
            var img = 'share__78.png';
            var title = '棠果旅居节';
            var content = '5亿红包狂撒一夏，超值东南亚线路999元起';
            var str = {shareImgUrl: img, shareContent: content, shareTitle: title, shareUrl: url};
            var u = navigator.userAgent;
            var isAndroid = u.indexOf('Android') > -1; //android终端
            var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
            if (isdiOS) {
                function showIosDetail() {
                    window.webkit.messageHandlers.share.postMessage(str);
                }

                showIosDetail();
            }
            if (isAndroid) {
                function showAndroidShare() {
                    window.h5Interface.share(title, content, url, img);
                }

                showAndroidShare();
            }
        })

        $('.fanhui').click(function () {
            var u = navigator.userAgent;
            var isAndroid = u.indexOf('Android') > -1; //android终端
            var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
            if (isdiOS) {
                function iosGoback() {
                    window.webkit.messageHandlers.goback.postMessage('abc');
                }

                iosGoback();
            }
            if (isAndroid) {
                function androidBack() {
                    window.h5Interface.goBack();
                }

                androidBack();
            }
        })

        $('.dazhuanpan').click(function () {
            var uid = $('.uid').val();
            var type = $('.mode').val();
            var source=$('.source').val();
            if (uid > 0) {
                window.location.href = "/activity/game?type=" + type + '&uid=' + uid;
            } else {
                window.location.href = "/activity/game?type=" + type+'&source='+source
            }
        })

        //跳转优惠券
        $('.new_gift').click(function () {
            var uid = $('.uid').val();
            var type = $('.mode').val();
            var source=$('.source').val();
            if (uid > 0) {
                if (type == 'app') {
                    var u = navigator.userAgent;
                    var isAndroid = u.indexOf('Android') > -1; //android终端
                    var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
                    if (isdiOS) {
                        function ioscoupon() {
                            window.webkit.messageHandlers.youhuiquan.postMessage('abc');
                        }

                        ioscoupon();
                    }
                    if (isAndroid) {
                        function androidcoupon() {
                            window.h5Interface.PersonalCoupon();
                        }

                        androidcoupon();
                    }
                } else {
                    location.href = "http://www.xywykj.com/";
                    return;
                }
            } else {
                if (type == 'h5') {
                    location.href = "/user/login?source="+source;
                    return;
                } else {
                    var url = window.location.href;
                    login(url);
                }
            }
        })

        $('.house_id li a').click(function () {
            var house_id = $(this).attr('house_id');
            var uid = $('.uid').val();
            var type = $('.mode').val();
            if (uid == 0) {
                if (type == 'h5') {
                    location.href = "http://www.xywykj.com/";
                    return;
                } else {
                    var url = window.location.href;
                    login(url);
                }
            } else {
                if (type == 'h5') {
                    location.href = "http://www.xywykj.com/";
                    return;
                } else {
                    var str = {house_id: house_id, type: 1};
                    detail(str);
                }
            }
        })

        $('.travel li a').click(function () {
            var higo_id = $(this).attr('higo_id');
            var uid = $('.uid').val();
            var type = $('.mode').val();
            if (type == 'app') {
                var str = {higo_id: higo_id, type: 3};
                detail(str);
            } else {
//                var url = "http://106.14.16.252:8088/indexdk/detail?higo_id=" + higo_id + '&resource=78&uid='+uid;
                var url="http://lvcheng.tgljweb.com/indexdk/detail?higo_id="+higo_id+'&resource=78&uid='+uid;
                location.href = url;
            }
        })
    })
</script>