<?php
use yii\helpers\Url;

$this->title = '当地服务详情';
?>

<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/shenhe_sxh.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/viewer.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/shenhe.js"></script>

<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/fullcalendar.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/fullcalendar.print.css"/>
<script src='<?= Yii::$app->request->baseUrl ?>/js/jquery-ui.custom.min.js'></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/fullcalendar.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>
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

    .theme-sxh2 img {
        margin-left: 96px;
    }

    .theme-sxh2 img, .theme-sxh2 textarea {
        float: left;
    }

    .theme-sxh2 {
        height: 140px;
    }

    .cont-img img {
        margin-bottom: 10px;
    }

    .cont-img img {
        float: left;
        margin-bottom: 10px;
    }

    .rignt-con .div-sxh2 img {
        margin-left: 5px;
    }

    .part_two label {
        color: #333;
        font-size: 12px;
        line-height: 20px;
    }

    .theme-sxh2 {
        overflow: hidden;
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
        font-weight: "Microsoft Yahei";
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

    /*2017年5月18日12:11:11 查看图片插件样式*/
    .dowebok1 li {
        display: inline-block;
        width: 200px;
        height: 150px;
        margin: 0 10px 0 0;
    }

    .dowebok1 li img {
        width: 100%;
        height: 100%;
    }

    /*xhh 2017年6月22日13:53:56 页面样式问题*/
    .rignt-con p > span {
        width: 60px;
        display: inline-block;
    }

</style>
</head>

<body>
<div class="shenhe-sxh">
    <div class="left">

    </div>
    <div class="right">
        <div class="part_one">
            <div class="top">
                <p>
                    <b>

                    </b>
                </p>
                <hr>
            </div>
            <div class="rignt-con">

                <div style="clear: both;"></div>
                <p style="margin-top:20px;">
                    <span>名称</span>
                    <input type="text" style="width:60%;" value="<?php echo $model->serve_name; ?>" readonly>
                </p>

                <p style="margin-top:20px;">
                    <span>服务类型</span>
                    <input type="text" style="width:60%;" value="<?php echo $model->servicecategory->name; ?>" readonly>
                </p>
                <p style="margin-top:20px;">
                    <span>服务方式</span>
                    <input type="text" style="width:60%;" value="<?php
                    if ($model->serve_way == 0) {
                        echo '免费';
                    }
                    if ($model->serve_way == 1) {
                        echo '收费';
                    }


                    ?>" readonly>
                </p>
                <p style="margin-top:20px;">
                    <span>费用</span>
                    <input type="text" style="width:60%;" value="<?php echo $model->serve_price ?>" readonly>
                </p>

                <p class="div-sxh2">
                    <span>服务内容</span>
                    <textarea readonly><?php echo $model->serve_content; ?></textarea>
                </p>

                <p class="div-sxh2">
                    <span>图片</span>
                    <span style="width:80%;float: left;text-align: left;" class="cont-img">
                        <ul class="dowebok1">
                             <?php if ($model->serve_img):
                                 $imgs = explode(',', $model->serve_img);

                                 foreach ($imgs as $k => $v):

                                     ?>
                                     <li><img data-original="" src="http://img.tgljweb.com/<?php echo $v; ?>"></li>
                                     <?php
                                 endforeach;

                             endif ?>
                        </ul>
                    </span>
                </p>

                <?php if ($housedata): ?>
                    <p class="div-sxh2">
                        <span>关联房源</span>
                        <span style="width:80%;float: left;text-align: left;" class="cont-img">
                        <ul class="dowebok1">
                             <?php
                             foreach ($housedata as $k => $v):

                                 ?>
                                 <li>
                                         <a href="<?php echo Url::to(['house-details/view', 'id' => $v['id']]) ?>"
                                            target="_blank">
                                          <img data-original=""
                                               src="http://img.tgljweb.com/<?php echo $v['cover_img']; ?>">
                                         </a>
                                     </li>
                                 <?php
                             endforeach;

                             ?>
                        </ul>
                    </span>
                    </p>
                <?php endif ?>
                <br>
                <?php if ($logs): ?>
                    <p class="div-sxh2">
                    <span>审核日志</span>
                    <?php foreach ($logs as $k => $v):
                        ?>
                        <h5><?php
                            echo $k + 1 . '&nbsp;&nbsp;&nbsp;';
                            echo $v['create_time'];

                            echo $v['result'] == 1 ? '&nbsp;&nbsp;&nbsp;通过' : '不通过' . '&nbsp;&nbsp;&nbsp;&nbsp;' . $v['reson'] ?>
                        </h5>
                    <?php endforeach; ?>
                    </p >

                <?php endif ?>


            </div>


            <div class="part_two">
                <div class="top">
                    <p>
                        <b>
                            审核
                        </b>
                    </p>
                    <hr>
                    <?php if ($model->status == 3): ?>
                    <div class="rignt-con right-con2 right-l">
                        <div class="right-l-con current-dis">
                            <p>
                                <span class="light-sxh">审核：</span>
                            <form style="display: inline-block;">
                                <input type="radio" id="nba" name="status" value="0" checked="'true">
                                <label name="nba" for="nba" class="checked label">
                                    <i>通过审核</i>
                                </label>
                                <input class="nvradio" type="radio" name="status" value="4" id='cba'>
                                <label name="cba" for="cba" class="label2">
                                    <i>未通过审核</i>
                                </label>
                            </form>
                            </p>
                            <div class="dis-sxh2">
                                <p>
                                    <span class="light-sxh">原因：</span>
                                    <textarea placeholder="必填" id="reason"></textarea>
                                </p>
                            </div>
                        </div>
                        <?php endif ?>

                        <?php if ($model->status == 0): ?>
                        <div class="rignt-con right-con2 right-l">
                            <div class="right-l-con current-dis">
                                <p>
                                    <span class="light-sxh">下线：</span>
                                <form style="display: inline-block;">
                                    <input type="radio" id="nba" name="status" value="1">
                                    <label name="nba" for="nba" class=" label">
                                        <i>下线</i>
                                    </label>

                                </form>
                                </p>
                                <div class="dis-sxh2">
                                    <p>
                                        <span class="light-sxh">原因：</span>
                                        <textarea placeholder="必填" id="reason"></textarea>
                                    </p>
                                </div>
                            </div>
                            <?php endif ?>
                            <div class="right-l-btn">
                                <a href="<?php echo Yii::$app->request->getReferrer() ?>" class="btn1">
                                    <button type="button" class="btn1">返回</button>
                                </a>

                                <?php if ($model->status == 3 || $model->status == 0): ?>
                                    <button type="submit" class="btn2 ajaxbtn" style="margin-left: 50px;">提交</button>
                                <?php endif ?>
                            </div>

                        </div>
                    </div>
                </div>

            </div>


            <script>

                $('.ajaxbtn').click(function () {
                    var id = <?php echo $_GET['id'] ?>;
                    var status = $('input[name="status"]:checked').val();
                    var reason = $('#reason').val();
                    var des = $("#des").val();
                    if (status == undefined) {
                        layer.alert('请先选择您的操作！');
                        return false;
                    }
                    if (status == 4) {
                        if (reason == '') {
                            layer.alert('原因不能为空');
                            return false;
                        }
                    }
                    layer.confirm('确定要执行此操作吗', {icon: 3, title: '友情提示'}, function (index) {
                        $.post("<?=Url::to(["local-serve/check"])?>", {
                            "PHPSESSID": "<?php echo session_id();?>",
                            "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                            data: {
                                id: id,
                                status: status,
                                reason: reason,

                            },
                        }, function (data) {
                            if (data == 1) {

                                layer.alert('操作成功');
                                window.location.href = '<?php echo Yii::$app->request->getReferrer() ?>';


                            }


                        });
                    });


                })


            </script>