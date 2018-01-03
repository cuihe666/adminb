<?php
use yii\helpers\Url;
$this->title = '修改活动信息';
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\ScrollAsset::register($this);
?>

<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/shenhe_sxh.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/viewer.min.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/commodity-change/css/travel-activity-manage-change.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/commodity-change/uploadify/uploadify.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/shenhe.js"></script>

<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/fullcalendar.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/fullcalendar.print.css"/>
<script src='<?= Yii::$app->request->baseUrl ?>/js/jquery-ui.custom.min.js'></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/fullcalendar.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/commodity-change/uploadify/jquery.uploadify.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/commodity-change/js/zm-canvas-crop2.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>
<script src="http://cdn.staticfile.org/Plupload/2.1.1/plupload.full.min.js"></script>
<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.js"></script>
<script language="javascript" type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/commodity-change/js/My97DatePicker/WdatePicker.js"></script>
<script>
    var token = '<?php echo $token;?>'
</script>
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
                        $data = \backend\controllers\TravelActivityController::getvents($_GET['id']);

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
<script type="text/javascript">
    $(function(){
//            2017年5月6日15:45:11 zjl
        if($(".after_div").find("div").hasClass("xh_shoutu")){
            $(".xh_shoutu").parents(".tg_st").find(".shoutu").hide();
            $(".xh_shoutu").parents(".tg_st").siblings(".tg_st").find(".yincang_tool").hide();
            $(".xh_shoutu").parents(".tg_st").siblings(".tg_st").find(".shotu2").show();
        }
        $("body").on("mouseover",".total_div",function(){
            $(this).children(".tool_div").css("opacity","1")
            $(this).children(".tool_div").children("p").show()
        })
        $("body").on("mouseout",".total_div",function(){
            $(this).children(".tool_div").css("opacity","0")
            $(this).children(".tool_div").children("p").hide()
        })
//        编辑页面后台上传的图片
        $("body").on("mouseover",".after_div",function(){
            $(this).children("p").show()
        })
        $("body").on("mouseout",".after_div",function(){
            $(this).children("p").hide()
        })

//        点击设为首图js
//            2017年5月6日15:40:06 zjl
        $("body").on("click",".shoutu",function(){
            if($(".zp ul li").eq(0).find(".div_shoutu").attr("class") == "div_shoutu current_first"){
                $(".zp ul li").eq(0).find(".div_shoutu").attr("class", "div_shoutu")
            }
//                设为首图 字隐藏 本身的 首图slogan 显示
            $(this).hide().parents(".tg_st").find(".div_shoutu2").find("div").show();
            $(this).hide().parents(".tg_st").find(".div_shoutu").show();
//                设为首图 字隐藏 本身的 首图slogan 显示 其他的slogan隐藏  其他的设为首图四个字 显示
            $(this).hide().parents(".tg_st").siblings(".tg_st").find(".div_shoutu2").find("div").hide();
            $(this).hide().parents(".tg_st").siblings(".tg_st").find(".div_shoutu").hide();
            $(this).hide().parents(".tg_st").siblings(".tg_st").find(".shoutu").show();

            var index = $(".shoutu").index($(this));
            $("#hidden_canvas").val(index)
        })
//        删除js
//            2017年5月6日15:40:06 zjl
        $("body").on('click', '.del', function() {
            //后台设置首图
            var index = $(".tg_st .del").index($(this))
            var val = $("#hidden_canvas").val()
            console.log(index,val,000000)
            //            2017年5月8日17:23:47 zjl 删除首图前方图片隐藏域值减1 问题
            if(val!=0){
                if(index<val) {
                    console.log(index,val,11111)
                    $("#hidden_canvas").val(parseInt(val)-1);
                }else{
                    console.log(index,val,22222)

                }
            }
            //            2017年5月68日 宋杏会 隐藏域赋值修改
            if(index == val){
                console.log(index,val,33333)
                $("#hidden_canvas").val("0");
            }
            $(this).parents(".total_div").remove();
            $(this).parents(".after_div").remove();


        })
    })
</script>
<script type="text/javascript">
    $(function(){
        // 点击删除按钮js
        $("#icon_save img").click(function(){
            $(".layer").hide()
        })

    })
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
        margin-left:96px;
    }
    .theme-sxh2 img,.theme-sxh2 textarea{
        float: left;
    }
    .theme-sxh2{
        height:140px;
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
        height:150px;
        margin:0 10px 0 0;
    }

    .dowebok1 li img {
        width: 100%;
        height:100%;
    }
    .city1{
        width: 260px;
    }
    #city1{
        margin-left: 80px;
        width: 260px;
    }
</style>
</head>

<body onload="fc()">
<div class="shenhe-sxh">
    <div class="left">

    </div>
    <form action="" method="post"  enctype="multipart/form-data" >
    <div class="right">
        <div class="part_one">
            <div class="top">
                <p>
                    <b>
                        ID:<?php echo $model['id'] ?>
                    </b>
                </p>
                <hr>
            </div>
            <div class="rignt-con">
                <div class="div-sxh2 zp">
                    <span>封面图片</span>
                    <input type="hidden" id="hidden_canvas" name="TravelActivity[first_pic]" value="<?=$model['first_pic']?>">
                    <span style="width:80%;float: left;text-align: left;" class="cont-img">
                        <ul>
                            <?php
                            $title_pics = explode(',', $model['title_pic']);
                            if ($model['title_pic']) {
                            foreach ($title_pics as $k => $v) {
                            ?>
                            <li class="total_div tg_st">
                                <img src="<?=$v?>">
                                <div class="tool_div">
                                    <p>
                                        <span class='del'>删除</span>
                                        <span class='shoutu shoutu2'>设为</br>首图</span>
                                    </p>
                                </div>
                                <div class='div_shoutu' <?php if ($k == $model['first_pic']){echo 'style="display: block"';} ?> >
                                    <i></i>
                                    <b>首图</b>
                                </div>
                                <input type="hidden" name="title_pic[<?=$k?>]" value="<?=$v?>">
                            </li>
                                <?php
                                }
                            }
                            ?>
                            <li class="add">
                                <div class="canvas_shangchuan">
                                    <div class="result" id="result_canvas"></div>
                                    <a href="javascript:;" class="meihua">
                                        <input type="file" name="" id="ipt" >
                                    </a>
                                    <div class="layer">
                                        <div class="layer_con_cont" style="margin:0 auto;position:relative">
                                            <div class="canvas-box"></div>
                                            <div class="icon_save" id="icon_save">
                                                <img src="<?= Yii::$app->request->baseUrl ?>/commodity-change/image/dele_pic.png" alt="" style="width:40px;height: 40px;">
                                                <input type="button" id="save" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <i class="canvas_i" style="color:red;font-size:14px;font-style:normal;margin:0 0 0 15px;display:none;text-indent:20px;"></i>
                                </div>
                            </li>
                        </ul>
                    </span>
                </div>
                <script type="text/javascript">
                    function saveCallBack(base64) {
                        $(".layer").hide()
                    }
                    var c = new ZmCanvasCrop({
                        fileInput: $('#ipt')[0],
                        saveBtn: $('#save')[0],
                        box_width: 800,  //剪裁容器的最大宽度
                        box_height: 600, //剪裁容器的最大高度
                        min_width: 400,  //上传图片的最小宽度
                        min_height: 300  //上传图片的最小高度
                    }, saveCallBack);
                </script>
                <div style="clear: both;"></div>
                <p style="margin-top:20px;">
                    <span>活动名称</span>
                    <input maxlength="30" type="text" style="width:60%;" name="TravelActivity[name]" value="<?php echo htmlspecialchars($model['name']) ?>">
                </p>
                <p>
                    <span>活动类别</span>
                    <select class="line_type" name="TravelActivity[type]" >
                        <option value="0" <?=($model->type==0)?'selected':''?> >线上活动</option>
                        <option value="1" <?=($model->type==1)?'selected':''?> >线下活动</option>
                    </select>
                    <input type="hidden" value="<?=$model->type?>" id="type_change" />
                </p>

                <div class="theme-sxh">
                    <?php $tags = \backend\models\TravelActivity::gettagidandtitle($model['tag']); ?>

                    <span>活动主题</span>
                    <p class="active" style="border: 1px solid #ccc; display: inline-block;margin-left: 20px;padding-right: 20px;" data-target="#myModal" data-toggle="modal">
                        <?php if (is_array($tags) && !empty($tags)): ?>
                            <?php foreach ($tags as $kk => $vv): ?>
                                <span><?=$vv['title']?></span><input type="hidden" name="TravelActivity[tag][]" value="<?php echo $vv['id']; ?>"  style="border: none; margin: 0;">
                            <?php endforeach; ?>

                        <?php endif ?>
                    </p>
                </div>
                <p class="div-sxh2">
                    <span>活动亮点</span>
                    <textarea name="TravelActivity[hot_spot]" ><?php echo str_replace("<br>","\n",$model['hot_spot']); ?></textarea>
                </p>
                <p class="div-sxh2">
                    <span>活动描述</span>
                    <textarea name="TravelActivity[des]" ><?php echo str_replace("<br>","\n",$model['des']); ?></textarea>
                </p>
                <?php if (is_array($des_img) && !empty($des_img)) {
                foreach ($des_img as $k => $v) { ?>
                    <div class="theme-sxh2 activity_description">
                        <span></span>
                        <ul style="float: left;margin-right:54px;width: 173px;">
                            <li>
                                <div class="file" id="files">
                                    <p id="container" class="container tgpic_item">
                                        <button id="browse" class="browse"
                                                style="width: 173px;height: 138px;opacity: 0;"></button>
                                        <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img">
                                        <input type="hidden" value="0" class="idcardz upload_status">
                                        <input type="hidden" value="<?=$v['pic']?>" name="pic[]" class="card_pic">
                                    </p>
                                    <div class="file-list" style="position: relative">
                                        <img src="<?=$v['pic']?>" alt="" class="add_img"
                                             style="margin-left: 0;width: 173px;height: 138px;">
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <textarea name="pic_explain[]" ><?php echo str_replace("<br>","\n",$v['pic_des']); ?></textarea>
                        <img src='../commodity-change/image/dele_pic.png' style='width: 32px;height: 32px;float: left;'
                             class='shanchu2 removebtn dele'>
                    </div>
                    <?php
                    }
                }
                ?>

                <div class="addnew_text" style="width: 100px; height: 100px;border: 1px solid #ccc;margin: 10px 0px 10px 90px;">
                    <img src="../commodity-change/image/add_pic.png" style="width: 100px;height: 100px;cursor: pointer;">
                </div>
                <script>
//                    给已有的活动描述图文部分绑定新的class和id
                    $(".activity_description").find('li').each(function(index){
                        $(this).find("#browse").attr("id", "browse" + index)
                        $(this).find(".browse").attr("class", "browses")
                        $(this).find(".card_pic").attr("class", "card_pic" + index)
                        $(this).find("#container").attr("id", "container" + index);
                        $(this).find(".file-list").attr("class", "file-list" + index);
                        $(this).find(".container").attr("class", "container" + index);
                    })
//                    给活动描述已有图片添加图片上传功能
                    $(".activity_description").each(function(index){
                        var uploader = Qiniu.uploader({
                            runtimes: 'html5,flash,html4',      // 上传模式,依次退化
                            browse_button: 'browse' + index,         // 上传选择的点选按钮，**必需**
                            filters: {
                                mime_types: [ //只允许上传图片文件和rar压缩文件
                                    {title: "图片文件", extensions: "jpg,JPG,JPEG,jpeg,PNG,png"}
                                ],
                                max_file_size: '3072kb', //最大只能上传100kb的文件
                            },
                            uptoken: token, // uptoken 是上传凭证，由其他程序生成
                            get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
                            domain: 'http://img.tgljweb.com/',     // bucket 域名，下载资源时用到，**必需**
                            container: 'container' + index,             // 上传区域 DOM ID，默认是 browser_button 的父元素，
                            max_file_size: '200mb',             // 最大文件体积限制
                            flash_swf_url: 'http://cdn.staticfile.org/Plupload/2.1.1/Moxie.swf',  //引入 flash,相对路径
                            max_retries: 50,                     // 上传失败最大重试次数
                            dragdrop: true,                     // 开启可拖曳上传
                            drop_element: 'container' + index,          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
                            chunk_size: '4mb',                  // 分块上传时，每块的体积
                            auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
                            init: {
                                'FilesAdded': function (up, files) {
                                    for (var i = 0, len = files.length; i < len; i++) {
                                        var file_name = files[i].name; //文件名
                                        !function (i) {
                                            previewImage(files[i], function (imgsrc) {
                                                $(".file-list" + index + " .add_img").attr("src", imgsrc);
                                                $(".file-list" + index).css("z-index", "2")
                                                $(".file-list" + index).append('<img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0;"/>')
                                                $(".file-list" + index + " .dele_img").on("click", function () {
                                                    $(this).siblings(".add_img").attr("src", "");
                                                    $(".file-list" + index).css("z-index", "1")
                                                    $(".container" + index).css("z-index", "2")
                                                    $(".card_pic" + index).val("0")
                                                    $(this).remove();
                                                })
                                            })
                                        }(i);
                                    }
                                },
                                'BeforeUpload': function (up, file) {
                                    // 每个文件上传前,处理相关的事情
                                },
                                'UploadProgress': function (up, file) {
                                    //                console.log(file);
                                    console.log(file.percent);

                                    $('.progress').css('width', file.percent + '%');//控制进度条
                                    // 每个文件上传时,处理相关的事情
                                },
                                'FileUploaded': function (up, file, info) {
                                    // 每个文件上传成功后,处理相关的事情
                                    // 其中 info 是文件上传成功后，服务端返回的json，形式如
                                    // {
                                    //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                                    //    "key": "gogopher.jpg"
                                    //  }
                                    // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html
                                    var domain = up.getOption('domain');
                                    var res = $.parseJSON(info);
                                    var sourceLink = domain + res.key; //  获取上传成功后的文件的Url
                                    $('.card_pic' + index).val(sourceLink);
                                    //                                    alert('success')
                                },
                                'Error': function (up, err, errTip) {
                                    console.log(errTip);
                                    //上传出错时,处理相关的事情
                                },
                                'UploadComplete': function () {
//                                                        队列文件处理完毕后,处理相关的事情
                                },
                                'Key': function (up, file) {
                                    // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                                    // 该配置必须要在unique_names: false，save_key: false时才生效
                                    var ext = Qiniu.getFileExtension(file.name);

                                    var key = Date.parse(new Date()) + ext;
                                    localStorage.key1 = 'http://img.tgljweb.com/' + key;
                                    // do something with key here
                                    return key
                                },

                            }
                        });


                        function previewImage(file, callback) {//file为plupload事件监听函数参数中的file对象,callback为预览图片准备完成的回调函数
                            if (!file || !/image\//.test(file.type)) return; //确保文件是图片
                            if (file.type == 'image/gif') {//gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
                                var fr = new mOxie.FileReader();
                                fr.onload = function () {
                                    callback(fr.result);
                                    fr.destroy();
                                    fr = null;
                                }
                                fr.readAsDataURL(file.getSource());
                            } else {
                                var preloader = new mOxie.Image();
                                preloader.onload = function () {
                                    preloader.downsize(300, 300);//先压缩一下要预览的图片,宽300，高300
                                    var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                                    callback && callback(imgsrc); //callback传入的参数为预览图片的url
                                    preloader.destroy();
                                    preloader = null;
                                };
                                preloader.load(file.getSource());
                            }
                        }
                    })
//                    给活动描述添加新的图片及说明
                    $(".addnew_text img").on("click", function(){
                        if($(".activity_description").last().find("#addpic").val() == ""){
                            layer.alert("请完善活动描述的图片信息!");
                            return false;
                        }
                        var str = "<div class='theme-sxh2 activity_description' style='margin-top: 20px;'>" +
                            "<span></span>" +
                            "<ul style='float: left;margin-right:54px;width: 173px;'>" +
                            "<li>" +
                            "<div class='file' id='files' style='width: 173px;height: 138px;'>" +
                            "<p style='width: 173px;' id='container" + $(".activity_description").length + "' class='container containers" + $(".activity_description").length + " tgpic_item'>" +
                            "<button class='browses' id='browse" + $(".activity_description").length + "' style='z-index: 2;width: 173px;height: 138px;opacity: 0;'></button>" +
                            "<img src='../commodity-change/image/add_pic.png' alt='' class='jia_img'>" +
                            "<input type='hidden' value='0' class='idcardz upload_status'>" +
                            "<input type='hidden' value='' id='addpic' name='pic[]' class='card_pic" + $(".activity_description").length + "'>" +
                            "</p>" +
                            "<div class='file-list" + $(".activity_description").length + " file-lists'>" +
                            "<img src='' alt='' class='add_img' style='width: 173px;height: 138px;margin-left: 0;'>" +
                            "</div>" +
                            "</div>" +
                            "</li>" +
                            "</ul>" +
                            "<textarea name='pic_explain[]' ></textarea>" +
                            "<img src='../commodity-change/image/dele_pic.png' style='width: 32px;height: 32px;float: left;' class='shanchu2 removebtn dele'>" +
                            "</div>"
                        $(".addnew_text").before(str);
                        var x = $(".activity_description").length - 1;
                        var uploader = Qiniu.uploader({
                            runtimes: 'html5,flash,html4',      // 上传模式,依次退化
                            browse_button: 'browse' + x,         // 上传选择的点选按钮，**必需**
                            filters: {
                                mime_types: [ //只允许上传图片文件和rar压缩文件
                                    {title: "图片文件", extensions: "jpg,JPG,JPEG,jpeg,PNG,png"}
                                ],
                                max_file_size: '3072kb', //最大只能上传100kb的文件
                            },
                            uptoken: token, // uptoken 是上传凭证，由其他程序生成
                            get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
                            domain: 'http://img.tgljweb.com/',     // bucket 域名，下载资源时用到，**必需**
                            container: 'container' + x,             // 上传区域 DOM ID，默认是 browser_button 的父元素，
                            max_file_size: '200mb',             // 最大文件体积限制
                            flash_swf_url: 'http://cdn.staticfile.org/Plupload/2.1.1/Moxie.swf',  //引入 flash,相对路径
                            max_retries: 50,                     // 上传失败最大重试次数
                            dragdrop: true,                     // 开启可拖曳上传
                            drop_element: 'container' + x,          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
                            chunk_size: '4mb',                  // 分块上传时，每块的体积
                            auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
                            init: {
                                'FilesAdded': function (up, files) {
                                    for (var i = 0, len = files.length; i < len; i++) {
                                        var file_name = files[i].name; //文件名
                                        !function (i) {
                                            previewImage(files[i], function (imgsrc) {
                                                $(".file-list" + x +" .add_img").attr("src",imgsrc);
                                                $(".file-list" + x).css("z-index","2")
                                                $(".file-list" + x).append('<img style="position: absolute;top: 0;right: 0;margin-left: 0;" src="../commodity-change/image/shanchu.png" class="dele_img" />')
                                                $(".file-list" + x + " .dele_img").on("click",function(){
                                                    $(this).siblings(".add_img").attr("src","");
                                                    $(".file-list" + x).css("z-index","1")
                                                    $(".container" + x).css("z-index","2")
                                                    $(".card_pic" + x).val("0")
                                                    $(this).hide();
                                                })
                                            })
                                        }(i);
                                    }
                                },
                                'BeforeUpload': function (up, file) {
                                    // 每个文件上传前,处理相关的事情
                                },
                                'UploadProgress': function (up, file) {
                                    //                console.log(file);
                                    console.log(file.percent);

                                    $('.progress').css('width', file.percent + '%');//控制进度条
                                    // 每个文件上传时,处理相关的事情
                                },
                                'FileUploaded': function (up, file, info) {
                                    // 每个文件上传成功后,处理相关的事情
                                    // 其中 info 是文件上传成功后，服务端返回的json，形式如
                                    // {
                                    //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                                    //    "key": "gogopher.jpg"
                                    //  }
                                    // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html
                                    var domain = up.getOption('domain');
                                    var res = $.parseJSON(info);
                                    var sourceLink = domain + res.key; //  获取上传成功后的文件的Url
                                    $('.card_pic' + x).val(sourceLink);
                                    //                                    alert('success')
                                },
                                'Error': function (up, err, errTip) {
                                    console.log(errTip);
                                    //上传出错时,处理相关的事情
                                },
                                'UploadComplete': function () {
                                    //队列文件处理完毕后,处理相关的事情
                                },
                                'Key': function (up, file) {
                                    // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                                    // 该配置必须要在unique_names: false，save_key: false时才生效
                                    var ext = Qiniu.getFileExtension(file.name);

                                    var key = Date.parse(new Date()) + ext;
                                    localStorage.key1 = 'http://img.tgljweb.com/' + key;
                                    // do something with key here
                                    return key
                                },

                            }
                        });


                        function previewImage(file, callback) {//file为plupload事件监听函数参数中的file对象,callback为预览图片准备完成的回调函数
                            if (!file || !/image\//.test(file.type)) return; //确保文件是图片
                            if (file.type == 'image/gif') {//gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
                                var fr = new mOxie.FileReader();
                                fr.onload = function () {
                                    callback(fr.result);
                                    fr.destroy();
                                    fr = null;
                                }
                                fr.readAsDataURL(file.getSource());
                            } else {
                                var preloader = new mOxie.Image();
                                preloader.onload = function () {
                                    preloader.downsize(300, 300);//先压缩一下要预览的图片,宽300，高300
                                    var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                                    callback && callback(imgsrc); //callback传入的参数为预览图片的url
                                    preloader.destroy();
                                    preloader = null;
                                };
                                preloader.load(file.getSource());
                            }
                        }
                    })
//                    点击删除按钮删除整个活动描述追加模块
                    $(document).on("click", ".removebtn",function(){
                        $(this).parent().remove();
                        for(var i = 0; i < $(".activity_description").length; i++){
                            $(".activity_description").eq(i).find(".browses").attr("id", "borwse" + i);
                        }
                    })
                </script>
                <p class="div-sxh2">
                    <span>活动流程</span>
                    <textarea name="TravelActivity[process]" ><?php echo str_replace("<br>","\n",$model['process']); ?></textarea>
                </p>
                <p class="theme-sxh3">
                    <span>人数上限</span>
                    <input type="text" name="TravelActivity[people_max]" onkeyup="value=value.replace(/[^1234567890]+/g,'')"])" value="<?php echo $model['people_max'] ?>" maxlength="2">人
                </p>
                <p class="theme-sxh3">
                    <span>活动时长</span>
                    <input type="text" onkeyup="value=value.replace(/[^1234567890]+/g,'')"])" name="TravelActivity[time_length]" value="<?php echo $model['time_length'] ?>" maxlength="3">
                    <select name="TravelActivity[time_unit]">
                        <option value="0" <?=($model->time_unit == 0)?'selected':''?> >小时</option>
                        <option value="1" <?=($model->time_unit == 1)?'selected':''?> >分</option>
                    </select>
                </p>
                    <p class="xianxia tg_city">
                        <span>活动城市</span>
                        <input type="text" id="TravelActivity[city_code]" class="city1" name="city3"
                               value="<?php echo \backend\models\TravelActivity::getcity($model['city_code']) ?>"
                               style="background-color: transparent;border:1px solid #ccc;"  autoComplete="Off" >
                        <input type="hidden" name="TravelActivity[city_code]" class="cityhid"
                               value="<?php echo $model->country_code . "," . $model->province_code . "," . $model->city_code ?>" <?php echo intval($model->city_code) != 0 ? 'tg="1"' : 'tg="0"' ?> />

                        <style>
                            .region123 {
                                margin-left: 0;
                                border: 1px solid #efefef; /*border-top:0; margin-top:-11px;*/
                                height: 330px;
                                overflow-y: scroll;
                                position: absolute;
                                z-index: 9;
                                width: 330px;
                                background-color: #fff;
                            }

                            .region123 li {
                                height: 26px;
                                line-height: 26px;
                                cursor: pointer;
                                padding-left: 10px;
                            }
                        </style>
                        <script>
                            $(".city1").on("input propertychange", function () {
                                var _this = $(this);
                                var name = $(this).val();
                                //清除原先的cityhid，并且把tg设置为0
                                $(this).siblings(".cityhid").val("");
                                $(this).siblings(".cityhid").attr("tg", 0);
                                /*reg=/^([\u2E80-\u9FFF])$/
                                 if(!reg.test(name)) {
                                 alert("请输入正确的信息");
                                 return false;
                                 }*/
                                if (name != '') {
                                    $.ajax({
                                        type: 'GET',
                                        url: '<?= \yii\helpers\Url::toRoute(["region/getcity"])?>',
                                        data: {"name": name},
                                        dataType: 'json',
                                        success: function (data) {
                                            if (data != "") {
                                                var html = '<ul id="city1" class="form-control region123" name="TravelNote[city1]" >';
                                                $.each(data, function (index, content) {
                                                    html += '<li data="' + index + '">' + content.replace(name, '<b style="color:red; font-weight:normal">' + name + '</b>') + '</li>';
                                                });
                                                html += '</ul>';
                                                _this.next("#city1").remove();
                                                _this.after(html);
                                            }
                                            else {
                                                _this.next("#city1").remove();
                                            }

                                        },
                                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                                            /*_this.val("");
                                             _this.blur();*/
                                        }
                                    });
                                }
                                else {
                                    $(this).next("#city1").remove();
                                }
                            });

                            $("body").on("click", ".region123 li", function () {
                                var code = $(this).attr("data");
                                var name = $(this).text();
                                var nameArr = name.split(",");
                                $(this).parent().siblings(".city1").val(nameArr[0]);
                                $(this).parent().siblings(".cityhid").val(code);
                                $(this).parent().siblings(".cityhid").attr("tg", 1);
                                $(this).parent().remove();
                            });

                            function tgCity(ev, city) {
                                $(document).on("click", function () {
                                    if ($(ev).val() == "" && $(ev).attr("tg") == "0") {
                                        var code = $(city).find("li:first-child").attr("data");
                                        var name = $(city).find("li:first-child").text();
                                        var nameArr = name.split(",");
                                        $(city).find(".city1").val(nameArr[0]);
                                        $(city).find(".cityhid").val(code);
                                        $(city).find("ul").remove();
                                    }

                                })
                            }
                            tgCity("input[name='TravelActivity[city_code]']", ".tg_city");
                        </script>
                    </p>
                    <p class="xianxia">
                        <span>活动地址</span>
                        <input style="width:60%;" type="text" name="TravelActivity[active_address]" value="<?php echo $model['active_address'] ?>">
                    </p>
                    <p class="xianxia">
                        <span>集合地址</span>
                        <input style="width:60%;" type="text" name="TravelActivity[set_address]" value="<?php echo $model['set_address'] ?>">
                    </p>
                    <p class="theme-sxh3 xianxia">
                        <span>集合时间</span>
                        <select id="travelactivity-shi" name="TravelActivity[shi]">
                            <option value="00" <?=($model->shi == '00')?'selected':''?> >00</option>
                            <option value="01" <?=($model->shi == '01')?'selected':''?> >01</option>
                            <option value="02" <?=($model->shi == '02')?'selected':''?> >02</option>
                            <option value="03" <?=($model->shi == '03')?'selected':''?> >03</option>
                            <option value="04" <?=($model->shi == '04')?'selected':''?> >04</option>
                            <option value="05" <?=($model->shi == '05')?'selected':''?> >05</option>
                            <option value="06" <?=($model->shi == '06')?'selected':''?> >06</option>
                            <option value="07" <?=($model->shi == '07')?'selected':''?> >07</option>
                            <option value="08" <?=($model->shi == '08')?'selected':''?> >08</option>
                            <option value="09" <?=($model->shi == '09')?'selected':''?> >09</option>
                            <option value="10" <?=($model->shi == '10')?'selected':''?> >10</option>
                            <option value="11" <?=($model->shi == '11')?'selected':''?> >11</option>
                            <option value="12" <?=($model->shi == '12')?'selected':''?> >12</option>
                            <option value="13" <?=($model->shi == '13')?'selected':''?> >13</option>
                            <option value="14" <?=($model->shi == '14')?'selected':''?> >14</option>
                            <option value="15" <?=($model->shi == '15')?'selected':''?> >15</option>
                            <option value="16" <?=($model->shi == '16')?'selected':''?> >16</option>
                            <option value="17" <?=($model->shi == '17')?'selected':''?> >17</option>
                            <option value="18" <?=($model->shi == '18')?'selected':''?> >18</option>
                            <option value="19" <?=($model->shi == '19')?'selected':''?> >19</option>
                            <option value="20" <?=($model->shi == '20')?'selected':''?> >20</option>
                            <option value="21" <?=($model->shi == '21')?'selected':''?> >21</option>
                            <option value="22" <?=($model->shi == '22')?'selected':''?> >22</option>
                            <option value="23" <?=($model->shi == '23')?'selected':''?> >23</option>
                        </select>时
                        <select id="travelactivity-fen" name="TravelActivity[fen]">
                            <option value="00"  <?=($model->fen == '00')?'selected':''?>  >00</option>
                            <option value="15"  <?=($model->fen == '15')?'selected':''?>  >15</option>
                            <option value="30"  <?=($model->fen == '30')?'selected':''?>  >30</option>
                            <option value="45"  <?=($model->fen == '45')?'selected':''?>  >45</option>
                        </select>分
                    </p>
                <p>
                    <span>联系电话</span>
                    <input type="text" name="TravelActivity[mobile]" value="<?php echo $model['mobile'] ?>" maxlength="11">
                </p>
                <p class="theme-sxh3">
                    <span>订单确认</span>
                    <select style="width: 120px;padding-left: 10px;" name="TravelActivity[is_confirm]" >
                        <option value="0" <?=($model->is_confirm == 0)?'selected':''?> >即时确认</option>
                        <option value="1" <?=($model->is_confirm == 1)?'selected':''?> >商家确认</option>
                    </select>
                    <img class="more_detail" src="<?= Yii::$app->request->baseUrl ?>/commodity-change/image/wenhao.png"/>
                    <span  style="margin-left: 5px;color: #ccc;display: none;font-size: 12px;position: relative;border: 1px solid #ccc;padding: 5px 15px;" class="detail" class="detail">
                        <em></em>
                        用户成功下单后，是否需要商家确认才可出行
                    </span>
                </p>
<!--                用于切换线上和线下模块-->
                <script>
                    $(document).ready(function(){
                        if($("#type_change").val() == 0){
                            $(".xianxia").css("display", "none");
                        }
                    })
                    $(".line_type").on("change", function(){
                        if($(this).val() == "0"){
                            $(".xianxia").css("display", "none")
                        }else{
                            $(".xianxia").css("display", "block");
                        }
                    })
                    $(function () {
                        // 步骤中的气泡提示 效果
                        $(".more_detail").hover(function () {
                            $(this).siblings(".detail").show();
                        }, function () {
                            $(this).siblings(".detail").hide();
                        })
                    })
                </script>
                <p class="theme-sxh4">
                    <span>有效期</span>
                    <input class="inp1" type="text" value="<?php echo substr($model['start_time'], 0, 10) ?>" disabled="disabled">至
                    <input class="inp2" type="text" value="<?php echo substr($model['end_time'], 0, 10) ?>" disabled="disabled">
                </p>
                <p class="theme-sxh4">
                    <span>价格设置</span>
                </p>

                <div class="calendarWrapper" style="border:solid 1px #ddd;width:80%;height: 70%;margin-left:100px;">
                    <div id="calendar" class="dib" style="height:50%;"></div>
                </div>

                <p class="div-sxh2">
                    <span>费用包含</span>
                    <textarea maxlength="500" name="TravelActivity[price_in]"><?php echo str_replace("<br>","\n",$model['price_in']); ?></textarea>
                </p>
                <p class="div-sxh2">
                    <span>费用不含</span>
                    <textarea maxlength="500" name="TravelActivity[price_out]"><?php echo str_replace("<br>","\n",$model['price_out']); ?></textarea>
                </p>
                <p class="div-sxh2">
                    <span>退订政策</span>
                    最晚提前
                    <input type="text" value="<?php echo $model['refund_type'] ?>" id="unsub" name="TravelActivity[refund_type]" style="width: 60px;">
                    天可退款
                    <i style="font-size:13px;color:#999;text-indent:10px;">填写范围1-30</i>
                </p>
                <p class="div-sxh2">
                    <span>退订说明</span>
                    <textarea maxlength="500" name="TravelActivity[refund_note]" ><?php echo str_replace("<br>","\n",$model['refund_note']); ?></textarea>
                </p>
                <p class="div-sxh2">
                    <span>预定须知</span>
                    <textarea maxlength="500" name="TravelActivity[note]" ><?php echo str_replace("<br>","\n",$model['note']); ?></textarea>
                </p>

            </div>
        </div>
        <div class="submitbtn">
            <button class="submit" style="background: #169bd5;color: white;border: none;">保存</button>
            <a href="<?=Url::to('index')?>" class="btn-cancle">取消</a>
        </div>
    </div>
    </form>

</div>
</body>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="cont">
                <?php foreach ($tag as $k => $v): ?>
                    <span class="tag" tag="<?php echo $v['title']; ?>" num="<?php echo $v['id'] ?>">
                        <?=$v['title']?>
                    </span>
                <?php endforeach ?>
            </div>
            <div>
                <span style="margin-right: 100px;"  data-dismiss="modal">取消</span>
                <span  id="savebut" data-dismiss="modal">确定</span>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#unsub').blur(function(){
            tuiting();
        })
    })
    // 添加主题
    var arr = [];
    $(".cont span").each(function(index){
        $(".cont span").eq(index).on("click", function(){
            if(arr.indexOf(index) == -1){
                if(arr.length == 3){
                    layer.alert("最多选三种主题");
                    return false;
                }
                arr.push(index);
                $(this).css({
                    "border": "1px solid green",
                    "color": "green"
                })
            }else{
                arr.splice(arr.indexOf(index), 1);
                $(this).css({
                    "border": "1px solid #ccc",
                    "color": "black"
                })
            }
        })
    })
    $("#savebut").on("click", function(){
        if(arr.length > 0){
            if(arr.length >= $(".active input").length){
                $(".active").html("");
                var tag_html = '';
                var tag_val = '';
                for(var i = 0; i < arr.length; i++){
//                    $(".active").append("<input type='text' value='" + $(".cont span").eq(arr[i]).html() + "' style='border: none;'/>")
                    tag_html = $.trim($(".cont span").eq(arr[i]).html());
                    tag_val = $.trim($(".cont span").eq(arr[i]).attr('num'));
                    $(".active").append("<span style='display: inline-block;height: 30px;line-height: 30px;margin-left: 16px;' >"+tag_html+",</span><input type='hidden' name='TravelActivity[tag][]' value='" + tag_val + "' style='border: none;'/>")
                }
            }else{
                for(var j = 0; j < $(".active input").length; j++){
                    $(".active input").eq(j).val($(".cont span").eq(arr[j]).html())
                    $(".active span").eq(j).html($(".cont span").eq(arr[j]).html())
                }
            }


        }
    })
</script>
<script>
    $(".submit").on("click", function(){
        var facepic_num = $(".zp ul li").length;
        var activity_name = $("input[name='TravelActivity[name]']").val();
        var activity_lighter = $("textarea[name='TravelActivity[hot_spot]']").val();
        var activity_des = $("textarea[name='TravelActivity[des]']").val();
        var activity_process = $("textarea[name='TravelActivity[process]']").val();
        var price_in = $("textarea[name='TravelActivity[price_in]']").val();
        var price_out = $("textarea[name='TravelActivity[price_out]']").val();
        var yuding = $("textarea[name='TravelActivity[refund_note]']").val();

        if(facepic_num < 4){
            layer.alert("最少需要上传三张图片!");
            return false;
        }
        if(activity_name == ""){
            layer.alert("活动名称不能为空!");
            return false;
        }
        if(activity_lighter == ""){
            layer.alert("活动亮点不能为空!");
            return false;
        }
        if(activity_des == ""){
            layer.alert("活动描述不能为空!");
            return false;
        }
        tuiting();
        for(var i = 0; i < $(".activity_description").length; i++){
            if($(".activity_description").eq(i).find("input[name='pic[]']").val() == ""){
                layer.alert("活动描述图片不能为空!");
                return false;
            }
        }
        if(activity_process == ""){
            layer.alert("活动流程不能为空!");
            return false;
        }
        if(price_in == ""){
            layer.alert("请查看费用包含!");
            return false;
        }
        if(price_out == ""){
            layer.alert("请查看费用不含!");
            return false;
        }
        if(yuding == ""){
            layer.alert("请查看预订须知!");
            return false;
        }
    })
    $('.ajaxbtn').click(function () {
        var id = <?php echo $_GET['id'] ?>;
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
            $.post("<?=Url::to(["travel-activity/check"])?>", {
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
    function fc(){
        var fcsYear = $(".inp1").val().slice(0, 4)
        var fcsMonth = parseInt($(".inp1").val().slice(5, 7)) - 1;
        $("#calendar").fullCalendar('gotoDate', fcsYear, fcsMonth);
    }

    $(".calendarWrapper").append("<div class='test-box'><ul><a><li></li></a></ul></div>")
    var start = parseInt($(".inp1").val().slice(5, 7));
    var end = parseInt($(".inp2").val().slice(5, 7));
    var leng = 0; // 用于记录月份的长度
    if(end < start){
        leng = end + 12 - start + 1;
    }else{
        leng = end - start + 1;
    }
    if(leng > 7){
        leng = 7;
    }
    for(var j = 0; j < leng; j++){
        $(".test-box ul").append("<a>" + $(".test-box ul a").html() +"</a>")
    }
    for(var i = 0; i < leng; i++){
        if(parseInt($(".inp1").val().slice(6, 7)) + i > 9 && parseInt($(".inp1").val().slice(5, 7)) + i < 13){
            $(".test-box a li").eq(i).html($(".inp1").val().slice(0, 5) + (parseInt($(".inp1").val().slice(5, 7)) + i))
        }else if(parseInt($(".inp1").val().slice(5, 7)) + i > 12){
            $(".test-box a li").eq(i).html(parseInt($(".inp1").val().slice(0, 4)) + 1 + "-" + (parseInt($(".inp1").val().slice(5, 7)) + i - 12))
        }else{
            $(".test-box a li").eq(i).html($(".inp1").val().slice(0, 5) + (parseInt($(".inp1").val().slice(5, 7)) + i))
        }
    }
    $(".test-box a").each(function(index){
        $(".test-box a").eq(index).on("click", function(){
            $(this).css({
                "border-bottom": "3px solid gray"
            }).siblings().css({
                "border-bottom": "none"
            })
            var fcsYear = $(".test-box a li").eq(index).html().slice(0, 4)
            var fcsMonth = parseInt($(".test-box a li").eq(index).html().slice(5, 7)) - 1;
            $("#calendar").fullCalendar('gotoDate', fcsYear, fcsMonth);
        })
    })
    $(".submit").on("click", function(){
        var facepic_num = $(".zp ul li").length;
        var active_name = $("input[name=TravelActivity[name]]").val();

        if(facepic_num < 4){
            layer.alert("至少上传3张图片!");
            return false;
        }
        if(active_name == ""){
            layer.alert("活动名称不能为空!");
            return false;
        }
    })
    function tuiting() {
        var inpval = $("#unsub").val();
        var re = /^\+?[1-9]\d*$/;
        if (re.test(inpval) && inpval <= 30) {
            return true;
        } else {
            $("#unsub").val("");
            layer.alert("请查看退订政策!");
            return false;
        }
        return;
    }
</script>