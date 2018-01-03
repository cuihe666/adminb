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
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/fullcalendar.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/fullcalendar.print.css"/>
<script src='<?= Yii::$app->request->baseUrl ?>/js/jquery-ui.custom.min.js'></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/fullcalendar.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>
<script type="text/javascript">
    /** 当天信息初始化 **/
    $(function () {
        var dayDate = new Date();
        var d = $.fullCalendar.formatDate(dayDate, "dddd");
        var m = $.fullCalendar.formatDate(dayDate, "yyyy年MM月dd日");
        var lunarDate = lunar(dayDate);
        $(".alm_date").html(m + "&nbsp;" + d);
        $(".today_date").html(dayDate.getDate())
        $("#alm_cnD").html("农历" + lunarDate.lMonth + "月" + lunarDate.lDate);
        $("#alm_cnY").html(lunarDate.gzYear + "年&nbsp;" + lunarDate.gzMonth + "月&nbsp;" + lunarDate.gzDate + "日");
        $("#alm_cnA").html("【" + lunarDate.animal + "年】");
        var fes = lunarDate.festival();
        if (fes.length > 0) {
            $(".alm_lunar_date").html($.trim(lunarDate.festival()[0].desc));
            $(".alm_lunar_date").show();
        } else {
            $(".alm_lunar_date").hide();
        }

    });
    /** calendar配置 **/
    $(document).ready(
        function () {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            $("#calendar").fullCalendar(
                {
//                    2017年5月9日15:59:33 xhh修改了日历禁止拖拽功能
                    editable: false,
                    events: [
                        <?php
                        $data = \backend\controllers\TravelHigoController::getvents($id);

                        foreach ($data as $k => $vv) {
                        ?>
                        {
                            title: '<?php if ($vv['adult_price'] == 0) {
                                echo '成人暂无';
                            } else {
                                echo '成人' . $vv['adult_price'];
                            }?>',
                            start: '<?php  echo substr($vv['date'], 0, 10);?>'

                        },
                        {
                            title: '<?php if ($vv['child_price'] == 0) {
                                echo '儿童暂无';
                            } else {
                                echo '儿童' . $vv['child_price'];
                            }?>',
                            start: '<?php  echo substr($vv['date'], 0, 10);?>'

                        },

                        {
                            title: '<?php if ($vv['stock'] == 0) {
                                echo '库存:无';
                            } else {
                                echo '库存' . $vv['stock'];
                            }?>',
                            start: '<?php  echo substr($vv['date'], 0, 10);?>'

                        },

//                        {
//                            title: '<?php //if ($vv['status'] == 0) {
                        //                                echo '停售中';
                        //                            } else {
                        //                                echo '出售中';
                        //                            }?>//',
//                            start: '<?php // echo substr($vv['date'], 0, 10);?>//'
//
//                        },

                        <?php
                        }

                        ?>
                    ],
                    dayClick: function (dayDate, allDay, jsEvent, view) { //点击单元格事件
                        var d = $.fullCalendar.formatDate(dayDate, "dddd");
                        var m = $.fullCalendar.formatDate(dayDate, "yyyy年MM月dd日");

                        $(".alm_date").html(m + "&nbsp;" + d);
                        $(".today_date").html(dayDate.getDate())
                        $("#alm_cnD").html("农历" + lunarDate.lMonth + "月" + lunarDate.lDate);
                        $("#alm_cnY").html(lunarDate.gzYear + "年&nbsp;" + lunarDate.gzMonth + "月&nbsp;" + lunarDate.gzDate + "日");
                        $("#alm_cnA").html("【" + lunarDate.animal + "年】");
                        var fes = lunarDate.festival();
                        if (fes.length > 0) {
                            $(".alm_lunar_date").html($.trim(lunarDate.festival()[0].desc));
                            $(".alm_lunar_date").show();
                        } else {
                            $(".alm_lunar_date").hide();
                        }
                        // 当天则显示“当天”标识
                        var now = new Date();
                        if (now.getDate() == dayDate.getDate() && now.getMonth() == dayDate.getMonth() && now.getFullYear() == dayDate.getFullYear()) {
                            $(".today_icon").show();
                        } else {
                            $(".today_icon").hide();
                        }
                    },
                    loading: function (bool) {
                        if (bool)
                            $("#msgTopTipWrapper").show();
                        else
                            $("#msgTopTipWrapper").fadeOut();
                    }

                });
        });
    /** 绑定事件到日期下拉框 **/
    $(function () {
        $("#fc-dateSelect").delegate("select", "change", function () {
            var fcsYear = $("#fcs_date_year").val();
            var fcsMonth = $("#fcs_date_month").val();
            $("#calendar").fullCalendar('gotoDate', fcsYear, fcsMonth);
        });
    });
</script>
<style>
    select, input {
        font-family: "微软雅黑"
    }

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

    .theme-sxh2 img, .theme-sxh2 textarea {
        float: left;
    }

    .theme-sxh2 img {
        margin-left: 101px;
    }

    .cont-img img {
        float: left;
        margin-bottom: 10px;
    }

    textarea {
        outline: none;
        resize: none;
    }

    .part_two .right-r {
        float: inherit;
    }

    .part_two .right-l {
        float: inherit;
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

    .part_two .right-r {
        width: 100%;
        margin-top: 0;
    }

    .part_two {
        height: inherit;
    }

    /*2017年5月18日12:11:11 查看图片插件样式*/
    .dowebok1 li {
        display: inline-block;
        width: 200px;
        height: 150px;
        margin: 0 10px 0 0;
    }

    .dowebok1 li img {
        width: 100%;
        height: 100%;
    }
</style>
</head>

<body>
<div class="shenhe-sxh">
    <div class="left">

    </div>
    <div class="right">
        <div class="part_one">
            <div class="top">
                <p>
                    <b>
                        ID：<?php echo $model['id'] ?>
                    </b>
                </p>
                <hr>
            </div>

            <?php if ($model['identity'] == 1): ?>
                <p style="color:#2bab6e;">
                    个人性质公司资质信息:
                </p>
                <div class="rignt-con">
                    <p class="sxh-1">
                        <span>上传时间</span>
                        <input type="text" value="<?= $model['create_time'] ?>" disabled="disabled"
                               style="border:none;background-color: transparent;">
                    </p>
                    <p>
                        <span>公司名称</span>
                        <input type="text" value="<?php echo $model['auth_name'] ?>" readonly>
                    </p>
                    <p class="div-sxh2">
                        <span>公司简介</span>
                        <textarea readonly><?php echo $model['auth_recommend'] ?></textarea>
                    </p>
                    <p class="div-sxh2">
                        <span>资质照片</span>
                        <ul class="dowebok1">
                            <li><img data-original="<?php echo $model['auth_license'] ?>" src="<?php echo $model['auth_license'] ?>" alt=""></li>
                            <li><img data-original="<?php echo $model['auth_operation'] ?>" src="<?php echo $model['auth_operation'] ?>" alt=""></li>
                    </p>
                </div>
            <?php endif ?>
            <p style="color:#2bab6e;margin-top:30px;">
                内容详情：
            </p>
            <div class="rignt-con" style="margin-top:10px;">
                <p class="div-sxh2">
                    <span>封面图片</span>
                    <span style="width:80%;" class="cont-img">
                        <ul class="dowebok1">
                        <?php
                        $title_pics = explode(',', $model['title_pic']);
                        if ($model['title_pic']) {
                            ?>

                            <li><img data-original="<?php echo $title_pics[$model['first_pic']] ?>"
                                     src="<?php echo $title_pics[$model['first_pic']] ?>" alt=""></li>

<!--                            <img data-original="--><?php //echo $title_pics[$model['first_pic']] ?><!--" src="--><?php //echo $title_pics[$model['first_pic']] ?><!--" alt="">-->

                            <?php
                            foreach ($title_pics as $k => $v) {
                                if ($k != $model['first_pic']) {
                                    ?>

                                    <li><img data-original="<?php echo $v ?>" src="<?php echo $v; ?>" alt=""></li>

                                    <!--                                    <img src="--><?php //echo $v ?><!--" alt="">-->
                                    <?php
                                }
                            }
                        }
                        ?>
    </ul>
                    </span>
                </p>
                </p>
                <div style="clear:both;"></div>
                <p>
                    <span>活动名称</span>
                    <input type="text" value="<?php echo htmlspecialchars($model['name']); ?>" style="width: 40%" readonly>
                </p>
                <p class="theme-sxh">
                    <span>活动主题</span>
                    <?php $tags = \backend\models\TravelActivity::gettagarray($model['tag']); ?>
                    <?php if (is_array($tags) && !empty($tags)): ?>
                        <?php foreach ($tags as $kk => $vv): ?>
                            <input type="text" value=<?php echo $vv; ?> disabled="disabled">
                        <?php endforeach; ?>

                    <?php endif ?>
                </p>
                <p>
                    <span>活动城市</span>
                    <input type="text"
                           value="<?php echo \backend\models\TravelActivity::getcity($model['start_city']); ?>"
                           disabled="disabled" style="background-color: transparent;border:none;">
                </p>
                <p>
                    <span>目的地城市</span>
                    <input type="text" value="<?php echo \backend\models\TravelActivity::getcity($model['end_city']); ?>"
                           disabled="disabled" style="background-color: transparent;border:none;">
                </p>
                <p class="div-sxh2">
                    <span>领队简介</span>
                    <textarea readonly><?php echo str_replace("<br>","\n",$model['profiles']); ?></textarea>
                </p>
                <p class="div-sxh2">
                    <span>活动亮点</span>
                    <textarea readonly><?php echo str_replace("<br>","\n",$model['high_light']); ?></textarea>
                </p>
                <?php if (is_array($imgs) && !empty($imgs)): ?>
                    <?php foreach ($imgs as $kk => $vv): ?>
                        <div style="clear: both;"></div>
                        <p class="div-sxh2">
                            <span>行程介绍</span>
                            <input type="text" value="<?php echo $vv['title']; ?>" style="width: 50%;margin-left:0;"  readonly>
                            <textarea readonly
                                    style="margin-left:77px;margin-top:15px;"><?php echo str_replace("<br>","\n",$vv['introduce']); ?></textarea>
                        </p>

                        <?php if ($vv['pic']): ?>
                            <?php

                            $pics = explode(',', $vv['pic']);
                            $pic_explains = explode('***', $vv['pic_explain']);


                            ?>
                            <?php if (is_array($pics) && !empty($pics)): ?>
                                <?php foreach ($pics as $kkk => $vvvv): ?>
                                    <div style="clear:both;height:150px;">
                                        <div class="theme-sxh2">
                                            <span></span>
                                            <ul class="dowebok1" style="float: left;margin-right:54px;">
                                                <li><img data-original="<?php echo $vvvv; ?>" src="<?php echo $vvvv; ?>"
                                                         style="width: 173px;margin-left:77px;height:138px;" alt="">
                                                </li>
                                            </ul>
                                            <!--                                    <img src="-->
                                            <?php //echo $vvvv; ?><!--" alt="" >-->
                                            <textarea readonly> <?php echo str_replace("<br>","\n",@$pic_explains[$kkk]); ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            <?php endif ?>

                        <?php endif ?>
                    <?php endforeach; ?>

                <?php endif ?>
                <div style="clear: both;"></div>
                <p class="theme-sxh3">
                    <span>商家确认</span>
                    <?php if ($model['is_confirm'] == 0): ?>
                        <input type="text" value="无需" readonly style="width: 120px;">
                    <?php else: ?>
                        <input type="text" value="需要" readonly style="width: 120px;">
                    <?php endif ?>
                </p>
                <p class="div-sxh2">
                    <span style="margin-top:5px;display: inline-block;">成团设置</span>
                    <b>提前</b>
                    <input type="number" style="width: 60px;margin-left: 0" readonly value="<?php echo $model['close_day']; ?>">
                    <b>天关团</b>
                </p>
                <p class="theme-sxh4">
                    <span>有效期</span>
                    <input type="text" value="<?php echo substr($model['start_time'], 0, 10); ?>" disabled="disabled">至
                    <input type="text" value="<?php echo substr($model['end_time'], 0, 10); ?>" disabled="disabled">
                </p>
                <p class="theme-sxh4">
                    <span>价格设置</span>
                </p>
                <div class="calendarWrapper" style="border:solid 1px #ddd;width:80%;height: 70%;margin-left:77px;">

                    <div id="calendar" class="dib" style="height:50%;"></div>
                </div>

                <p class="div-sxh2">
                    <span>费用包含</span>
                    <textarea readonly> <?php echo str_replace("<br>","\n",$model['price_in']); ?></textarea>
                </p>
                <p class="div-sxh2">
                    <span>费用不含</span>
                    <textarea readonly> <?php echo str_replace("<br>","\n",$model['price_out']); ?></textarea>
                </p>
                <p class="div-sxh2">
                    <span>退订政策</span>
                    最晚提前
                    <input type="text" value="<?php echo $model['refund_type']; ?>" readonly style="width: 60px;">
                    天可退款
                </p>
                <p class="div-sxh2">
                    <span>退订说明</span>
                    <textarea readonly> <?php echo str_replace("<br>","\n",$model['refund_note']); ?></textarea>
                </p>
                <p class="div-sxh2">
                    <span>预定须知</span>
                    <textarea readonly> <?php echo str_replace("<br>","\n",$model['note']); ?></textarea>
                </p>

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
                                    <td><?php echo $v['reason'] ?></td>
                                    <td><?php echo $v['remarks'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif ?>
                <div class="right-l-btn">
                    <a href="<?php echo Yii::$app->request->getReferrer() ?>" class="btn1">
                        <button type="button" class="btn1">返回</button>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>


<!--2017年5月18日11:51:55 替换公司资质和个人资质的图片查看插件-->
<script>
    $(function () {
        var length = $(".dowebok1").length;
        for (var i = 0; i < length; i++) {
            var viewer = new Viewer(document.getElementsByClassName('dowebok1')[i], {
                url: 'data-original'
            });
        }
    })
</script>


