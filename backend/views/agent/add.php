<?php
$this->title = '添加代理商';
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

?>
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="member-form">

                        <link href="http://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
                        <link href="<?= Yii::$app->request->baseUrl ?>/css/city-picker.css" rel="stylesheet">
                        <link href="<?= Yii::$app->request->baseUrl ?>/css/main.css" rel="stylesheet">
                        <script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
                        <script src="<?= Yii::$app->request->baseUrl ?>/js/bootstrap.js"></script>
                        <script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
                        <form id="signupForm" class="form-horizontal" action="/agent/add" method="post"
                              enctype="multipart/form-data">
                            <div class="form-group field-tgagent-username">
                                <label class="control-label col-sm-2 control-label" for="tgagent-username">用户名</label>
                                <div class="col-sm-3"><input type='{"maxlength":true}' id="tgagent-username"
                                                             class="form-control" name="TgAgent[username]">
                                    <div class="help-block help-block-error "></div>
                                </div>
                            </div>
                            <div class="form-group field-tgagent-password">
                                <label class="control-label col-sm-2 control-label" for="tgagent-password">密码</label>
                                <div class="col-sm-3"><input type="password" id="tgagent-password" class="form-control"
                                                             name="TgAgent[password]" maxlength="32">
                                    <div class="help-block help-block-error "></div>
                                </div>
                            </div>
                            <div class="form-group field-tgagent-email">
                                <label class="control-label col-sm-2 control-label" for="tgagent-email">邮箱</label>
                                <div class="col-sm-3">
                                    <input type='{"maxlength":true}' id="tgagent-email"
                                           class="form-control" name="TgAgent[email]">
                                    <div class="help-block help-block-error "></div>
                                </div>
                            </div>
                            <div class="form-group field-tgagent-true_name">
                                <label class="control-label col-sm-2 control-label" for="tgagent-true_name">姓名</label>
                                <div class="col-sm-3"><input type='{"maxlength":true}' id="tgagent-true_name"
                                                             class="form-control" name="TgAgent[true_name]">
                                    <div class="help-block help-block-error "></div>
                                </div>
                            </div>
                            <div class="form-group field-tgagent-status">
                                <label class="control-label col-sm-2 control-label" for="tgagent-status">状态</label>
                                <div class="col-sm-3"><select id="tgagent-status" class="form-control"
                                                              name="TgAgent[status]">
                                        <option value="1">启用</option>
                                        <option value="0">禁用</option>
                                    </select>
                                    <div class="help-block help-block-error "></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="tg_address">
                                    <label class="control-label col-sm-2 control-label" for="city-picker3"
                                           style="float: none;display: inline-block;">选择城市</label>
                                    <div style="position: relative;width:400px;display: inline-block;">
                                        <input id="city-picker3" class="form-control" readonly type="text"
                                               value=""
                                               data-toggle="city-picker">

                                    </div>

                                    <div style="display: inline-block;width: 200px;">
                                        <button class="btn btn-warning" id="reset" type="button">重置</button>

                                    </div>
                                    <i class="city_hint"
                                       style="color:#737373;font-style:normal;display: block;font-size:14px;margin:5px 0 0 287px;"></i>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label btn_no"></label>
                                <div class="col-sm-6">
                                    <a class="btn btn-primary btn_ajx">提交</a>
                                    <button type="reset" class="btn btn-danger">重置</button>
                                </div>
                            </div>

                        </form>


                    </div>
                    <style>
                        .control-label:after {
                            content: "：";
                        }

                        .btn_no:after {
                            content: '';
                        }
                    </style>

                </div>
            </div>
        </div>
    </div>


    <script>
        (function (factory) {
            if (typeof define === 'function' && define.amd) {
                // AMD. Register as anonymous module.
                define('ChineseDistricts', [], factory);
            } else {
                // Browser globals.
                factory();
            }
        })(function () {

            var ChineseDistricts = <?php echo \backend\controllers\AgentController::Getprovince() ?>;

            if (typeof window !== 'undefined') {
                window.ChineseDistricts = ChineseDistricts;
            }

            return ChineseDistricts;

        });

    </script>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/city-picker.js"></script>


    <script>
        $(function () {
//            2017年5月16日17:00:55 xhh添加页面验证
            name = $('#tgagent-username').val();
            tishi = $("#tgagent-username").siblings("div");
            passwordtishi = $("#tgagent-password").siblings("div");
            emailtishi = $("#tgagent-email").siblings("div");
            hinesetishi = $("#tgagent-true_name").siblings("div");

            // 验证用户名
            function hotelname(bankname, bankname_b, message) {
                var $this = bankname;
                var thisval = $this.val();
                var $tip = bankname_b;
                if (thisval == '') {
                    $tip.text("用户名已存在")
                    return false;
                }

                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['checkaccount']) ?>",
                    data: {name: thisval},
                    success: function (data) {
                        if (data == 1) {

                            $tip.text("用户名已存在")
                            return false;
                        }

                    }
                })
                if (thisval.length < 5 || thisval.match(/^\s+$/g)) {
                    $tip.text(message);
                    return false;
                } else {
                    $tip.text("")
                    return true;
                }

            }

//            密码
            function passwor(password, password_b) {
                var $this = password;
                var thisval = $this.val();
                var $tip = password_b;
                if (thisval == '') {
                    $tip.text(" 密码不能为空");
                    return false;
                } else {
                    $tip.text("")
                    return true;

                }

            }

            //验证邮箱
            function checkmail(checkMail, checkMail_b) {
                var $this = checkMail;
                var thisval = $this.val();
                var $tip = checkMail_b;
                var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (thisval == "") {
                    $tip.text("邮箱不能为空");
                    return false;
                } else {
                    if (!reg.test(thisval) && thisval != "") {
                        $tip.text("您的电子邮件格式不正确");
                        return false;
                    } else {
                        $tip.text("");
                        return true;
                    }
                }
            }

//            验证姓名
            function hinese(hinese, hinese_b) {
                var $this = hinese;
                var thisval = $this.val();
                var $tip = hinese_b;
                reg = /^([\u2E80-\u9FFF]){2,6}$/;
                if (thisval == '') {
                    $tip.text('姓名不能为空')
                }
                if (!reg.test(thisval)) {
                    $tip.text("姓名填写不正确");
                    return false;
                } else {
                    $tip.text("")
                    return true;
                }
            }


            function city() {
                var cnt = $('.select-item');
                if (cnt.length == 0) {
                    $(".city_hint").text("请选择城市");
                    return false;
                } else {
                    $(".city_hint").text("");
                    return true;
                }
            }

            $('#tgagent-username').blur(function () {
                hotelname($('#tgagent-username'), tishi, '用户名长度不能小于5位');
            })

            $("#tgagent-password").blur(function () {
                passwor($("#tgagent-password"), passwordtishi);
            });

            $("#tgagent-email").blur(function () {
                checkmail($("#tgagent-email"), emailtishi);
            });

            $("#tgagent-true_name").blur(function () {
                hinese($("#tgagent-true_name"), hinesetishi);
            });

            $(".btn_ajx").click(function () {
                if (hotelname($('#tgagent-username'), tishi, '用户名长度不能小于5位') && passwor($("#tgagent-password"), passwordtishi) && checkmail($("#tgagent-email"), emailtishi) && hinese($("#tgagent-true_name"), hinesetishi) && city()) {
                    var username = $('#tgagent-username').val();
                    var password = $('#tgagent-password').val();
                    var email = $('#tgagent-email').val();
                    var true_name = $('#tgagent-true_name').val();
                    var status = $('#tgagent-status').val();
                    var area = $('span.select-item:last').attr('data-code');
                    $.ajax({
                        type: 'post',
                        url: "<?php echo \yii\helpers\Url::to(['ajaxadd']) ?>",
                        data: {
                            username: username,
                            password: password,
                            email: email,
                            true_name: true_name,
                            status: status,
                            area: area
                        },
                        success: function (data) {
                            layer.alert(data);
                            return;


                        }
                    })


                }
            })


        })

    </script>




