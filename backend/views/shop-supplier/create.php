<!-- 加载编辑器的容器 -->
<textarea id="uploadEditor" class="follow_remark" style="width:900px; height:220px; resize: none;" name="follow_remark"></textarea>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/ueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var uploadEditor = UE.getEditor("uploadEditor", {
        isShow: true,
        toolbars: [[

            'undo', //撤销
            'redo', //重做
            'bold', //加粗
            'indent', //首行缩进
            'snapscreen', //截图

            'strikethrough', //删除线
            'subscript', //下标

            'preview', //预览

            'unlink', //取消链接

            'mergeright', //右合并单元格
            'mergedown', //下合并单元格

            'simpleupload', //单图上传
            'insertimage', //多图上传
            'edittable', //表格属性
            'edittd', //单元格属性
            'link', //超链接
            'emotion', //表情
            'spechars', //特殊字符
            'searchreplace', //查询替换
            'map', //Baidu地图
            'gmap', //Google地图
            'backcolor', //背景色




            ]]
    });
</script>

