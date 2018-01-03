<?php
use yii\helpers\Url;
$this->title = '修改线路信息';
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\ScrollAsset::register($this);
?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/shenhe_sxh.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/viewer.min.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/commodity-change/css/travel-higo-manage-change.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/commodity-change/uploadify/uploadify.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/shenhe.js"></script>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/fullcalendar.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/fullcalendar.print.css"/>
<script src='<?= Yii::$app->request->baseUrl ?>/js/jquery-ui.custom.min.js'></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/fullcalendar.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>
<script src="http://cdn.staticfile.org/Plupload/2.1.1/plupload.full.min.js"></script>
<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/commodity-change/uploadify/jquery.uploadify.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/commodity-change/js/zm-canvas-crop2.js"></script>
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
//                    2017年5月9日15:59:33 xhh修改了日历禁止拖拽功能
                    editable: false,
                    events: [
                        <?php
                        $data = \backend\controllers\TravelHigoController::getvents($_GET['id']);

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
//                    dayClick: function (dayDate, allDay, jsEvent, view) { //点击单元格事件
//                        var d = $.fullCalendar.formatDate(dayDate, "dddd");
//                        var m = $.fullCalendar.formatDate(dayDate, "yyyy年MM月dd日");
//
//                        $(".alm_date").html(m + "&nbsp;" + d);
//                        $(".today_date").html(dayDate.getDate())
//                        $("#alm_cnD").html("农历" + lunarDate.lMonth + "月" + lunarDate.lDate);
//                        $("#alm_cnY").html(lunarDate.gzYear + "年&nbsp;" + lunarDate.gzMonth + "月&nbsp;" + lunarDate.gzDate + "日");
//                        $("#alm_cnA").html("【" + lunarDate.animal + "年】");
//                        var fes = lunarDate.festival();
//                        if (fes.length > 0) {
//                            $(".alm_lunar_date").html($.trim(lunarDate.festival()[0].desc));
//                            $(".alm_lunar_date").show();
//                        } else {
//                            $(".alm_lunar_date").hide();
//                        }
//                        // 当天则显示“当天”标识
//                        var now = new Date();
//                        if (now.getDate() == dayDate.getDate() && now.getMonth() == dayDate.getMonth() && now.getFullYear() == dayDate.getFullYear()) {
//                            $(".today_icon").show();
//                        } else {
//                            $(".today_icon").hide();
//                        }
//                    },
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
        width: 46%;
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
        /*border: none !important;*/
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

    .part_two .right-r {
        width: 100%;
        margin-top: 0;
    }

    .part_two {
        height: inherit;
    }
    .city1{
        width: 260px!important;
    }
    #city1{
        margin-left: 82px;
        width: 260px;
    }
</style>

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
//            console.log(index,val,000000)
            //            2017年5月8日17:23:47 zjl 删除首图前方图片隐藏域值减1 问题
            if(val!=0){
                if(index<val) {
//                    console.log(index,val,11111)
                    $("#hidden_canvas").val(parseInt(val)-1);
                }else{
//                    console.log(index,val,22222)

                }
            }
            //            2017年5月68日 宋杏会 隐藏域赋值修改
            if(index == val){
//                console.log(index,val,33333)
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
</head>

<body onload="fc()">
<div class="shenhe-sxh">
    <div class="left">

    </div>
    <div class="right">
        <form action="" method="post" id="update_form" enctype="multipart/form-data">
        <div class="part_one">
            <div class="top">
                <p class="ps">
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
                <div class="rignt-con per">
                    <p class="sxh-1">
                        <span>上传时间</span>
                        <input type="text" value="<?= $model['create_time'] ?>" disabled="disabled"
                               style="border:none;background-color: transparent;">
                    </p>
                    <p>
                        <span>公司名称</span>
                        <input type="text" value="<?php echo $model['auth_name'] ?>" disabled="disabled" >
                    </p>
                    <p class="div-sxh2">
                        <span>公司简介</span>
                        <textarea disabled="disabled" ><?php echo $model['auth_recommend'] ?></textarea>
                    </p>
                    <p class="div-sxh2">
                        <span>资质照片</span>
                        <div class="fl tg_picbox">
                            <div class="zheng">
                                <div class="file" id="file">
                                        <p id="container" class="container tgpic_item">
<!--                                            <button id="browse" ></button>-->
                                            <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img">
                                            <input type="hidden" value="0" class="idcardz upload_status">
                                            <input type="hidden" value="" name="card_pic_zheng" class="card_pic">
                                        </p>
                                        <div class="file-list">
                                            <img src="<?php echo $model['auth_license'] ?>" alt="" class="add_img">
                                        </div>
                                    </div>
                                <i></i>
                            </div>
                            <div class="fan">
                                <div class="file" id="file2">
                                    <p id="container2" class="container2 tgpic_item">
<!--                                        <button id="browse2" ></button>-->
                                        <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img">

                                        <input type="hidden" value="0" class="idcardf upload_status">
                                        <input type="hidden" value="" name="card_pic_fan" class="card_pic2">
                                    </p>
                                    <div class="file-list2">
                                        <img src="<?php echo $model['auth_operation'] ?>" alt="" class="add_img">
                                    </div>
                                </div>
                                <i></i>
                            </div>
<!--                            资质照片的上传-->
                            <script>
//                                console.log($(".fl #browse"))
/*                                $(function(){
                                    $("#container .dele_img").click(function(){
                                        $("#file .add_img").attr("src","");
                                        $(".card_pic").val("0")
                                        $(this).hide()
                                    })
                                    var uploader = Qiniu.uploader({
                                        runtimes: 'html5,flash,html4',      // 上传模式,依次退化
                                        browse_button: 'browse',         // 上传选择的点选按钮，**必需**
                                        filters: {
                                            mime_types: [ //只允许上传图片文件和rar压缩文件
                                                {title: "图片文件", extensions: "jpg,JPG,JPEG,jpeg,PNG,png"}
                                            ],
                                            max_file_size: '3072kb', //最大只能上传100kb的文件
                                        },
                                        uptoken: token, // uptoken 是上传凭证，由其他程序生成
                                        get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
                                        domain: 'http://img.tgljweb.com/',     // bucket 域名，下载资源时用到，**必需**
                                        container: 'container',             // 上传区域 DOM ID，默认是 browser_button 的父元素，
                                        max_file_size: '200mb',             // 最大文件体积限制
                                        flash_swf_url: 'http://cdn.staticfile.org/Plupload/2.1.1/Moxie.swf',  //引入 flash,相对路径
                                        max_retries: 50,                     // 上传失败最大重试次数
                                        dragdrop: true,                     // 开启可拖曳上传
                                        drop_element: 'container',          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
                                        chunk_size: '4mb',                  // 分块上传时，每块的体积
                                        auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
                                        init: {
                                            'FilesAdded': function (up, files) {
                                                for (var i = 0, len = files.length; i < len; i++) {
                                                    var file_name = files[i].name; //文件名

                                                    !function (i) {
                                                        previewImage(files[i], function (imgsrc) {
                                                            $(".file-list .add_img").attr("src",imgsrc);
                                                            $(".file-list").css("z-index","2")
                                                            $(".file-list").append('<img src="../commodity-change/image/shanchu.png" class="dele_img" />')
                                                            $(".file-list .dele_img").on("click",function(){
                                                                $(this).siblings(".add_img").attr("src","");
                                                                $(".file-list").css("z-index","1")
                                                                $(".container").css("z-index","2")
                                                                $(".card_pic").val("0")
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
//                                                console.log(file.percent);

                                                $('.progress').css('width', file.percent + '%');//控制进度条

                                                // 每个文件上传时,处理相关的事情
                                            },
                                            'FileUploaded': function (up, file, info) {
                                                var domain = up.getOption('domain');
                                                var res = $.parseJSON(info);
                                                var sourceLink = domain + res.key; //  获取上传成功后的文件的Url
                                                $('.card_pic').val(sourceLink);
//                                    alert('success')
                                            },
                                            'Error': function (up, err, errTip) {
//                                                console.log(errTip);
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
                                })*/

                            </script>
                            <script>
                                $(function(){
                                    $("#container2 .dele_img").click(function(){
                                        $("#file2 .add_img").attr("src","");
                                        $(".card_pic2").val("0")
                                        $(this).hide()
                                    })
                                    var uploader = Qiniu.uploader({
                                        runtimes: 'html5,flash,html4',      // 上传模式,依次退化
                                        browse_button: 'browse2',         // 上传选择的点选按钮，**必需**
                                        filters: {
                                            mime_types: [ //只允许上传图片文件和rar压缩文件
                                                {title: "图片文件", extensions: "jpg,JPG,JPEG,jpeg,PNG,png"}
                                            ],
                                            max_file_size: '3072kb', //最大只能上传100kb的文件
                                        },
                                        uptoken: token, // uptoken 是上传凭证，由其他程序生成
                                        get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
                                        domain: 'http://img.tgljweb.com/',     // bucket 域名，下载资源时用到，**必需**
                                        container: 'container2',             // 上传区域 DOM ID，默认是 browser_button 的父元素，
                                        max_file_size: '200mb',             // 最大文件体积限制
                                        flash_swf_url: 'http://cdn.staticfile.org/Plupload/2.1.1/Moxie.swf',  //引入 flash,相对路径
                                        max_retries: 50,                     // 上传失败最大重试次数
                                        dragdrop: true,                     // 开启可拖曳上传
                                        drop_element: 'container2',          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
                                        chunk_size: '4mb',                  // 分块上传时，每块的体积
                                        auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
                                        init: {

                                            'FilesAdded': function (up, files) {             for (var i = 0, len = files.length; i < len; i++) {
                                                    var file_name = files[i].name; //文件名

                                                    !function (i) {
                                                        previewImage(files[i], function (imgsrc) {
                                                            $(".file-list2 .add_img").attr("src",imgsrc);
                                                            $(".file-list2").css("z-index","2")
                                                            $(".file-list2").append('<img src="../commodity-change/image/shanchu.png" class="dele_img" />')
                                                            $(".file-list2 .dele_img").on("click",function(){
                                                                $(this).siblings(".add_img").attr("src","");
                                                                $(".file-list2").css("z-index","1")
                                                                $(".container2").css("z-index","2")
                                                                $(".card_pic2").val("0")
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
//                                                console.log(file.percent);

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
                                                $('.card_pic2').val(sourceLink);
//                                    alert('success')
                                            },
                                            'Error': function (up, err, errTip) {
//                                                console.log(errTip);
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

                                    // domain 为七牛空间（bucket)对应的域名，选择某个空间后，可通过"空间设置->基本设置->域名设置"查看获取
                                    // uploader 为一个 plupload 对象，继承了所有 plupload 的方法，参考http://plupload.com/docs
                                })


                            </script>
                        </div>
<!--                        <img src="--><?php //echo $model['auth_license'] ?><!--" alt="">-->
<!--                        <img src="--><?php //echo $model['auth_operation'] ?><!--" alt="">-->
                    </p>
                </div>
            <?php endif ?>
            <p style="color:#2bab6e;margin-top:30px;">
                内容详情：
            </p>
            <div class="rignt-con" style="margin-top:10px;">
                <div class="div-sxh2 zp">
                    <span style="display: block; width: 56px;">封面图片</span>
                    <input type="hidden" name="TravelHigo[first_pic]" id="hidden_canvas" value="<?=$model['first_pic']?>" >
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
                                    <!--<input type="file" name="" id="ipt">-->
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
                </div>
<!--                封面照片-->
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
                <div style="clear:both;"></div>
                <p>
                    <span>活动名称</span>
                    <input maxlength="30" type="text" name="TravelHigo[name]" value="<?php echo htmlspecialchars($model['name']); ?>" style="width: 40%">
                </p>
                <div class="theme-sxh">
                    <span>活动主题</span>
                    <p class="theme" style="display: inline-block; border: 1px solid #ccc; line-height: 20px;padding-right: 15px; margin-left: 20px;" data-target="#myModal" data-toggle="modal">
                        <?php $tags = \backend\models\TravelActivity::gettagidandtitle($model['tag']); ?>
                        <?php if (is_array($tags) && !empty($tags)): ?>
                            <?php foreach ($tags as $kk=> $vv): ?>
                                <span><?=$vv['title']?></span><input type="hidden" name="TravelHigo[tag][]" value="<?php echo $vv['id']; ?>"  style="border: none; margin: 0;">
                            <?php endforeach; ?>
                        <?php endif ?>
                    </p>
                </div>
                <p>
                    <span>出发城市</span>
                    <input type="text" style="width: 200px;" id="start_address" class="city1" name="city1" value="<?php echo ($model['start_city'])?\backend\service\RegionService::getCityName($model['start_city']):'' ?>"  maxlength="30"   autoComplete= "Off" />
                    <input type="hidden" name="TravelHigo[start_city]" class="cityhid" value="<?php echo $model->start_country.",".$model->start_province.",".$model->start_city?>" tg="0" />
                </p>
                <p>
                    <span>目的地城市</span>
                    <input type="text" style="width: 200px; margin-left: 8px;" id="end_address" class="city1" name="city1" value="<?php echo ($model['end_city'])?\backend\service\RegionService::getCityName($model->end_city):'' ?>"  maxlength="30" autoComplete= "Off" />
                    <input type="hidden" name="TravelHigo[end_city]" class="cityhid" value="<?php echo $model->end_country.",".$model->end_province.",".$model->end_city?>" <?php echo intval($model->start_city) != 0 ? 'tg="1"' : 'tg="0"'?> />

                </p>
                <style>
                    .region123{ margin-left:0; background-color: #fff; padding-left:10px; border:1px solid #efefef; border-top:0; margin-top:-2px; height: 330px; overflow-y: scroll; position:absolute; z-index:9; width:300px;}
                    .region123 li{ height: 26px; line-height: 26px; cursor: pointer;}
                    /*.activity_con3 .content input.city1{ height:30px; line-height:30px;}*/
                </style>
                <script>
                    $(".city1").on("input propertychange",function(){
                        var _this = $(this);
                        var name = $(this).val();
                        //清除原先的cityhid，并且把tg设置为0
                        $(this).siblings(".cityhid").val("");
                        $(this).siblings(".cityhid").attr("tg",0);

//                        if(_this.val()==""|| _this.val()==0){
//                            _this.siblings(".cityhid").val('');
//                        }
                        /*reg=/^([\u2E80-\u9FFF])$/
                         if(!reg.test(name)) {
                         alert("请输入正确的信息");
                         return false;
                         }*/
                        if(name!=''){
                            $.ajax({
                                type: 'GET',
                                url: '<?= \yii\helpers\Url::toRoute(["region/getcity"])?>',
                                data: {"name": name},
                                dataType: 'json',
                                success: function (data) {
                                    if(data!=""){
                                        var html = '<ul id="city1" class="form-control region123" name="TravelNote[city1]" >';
                                        $.each(data, function(index, content){
                                            html += '<li data="'+index+'">'+content.replace(name, '<b style="color:red; font-weight:normal">'+name+'</b>')+'</li>';
                                        });
                                        html += '</ul>';
                                        _this.next("#city1").remove();
                                        _this.after(html);
                                    }
                                    else{
                                        _this.next("#city1").remove();
                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    //alert(22);
                                    /*_this.val("");
                                     _this.blur();*/
                                }
                            });
                        }
                        else{
                            $(this).next("#city1").remove();
                        }
                    });

                    $("body").on("click",".region123 li",function(){
                        var code = $(this).attr("data");
                        var name = $(this).text();
                        var nameArr = name.split(",");
                        $(this).parent().siblings(".city1").val(nameArr[0]);
                        $(this).parent().siblings(".cityhid").val(code);
                        $(this).parent().siblings(".cityhid").attr("tg",1);
                        $(this).parent().remove();
                    });

                    function tgCity(ev,city){
                        $(document).on("click",function(){
                            if($(ev).val()=="" && $(ev).attr("tg")=="0"){
                                var code = $(city).find("li:first-child").attr("data");
                                var name = $(city).find("li:first-child").text();
                                var nameArr = name.split(",");
                                $(city).find(".city1").val(nameArr[0]);
                                $(city).find(".cityhid").val(code);
                                $(city).find("ul").remove();
                            }

                        })
                    }
                    tgCity("input[name='TravelHigo[start_city]']",".tg_city1");
                    tgCity("input[name='TravelHigo[end_city]']",".tg_city2");
                </script>
                <p class="div-sxh2">
                    <span>领队简介</span>
                    <textarea name="TravelHigo[profiles]" maxlength="150"><?php echo str_replace("<br>","\n",$model['profiles']); ?></textarea>
                </p>
                <p class="div-sxh2">
                    <span>活动亮点</span>
                    <textarea name="TravelHigo[high_light]" maxlength="150"><?php echo str_replace("<br>","\n",$model['high_light']); ?></textarea>
                </p>
                <div class="xingcheng">
                    <span style="display: block;">行程介绍</span>
                    <?php if (is_array($imgs) && !empty($imgs)): ?>
                        <?php foreach ($imgs as $kk => $vv): ?>
                            <div style="clear: both;"></div>
                            <div class="xcjs">
                                <div class="div-sxh2">
                                    <input type="text" name="TravelHigo[title][]" value="<?php echo $vv['title']; ?>" style="width: 60%;margin-left:78px;">
                                    <input type="hidden" class="number_x" value="<?=$kk?>" >
                                    <img src="../commodity-change/image/dele_pic.png" style="width: 32px;height: 32px;" class="xcdele"/>
                                    <textarea name="TravelHigo[introduce][]"
                                style="margin-left:77px;margin-top:15px;" maxlength="300"><?php echo str_replace("<br>","\n",$vv['introduce']); ?></textarea>
                                </div>
                                <?php if ($vv['pic']){ ?>
                                    <?php
                                        $pics = explode(',', $vv['pic']);
                                        $pic_explains = explode('***', $vv['pic_explain']);
                                    ?>
                                    <?php if (is_array($pics) && !empty($pics)){ ?>
                                        <?php foreach ($pics as $kkk => $vvvv){ ?>
                                            <div style="clear:both;height:150px;position: relative;margin-top: 20px;" class="textarea">
                                                <div class="theme-sxh2">
                                                    <span></span>
                                                    <ul style="float: left;margin-right:54px;">
                                                        <li style="margin-left: 78px;">
                                                            <div class="file" id="file">
                                                                <p id="container" class="container tgpic_item">
                                                                    <button id="browse" class="browse" style="width: 173px;height: 138px;"></button>
                                                                    <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img">
                                                                    <input type="hidden" value="0" class="idcardz upload_status">
                                                                    <input id="travelHigo_pic" type="hidden" value="<?php echo $vvvv; ?>" name="TravelHigo[pic][<?=$kk?>][]" class="card_pic">
                                                                </p>
                                                                <div class="file-list" style="position: relative">
                                                                    <img src="<?php echo $vvvv; ?>" alt=""  class="add_img" style="margin-left: 0;">
                                                                    <input type="hidden" value="<?php echo $vvvv; ?>">
<!--                                                                    <input id="travelHigo_pic" type="hidden"  name="TravelHigo[pic][--><?//=$kk?><!--][]" value="--><?php //echo $vvvv; ?><!--">-->
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <textarea maxlength="300" id="travelHigo_text" style="position: relative;" name="TravelHigo[pic_explain][<?=$kk?>][]"><?php echo str_replace("<br>","\n",@$pic_explains[$kkk]); ?></textarea>
                                                </div>
                                                <img src="../commodity-change/image/dele_pic.png" class="dele"/>
                                            </div>
                                        <?php } ?>

                                    <?php } ?>

                                <?php }else{
                                    ?>
                                    <input id="travelHigo_pic" type="hidden" value="" name="TravelHigo[pic][<?=$kk?>][]" class="card_pic">
                                    <textarea maxlength="300" id="travelHigo_text" style="position: relative;display: none" name="TravelHigo[pic_explain][<?=$kk?>][]"><?php echo str_replace("<br>","\n",@$pic_explains[$kkk]); ?></textarea>
                                <?php
                                }
                                ?>
                                <div class="addnew_text" style="border: 1px solid #ccc;margin: 10px 0px 10px 90px;">
                                    <img src="../commodity-change/image/add_pic.png" style="cursor: pointer;" class="addnew_text_img">
                                </div>
                            </div>
                        <?php endforeach; ?>
<!--                        行程介绍已有图片点击修改-->
                        <script>
                            $(".xcjs").eq(0).find(".xcdele").css("display", "none")
                            var c = 0;
                            var d = 0;
                            $(".xcjs").each(function(index1){
                                $(this).attr("id", "xcjs" + index1);
                                $(".xcjs").eq(index1).find(".textarea").each(function(index2){
                                    c = index2;
                                    d = index1;
//                                    console.log(c, d)
                                    $(this).find("#browse").attr("id", "browse" + index2 + "_" + index1)
                                    $(this).find(".browse").attr("class", "browses")
                                    $(this).find(".card_pic").attr("class", "card_pic" + index2 + "_" + index1)
                                    $(this).find("#container").attr("id", "container" + index2 + "_" + index1);
                                    $(this).find(".file-list").attr("class", "file-list" + index2 + "_" + index1);
                                    $(this).find(".container").attr("class", "container" + index2 + "_" + index1);
                                })
                            })
                       </script>

                    <?php endif ?>
                    <div id="rightbox" style="margin-top:20px;margin-left:0;"></div>
                    <img src="../commodity-change/image/add_pic.png" alt="" class="add_txt" style="margin-left:75px;margin-top:0">
                    <input type="hidden" id="hid_num" value='0'>
                    <input type="hidden" id="hid_num2" value='0'>
                    <input type="hidden" id="hid_num3" value='0'>
                    <script>
                        //                    用于删除行程介绍整体模块
                        $(".xingcheng").on("click", ".xcdele", function(){
//                            var bro, broid, conid, conclass;
                            if(parseInt($(this).parents(".xcjs").attr("id").slice(4)) < parseInt($(".xingcheng .xcjs").last().attr("id").slice(4))){
                                for(var x = parseInt($(this).parents(".xcjs").attr("id").slice(4)); x < $(".xcjs").length; x++){
                                    $(".xcjs").eq(x).find("#travelHigo_pic").attr("name", "TravelHigo[pic][" + (x - 1) + "][]");
                                    if($(".xcjs").eq(x).find(".browses").length > 0){
                                        console.log($(".xcjs").eq(x).find(".browses").length)
                                        for(var o = 0; o < $(".xcjs").eq(x).find(".browses").length; o++){
                                            $(".xcjs").eq(x).find("#travelHigo_pic").eq(o).attr("class","card_pic" + o + "_" + (x - 1))
                                            $(".xcjs").eq(x).find(".browses").eq(o).attr("id", "browse" + o + "_" + (x - 1));
                                            $(".xcjs").eq(x).find("p").eq(o).attr("id", "container" + o + "_" + (x - 1));
                                            $(".xcjs").eq(x).find("p").eq(o).attr("class", "container" + o + "_" + (x - 1));
                                            $(".xcjs").eq(x).find(".add_img").eq(o).parent().attr("class", "file-list" + o + "_" + (x - 1));
                                        }
                                    }
                                    $(".xcjs").eq(x).find("#travelHigo_text").attr("name", "TravelHigo[pic_explain][" + (x - 1) + "][]")
                                    $(".xcjs").eq(x).find(".number_x").val(parseInt($(".xcjs").eq(x).find(".number_x").val()) - 1);

                                }
                            }
                            $(this).parent().parent().remove();
                            for(var i = 0; i < $(".xcjs").length; i++){
                                $(".xcjs").eq(i).attr("id", "xcjs" + i);
                            }
                        })
                        $(".xingcheng").on("click", ".dele", function(){
                            if($(this).parents(".xcjs").find(".textarea").length == 1){
                                var hidden_box = "<div class='hidden_box'>" +
                                                 "<input id='travelHigo_pic' value='' type='hidden' name='TravelHigo[pic][" + $(this).parents('.xcjs').attr("id").slice(4) +"][]' class='card_pic'>" +
                                                 "<textarea style='display:none' name='TravelHigo[pic_explain][" + $(this).parents('.xcjs').attr("id").slice(4) + "][]' id='travelHigo_text'></textarea>" +
                                                 "</div>"
                                $(this).parents(".xcjs").append(hidden_box)
                            }
                            $(this).parent().remove()
                        })
                    </script>
                    <script>
                        $(function(){
                            $(".xingcheng").on("click",'.addnew_text_img', function(){
                                if($(this).parents(".xcjs").find(".textarea").length == 0){
                                    $(this).parents(".xcjs").find(".hidden_box").remove();
                                }
                                for(var i = 0; i < $(this).parents(".xingcheng").find(".textarea").length; i++){
                                    if($(this).parents(".xingcheng").find(".textarea").eq(i).find("#travelHigo_pic").val() == ""){
                                        layer.alert("图片不能为空!");
                                        return false;
                                    }
                                }
//                                if($(this).parents(".xingcheng").find(".textarea").last().find("#travelHigo_pic").val() == ""){
//                                    layer.alert("图片不能为空!");
//                                    return false;
//                                }
                                var numb = $(this).parents(".xcjs").attr("id").slice(4);
                                var str = "<div class='zheng' style='width: 173px;height: 138px;margin: 0px 12px 10px 78px;float: left;'>" +
                                    "<div class='file' id='files' style='width: 173px;height: 138px;'>" +
                                    "<p id='container" + $(this).parent().parent().find(".textarea").length + "_" + numb + "' class='container containers" + $(this).parent().parent().find(".textarea").length + " tgpic_item'>" +
                                    "<button class='browses' id='browse" + $(this).parent().parent().find(".textarea").length + "_" + numb + "' style='width: 173px;height: 138px;z-index:2;'></button>" +
                                    "<img src='../commodity-change/image/add_pic.png' alt='' class='jia_img' style='left: 50%;top: 50%;'>" +
                                    "<input type='hidden' value='0' class='idcardz upload_status'>" +
                                    "<input  id='travelHigo_pic' type='hidden' value='' name='TravelHigo[pic]["+ $(this).parents(".xcjs").find(".number_x").val() +"][]' class='card_pic" + $(this).parent().parent().find(".textarea").length + "_" + numb + "'>" +
                                    "</p>" +
                                    "<div class='file-list" + $(this).parent().parent().find(".textarea").length + "_" + numb + " file-lists'>" +
                                    "<img src='' alt='' class='add_img' style='width: 173px;height: 138px;'>" +
//                                    "<input type='hidden' name='TravelHigo[pic]["+numb+"][]' value='' >" +
                                    "<input type='hidden' value='' >" +
                                    "</div>" +
                                    "</div>" +
                                    "<i></i>" +
                                    "</div>";
                                var li = "<div style='margin-top:15px;padding-bottom:10px;height: 138px;' class = 'imgtag textarea'>" +
                                    "<div class='baokuo' style='position: relative;width:46%;float: left;'>" +
                                    "<textarea  id='travelHigo_text' placeholder='文字说明（选填）' class='text_len' style='float: left;width:100%;height:138px;padding:0;padding-left:10px;border: 1px solid #ccc;;padding-top:10px;box-sizing:border-box;' name='TravelHigo[pic_explain]["+ $(this).parents(".xcjs").find(".number_x").val() +"][]' maxlength ='300'></textarea>" +
                                    "</div>" + "<img src='../commodity-change/image/dele_pic.png' style='width: 32px;height: 32px;float: left;' class='shanchu2 removebtn dele'>" +
                                    "</div>";
                                $(this).parent().parent().find(".addnew_text").before(li)
                                $(this).parent().parent().find(".textarea").eq($(".xcjs").eq(numb).find(".textarea").length - 1).prepend(str)
                                var x = numb;
//                                       var y = $(".xcjs").eq(numb).find(".textarea").length - 1;
                                var y = $(this).parents(".xcjs").find(".textarea").length - 1;
                                var uploader = Qiniu.uploader({
                                    runtimes: 'html5,flash,html4',      // 上传模式,依次退化
                                    browse_button: 'browse' + y + "_" + x,         // 上传选择的点选按钮，**必需**
                                    filters: {
                                        mime_types: [ //只允许上传图片文件和rar压缩文件
                                            {title: "图片文件", extensions: "jpg,JPG,JPEG,jpeg,PNG,png"}
                                        ],
                                        max_file_size: '3072kb', //最大只能上传100kb的文件
                                    },
                                    uptoken: token, // uptoken 是上传凭证，由其他程序生成
                                    get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
                                    domain: 'http://img.tgljweb.com/',     // bucket 域名，下载资源时用到，**必需**
                                    container: 'container' + y + "_" + x,             // 上传区域 DOM ID，默认是 browser_button 的父元素，
                                    max_file_size: '200mb',             // 最大文件体积限制
                                    flash_swf_url: 'http://cdn.staticfile.org/Plupload/2.1.1/Moxie.swf',  //引入 flash,相对路径
                                    max_retries: 50,                     // 上传失败最大重试次数
                                    dragdrop: true,                     // 开启可拖曳上传
                                    drop_element: 'container' + y + "_" + x,          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
                                    chunk_size: '4mb',                  // 分块上传时，每块的体积
                                    auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
                                    init: {
                                        'FilesAdded': function (up, files) {
                                            for (var i = 0, len = files.length; i < len; i++) {
                                                var file_name = files[i].name; //文件名
                                                !function (i) {
                                                    previewImage(files[i], function (imgsrc) {
                                                        $(".file-list" + y + "_" + x +" .add_img").attr("src",imgsrc);
                                                        $(".file-list" + y + "_" + x).css("z-index","2")
                                                        $(".file-list" + y + "_" + x).append('<img src="../commodity-change/image/shanchu.png" class="dele_img" />')
                                                        $(".file-list" + y + "_" + x + " .dele_img").on("click",function(){
                                                            $(this).siblings(".add_img").attr("src","");
                                                            $(".file-list" + y + "_" + x).css("z-index","1")
                                                            $(".container" + y + "_" + x).css("z-index","2")
                                                            $(".card_pic" + y + "_" + x).val("0")
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
//                                                   console.log(file.percent);

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
//                                                   console.log(x)
                                            $('.card_pic' + y + "_" + x).val(sourceLink);
                                            //                                    alert('success')
                                        },
                                        'Error': function (up, err, errTip) {
//                                                   console.log(errTip);
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
//                            点击添加行程介绍整体部分一此部分的图文介绍
                            var ind = 0;
                            $(".content .add_txt").click(function () {
//                              添加整体部分（.xcjs）
                                ind = $(".xcjs").length;
                                var a = parseInt($("#hid_num").val()) + 1;
                                var b = parseInt($("#hid_num2").val()) + 1;
                                var c = parseInt($("#hid_num3").val()) + 1;
                                var numb = $(".xcjs").length;
                                var li_num = '<div class="right addright xcjs" id="xcjs' + ind + '" style="margin-left:90px;margin-bottom:50px;position:relative">' +
                                    '<div class="tg_tit">' +
                                    '<input type="text" class="inp_len title_first" style="margin-bottom:10px;display: inline-block;" placeholder="标题栏（必填）" name="TravelHigo[title][]" maxlength="30"><input type="hidden" class="number_x" value="'+numb+'" >' + '<i class="tishii"></i>' +
                                    '<img src="../commodity-change/image/dele_pic.png" style="width: 32px;height: 32px;" class="shanchu2 removebtn_2 xcdele">' +
                                    '</div><div class="tg_detail">' + '<textarea placeholder="具体介绍（必填）"  class="text_len des_first" name="TravelHigo[introduce][]" maxlength="300"></textarea>' + '<i class="tishi2"></i>' +
                                    '</div>' +
                                    '<div class="hidden_box">'+
                                    '<input id="travelHigo_pic" value="" type="hidden" name="TravelHigo[pic][' + ind +'][]" class="card_pic">'+
                                    '<textarea style="display:none" name="TravelHigo[pic_explain][' + ind + '][]" id="travelHigo_text"></textarea>'+
                                    '</div>'+
                                    "<div class='addnew_text' style='border: 1px solid #ccc;margin: 10px 0px 10px 90px;'>" +
                                    "<img src='../commodity-change/image/add_pic.png' style='cursor: pointer;' class='addnew_text_img'/>" +
                                    "</div>" +
                                    "</div>";
                                $(".xingcheng .add_txt").before(li_num);
                                $("#hid_num").val(a);
                                $("#hid_num2").val(b);
                                $("#hid_num3").val(c);
                            })
//                            已有图片修改
                            $(".xcjs").each(function(index3) {
                                $(".xcjs").eq(index3).find(".browses").each(function (index4) {
                                    var uploader = Qiniu.uploader({
                                        runtimes: 'html5,flash,html4',      // 上传模式,依次退化
                                        browse_button: 'browse' + index4 + "_" + index3,         // 上传选择的点选按钮，**必需**
                                        filters: {
                                            mime_types: [ //只允许上传图片文件和rar压缩文件
                                                {title: "图片文件", extensions: "jpg,JPG,JPEG,jpeg,PNG,png"}
                                            ],
                                            max_file_size: '3072kb', //最大只能上传100kb的文件
                                        },
                                        uptoken: token, // uptoken 是上传凭证，由其他程序生成
                                        get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
                                        domain: 'http://img.tgljweb.com/',     // bucket 域名，下载资源时用到，**必需**
                                        container: 'container' + index4 + "_" + index3,             // 上传区域 DOM ID，默认是 browser_button 的父元素，
                                        max_file_size: '200mb',             // 最大文件体积限制
                                        flash_swf_url: 'http://cdn.staticfile.org/Plupload/2.1.1/Moxie.swf',  //引入 flash,相对路径
                                        max_retries: 50,                     // 上传失败最大重试次数
                                        dragdrop: true,                     // 开启可拖曳上传
                                        drop_element: 'container' + index4 + "_" + index3,          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
                                        chunk_size: '4mb',                  // 分块上传时，每块的体积
                                        auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
                                        init: {
                                            'FilesAdded': function (up, files) {
                                                for (var i = 0, len = files.length; i < len; i++) {
                                                    var file_name = files[i].name; //文件名
                                                    !function (i) {
                                                        previewImage(files[i], function (imgsrc) {
                                                            $(".file-list" + index4 + "_" + index3 + " .add_img").attr("src", imgsrc);
                                                            $(".file-list" + index4 + "_" + index3).css("z-index", "2")
                                                            $(".file-list" + index4 + "_" + index3).append('<img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0;"/>')
                                                            $(".file-list" + index4 + "_" + index3 + " .dele_img").on("click", function () {
                                                                $(this).siblings(".add_img").attr("src", "");
                                                                $(".file-list" + index4 + "_" + index3).css("z-index", "1")
                                                                $(".container" + index4 + "_" + index3).css("z-index", "2")
                                                                $(".card_pic" + index4 + "_" + index3).val("0")
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
//                                                console.log(file.percent);

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
                                                $('.card_pic' + index4 + "_" + index3).val(sourceLink);
                                                //                                    alert('success')
                                            },
                                            'Error': function (up, err, errTip) {
//                                                console.log(errTip);
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
                            })
                        })
                    </script>
                </div>
                <div style="clear: both;"></div>
                <p class="theme-sxh3">
                    <span>订单确认</span>
                    <select style="width: 150px;" name="TravelHigo[is_confirm]">
                        <option value="0" <?=($model['is_confirm'] == 0)?'selected':''?> >即时确认</option>
                        <option value="1" <?=($model['is_confirm'] == 1)?'selected':''?> >商家确认</option>
                    </select>
                    <img class="more_detail" src="<?= Yii::$app->request->baseUrl ?>/commodity-change/image/wenhao.png"/>
                    <span  style="margin-left: 5px;color: #ccc;display: none;font-size: 12px;position: relative;border: 1px solid #ccc;padding: 5px 15px;" class="detail" class="detail">
                        <em></em>
                        用户成功下单后，是否需要商家确认才可出行
                    </span>
                </p>
                <p class="div-sxh2">
                    <span style="margin-top:5px;display: inline-block;">成团设置</span>
                    <b>提前</b>
                    <input type="number" style="width: 60px;margin-left: 0;text-align: center;"  value="<?php echo $model['close_day']; ?>" name="TravelHigo[close_day]" onkeyup="value=value.replace(/[^1234567890-]+/g,''); if(value > 30){value = 30}">
                    <b>天关团</b><span style="color: #ccc;float: none; margin-left: 20px; font-size: 12px;">(可输入0-30天)</span>
                </p>
                <p class="theme-sxh4">
                    <span>有效期</span>
<!--                    <input id="d4311" class="Wdate inp1" type="text" value="--><?php //echo substr($model['start_time'], 0, 10); ?><!--"  onFocus="WdatePicker({minDate: $('.inp1').val(),maxDate: $('.inp2').val()})" style="margin-right: 10px;"/>至-->
<!--                    <input id="d4312" class="Wdate" type="text" value="--><?php //echo substr($model['end_time'], 0, 10); ?><!--" onFocus="WdatePicker({minDate: '#F{$dp.$D(\'d4311\')}',maxDate: $('.inp2').val()})" style="margin-left: 10px;"/>-->
                    <input class="inp1" type="text" value="<?php echo substr($model['start_time'], 0, 10); ?>" disabled="disabled" style="margin-right: 20px; border: none;">至
                    <input class="inp2" type="text" value="<?php echo substr($model['end_time'], 0, 10); ?>" disabled="disabled" style="border: none;">
                </p>
                <p class="theme-sxh4">
                    <span>价格设置</span>
                </p>
                <div class="calendarWrapper" style="border:solid 1px #ddd;width:80%;height: 70%;margin-left:77px;">

                    <div id="calendar" class="dib" style="height:50%;"></div>
                </div>

                <p class="div-sxh2">
                    <span>费用包含</span>
                    <textarea maxlength="500" name="TravelHigo[price_in]"><?php echo str_replace("<br>","\n",$model['price_in']); ?></textarea>
                </p>
                <p class="div-sxh2">
                    <span>费用不含</span>
                    <textarea maxlength="500"  name="TravelHigo[price_out]"><?php echo str_replace("<br>","\n",$model['price_out']); ?></textarea>
                </p>
                <p class="div-sxh2">
                    <span>退订政策</span>
                    最晚提前
                    <input type="number" value="<?php echo $model['refund_type']; ?>" id="unsub" name="TravelHigo[refund_type]" style="width: 60px;">
                    天可退款
                    <i style="font-size:13px;color:#999;text-indent:10px;">填写范围1-30</i>
                </p>
                <p class="div-sxh2">
                    <span>退订说明</span>
                    <textarea name="TravelHigo[refund_note]" ><?php echo str_replace("<br>","\n",$model['refund_note']); ?></textarea>
                </p>
                <p class="div-sxh2">
                    <span>预定须知</span>
                    <textarea name="TravelHigo[note]" ><?php echo str_replace("<br>","\n",$model['note']); ?></textarea>
                </p>


            </div>
        <div class="submitbtn">
            <button type="button" class="submit" style="background: #169bd5;color: white;border: none;">保存</button>
            <a href="<?=Url::to('index')?>" class="btn-cancle">取消</a>
        </div>
    </form>
    </div>

</div>
</body>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="cont">
                <?php foreach ($tag as $k => $v): ?>
                    <span class="tag" tag="<?php echo $v['title']; ?>" num="<?php echo $v['id'] ?>">
                        <?php echo $v['title'] ?>
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
    $(function () {
        // 步骤中的气泡提示 效果
        $(".more_detail").hover(function () {
            $(this).siblings(".detail").show();
        }, function () {
            $(this).siblings(".detail").hide();
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
//        console.log(arr);
        if(arr.length > 0){
            if(arr.length >= $(".theme input").length){
                $(".theme").html("");
                var tag_html = '';
                var tag_val = '';
                for(var i = 0; i < arr.length; i++){
                    tag_html = $.trim($(".cont span").eq(arr[i]).html());
                    tag_val = $.trim($(".cont span").eq(arr[i]).attr('num'));
                    $(".theme").append("<span>"+tag_html+",</span><input type='hidden' name='TravelHigo[tag][]' value='" + tag_val + "' style='border: none;'/>")
                }
            }else{
                var nnn = $(".theme input").length - arr.length;
                for(var z = 0; z < nnn; z++){
                    $(".theme input").last().remove();
                    $(".theme span").last().remove();
                }
                for(var j = 0; j < $(".theme input").length; j++){
                    $(".theme input").eq(j).val($(".cont span").eq(arr[j]).html())
                    $(".theme span").eq(j).html($(".cont span").eq(arr[j]).html() + ",")
                }
            }


        }
    })
</script>

<script>
    $(function(){
        $('#unsub').blur(function(){
            tuiting();
        })
    })

    $('.submit').click(function () {
        var id = <?php echo $_GET['id'] ?>;
//        var status = $('input[name="status"]:checked').val();
//        var reason = $('#reason').val();
//        var des = $("#des").val();
//        if (status == 3) {
//            if (reason == '') {
//                layer.alert('原因不能为空');
//                return false;
//
//            }
//        }
        var facepic_num = $(".zp ul li").length;
        var travelName = $("input[name='TravelHigo[name]']").val();
        var theme_num = $(".theme span").length;
        var start_address = $("#start_address").val();
        var end_address = $("#end_address").val();
        var ladertri = $("textarea[name='TravelHigo[profiles]']").val();
        var activelighter = $("textarea[name='TravelHigo[high_light]']").val();
        var price_in = $("textarea[name='TravelHigo[price_in]']").val()
        var price_out = $("textarea[name='TravelHigo[price_out]']").val()
        var refund_note = $("textarea[name='TravelHigo[refund_note]']").val();
        var note = $("textarea[name='TravelHigo[note]']").val();
        if(facepic_num < 4){
            layer.alert("封面图片至少三张!")
            return false;
        }
        if(travelName == ""){
            layer.alert("名称不能为空!")
            return false;
        }
        if(theme_num == 0){
            layer.alert("活动主题不能为空!")
            return false;
        }
        if(start_address == ""){
            layer.alert("出发城市不能为空!");
            return false;
        }
        if(end_address == ""){
            layer.alert("目的地城市不能为空!");
            return false;
        }
        if(ladertri == ""){
            layer.alert("领队简介不能为空!");
            return false;
        }
        if(activelighter == ""){
            layer.alert("领队简介不能为空!");
            return false;
        }
        tuiting();
        for(var k = 0; k < $(".textarea").length; k++){
            if($(".textarea").eq(k).find("#travelHigo_pic").val() == ""){
                layer.alert("行程介绍图片不能为空!");
                return false;
            }
        }
        for(var i = 0; i < $(".xingcheng").find(".xcjs").length; i++){
            if($("input[name='TravelHigo[title][]']").eq(i).val() == 0 || $("textarea[name='TravelHigo[introduce][]']").eq(i).val() == 0){
                layer.alert("请完善行程介绍!");
                return false;
            }
        }
        if(price_in == ""){
            layer.alert("请参考费用包含!");
            return false;
        }
        if(price_out == ""){
            layer.alert("请参考费用不含!");
            return false;
        }
        if(refund_note == ""){
            layer.alert("请参考退订说明!");
            return false;
        }
        if(note == ""){
            layer.alert("请参考预订须知!");
            return false;
        }


        layer.confirm('确认要发布吗', {icon: 3, title: '友情提示'}, function (index) {
//            $(".submit").attr("type", "submit");
                $('#update_form').submit();
//            $.post("<?//=Url::to(["travel-higo/check"])?>//", {
//                "PHPSESSID": "<?php //echo session_id();?>//",
//                "<?//=Yii::$app->request->csrfParam?>//": "<?//=Yii::$app->request->getCsrfToken()?>//",
//                data: {
//                    id: id,
//                    status: status,
//                    des: des,
//                    reason: reason,
//
//                },
//            }, function (data) {
//                if (data == 1) {
//
//                    layer.alert('操作成功');
//                    //2017年6月23日18:08:19       付燕飞 修改，操作成功后跳转回的页面记录搜索条件
//                    window.location.href = '<?php //echo Yii::$app->request->getReferrer() ?>//';
//                }
//            });
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
//        console.log($("#data-date").attr("start-date").slice(5, 7))
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


