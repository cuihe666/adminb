<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/4/25
 * Time: 上午11:30
 */

\backend\assets\WebUploaderAsset::register($this);

?>


<div id="uploader2333" class="uploader">
    <div class="queueList">
        <div id="dndArea" class="placeholder">
            <div id="filePicker_clc1"><div class="webuploader-pick">点击选择图片</div></div>
        </div>
        <ul class="filelist"></ul></div>
    <div class="statusBar" style="display:none;">
        <div class="progress" style="display: none;">
            <span class="text">0%</span>
            <span class="percentage" style="width: 0%;"></span>
        </div>
        <div class="info">共0张（0B），已上传0张</div>
        <div class="btns">
            <div id="filePicker_str1" class="webuploader-container"><div class="webuploader-pick">继续添加</div><div id="rt_rt_1befdbp011f131si0ot85mm1noh6" style="position: absolute; top: 0px; left: 0px; width: 1px; height: 1px; overflow: hidden;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div>
            <div class="uploadBtn state-pedding">开始上传</div>
        </div>
    </div>
</div>


<script>

    var unique_id = '<?= $widget_id ?>';

    var config = {
        id : 'upload2333',
        addButon : {
            id : '#filePicker_str1',
            label : '继续添加'
        },
    };

    //需要统一修改的部分
    // id = uploader
    // filePicker_clc1
    // filePicker_str1
    // dndArea

</script>