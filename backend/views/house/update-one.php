<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
$this->title = '基本信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--<link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>-->
<script type="text/javascript"
        src="http://maps.google.cn/maps/api/js?key=AIzaSyDTGzrVtaszLJYj7pzMNB2ZWDEeVhIN0Dw&sensor=false&libraries=places&language=zh-CN"></script>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=617da82831edeaf0c65e7352adf79479"></script>
<script type="text/javascript"
        src="http://webapi.amap.com/maps?v=1.3&key=617da82831edeaf0c65e7352adf79479&plugin=AMap.Autocomplete,AMap.PlaceSearch,AMap.Geocoder"></script>
<script src="http://webapi.amap.com/ui/1.0/main.js"></script>
<script type="text/javascript" src="http://webapi.amap.com/demos/js/liteToolbar.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<!--<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=617da82831edeaf0c65e7352adf79479&plugin=AMap.Geocoder"></script>-->
<script>
    function testprov(obj) {
        $.get("<?=Url::to(["house/getprovince"])?>" + "?id=" + $(obj).val(), function (data) {
            $("#bank_prov").html(data);
        });

        $("#bank_city").html('<option>请选择城市</option>');
        $("#bank_area").html('<option>请选择区域</option>');
    }

    function testcity(obj) {
        $.get("<?=Url::to(["house/getcity"])?>" + "?id=" + $(obj).val(), function (data) {
            $("#bank_city").html(data);
            $("#bank_area").html('<option>请选择区域</option>');
        });

    }

    function testarea(obj) {
        $.get("<?=Url::to(["house/getarea"])?>" + "?id=" + $(obj).val(), function (data) {
            $("#bank_area").html(data);
        });

    }

</script>

<style>
    .wrapper {
        position: inherit !important;
    }

    .content > .row > span {
        border: 1px solid #666;
        padding: 5px 10px;
        margin-right: 10px;
    }

    .table td {
        padding-top: 10px !important;
    }

    .table td label {
        margin-right: 20px;
    }

    .table td label input {
        float: left;
        margin-right: 5px;
    }

    .table td label em {
        margin-top: 2px;
        display: inline-block;
        font-style: normal;
        color: #666;
    }

    .table .acreage label input {
        width: 10%;
        float: inherit;
        text-align: center;
        font-weight: normal;
    }

    .table .acreage label em {
        margin-right: 10px;
    }

    .table .acreage2 label {
        margin-top: 10px;
        display: block;
    }

    .table .acreage2 label input {
        width: 50px;
        text-align: center;
    }

    .table .acreage2 label img {
        width: 25px;
        margin-left: 15px;
    }

    .table .acreage2 label img.shanchu {
        width: 20px;
        margin-left: 20px;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /*地图样式*/

    .left {
        float: left;
    }

    .right {
        /*float: right;*/
    }

    .clearfix {
        clear: both;
    }

    .hide {
        display: none;
    }

    /*地图标注文本样式*/
    #tip2 {
        background-color: #fff;
        padding-left: 10px;
        padding-right: 2px;
        font-size: 12px;
        border-radius: 3px;
        overflow: hidden;
        width: 66.67%;
        position: absolute;
        left: 10px;
        top: 10px;
        z-index: 999;
    }

    #tip2 select {
        height: 30px;
        margin-bottom: 10px;
    }

    #tip2 input[type="button"] {
        background-color: #0D9BF2;
        height: 25px;
        text-align: center;
        line-height: 25px;
        color: #fff;
        font-size: 12px;
        padding: 0 10px;
        border-radius: 3px;
        outline: none;
        border: 0;
        cursor: pointer;
    }

    #tip2 input[type="text"] {
        height: 25px;
        border: 1px solid #eee;
        padding-left: 5px;
        border-radius: 3px;
        outline: none;
        width: 100% !important;
        height: 34px;
    }

    #pos {
        background-color: #fff;
        padding-left: 10px;
        padding-right: 10px;
        font-size: 12px;
        border-radius: 3px;
        position: absolute;
        left: 0;
        top: 85px;
    }

    #pos input {
        border: 1px solid #ddd;
        height: 23px;
        border-radius: 3px;
        outline: none;
    }

    #result1 {
        max-height: 300px;
    }

    .amap-info-content {
        text-align: center;
        width: 250px !important;
        padding-left: 0;
        padding-right: 0;
    }

    .amap-logo {
        display: none;
    }

    .amap-copyright {
        display: none !important;
    }

    .cha {
        position: absolute;
        right: 20px;
        top: 20px;
        width: 20px;
    }

    .change_price span {
        background-color: #ccc;
        padding: 5px 10px;
        border-radius: 5px;
        color: #fff;
        margin-bottom: 10px;
        display: inline-block;
        margin-right: 10px;
    }

    .week_label {
        padding-left: 25px;
    }

    .week_label label {
        margin-right: 15px;
        display: inline-block;
    }

    .week_label input {
        float: left;
    }

    .week_label em {
        font-style: normal;
        font-weight: normal;
        display: inline-block;
        margin-left: 5px;
        margin-top: 3px;
    }

    label {
        font-weight: normal !important;
    }

    textarea {
        outline: none;
        padding: 5px 0 0 5px;
    }

    #myModal6 label {
        display: inline-block;
        margin-right: 15px;
    }

    #myModal6 label input {
        float: left;
    }

    #myModal6 .row {
        margin-top: 5px
    }

    #myModal6 label em {
        font-style: normal;
        color: #999;
        font-weight: normal;
        display: inline-block;
        margin-top: 0px;
        margin-left: 3px;
        font-size: 14px;
    }

    #myModal6 span {
        display: inline-block;
        font-size: 14px;
    }

    .table-responsive > .table td {
        text-align: left !important;
    }

    .gmnoprint {
        display: none;
    }

    .amap-sug-result {
        left: 600px !important;
        top: 557px !important;
    }
</style>
<script>
    function leave() {
        var len = $(".title_inp").val().length;
        if (len > 22 || len < 5) {
//            alert("请输入正确格式");
            $(".title_inp").val("")
            $(".title_inp").siblings("span").css("color", "red")
        } else {
            $(".title_inp").siblings("i").text("")
            $(".title_inp").siblings("span").css("color", "#ccc")
        }
    }
    //input checkbox

    function chooseOne(cb) {
        var obj = document.getElementsByName("nm");
        for (var i = 0; i < obj.length; i++) {
            if (obj[i] != cb) {
                obj[i].checked = false;
            } else {
                obj[i].checked = cb.checked;
                $(".tip").text("")
            }
        }
    }
    function choosetwo(cb) {
        var obj = document.getElementsByName("gname");
        for (var i = 0; i < obj.length; i++) {
            if (obj[i] != cb) {
                obj[i].checked = false;
            } else {
                obj[i].checked = cb.checked;
                $(".tips").text("")
            }
        }
    }

    //增加床铺信息
    function add() {
        var str = '<label class="str_label">' +
            '<select name="house_bed[]" class="house_bed">' +
            '<option value="1">双人床</option>' +
            '<option value="2">单人床</option>' +
            '<option value="3">大床</option>' +
            '<option value="4">圆床</option>' +
            '<option value="5">榻榻米</option>' +
            '<option value="6">沙发床</option>' +
            '<option value="7">双层床</option>' +
            '<option value="8">床垫</option>' +
            '<option value="9">其它</option>' +
            '</select>' +
            '<em style="margin-right:5px;margin-left:13px;">长</em>' +
            '<input type="number" name="bed_long[]" placeholder="" style="margin-right:4px;">' +
            '<em style="margin-right:5px;">米*宽</em>' +
            '<input type="number" name="bed_wide[]" placeholder="" style="margin-right:3px;">' +
            '<em>米</em>' +
            '<input type="number" name="bed_count[]" placeholder="" style="margin-right:4px;margin-left:5px">' +
            '<em>张</em>' +
            '<img src="/images/shanchu.png" alt="" class="shanchu">' +
            '</label>';
        $(".add_append").after(str);
    }


    // 地图重置
    function formReset() {
        document.getElementById("myForm").reset()
    }

    $(function () {
        $("body").on("click", ".shanchu", function () {
            $(this).parents(".str_label").remove()
        });
        $(".cha").click(function () {
            $("#myModal").hide()
            $(".modal-backdrop").hide()
        })

    })

</script>
<script>
    function bed_long() {
        var str = $("input[name='bed_long[]']").val();
        var len = $("input[name='bed_long[]']").val().length;
        var reg = /^[0-9]+$/;

        if ($("input[name='bed_long[]']").val() != "") {
//                                        if(!reg.text(str)){
//                                            $(".bed_long").text("请输入大于0的整数")
//                                        }else{
//                                            $(".bed_long").text("")
//                                        }
        }
    }
</script>
<script>
    function bed_count() {
        var str = $("input[name='bed_count[]']").val()
        var reg = /^[0-9]+$/;
        if ($("input[name='bed_count[]']").val() != "") {
            $(".bed_tip").text("")
            var len = $("input[name='bed_count[]']").val().length;
            if (len >= 4 || !reg.test(str)) {
                $(".bed-limit_tip").text("不超过3位数且输入正整数")
            } else {
                $(".bed-limit_tip").text("")
            }
        }
    }
</script>
<section class="content" style="width:80%;margin:0 auto;">
    <div class="row">
        <span id="base_message" style="border:none;background-color: #367fa9;color:#fff;">
            <a href="###" style="color:#fff;">1、基本信息</a>
        </span>
        <span id="price_rule">
            <a href="<?php echo \yii\helpers\Url::to(['add-two', 'house_id' => $_GET['house_id']]) ?>"
               style="color:#666;">2、价格规则</a>
        </span>
        <span id="ruzhu_note">
            <a href="<?php echo \yii\helpers\Url::to(['add-three', 'house_id' => $_GET['house_id']]) ?>"
               style="color:#666;">3、入住须知</a>
        </span>
        <span id="house_dep">
            <a href="<?php echo \yii\helpers\Url::to(['add-four', 'house_id' => $_GET['house_id']]) ?>"
               style="color:#666;">4、房屋描述</a>
        </span>
        <?php ?>
        <?php if ($status == 3): ?>
            <?php if ($house_error) { ?>
                <b style="color:red; line-height: 30px;">审核不通过原因:</b>


                <?php if (!empty($house_error['reson'])): ?>

                    <?php
                    $resons = explode('/n', $house_error['reson']);
                    ?>
                    <td>
                        <?php if (!empty($resons)): ?>
                            <?php foreach ($resons as $k => $v): ?>
                                <b style="line-height: 30px;"><?= isset($house_error['detail_reson']) ? $house_error['detail_reson'] : ''?></b>
                                <b style="line-height: 30px;"><?php echo $k + 1 ?>.<?php echo $v; ?>
                                </b>

                            <?php endforeach ?>

                        <?php endif ?>

                    </td>
                <?php endif ?>
            <?php } ?>
        <?php endif ?>
    </div>
    <div class="form-group">
        <div class="table-responsive">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td style="text-align: right!important;width:140px;">房东手机号</td>
                    <td>
                        <input type="number" disabled value="<?php echo $mobile; ?>" name="yz-num"
                               style="padding-left:5px;box-sizing:border-box;"
                               onblur="cellNumber(this.parentElement)">
                        <i class="yz-num" style="color:red;font-size: 12px;"></i>
                    </td>
                    <script>
                        function cellNumber(num) {
                            var thisval = $("input[name='yz-num']").val();
                            var reg = /^0?1[3|7|4|5|8][0-9]\d{8}$/;
                            if (!reg.test(thisval)) {
                                $(".yz-num").text("请输入正确手机号")
                            } else {
                                $(".yz-num").text("")
                            }
                        }

                    </script>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:140px;">房屋标题</td>
                    <td>
                        <input type="text" value="<?php echo $house_data['title']; ?>"
                               style="width:40%;" class="title_inp">
                        <!--                        <span style="color:#ccc">*房源标题必须为5-22字</span>-->
                        <i style="color:red;font-size: 12px;"></i>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:140px;">出租类型</td>
                    <td class="inp_check_rent">
                        <label>
                            <input type="checkbox" <?php if ($house_data['roommode'] == 1) {
                                echo 'checked';
                            } ?> name="nm" onclick="return chooseOne(this);" value="1">
                            <em>整租</em>
                        </label>
                        <label>
                            <input type="checkbox" <?php if ($house_data['roommode'] == 2) {
                                echo 'checked';
                            } ?> name="nm" onclick="return chooseOne(this);" value="2">
                            <em>单间</em>
                        </label>
                        <label>
                            <input type="checkbox" <?php if ($house_data['roommode'] == 3) {
                                echo 'checked';
                            } ?> name="nm" onclick="return chooseOne(this);" value="3">
                            <em>床位</em>
                        </label>
                        <i class="tip" style="color:red;font-size: 12px;"></i>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:140px;">房源类型</td>
                    <td class="inp_check_fy">
                        <?php foreach ($house_type as $k => $v): ?>
                            <label>
                                <input <?php if ($house_data['code'] == $v['id']) {
                                    echo 'checked';
                                } ?> type="checkbox" name="gname" onclick="return choosetwo(this);"
                                     value="<?php echo $v['id']; ?>">
                                <em><?php echo $v['code_name']; ?></em>
                            </label>
                        <?php endforeach; ?>
                        <i class="tips" style="color:red;font-size: 12px;"></i>
                    </td>
                </tr>
                <tr class="acreage">
                    <td style="text-align: right!important;width:140px;">房源面积</td>
                    <td>
                        <label>
                            <input type="number" name="proportion" value="<?php echo $house_data['roomsize']; ?>"
                                   onblur="proportion()">
                            <script>
                                function proportion() {
                                    var str = $('input[name="proportion"]').val();
                                    if ($('input[name="proportion"]').val() != "") {
                                        var reg = /^[0-9]+$/;
                                        var len = $('input[name="proportion"]').val().length;
                                        if (len >= 5 || !reg.test(str)) {
                                            $(".proportion_tip").text("不超过4位数且输入正整数")
                                        } else {
                                            $(".proportion_tip").text("")
                                        }
                                    }
                                }

                            </script>
                            <em>平米</em>
                            <i class="proportion_tip" style="color:red;font-size: 12px;"></i>
                            <em>宜住人数</em>
                            <input type="number" max="100" min="1" value="<?php echo $house_data['minguest']; ?>"
                                   name="min_num" onblur="minnum()">
                            <script>
                                function minnum() {
                                    var str = $('input[name="min_num"]').val();
                                    if ($('input[name="min_num"]').val() != "") {
                                        var reg = /^[0-9]+$/;
                                        var len = $('input[name="min_num"]').val().length;
                                        if (len >= 4 || !reg.test(str)) {
                                            $(".yizhu_tip").text("不超过3位数且输入正整数")
                                        } else {
                                            $(".yizhu_tip").text("")
                                        }
                                    }
                                }
                            </script>
                            <i class="yizhu_tip" style="color:red;font-size: 12px;"></i>
                            <em>最多入住人数</em>
                            <input type="number" name="max_num" value="<?php echo $house_data['maxguest']; ?>"
                                   style="text-align: left!important;" onblur="max_num()">
                            <script>
                                function max_num() {
                                    var str = $("input[name='max_num']").val();
                                    var reg = /^[0-9]+$/;
                                    if ($("input[name='max_num']").val() == "") {
                                        $(".max_num").text("请输入内容")
                                    } else {
                                        if (!reg.test(str)) {
                                            $(".max_num").text("请输入大于0的正整数")
                                        } else {
                                            $(".max_num").text("")
                                        }
                                    }
                                }
                            </script>
                            <i class="max_num" style="color:red;font-size: 12px;"></i>
                            <i class="num_limit" style="color:red;font-size: 12px;"></i>
                        </label>
                    </td>
                </tr>
                <tr class="acreage acreage2">
                    <td style="text-align: right!important;width:140px;">户型</td>
                    <td>
                        <label>
                            <input type="number" value="<?php echo $house_data['roomnum']; ?>" name="shi"
                                   onblur="shi()">
                            <script>
                                function shi() {
                                    var str = $('input[name="shi"]').val()
                                    if ($('input[name="shi"]').val() != "") {
                                        var len = $('input[name="shi"]').val().length;
                                        var reg = /^[0-9]+$/;
                                        if (len >= 3 || !reg.test(str)) {
                                            $(".huxing_tip").text("不超过2位数且输入正整数")
                                        } else {
                                            $(".huxing_tip").text("")
                                        }
                                    }
                                }
                            </script>
                            <em>室</em>
                            <input type="number" placeholder="1" name="ting" class="limit_add"
                                   value="<?php echo $house_data['officenum']; ?>" onblur="limit()">
                            <em>厅</em>
                            <input type="number" placeholder="0" name="chu"
                                   value="<?php echo $house_data['kitchenum']; ?>" onblur="limit()">
                            <em>厨</em>
                            <input type="number" placeholder="0" name="wei"
                                   value="<?php echo $house_data['bathnum']; ?>" onblur="limit()">
                            <em>卫</em>
                            <input type="number" placeholder="0" name="yang"
                                   value="<?php echo $house_data['balconynum']; ?>" onblur="limit()">
                            <em>阳台</em>
                            <script>
                                function limit() {
                                    var str = $(".limit_add").val();

                                    var len = $(".limit_add").val().length;
                                    var reg = /^[0-9]+$/;
                                    if (len >= 3 || !reg.test(str)) {
                                        $(".limit_tip").text("不超过2位数且输入正整数")
                                    } else {
                                        $(".limit_tip").text("")
                                    }
                                }
                            </script>
                        </label>
                        <i class="huxing_tip" style="color:red;font-size: 12px;"></i>
                    </td>
                </tr>
                <tr class="acreage acreage2">
                    <td style="text-align: right!important;width:140px;">床铺信息</td>
                    <td>
                        <div class="add_append">
                            <?php if ($house_bed) { ?>
                                <?php foreach ($house_bed as $k => $v): ?>
                                    <label class="str_label">
                                        <select name="house_bed[]" class="house_bed">
                                            <option <?php if ($v['bed_type'] == 1) {
                                                echo 'selected';
                                            } ?> value="1">双人床
                                            </option>
                                            <option <?php if ($v['bed_type'] == 2) {
                                                echo 'selected';
                                            } ?> value="2">单人床
                                            </option>
                                            <option <?php if ($v['bed_type'] == 3) {
                                                echo 'selected';
                                            } ?> value="3">大床
                                            </option>
                                            <option <?php if ($v['bed_type'] == 4) {
                                                echo 'selected';
                                            } ?> value="4">圆床
                                            </option>
                                            <option <?php if ($v['bed_type'] == 5) {
                                                echo 'selected';
                                            } ?> value="5">榻榻米
                                            </option>
                                            <option <?php if ($v['bed_type'] == 6) {
                                                echo 'selected';
                                            } ?> value="6">沙发床
                                            </option>
                                            <option <?php if ($v['bed_type'] == 7) {
                                                echo 'selected';
                                            } ?> value="7">双层床
                                            </option>
                                            <option <?php if ($v['bed_type'] == 8) {
                                                echo 'selected';
                                            } ?> value="8">床垫
                                            </option>
                                            <option <?php if ($v['bed_type'] == 9) {
                                                echo 'selected';
                                            } ?> value="9">其它
                                            </option>
                                        </select>
                                        <em style="margin-right:0px;margin-left:10px;">长</em>
                                        <input type="number" name="bed_long[]" value="<?php echo $v['bed_long']; ?>"
                                               onblur="bed_long()" style="margin-left:0;margin-right:0;">
                                        <i class="bed_long" style="color:red;font-size: 12px;"></i>
                                        <em style="margin-right:0px;margin-left:0px;">米*宽</em>
                                        <input type="number" name="bed_wide[]" value="<?php echo $v['bed_wide']; ?>"
                                               style="margin-right:0;">
                                        <em>米</em>
                                        <input type="number" name="bed_count[]" value="<?php echo $v['bed_count']; ?>"
                                               onblur="bed_count()" style="margin-right:0;">
                                        <em>张</em>
                                        <?php if ($k == 0) { ?>
                                            <img src="<?= Yii::$app->request->baseUrl ?>/images/add.png" alt=""
                                                 onclick="add()">
                                        <?php } else { ?>
                                            <img src="<?= Yii::$app->request->baseUrl ?>/images/shanchu.png" alt=""
                                                 class="shanchu">
                                        <?php } ?>
                                    </label>
                                <?php endforeach; ?>
                            <?php } else { ?>
                                <label class="str_label">
                                    <select name="house_bed[]" class="house_bed">
                                        <option value="1">双人床</option>
                                        <option value="2">单人床</option>
                                        <option value="3">大床</option>
                                        <option value="4">圆床</option>
                                        <option value="5">榻榻米</option>
                                        <option value="6">沙发床</option>
                                        <option value="7">双层床</option>
                                        <option value="8">床垫</option>
                                        <option value="9">其它</option>
                                    </select>
                                    <em style="margin-right:0px;margin-left:10px;">长</em>
                                    <input type="text" name="bed_long[]" placeholder="" onblur="bed_long()"
                                           style="margin-left:0;margin-right:0;">
                                    <script>
                                        function bed_long() {
                                            var str = $("input[name='bed_long[]']").val();
                                            var len = $("input[name='bed_long[]']").val().length;
                                            var reg = /^\d+(\.\d{1})?$/

                                            if ($("input[name='bed_long[]']").val() != "") {
                                                if (!reg.test(str)) {
                                                    $(".bed_long").text("请输入大于0的数字或者1位小数")
                                                } else {
                                                    $(".bed_long").text("")
                                                }
                                            }
                                        }
                                    </script>
                                    <i class="bed_long" style="color:red;font-size: 12px;"></i>
                                    <em style="margin-right:0px;margin-left:0px;">米*宽</em>
                                    <input type="text" name="bed_wide[]" placeholder="" style="margin-right:0;"
                                           onblur="wide()">
                                    <script>
                                        function wide() {
                                            var str = $("input[name='bed_wide[]']").val();
                                            var len = $("input[name='bed_wide[]']").val().length;
                                            var reg = /^\d+(\.\d{1})?$/

                                            if ($("input[name='bed_wide[]']").val() != "") {
                                                if (!reg.test(str)) {
                                                    $(".bed_wide").text("请输入大于0的数字或者1位小数")
                                                } else {
                                                    $(".bed_wide").text("")
                                                }
                                            }
                                        }
                                    </script>
                                    <i class="bed_wide" style="color:red;font-size: 12px;"></i>
                                    <em>米</em>
                                    <input type="number" name="bed_count[]" placeholder="" onblur="bed_count()"
                                           style="margin-right:0;">
                                    <script>
                                        function bed_count() {
                                            var str = $("input[name='bed_count[]']").val()
                                            var reg = /^[0-9]+$/;
                                            if ($("input[name='bed_count[]']").val() != "") {
                                                $(".bed_tip").text("")
                                                var len = $("input[name='bed_count[]']").val().length;
                                                if (len >= 4 || !reg.test(str)) {
                                                    $(".bed-limit_tip").text("不超过3位数字")
                                                } else {
                                                    $(".bed-limit_tip").text("")
                                                }
                                            }
                                        }
                                    </script>
                                    <em>张</em>
                                    <img src="<?= Yii::$app->request->baseUrl ?>/images/add.png" alt="" onclick="add()">
                                </label>
                            <?php } ?>
                        </div>
                        <i class="bed_tip" style="color:red;font-size: 12px;"></i>
                        <i class="bed-limit_tip" style="color:red;font-size: 12px;"></i>
                        <i class="limit_bed_tip" style="color:red;font-size: 12px;"></i>
                    </td>
                </tr>
                <tr class="acreage acreage2">
                    <td style="text-align: right!important;width:140px;">同类房源</td>
                    <td>
                        <input type="number" name="kucun" value="<?php echo $house_data['total_stock']; ?>"
                               onblur="leave_kucun()"
                               style="width:80px;text-align: center;">
                        <span style="color:#ccc">*含此房源（朝向、户型、房间面积相同；家具家电、装修同档的房间）</span>
                        <i class="kucun_limit" style="color:red;font-size: 12px;"></i>
                        <script>
                            function leave_kucun() {
                                var len = $("input[name='kucun']").val().length;
                                var str = $("input[name='kucun']").val();
                                var reg = /^[0-9]+$/;
                                if (len >= 3 || !reg.test(str)) {
                                    $(".kucun_limit").text("不超过3位数且输入正整数")
                                } else {
                                    $(".kucun_limit").text("")
                                }
                            }
                        </script>
                    </td>
                </tr>
                <tr class="acreage acreage2">
                    <td style="text-align: right!important;width:140px;">房屋地址</td>
                    <td>
                        <div style="margin-bottom: 10px;">
                            <select style="height:30px;margin-right:10px;" id="bank_country" onchange="testprov(this)">

                                <?php echo \backend\service\CommonService::updatecountry($house_data['national']); ?>
                            </select>
                            <select style="height:30px;margin-right:10px;" id="bank_prov" onchange="testcity(this)">
                                <?php echo \backend\service\CommonService::updateprovince($house_data['province'], $house_data['national']); ?>
                            </select>

                            <select style="height:30px;;margin-right:10px;" id="bank_city" onchange="testarea(this)">
                                <?php echo \backend\service\CommonService::updatecity($house_data['city'], $house_data['province']); ?>
                            </select>

                            <select style="height:30px;;margin-right:10px;" id="bank_area">
                                <?php echo \backend\service\CommonService::updatearea($house_data['area'], $house_data['city']); ?>
                            </select>
                        </div>
                        <div class="pac">
                            <input id="pac-input" class="controls" type="text"
                                   value="<?php if ($house_data['old_hid'] > 0 && !$house_data['biotope']) {
                                       echo $house_data['address'];
                                   } else {
                                       echo $house_data['biotope'];
                                   } ?>"
                                   placeholder="请输入详情地址" style="height:30px;width:66.7%;margin-right:10px;"
                                   onblur="pacinput()">
                            <script>
                                function pacinput() {
                                    if ($("#pac-input").val() != "") {
                                        $(".address_tip").text("")
                                    }
                                }
                            </script>
                            <input type="text" name="doornum" value="<?php echo $house_data['doornum']; ?>"
                                   placeholder="门牌号(对房客保密)" style="height:30px;">
                            <i class="address_tip" style="color:red;font-size: 12px;"></i>
                        </div>
                        <div class="pac1" style="display: none">
                            <input id="pac-input1" class="controls" type="text"
                                   value="<?php if ($house_data['national'] != 10001) {
                                       if ($house_data['old_hid'] > 0) {
                                           echo $house_data['address'];
                                       } else {
                                           echo $house_data['biotope'];
                                       }
                                   } ?>"
                                   placeholder="请输入详情地址" style="height:30px;width:66.7%;margin-right:10px;">
                            <input type="text" name="doornum1" value="<?php if ($house_data['national'] != 10001) {
                                echo $house_data['doornum'];
                            } ?>" placeholder="门牌号(对房客保密)" style="height:30px;">
                            <i class="address_tip1" style="color:red;font-size: 12px;"></i>
                        </div>
                        <input type="hidden" name="lng" id="lng" style="width: 100px;"
                               value="<?php echo $house_data['longitude']; ?>"/>
                        <input type="hidden" name="lat" id="lat" style="width: 100px;"
                               value="<?php echo $house_data['latitude']; ?>"/>
                        <input type="hidden" id="address" style="width: 100px;"
                               value="<?php echo $house_data['vague_addr']; ?>"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row" style="width:90%;margin:0 auto 10px;padding:0px;box-sizing:border-box;">
            <div style="margin-top:10px">
                <div id="map" style="width:100%;height:480px;margin:0 auto;"></div>
            </div>
            <div style="margin-top:10px">
                <div id="map1" style="width:100%;height:480px;margin:0 auto;display: none"></div>
            </div>

            <!--高德地图-->
            <script>
                $(function () {
                    var listen;
                    var gdclick;
                    $('#pac-input').focus(function () {
                        var country_code = $('#bank_country option:selected').val();
                        var prov_code = $('#bank_prov option:selected').val();
                        var city_code = $('#bank_city option:selected').val();
                        var area_code = $('#bank_area option:selected').val();
//                        console.log(country_code);
//                        console.log(prov_code);
                        if (parseInt(country_code) == 10001 && parseInt(prov_code) > 0 && parseInt(city_code) > 0 && parseInt(area_code) > 0) {
                            var auto = new AMap.Autocomplete({
                                input: "pac-input"
                            });
                            listen = AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
                        }
                    })

//                    $('#pac-input1').blur(function(){
//                        var country_code = $('#bank_country option:selected').val();
//                        var prov_code = $('#bank_prov option:selected').val();
//                        var city_code = $('#bank_city option:selected').val();
//                        var area_code = $('#bank_area option:selected').val();
//
//                    })

                    $('#bank_prov').change(function () {
                        document.getElementById("lng").value = ''
                        document.getElementById("lat").value = '';
                        document.getElementById("address").value = '';
                        $('.pac1').show();
                        $('.pac').hide();
                        var name = $('#bank_prov option:selected').html();
                        var country_name = $('#bank_country option:selected').html();
                        var country_code = $('#bank_country option:selected').val();
                        if (country_code != 10001 && country_code != 0) {
                            $('#map').hide();
                            geocodeAddress1(geocoder_google, country_name + name, 2);
                            $('#map1').show();
                        } else {
//                            initGDmap();
                            $('#map1').hide();
                            map.setCity(name);
                            $('#map').show();
                        }
                    })
                    $('#bank_city').change(function () {
                        document.getElementById("lng").value = ''
                        document.getElementById("lat").value = '';
                        document.getElementById("address").value = '';
                        $('.pac1').show();
                        $('.pac').hide();
                        var name = $('#bank_city option:selected').val();
                        var country_code = $('#bank_country option:selected').val();
                        if (country_code != 10001) {
                            $('#map').hide();
//                            geocodeAddress1(geocoder_google,country_name+city_name+name,3);
                            $('#map1').show();
                            return;
                        } else {
                            restMap();
                            $('#map1').hide();
                            map.setCity(name);
                            $('#map').show();
                        }
                        map.setCity(name);
                    })
                    $('#bank_area').change(function () {
                        document.getElementById("lng").value = ''
                        document.getElementById("lat").value = '';
                        document.getElementById("address").value = '';
                        var name = $('#bank_area option:selected').html();
                        var country_name = $('#bank_country option:selected').html();
                        var city_name = $('#bank_city option:selected').html();
                        var country_code = $('#bank_country option:selected').val();
                        if (country_code != 10001) {
                            $('#map').hide();
                            geocodeAddress1(geocoder_google, country_name + city_name + name, 3);
                            $('#map1').show();
                            return;
                        } else {
                            $('#pac-input').val('');
                            $('#doornum').val('');
                            $('.pac1').hide();
                            $('.pac').show();
//                            initGDmap();
                            AMap.event.addListener(map, "click", _onClick); //绑定事件，返回监听对象
                            $('#map1').hide();
                            map.setCity(city_name + name);
                            $('#map').show();
                        }
                        map.setCity(name);
                    })

                    $(document).on('click', '.amap-labels', function () {
                        var area_code = $('#bank_area option:selected').val();
                        if (area_code == 0) {
                            layer.open({
                                content: '请先选择房源所在的国家-省-市-区',
                            });
                        }
                    })

                    $('#bank_country').change(function () {
                        document.getElementById("lng").value = ''
                        document.getElementById("lat").value = '';
                        document.getElementById("address").value = '';
                        var country_code = $('#bank_country option:selected').val();
                        var name = $('#bank_country option:selected').html();
                        if (country_code == 0) {
                            $('#map').show();
                            $('#map1').hide();
                            initGDmap();
                        }
                        if (country_code != 10001 && country_code != 0) {
                            $('.pac1').show();
                            $('.pac').hide();
                            $('#map').hide();
                            geocodeAddress1(geocoder_google, name, 1);
//                            initMap();
                            $('#map1').show();
                        } else {
                            initGDmap(1);
                            $('#map1').hide();
                            map.setCity(name);
                            $('#map').show();
                        }
                    })
                })
                function restMap() {
                    lat =<?php echo $house_data['latitude'] ?>;
                    lng =<?php echo $house_data['longitude'] ?>;
                    map = new AMap.Map("map", {
                        resizeEnable: true,
                        zoom: 15,//地图显示的缩放级别
                        center: [lng, lat]
                    });
                    AMap.event.removeListener(gdclick);
                }
                function initGDmap() {
                    lat =<?php echo $house_data['latitude'] ?>;
                    lng =<?php echo $house_data['longitude'] ?>;
                    map = new AMap.Map("map", {
                        resizeEnable: true,
                        zoom: 15,//地图显示的缩放级别
                        center: [lng, lat]
                    });


                    marker = new AMap.Marker({
                        map: map,
                        position: [lng, lat],
                    });


                    lnglatXY = [lng, lat];
                    var geocoder = new AMap.Geocoder({
                        radius: 2000,
                        extensions: "all"
                    });
                    geocoder.getAddress(lnglatXY, function (status, result) {
                        if (status === 'complete' && result.info === 'OK') {
//                                console.log(result.regeocode.formattedAddress);
                            var infoWindow = new AMap.InfoWindow({
                                autoMove: true,
                                offset: {x: 0, y: -30}
                            });
                            infoWindow.setContent(result.regeocode.formattedAddress);
                            infoWindow.open(map, lnglatXY);
                        }
                    });
                    _onClick = function (e) {
                        map.clearMap();
                        new AMap.Marker({
                            position: e.lnglat,
                            map: map
                        })
                        document.getElementById("lng").value = e.lnglat.getLng();
                        document.getElementById("lat").value = e.lnglat.getLat();
                        lnglatXY = [e.lnglat.getLng(), e.lnglat.getLat()];
                        var geocoder = new AMap.Geocoder({
                            radius: 1000,
                            extensions: "all"
                        });
                        geocoder.getAddress(lnglatXY, function (status, result) {
                            if (status === 'complete' && result.info === 'OK') {
//                                console.log(result.regeocode.formattedAddress);
                                var infoWindow = new AMap.InfoWindow({
                                    autoMove: true,
                                    offset: {x: 0, y: -30}
                                });
                                document.getElementById("address").value = result.regeocode.formattedAddress;
                                infoWindow.setContent(result.regeocode.formattedAddress);
                                infoWindow.open(map, lnglatXY);
                            }
                        });
                    }
                    gdclick = AMap.event.addListener(map, "click", _onClick); //绑定事件，返

                }

                function select(e) {
                    if (e.poi && e.poi.location) {
                        map.setZoom(17);
                        map.setCenter(e.poi.location);
                        var marker = new AMap.Marker({});
                        marker.setPosition(e.poi.location);
                        marker.setMap(map);
                        var geocoder = new AMap.Geocoder({
                            radius: 1000,
                            extensions: "all"
                        });
                        geocoder.getAddress(e.poi.location, function (status, result) {
                            if (status === 'complete' && result.info === 'OK') {
                                var infoWindow = new AMap.InfoWindow({
                                    autoMove: true,
                                    offset: {x: 0, y: -30}
                                });
                                document.getElementById("lng").value = e.poi.location.lng;
                                document.getElementById("lat").value = e.poi.location.lat;
                                document.getElementById("address").value = result.regeocode.formattedAddress;
                                infoWindow.setContent(result.regeocode.formattedAddress);
                                infoWindow.open(map, e.poi.location);
                            }
                        });
                    }
                }

                //回调函数
                function placeSearch_CallBack(lnglatXY) {
                    var infoWindow = new AMap.InfoWindow({
                        autoMove: true,
                        offset: {x: 0, y: -30}
                    });
//					  var poiArr = data.poiList.pois;
                    //添加marker
//					  var marker = new AMap.Marker({
//						  map: map,
//						  position: lnglatXY
//					  });
//					  map.setCenter(marker.getPosition());
                    infoWindow.setContent('测试123');
                    infoWindow.open(map, lnglatXY);
                }
                function createContent(poi) {  //信息窗体内容
                    var s = [];
                    s.push("<b>名称：" + poi.name + "</b>");
                    s.push("地址：" + poi.address);
                    s.push("电话：" + poi.tel);
                    s.push("类型：" + poi.type);
                    return s.join("<br>");
                }

                function regeocoder(lnglatXY) {  //逆地理编码
                    var geocoder = new AMap.Geocoder({
                        radius: 1000,
                        extensions: "all"
                    });
                    geocoder.getAddress(lnglatXY, function (status, result) {
                        if (status === 'complete' && result.info === 'OK') {
                            geocoder_CallBack(result);
                        }
                    });
                    var marker = new AMap.Marker({  //加点
                        map: map,
                        position: lnglatXY
                    });
//					  map.setFitView();
                }
                function regeocoder1(lnglatXY) {  //逆地理编码
                    var geocoder = new AMap.Geocoder({
                        radius: 1000,
                        extensions: "all"
                    });
                    geocoder.getAddress(lnglatXY, function (status, result) {
                        if (status === 'complete' && result.info === 'OK') {
                            adds = result.regeocode.formattedAddress;
                        } else {
                            adds = '暂无';
                        }
                    });
                    return adds;
                }
                function geocoder_CallBack(data) {
                    var address = data.regeocode.formattedAddress; //返回地址描述
                    document.getElementById("address").value = address;
                    return address;
                }
                window.onload = function () {
                    var old_country = $('.old_country').val();
                    if (old_country == 10001) {
                        initGDmap();
                    } else {
                        $('.pac1').show();
                        $('.pac').hide();
                        $('#map').hide();
//                            initMap();
                        $('#map1').show();
                        initMap();
                        initMap();
                    }
                    geocoder_google = new google.maps.Geocoder();
//                    initMap();
                }
            </script>
            <!--高德地图-->


            <!--			谷歌地图-->
            <script>
                var marker_google;
                var infowindow;
                var geocoder;
                var markersArray = [];


                function geocodeAddress(geocoder_google, resultsMap, address) {
                    geocoder_google.geocode({'address': address}, function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            resultsMap.setCenter(results[0].geometry.location);
                            var marker = new google.maps.Marker({
                                map: resultsMap,
                                position: results[0].geometry.location
                            });
                        } else {
                            alert('Geocode was not successful for the following reason: ' + status);
                        }
                    });
                }

                function geocodeAddress1(geocoder_google, address, type) {
                    switch (type) {
                        case 1:
                            var google_zoom = 7;
                            break;
                        case 2:
                            var google_zoom = 13;
                            break;
                        case 3:
                            var google_zoom = 15;
                            break;
                    }
                    geocoder_google.geocode({'address': address}, function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            map_google = new google.maps.Map(document.getElementById('map1'), {
                                center: results[0].geometry.location,
                                zoom: google_zoom
                            });
                            google.maps.event.addListener(map_google, 'click', function (event) {
                                placeMarker(event.latLng);
                            });
                        } else {
                            alert('没查找到相关数据' + status);
                        }
                    });
                }

                function initMap() {
                    lat =<?php echo $house_data['latitude'] ?>;
                    lng =<?php echo $house_data['longitude'] ?>;
                    map_google = new google.maps.Map(document.getElementById('map1'), {
                        zoom: 13,
                        center: {lat: lat, lng: lng}
                    });
                    geocoder_google = new google.maps.Geocoder();
                    //监听点击地图事件
                    google.maps.event.addListener(map_google, 'click', function (event) {
                        placeMarker(event.latLng);
                    });
                    var latlng = new google.maps.LatLng(lat, lng);
                    placeMarker(latlng);
                    var infowindow = new google.maps.InfoWindow();
                    var marker_google = new google.maps.Marker({
                        map: map_google,
                        anchorPoint: new google.maps.Point(0, -29)
                    });

                }

                function placeMarker(location) {
                    clearOverlays(infowindow);//清除地图中的标记
                    marker_google = new google.maps.Marker({
                        position: location,
                        map: map_google
                    });
                    markersArray.push(marker_google);
//                    marker_google.setMap(map_google);
                    //根据经纬度获取地址
                    if (geocoder_google) {
                        geocoder_google.geocode({'location': location}, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (results[0]) {
                                    attachSecretMessage(marker_google, results[0].geometry.location, results[0].formatted_address);
                                }
                            } else {
                                alert("Geocoder failed due to: " + status);
                            }
                        });
                    }
                }

                //在地图上显示经纬度地址
                function attachSecretMessage(marker_google, piont, address) {
                    var message = "<b>地址:</b>" + address;
                    var infowindow = new google.maps.InfoWindow(
                        {
                            content: message,
                            size: new google.maps.Size(50, 50)
                        });
                    infowindow.open(map_google, marker_google);
                    if (typeof (mapClick) == "function") mapClick(piont.lng(), piont.lat(), address);
                }

                //删除所有标记阵列中消除对它们的引用
                function clearOverlays(infowindow) {
                    if (markersArray && markersArray.length > 0) {
                        for (var i = 0; i < markersArray.length; i++) {
                            markersArray[i].setMap(null);
                        }
                        markersArray.length = 0;
                    }
                    if (infowindow) {
                        infowindow.close();
                    }
                }


                function setiInit() {
                    // 页面加载显示默认lng lat address---begin
                    var lattxt = document.getElementById("lat").value;
                    var lngtxt = document.getElementById("lng").value;
                    // var addresstxt = document.getElementById("address").value;
                    if (lattxt != '' && lngtxt != '') {
                        var latlng = new google.maps.LatLng(lattxt, lngtxt);
                        marker = new google.maps.Marker({
                            position: latlng,
                            map: map_google
                        });
                        markersArray.push(marker);
                        attachSecretMessage(marker, latlng);
                    }
                    // ---end
                }
                function mapClick(lng, lat, address) {
                    document.getElementById("lng").value = lng;
                    document.getElementById("lat").value = lat;
                    document.getElementById("address").value = address;
                }

            </script>
            <!--			谷歌地图-->

        </div>
        <div class="row" style="padding-top: 0;">
            <input type="hidden" class="house_id" value="<?php echo $house_data['id']; ?>">
            <input type="hidden" class="old_country" value="<?php echo $house_data['national']; ?>">
            <input type="hidden" class="host" value="<?php echo $host; ?>">
            <button type="button" class="btn btn-primary add-one">保存并继续</button>
            <button type="button" class="btn btn-primary commit-update">提交修改</button>
        </div>
    </div>
</section>
<script>
    function conservation() {
        var country_code = $('#bank_country option:selected').val();
        console.log(country_code);
        var status = 1;
        if ($(".inp_check_fy input[type='checkbox").is(':checked')) {
            $(".tips").text("")
        } else {
            var status = 0;
            $(".tips").text("请选择")
        }

        var title_inp = $(".title_inp").val();
        if (title_inp == "") {
            var status = 0;
            $(".title_inp").siblings("i").text("请填写信息")
        } else {
            var length = title_inp.length;
            if (country_code == 10001) {
                if (length > 22) {
                    var status = 0;
                    $(".title_inp").siblings("i").text("标题最多22个字符")
                } else {
                    $(".title_inp").siblings("i").text("")
                }
            } else {
                if (length > 50) {
                    var status = 0;
                    $(".title_inp").siblings("i").text("标题最多50个字符")
                } else {
                    $(".title_inp").siblings("i").text("")
                }
            }
        }

        if ($(".inp_check_rent input[type='checkbox").is(':checked')) {
            $(".tip").text("")
        } else {
            var status = 0;
            $(".tip").text("请选择")
        }

        var proportion = $('input[name="proportion"]').val();
        if (proportion == "") {
            var status = 0;
            $(".proportion_tip").text("请填写信息")
        } else {
            $(".proportion_tip").text("")
        }

        var min_num = $('input[name="min_num"]').val();
        //宜住人数
        if (min_num == "") {
            var status = 0;
            $(".yizhu_tip").text("请填写信息")
        } else {
            $(".yizhu_tip").text("")
        }

        var shi = $('input[name="shi"]').val();
        if (shi == "") {
            var status = 0;
            $(".huxing_tip").text("请填写信息")
        } else {
            $(".huxing_tip").text("")
        }

//        最多入住人数
        max_num1 = $('input[name="max_num"]').val();
        if (max_num1 == "") {
            var status = 0;
            $(".max_num").text("请填写信息")
        } else {
            $(".max_num").text("")
        }
        min_num1 = $('input[name="min_num"]').val();
        if (parseInt(min_num1) > parseInt(max_num1)) {
            var status = 0;
            $(".num_limit").text("最多入住人数不能小于宜住人数1")
        } else {
            $(".num_limit").text("")
        }
        if (country_code == 10001) {
            if ($("#pac-input").val() == "") {
                var status = 0;
                $(".address_tip").text("请填写信息")
            } else {
                $(".address_tip").text("")
            }
        } else {
            if ($("#pac-input1").val() == "") {
                var status = 0;
                $(".address_tip1").text("请填写信息")
            } else {
                $(".address_tip1").text("")
            }
        }

        var house_bed = $('input[name="house_bed[]"]').val();
        var bed_long = $('input[name="bed_long[]"]').val();
        var bed_wide = $('input[name="wide[]"]').val();
        var bed_count = $('input[name="bed_count[]"]').val();
        if (house_bed == "" || bed_long == "" || bed_count == "" || bed_wide == "") {
            var status = 0;
            $(".bed_tip").text("请填写信息")
        } else {
            $(".bed_tip").text("")
        }

        if ($("input[name='yz-num']").val() == "") {
            var status = 0;
            $(".yz-num").text("请输入正确手机号")
        } else {
            $(".yz-num").text("")
        }

        var lat = $('#lat').val();
        var lng = $('#lng').val();
        if (!lat || !lng) {
            var status = 0;
            layer.open({
                content: '请在地图上标记房源位置',
            });
        }
        return status;
    }

    $(function () {
        $('.add-one').click(function () {
            var validate_status = conservation();
            if (validate_status == 0) {
                return false;
            }
            var house_id = $('.house_id').val();
            var mobile = $('input[name="yz-num"]').val();
            var title = $('.title_inp').val();
            var mode = $('input[name="nm"]:checked').val();
            var type = $('input[name="gname"]:checked').val();
            var proportion = $('input[name="proportion"]').val();
            var min_num = $('input[name="min_num"]').val();
            var max_num = $('input[name="max_num"]').val();
            var shi = $('input[name="shi"]').val();
            var ting = $('input[name="ting"]').val();
            var chu = $('input[name="chu"]').val();
            var wei = $('input[name="wei"]').val();
            var yang = $('input[name="yang"]').val();
            var bed_long = $('input[name="bed_long[]"]').val();
            var bed_wide = $('input[name="wide[]"]').val();
            var bed_count = $('input[name="bed_count[]"]').val();
            var bed_long_arr = new Array;
            var bed_wide_arr = new Array;
            var bed_count_arr = new Array;
            var bed_type_arr = new Array;
            $("input[name='bed_long[]']").each(function (i) {
                bed_long_arr[i] = $(this).val();
            });
            $("input[name='bed_wide[]']").each(function (i) {
                bed_wide_arr[i] = $(this).val();
            });
            $("input[name='bed_count[]']").each(function (i) {
                bed_count_arr[i] = $(this).val();
            });
            $('.house_bed option:selected').each(function (i) {
                bed_type_arr[i] = $(this).val();
            });
            var bed_long_str = bed_long_arr.join(',');
            var bed_wide_str = bed_wide_arr.join(',');
            var bed_count_str = bed_count_arr.join(',');
            var bed_type_str = bed_type_arr.join(',');
            var kucun = $('input[name="kucun"]').val();
            var time_zone = $('#bank_country option:selected').attr('time_zone');
            var country_code = $('#bank_country option:selected').val();
            var prov_code = $('#bank_prov option:selected').val();
            var city_code = $('#bank_city option:selected').val();
            var area_code = $('#bank_area option:selected').val();
            var country_name=$('#bank_country option:selected').html();
            var prov_name=$('#bank_prov option:selected').html();
            var city_name=$('#bank_city option:selected').html();
            var area_name=$('#bank_area option:selected').html();
            var vague_address = $('#address').val();
            var lat = $('#lat').val();
            var lng = $('#lng').val();
            if (country_code == 10001) {
                var true_address = $('#pac-input').val();
                var doornum = $('input[name="doornum"]').val();
                if(doornum){
                    var full_address=country_name+prov_name+city_name+area_name+true_address+doornum;
                }else{
                    var full_address=country_name+prov_name+city_name+area_name+true_address;
                }
            } else {
                var true_address = $('#pac-input1').val();
                var doornum = $('input[name="doornum1"]').val();
                if(doornum){
                    var full_address=country_name+city_name+true_address+doornum;
                }else{
                    var full_address=country_name+city_name+true_address;
                }
            }
            if (!lat || !lng) {
                layer.open({
                    content: '请在地图上标记房源位置',
                });
            }

            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['update-one']) ?>",
                data: {
                    title: title,
                    roommode: mode,
                    roomtype: type,
                    roomsize: proportion,
                    maxguest: max_num,
                    minguest: min_num,
                    roomnum: shi,
                    officenum: ting,
                    kitchenum: chu,
                    bathnum: wei,
                    balconynum: yang,
                    bed_long: bed_long_str,
                    bed_wide: bed_wide_str,
                    bed_count: bed_count_str,
                    total_stock: kucun,
                    time_zone: time_zone,
                    national: country_code,
                    province: prov_code,
                    city: city_code,
                    area: area_code,
                    vague_addr: vague_address,
                    address: true_address,
                    latitude: lat,
                    longitude: lng,
                    doornum: doornum,
                    bed_type: bed_type_str,
                    mobile: mobile,
                    full_address:full_address,
                    house_id: house_id
                },
                success: function (data) {
                    if (data > 0) {
                        var host = $('.host').val();
                        location.href = "http://" + host + "/house/add-two?house_id=" + data;
                    }
                    if (data == 0) {
                        layer.open({
                            content: '所填信息有误',
                        });
                    }
                    if (data == -1) {
                        layer.open({
                            content: '房型有误',
                        });
                    }
                    if (data == -2) {
                        layer.open({
                            content: '床型信息不对',
                        });
                    }
                    if (data == -3) {
                        layer.open({
                            content: '上传失败',
                        });
                    }
                    if (data == -4) {
                        layer.open({
                            content: '手机号信息有误',
                        });
                    }
                    if (data == -5) {
                        layer.open({
                            content: '请选择区域信息',
                        });
                    }
                }
            })
        })

    })
    $(function () {
        $('.commit-update').click(function () {
            var validate_status = conservation();
            if (validate_status == 0) {
                return false;
            }
            var house_id = $('.house_id').val();
            var mobile = $('input[name="yz-num"]').val();
            var title = $('.title_inp').val();
            var mode = $('input[name="nm"]:checked').val();
            var type = $('input[name="gname"]:checked').val();
            var proportion = $('input[name="proportion"]').val();
            var min_num = $('input[name="min_num"]').val();
            var max_num = $('input[name="max_num"]').val();
            var shi = $('input[name="shi"]').val();
            var ting = $('input[name="ting"]').val();
            var chu = $('input[name="chu"]').val();
            var wei = $('input[name="wei"]').val();
            var yang = $('input[name="yang"]').val();
            var bed_long = $('input[name="bed_long[]"]').val();
            var bed_wide = $('input[name="wide[]"]').val();
            var bed_count = $('input[name="bed_count[]"]').val();
            var bed_long_arr = new Array;
            var bed_wide_arr = new Array;
            var bed_count_arr = new Array;
            var bed_type_arr = new Array;
            $("input[name='bed_long[]']").each(function (i) {
                bed_long_arr[i] = $(this).val();
            });
            $("input[name='bed_wide[]']").each(function (i) {
                bed_wide_arr[i] = $(this).val();
            });
            $("input[name='bed_count[]']").each(function (i) {
                bed_count_arr[i] = $(this).val();
            });
            $('.house_bed option:selected').each(function (i) {
                bed_type_arr[i] = $(this).val();
            });
            var bed_long_str = bed_long_arr.join(',');
            var bed_wide_str = bed_wide_arr.join(',');
            var bed_count_str = bed_count_arr.join(',');
            var bed_type_str = bed_type_arr.join(',');
            var kucun = $('input[name="kucun"]').val();
            var sort = $('input[name="sort"]').val();
            var country_code = $('#bank_country option:selected').val();
            var prov_code = $('#bank_prov option:selected').val();
            var city_code = $('#bank_city option:selected').val();
            var area_code = $('#bank_area option:selected').val();
            var country_name=$('#bank_country option:selected').html();
            var prov_name=$('#bank_prov option:selected').html();
            var city_name=$('#bank_city option:selected').html();
            var area_name=$('#bank_area option:selected').html();
            var vague_address = $('#address').val();
            var lat = $('#lat').val();
            var lng = $('#lng').val();
            var top_start = $('input[name="top_start"]').val();
            var top_end = $('input[name="top_end"]').val();
            var to_top_status = $("input[name='to_top']").is(':checked');
            if (to_top_status == true) {
                var to_top = 1;
            } else {
                var to_top = 0;
            }
            if (country_code == 10001) {
                var true_address = $('#pac-input').val();
                var doornum = $('input[name="doornum"]').val();
                if(doornum){
                    var full_address=country_name+prov_name+city_name+area_name+true_address+doornum;
                }else{
                    var full_address=country_name+prov_name+city_name+area_name+true_address;
                }
            } else {
                var true_address = $('#pac-input1').val();
                var doornum = $('input[name="doornum1"]').val();
                if(doornum){
                    var full_address=country_name+city_name+true_address+doornum;
                }else{
                    var full_address=country_name+city_name+true_address;
                }
            }
            if (!lat || !lng) {
                layer.open({
                    content: '请在地图上标记房源位置',
                });
            }
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['update-one']) ?>",
                data: {
                    title: title,
                    roommode: mode,
                    roomtype: type,
                    roomsize: proportion,
                    maxguest: max_num,
                    minguest: min_num,
                    roomnum: shi,
                    officenum: ting,
                    kitchenum: chu,
                    bathnum: wei,
                    balconynum: yang,
                    bed_long: bed_long_str,
                    bed_wide: bed_wide_str,
                    bed_count: bed_count_str,
                    total_stock: kucun,
                    tango_weight: sort,
                    national: country_code,
                    province: prov_code,
                    city: city_code,
                    area: area_code,
                    vague_addr: vague_address,
                    address: true_address,
                    latitude: lat,
                    longitude: lng,
                    doornum: doornum,
                    bed_type: bed_type_str,
                    mobile: mobile,
                    to_top: to_top,
                    top_start: top_start,
                    top_end: top_end,
                    house_id: house_id,
                    full_address:full_address
                },
                success: function (data) {
                    if (data > 0) {
                        var host = $('.host').val();
                        location.href = "http://" + host + "/house-details/index";
                    }
                    if (data == 0) {
                        layer.open({
                            content: '所填信息有误',
                        });
                    }
                    if (data == -1) {
                        layer.open({
                            content: '房型有误',
                        });
                    }
                    if (data == -2) {
                        layer.open({
                            content: '床型信息不对',
                        });
                    }
                    if (data == -3) {
                        layer.open({
                            content: '上传失败',
                        });
                    }
                    if (data == -4) {
                        layer.open({
                            content: '手机号信息有误',
                        });
                    }
                    if (data == -5) {
                        layer.open({
                            content: '请选择区域信息',
                        });
                    }
                }
            })
        })

    })
</script>