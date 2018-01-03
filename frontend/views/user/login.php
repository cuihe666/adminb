<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="pragma" content="no-cache"/>
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no"
          name="viewport" id="viewport"/>
    <title>快捷登录</title>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/kinerLottery.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/js/zepto.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.md5.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/layer/layer.js"></script>
    <style media="screen">
        .main {
            background-image: none;
        }

        .main .top {
            background-color: #fff;
            color: #333;
            border-bottom: 1px solid #efefef;
            height: 40px;
            position: inherit;
            top: 0;
            line-height: 40px;

        }

        .top .fanhui {
            top: 8px;
        }

        html, body {
            position: relative;
        }

        .layer_tel {
            position: absolute;
            left: 20%;
            top: 30%;
            background-color: rgba(0, 0, 0, 0.7);
            width: 60%;
            height: 35px;
            z-index: 5;
            text-align: center;
            color: #fff;
            line-height: 35px;
            margin-top: 24%;
            font-size: 0.5rem;
            display: none;
        }

        input, button {
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
            -webkit-appearence: none;
        }

    </style>
</head>

<body>
<div class="layer_tel">
    <p>请输入正确的手机号</p>
</div>
<div class="main">
    <div class="top">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/fanhui_b.png" alt="" class="fanhui">
        <span>快捷登录</span>
        <!--        <img src="/images/share_b.png" alt="" class="share">-->
    </div>
    <div class="login">
        <input type="text" hidden="hidden" id="hidden">
        <p>
            <span>+86</span>
            <input type="number" id="mobile" placeholder="请输入手机号" onblur="cellNumber(this.parentElement)">
            <i></i>
        </p>
        <p class="yz">
            <img src="<?= Yii::$app->request->baseUrl ?>/images/xinxi_icon.png" alt="" class="xinxi_icon">
            <input type="number" placeholder="请输入验证码" class="yz-ma">
            <input type="button" value="获取验证码" class="yz-btn" onclick="settime(this)"/>
        </p>
        <div class="submit">
            <input type="hidden" value="<?php echo isset($_GET['source']) ? $_GET['source'] : 'default'; ?>"
                   class="source">
            <button type="button" name="button" class="submit_btn">登录</button>
        </div>
    </div>
</div>
</body>
</html>
<script>
    /* 验证码 */
    var countdown = 60;
    function settime(val) {
        if (document.getElementById("hidden").value == 1) {
            /* 验证码发送 */
            if (countdown == 0) {
                val.removeAttribute("disabled");
                val.value = "重新获取";
                countdown = 60;
                return;
            } else {
                val.setAttribute("disabled", true);
                val.value = "" + countdown + 's';
                countdown--;
                setTimeout(function () {
                    settime(val)
                }, 1000)
            }
        } else {
            document.getElementById("hidden").value == ""
        }
    }

    $('.yz-btn').click(function () {
        if ($('#hidden').val() == 1) {
            send_verify();
        }
    })

    $('.fanhui').click(function () {
        history.back();
    })
    $('.share').click(function () {
        var url = $('.url').val() + '?type=h5';
        var img = 'share__78.png';
        var title = '棠果旅居节';
        var content = '测试内容';
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
    function send_verify() {
        var verify = '86';
        var mobile = $("#mobile").val();
        var str = $.md5("areaCode=86&mobile=" + mobile + "&sendMode=sms");
        var sign_s = $.md5(str + '654eva321');
        $.post("<?=\yii\helpers\Url::to(['user/send_verify'])?>", {
            "PHPSESSID": "<?php echo session_id();?>",
            "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
            dataType: 'json',
            data: {areaCode: verify, mobile: mobile, sendMode: 'sms', sign: sign_s},
        }, function (data) {
            var info = $.parseJSON(data);
//							console.log(info);
            if ($.parseJSON(data).code == 0) {
                layer.msg("验证码发送成功", {time: 2000});
            } else {
                layer.alert($.parseJSON(data).mes);
            }
        });
    }

    $('.submit_btn').click(function () {
        var mobile = $("#mobile").val();
        var verify = $(".yz-ma").val();
        if (mobile && verify) {
            login_fast();
        }
    })

    function login_fast() {
        var mobile = $("#mobile").val();
        var verify = $(".yz-ma").val();
        var source = $('.source').val();
        if (source == 'default') {
            var source_value = 1;
        } else if (source == 'today') {
            var source_value = 222;
        } else if (source == 'wx') {
            var source_value = 333;
        }else if(source == 'gd'){
            var source_value = 444;
        }else{
            var source_value = 0;
        }
        $.post("<?=\yii\helpers\Url::to(['user/login_fast'])?>", {
            "PHPSESSID": "<?php echo session_id();?>",
            "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
            dataType: 'json',
            data: {account: mobile, verify: verify, source: source_value},
        }, function (data) {
            var info = $.parseJSON(data);
//							console.log(info);
            if ($.parseJSON(data).code == 0) {
                var uid = info.data.uid;
                location.href = "/activity/baofa?type=h5&uid=" + uid;
            } else {
                layer.alert($.parseJSON(data).mes);
            }
        });
    }
    //验证手机号
    function cellNumber(num) {
        var $p = $(num);
        var $inputmane = $p.find("input");
        var thisval = $inputmane.val();
        var reg = /^0?1[3|7|4|5|8][0-9]\d{8}$/;
        if (!reg.test(thisval)) {
            document.getElementById("hidden").value = "";
            $(".layer_tel").show()
            setTimeout(function () {
                $(".layer_tel").hide()
            }, 2000)
        } else {
            document.getElementById("hidden").value = 1;
        }
    }

</script>
