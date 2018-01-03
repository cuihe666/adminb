<?php
use yii\helpers\Url;

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
    .f_compari{font-style: normal; display: inline-block; margin-left: 10px; color:#FF0000}
    .rignt-con input.f_compari_border,.rignt-con textarea.f_compari_border,.dowebok1 li img.f_compari_border{ border:2px solid #FF0000;}
    .current-dis label{ color:#333;}
</style>
</head>

<body>
<div class="shenhe-sxh">
    <div class="left"></div>
    <div class="right">
        <div class="part_one">
            <div class="top">
                <p>
                    <b>ID：<?php echo $model['id'] ?></b>
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
                        <input type="text" value="<?= $model['create_time'] ?>" disabled="disabled" style="border:none;background-color: transparent;">
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
                        if ($model['title_pic']) { ?>
                            <li><img data-original="<?php echo $title_pics[$model['first_pic']] ?>" src="<?php echo $title_pics[$model['first_pic']] ?>" alt=""></li>
                            <?php
                            foreach ($title_pics as $k => $v) {
                                if ($k != $model['first_pic']) {
                                    ?>
                                    <li><img data-original="<?php echo $v ?>" src="<?php echo $v; ?>" alt=""></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </ul>
                    </span>
                </p>
                <div style="clear:both;"></div>
                <p>
                    <span>活动名称</span>
                    <?php
                        $class = "";
                        $msg = '';
                        if($compari && $model->name!=$compari['name'] && $model->status == 0):
                            $class = "f_compari_border";
                            $msg = '<em class="f_compari">已修改</em>';
                        endif;
                    ?>
                    <input type="text" value="<?php echo htmlspecialchars($model['name']); ?>" style="width: 40%" readonly class='<?=$class?>'>
                    <?= $msg?>
                </p>
                <p class="theme-sxh">
                    <span>活动主题</span>
                    <?php $tags = \backend\models\TravelActivity::gettagarray($model['tag']); ?>
                    <?php
                        $tag = '';
                        if (is_array($tags) && !empty($tags)):
                            foreach ($tags as $kk => $vv):
                                $tag .= $vv."&nbsp;&nbsp;";
                            endforeach;
                        endif
                    ?>
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->tag!=$compari['tag'] && $model->status == 0):
                        $class = "f_compari_border";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <input type="text" value=<?=trim($tag) ?> disabled="disabled" style="width:220px;" class='<?=$class?>'>
                    <?= $msg?>
                </p>
                <p>
                    <span>活动城市</span>
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->start_city!=$compari['start_city'] && $model->status == 0):
                        $class = "f_compari_border";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <input type="text"
                           value="<?php echo \backend\models\TravelActivity::getcity($model['start_city']); ?>" disabled="disabled" style="background-color: transparent;" class='<?=$class?>'>
                    <?= $msg?>
                </p>
                <p>
                    <span>目的城市</span>
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->end_city!=$compari['end_city'] && $model->status == 0):
                        $class = "f_compari_border";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <input type="text" value="<?php echo \backend\models\TravelActivity::getcity($model['end_city']); ?>" disabled="disabled" style="background-color: transparent;" class='<?=$class?>'>
                    <?= $msg?>
                </p>
                <p class="div-sxh2">
                    <span>领队简介</span>
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->profiles!=$compari['profiles'] && $model->status == 0):
                        $class = "f_compari_border";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <textarea readonly class='<?=$class?>'><?php echo str_replace("<br>","\n",$model['profiles']); ?></textarea>
                    <?= $msg?>
                </p>
                <p class="div-sxh2">
                    <span>活动亮点</span>
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->high_light!=$compari['high_light'] && $model->status == 0):
                        $class = "f_compari_border";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <textarea readonly class='<?=$class?>'><?php echo str_replace("<br>","\n",$model['high_light']); ?></textarea>
                    <?= $msg?>
                </p>
                <?php if (is_array($imgs) && !empty($imgs)): ?>
                    <?php foreach ($imgs as $kk => $vv): ?>
                        <div style="clear: both;"></div>
                        <p class="div-sxh2">
                            <span>行程介绍</span>
                            <?php
                            $class = "";
                            $msg = '';
                            if($oldConArr[$kk] && $model->status == 0){
                                if($vv['title']!=$oldConArr[$kk]['title']){
                                    $class = "f_compari_border";
                                    $msg = '<em class="f_compari">已修改</em>';
                                }
                            } elseif($model->status == 0 && $oldConArr){
                                $class = "f_compari_border";
                                $msg = '<em class="f_compari">新增</em>';
                            }
                            ?>
                            <input type="text" value="<?php echo $vv['title']; ?>" style="width: 50%;margin-left:0;"  readonly class='<?=$class?>'>
                            <?= $msg?>
                            <?php
                            $class = "";
                            $msg = '';
                            if($oldConArr[$kk] && $model->status == 0){
                                if($vv['introduce']!=$oldConArr[$kk]['introduce']){
                                    $class = "f_compari_border";
                                    $msg = '<em class="f_compari">已修改</em>';
                                }
                            }  elseif($model->status == 0 && $oldConArr){
                                $class = "f_compari_border";
                                $msg = '<em class="f_compari">新增</em>';
                            }
                            ?>
                            <textarea readonly style="margin-left:77px;margin-top:15px;" class='<?=$class?>'><?php echo str_replace("<br>","\n",$vv['introduce']); ?></textarea>
                            <?= $msg?>
                        </p>

                        <?php if ($vv['pic']): ?>
                            <?php
                            //用户修改之后的行程详情
                            $pics = explode(',', $vv['pic']);
                            $pic_explains = explode('***', $vv['pic_explain']);
                            //用户修改之前的行程详情
                            $pics_old = explode(',', $oldConArr[$kk]['pic']);
                            $pic_explains_old = explode('***', $oldConArr[$kk]['pic_explain']);
                            ?>
                            <?php if (is_array($pics) && !empty($pics)): ?>
                                <?php foreach ($pics as $kkk => $vvvv): ?>
                                    <div style="clear:both;height:150px;">
                                        <div class="theme-sxh2">
                                            <span></span>
                                            <ul class="dowebok1" style="float: left;margin-right:54px;">
                                                <?php
                                                $class = "";
                                                $msg = '';
                                                if($pics_old[$kkk] && $model->status == 0){
                                                    if($vvvv!=$pics_old[$kkk]){
                                                        $class = "f_compari_border";
                                                        $msg = '<em class="f_compari">已修改</em>';
                                                    }
                                                } elseif($model->status == 0 && $oldConArr){
                                                    $class = "f_compari_border";
                                                    $msg = '<em class="f_compari">新增</em>';
                                                }
                                                ?>
                                                <li><img data-original="<?php echo $vvvv; ?>" src="<?php echo $vvvv; ?>" style="width: 173px;margin-left:77px;height:138px; display: inline-block" alt="" class='<?=$class?>'>
                                                </li>
                                            </ul>
                                            <?php
                                            $class = "";
                                            $msg = '';
                                            if($pics_old[$kkk] && /*$pic_explains_old[$kkk] &&*/ $model->status == 0){
                                                if($pic_explains[$kkk]!=$pic_explains_old[$kkk]){
                                                    $class = "f_compari_border";
                                                    $msg = '<em class="f_compari">已修改</em>';
                                                }
                                            } elseif($model->status == 0 && $oldConArr){
                                                $class = "f_compari_border";
                                                $msg = '<em class="f_compari">新增</em>';
                                            }
                                            ?>
                                            <textarea readonly class='<?=$class?>'> <?php echo str_replace("<br>","\n",@$pic_explains[$kkk]); ?></textarea>
                                            <?= $msg?>
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
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->is_confirm!=$compari['is_confirm'] && $model->status == 0):
                        $class = "f_compari_border";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <?php if ($model['is_confirm'] == 0): ?>
                        <input type="text" value="无需" readonly style="width: 120px;" class='<?=$class?>'>
                    <?php else: ?>
                        <input type="text" value="需要" readonly style="width: 120px;" class='<?=$class?>'>
                    <?php endif ?>
                    <?=$msg?>
                </p>
                <p class="div-sxh2">
                    <span style="margin-top:5px;display: inline-block;">成团设置</span>
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->close_day!=$compari['close_day'] && $model->status == 0):
                        $class = "f_compari_border";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <b>提前</b>
                    <input type="number" style="width: 60px;margin-left: 0" readonly value="<?php echo $model['close_day']; ?>" class='<?=$class?>'>
                    <b>天关团</b>
                    <?=$msg?>
                </p>
                <p class="theme-sxh4">
                    <span>有效期</span>
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->start_time!=$compari['start_time'] && $model->status == 0):
                        $class = "color:#FF0000; font-weight:bold;";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <input type="text" value="<?php echo substr($model['start_time'], 0, 10); ?>" readonly style='<?=$class?>'>至
                    <?php
                    $class = "";
                    $msg1 = '';
                    if($compari && $model->end_time!=$compari['end_time'] && $model->status == 0):
                        $class = "color:#FF0000; font-weight:bold;";
                        $msg1 = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <input type="text" value="<?php echo substr($model['end_time'], 0, 10); ?>" readonly style='<?=$class?>'>
                    <?php if($msg) echo $msg; else echo $msg1; ?>
                </p>
                <p class="theme-sxh4">
                    <span>价格设置</span>
                </p>
                <div class="calendarWrapper" style="border:solid 1px #ddd;width:80%;height: 70%;margin-left:77px;">
                    <div id="calendar" class="dib" style="height:50%;"></div>
                </div>
                <p class="div-sxh2">
                    <span>费用包含</span>
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->price_in!=$compari['price_in'] && $model->status == 0):
                        $class = "f_compari_border";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <textarea readonly class='<?=$class?>'> <?php echo str_replace("<br>","\n",$model['price_in']); ?></textarea>
                    <?=$msg?>
                </p>
                <p class="div-sxh2">
                    <span>费用不含</span>
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->price_out!=$compari['price_out'] && $model->status == 0):
                        $class = "f_compari_border";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <textarea readonly class='<?=$class?>'> <?php echo str_replace("<br>","\n",$model['price_out']); ?></textarea>
                    <?=$msg?>
                </p>
                <p class="div-sxh2">
                    <span>退订政策</span>
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->refund_type!=$compari['refund_type'] && $model->status == 0):
                        $class = "f_compari_border";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    最晚提前
                    <input type="text" value="<?php echo $model['refund_type']; ?>" readonly style="width: 60px;" class='<?=$class?>'>
                    天可退款
                    <?=$msg?>
                </p>
                <p class="div-sxh2">
                    <span>退订说明</span>
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->refund_note!=$compari['refund_note'] && $model->status == 0):
                        $class = "f_compari_border";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <textarea readonly class='<?=$class?>'> <?php echo str_replace("<br>","\n",$model['refund_note']); ?></textarea>
                    <?=$msg?>
                </p>
                <p class="div-sxh2">
                    <span>预定须知</span>
                    <?php
                    $class = "";
                    $msg = '';
                    if($compari && $model->note!=$compari['note'] && $model->status == 0):
                        $class = "f_compari_border";
                        $msg = '<em class="f_compari">已修改</em>';
                    endif;
                    ?>
                    <textarea readonly class='<?=$class?>'> <?php echo str_replace("<br>","\n",$model['note']); ?></textarea>
                    <?=$msg?>
                </p>
            </div>
        </div>
        <div class="part_two">
            <div class="top">
                <p>
                    <b>审核</b>
                </p>
                <hr>
                <?php if ($model['status'] == 0): ?>
                    <div class="rignt-con right-con2 right-l" style="width: 46%;">
                        <div class="right-l-con current-dis">
                            <p>
                                <span class="light-sxh">审核：</span>
                                <form style="display: inline-block;">
                                    <input type="radio" id="nba" name="status" value="1" checked="'true">
                                    <label name="nba" for="nba" class="checked label">
                                        <i>通过审核</i>
                                    </label>
                                    <input class="nvradio" type="radio" name="status" value="3" id='cba'>
                                    <label name="cba" for="cba" class="label2">
                                        <i>未通过审核</i>
                                    </label>
                                </form>
                            </p>
                            <div class="dis-sxh">
                                <p>
                                    <span class="light-sxh">备注：</span>
                                    <textarea placeholder="选填" id="des"></textarea>
                                </p>
                            </div>
                            <div class="dis-sxh2">
                                <p>
                                    <span class="light-sxh">原因：</span>
                                    <textarea placeholder="必填" id="reason"></textarea>
                                </p>
                            </div>
                        </div>
                        <?php if (!empty($logs['list'])): ?>
                            <div class="right-r">
                                <p>操作日志：</p>
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
                                            <td><?php
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
                                                ?></td>
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
                            <button type="submit" class="btn2 ajaxbtn" style="margin-left: 50px;">提交</button>
                        </div>
                    </div>
                <?php endif ?>
                <?php if ($model['status'] == 1 || $model['status'] == 2): ?>
                    <div class="rignt-con right-con2 right-l">
                        <div class="right-l-con current-dis">
                            <p>
                                <span class="light-sxh">审核：</span>
                            <form style="display: inline-block;">
                                <input type="radio" id="nba" name="status" value="1" checked="'true">
                                <label name="nba" for="nba" class="checked label">
                                    <i>已通过</i>
                                </label>

                            </form>
                            </p>
                            <div class="dis-sxh">
                                <p>
                                    <span class="light-sxh">备注：</span>
                                    <textarea id="des"> <?php echo $model['remarks'] ?></textarea>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($logs['list'])): ?>
                        <div class="right-r">
                            <p>
                                操作日志：
                            </p>
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
                                        <td><?php
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
                                            ?></td>
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
                <?php endif ?>
                <?php if ($model['status'] == 3): ?>
                    <div class="rignt-con right-con2 right-l">
                        <div class="right-l-con current-dis">
                            <p>
                                <span class="light-sxh">审核：</span>
                            <form style="display: inline-block;">
                                <input type="radio" id="nba" name="status" value="1" checked="'true">
                                <label name="nba" for="nba" class="checked label">
                                    <i>未通过</i>
                                </label>
                            </form>
                            </p>
                            <div class="dis-sxh">
                                <p>
                                    <span class="light-sxh">备注：</span>
                                    <textarea id="des"> <?php echo $model['remarks'] ?></textarea>
                                </p>
                            </div>
                            <div class="dis-sxh2" style="display:block">
                                <p>
                                    <span class="light-sxh">原因：</span>
                                    <textarea placeholder="必填" id="reason"><?php echo $model['reason'] ?></textarea>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($logs['list'])): ?>
                        <div class="right-r">
                            <p>
                                操作日志：
                            </p>
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
                                        <td><?php
                                            if ($v['status'] == 1) {
                                                echo '通过审核/上线';
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
                                            ?></td>
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
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<script>
    $('.ajaxbtn').click(function () {
        var id = <?php echo $id ?>;
        var status = $('input[name="status"]:checked').val();
        var reason = $('#reason').val();
        var des = $("#des").val();
        if (status == 3) {
            if (reason == '') {
                layer.alert('原因不能为空');
                return false;
            }
        }
        layer.confirm('确认要发布吗', {icon: 3, title: '友情提示'}, function (index) {
            $.post("<?=Url::to(["travel-higo/check"])?>", {
                "PHPSESSID": "<?php echo session_id();?>",
                "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                data: {
                    id: id,
                    status: status,
                    des: des,
                    reason: reason,
                },
            }, function (data) {
                if (data == 1) {

                    layer.alert('操作成功');
                    /* window.location.href = '<?php echo \yii\helpers\Url::to(['travel-higo/index']) ?>';*/
                    //2017年6月23日18:08:19       付燕飞 修改，操作成功后跳转回的页面记录搜索条件
                    window.location.href = '<?php echo Yii::$app->request->getReferrer() ?>';
                }
            });
        });
    })
</script>
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