<script src="/common/js/jquery.min.js"></script>
<!-- bootstrap -->
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/bootstrap/dist/js/app.min.js"></script>
<!-- 页面css -->
<link rel="stylesheet" href="/css/cobber_tag.css">
<!-- 上传图片引用的js -->
<script src="/common/js/input_up.js"></script>
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
</style>
<div class="modal" id="myModal">
    <div class="modal-dialog">
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
                    <input type="text" name="title" value="" class="title">
                    <i class="tips" style="color:red;font-size:12px;"></i>
                </div>
                <div class="row row_model">
                    <span>图片:</span>
                    <input type="text" class="img2_root" name="root">
                    <div class="imgbox">
                        <em style="z-index:1">浏览...</em>
                        <input type="file" class="filepath" style="z-index:2"/>
                    </div>
                    <i style="color:red;font-size12px;" class="tips_img"></i>
                </div>
                <div class="row row_model">
                    <span>排序:</span>
                    <input type="text" value="0" class="inp" onblur="paixu()">
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
                    <img src="" class="img2"/>
                </div>
                <div class="row foot_model">
                    <button type="button" class="btn btn-primary btn-sure">确定</button>
                    <button type="button" class="btn btn-default btn_qx" data-dismiss="modal">取消</button>
                </div>
            </div>
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
                <input type="text" name="name" value="">
                <i style="font-size:12px;color:#ccc;">*规格的中文名称</i>
                <i class="message_tip" style="color:red;font-size:12px;"></i>
            </div>
            <div class="row row_add3 row_add2">
                <span>描述:</span>
                <textarea name="desc"></textarea>
                <i>非必填,最多255字符</i>
            </div>
            <div class="row row_add2 row_tip">
                <span>排序数字:</span>
                <input type="text" name="sort" class="sort_inp" value="0" style="width:80px;text-align:center"
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
