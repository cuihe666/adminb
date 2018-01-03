<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="comment-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'obj_sub_type')->dropDownList(Yii::$app->params['comment_type']) ?>

        <?= $form->field($model, 'obj_id')->textInput() ?>

        <?= $form->field($model, 'nickname')->textInput() ?>

        <?= $form->field($model, 'grade')->dropDownList([1 => '1',2 => '2',3 => '3',4 => '4',5 => '5']) ?>

        <?= $form->field($model, 'content')->textarea(['maxlength' => true]) ?>

        <?= $form->field($model, 'pic')->hiddenInput(['id' => 'pp']) ?>

        <p id="container">
            <?= Html::Button('上传图片', ['class' => 'btn btn-primary','id' => 'browse']) ?>
        <div id="file-list" ></div>
        </p>
        <?= $form->field($model, 'quintessence')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '保存' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::Button($model->isNewRecord ? '取消' : 'Delete', ['class' => $model->isNewRecord ? 'btn btn-error' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<script>
    var x = 1;
    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',      // 上传模式,依次退化
        browse_button: 'browse',         // 上传选择的点选按钮，**必需**
        filters: {
            mime_types: [ //只允许上传图片文件和rar压缩文件
                {title: "图片文件", extensions: "jpg,JPG,JPEG,jpeg,PNG,png"}
            ],
            max_file_size: '20mb', //最大只能上传20mb的文件
        },
        uptoken: token, // uptoken 是上传凭证，由其他程序生成
        get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
        domain: 'http://img.tgljweb.com/',     // bucket 域名，下载资源时用到，**必需**
        container: 'container',             // 上传区域 DOM ID，默认是 browser_button 的父元素，
        max_file_size: '200mb',             // 最大文件体积限制
        flash_swf_url: 'http://cdn.staticfile.org/Plupload/2.1.1/Moxie.swf',  //引入 flash,相对路径
        max_retries: 1,                     // 上传失败最大重试次数
        dragdrop: true,                     // 开启可拖曳上传
        drop_element: 'container',          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
        chunk_size: '4mb',                  // 分块上传时，每块的体积
        auto_start: false,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
        init: {
            'FilesAdded': function (up, files) {
                var had_img_length = up.files.length;
                var count_size = 15;
                if(had_img_length > count_size){
                    alert('最大上传'+count_size+'张');
                    return false;
                }
                uploader.start();
                for (var i = 0, len = files.length; i < len; i++) {
                    var file_name = files[i].name; //文件名
                    $('#file-list').addClass('img');
                    var html = '<li id="file-' + files[i].id + '" class="img-list"></li>';
                    $(html).appendTo('#file-list');
                    !function (i) {
                        previewImage(files[i], function (imgsrc) {
                            $('#file-' + files[i].id).append('<img src="' + imgsrc + '" width="200px" height="200px"/>');
                        })
                    }(i);
                }
            },
            'BeforeUpload': function (up, file) {
                // 每个文件上传前,处理相关的事情
            },
            'UploadProgress': function (up, file) {
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
                var hiden_file = $('#pp').val();
//                console.log(sourceLink);
//                hiden_file += sourceLink+',';
                hiden_file += res.key+',';
                $('#pp').val(hiden_file);
//                $('.card_pic' + x).val(sourceLink);

            },
            'Error': function (up, err, errTip) {
//                console.log(errTip);
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
//                console.log(localStorage.key1);
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
</script>