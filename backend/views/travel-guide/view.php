<?php
use yii\helpers\Url;
$this->title = '当地向导详情';
$this->params['breadcrumbs'][] = $this->title;
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
//                    2017年5月9日16:09:34 xhh修改了日历禁止拖拽功能
                    editable: false,
                    events: [
                        <?php
                        $data = \backend\controllers\TravelGuideController::getvents($id);

                        foreach ($data as $k => $vv) {
                        ?>
                        {

                            title: '<?php if ($vv['price'] == 0) {
                                echo '暂无';
                            } else {
                                echo $vv['price'] . '元';
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

                        {
                            title: '<?php if ($vv['status'] == 0) {
                                echo '停售中';
                            } else {
                                echo '出售中';
                            }?>',
                            start: '<?php  echo substr($vv['date'], 0, 10);?>'

                        },
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
    .theme-sxh2 img{
        margin-left:76px;
    }
    .theme-sxh2 img,.theme-sxh2 textarea{
        float: left;
    }
    .theme-sxh2{
        height:140px;
        margin-bottom: 16px;
    }
    .cont-img img{
        margin-bottom:10px;
    }
    .cont-img img{
        float:left;
        margin-bottom:10px;
    }
    .rignt-con .div-sxh2 img{
        margin-left:5px;
    }
    .part_two label{
        color:#333;
        font-size: 12px;
        line-height: 20px;
    }
    .theme-sxh2{
        overflow: hidden;
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
    .part_two{
        height:inherit;
    }
    /*2017年5月18日12:11:11 查看图片插件样式*/
    .dowebok1 li {
        display: inline-block;
        width:200px ;
        height:138px;
        margin:0 10px 0 0;
    }

    .dowebok1 li img {
        width: 100%;
        height:100%;
    }
    .tit{
        display: inline-block;
        width: 56px;
        text-align: left!important;
    }

    .f_compari{font-style: normal; display: inline-block; margin-left: 10px; color:#FF0000}
    .rignt-con input.f_compari_border,.rignt-con textarea.f_compari_border,.dowebok1 li img.f_compari_border,.rignt-con select.f_compari_border{ border:2px solid #FF0000;}

    .p_line{ overflow: hidden}
    .p_line span{ display: inline-block; /*width:60px;*/ text-align: right;}
    .p_line .pic_span{ display: block;}
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
                    <b>序号:<?php echo $model['id'] ?></b>
                </p>
                <hr>
            </div>
            <div class="rignt-con">
                <div class="div-sxh2 p_line">
                    <span class="pic_span tit">封面图片</span>
                    <div style="width:80%;float: left;text-align: left;" class="cont-img">
                        <ul class="dowebok1">
                            <?php
                            $title_pics = explode(',', $model['title_pic']);
                            if ($model['title_pic']) {?>
                                <li><img data-original="<?php echo $model['first_pic'] ?>" src="<?php echo $model['first_pic'] ?>" alt=""></li>
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
                    </div>
                </div>
                <div style="clear: both;"></div>
                <p class="p_line" style="margin-top:20px;">
                    <span class="tit">性别</span>
                    <input type="text" style="width:60%; border:0;" value="<?php echo Yii::$app->params['sex'][$model->sex] ?>" readonly />
                </p>
                <p class="p_line" style="margin-top:20px;">
                    <span class="tit">联系电话</span>
                    <input type="text" style="width:220px;" value="<?php echo $model->mobile ?>" readonly />
                </p>
                <p class="theme-sxh p_line">
                    <span class="tit">标签</span>
                    <input type="text" value="<?=($model['tag'])?\backend\service\TravelTagService::getTagById($model['tag'],4):'' ?>" readonly style="width:220px;">
                </p>
                <p class="p_line" style="margin-top:20px;">
                    <span class="tit">标题</span>
                    <input type="text" style="width:60%;" value="<?php echo htmlspecialchars($model['title']) ?>" readonly />
                </p>
                <p class="div-sxh2 p_line">
                    <span class="tit">服务内容</span>
                    <textarea readonly><?php echo str_replace("<br>","\n",$model['service_content']); ?></textarea>
                </p>
                <?php if (is_array($imgs) && !empty($imgs)):?>
                    <?php foreach ($imgs as $kk => $vv): ?>
                        <div class="theme-sxh2">
                            <span></span>
                            <ul class="dowebok1" style="float: left;margin-right:54px;">
                                <li><img data-original="<?php echo $vv['pic']; ?>" src="<?php echo $vv['pic']; ?>" style="width: 173px;"></li>
                            </ul>
                            <textarea readonly> <?php echo str_replace("<br>","\n",$vv['pic_desc']); ?></textarea>
                        </div>
                    <?php endforeach; ?>
                <?php endif ?>
                <p class="p_line">
                    <span class="tit">服务城市</span>
                    <input type="text" value="<?php echo \backend\models\TravelActivity::getcity($model['city']) ?>" readonly style="background-color: transparent;" >
                </p>
                <p class="p_line">
                    <span class="tit">服务语言</span>
                    <?php
                    $language = "";
                    if($model->language){
                        $languageArr = explode(",",$model->language);
                        if($languageArr){
                            foreach($languageArr as $key=>$val){
                                if($val==4)
                                    $language .=  Yii::$app->params['travel_language'][$val]."[".$model->language_other."],";
                                else
                                    $language .= Yii::$app->params['travel_language'][$val].",";
                            }
                        }
                        $language = rtrim($language,",");
                    }
                    ?>
                    <input type="text" value="<?php echo $language ?>" readonly style="width:40%;" >
                </p>
                <p class="p_line">
                    <span class="tit">服务时段</span>
                    <input type="text" value="<?php echo $model['time_interval_start']; ?>" readonly > 至 <input type="text" value="<?php echo $model['time_interval_end']; ?>" readonly >
                </p>
                <p class="p_line">
                    <span class="tit">服务时长</span>
                    <input type="text" value="<?php echo $model['service_time']; ?>" readonly >
                </p>
                <p class="p_line">
                    <span class="tit">接待人数</span>
                    <input type="text" value="<?php echo $model['num']; ?>" readonly >
                </p>
                <p class="theme-sxh3 p_line">
                    <span class="tit">订单确认</span>
                    <input type="text" value="<?=Yii::$app->params['is_confirm'][$model->is_confirm]?>" readonly style="width: 120px;" >
                </p>
                <p class="theme-sxh4 p_line">
                    <span class="tit">有效期</span>
                    <input type="text" value="<?php echo substr($model['start_date'], 0, 10); ?>" readonly style=''>&nbsp;&nbsp;&nbsp;&nbsp;至<input type="text" value="<?php echo substr($model['end_date'], 0, 10); ?>" readonly style='padding:0; margin-left:15px;'>
                </p>
                <p class="theme-sxh4 p_line">
                    <span class="tit">价格设置</span>
                </p>
                <div class="calendarWrapper p_line" style="border:solid 1px #ddd;width:80%;height: 70%;margin-left:100px;">
                    <div id="calendar" class="dib" style="height:50%;"></div>
                </div>
                <p class="div-sxh2 p_line">
                    <span class="tit">费用包含</span>
                    <textarea readonly> <?php echo str_replace("<br>","\n",$model['price_in']); ?></textarea>
                </p>
                <p class="div-sxh2 p_line">
                    <span class="tit">费用不含</span>
                    <textarea readonly > <?php echo str_replace("<br>","\n",$model['price_out']); ?></textarea>
                </p>
                <p class="div-sxh2 p_line">
                    <span class="tit">退订政策</span>
                    最晚提前
                    <input type="text" value="<?php echo $model['refund_type'] ?>" readonly style="width: 60px;" >
                    天可退款
                </p>
                <p class="div-sxh2 p_line">
                    <span>退订说明</span>
                    <textarea readonly> <?php echo str_replace("<br>","\n",$model['refund_note']); ?></textarea>
                </p>
                <p class="div-sxh2 p_line">
                    <span class="tit">预定须知</span>
                    <textarea readonly> <?php echo str_replace("<br>","\n",$model['note']); ?></textarea>
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
                        <?php if (is_array($logs) && !empty($logs['list'])): ?>
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
                                            <td><?php if ($v['status'] == 5) {
                                                    echo '通过审核';
                                                }
                                                if ($v['status'] == 3) {
                                                    echo '未通过审核';
                                                } ?></td>
                                            <td><?php echo $v['reason'] ?></td>
                                            <td><?php echo $v['remarks'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        <?php endif ?>
                        <div class="right-l-btn">
                            <a href="<?php echo Yii::$app->request->getReferrer() ?>" class="btn1"><button type="button" class="btn1">返回</button></a>
                            <button type="submit" class="btn2 ajaxbtn" style="margin-left: 50px;">提交</button>
                        </div>
                    </div>
                <?php endif ?>
                <?php if ($model['status'] == 1 ||$model['status'] == 2): ?>
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
                    <?php if (is_array($logs) && !empty($logs['list'])): ?>
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
                                        <td><?php if ($v['status'] == 5) {
                                                echo '通过审核';
                                            }
                                            if ($v['status'] == 3) {
                                                echo '未通过审核';
                                            } ?></td>
                                        <td><?php echo $v['reason'] ?></td>
                                        <td><?php echo $v['remarks'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif ?>
                    <div class="right-l-btn">
                        <a href="<?php echo Yii::$app->request->getReferrer() ?>" class="btn1"><button type="button" class="btn1">返回</button>
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
                    <?php if (is_array($logs) && !empty($logs['list'])): ?>
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
                                        <td><?php if ($v['status'] == 1) {
                                                echo '通过审核';
                                            }
                                            if ($v['status'] == 3) {
                                                echo '未通过审核';
                                            } ?></td>
                                        <td><?php echo $v['reason'] ?></td>
                                        <td><?php echo $v['remarks'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif ?>
                    <div class="right-l-btn">
                        <a href="<?php echo Yii::$app->request->getReferrer() ?>" class="btn1"><button type="button" class="btn1">返回</button></a>
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
            $.post("<?=Url::to(["travel-guide/check"])?>", {
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
                    //2017年6月23日18:09:05       付燕飞 修改，操作成功后跳转回的页面记录搜索条件
                    window.location.href = '<?php echo Yii::$app->request->getReferrer() ?>';
                }
            });
        });
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