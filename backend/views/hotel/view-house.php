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
<!-- 图片切换 -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/amaze/css/amazeui.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
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
</style>


<body class="hold-transition skin-blue sidebar-mini">


    <!-- Content Wrapper. Contains page content -->
    <div class="wrapper-content animated fadeInRight" style="">
        <div class="details_header">
            <a href="<?php echo \yii\helpers\Url::to(['hotel/view','id'=>$model->hotel_id]) ?>"><input class="return_manage" type="button" value="< &nbsp;返回房型管理" /></a>

        </div>
        <div id="wrapper">
            <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default  ul_pic" data-am-gallery="{ pureview: true }">
                <?php if ($picArr) { ?>
                    <?php foreach ($picArr as $k => $v): ?>
                        <li class="house_imgs" <?php if ($v == $cover_img) { echo 'cover=1'; } ?> style="position: relative;">
                            <?php if ($v == $cover_img) { ?>
                                <b class='figure_first'></b><i class='figure_des'>首图</i>
                            <?php } ?>
                            <div class="am-gallery-item" style="position: relative;">
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

        <!--房型-->
        <div class="house_type" style="margin-top:20px;">
            <table class="house_table" border="" cellspacing="" cellpadding="">
                <tr>
                    <td style="width:20%;">房型名称：</td>
                    <td><?=$model->name?></td>
                </tr>
                <tr>
                    <td>早餐：</td>
                    <td>
                        <?= Yii::$app->params['hotel_breakfast'][$model->breakfast]?>
                    </td>
                </tr>
                <tr>
                    <td>床型：</td>
                    <td>
                        <?= Yii::$app->params['hotel_bed_type'][$model->type]?>
                    </td>
                </tr>
                <tr>
                    <td>最大可住人数：</td>
                    <td><?=$model->max_num?></td>
                </tr>
                <tr>
                    <td>面积：</td>
                    <td><?=$model->room_size?></td>
                </tr>
                <tr>
                    <td>取消政策：</td>
                    <td>
                        <?= Yii::$app->params['hotel_refund_type'][$model->refund_type]?>
                        <?php
                        if($model->refund_type=='0')
                            $style = 'style="display: inline-block"';
                        else
                            $style = 'style="display: none"';
                        ?>
                        <span class="hide_time" <?=$style?>>
                            <span style="margin-left:40px;">取消时间：</span>
                            <?= Yii::$app->params['hotel_refund_time'][$model->refund_time] ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>有窗：</td>
                    <td>
                        <?=Yii::$app->params['hotel_is_window'][$model->is_window]?>
                    </td>
                </tr>
            </table>
        </div>
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

