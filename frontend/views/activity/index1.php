<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>棠果旅居节-预热</title>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/lvjujie.css"/>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/reset.css"/>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/lvjujie.js"></script>
    <script type="text/javascript">
        document.addEventListener('plusready', function () {
            //console.log("所有plus api都应该在此事件发生后调用，否则会出现plus is undefined。"

        });
    </script>
</head>

<body>
<!--弹窗-->
<div class="layer5">
    <div class="layer_con">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/layer.png" alt="" class="record_bj">
    </div>
    <img src="<?= Yii::$app->request->baseUrl ?>/images/close.png" alt="" class="close">
</div>

<div class="x_content">
    <!--导航栏-->
    <div class="x_nav">
        <div class="nav_left absolete">
            <img class="img_left" src="<?= Yii::$app->request->baseUrl ?>/images/fanhui.png" alt=""/>
            <p class="x_title color">
                <span>棠果旅居节 优惠海不停</span>
            </p>
            <img class="img_right" src="<?= Yii::$app->request->baseUrl ?>/images/share.png" alt=""/>
        </div>
    </div>
    <!--banner-->
    <div class="x_head">
        <img class="width" src="<?= Yii::$app->request->baseUrl ?>/images/banner.png" alt=""/>
    </div>
    <div class="x_bj width" style="height:10px;"></div>
    <!--侧边导航-->
    <div class="fixed_nav" style="display: block;">
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
    <a href="coupon_new.html"><img class="new_gift" src="<?= Yii::$app->request->baseUrl ?>/images/new_gift.png"
                                   alt=""/></a>

    <!--优惠券专区-->
    <div class="offset_top"></div>
    <div class="x_discount width">
        <div class="x_arck_back">
            <p class="arch_title color">
                优惠券专区
            </p>

            <div class="arch_tu ">
                <a href="#" class="arch_07">
                    <?php if ($coupon_1_status == 0) { ?>
                        <img class="coupon_1_no" src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                    <?php } else {
                        ?>
                        <img class="coupon_1_yes" src="<?= Yii::$app->request->baseUrl ?>/images/i_yhq_10.png" alt=""/>
                        <?php
                    }
                    ?>
                </a>
                <a href="#" class="arch_09">
                    <?php if ($coupon_2_status == 0) { ?>
                        <img class="coupon_2_no" src="<?= Yii::$app->request->baseUrl ?>/images/arch_09.png" alt=""/>
                    <?php } else {
                        ?>
                        <img class="coupon_2_yes" src="<?= Yii::$app->request->baseUrl ?>/images/i_yhq_30.png" alt=""/>
                        <?php
                    }
                    ?>
                </a>
                <a href="#" class="arch_11">
                    <?php if ($coupon_3_status == 0) { ?>
                        <img class="coupon_3_no" src="<?= Yii::$app->request->baseUrl ?>/images/arch_11.png" alt=""/>
                    <?php } else {
                        ?>
                        <img class="coupon_3_yes" src="<?= Yii::$app->request->baseUrl ?>/images/i_yhq_50.png" alt=""/>
                        <?php
                    }
                    ?>
                </a>
                <!--<a href="#"><img src="<?= Yii::$app->request->baseUrl ?>/images/i_yhq_10.png" alt="" /></a>
					<a href="#"><img src="<?= Yii::$app->request->baseUrl ?>/images/i_yhq_30.png" alt="" /></a>
					<a href="#"><img src="<?= Yii::$app->request->baseUrl ?>/images/i_yhq_50.png" alt="" /></a>-->
            </div>
            <p class="x_yanze color">
                查看优惠券使用原则<img src="<?= Yii::$app->request->baseUrl ?>/images/yuan.png" alt=""/>
            </p>
        </div>
    </div>
    <!--幸运大转盘-->
    <div class="offset_top"></div>
    <div class="x_bj width"></div>
    <div class="x_dial width position" style="height: 7.19rem;">
        <div class="x_dial_title absolete color">
            幸运大转盘
        </div>
        <div class="dial_bj">
            <p class="dial_size left">
                <span class="dial_prize">德法意瑞经典游  </span></br>
                iPhone7、60元现金券等 </br>
                多重好礼等你拿！
            </p>
            <div class="dial_click">
                <a href="game_rarate.html">
                    <img class="dial_lottery" src="<?= Yii::$app->request->baseUrl ?>/images/i_lottery_draw_icon.png"
                         alt=""/>
                </a>
            </div>
        </div>

    </div>
    <!--优惠专区-->
    <div class="x_privilege width position">
        <div class="x_dial_title absolete color">
            优惠专区
        </div>
        <p class="x_dial_title2 color">
            超值出游
        </p>
        <div class="offset_top"></div>
        <div class="x_privilege_bj width"></div>
        <div class="x_privilege_cont">
            <!--超值东南亚-->
            <div class="x_loca">
                <div class="loca_dny backsize">超值东南亚</div>
            </div>
            <ul class="width laca_li">
                <li>千佛之国</li>
                <li>森林氧吧</li>
                <li>乐享海岛</li>
            </ul>
            <div class="laca_cont">
                <ul class="width laca_show on">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
            <div style="clear:both;"></div>
            <!--国内精品线路-->
            <div class="offset_top"></div>
            <div class="x_loca margin_top">
                <div class="loca_dny backsize">国内精品线路</div>
            </div>
            <ul class="width laca_li">
                <li>丝绸探秘</li>
                <li>西部古都</li>
                <li>追梦自然</li>
            </ul>
            <div class="laca_cont">
                <ul class="width laca_show on">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
            <div style="clear:both;"></div>
            <!--短途周边-->
            <div class="offset_top"></div>
            <div class="x_loca margin_top">
                <div class="loca_dny backsize">短途周边</div>
            </div>
            <ul class="width laca_li">
                <li>户外探险</li>
                <li>魅力古镇</li>
                <li>欢乐游园</li>
            </ul>
            <div class="laca_cont">
                <ul class="width laca_show on">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show ">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show ">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
            </div>

            <div style="clear:both;"></div>
            <!--精品民宿-->
            <div class="offset_top"></div>
            <div class="x_loca margin_top">
                <div class="loca_dny backsize">精品民宿</div>
            </div>
            <ul class="width laca_li">
                <li>北京</li>
                <li>丽江</li>
                <li>厦门</li>
            </ul>
            <div style="clear:both;"></div>
            <div class="laca_cont">
                <ul class="width laca_show on">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
            <div style="clear: both;"></div>
            <ul class="width laca_li">
                <li>北京</li>
                <li>丽江</li>
                <li>厦门</li>
            </ul>
            <div style="clear:both;"></div>
            <div class="laca_cont">
                <ul class="width laca_show on">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show">
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?= Yii::$app->request->baseUrl ?>/images/arch_07.png" alt=""/>
                            <p>
                                东方凯宾斯基酒店东方凯宾...
                            </p>
                            <p class="right">
                                ¥588 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
</div>
</body>

</html>
<script type="text/javascript">
    onresize = function () {
        document.documentElement.style.fontSize = innerWidth / 16 + 'px';
    };
    document.documentElement.style.fontSize = innerWidth / 16 + 'px';
</script>