<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">-->
    <title>棠果旅居节 优惠嗨不停</title>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/lvjujie.css"/>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/reset.css"/>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/lvjujie.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/base-loading.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/layer/layer.js"></script>
<!--    <script type="text/javascript">-->
<!--        document.addEventListener('plusready', function () {-->
<!--            //console.log("所有plus api都应该在此事件发生后调用，否则会出现plus is undefined。"-->
<!---->
<!--        });-->
<!--    </script>-->
    <style>
        /*sxh 7.06 页面左右滑动*/
        html,body{overflow:hidden;overflow-y:auto;}
        .x_content{
            width:100%;
        }
        .layer5 .close{
            bottom:3rem;
        }
    </style>
    <script>
        $(document).scroll(function(){
            var top = $(document).scrollTop();
//            console.log(top)
            if(top>0){
                $(".x_nav").css("background-color","rgba(0,0,0,0.4)");
                var u = navigator.userAgent;
                var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
                if(isiOS == true){
                    $(".x_nav").css("padding-top", "20px");
                    $(".x_nav").css("top", "0");
                }else{
                    $(".x_nav").css("padding-top","0px")
                }

            }else{
                $(".x_nav").css("background-color","transparent")
            }
        })
    </script>
    <script>
//        ios判断
    window.onload = function(){
        var u = navigator.userAgent;
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        if (isiOS == true) {
            $(".x_nav").css("top", "20px")
        }else{
            $(".x_nav").css("top", "0")
        }
    }

//        var ua = navigator.userAgent.toLowerCase();
//        if (/iphone|ipad|ipod/.test(ua)) {
//            $(".x_nav").css("top","100px")
//        }
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
<div class="layer_receive">
    <div class="layer_con">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/layer_receive.png" alt="" class="record_bj">
    </div>
    <img src="<?= Yii::$app->request->baseUrl ?>/images/close.png" alt="" class="close">
</div>

<div class="layer6" style="display: none;">
    <div class="layer_con">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/rule_bj_no.png" alt="" class="record_bj">
        <p>您已领取此优惠券！</p>
    </div>
    <img src="<?= Yii::$app->request->baseUrl ?>/images/close.png" alt="" class="close">
</div>

<div class="x_content">

    <!--导航栏-->
    <?php if($_GET['type']=='app'){ ?>
    <div class="x_nav" style="position:fixed;width:100%;height:60px;z-index:999;font-size:18px; ">
        <div class="nav_left absolete">
            <?php if($_GET['type']=='app'){ ?>
            <img class="img_left goback" src="<?= Yii::$app->request->baseUrl ?>/images/fanhui.png" alt=""/>
            <?php } ?>
            <p class="x_title color">
                <span>棠果旅居节 优惠嗨不停</span>
            </p>
            <?php if($_GET['type']=='app'){ ?>
            <img class="img_right img_share" src="<?= Yii::$app->request->baseUrl ?>/images/share.png" alt=""/>
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
        var month = time.getMonth()+1;
        var date = time.getDate();
        if(month==7&&date==24){
            $(".x_head img").attr("src","/images/banner.jpg")
        }else if(month==8&&date==3){
            $(".x_head img").attr("src","/images/banner2.jpg")
        }else if(month==8&&date==12){
            $(".x_head img").attr("src","/images/banner3.jpg")
        }

    </script>

    <div class="x_bj width" style="height:0px;"></div>
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
                手机一部、60元现金券等 </br>
                多重好礼等你拿！
            </p>
            <div class="dial_click">
                    <img class="dial_lottery" src="<?= Yii::$app->request->baseUrl ?>/images/i_lottery_draw_icon.png"
                         alt=""/>
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
                <li class="current">千佛之国</li>
                <li>森林氧吧</li>
                <li>乐享海岛</li>
            </ul>
            <div class="laca_cont">
                <ul class="width laca_show on travel">
                    <li>
                        <a href="javascript:;" higo_id="460">
                            <img id="house" src="http://img.tgljweb.com/theme_2713326_1496634111.8572.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                泰国| 曼谷的夏天有多种颜色
                            </p>
                            <p class="right">
                                ¥4999 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="223">
                            <img id="house" src="http://img.tgljweb.com/activity__1493281197.9495.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                曼谷| 为曼芭驻足，感受异国景致
                            </p>
                            <p class="right">
                                ¥2200 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="58">
                            <img id="house" src="http://img.tgljweb.com/activity__1490078157.9628.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                泰国| 清迈黛兰塔维+曼谷美食之旅
                            </p>
                            <p class="right">
                                ¥30800 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="469">
                            <img id="house" src="http://img.tgljweb.com/theme_2713326_1496717643.2239.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                清迈| 静谧泰北，悠然假期
                            </p>
                            <p class="right">
                                ¥3999 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show travel">
                    <li>
                        <a href="javascript:;" higo_id="607">
                            <img id="house" src="http://img.tgljweb.com/theme_2719498_1498643288.3242.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                清迈| 静谧泰北，悠然假期
                            </p>
                            <p class="right">
                                ¥2990 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="204">
                            <img id="house" src="http://img.tgljweb.com/activity__1493085649.453.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                普吉岛| 魅力白沙滩+神仙半岛，欣赏海天一色的美景
                            </p>
                            <p class="right">
                                ¥6650 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="76">
                            <img id="house" src="http://img.tgljweb.com/activity__1490175340.9632.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                普吉岛| 独享普吉岛的白沙滩泳池别墅
                            </p>
                            <p class="right">
                                ¥6880 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="62">
                            <img id="house" src="http://img.tgljweb.com/activity__1490084392.7386.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                沙巴| 仙本那-马步岛自由之旅
                            </p>
                            <p class="right">
                                ¥8699 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show travel">
                    <li>
                        <a href="javascript:;" higo_id="34">
                            <img id="house" src="http://img.tgljweb.com/theme_2713326_1495518251.5448.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                印度尼西亚| 爬山涉水异国双享
                            </p>
                            <p class="right">
                                ¥128000 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="160">
                            <img id="house" src="http://img.tgljweb.com/activity__1492137835.6766.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                印度尼西亚| 巴厘岛6天4晚半自由行度假之旅
                            </p>
                            <p class="right">
                                ¥6999 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="452">
                            <img id="house" src="http://img.tgljweb.com/theme_2570258_1495854641.443.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                普吉岛| 臻选酒店，畅游芭东海滩
                            </p>
                            <p class="right">
                                ¥3700 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="593">
                            <img id="house" src="http://img.tgljweb.com/theme_2713326_1498472039.4678.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                沙巴| 享受阳光与海水，寻找长鼻猴、观赏萤火虫
                            </p>
                            <p class="right">
                                ¥4200 <span>起</span>
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
                <li class="current">丝绸探秘</li>
                <li>西部古都</li>
                <li>追梦自然</li>
            </ul>
            <div class="laca_cont">
                <ul class="width laca_show on travel">
                    <li>
                        <a href="javascript:;" higo_id="59">
                            <img id="house" src="http://img.tgljweb.com/theme_2665582_1494820913.6801.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                西宁| 重走古道丝绸之路，背起背包嗨翻大西北
                            </p>
                            <p class="right">
                                ¥1600 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="351">
                            <img id="house" src="http://img.tgljweb.com/theme_2555298_1494468414.1408.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                西宁| 敦煌大环线，梦回丝绸之路
                            </p>
                            <p class="right">
                                ¥3380 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="355">
                            <img id="house" src="http://img.tgljweb.com/theme_2555298_1494473115.0688.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                西宁| 骑行、徒步青海湖4日
                            </p>
                            <p class="right">
                                ¥1680 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="476">
                            <img id="house" src="http://img.tgljweb.com/theme_2570258_1496730807.222.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                乌兰布统| 草原儿童夏令营，探秘纯正蒙古风情
                            </p>
                            <p class="right">
                                ¥4900 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show travel">
                    <li>
                        <a href="javascript:;" higo_id="470">
                            <img id="house" src="http://img.tgljweb.com/theme_2713326_1496717708.6919.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                乌兰布统| 草原儿童夏令营，探秘纯正蒙古风情
                            </p>
                            <p class="right">
                                ¥2850 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="472">
                            <img id="house" src="http://img.tgljweb.com/theme_2713326_1496719751.7384.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                西安| 秦皇雄略，诸葛千古历史文化之旅6日
                            </p>
                            <p class="right">
                                ¥2680 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="473">
                            <img id="house" src="http://img.tgljweb.com/theme_2713326_1496721217.7135.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                西安| 秦皇兵马俑历史人文体验4日
                            </p>
                            <p class="right">
                                ¥1600 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="471">
                            <img id="house" src="http://img.tgljweb.com/theme_2570258_1496720437.9741.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                山西| 品尝平遥八碗八碟，聆听当年晋商的声音
                            </p>
                            <p class="right">
                                ¥1271 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show travel">
                    <li>
                        <a href="javascript:;" higo_id="533">
                            <img id="house" src="http://img.tgljweb.com/theme_2720228_1498553954.4935.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                稻亚经典| 海螺沟新都桥稻城亚丁深度游经典7日
                            </p>
                            <p class="right">
                                ¥2280 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="530">
                            <img id="house" src="http://img.tgljweb.com/theme_2720228_1497876314.1874.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                天界之渡| 四姑娘山稻城亚丁川藏南线10日深度游
                            </p>
                            <p class="right">
                                ¥6100 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="166">
                            <img id="house" src="http://img.tgljweb.com/activity__1492412758.6507.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                云南| 相约大理，魅力之旅
                            </p>
                            <p class="right">
                                ¥1999 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="257">
                            <img id="house" src="http://img.tgljweb.com/theme_2570258_1495266094.7961.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                云南| 去稻城亚丁，寻最后的香格里拉
                            </p>
                            <p class="right">
                                ¥3880 <span>起</span>
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
                <li class="current">户外探险</li>
                <li>魅力古镇</li>
                <li>欢乐游园</li>
            </ul>
            <div class="laca_cont">
                <ul class="width laca_show on travel">
                    <li>
                        <a href="javascript:;" higo_id="466">
                            <img id="house" src="http://img.tgljweb.com/theme_2710693_1496648469.1766.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                赤峰| 乌兰布统大草原，穿越无人区，草原深处享用美味佳肴
                            </p>
                            <p class="right">
                                ¥908 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="467">
                            <img id="house" src="http://img.tgljweb.com/theme_2710693_1496650086.172.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                吉林| 去长白山看看天堂里的花园、天使散步的地方
                            </p>
                            <p class="right">
                                ¥1200 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="359">
                            <img id="house" src="http://img.tgljweb.com/theme_2710693_1494492029.6162.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                张家口| 相约醉美草原闪电湖扎营·篝火
                            </p>
                            <p class="right">
                                ¥350 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="406">
                            <img id="house" src="http://img.tgljweb.com/theme_2711523_1495008204.2755.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                张家口| 周末去最美66号公路看草原天路
                            </p>
                            <p class="right">
                                ¥350 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show travel">
                    <li>
                        <a href="javascript:;" higo_id="361">
                            <img id="house" src="http://img.tgljweb.com/theme_2710693_1494493464.5069.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                晋中| 平遥古城·乔家大院两日游
                            </p>
                            <p class="right">
                                ¥450 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="363">
                            <img id="house" src="http://img.tgljweb.com/theme_2710693_1494494336.2065.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                北京| 近郊游古北小桥流水、古镇风情
                            </p>
                            <p class="right">
                                ¥299 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="407">
                            <img id="house" src="http://img.tgljweb.com/theme_2711523_1495009826.779.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                晋中| 晋中休闲二日、平遥古城、王家大院、品美食赏美景
                            </p>
                            <p class="right">
                                ¥350 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="387">
                            <img id="house" src="http://img.tgljweb.com/theme_2711523_1494922921.3301.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                北京| 爸爸去哪拍摄地-灵水村-爨底下
                            </p>
                            <p class="right">
                                ¥70 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show travel">
                    <li>
                        <a href="javascript:;" higo_id="362">
                            <img id="house" src="http://img.tgljweb.com/theme_2710693_1494493738.1287.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                秦皇岛| 漫步东戴河沙滩一起踏浪嬉戏
                            </p>
                            <p class="right">
                                ¥360 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="358">
                            <img id="house" src="http://img.tgljweb.com/theme_2710693_1494491109.869.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                秦皇岛| 阳光沙滩翡翠岛 海边扎营
                            </p>
                            <p class="right">
                                ¥300 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="130">
                            <img id="house" src="http://img.tgljweb.com/theme_2713326_1495509134.9511.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                珠海| 蓝色奇迹，惊艳世界
                            </p>
                            <p class="right">
                                ¥2590 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" higo_id="71">
                            <img id="house" src="http://img.tgljweb.com/theme_2713326_1495265000.1741.jpeg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                香港| 海洋公园+迪士尼乐园嗨翻天
                            </p>
                            <p class="right">
                                ¥1050 <span>起</span>
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
                <li class="current">北京</li>
                <li>沈阳</li>
                <li>惠州</li>
            </ul>
            <div style="clear:both;"></div>
            <div class="laca_cont">
                <ul class="width laca_show on house_id">
                    <li>
                        <a href="javascript:;" house_id="1745857">
                            <img src="http://img.tgljweb.com/pcHouse_63_1489397597.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                鼓楼大街未名四合院大床房
                            </p>
                            <p class="right">
                                ¥880 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1750305">
                            <img src="http://img.tgljweb.com/pcHouse_63_1489819400.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                北海161四合院大床房
                            </p>
                            <p class="right">
                                ¥375 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1766873">
                            <img src="http://img.tgljweb.com/agent_1766873_149879119057048.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                北京后现代城设计师精装工业风大开间
                            </p>
                            <p class="right">
                                ¥458 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1766867">
                            <img src="http://img.tgljweb.com/agent_1766867_149879054897819.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                北京CBD国贸地铁旁舒适大床房
                            </p>
                            <p class="right">
                                ¥400 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show house_id">
                    <li>
                        <a href="javascript:;" house_id="1756608">
                            <img src="http://img.tgljweb.com/house_14936961167776398.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                唐轩公馆精装公寓，24小时热水，无线网络覆盖
                            </p>
                            <p class="right">
                                ¥80 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1755627">
                            <img src="http://img.tgljweb.com/house_1493197029166_2685.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                棠棠主题动漫大圆床
                            </p>
                            <p class="right">
                                ¥148 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1757777">
                            <img src="http://img.tgljweb.com/agent_1757777_149405832764678.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                栖居精品复式主题酒店
                            </p>
                            <p class="right">
                                ¥238 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1746382">
                            <img src="http://img.tgljweb.com/house_1487756916696_0685.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                玫瑰阁主题公寓
                            </p>
                            <p class="right">
                                ¥148 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show house_id">
                    <li>
                        <a href="javascript:;" house_id="1760519">
                            <img src="http://img.tgljweb.com/agent_1760519_149544128446839.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                双月湾巴里海寓日出飘窗湾景双床房
                            </p>
                            <p class="right">
                                ¥289 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1759521">
                            <img src="http://img.tgljweb.com/agent_1759521_149498797466005.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                十里银滩蓝海小筑度假公寓园景双床房
                            </p>
                            <p class="right">
                                ¥400 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1759433">
                            <img src="http://img.tgljweb.com/agent_1759433_149491586337311.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                亚婆角佰优·海滩度假公寓双人房
                            </p>
                            <p class="right">
                                ¥270 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1759272">
                            <img src="http://img.tgljweb.com/agent_1759272_149483028775045.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                双月湾阳光沙滩酒店至尊一线全海景两房一厅
                            </p>
                            <p class="right">
                                ¥740 <span>起</span>
                            </p>
                        </a>
                    </li>
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
                    <li>
                        <a href="javascript:;" house_id="1626200">
                            <img src="http://img.tgljweb.com/house_65980_1478253778950.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                上海世季假日公寓舒馨一室
                            </p>
                            <p class="right">
                                ¥259 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1758389">
                            <img src="http://img.tgljweb.com/house_14943165418147821.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                上海徐汇法租界loft温馨房
                            </p>
                            <p class="right">
                                ¥479 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1759441">
                            <img src="http://img.tgljweb.com/house_1494947396273_4395.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                锦江乐园-南方商城-复旦儿科医院-上海南站
                            </p>
                            <p class="right">
                                ¥429 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1615165">
                            <img src="http://img.tgljweb.com/573a74f4a99e8_640_403.jpg?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                未来域壹极复式豪华大床房
                            </p>
                            <p class="right">
                                ¥289 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show house_id">
                    <li>
                        <a href="javascript:;" house_id="1628594">
                            <img src="http://img.tgljweb.com/house_76337_1478710674240.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                花园洋房三卧室套房
                            </p>
                            <p class="right">
                                ¥368 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1756036">
                            <img src="http://img.tgljweb.com/house_14932298812417809.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                清早.小宿one morning 清新北欧
                            </p>
                            <p class="right">
                                ¥398 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1741769">
                            <img src="http://img.tgljweb.com/house_6046526_1484631987273.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                青岛达令港精装海景大床
                            </p>
                            <p class="right">
                                ¥368 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1628078">
                            <img src="http://img.tgljweb.com/house_73905_1478592474974.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                金沙滩雅居度假公寓一居室
                            </p>
                            <p class="right">
                                ¥298 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="width laca_show house_id">
                    <li>
                        <a href="javascript:;" house_id="1757759">
                            <img src="http://img.tgljweb.com/agent_1757759_149404363322864.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                稀客美宿客栈东篱套房～近世纪城新会展中心
                            </p>
                            <p class="right">
                                ¥338 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1758120">
                            <img src="http://img.tgljweb.com/agent_1758120_149422729180175.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                蜀宿酒店公寓~特色大床房（近桐梓林地铁）
                            </p>
                            <p class="right">
                                ¥169 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1759359">
                            <img src="http://img.tgljweb.com/agent_1759359_149489986024837.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                武侯祠`锦里`日式榻榻米套房
                            </p>
                            <p class="right">
                                ¥388 <span>起</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" house_id="1759429">
                            <img src="http://img.tgljweb.com/house_1494944167714_6347.png?imageView2/1/w/200/h/150" alt=""/>
                            <p>
                                明皓公寓、临时武侯祠、锦里、宽窄巷子
                            </p>
                            <p class="right">
                                ¥308 <span>起</span>
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
            <div style="clear:both;"></div>
            <input type="hidden" value="<?php echo isset($_GET['uid']) ? $_GET['uid'] : 0; ?>" class="uid">
            <input type="hidden" value="<?php echo $_GET['type'] ?>" class="mode">
            <input type="hidden" value="<?php echo $url; ?>" class="url">
            <input type="hidden" value="<?php echo isset($_GET['source']) ? $_GET['source'] : 'default'; ?>" class="source">
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
    function login(url){
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1; //android终端
        var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
        if(isdiOS){
            function showIosToast(){
                window.webkit.messageHandlers.userLogin.postMessage(url);
            }
            showIosToast();
        }
        if(isAndroid){
            function showAndroidToast() {
//                javascript:jsandroid.alipay();
                 window.h5Interface.toLogin();
            }
            showAndroidToast();
        }
    }


    function detail(str){
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1; //android终端
        var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
        if(isdiOS){
            function showIosDetail(){
                window.webkit.messageHandlers.showDetail.postMessage(str);
            }
            showIosDetail();
        }
        if(isAndroid){
            function showAndroidDetail() {
                if(str.type==1){
                    window.h5Interface.toDetailActivity(str.type,str.house_id);
                }
                if(str.type==2){
                    window.h5Interface.toDetailActivity(str.type,str.local_id);
                }
                if(str.type==3){
                    window.h5Interface.toDetailActivity(str.type,str.higo_id);
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
                }else{
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
                            $("html,body").css("overflow-y","hidden")
                            $(".layer_con img").attr("src", "/images/not_yhj.png");
                        }
                        if(data==-2){
                            $(".layer_receive").show();
                            $('.arch_07').html("<img class='coupon_1_yes' src='/images/i_yhq_10.png'/>");
                        }
                        if (data == 1) {
                            $(".layer5").show();
                            $("html,body").css("overflow-y","hidden")
                            $(".layer_con img").attr("src", "/images/succeed.png")
                            $(".layer5 .close").click(function () {
                                $(".layer5").hide();
                                $("html,body").css("overflow-y","auto")
                                This.attr("src", '/images/i_yhq_10.png');
                            })
                            This.unbind();
                        }
                    }
                })
            }
        })
        $(".layer_receive .close").click(function () {
            $(".layer_receive").hide();
        })
        $(".arch_tu .coupon_2_no").click(function () {
            var uid = $('.uid').val();
            var type = $('.mode').val();
            var source=$('.source').val();
            if (uid == 0) {
                if (type == 'h5') {
                    location.href = "/user/login?source="+source;
                    return;
                }else{
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
                            $("html,body").css("overflow-y","hidden")

                            $(".layer_con img").attr("src", "/images/not_yhj.png");
                        }
                        if(data==-2){
                            $(".layer_receive").show();
                            $('.arch_09').html("<img class='coupon_2_yes' src='/images/i_yhq_30.png'/>");
                        }
                        if (data == 1) {
                            $(".layer5").show();
                            $("html,body").css("overflow-y","hidden")

                            $(".layer_con img").attr("src", "/images/succeed.png")
                            $(".close").click(function () {
                                $(".layer5").hide();
                                $("html,body").css("overflow-y","auto")
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
                }else{
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
                            $(".layer_con img").attr("src", "/images/not_yhj.png");
                        }
                        if(data==-2){
                            $(".layer_receive").show();
                            $('.arch_11').html("<img class='coupon_3_yes' src='/images/i_yhq_50.png'/>");
                        }
                        if (data == 1) {
                            $(".layer5").show();
                            $("html,body").css("overflow-y","hidden")

                            $(".layer_con img").attr("src", "/images/succeed.png")
                            $(".close").click(function () {
                                $(".layer5").hide();
                                $("html,body").css("overflow-y","auto")
                                This.attr("src", '/images/i_yhq_50.png');
                            })
                            This.unbind();
                        }
                    }
                })
            }
        })


        $('.house_id li a').click(function(){
            var house_id=$(this).attr('house_id');
            var uid = $('.uid').val();
            var type = $('.mode').val();
            if (uid == 0) {
                if (type == 'h5') {
                    location.href = "http://www.xywykj.com/";
                    return;
                }else{
                    var url = window.location.href;
                    login(url);
                }
            }else{
                if(type=='h5'){
                    location.href = "http://www.xywykj.com/";
                    return;
                }else{
                    var str={house_id:house_id,type:1};
                    detail(str);
                }
            }
        })

        $('.travel li a').click(function(){
            var higo_id=$(this).attr('higo_id');
            var uid = $('.uid').val();
            var type = $('.mode').val();
            if(type=='app'){
                var str={higo_id:higo_id,type:3};
                detail(str);
            }else{
                var url="http://lvcheng.tgljweb.com/indexdk/detail?higo_id="+higo_id+'&resource=78';
//                    var url="http://106.14.16.252:8088/indexdk/detail?higo_id="+higo_id+'&resource=78';
                location.href =url;
            }
        })

        $('#bendi').click(function(){
            var local_id=257;
            var uid = $('.uid').val();
            var type = $('.mode').val();
            if (uid == 0) {
                if (type == 'h5') {
                    location.href = "http://www.xywykj.com/";
                    return;
                }else{
                    var url = window.location.href;
                    login(url);
                }
            }else{
                var str={local_id:local_id,type:2};
                detail(str);
            }
        })

        $('.img_share').click(function(){
            var url=$('.url').val()+'?type=h5';
            var img='share__78.png';
            var title='棠果旅居节';
            var content='5亿红包狂撒一夏，超值东南亚线路999元起';
            var str={shareImgUrl:img,shareContent:content,shareTitle:title,shareUrl:url};
            var u = navigator.userAgent;
            var isAndroid = u.indexOf('Android') > -1; //android终端
            var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
            if(isdiOS){
                function showIosDetail(){
                    window.webkit.messageHandlers.share.postMessage(str);
                }
                showIosDetail();
            }
            if(isAndroid){
                function showAndroidShare() {
                 window.h5Interface.share(title,content,url,img);
                }
                showAndroidShare();
            }
        })

        $('.goback').click(function(){
            var u = navigator.userAgent;
            var isAndroid = u.indexOf('Android') > -1; //android终端
            var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
            if(isdiOS){
                function iosGoback(){
                    window.webkit.messageHandlers.goback.postMessage('abc');
                }
                iosGoback();
            }
            if(isAndroid){
                function androidBack() {
                 window.h5Interface.goBack();
                }
                androidBack();
            }
        })

        //跳转大转盘
        $('.dial_lottery').click(function(){
            var uid = $('.uid').val();
            var type = $('.mode').val();
            if(uid==0){
                window.location.href="/activity/game?type="+type;
            }else{
                window.location.href="/activity/game?type="+type+'&uid='+uid;
            }
        })

        //跳转优惠券
        $('.new_gift').click(function(){
            var uid = $('.uid').val();
            var type = $('.mode').val();
            if(uid>0){
                if(type=='app'){
                    var u = navigator.userAgent;
                    var isAndroid = u.indexOf('Android') > -1; //android终端
                    var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
                    if(isdiOS){
                        function ioscoupon(){
                            window.webkit.messageHandlers.youhuiquan.postMessage('abc');
                        }
                        ioscoupon();
                    }
                    if(isAndroid){
                        function androidcoupon() {
                            window.h5Interface.PersonalCoupon();
                        }
                        androidcoupon();
                    }
                }else{
                    location.href = "http://www.xywykj.com/";
                    return;
                }
            }else{
                if (type == 'h5') {
                    location.href = "<?php echo \yii\helpers\Url::to(['user/login']) ?>";
                    return;
                }else{
                    var url = window.location.href;
                    login(url);
                }
            }
        })
    })
</script>
