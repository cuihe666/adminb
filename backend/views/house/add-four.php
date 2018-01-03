<?php
$this->title = '房屋描述';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/amaze/css/amazeui.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/amaze/css/font-awesome.min.css">
<!-- 百度上传图片 -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webuploader_agent/webuploader.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/webuploader_agent/style.css"/>
<!-- @2017年11月7日16:14:50 fuyanfei to add minsu320[房源图片添加设置标签的功能]-->
<script type="text/javascript">
    var imgLabelMap = <?= json_encode(Yii::$app->params['house']['house_img_label'])?>;
    var upload_id = <?= Yii::$app->request->get("house_id")?>;
</script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader_agent/webuploader.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader_agent/upload.js?t=1"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/amaze/js/amazeui.min.js"></script>

<style>
    body {
        font-size: 14px;
    }

    .content > .row > span {
        border: 1px solid #666;
        padding: 5px 10px;
        margin-right: 10px;
    }

    .table td {
        padding-top: 10px !important;
    }

    .table td label {
        margin-right: 20px;
    }

    .table td label input {
        float: left;
        margin-right: 5px;
    }

    .table td label em {
        margin-top: 2px;
        display: inline-block;
        font-style: normal;
        color: #666;
    }

    .table .acreage label input {
        width: 10%;
        float: inherit;
        text-align: center;
        font-weight: normal;
    }

    .table .acreage label em {
        margin-right: 10px;
    }

    .table .acreage2 label {
        margin-top: 10px;
        display: block;
    }

    .table .acreage2 label input {
        width: 50px;
        text-align: center;
    }

    .table .acreage2 label img {
        width: 25px;
        margin-left: 15px;
    }

    .table .acreage2 label img.shanchu {
        width: 20px;
        margin-left: 20px;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .cha {
        position: absolute;
        right: 20px;
        top: 20px;
        width: 20px;
    }

    .change_price span {
        background-color: #ccc;
        padding: 5px 10px;
        border-radius: 5px;
        color: #fff;
        margin-bottom: 10px;
        display: inline-block;
        margin-right: 10px;
    }

    textarea {
        outline: none;
        padding: 5px 0 0 5px;
    }

    #myModal6 label {
        display: inline-block;
        margin-right: 15px;
    }

    #myModal6 label input {
        float: left;
    }

    #myModal6 .row {
        margin-top: 5px
    }

    #myModal6 label em {
        font-style: normal;
        color: #999;
        font-weight: normal;
        display: inline-block;
        margin-top: 0px;
        margin-left: 3px;
        font-size: 14px;
    }

    #myModal6 span {
        display: inline-block;
        font-size: 14px;
    }

    .table-responsive > .table td {
        text-align: left !important;
    }

    .gmnoprint {
        display: none;
    }

    em {
        font-style: normal;
        display: inline-block;
        margin-right: 5px;
        font-weight: normal;
    }

    .appliances, .facilities, .bathroom, .service {
        font-weight: normal;
        color: #000;
        letter-spacing: 1px;
    }

    .main-header .right h4 {
        margin-top: 0;
    }

    .main-header .right small {
        top: 16px;
    }

    /*@2017-11-7 10:15:59 fuyanfei to add 房屋图片的标签配置--------minsu 320*/
    .house_imgs{ margin-bottom: 10px;}
    .house_tag{ overflow: hidden; height: 32px; }
    .house_tag span{ display: inline-block; height: 28px; line-height: 28px;}
    .house_tag select{ height: 26px; line-height: 26px; width:140px;}
    /*@2017-11-7 15:14:01 fuyanfeo to update minsu320 百度编辑器样式修改*/
    #uploader .filelist li{ height: 170px; width:140px;}
    #uploader .filelist li p.imgWrap{ width:140px; height: 130px;}
    .house_tag_js{ }
    .house_tag_js select{ width:70px;}
</style>
<script>
    function leave() {
        var len = $(".title_inp").val().length;
        if (len > 22 || len < 5) {
            alert("请输入正确格式");
            $(".title_inp").val("")
        }
    }

    // 文本域字数控制js
    function leave_txt4() {
        var len4 = $(".limit_len4 textarea").val().length;
        if (len4 > 2000) {
            $(".limit_len4 i").text("字数控制在2000字以内").css("display", "block")
        } else {
            $(".limit_len4 i").text("")
        }
    }

    function leave_txt5() {
        var len5 = $(".limit_len5 textarea").val().length;
        if (len5 > 2000) {
            $(".limit_len5 i").text("字数控制在2000字以内").css("display", "block")
        } else {
            $(".limit_len5 i").text("")
        }
    }
    function leave_txt6() {
        var len6 = $(".limit_len6 textarea").val().length;
        if (len6 > 2000) {
            $(".limit_len6 i").text("字数控制在2000字以内").css("display", "block")
        } else {
            $(".limit_len6 i").text("")
        }
    }
    //@2017-11-7 10:51:37 fuyafnei to add minsu320[添加房源亮点，限制字数100字以内]
    function leave_txt7() {
        var len7 = $(".limit_len7 textarea").val().length;
        if (len7 > 100) {
            $(".limit_len7 i").text("字数控制在100字以内").css("display", "block")
        } else {
            $(".limit_len7 i").text("")
        }
    }
    //---------end minsu320------------

    $(function () {
        $("body").on("click", ".shanchu", function () {
            $(this).parents(".str_label").remove()
        });
        $(".cha").click(function () {
            $("#myModal").hide()
            $(".modal-backdrop").hide()
        })

        // 设置modal框弹出 点击确定按钮获取值
        // appliances 家电
        // facilities 设施
        // bathroom 卫浴
        // service 服务

        $(".btn_confirm").click(function () {
//            var week_arr = new Array;
//            var week_cat = new Array;
            $(".appliances").html('');
            $(".facilities").html('');
            $(".bathroom").html('');
            $(".insite_label input[type='checkbox']:checkbox:checked").each(function (i) {
//                week_arr[i] = $(this).val();
//                week_cat[i] = $(this).attr('cat');
                if ($(this).attr('cat') == 1) {
                    var text = $(this).siblings("em").text() + '、';
                    var val = $(this).val();
                    var span = "<span style='display: inline-block;'>" + text + "</span><input class='inside' type='hidden' value='" + val + "' >";
                    $(".appliances").append(span);
                } else if ($(this).attr('cat') == 2) {
                    var text = $(this).siblings("em").text() + '、';
                    var val = $(this).val();
                    var span = "<span style='display: inline-block;'>" + text + "</span><input class='inside' type='hidden' value='" + val + "' >";
                    $(".facilities").append(span);
                } else {
                    var text = $(this).siblings("em").text() + '、';
                    var val = $(this).val();
                    var span = "<span style='display: inline-block;'>" + text + "</span><input class='inside' type='hidden' value='" + val + "' >";
                    $(".bathroom").append(span);
                }
            })
//            if (week_arr) {
//                var week_str = week_arr.join(',');
//                var select_cat_str = week_cat.join(',');
//                $('#inside_str').val(week_str);
//                $('#inside_cat').val(select_cat_str);
//            }

            // modal框隐藏
            $(".modal-backdrop").hide()
            $("#myModal6").hide()

        })


    })
</script>
<div class="modal fade" id="myModal6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="background-color: #fff;">
        <div class="modal-content">
            <div class="modal-body">
                <?php foreach ($insite_data as $k => $v): ?>
                    <div class="row" id="appliances">
                        <div class="col-md-2" style="text-align: right">
                            <span><?php echo $v['cat_name']; ?></span>
                        </div>
                        <div class="col-md-10">
                            <?php foreach ($v['son'] as $kk => $vv): ?>
                                <label class="insite_label">
                                    <input <?php if (!empty($old_inside)) { ?><?php foreach ($old_inside as $kkk => $vvv) {
                                        if ($vvv['inside_id'] == $vv['id']) {
                                            echo 'checked';
                                        }
                                    } ?><?php } ?> type="checkbox" cat="<?php echo $vv['category']; ?>"
                                                   value="<?php echo $vv['id']; ?>">
                                    <em><?php echo $vv['facilities_in_name']; ?></em>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-primary btn_confirm">确认</button>
        </div>
    </div>
</div>
<style>
    .content{
        padding-top:0;
    }
</style>

<section class="content" style="width:80%;margin:0 auto;">
    <div class="row">
        <span id="base_message">
            <a href="<?php echo \yii\helpers\Url::to(['update-one', 'house_id' => $_GET['house_id']]) ?>"
               style="color:#666;">1、基本信息</a>
        </span>
        <span id="price_rule">
            <a href="<?php echo \yii\helpers\Url::to(['add-two', 'house_id' => $_GET['house_id']]) ?>"
               style="color:#666;">2、价格规则</a>
        </span>
        <span id="ruzhu_note">
            <a href="<?php echo \yii\helpers\Url::to(['add-three', 'house_id' => $_GET['house_id']]) ?>"
               style="color:#666;">3、入住须知</a>
        </span>
        <span id="house_dep" style="border:none;background-color: #367fa9;">
            <a href="###" style="color:#fff">4、房屋描述</a>
        </span>
        <?php if($house_error){ ?>
            <b style="color:red;">审核不通过原因:<?php echo $house_error['reson']; ?></b>
        <?php } ?>

    </div>

    <div class="form-group" style="margin-top:30px;">
        <!--        <div class="row">-->
        <!--            <span style="background-color: #367fa9;color:#fff;padding: 5px 10px;">4、房屋描述</span>-->
        <!--        </div>-->
        <div class="table-responsive" style="overflow-x:inherit">
            <table class="table table-condensed">
                <tbody>
                <?php if ($img) { ?>
                    <tr>
                        <td style="text-align: right!important;width: 150px;">原图片</td>
                        <td class="limit_len4">
                            <div id="wrapper">
                                <ul data-am-widget="gallery"
                                    class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default"
                                    data-am-gallery="{ pureview: true }">
                                        <?php foreach ($img as $k => $v): ?>
                                            <li class="house_imgs" <?php if ($v['img_url'] == $cover_img) {
                                                echo 'cover=1';
                                            } ?> style="position: relative;">
                                                <?php if ($v['img_url'] == $cover_img) { ?>
                                                    <b class='figure_first'></b><i class='figure_des'>首图</i>
                                                <?php } ?>
                                                <div class="am-gallery-item" style="position: relative;">
                                                    <div style="position: absolute;top: 5px;right: 5px;">
                                                        <span class="settitle"
                                                              style="color:#fff;cursor: pointer;">设为首图</span>
                                                        <span class="cancel1">删除</span>
                                                    </div>
                                                    <input type="hidden" name="pic[]"
                                                           value="<?php echo $v['img_url']; ?>">
                                                    <a href="http://img.tgljweb.com/<?php echo $v['img_url']; ?>"
                                                       class="">
                                                        <img src="http://img.tgljweb.com/<?php echo $v['img_url']; ?>"
                                                             style="height: 145px;"/>
                                                    </a>
                                                </div>
                                                <!-- @2017-11-7 13:43:07 fuyanfei to add minsu320【房源图片标签配置】 -->
                                                <p class="house_tag">
                                                    <span>标签配置：</span>
                                                    <select name="img_label[]">
                                                        <?php foreach(Yii::$app->params['house']['house_img_label'] as $key => $val):?>
                                                        <option value="<?=$key?>" <?php echo $v['img_label']==$key ? "selected" : "";?>><?=$val?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </p>
                                            </li>
                                        <?php endforeach ?>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <style>
                    .cancel1 {
                        width: 35px;
                        /*height: 24px;*/
                        display: inline;
                        /*float: right;*/
                        /*text-indent: -9999px;*/
                        color: #fff;
                        overflow: hidden;
                        /*background: url(/webuploader/icons.png) no-repeat;*/
                        margin: 5px 1px 1px;
                        cursor: pointer;
                        /*background-position: -48px -24px;*/
                    }

                    .am-gallery .figure_first {
                        position: absolute;
                        left: 0;
                        top: -19px;
                        z-index: 4;
                        color: red;
                        width: 0;
                        height: 0;
                        border-top: 36px solid transparent;
                        border-bottom: 36px solid transparent;
                        border-right: 36px solid red;
                        transform: rotate(46deg);
                        -webkit-transform: rotate(46deg);
                        -moz-transform: rotate(46deg);
                        -o-transform: rotate(46deg);
                        -ms-transform: rotate(46deg);
                    }

                    .am-gallery .figure_des {
                        position: absolute;
                        left: 6px;
                        top: 8px;
                        z-index: 5;
                        font-size: 14px;
                        color: #fff;
                    }

                    .am-pureview-direction a:before {
                        font-size: 40px;
                    }

                    .am-pureview-actions a {
                        left: 97%;
                    }

                    .am-icon-chevron-left:before {
                        content: "";
                        width: 33px;
                        height: 45px;
                        background: url(<?= Yii::$app->request->baseUrl ?>/images/cha.png) no-repeat 100%;
                    }

                    .am-pureview-next {
                        background: url(<?= Yii::$app->request->baseUrl ?>/images/arrow_r.png) no-repeat 100%;
                    }

                    .am-pureview-prev {
                        background: url(<?= Yii::$app->request->baseUrl ?>/images/arrrow.png) no-repeat 100%;
                    }

                    .am-pureview-direction .am-pureview-next a:before {
                        content: '';
                    }

                    .am-pureview-direction a:before {
                        content: '';
                    }
                </style>
                <script>
                    //                    $(function () {
                    //                        $(".am-gallery li").first().css("position", "relative").append("<b class='figure_first' ></b>" + "<i class='figure_des'>首图</i>")
                    //                    })
                    $(function () {
                        $(document).on('click', '.cancel1', function () {
                            var cover_img = "<?php echo $cover_img ? $cover_img : ''; ?>";
                            var del_img = $(this).parent().siblings('input').val();
                            var house_id = $('#house_id').val();
                            if (cover_img == del_img) {
                                $.ajax({
                                    type: 'post',
                                    url: "<?php echo \yii\helpers\Url::to(['del-title-pic']) ?>",
                                    data: {
                                        house_id: house_id
                                    },
                                })
                            }
                            $(this).parents('.house_imgs').remove();
                        })
                        $(document).on('click', '.settitle', function () {
                            var house_id = $('#house_id').val();
                            var title_pic = $(this).parent().siblings('input').val();
                            var This=$(this);
                            $.ajax({
                                type: 'post',
                                url: "<?php echo \yii\helpers\Url::to(['set-title-pic']) ?>",
                                data: {house_id: house_id, title_pic: title_pic},
                                success: function (data) {
                                    if (data == -1) {
                                        layer.open({
                                            content: '设置失败',
                                        });
                                    }
                                    if (data > 0) {
                                        layer.open({
                                            content: '设置成功',
                                        });
                                        This.parents('.house_imgs').siblings('li').find('.figure_first').remove();
                                        This.parents('.house_imgs').siblings('li').find('.figure_des').remove();
                                        This.hide().parents('.house_imgs').prepend(" <b class='figure_first'></b><i class='figure_des'>首图</i>");
                                        This.parents('.house_imgs').siblings('li').find('.settitle').show();
                                    }
                                }
                            })
                        })
                        if ($(".house_imgs").find("b").hasClass("figure_first")) {
                            $(".figure_first").siblings(".am-gallery-item").find(".settitle").hide();
                        }

                    })

                </script>
                <tr>
                    <td style="text-align: right!important;width: 150px;">新增图片</td>
                    <td class="limit_len4">
                        <div id="wrapper">
                            <div id="container" style="width: 936px;">
                                <!--头部，相册选择和格式选择-->

                                <div id="uploader">
                                    <div class="queueList">
                                        <div id="dndArea" class="placeholder">
                                            <div id="filePicker"></div>
                                            <p>按住Ctrl可多选 ，请上传5-50张房源图片，格式支持.jpg .jpeg .png</p>
                                        </div>
                                        <ul class="filelist">

                                        </ul>
                                    </div>
                                    <div class="statusBar" style="display:none;">
                                        <div class="progress">
                                            <span class="text">0%</span>
                                            <span class="percentage"></span>
                                        </div>
                                        <div class="info"></div>
                                        <div class="btns">
                                            <div id="filePicker2"></div>
                                            <div class="uploadBtn">开始上传</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;">配套设施</td>
                    <td style="text-align: left!important;padding-left:2em;position: relative;">
                        <div class="row" style="width:80%">
                            <span>家电：</span>
                            <label class="appliances">
                                <?php if ($jiadian) { ?>
                                    <?php foreach ($jiadian as $k => $v): ?>
                                        <span
                                            style='display: inline-block;'><?php echo $v['facilities_in_name']; ?></span>
                                        <input class='inside' type="hidden" value="<?php echo $v['id']; ?>">
                                    <?php endforeach; ?>
                                <?php } ?>
                            </label>
                        </div>


                        <div class="row" style="width:80%;">
                            <span>设施：</span>
                            <label class="facilities">
                                <?php if ($sheshi) { ?>
                                    <?php foreach ($sheshi as $k => $v): ?>
                                        <span
                                            style='display: inline-block;'><?php echo $v['facilities_in_name']; ?></span>
                                        <input class='inside' type="hidden" value="<?php echo $v['id']; ?>">
                                    <?php endforeach; ?>
                                <?php } ?>
                            </label>
                        </div>
                        <div class="row" style="width:80%;">
                            <span>卫浴：</span>
                            <label class="bathroom">
                                <?php if ($weiyu) { ?>
                                    <?php foreach ($weiyu as $k => $v): ?>
                                        <span
                                            style='display: inline-block;'><?php echo $v['facilities_in_name']; ?></span>
                                        <input class='inside' type="hidden" value="<?php echo $v['id']; ?>">
                                    <?php endforeach; ?>
                                <?php } ?>
                            </label>
                        </div>
                        <span
                            style="background-color: #3c8dbc;color:#fff;padding:5px 10px;display: inline-block;position: absolute;right:10%;top:20px;border-radius: 5px;cursor:pointer"
                            data-toggle="modal" data-target="#myModal6">设置</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;">房源描述</td>
                    <td class="limit_len4" style="width:936px;">
                        <textarea class="introduce"
                                  style="border:1px solid #ccc;margin:0 1em;height:100px;width:946px;resize:none;"
                                   onblur="leave_txt4()"
                                  maxlength="2000"><?php echo $old_house_data['introduce']; ?></textarea>
                        <span style="color:#ccc;display:block;font-size: 12px;margin-left: 1em">(2000字以内)</span>
                        <i style="color:red;font-size: 12px;margin-left:1em;"></i>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;">房源亮点</td>
                    <td class="limit_len7" style="width:936px;">
                        <textarea class="house_highlights" style="border:1px solid #ccc;margin:0 1em;height:100px;width:946px;resize:none;" onblur="leave_txt7()"  maxlength="100"><?php echo $old_house_data['house_highlights']; ?></textarea>
                        <span style="color:#ccc;display:block;font-size: 12px;margin-left: 1em">(100字以内)</span>
                        <i style="color:red;font-size: 12px;margin-left:1em;"></i>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;">交通情况（选填）</td>
                    <td class="limit_len5" style="width:936px;">
                        <textarea class="traffic_intro"
                                  style="border:1px solid #ccc;margin:0 1em;height:100px;width:946px;resize:none;"
                                   onblur="leave_txt5()"
                                  maxlength="2000"><?php echo $old_house_data['traffic_intro']; ?></textarea>
                        <span style="color:#ccc;display:block;font-size: 12px;margin-left: 1em">(2000字以内)</span>
                        <i style="color:red;font-size: 12px;margin-left:1em;"></i>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;">周边设施（选填）</td>
                    <td class="limit_len6" style="width:936px;">
                        <textarea class="nearby_intro"
                                  style="border:1px solid #ccc;height:100px;margin:0 1em;width:946px;resize:none;"
                                   onblur="leave_txt6()"
                                  maxlength="2000"><?php echo $old_house_data['nearby_intro']; ?></textarea>
                        <span style="color:#ccc;display:block;font-size: 12px;margin-left: 1em">(2000字以内)</span>
                        <i style="color:red;font-size: 12px;margin-left:1em;"></i>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;">权重配置</td>
                    <style>
                        .house_rank{}
                        .house_rank span{ display: inline-block; margin-left:15px; margin-right: 15px;}
                        .house_rank span input{ width:40px; border:1px solid #ccc; text-align: center;}
                    </style>
                    <td class="limit_len6 house_rank" style="width:936px;">
                        <span><b>图片：</b><input type="text" name="house_img" value="<?= $qualityInfo['house_img'] ? $qualityInfo['house_img'] : 0 ;?>" oninput="if(parseInt(value)>5){value=5;}" onkeyup="value=value.reg(/[123450]{1}/)" maxlength="1" /> </span>
                        <span><b>文字描述：</b><input type="text" name="text_description" value="<?= $qualityInfo['text_description'] ? $qualityInfo['text_description'] : 0 ;?>" min="0" max="5" oninput="if(parseInt(value)>5){value=5;}" onkeyup="value=value.reg(/[123450]{1}/)" maxlength="1" /> </span>
                        <span><b>装修：</b><input type="text" name="renovation" value="<?= $qualityInfo['renovation'] ? $qualityInfo['renovation'] : 0 ;?>" min="0" max="5" oninput="if(parseInt(value)>5){value=5;}" onkeyup="value=value.reg(/[123450]{1}/)" maxlength="1" /> </span>
                        <span><b>床品：</b><input type="text" name="bedding" value="<?= $qualityInfo['bedding'] ? $qualityInfo['bedding'] : 0 ;?>" min="0" max="5" oninput="if(parseInt(value)>5){value=5;}" onkeyup="value=value.reg(/[123450]{1}/)" maxlength="1" /> </span>
                        <span style=""><b>干湿分离（热水）：</b><input type="text" name="dry_wet" value="<?= $qualityInfo['dry_wet'] ? $qualityInfo['dry_wet'] : 0 ;?>" oninput="if(parseInt(value)>5){value=5;}" onkeyup="value=value.reg(/[123450]{1}/)" maxlength="1" /> </span>
                        <span style="color: #FF0000">（每一项分数为0-5分）</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row" style="padding-top: 0;margin-top: 10px;">
            <input type="hidden" id="inside_str" value="">
            <input type="hidden" id="inside_cat" value="">
            <input type="hidden" id="house_id" value="<?php echo $_GET['house_id']; ?>">
            <button type="button" class="btn btn-primary add-four">提交</button>
        </div>
    </div>
</section>
<script>
    $(function () {
        $(document).on('click', '.title_pic', function () {
            var house_id = $('#house_id').val();
            var title_pic = $(this).siblings('input').val();
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['set-title-pic']) ?>",
                data: {house_id: house_id, title_pic: title_pic},
                success: function (data) {
                    if (data == -1) {
                        layer.open({
                            content: '设置失败',
                        });
                    }
                    if (data == -3) {
                        layer.open({
                            content: '请勾选房内设施',
                        });
                    }
                    if (data > 0) {
                        if (data > 0) {
                            layer.open({
                                content: '设置成功',
                            });
                        }
                    }
                }
            })
        })


        $('.add-four').click(function () {
            var house_id = $('#house_id').val();
            var pic_arr = new Array;
            var introduce = $('.introduce').val();
            var house_highlights = $(".house_highlights").val();     //@2017-11-7 10:56:35 fuyanfei to add minsu320[添加房源亮点]
            var traffic_intro = $('.traffic_intro').val();
            var nearby_intro = $('.nearby_intro').val();
            var inside_arr = new Array;
            //@2017-11-7 18:14:15 fuyanfei to add minsu320[房源权重分数]
            var house_img = $("input[name='house_img']").val();
            var text_description = $("input[name='text_description']").val();
            var renovation = $("input[name='renovation']").val();
            var bedding = $("input[name='bedding']").val();
            var dry_wet = $("input[name='dry_wet']").val();
            //------------minsu320[房源权重分数]-end--------------//
            //图片
            $("input[name='pic[]']").each(function (i) {
                pic_arr[i] = $(this).val();
            })
            var pic_count = pic_arr.length;
            if (pic_count < 5 || pic_count > 50) {
                layer.open({
                    content: '图片5-50张',
                });
                return;
            }
            //图片标签--------@2017-11-7 10:23:00 fuyanfei to add  minsu320[添加房源图片标签配置]
            var imgLabelArr = new Array;
            $("select[name='img_label[]']").each(function(i){
                imgLabelArr[i] = $(this).val();
            })
            var imgLabelStr = imgLabelArr.join(",");
            //----------------end---------------------
            //卫浴
            $("input[class='inside']").each(function (i) {
                inside_arr[i] = $(this).val();
            })
            var inside_str = inside_arr.join(',');
            var pic_str = pic_arr.join(',');
            if (house_id && pic_str && inside_str) {
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['add-four']) ?>",
                    data: {
                        house_id: house_id,
                        pic: pic_str,
                        imgLabelStr:imgLabelStr,     //@2017-11-7 10:24:02 fuyanfei to add minsu320[添加房源图片标签配置]
                        introduce: introduce,
                        house_highlights:house_highlights,     //@2017-11-7 10:57:07 fuyanfei to add minsu320[添加房源亮点]
                        traffic_intro: traffic_intro,
                        nearby_intro: nearby_intro,
                        inside: inside_str,
                        house_img:house_img,       //@2017-11-7 18:14:15 fuyanfei to add minsu320[房源质量权重图片分数]
                        text_description:text_description,       //@2017-11-7 18:14:15 fuyanfei to add minsu320[房源质量权重文字描述分数]
                        renovation:renovation,       //@2017-11-7 18:14:15 fuyanfei to add minsu320[房源质量权重装修分数]
                        bedding:bedding,       //@2017-11-7 18:14:15 fuyanfei to add minsu320[房源质量权重床品分数]
                        dry_wet:dry_wet,       //@2017-11-7 18:14:15 fuyanfei to add minsu320[房源质量权重干湿分离分数]
                    },
                    success: function (data) {
                        if (data == -1) {
                            layer.open({
                                content: '请补全信息',
                            });
                        }
                        if (data == -3) {
                            layer.open({
                                content: '请勾选房内设施',
                            });
                        }
                        if (data > 0) {
                            layer.open({
                                content: '上传成功',
                            });
                            location.href = "<?php echo \yii\helpers\Url::to(['house-details/index']) ?>"
                        }
                        if (data == -2) {
                            layer.open({
                                content: '请设置首图',
                            });
                        }
                    }
                })
            } else {
                layer.open({
                    content: '请补全信息',
                });
            }
        })
    })
</script>
