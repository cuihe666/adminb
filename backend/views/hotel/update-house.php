<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '房型详情';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\ScrollAsset::register($this);
?>

<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/bootstrap/css/bootstrap-datetimepicker.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
      page. However, you can choose any other skin. Make sure you
      apply the skin class to the body tag so the changes take effect.
-->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/skins/skin-blue.min.css">
<!--new link-->
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/dist/css/rummery.css"/>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/gobal.css" />
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/xhhgrogshop.css" />
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/layer/skin/default/layer.css"/>
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
<!--上传插件--><!--
<link rel="stylesheet" href="<?/*= Yii::$app->request->baseUrl */?>/dist/css/webuploader.css" />
<link rel="stylesheet" href="<?/*= Yii::$app->request->baseUrl */?>/dist/css/uploadstyle.css" />-->
<!-- 百度上传图片 -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webuploader/webuploader.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/webuploader/style.css"/>
<!-- 图片切换 -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/amaze/css/amazeui.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
    .shoutu {
        width: 75%;
        height: 30px;
        line-height: 30px;
        background: red;
        text-align: center;
        position: absolute;
        bottom:-19px;
        left: 0;
        font-size: 12px;
        color: #FFFFFF;
    }
    .am-avg-lg-4 > li:nth-of-type(4n + 1){ clear: none;}
    .shoutublock{top:-19px;}

    #uploader .filelist li {
        width: 171px;
        height: 170px;
    }

    #uploader .filelist div.file-panel {
        bottom: 28px;
    }

    #uploader .filelist li p.imgWrap {
        width: 151px;
        height: 150px;
    }

    #uploader .filelist li p.error {
        bottom: 28px;
    }

    #uploader .placeholder {
        padding-top: 75px;
    }
    .house_table td>i{
        color:red;
        text-indent: 10px;
        display: inline-block;
    }
    .house_table td>input{
        height:31px; line-height: 31px; width:151px;
    }
    .pic_text{ color:red; text-indent:10px;display:inline-block;}
    input[name="pic_desc[]"]{ display: none;}
    .am-pinch-zoom img{ width: auto;}
</style>


<body class="hold-transition skin-blue sidebar-mini">


    <!-- Content Wrapper. Contains page content -->
    <div class="wrapper-content animated fadeInRight" style="">
        <div class="details_header">
            <a href="<?php echo \yii\helpers\Url::to(['hotel/four','id'=>$model->hotel_id]) ?>"><input class="return_manage" type="button" value="< &nbsp;返回房型管理" /></a>
            <?php
            if($model->status==1){
                $stop_style = "display:inline-block;";
                $start_style = "display:none;";
            }
            if($model->status==0){
                $start_style = "display:inline-block;";
                $stop_style = "display:none;";
            }
            ?>
            <input class="return_manage return_manage_stop house_status stop"  style="<?=$stop_style?>" type="button" data="0" value="|| &nbsp;暂停售卖" />
            <input class="return_manage return_manage_stop house_status start" style="background-color: #00a65a;<?=$start_style?>" type="button" data="1" value="▷ &nbsp;正常售卖" />

						<span class="manage_del house_status" data = "3">
							<a href="javascript:void(0)">×删除房型</a>
						</span>
        </div>
        <script>
            $(".house_status").click(function(){
                var _this = $(this);
                layer.confirm('您确定操作吗？', {
                    btn: ['确定','取消'], //按钮
                    shade: false //不显示遮罩
                }, function(index){
                    var hotel_house_id = $("#hotel_house_id").val();
                    var hotel_id = $("#hotel_id").val();
                    var status = _this.attr("data");
                    $.ajax({
                        type: 'post',
                        url: "<?php echo \yii\helpers\Url::to(['update-status']) ?>",
                        data: {
                            hotel_house_id:hotel_house_id,
                            hotel_id:hotel_id,
                            status:status,
                        },
                        success: function (data) {
                            if(status==0){
                                $(".stop").hide();
                                $(".start").show();
                            }
                            else if(status==1){
                                $(".stop").show();
                                $(".start").hide();
                            }
                            else {
                                location.href = '<?php echo \yii\helpers\Url::to(['hotel/four','id'=>$model->hotel_id]) ?>';
                            }
                            layer.close(index);
                        }
                    })
                });
            })
        </script>
        <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form']) ?>
        <div id="wrapper">
            <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default  ul_pic" data-am-gallery="{ pureview: true }">
                <?php if ($picArr) { ?>
                    <?php foreach ($picArr as $k => $v): ?>
                        <li class="house_imgs" <?php if ($v == $cover_img) { echo 'cover=1'; } ?> style="position: relative;">
                            <?php if ($v == $cover_img) { ?>
                                <b class='figure_first'></b><i class='figure_des'>首图</i>
                            <?php } ?>
                            <div class="am-gallery-item" style="position: relative;">
                                <div style="position: absolute;top: 5px;right: 5px;">
                                    <span class="settitle" style="color:#fff;cursor: pointer;">设为首图</span>
                                    <span class="cancel1">删除</span>
                                </div>
                                <input type="hidden" name="pic[]"
                                       value="<?php echo $v; ?>">
                                <a href="http://img.tgljweb.com/<?php echo $v; ?>" class="">
                                    <img src="http://img.tgljweb.com/<?php echo $v; ?>"  style="height: 138px;"/>
                                </a>
                            </div>
                        </li>
                    <?php endforeach ?>
                <?php } ?>
            </ul>
        </div>

        <div style="clear: both;"></div>
        <style>
            .house_save{margin:10px auto;}
            .house_imgs{ width:10%; float: left; position: relative; display: block; margin-right: 8px;
                border:1px solid #ccc; padding:0; margin-bottom: 5px;}
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
            .uploader .queueList{margin 20px 5px;}
            .am-gallery{padding:5px 0 0 0;}
            .am-avg-lg-4 > li{
                width:196px;
                height: 150px;
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

        </style>
        <script>
                $(document).on('click', '.cancel1', function () {
                    var cover_img = "<?php echo $cover_img ? $cover_img : ''; ?>";
                    var del_img = $(this).parent().siblings('input').val();
                    var hotel_house_id = $('#hotel_house_id').val();
                    if (cover_img == del_img) {
                        $.ajax({
                            type: 'post',
                            url: "<?php echo \yii\helpers\Url::to(['del-title-pic']) ?>",
                            data: {
                                hotel_house_id: hotel_house_id,
                                cover_img:cover_img,
                                del_img:del_img,
                            },
                            success: function (data) {
                                $("#cover_img").val("");
                            }
                        })
                    }
                    $(this).parents('.house_imgs').remove();
                })

                $(document).on('click', '.settitle', function () {
                    var hotel_house_id = $('#hotel_house_id').val();
                    var title_pic = $(this).parent().siblings('input').val();
                    var This=$(this);
                    $.ajax({
                        type: 'post',
                        url: "<?php echo \yii\helpers\Url::to(['set-title-pic']) ?>",
                        data: {hotel_house_id: hotel_house_id, title_pic: title_pic},
                        success: function (data) {
                            if (data == -1) {
                                layer.open({
                                    content: '设置失败',
                                });
                            }
                            if (data >= 0) {
                                $("#cover_img").val(title_pic);
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
        </script>


        <div id="wrapper" class="f_wrapper">
            <div id="container" style="width:536px;">
                <!--头部，相册选择和格式选择-->

                <div id="uploader" class="uploader">
                    <div class="queueList">
                        <div id="dndArea" class="placeholder">
                            <div id="filePicker"></div>
                            <p style="text-align: center;">按住Ctrl可多选 ，请上传至少1张房型图片，格式支持.jpg .jpeg .png</p>
                        </div>
                    </div>
                    <div class="statusBar" style="display:none;">
                        <div class="progress">
                            <span class="text">0%</span>
                            <span class="percentage"></span>
                        </div>
                        <div class="info"></div>
                        <div class="btns">
                            <div id="filePicker2" class="filePicker2"></div>
                            <div class="uploadBtn">开始上传</div>
                        </div>
                    </div>
                </div>
            </div>
            <i class="pic_text"></i>
        </div>


        <!--房型-->
        <div class="house_type" style="margin-top:20px;">
            <table class="house_table" border="" cellspacing="" cellpadding="">
                <tr>
                    <td style="width:20%;">房型名称：</td>
                    <td><input type="text" id="houst_name" name="HotelHouse[name]" value="<?=$model->name?>" maxlength="15" placeholder="最多输入15个字" /><i class="houst_name"></i></td>
                </tr>
                <tr>
                    <td>早餐：</td>
                    <td>
                        <?= Html::activeDropDownList($model, 'breakfast', Yii::$app->params['hotel_breakfast'], ['class' => 'hotel_information_select', 'id'=>"cereal", 'prompt' => '请选择']) ?>
                        <i class="cereal"></i>
                    </td>
                </tr>
                <tr>
                    <td class="bed-type-title <?php if ($model->type == 2) {echo 'bed-info-double';}?>">床型：</td>
                    <td>
                        <div class="bed-select-info">
                            <select name="type"  <?php if ($model->type == 2) {echo 'class="bed-info-double"';}?>>
                                <option>请选择</option>
                                <?php for ($i=0; $i<count(Yii::$app->params['hotel_bed_type']); $i++) {?>
                                    <option value=<?= $i?> <?php if ($model->type == $i) {echo 'selected=selected';}?>><?= Yii::$app->params['hotel_bed_type'][$i]?></option>
                                <?php }?>
                            </select>
                            <div class="bed-select-info-item">
                                <?php if ($model->type == 2) {//选择是大床或双床 ?>
                                    <div>
                                        <div>
                                            <input type="text" value="大床" style="width: 70px;margin-left: 5px" readonly>
                                            <input type="number" style="margin-left: 5px"  name="bed_num1" value="<?=isset($model->bed_single_num) ? $model->bed_single_num : ''?>"
                                                   onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === '00' || /[.+-]/.test(value))value=''">
                                            <span class="bed-num-unit">张</span>
                                            <span class="bed-width">宽：</span>
                                            <input type="number"  name="bed_width1" value="<?=isset($model->bed_single_width) ? $model->bed_single_width : ''?>"
                                                   onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === '00' || value === '0.0' || /[.+-]{2}/.test(value))value=''">
                                            <span>米</span>
                                        </div>
                                        <div>
                                            <input type="text" value="双床" style="width: 70px;margin-left: 5px" readonly>
                                            <input type="number" style="margin-left: 5px" name="bed_num2" value="<?=isset($model->bed_num) ? $model->bed_num : ''?>"
                                                   onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === '00' || /[.+-]/.test(value))value=''">
                                            <span class="bed-num-unit">张</span>
                                            <span class="bed-width">宽：</span>
                                            <input type="number"  name="bed_width2" value="<?=isset($model->bed_width) ? $model->bed_width : ''?>"
                                                   onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === '00' || value === '0.0' || /[.+-]{2}/.test(value))value=''">
                                            <span>米</span>
                                        </div>
                                    </div>
                                <?php }else if ($model->type == 11) {//选择的是其他床型 ?>
                                    <input type="text" name="other_bed_type" placeholder="请填写床型详情" style="width: 102px;margin-left: 5px;" value="<?= isset($model->type_other_name) ? $model->type_other_name : ''?>">
                                    <input type="number" style="margin-left: 5px"  name="bed_num" value="<?=isset($model->bed_num) ? $model->bed_num : ''?>"
                                           onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === '00' || /[.+-]/.test(value))value=''">
                                    <span class="bed-num-unit">张</span>
                                    <span class="bed-width">宽：</span>
                                    <input type="text" name="bed_width" value="<?=isset($model->bed_width) ? $model->bed_width : ''?>"
                                           onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === '00' || value === '0.0' || /[.+-]{2}/.test(value))value=''">
                                    <span>米</span>
                                <?php } else {?>
                                    <input type="number" style="margin-left: 5px" name="bed_num" value="<?=isset($model->bed_num) ? $model->bed_num : ''?>"
                                           onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === '00' || /[.+-]/.test(value))value=''"><!-- 床的个数 -->
                                    <span class="bed-num-unit">张</span>
                                    <span class="bed-width">宽：</span>
                                    <input type="number" name="bed_width" value="<?=isset($model->bed_width) ? $model->bed_width : ''?>"
                                           onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === '00' || value === '0.0' || /[.+-]{2}/.test(value))value=''"><!-- 床的宽度 -->
                                    <span>米</span>

                                    <span class="add-house-floor-math" style="margin-left: 10px;display: none;">
                                    <span class="bed-info-add">+</span>
                                    <span class="bed-info-plus">-</span>
                                    </span>
                                <?php }?>
                            </div>
                            <i class="bed" style="color: red;text-indent: 10px;display: inline-block;"></i>
                        </div>
                    </td>

                </tr>
                <script>
                    $('body').on('change', "select[name='type']", function () {
                        if($(this).val() == '2'){
                            $(this).parent().find('.bed-select-info-item').html('<div>\n' +
                                '                                    <div>\n' +
                                '                                        <input type="text" value="大床" style="width: 70px;margin-left: 5px" readonly>\n' +
                                '                                        <input type="number" style="margin-left: 5px"  name="bed_num1" onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === \'00\' || /[.+-]/.test(value))value=\'\'">\n' +
                                '                                        <span class="bed-num-unit">张</span>\n' +
                                '                                        <span class="bed-width">宽：</span>\n' +
                                '                                        <input type="number"  name="bed_width1"   onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === \'00\' || value === \'0.0\' || /[.+-]{2}/.test(value))value=\'\'">\n' +
                                '                                        <span>米</span>\n' +
                                '                                    </div>\n' +
                                '                                    <div>\n' +
                                '                                        <input type="text" value="双床" style="width: 70px;margin-left: 5px" readonly>\n' +
                                '                                        <input type="number" style="margin-left: 5px" name="bed_num2" onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === \'00\' || /[.+-]/.test(value))value=\'\'">\n' +
                                '                                        <span class="bed-num-unit">张</span>\n' +
                                '                                        <span class="bed-width">宽：</span>\n' +
                                '                                        <input type="number"  name="bed_width2"   onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === \'00\' || value === \'0.0\' || /[.+-]{2}/.test(value))value=\'\'">\n' +
                                '                                        <span>米</span>\n' +
                                '                                    </div>\n' +
                                '                                </div>');
                            /*\n' +
                                '\n' +
                                '                                <span class="add-house-floor-math" style="margin-left: 10px">\n' +
                                '                                <span class="bed-info-add">+</span>\n' +
                                '                                <span class="bed-info-plus">-</span>\n' +
                                '                                </span>*/
                            $(this).addClass('bed-info-double');
                            $(this).parent().parent().parent().find('.bed-type-title').addClass('bed-info-double');
                            $(this).parent().find('.add-house-floor-math').addClass('bed-info-double');
                            return false;
                        }
                        if($(this).val() == '11'){
                            $(this).parent().find('.bed-select-info-item').html('<input type="text"   name="other_bed_type" placeholder="请填写床型详情" style="width: 102px;margin-left: 5px;">\n' +
                                '                                <input type="number" style="margin-left: 5px"  name="bed_num" onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === \'00\' || /[.+-]/.test(value))value=\'\'">\n' +
                                '                                <span class="bed-num-unit">张</span>\n' +
                                '                                <span class="bed-width">宽：</span>\n' +
                                '                                <input type="text" name="bed_width"   onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === \'00\' || value === \'0.0\' || /[.+-]{2}/.test(value))value=\'\'">\n' +
                                '                                <span>米</span>');
                            /*\n' +
                                '                                <span class="add-house-floor-math" style="margin-left: 10px">\n' +
                                '                                <span class="bed-info-add">+</span>\n' +
                                '                                <span class="bed-info-plus">-</span>\n' +
                                '                                </span>*/
                            $(this).removeClass('bed-info-double');
                            $(this).parent().parent().parent().find('.bed-type-title').removeClass('bed-info-double');
                            $(this).parent().find('.add-house-floor-math').removeClass('bed-info-double');
                            return false;
                        }
                        $(this).parent().find('.bed-select-info-item').html('<input type="number" style="margin-left: 5px" name="bed_num" onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === \'00\' || /[.+-]/.test(value))value=\'\'">\n' +
                            '                                <span class="bed-num-unit">张</span>\n' +
                            '                                <span class="bed-width">宽：</span>\n' +
                            '                                <input type="text" name="bed_width"   onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === \'00\' || value === \'0.0\' || /[.+-]{2}/.test(value))value=\'\'">\n' +
                            '                                <span>米</span>');
                        /*\n' +
                            '                                <span class="add-house-floor-math" style="margin-left: 10px">\n' +
                            '                                <span class="bed-info-add">+</span>\n' +
                            '                                <span class="bed-info-plus">-</span>\n' +
                            '                                </span>*/
                        $(this).removeClass('bed-info-double');
                        $(this).parent().parent().parent().find('.bed-type-title').removeClass('bed-info-double');
                        $(this).parent().find('.add-house-floor-math').removeClass('bed-info-double');
                    });
                </script>
                <tr>
                    <td>最大可住人数：</td>
                    <td><input type="number" id="maxnumber" name="HotelHouse[max_num]" min="1" oninput="if(value.length>2)value=value.slice(0,2)" value="<?=$model->max_num?>" onkeyup="value=value.replace(/[^1-9][0-9]/g,'')" placeholder="最多输入2位数" /><i class="maxnumber"></i></td>
                </tr>
                <tr>
                    <td>面积：</td>
                    <!--                     2017年5月8日11:49:33 zjl 正则不能以0 开头 最大4位-->
                    <td><input type="number" id="houst_area" name="HotelHouse[room_size]" min="1" oninput="if(value.length>4)value=value.slice(0,4)" value="<?=$model->room_size?>" onkeyup="value=value.replace(/^[0]\d*$/g,'')" placeholder="最多输入4位数" /><b style="padding:0 5px; font-size:16px;">㎡</b><i class="houst_area"></i></td>
                </tr>
                <tr>
                    <td>楼层：</td>
                    <!--                     2017年5月8日11:49:33 zjl 正则不能以0 开头 最大4位-->
                    <td>
                        <div class="add-house-floor">
                            <select name="floor_type">
                                <option value="">请选择</option>
                                <?php for ($j=0; $j<count(Yii::$app->params['hotel_floor_type']); $j++) {?>
                                    <option value="<?= $j?>" <?php if ($model->floor_type === $j) {echo 'selected=selected';}?>><?= Yii::$app->params['hotel_floor_type'][$j]?></option>
                                <?php }?>
                            </select>
                            <input type="text" placeholder="示例:5-7,12,13" name="floor" value="<?=isset($model->floor) ? $model->floor : ''?>">
                            <span class="add-house-floor-math" style="display: none;">
                                <span class="add-house-floor-add">+</span>
                                <span class="add-house-floor-plus">-</span>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>取消政策：</td>
                    <td>
                        <?= Html::activeDropDownList($model, 'refund_type', Yii::$app->params['hotel_refund_type'], ['class' => 'hotel_information_select refund_type',  'prompt' => '请选择']) ?>
                        <?php
                        if($model->refund_type=='0')
                            $style = 'style="display: inline-block"';
                        else
                            $style = 'style="display: none"';
                        ?>
                        <span class="hide_time" <?=$style?>>
                            <span style="margin-left:40px;">入住当天：</span>
                            <?= Html::activeDropDownList($model, 'refund_time', Yii::$app->params['hotel_refund_time'], ['class' => 'hotel_information_select']) ?>
                        </span>
                        <i class="refund_type_i"></i>
                    </td>
                    <script>
                        $('.refund_type').change(function(){
                            if($(this).val()!=""){
                                if($(this).val()==0){
                                    $(".hide_time").show();
                                    $(".refund_type_i").text("");
                                }
                                else{
                                    $(".hide_time").hide();
                                }
                            }
                            else{
                                $(".hide_time").hide();
                            }
                        })
                    </script>
                </tr>
                <tr>
                    <td>有窗：</td>
                    <td>
                        <?= Html::activeDropDownList($model, 'is_window', Yii::$app->params['hotel_is_window'], ['class' => 'hotel_information_select','prompt' => '请选择']) ?>
                    </td>
                </tr>
            </table>
        </div>

        <input type="hidden" id="hotel_id" value="<?php echo $model->hotel_id; ?>">
        <input type="hidden" id="hotel_house_id" value="<?php echo $model->id; ?>">
        <input type="hidden" name="cover_img" class="cover_img" id="cover_img" value="<?=$model->cover_img?>" />
        <input type="hidden" name="optype" id="optype" value="2" />
        <div class="house_save" onclick="house_save()">保存</div>
        <?= Html::endForm();?>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <div class="control-sidebar-bg"></div>


<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="<?= Yii::$app->request->baseUrl ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/app.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/gobal.js"></script>

<!--<script src="<?/*= Yii::$app->request->baseUrl */?>/dist/js/webuploader.js"></script>
<script src="<?/*= Yii::$app->request->baseUrl */?>/dist/js/upload.js"></script>-->
<!-- 百度上传图片 -->
<script>
    var upload_type = "hotel_house";
    var upload_id = $("#hotel_id").val();
</script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/webuploader.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/upload.js"></script>
<!-- 图片切换 -->
<script src="<?= Yii::$app->request->baseUrl ?>/amaze/js/amazeui.min.js"></script>

</body>
</html>

<?php if (Yii::$app->session->hasFlash('errors')) {?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('errors')?>")</script>
<?php }?>


<?php if (Yii::$app->session->hasFlash('msg')) {?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('msg')?>")</script>
<?php }?>

