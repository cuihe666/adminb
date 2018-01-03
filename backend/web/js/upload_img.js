/**
 * Created by cuihe on 2017/9/1.
 */
$(function(){
    $(".file").each(function(ind){
        var index = $(".file").eq(ind).find("button").attr("id").split("browse")[1];
        var uploader = Qiniu.uploader({
            runtimes: 'html5,flash,html4',      // 上传模式,依次退化
            browse_button: 'browse' + index,         // 上传选择的点选按钮，**必需**
            filters: {
                mime_types: [ //只允许上传图片文件和rar压缩文件
                    {title: "图片文件", extensions: "jpg,gif,png,bmp,jpeg"},
                    {title: "RAR压缩文件", extensions: "zip"}
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
                        var html = '<li id="file-' + files[i].id + '"><p class="file-name">' + file_name + '</p><p class="progress"></p></li>';
                        !function (i) {
                            previewImage(files[i], function (imgsrc) {
                                // console.log($(".file-list" + index + " .jia_img").length);
                                $(".file-list" + index + " .add_img").attr("src", imgsrc);
                                $(".file-list" + index).prev().find(".jia_img").css("display", 'none');
                                $(".file-list" + index).css("z-index", "2")
                                $(".file-list" + index).append('<img src="../commodity-change/image/shanchu.png" class="dele_img1" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0;"/>')
                                $(".file-list" + index + " .dele_img1").on("click", function () {
                                    // console.log($(this).siblings(".jia_img").length);
                                    $(this).siblings(".add_img").attr("src", "");
                                    $(this).parent().prev().find(".jia_img").css("display","block");
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
                    $('.progress').css('width', file.percent + '%');//控制进度条
                    // 每个文件上传时,处理相关的事情
                },
                'FileUploaded': function (up, file, info) {
                    var domain = up.getOption('domain');
                    var res = $.parseJSON(info);
                    var sourceLink = domain + res.key;
                    $('.card_pic' + index).val(sourceLink);
                    $('.card_pic' + index).siblings('.close').css('display','inline');
                },
                'Error': function (up, err, errTip) {
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


    //删除图片
    $(".dele_img").each(function(index){
        $(".dele_img").eq(index).click(function(){
            // console.log($(this).parent().prev().find(".jia_img").length);
            $(this).siblings(".add_img").attr("src", "");
            $(this).parent().prev().find(".jia_img").css("display","block");
            $(this).parent().css("z-index", "1");
            $(this).parent().siblings("p").css("z-index", "2");
            $(this).parents(".file").find(".hide_val").val("");
            $(this).remove();
        })
    })

})