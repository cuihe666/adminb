<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '图片管理';
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
    .rummery_tab li a{ color: #000000;}
    .hotel_information_tips,.hostshort_b{
        color:red;
    }
    .shoutu {
        width: 75%;
        height: 30px;
        line-height: 30px;
        background: red;
        text-align: center;
        position: absolute;
        bottom: -19px;
        left: 0;
        font-size: 12px;
        color: #FFFFFF;
    }
    .shoutublock{top:-19px;}
    .am-avg-lg-4 > li:nth-of-type(4n + 1){ clear: none;}
    .f_wrapper .uploader .filelist li{
        width:171px;
        height:170px;
    }
    .f_wrapper .uploader .filelist div.file-panel{
        bottom:28px;
    }
    .f_wrapper .uploader .filelist li p.imgWrap{
        width:151px;
        height:142px;
        margin-bottom:7px;
    }
    .f_wrapper .uploader .filelist li p.error{
        bottom:28px;
    }
    .f_wrapper .uploader .placeholder{
        padding-top:75px;
    }
    .pic_text{ color:red; text-indent:10px;display:none;}
    /*input[name="pic_desc[]"]{ display: none;}*/
    .desc_i{ display: inline-block; text-align: center; width:100%; font-size:12px;}
    .am-pinch-zoom img{ width: auto;}
</style>



<body class="hold-transition skin-blue sidebar-mini">

<?= \backend\widgets\ElementAlertWidget::widget() ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="wrapper-content animated fadeInRight" style="background-color: #F2F2F2;">
        <!-- Content Header (Page header) -->

        <?php
        $wgnum = 0;
        $ssnum = 0;
        $wsnum = 0;
        $ktnum = 0;
        if(!empty($hotelImg)){
            foreach($hotelImg as $key=>$val){
                if($val['type']==1)
                    $wgnum++;
                if($val['type']==2)
                    $ssnum++;
                if($val['type']==3)
                    $wsnum++;
                if($val['type']==4)
                    $ktnum++;
            }
        }
        ?>
        <!-- Main content -->
        <section class="content">
            <ul class="rummery_tab clearfix">
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/update','id'=>$id]) ?>">酒店信息</a></li>
                <!-- 酒店2.1 添加酒店账户信息 ↓ admin:ys time:2017/11/3 -->
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-account','id'=>$id]) ?>">账号信息</a></li>
                <!-- 完 ↑ -->
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/two','id'=>$id]) ?>">酒店政策</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/three','id'=>$id]) ?>">服务设施</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/four','id'=>$id]) ?>">房型管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/set-price','hotel_id'=>$id]) ?>">房态房价设置</a></li>
                <li class="col-sm-8 current"><a href="###">图片管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/supplier','id'=>$id]) ?>">关联供应商</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/contact','id'=>$id]) ?>">联系人信息</a></li>
            </ul>
            <div class="grogshop_imgs">
                酒店图片<span>（<?php echo count($hotelImg);?>）</span>
            </div>
            <div class="imgs_top">
                外观<span>（<?=$wgnum?>）</span>
            </div>
            <?php
            //dump(array_count_values($hotelImg));
            ?>
            <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form']) ?>
            <div id="wrapper" class="pic_show">
                <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default"
                    data-am-gallery="{ pureview: true }">
                    <?php
                    $cover_img = "";
                    ?>
                    <?php if ($hotelImg) { ?>
                        <?php foreach ($hotelImg as $k => $v):
                            if($v['type']==1) {
                                if($v['is_cover_img'] == 1)
                                    $cover_img = $v['pic'];
                                ?>
                                <li class="house_imgs" <?php if($v['is_cover_img'] == 1) {
                                    echo 'cover=1';
                                } ?> style="position: relative;">
                                    <?php if ($v['is_cover_img'] == 1) { ?>
                                        <b class='figure_first'></b><i class='figure_des'>首图</i>
                                    <?php } ?>
                                    <div class="am-gallery-item" style="position: relative;">
                                        <div style="position: absolute;top: 5px;right: 5px;">
                                        <?php if ($v['is_cover_img'] == 0) { ?>
                                            <span class="settitle" style="color:#fff;cursor: pointer;" type="1">设为首图</span>
                                        <?php } ?>
                                            <span class="cancel1" type="1" cover="<?=$v['is_cover_img']?>">删除</span>
                                        </div>
                                        <input type="hidden" name="pic[]"
                                               value="<?php echo $v['pic']; ?>">
                                        <a href="http://img.tgljweb.com/<?php echo $v['pic']; ?>" class="">
                                            <img src="http://img.tgljweb.com/<?php echo $v['pic']; ?>" style="height: 138px;"/>
                                        </a>
                                        <i class="desc_i">
                                            <?php echo $v['des']?>
                                            <input type="hidden" name="pic_desc[]" value="<?php echo $v['des']?>">
                                        </i>
                                    </div>
                                </li>
                                <?php
                            }
                            endforeach ?>
                    <?php } ?>
                </ul>
            </div>
            <div style="clear: both;"></div>

            <div id="wrapper" class="f_wrapper">
                <div id="container">
                    <div id="uploader" class="uploader">
                        <div class="queueList">
                            <div id="dndArea" class="placeholder">
                                <div id="filePicker"></div>
                                <p style="text-align: center;">按住Ctrl可多选 ，请上传<!--5-50张-->酒店外观图片，格式支持.jpg .jpeg .png</p>
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
            <i class="pic_text">请至少上传5张酒店外观图片</i>
            <input type="hidden" name="hotel_id" value="<?php echo $_GET['id']; ?>">
            <input type="hidden" name="cover_img" class="cover_img" id="cover_img" value="<?=$cover_img?>" />
            <input type="hidden" name="type" class="type" value="1" />
            <div class="house_save">保存</div>
            <?= Html::endForm();?>

            <div class="imgs_top">
                设施<span>（<?=$ssnum?>）</span>
            </div>
            <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form']) ?>
            <div id="wrapper" class="pic_show">
                <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default  ul_pic" data-am-gallery="{ pureview: true }">
                    <?php
                    $cover_img = "";
                    ?>
                    <?php if ($hotelImg) { ?>
                        <?php foreach ($hotelImg as $k => $v):
                            if($v['type']==2) {
                                if($v['is_cover_img'] == 1)
                                    $cover_img = $v['pic'];
                                ?>
                                <li class="house_imgs" <?php if($v['is_cover_img'] == 1) {
                                    echo 'cover=1';
                                } ?> style="position: relative;">
                                    <?php if ($v['is_cover_img'] == 1) { ?>
                                        <b class='figure_first'></b><i class='figure_des'>首图</i>
                                    <?php } ?>
                                    <div class="am-gallery-item" style="position: relative;">
                                        <div style="position: absolute;top: 5px;right: 5px;">
                                        <?php if ($v['is_cover_img'] == 0) { ?>
                                            <span class="settitle" style="color:#fff;cursor: pointer;" type="2">设为首图</span>
                                        <?php } ?>
                                            <span class="cancel1" type="2" cover="<?=$v['is_cover_img']?>">删除</span>
                                        </div>
                                        <input type="hidden" name="pic[]"
                                               value="<?php echo $v['pic']; ?>">
                                        <a href="http://img.tgljweb.com/<?php echo $v['pic']; ?>" class="">
                                            <img src="http://img.tgljweb.com/<?php echo $v['pic']; ?>"
                                                 style="height: 138px;"/>
                                        </a>
                                        <i class="desc_i">
                                            <?php echo $v['des']?>
                                            <input type="hidden" name="pic_desc[]" value="<?php echo $v['des']?>">
                                        </i>
                                    </div>
                                </li>
                                <?php
                            }
                        endforeach ?>
                    <?php } ?>
                </ul>
            </div>
            <div style="clear: both;"></div>
            <div id="wrapper_1" class="f_wrapper">
                <div id="container_1">
                    <div id="uploader_1" class="uploader">
                        <div class="queueList">
                            <div id="dndArea_1" class="placeholder">
                                <div id="filePicker_1"></div>
                                <p style="text-align: center;">按住Ctrl可多选 ，请上传<!--5-50张-->酒店设施图片，格式支持.jpg .jpeg .png</p>
                            </div>
                        </div>
                        <div class="statusBar" style="display:none;">
                            <div class="progress">
                                <span class="text">0%</span>
                                <span class="percentage"></span>
                            </div>
                            <div class="info"></div>
                            <div class="btns">
                                <div id="filePicker2_1" class="filePicker2"></div>
                                <div class="uploadBtn">开始上传</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <i class="pic_text">请至少上传5张酒店设施图片</i>
            <input type="hidden" name="hotel_id" value="<?php echo $_GET['id']; ?>">
            <input type="hidden" name="cover_img" class="cover_img" id="cover_img" value="<?=$cover_img?>" />
            <input type="hidden" name="type" id="type" value="2" />
            <div class="house_save">保存</div>
            <?= Html::endForm();?>

            <div class="imgs_top">
                卧室<span>（<?=$wsnum?>）</span>
            </div>
            <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form']) ?>
            <div id="wrapper" class="pic_show">
                <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default  ul_pic" data-am-gallery="{ pureview: true }">
                    <?php
                    $cover_img = "";
                    ?>
                    <?php if ($hotelImg) { ?>
                        <?php foreach ($hotelImg as $k => $v):
                            if($v['type']==3) {
                                if($v['is_cover_img'] == 1)
                                    $cover_img = $v['pic'];
                                ?>
                                <li class="house_imgs" <?php if($v['is_cover_img'] == 1) {
                                    echo 'cover=1';
                                } ?> style="position: relative;">
                                    <?php if ($v['is_cover_img'] == 1) { ?>
                                        <b class='figure_first'></b><i class='figure_des'>首图</i>
                                    <?php } ?>
                                    <div class="am-gallery-item" style="position: relative;">
                                        <div style="position: absolute;top: 5px;right: 5px;">
                                        <?php if ($v['is_cover_img'] == 0) { ?>
                                            <span class="settitle" style="color:#fff;cursor: pointer;" type="3">设为首图</span>
                                        <?php } ?>
                                            <span class="cancel1" type="3" cover="<?=$v['is_cover_img']?>">删除</span>
                                        </div>
                                        <input type="hidden" name="pic[]"
                                               value="<?php echo $v['pic']; ?>">
                                        <a href="http://img.tgljweb.com/<?php echo $v['pic']; ?>" class="">
                                            <img src="http://img.tgljweb.com/<?php echo $v['pic']; ?>"
                                                 style="height: 138px;"/>
                                        </a>
                                        <i class="desc_i">
                                            <?php echo $v['des']?>
                                            <input type="hidden" name="pic_desc[]" value="<?php echo $v['des']?>">
                                        </i>
                                    </div>
                                </li>
                                <?php
                            }
                        endforeach ?>
                    <?php } ?>
                </ul>
            </div>
            <div style="clear: both;"></div>
            <div id="wrapper_2" class="f_wrapper">
                <div id="container_2">
                    <div id="uploader_2" class="uploader">
                        <div class="queueList">
                            <div id="dndArea_2" class="placeholder">
                                <div id="filePicker_2"></div>
                                <p style="text-align: center;">按住Ctrl可多选 ，请上传<!--5-50张-->酒店卧室图片，格式支持.jpg .jpeg .png</p>
                            </div>
                        </div>
                        <div class="statusBar" style="display:none;">
                            <div class="progress">
                                <span class="text">0%</span>
                                <span class="percentage"></span>
                            </div>
                            <div class="info"></div>
                            <div class="btns">
                                <div id="filePicker2_2" class="filePicker2"></div>
                                <div class="uploadBtn">开始上传</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <i class="pic_text">请至少上传5张酒店卧室图片</i>
            <input type="hidden" name="hotel_id" value="<?php echo $_GET['id']; ?>">
            <input type="hidden" name="cover_img" class="cover_img" id="cover_img" value="<?=$cover_img?>" />
            <input type="hidden" name="type" id="type" value="3" />
            <div class="house_save">保存</div>
            <?= Html::endForm();?>

            <div class="imgs_top">
                客厅<span>（<?=$ktnum?>）</span>
            </div>
            <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form']) ?>
            <div id="wrapper" class="pic_show">
                <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default  ul_pic" data-am-gallery="{ pureview: true }">
                    <?php
                    $cover_img = "";
                    ?>
                    <?php if ($hotelImg) { ?>
                        <?php foreach ($hotelImg as $k => $v):
                            if($v['type']==4) {
                                if($v['is_cover_img'] == 1)
                                    $cover_img = $v['pic'];
                                ?>
                                <li class="house_imgs" <?php if($v['is_cover_img'] == 1) {
                                    echo 'cover=1';
                                } ?> style="position: relative;">
                                    <?php if ($v['is_cover_img'] == 1) { ?>
                                        <b class='figure_first'></b><i class='figure_des'>首图</i>
                                    <?php } ?>
                                    <div class="am-gallery-item" style="position: relative;">
                                        <div style="position: absolute;top: 5px;right: 5px;">
                                        <?php if ($v['is_cover_img'] == 0) { ?>
                                            <span class="settitle" style="color:#fff;cursor: pointer;" type="4">设为首图</span>
                                        <?php } ?>
                                            <span class="cancel1" type="4" cover="<?=$v['is_cover_img']?>">删除</span>
                                        </div>
                                        <input type="hidden" name="pic[]"
                                               value="<?php echo $v['pic']; ?>">
                                        <a href="http://img.tgljweb.com/<?php echo $v['pic']; ?>" class="">
                                            <img src="http://img.tgljweb.com/<?php echo $v['pic']; ?>"
                                                 style="height: 138px;"/>
                                        </a>
                                        <i class="desc_i">
                                            <?php echo $v['des']?>
                                            <input type="hidden" name="pic_desc[]" value="<?php echo $v['des']?>">
                                        </i>
                                    </div>
                                </li>
                                <?php
                            }
                        endforeach ?>
                    <?php } ?>
                </ul>
            </div>
            <div style="clear: both;"></div>
            <div id="wrapper_3" class="f_wrapper">
                <div id="container_3">
                    <div id="uploader_3" class="uploader">
                        <div class="queueList">
                            <div id="dndArea_3" class="placeholder">
                                <div id="filePicker_3"></div>
                                <p style="text-align: center;">按住Ctrl可多选 ，请上传<!--5-50张-->酒店客厅图片，格式支持.jpg .jpeg .png</p>
                            </div>
                        </div>
                        <div class="statusBar" style="display:none;">
                            <div class="progress">
                                <span class="text">0%</span>
                                <span class="percentage"></span>
                            </div>
                            <div class="info"></div>
                            <div class="btns">
                                <div id="filePicker2_3" class="filePicker2"></div>
                                <div class="uploadBtn">开始上传</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <i class="pic_text">请至少上传5张酒店客厅图片</i>
            <input type="hidden" name="hotel_id" value="<?php echo $_GET['id']; ?>">
            <input type="hidden" name="cover_img" class="cover_img" id="cover_img" value="<?=$cover_img?>" />
            <input type="hidden" name="type" id="type" value="4" />
            <div class="house_save">保存</div>
            <?= Html::endForm();?>
            <input type="hidden" id="hotel_id" value="<?=$id?>">
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <div class="control-sidebar-bg"></div>
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
            height: 175px;
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
            var hotel_id = $('#hotel_id').val();
            var type = $(this).attr("type");
            var cover = $(this).attr("cover");
            var _this = $(this);
            /* if(cover==1){
             layer.alert("当前要删除的图片为首图，请重新设置首图后再做删除！！");
             return false;
             }*/
            layer.confirm('您确定操作吗？', {
                btn: ['确定','取消'], //按钮
                shade: false //不显示遮罩
            }, function(index){
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['del-hotel-pic']) ?>",
                    data: {
                        hotel_id: hotel_id,
                        type:type,
                        del_img:del_img,
                        cover:cover,
                    },
                    success: function (data) {
                        //return false;
                        if (data == 1) {
                            _this.parents(".pic_show").siblings(".cover_img").val("");
                            location.href = "<?php echo \yii\helpers\Url::to(['hotel-pic','id'=> $_GET['id']]) ?>";
                        }
                        layer.close(index);
                    }
                });
                _this.parents('.house_imgs').remove();
            });
            /*var cover_img = "<?php echo $cover_img ? $cover_img : ''; ?>";
             var del_img = $(this).siblings('input').val();
             var hotel_id = $('#hotel_id').val();
             var type = $(this).attr("type");
             var cover = $(this).attr("cover");
             var _this = $(this);
             if (cover == 1) {
             $.ajax({
             type: 'post',
             url: "<?php echo \yii\helpers\Url::to(['del-hotel-cover']) ?>",
             data: {
             hotel_id: hotel_id,
             type:type,
             del_img:del_img,
             },
             success: function (data) {
             if (data == 1) {
             _this.parents(".pic_show").siblings(".cover_img").val("");

             }
             }
             })
             }
             $(this).parents('.house_imgs').remove();*/
        })

        $(document).on('click', '.settitle', function () {
            var hotel_id = $('#hotel_id').val();
            var title_pic = $(this).parent().siblings('input').val();
            var type = $(this).attr("type");
            var This=$(this);
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['set-cover-img']) ?>",
                data: {hotel_id: hotel_id, title_pic: title_pic,type:type},
                success: function (data) {
                    if (data == -1) {
                        layer.open({
                            content: '参数有误',
                        });
                    }if (data == -2) {
                        layer.open({
                            content: '设置失败',
                        });
                    }
                    if (data > 0) {
                        This.parents(".pic_show").siblings(".cover_img").val(title_pic);
                        layer.open({
                            content: '设置成功',
                        });
                        //This.parents('.house_imgs').siblings('li').find('.figure_first').siblings(".am-gallery-item").find(".cancel1").attr("cover","0");
                        This.parents('.house_imgs').siblings('li').find('.figure_first').remove();
                        This.parents('.house_imgs').siblings('li').find('.figure_des').remove();
                        This.hide().parents('.house_imgs').prepend(" <b class='figure_first'></b><i class='figure_des'>首图</i>");
                        //This.hide().parents('.house_imgs').find(".cancel1").attr("cover","1");
                        This.parents('.house_imgs').siblings('li').find('.settitle').show();
                    }
                }
            })
        })
        if ($(".house_imgs").find("b").hasClass("figure_first")) {
            $(".figure_first").siblings(".am-gallery-item").find(".settitle").hide();
        }
    </script>

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="<?= Yii::$app->request->baseUrl ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/app.min.js"></script>
<!--new link-->
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/rummery.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/gobal.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>

<!-- 百度上传图片 -->
<script>
    var upload_type = "hotel_facade";
    var upload_id = $("#hotel_id").val();
</script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/webuploader.js"></script>
<!-- 酒店外观上传 -->
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/upload.js"></script>
<!-- 酒店设施上传 -->
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/upload1.js"></script>
<!-- 酒店卧室上传 -->
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/upload2.js"></script>
<!-- 酒店客厅上传 -->
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/webuploader/upload3.js"></script>

<!-- 图片切换 -->
<script src="<?= Yii::$app->request->baseUrl ?>/amaze/js/amazeui.min.js"></script>

<script>
    $(document).on('click', '.house_save', function () {
        /*var picNum1 = $(this).siblings(".pic_show").find(".house_imgs").length;
        var picNum2 = $(this).siblings(".f_wrapper").find(".pic").length;*/
        var picNum1 = $(".house_imgs").length;
        var picNum2 = $(".pic").length;
        var picNum = parseInt(picNum1+picNum2);
        var picNum_self = $(this).siblings(".f_wrapper").find(".pic").length;
        //alert(picNum1+"+"+picNum2+"="+picNum);
        if(picNum_self>0){
            /*if(picNum<5){
                //$(this).siblings(".pic_text").show();
                layer.alert("请至少上传5张酒店图片");
                return false;
            }
            else{
                $(this).siblings(".pic_text").hide();
                $(this).parent(".hotel-form").submit();
            }*/
            $(this).parent(".hotel-form").submit();
        }
        else{
            layer.alert("没有图片需要提交");
        }

    })
</script>
</body>
</html>

