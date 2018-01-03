<script src="/common/js/jquery.min.js"></script>
<!-- bootstrap -->
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/bootstrap/dist/js/app.min.js"></script>
<!-- 页面css -->
<link rel="stylesheet" href="/css/cobber_tag.css">

<!-- js -->
<script src="/common/js/input_up.js"></script>

<!--七牛上传图片-->
<script src="http://cdn.staticfile.org/Plupload/2.1.1/plupload.full.min.js"></script>
<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>

<!-- 日历引用文件 -->
<script src="/My97DatePicker/WdatePicker.js"></script>

<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>

<style>
    .content_wrapper {
        margin: 0;
    }

    .content .footer {
        background-color: transparent;
        border: none;
    }

    .file-name {
        border: 1px solid #ccc;
        display: inline-block;
        /*width:200px;*/
        height: 25px;
        padding: 0 20px;
        margin-right: 10px;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-all;
    }

    #browse {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 2px 5px;
        position: absolute;
    }
</style>
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <!--        <form action="-->
        <?php //echo \yii\helpers\Url::to(['tag/addson']) ?><!--" id="uploadForm" method="post"-->
        <!--              enctype="multipart/form-data">-->


        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    规格设置
                </h4>
            </div>
            <div class="modal-body model_st">
                <div class="row row_model">
                    <span>文字:</span>
                    <input type="text" name="title" value="" class="title" id="title">
                    <i class="tips" style="color:red;font-size:12px;"></i>
                </div>
                <div class="row row_model">
                    <span>图片:</span>
                    <p id="container">
                    <p class="file-name"></p>
                    <button id="browse">浏览...</button>
                    </p>
                    <i style="color:red;font-size12px;" class="tips_img"></i>
                    <input type="hidden" name="pic" id='pic'>
                </div>
                <div class="row row_model">
                    <span>排序:</span>
                    <input type="text" value="0" class="inp" onblur="paixu()" name="num" id="num">
                    <i style="color:#ccc">*数字越大越靠前,默认0</i>
                    <i class="paixu" style="color:red;font-size:12px;"></i>
                    <script>
                        function paixu() {
                            var sort = $(".row_model .inp").val();
                            var reg = /^(0|[1-9][0-9]*)$/;
                            if (!reg.test(sort)) {
                                $(".paixu").text("请输入大于等于零的整数")
                            } else {
                                $(".paixu").text("")
                            }
                        }
                    </script>
                </div>
                <div class="row row_model">
                    <span>图片预览:</span>
                    <div id="file-list">
                        <li class="file" style="width:200px;height:150px;border:1px solid #ccc;margin-left:80px;">
                            <img src="" alt="" style="width:200px;height:150px;">
                        </li>
                    </div>
                </div>
                <div class="row foot_model">
                    <button type="button" class="btn btn-primary btn-sure obj_btn">确定</button>
                    <button type="button" class="btn btn-default btn_qx" data-dismiss="modal">取消</button>
                </div>
            </div>
            <!--        </form>-->
        </div>
    </div>

</div>

<section class="content-header">
    <h5>
        当前位置:首页 > 房源配置 > 配套设施编辑
    </h5>
    <hr>
</section>
<section class="content">
    <div class="row row_top" style="padding-left:15px;">
        <p>基本信息</p>
        <hr>
    </div>

    <form action="" method="post">
        <div class="form-group" style="margin-top:30px;">
            <div class="row row_add2 row_tip">
                <span>规格名称:</span>
                <input type="text" name="name" value="<?php echo $cate_data->name ?>">
                <i style="font-size:12px;color:#ccc;">*规格的中文名称</i>
                <i class="message_tip" style="color:red;font-size:12px;"></i>
            </div>
            <div class="row row_add3 row_add2">
                <span>描述:</span>
                <textarea name="desc"><?php echo $cate_data->desc ?></textarea>
                <i>非必填,最多255字符</i>
            </div>
            <div class="row row_add2 row_tip">
                <span>排序数字:</span>
                <input type="text" name="sort" class="sort_inp" value="<?php echo $cate_data->sort ?>"
                       style="width:80px;text-align:center"
                       onblur="upper()">
                <i style="font-size:12px;color:#ccc;">*数字越大越靠前</i>
                <i style="color:red;font-size:12px;" class="sort_tip"></i>
                <script>
                    function upper() {
                        var sort = $("input[name='sort']").val();
                        var reg = /^(0|[1-9][0-9]*)$/;
                        if (!reg.test(sort)) {
                            $(".sort_tip").text("请输入大于等于零的整数")
                        } else {
                            $(".sort_tip").text("")
                        }
                    }
                </script>
            </div>
            <div class="row row_add2">
                <span>规格选项:</span>
                <button type="button" modal_name="#myModal" class="btn btn-default btn-model">+添加选项
                </button>
            </div>
            <div class="table-responsive table_top" style="overflow-x:inherit">
                <table class="table table-bordered table_line">
                    <tbody>
                    <tr class="active">
                        <th>文字</th>
                        <th>图片</th>
                        <th>排序</th>
                        <th>操作</th>
                    </tr>
                    <?php if ($sons): ?>
                        <?php foreach ($sons as $k => $v): ?>
                            <tr>
                                <td><?php echo $v['title']; ?></td>
                                <td><img src="<?php echo $v['pic']; ?>" style="width:40px;"/></td>

                                <td><?php echo $v['sort'] ?></td>
                                <td>
                                    <!--                                    <a href="">修改</a>-->
                                    <a href="<?php echo \yii\helpers\Url::to(['tag/delson', 'id' => $v['id']]) ?>">删除</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                    </tbody>
                </table>
            </div>
            <div class="footer">
                <button type="submit" class="btn btn-primary btn-save">提交保存</button>
                <button type="button" class="btn btn-warning">返回上一页</button>
            </div>

            <form action="" method="post">
        </div>
</section>
<script>
    $(function () {
        $(".btn-model").click(function () {
            $("#myModal").show()
        })
        $(".foot_model .btn_qx").click(function () {
            $("#myModal").hide()
        })

        $(".footer .btn-save").click(function () {
            var name = $("input[name='name']").val();
            if (name == "") {
                $(".message_tip").text("请填写信息");
                return false;
            } else {
                $(".message_tip").text("")
            }
        })
    })
</script>

<?php
if (Yii::$app->session->hasFlash('info')) {
    ?>
    <script>

        layer.alert("<?php echo Yii::$app->session->getFlash('info') ?>", {icon: 2});
    </script>

    <?php

}

?>
<script>
    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',      // 上传模式,依次退化
        browse_button: 'browse',         // 上传选择的点选按钮，**必需**
        filters: {
            mime_types: [ //只允许上传图片文件和rar压缩文件
                {title: "图片文件", extensions: "jpg,png,JPEG,PNG"}
//                {title: "RAR压缩文件", extensions: "zip"}
            ],
//            max_file_size: '100kb', //最大只能上传100kb的文件
//            prevent_duplicates: true //不允许队列中存在重复文件
        },

        // 在初始化时，uptoken, uptoken_url, uptoken_func 三个参数中必须有一个被设置
        // 切如果提供了多个，其优先级为 uptoken > uptoken_url > uptoken_func
        // 其中 uptoken 是直接提供上传凭证，uptoken_url 是提供了获取上传凭证的地址，如果需要定制获取 uptoken 的过程则可以设置 uptoken_func
        uptoken: "<?php echo $token;?>", // uptoken 是上传凭证，由其他程序生成
        // uptoken_url: '/uptoken',         // Ajax 请求 uptoken 的 Url，**强烈建议设置**（服务端提供）
        // uptoken_func: function(file){    // 在需要获取 uptoken 时，该方法会被调用
        //    // do something
        //    return uptoken;
        // },
        get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
        // downtoken_url: '/downtoken',
        // Ajax请求downToken的Url，私有空间时使用,JS-SDK 将向该地址POST文件的key和domain,服务端返回的JSON必须包含`url`字段，`url`值为该文件的下载地址
//        unique_names: true,              // 默认 false，key 为文件名。若开启该选项，JS-SDK 会为每个文件自动生成key（文件名）
        // save_key: true,                  // 默认 false。若在服务端生成 uptoken 的上传策略中指定了 `sava_key`，则开启，SDK在前端将不对key进行任何处理
        domain: 'img.tgljweb.com',     // bucket 域名，下载资源时用到，**必需**
        container: 'container',             // 上传区域 DOM ID，默认是 browser_button 的父元素，
        max_file_size: '200mb',             // 最大文件体积限制
        flash_swf_url: 'http://cdn.staticfile.org/Plupload/2.1.1/Moxie.swf',  //引入 flash,相对路径
        max_retries: 3,                     // 上传失败最大重试次数
        dragdrop: true,                     // 开启可拖曳上传
        drop_element: 'container',          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
        chunk_size: '4mb',                  // 分块上传时，每块的体积
        auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
        //x_vars : {
        //    自定义变量，参考http://developer.qiniu.com/docs/v6/api/overview/up/response/vars.html
        //    'time' : function(up,file) {
        //        var time = (new Date()).getTime();
        // do something with 'time'
        //        return time;
        //    },
        //    'size' : function(up,file) {
        //        var size = file.size;
        // do something with 'size'
        //        return size;
        //    }
        //},
        init: {

            'FilesAdded': function (up, files) {
//                plupload.each(files, function (file) {
//
//                    console.log(file);
//                    return;
//                    // 文件添加进队列后,处理相关的事情
//                });
                for (var i = 0, len = files.length; i < len; i++) {
                    var file_name = files[i].name; //文件名

                    // var html = '<li id="file-' + files[i].id + '"></li>';
                    $(".file-name").text(file_name)
                    // var html = '<li id="file-' + files[i].id + '"><p class="file-name">' + file_name + '</p></li>';
                    // $(html).appendTo('#file-list');
                    !function (i) {
                        previewImage(files[i], function (imgsrc) {
                            $(".file img").attr("src", imgsrc);
                            // $('#file-' + files[i].id).append('<img src="' + imgsrc + '" style="width:200px;height:150px;" class="Plupload_img"/>');
                        })
                    }(i);
                }
            },
            'BeforeUpload': function (up, file) {
                // 每个文件上传前,处理相关的事情
            },
            'UploadProgress': function (up, file) {

                // 每个文件上传时,处理相关的事情
            },
            'FileUploaded': function (up, file, info) {
                var info = JSON.parse(info)
                var url = 'http://img.tgljweb.com/' + info.key;
                $('#pic').attr('value', url);
//                console.log(url);
                // 每个文件上传成功后,处理相关的事情
                // 其中 info 是文件上传成功后，服务端返回的json，形式如
                // {
                //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                //    "key": "gogopher.jpg"
                //  }
                // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html
                // var domain = up.getOption('domain');
                // var res = parseJSON(info);
                // var sourceLink = domain + res.key; 获取上传成功后的文件的Url
//                alert('success')
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

                var key = 'tag_' + Date.parse(new Date()) + '.' + ext;

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
</script>

<!--ajax提交数据-->
<script>
    $('.obj_btn').click(function () {
        var cid = parseInt("<?php echo $_GET['id'] ?>");
        var title = $('#title').val();
        var num = $('#num').val();
        var pic = $('#pic').val();
        if (cid < 0) {
            alert('分类有误');
            return false;
        }
        if (title == '') {
            alert('标题不能为空');
            return false;
        }

        if (num == '') {
            alert('排序值不能为空');
            return false;
        }

        if (pic == '') {

            alert('图片不能为空');

            return false;
        }
        $.ajax({
            type: 'post',
            url: "<?php echo \yii\helpers\Url::to(['addson']) ?>",
            data: {cid: cid, title: title, num: num, pic: pic},
            success: function (data) {
                if (data == 1) {
                    layer.alert('操作成功', {icon: 1});
                    location.href = '<?php echo \yii\helpers\Url::to(['tag/edit', 'id' => $_GET['id']]) ?>';
                }

            }
        })
    })

</script>