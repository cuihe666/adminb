<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>外部调用UEditor的多图上传和附件上传</title>
    <script type="text/javascript" charset="utf-8" src="ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="ueditor.all.js"></script>
    <style>
        ul{display: inline-block;width: 100%;margin: 0;padding: 0;}
        li{list-style-type: none;margin: 5px;padding: 0;}
    </style>
</head>
<body>
<h1>外部调用UEditor的多图上传和附件上传示例</h1>
 
<button type="button" id="j_upload_img_btn">多图上传</button>
<ul id="upload_img_wrap"></ul>
 
<button type="button" id="j_upload_file_btn">附件上传</button>
<ul id="upload_file_wrap"></ul>
 
<!-- 加载编辑器的容器 -->
<textarea id="uploadEditor"></textarea>
 
<!-- 使用ue -->
<script type="text/javascript">
 
    // 实例化编辑器，这里注意配置项隐藏编辑器并禁用默认的基础功能。
 var uploadEditor = UE.getEditor("uploadEditor", {
        isShow: false,
        focus: false,
        enableAutoSave: false,
        autoSyncData: false,
        autoFloatEnabled:false,
        wordCount: false,
        sourceEditor: null,
        scaleEnabled:true,
        toolbars: [["insertimage", "attachment"]]
    });
 
    // 监听多图上传和上传附件组件的插入动作
 uploadEditor.ready(function () {
        uploadEditor.addListener("beforeInsertImage", _beforeInsertImage);
        uploadEditor.addListener("afterUpfile",_afterUpfile);
    });
 
    // 自定义按钮绑定触发多图上传和上传附件对话框事件
 document.getElementById('j_upload_img_btn').onclick = function () {
        var dialog = uploadEditor.getDialog("insertimage");
        dialog.title = '多图上传';
        dialog.render();
        dialog.open();
    };
 
    document.getElementById('j_upload_file_btn').onclick = function () {
        var dialog = uploadEditor.getDialog("attachment");
        dialog.title = '附件上传';
        dialog.render();
        dialog.open();

    };
 
    // 多图上传动作
 function _beforeInsertImage(t, result) {
        var imageHtml = '';
        for(var i in result){
            imageHtml += '<li><img src="'+result[i].src+'" alt="'+result[i].alt+'" height="150"></li>';
        }
        document.getElementById('upload_img_wrap').innerHTML = imageHtml;
    }
 
    // 附件上传
 function _afterUpfile(t, result) {
        var fileHtml = '';
        for(var i in result){
            fileHtml += '<li><a href="'+result[i].url+'" target="_blank">'+result[i].url+'</a></li>';
        }
        document.getElementById('upload_file_wrap').innerHTML = fileHtml;
    }
</script>
</body>
</html>