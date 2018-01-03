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
<!--上传插件--><!--
<link rel="stylesheet" href="<?/*= Yii::$app->request->baseUrl */?>/dist/css/webuploader.css" />
<link rel="stylesheet" href="<?/*= Yii::$app->request->baseUrl */?>/dist/css/uploadstyle.css" />-->
<!-- 百度上传图片 -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webuploader/webuploader.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/webuploader/style.css"/>

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
        bottom: 0;
        left: 0;
        font-size: 12px;
        color: #FFFFFF;
    }

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
</style>


<body class="hold-transition skin-blue sidebar-mini">


<?= \backend\widgets\ElementAlertWidget::widget() ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="wrapper-content animated fadeInRight" style="">
        <div class="details_header">
            <a href="<?php echo \yii\helpers\Url::to(['hotel/four','id'=>$id]) ?>"><input class="return_manage" type="button" value="< &nbsp;返回房型管理" /></a>
        </div>
        <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form']) ?>

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
        </div>
            <i class="pic_text"></i>


        <!--房型-->
        <div class="house_type" style="margin-top:20px;">
            <style>
                .house_table td .require_i{
                    text-indent: 0;
                    display: inline;
                }
            </style>
            <table class="house_table" border="" cellspacing="" cellpadding="">
                <tr>
                    <td style="width:20%;"><i class="require_i">*&nbsp;&nbsp;</i>房型名称：</td>
                    <td><input type="text" id="houst_name" name="HotelHouse[name]" value="" maxlength="15" placeholder="最多输入15个字" /><i class="houst_name"></i></td>
                </tr>
                <tr>
                    <td><i class="require_i">*&nbsp;&nbsp;</i>早餐：</td>
                    <td>
                        <?= Html::activeDropDownList($model, 'breakfast', Yii::$app->params['hotel_breakfast'], ['class' => 'hotel_information_select', 'id'=>"cereal", 'prompt' => '请选择']) ?>
                        <i class="cereal"></i>
                    </td>
                </tr>
                <tr>
                    <td class="bed-type-title"><i class="require_i">*&nbsp;&nbsp;</i>床型：</td>
                    <td>
                        <div class="bed-select-info">
                            <select name="type">
                                <option>请选择</option>
                                <?php for ($i=0; $i<count(Yii::$app->params['hotel_bed_type']); $i++) {?>
                                    <option value=<?= $i?>><?= Yii::$app->params['hotel_bed_type'][$i]?></option>
                                <?php }?>
                            </select>
                            <div class="bed-select-info-item">
                                <input type="number" style="margin-left: 5px" name="bed_num" onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === '00' || /[.+-]/.test(value))value=''"><!-- 床的个数 -->
                                <span class="bed-num-unit">张</span>
                                <span class="bed-width">宽：</span>
                                <input type="number" name="bed_width" onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === '00' || value === '0.0' || /[.+-]{2}/.test(value))value=''"><!-- 床的宽度 -->
                                <span>米</span>

                                <span class="add-house-floor-math" style="margin-left: 10px;display: none;">
                                    <span class="bed-info-add">+</span>
                                    <span class="bed-info-plus">-</span>
                                </span>
                            </div>
                            <i class="bed" style="color: red;text-indent: 10px;display: inline-block;"></i>
                        </div>
                    </td>
                    <script>
                        $(function () {
                            $('body').on('click', '.bed-info-add', function () {
                                $(this).parent().parent().parent().parent().append('<div class="bed-select-info">\n' +
                                    '                            <select name="type">\n' +
                                    '                                <option>请选择</option>\n' +
                                    '                                <?php for ($i=0; $i<count(Yii::$app->params['hotel_bed_type']); $i++) {?><option value=<?= $i?>><?= Yii::$app->params['hotel_bed_type'][$i]?></option><?php }?>\n' +
                                    '                            </select>\n' +
                                    '                            <div class="bed-select-info-item">\n' +
                                    '                                <input type="text" style="margin-left: 5px">\n' +
                                    '                                <span class="bed-num-unit">张</span>\n' +
                                    '                                <span class="bed-width">宽：</span>\n' +
                                    '                                <input type="text">\n' +
                                    '                                <span>米</span>\n' +
                                    '                                <span class="add-house-floor-math" style="margin-left: 10px">\n' +
                                    '                                <span class="bed-info-add">+</span>\n' +
                                    '                                <span class="bed-info-plus">-</span>\n' +
                                    '                            </span>\n' +
                                    '                            </div>\n' +
                                    '                        </div>');
                            });
                            $('body').on('click', '.bed-info-plus', function () {
                                if($('.bed-select-info').length == '1'){
                                    return false;
                                }
                                $(this).parent().parent().parent().remove();
                            });
                            $('body').on('change', "select[name='type']", function () {
                                if($(this).val() == '2'){
                                    $(this).parent().find('.bed-select-info-item').html('<div>\n' +
                                        '                                    <div>\n' +
                                        '                                        <input type="text" value="大床" style="width: 70px;margin-left: 5px" readonly>\n' +
                                        '                                        <input type="number" style="margin-left: 5px"  name="bed_num1" onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === \'00\' || /[.+-]/.test(value))value=\'\'">\n' +
                                        '                                        <span class="bed-num-unit">张</span>\n' +
                                        '                                        <span class="bed-width">宽：</span>\n' +
                                        '                                        <input type="number"  name="bed_width1" onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === \'00\' || value === \'0.0\' || /[.+-]{2}/.test(value))value=\'\'">\n' +
                                        '                                        <span>米</span>\n' +
                                        '                                    </div>\n' +
                                        '                                    <div>\n' +
                                        '                                        <input type="text" value="双床" style="width: 70px;margin-left: 5px" readonly>\n' +
                                        '                                        <input type="number" style="margin-left: 5px" name="bed_num2" onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === \'00\' || /[.+-]/.test(value))value=\'\'">\n' +
                                        '                                        <span class="bed-num-unit">张</span>\n' +
                                        '                                        <span class="bed-width">宽：</span>\n' +
                                        '                                        <input type="number"  name="bed_width2" onkeyup="if((!/^[0-9]$/.test(value)&&value.length < 2) || value < 0 || value === \'00\' || value === \'0.0\' || /[.+-]{2}/.test(value))value=\'\'">\n' +
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
                                    $(this).parent().find('.bed-select-info-item').html('<input type="text" name="other_bed_type" placeholder="请填写床型详情" style="width: 102px;margin-left: 5px;" >\n' +
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

                        });
                    </script>
                </tr>
                <tr>
                    <td><i class="require_i">*&nbsp;&nbsp;</i>最大可住人数：</td>
                    <td><input type="number" id="maxnumber" name="HotelHouse[max_num]" value="" min="1" oninput="if(value.length>2)value=value.slice(0,2)" onkeyup="value=value.replace(/[^1-9][0-9]/g,'')" placeholder="最多输入2位数" /><i class="maxnumber"></i></td>
                </tr>
                <tr>
                    <td><i class="require_i">*&nbsp;&nbsp;</i>面积：</td>
<!--                     2017年5月8日11:49:33 zjl 正则不能以0 开头 最大4位-->
                    <td><input type="number" id="houst_area" name="HotelHouse[room_size]" value="" min="1" oninput="if(value.length>4)value=value.slice(0,4)" onkeyup="value=value.replace(/^[0]\d*$/g,'')" placeholder="最多输入4位数" /><b style="padding:0 5px; font-size:16px;">㎡</b><i class="houst_area"></i></td>
                </tr>
                <tr>
                    <td><i class="require_i">&nbsp;&nbsp; </i>楼层：</td>
                    <td>
                        <div class="add-house-floor">
                            <select name="floor_type">
                                <option value="">请选择</option>
                                <?php for ($j=0; $j<count(Yii::$app->params['hotel_floor_type']); $j++) {?>
                                    <option value="<?= $j?>"><?= Yii::$app->params['hotel_floor_type'][$j]?></option>
                                <?php }?>
                            </select>
                            <input type="text" placeholder="示例:5-7,12,13" name="floor">
                            <span class="add-house-floor-math" style="display: none;">
                                <span class="add-house-floor-add">+</span>
                                <span class="add-house-floor-plus">-</span>
                            </span>
                        </div>
<!--                        <i class="refund_type_i"></i>-->
                    </td>
                    <script>
                        $(function () {
                            $('body').on('click', '.add-house-floor-add', function () {
                                $(this).parent().parent().parent().append('<div class="add-house-floor">\n' +
                                    '                            <select name="floor_type">\n' +
                                    '                                <option>请选择</option>\n' +
                                    '                                <?php for ($j=0; $j<count(Yii::$app->params['hotel_floor_type']); $j++) {?><option value="<?= $j?>"><?= Yii::$app->params['hotel_floor_type'][$j]?></option><?php }?>\n' +
                                    '                            </select>\n' +
                                    '                            <input type="text" placeholder="示例:5-7,12,13" name="floor">\n' +
                                    '                            <span class="add-house-floor-math">\n' +
                                    '                                <span class="add-house-floor-add">+</span>\n' +
                                    '                                <span class="add-house-floor-plus">-</span>\n' +
                                    '                            </span>\n' +
                                    '                        </div>');
                            });
                            $('body').on('click', '.add-house-floor-plus', function () {
                                /*判断只剩一个就返回*/
                                if($('.add-house-floor').length == '1'){
                                    return false;
                                }
                                $(this).parent().parent().remove();
                            });
                        });
                    </script>
                </tr>
                <tr>
                    <td><i class="require_i">*&nbsp;&nbsp;</i>取消政策：</td>
                    <td>
                        <?= Html::activeDropDownList($model, 'refund_type', Yii::$app->params['hotel_refund_type'], ['class' => 'hotel_information_select refund_type',  'prompt' => '请选择']) ?>
                        <span class="hide_time" style="display: none">
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
                    <td><i class="require_i">&nbsp;&nbsp;&nbsp;</i>有窗：</td>
                    <td>
                        <?= Html::activeDropDownList($model, 'is_window', Yii::$app->params['hotel_is_window'], ['class' => 'hotel_information_select','prompt' => '请选择']) ?>
                    </td>
                </tr>
            </table>
        </div>

        <input type="hidden" id="hotel_id" value="<?php echo $_GET['id']; ?>">
        <input type="hidden" name="cover_img" class="cover_img" id="cover_img" />
        <input type="hidden" name="optype" id="optype" value="1" />
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

<!-- 百度上传图片 -->
<script>
    var upload_type = "hotel_house";
    var upload_id = $("#hotel_id").val();
</script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/webuploader.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/upload.js"></script>
</body>
</html>

