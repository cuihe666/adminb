<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>大转盘</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/kinerLottery.css">
</head>
<style media="screen">
    .layer3 .close{
        bottom:0;
    }
    .layer .close,.layer2 .close{
        bottom:-30px;
    }
    .layer5 .layer_con{
        top:70%;
    }
    .layer5 .close{
        bottom:8rem;
    }
</style>

<body>
<div class="layer" id="layer">
    <div class="layer_con">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/rorate_tip-bj.png" alt="" class="rorate_tip-bj">
        <div class="reaward">
            <img src="" alt="">
            <div>恭喜你抽中<span id="award"></span>,请记得下单时使用哦！ </div>
        </div>
        <img src="<?= Yii::$app->request->baseUrl ?>/images/close.png" alt="" class="close">
    </div>
</div>
<div class="layer2" id="layer2">
    <div class="layer_con">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/rorate_tip-bj.png" alt="" class="rorate_tip-bj">
        <div class="reaward">
            <img src="" alt="">
            <div>恭喜你抽中<span id="award2"></span>,客服将在7各工作日内联系您领取奖品哦！ </div>
        </div>
        <img src="<?= Yii::$app->request->baseUrl ?>/images/close.png" alt="" class="close">
    </div>
</div>
<!-- 规则 弹框-->
<div class="layer3">
    <div class="layer_con">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/rule_bj.png" alt="" class="record_bj">
        <ul>
            <li>1、活动时间：7月12日-8月12日；</li>
            <li>2、参与活动用户：棠果App注册会员；</li>
            <li>3、参与方式：棠果App会员，每天有一次抽奖机会</li>
            <li>4、领奖方式（优惠劵）：如您抽中优惠劵，系统将会自动绑定在，我的账户--优惠劵中；</li>
            <li>5、实物奖品将在活动结束后，客服人员会联系您，奖品一般会在10工作日内发出；</li>
            <li>6、最终解释权归棠果App所有；</li>
        </ul>
        <img src="<?= Yii::$app->request->baseUrl ?>/images/close.png" alt="" class="close">
    </div>
</div>
<!-- 中奖纪录 弹框-->
<div class="layer4">
    <div class="layer_con">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/record_bj.png" alt="" class="record_bj">
        <ul>
            <li>2017-07-13 16:00   恭喜您抽中棠果旅行背包！</li>
            <li>2017-07-13 16:00   恭喜您抽中60元现金券！</li>
            <li>2017-07-13 16:00   恭喜您抽中10元现金券！</li>
            <li>2017-07-13 16:00   恭喜您抽中10元现金券！</li>
            <li>2017-07-13 16:00   恭喜您抽中10元现金券！</li>
            <li>2017-07-13 16:00   恭喜您抽中棠果杯子！</li>
            <li>2017-07-13 16:00   恭喜您抽中100元现金券！</li>
            <li>2017-07-13 16:00   恭喜您抽中10元现金券！</li>
            <li>2017-07-13 16:00   恭喜您抽中10元现金券！</li>
            <li>2017-07-13 16:00   恭喜您抽中10元现金券！</li>
            <li>2017-07-13 16:00   恭喜您抽中10元现金券！</li>
            <li>2017-07-13 16:00   恭喜您抽中10元现金券！</li>
            <li>2017-07-13 16:00   恭喜您抽中10元现金券！</li>
            <li>2017-07-13 16:00   恭喜您抽中10元现金券！</li>
            <li>2017-07-13 16:00   恭喜您抽中10元现金券！</li>
        </ul>
    </div>
    <img src="<?= Yii::$app->request->baseUrl ?>/images/close.png" alt="" class="close">
</div>
<div class="layer5">
    <div class="layer_con">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/rule_bj_no.png" alt="" class="record_bj">
        <p>不好意思哦亲，今天的抽奖机会已经用完了，请明天再来哟～</p>
    </div>
    <img src="<?= Yii::$app->request->baseUrl ?>/images/close.png" alt="" class="close">
</div>

<div class="main">
    <div class="top">
        <a href="baofa.html">
            <img src="<?= Yii::$app->request->baseUrl ?>/images/fanhui.png" alt="" class="fanhui">
        </a>
        <span>幸运大转盘</span>
        <img src="<?= Yii::$app->request->baseUrl ?>/images/share.png" alt="" class="share">
    </div>
    <div id="box" class="box">
        <div class="outer KinerLottery KinerLotteryContent">
            <img src="<?= Yii::$app->request->baseUrl ?>/images/lotteryContent.png" class="yuan">
        </div>
        <img src="<?= Yii::$app->request->baseUrl ?>/images/shadow.png" alt="" class="shadow">
        <!--        <div class="inner KinerLotteryBtn start"></div>-->
        <input type="button" class="inner KinerLotteryBtn start" id="rorate_btn">
    </div>
    <div class="footer_award">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/btn_rule.png" alt="" class="btn1">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/btn_record.png" alt="" class="btn2">
    </div>

</div>

<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script>$.noConflict();</script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/zepto.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/kinerLottery.js"></script>
<input type="hidden" value="<?php echo isset($_GET['uid'])?$_GET['uid']:0; ?>" class="uid">
<script type="text/javascript">
    $(function(){
        $(".footer_award .btn1").click(function(){
            $(".layer3").show()
        })
        $(".footer_award .btn2").click(function(){
            $(".layer4").show()
        })
        $(".layer4 .close").click(function(){
            $(".layer4").hide()
        })
        $(".layer5 .close").click(function(){
            $(".layer5").hide()
        })
        $(".layer3 .close").click(function(){
            $(".layer3").hide()
        })
        $(".layer .close").click(function(){
            $(".layer").hide()
        })
        $(".layer2 .close").click(function(){
            $(".layer2").hide()
        })

        // 只能抽一次奖
        $(".KinerLotteryBtn").click(function(){
//            if($(this).hasClass("doing")){
//
//            }
            var uid=$('.uid').val();
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['check-award']) ?>",
                data: {uid: uid, "_csrf-frontend": "<?php echo Yii::$app->request->csrfToken ?>"},
                success: function (data) {
                    if(data==0){
                        $(".layer5").show();
//                        $(this).die('click')
                        $("#rorate_btn").attr("disabled", true);
                        $(".KinerLotteryContent").css({"transition":"none","transform":" rotate(0deg)","-webkit-transform":" rotate(0deg)"})
                    }
                }
            })
        })
    })
</script>
<script>
    /**
     * 根据转盘旋转角度判断获得什么奖品
     * @param deg
     * @returns {*}
     */

    var whichAward = function(deg) {
        if ((deg > 330 && deg <= 360)) {
            var deg = Number(deg) +60;
            $("body").find('.KinerLotteryContent').css({
                '-webkit-transition': 'none',
                'transition': 'none',
                '-webkit-transform': 'rotate(' + (deg) + 'deg)',
                'transform': 'rotate(' + (deg) + 'deg)'
            });
            return "60元现金券";
        }else if(deg > 0 && deg <= 30){
            var deg = Number(deg) +60;
            $("body").find('.KinerLotteryContent').css({
                '-webkit-transition': 'none',
                'transition': 'none',
                '-webkit-transform': 'rotate(' + (deg) + 'deg)',
                'transform': 'rotate(' + (deg) + 'deg)'
            });
            return "60元现金券";
        }else if ((deg > 30 && deg <= 90)) {
            return "60";
        } else if (deg > 90 && deg <= 150) {
            var deg = Number(deg) +60;
            $("body").find('.KinerLotteryContent').css({
                '-webkit-transition': 'none',
                'transition': 'none',
                '-webkit-transform': 'rotate(' + (deg) + 'deg)',
                'transform': 'rotate(' + (deg) + 'deg)'
            });
            return "10元现金券";
        } else if (deg > 150 && deg <= 210) {
            return "10元现金券";
        } else if (deg > 210 && deg <= 270) {
            var deg = Number(deg) +60;
            $("body").find('.KinerLotteryContent').css({
                '-webkit-transition': 'none',
                'transition': 'none',
                '-webkit-transform': 'rotate(' + (deg) + 'deg)',
                'transform': 'rotate(' + (deg) + 'deg)'
            });
            return "棠果杯子";
        } else if (deg > 270 && deg <= 330) {
            return "棠果杯子";
        }
    }
    //    var whichAward = function(deg) {
    //        if ((deg > 330 && deg <= 360)) {
    //          var deg = Number(deg) -180;
    //          $("body").find('.KinerLotteryContent').css({
    //              '-webkit-transition': 'none',
    //              'transition': 'none',
    //              '-webkit-transform': 'rotate(' + (deg) + 'deg)',
    //              'transform': 'rotate(' + (deg) + 'deg)'
    //          });
    //          return "10元现金券";
    //        }else if(deg > 0 && deg <= 30){
    //          var deg = Number(deg) +180;
    //          $("body").find('.KinerLotteryContent').css({
    //              '-webkit-transition': 'none',
    //              'transition': 'none',
    //              '-webkit-transform': 'rotate(' + (deg) + 'deg)',
    //              'transform': 'rotate(' + (deg) + 'deg)'
    //          });
    //            return "10元现金券";
    //        }else if ((deg > 30 && deg <= 90)) {
    //            var deg = Number(deg) +180;
    //          $("body").find('.KinerLotteryContent').css({
    //              '-webkit-transition': 'none',
    //              'transition': 'none',
    //              '-webkit-transform': 'rotate(' + (deg) + 'deg)',
    //              'transform': 'rotate(' + (deg) + 'deg)'
    //          });
    //            return "棠果杯子";
    //        } else if (deg > 90 && deg <= 150) {
    //            return "60元现金券";
    //        } else if (deg > 150 && deg <= 210) {
    //            return "10元现金券";
    //        } else if (deg > 210 && deg <= 270) {
    //            return "棠果杯子";
    //        } else if (deg > 270 && deg <= 330) {
    //          var deg = Number(deg) - 180
    //          $("body").find('.KinerLotteryContent').css({
    //              '-webkit-transition': 'none',
    //              'transition': 'none',
    //              '-webkit-transform': 'rotate(' + (deg) + 'deg)',
    //              'transform': 'rotate(' + (deg) + 'deg)'
    //          });
    //
    //            return "60元现金券";
    //        }
    //    }
    var KinerLottery = new KinerLottery({
        rotateNum: 5, //转盘转动圈数
        body: "#box", //大转盘整体的选择符或zepto对象
        direction: 0, //0为顺时针转动,1为逆时针转动

        disabledHandler: function(key) {
            switch (key) {
                case "noStart":
                    alert("活动尚未开始");
                    break;
                case "completed":
                    alert("活动已结束");
                    break;
            }

        }, //禁止抽奖时回调

        clickCallback: function() {
            //此处访问接口获取奖品
            function random() {
                return Math.floor(Math.random() * 360);
            }
            this.goKinerLottery(random(1));
        }, //点击抽奖按钮,再次回调中实现访问后台获取抽奖结果,拿到抽奖结果后显示抽奖画面

        KinerLotteryHandler: function(deg) {
            if ((deg > 330 && deg <= 360) || (deg > 0 && deg <= 30)) {
                // iPhone
                var uid=$('.uid').val();
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['get-award']) ?>",
                    data: {uid: uid, "_csrf-frontend": "<?php echo Yii::$app->request->csrfToken ?>",title:'iPhone 7',id:1},
                    success: function (data) {
                        document.getElementById("award").innerHTML = whichAward(deg);
                        jQuery("#layer2").delay(300).fadeIn();
                        $(".reaward img").attr("src","<?= Yii::$app->request->baseUrl ?>/images/tg_cup.png").css({"width":"50%","margin-left":"25%"})
                    }
                })
            } else if ((deg > 30 && deg <= 90)) {
                // 60元现金券
                var uid=$('.uid').val();
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['get-award']) ?>",
                    data: {uid: uid, "_csrf-frontend": "<?php echo Yii::$app->request->csrfToken ?>",title:'iPhone 7',id:2},
                    success: function (data) {
                        jQuery("#layer").delay(300).fadeIn()
                        document.getElementById("award").innerHTML =whichAward(deg);
                        $(".reaward img").attr("src","<?= Yii::$app->request->baseUrl ?>/images/sixty.png");
                    }
                })
            } else if (deg > 90 && deg <= 150) {
                // 12199元 德法意瑞 10晚13日游
                // document.getElementById("layer2").style.display = "block";
                jQuery("#layer2").delay(300).fadeIn()
                document.getElementById("award2").innerHTML =whichAward(deg)
                $(".reaward img").attr("src","<?= Yii::$app->request->baseUrl ?>/images/sixty.png")

            } else if (deg > 150 && deg <= 210) {
                // 60元现金券
                // document.getElementById("layer").style.display = "block";
                jQuery("#layer").delay(300).fadeIn()

                document.getElementById("award").innerHTML =whichAward(deg);
                $(".reaward img").attr("src","<?= Yii::$app->request->baseUrl ?>/images/ten_reward.png")

            } else if (deg > 210 && deg <= 270) {
                // 棠果杯子
                // document.getElementById("layer2").style.display = "block";
                document.getElementById("award2").innerHTML =whichAward(deg);
                jQuery("#layer2").delay(300).fadeIn()
                $(".reaward img").attr("src","<?= Yii::$app->request->baseUrl ?>/images/tg_cup.png").css({"width":"50%","margin-left":"25%"})

            } else if (deg > 270 && deg <= 330) {
                // 3999元吉普岛6日4晚游
                // document.getElementById("layer2").style.display = "block";
                jQuery("#layer2").delay(300).fadeIn()
                document.getElementById("award2").innerHTML =whichAward(deg);
                $(".reaward img").attr("src","<?= Yii::$app->request->baseUrl ?>/images/tg_cup.png").css({"width":"50%","margin-left":"25%"})
            }
        } //抽奖结束回调
    });
</script>
</body>
</html>
