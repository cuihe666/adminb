

// 七牛云的token值
var token = "/api/qiniu/getqiniutoken";

function uploadImg(browse,container,pic_url){  //browse:上传选择的点选按钮  container:拖曳上传区域元素的 ID   pic_url:放图片链接的class
    //*******************************图片上传**********************************************
    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',      // 上传模式,依次退化
        browse_button: browse,         // 上传选择的点选按钮，**必需**
        filters: {
            mime_types: [ //只允许上传图片文件和rar压缩文件
                {title: "图片文件", extensions: "jpg,JPG,JPEG,jpeg,PNG,png"}
            ],
            max_file_size: '3072kb', //最大只能上传100kb的文件
        },
        uptoken_url: http_url + token, // uptoken 是上传凭证，由其他程序生成
        get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
        domain: 'http://img.tgljweb.com/',     // bucket 域名，下载资源时用到，**必需**
        container: container,             // 上传区域 DOM ID，默认是 browser_button 的父元素，
        max_file_size: '200mb',             // 最大文件体积限制
        flash_swf_url: 'http://cdn.staticfile.org/Plupload/2.1.1/Moxie.swf',  //引入 flash,相对路径
        max_retries: 50,                     // 上传失败最大重试次数
        dragdrop: true,                     // 开启可拖曳上传
        drop_element: container,          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
        chunk_size: '4mb',                  // 分块上传时，每块的体积
        auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
        init: {
            'FilesAdded': function (up, files) {
                for (var i = 0, len = files.length; i < len; i++) {
                    var file_name = files[i].name; //文件名
                    !function (i) {
                        previewImage(files[i], function (imgsrc) {

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
                console.log(sourceLink)
                $(pic_url).val(sourceLink);
                // $('.card_pic' + index).val(sourceLink);
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

                var key = Date.parse(new Date()) + '.'+ext;
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
    /*******************************************************图片上传完成****************************************************************************/
}
