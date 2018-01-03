<?php
$this->title = '入住须知';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/bootstrap/dist/css/skin-blue.min.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/bootstrap/dist/css/AdminLTE.min.css">
<!-- 页面css -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/cobber.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/dist/js/app.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<style>
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
    label{
        font-weight: normal!important;
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
</style>
<script>
    function leave() {
        var len = $(".title_inp").val().length;
        if (len > 22 || len < 5) {
            alert("请输入正确格式");
            $(".title_inp").val("")
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
            }
        }
    }
    function choosethree(cb) {
        var obj = document.getElementsByName("gnm");
        for (var i = 0; i < obj.length; i++) {
            if (obj[i] != cb) {
                obj[i].checked = false;
            } else {
                obj[i].checked = cb.checked;
            }
        }
    }
    function choosefour(cb) {
        var obj = document.getElementsByName("gn");
        for (var i = 0; i < obj.length; i++) {
            if (obj[i] != cb) {
                obj[i].checked = false;
            } else {
                obj[i].checked = cb.checked;
            }
        }
    }

    function leave_txt() {
        var len = $(".limit_len textarea").val().length;
        if (len > 200) {
            $(".limit_len i").text("字数控制在200字以内").css("display", "block").css("color",'red');
        } else {
            $(".limit_len i").text("")
        }
    }
    function leave_txt2() {
        var len2 = $(".limit_len2 textarea").val().length;
        if (len2 > 200) {
            $(".limit_len2 i").text("字数控制在200字以内").css("display", "block").css("color",'red');
        } else {
            $(".limit_len2 i").text("")
        }
    }
    function leave_txt3() {
        var len3 = $(".limit_len3 textarea").val().length;
        if (len3 > 200) {
            $(".limit_len3 i").text("字数控制在200字以内").css("display", "block").css("color",'red');
        } else {
            $(".limit_len3 i").text("")
        }
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


<section class="content" style="width:80%;margin:0 auto;">
    <div class="row">
        <span id="base_message">
            <a href="<?php echo \yii\helpers\Url::to(['update-one','house_id'=>$_GET['house_id']]) ?>" style="color:#666;">1、基本信息</a>
        </span>
        <span id="price_rule">
            <a href="<?php echo \yii\helpers\Url::to(['add-two','house_id'=>$_GET['house_id']]) ?>" style="color:#666;">2、价格规则</a>
        </span>
        <span id="ruzhu_note" style="border:none;background-color: #367fa9;color:#fff;">
            <a href="###" style="color:#fff;">3、入住须知</a>
        </span>
        <span id="house_dep">
            <a href="<?php echo \yii\helpers\Url::to(['add-four','house_id'=>$_GET['house_id']]) ?>" style="color:#666;">4、房屋描述</a>
        </span>
        <?php if($house_error){ ?>
            <b style="color:red;">审核不通过原因:<?php echo $house_error['reson']; ?></b>
        <?php } ?>

    </div>
    <div class="form-group" style="margin-top:30px;">
<!--        <div class="row">-->
<!--            <span style="background-color: #367fa9;color:#fff;padding: 5px 10px;">3、入住须知</span>-->
<!--        </div>-->
        <div class="table-responsive">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td style="text-align: right!important;width:140px">入住规则:</td>
                    <td>
                        <span>最少入住天数</span>
                        <input type="number" value="<?php echo $house_data['minday']?$house_data['minday']:1; ?>" class="minday" maxlength="5" style="width:80px;text-align: center;" onblur="minday()">
                        <i class="minday_tip" style="color:red;font-size: 12px;"></i>
                        <script>
                            function minday(){
                                var minday = $('.minday').val();//
                                var reg = /^(0|[1-9][0-9]*)$/;
                                if(!reg.test(minday)){
                                    $(".minday_tip").text("大于0的整数")
                                }else{
                                    $(".minday_tip").text("")
                                }

                            }
                        </script>

                        <span>最多入住天数</span>
                        <input type="number" class="maxday" value="<?php echo $house_data['maxday']?$house_data['maxday']:0; ?>" style="width:80px;text-align: center;" onblur="maxday()">
                        <i class="maxday_tip" style="color:red;font-size: 12px;"></i>
                        <script>
                            function maxday(){
                                var maxday = $('.maxday').val();
                                var reg = /^\+?[1-9]\d*$/;
                                if(!reg.test(maxday)){
                                    $(".maxday_tip").text("大于0的整数")
                                }else{
                                    $(".maxday_tip").text("")
                                }
                            }
                        </script>

                        <span style="color:#ccc;">*0默认不限制</span>
                        <span>提前预定天数</span>
                        <input type="number" class="beforeday" value="<?php echo $house_data['beforeday']?$house_data['beforeday']:0; ?>" style="width:80px;text-align: center;" onblur="beday()">
                        <i class="be_day" style="color:red;font-size: 12px;"></i>
                        <script>
                            function beday(){
                                var beday = $(".beforeday").val();
                                var reg = /^(0|[1-9][0-9]*)$/;
                                if(!reg.test(beday)){
                                    $(".be_day").text("大于等于0的整数")
                                }else{
                                    $(".be_day").text("")
                                }
                            }
                        </script>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:140px">入离时间:</td>
                    <td>
                        <span>最早入住时间</span>
                        <select class="intime">
                            <option <?php if($house_data['intime']==12){echo 'selected';} ?> value="12">12:00</option>
                            <option <?php if($house_data['intime']==13){echo 'selected';} ?> value="13">13:00</option>
                            <option <?php if($house_data['intime']==14){echo 'selected';} ?> value="14">14:00</option>
                            <option <?php if($house_data['intime']==15){echo 'selected';} ?> value="15">15:00</option>
                            <option <?php if($house_data['intime']==16){echo 'selected';} ?> value="16">16:00</option>
                            <option <?php if($house_data['intime']==17){echo 'selected';} ?> value="17">17:00</option>
                            <option <?php if($house_data['intime']==18){echo 'selected';} ?> value="18">18:00</option>
                        </select>
                        <span>最晚退房时间</span>
                        <select class="outtime">
                            <option <?php if($house_data['outtime']==12){echo 'selected';} ?> value="12">12:00</option>
                            <option <?php if($house_data['outtime']==13){echo 'selected';} ?> value="13">13:00</option>
                            <option <?php if($house_data['outtime']==14){echo 'selected';} ?> value="14">14:00</option>
\
                        </select>
                    </td>
                </tr>
                <!-- admin:ys time:2017/11/10 content:添加房源预订方式修改项 -->
                <?php if ($house_data['up_type'] == 0 || $house_data['up_type'] == 1 || $house_data['up_type'] == 2 || $house_data['up_type'] == 3) {//房源来源不是番茄或者同程才会展示?>

                <tr>
                    <td style="text-align: right!important;width:140px">是否可即时预定:</td>
                    <td>
                        <input type="radio" name="is_realtime" value="0" <?php if($house_data['is_realtime']==0){echo 'checked';} ?>>
                        <span>需确认入住</span>
                        <span style="padding-left: 10px;"></span>
                        <input type="radio" name="is_realtime" value="1" <?php if($house_data['is_realtime']==1){echo 'checked';} ?>>
                        <span>可即时预定</span>
                    </td>
                </tr>
                <?php }?>
                <tr>
                    <td style="text-align: right!important;width:140px">接纳性别:</td>
                    <td>
                        <label>
                            <input type="checkbox" <?php if($house_data['sex']==0){echo 'checked';} ?> name="gnm" value="0" checked onclick="return choosethree(this);">
                            <em>不限</em>
                        </label>
                        <label>
                            <input type="checkbox" <?php if($house_data['sex']==1){echo 'checked';} ?> name="gnm" value="1" onclick="return choosethree(this);">
                            <em>男</em>
                        </label>
                        <label>
                            <input type="checkbox" <?php if($house_data['sex']==2){echo 'checked';} ?> name="gnm" value="2" onclick="return choosethree(this);">
                            <em>女</em>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:140px">是否接纳外宾:</td>
                    <td>
                        <label>
                            <input type="checkbox" <?php if($house_data['is_welcome']==1){echo 'checked';} ?> name="gn" value="1" onclick="return choosefour(this);">
                            <em>是</em>
                        </label>
                        <label>
                            <input type="checkbox" <?php if($house_data['is_welcome']==0){echo 'checked';} ?> name="gn" value="0" onclick="return choosefour(this);">
                            <em>否</em>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:140px">禁止行为(选填):</td>
                    <td>
                        <?php foreach ($house_limit as $k => $v): ?>
                            <label>
                                <input <?php foreach($old_limit as $kk=>$vv){if($vv['limit_id']==$v['id']){echo 'checked';}} ?> type="checkbox" name="limit" value="<?php echo $v['id']; ?>">
                                <em><?php echo $v['limit_name'] ?></em>
                            </label>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <!--                <tr>-->
                <!--                    <td style="text-align: right!important;">其他费用(选填)</td>-->
                <!--                    <td class="limit_len">-->
                <!--                        <textarea style="border:1px solid #ccc;height:80px;width:80%;resize:none;"-->
                <!--                                  placeholder="对水电费进行描述" onblur="leave_txt()" max-length="200"></textarea>-->
                <!--                        <span style="color:red;">(200字以内)</span>-->
                <!--                        <i></i>-->
                <!--                    </td>-->
                <!--                </tr>-->
                <tr>
                    <td style="text-align: right!important;width:140px">隐藏贴士(选填):</td>
                    <td class="limit_len2">
                        <textarea class="secret_notice" style="border:1px solid #ccc;height:80px;width:80%;resize:none;"
                                  placeholder="" onblur="leave_txt2()" max-length="200"><?php echo $house_data['secret_notice']; ?></textarea>
                        <span style="color:#ccc;">(200字以内)</span>
                        <i></i>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:140px;">其他房客须知(选填):</td>
                    <td class="limit_len3">
                        <textarea class="notice" style="border:1px solid #ccc;height:80px;width:80%;resize:none;"
                                  placeholder="" onblur="leave_txt3()" max-length="200"><?php echo $house_data['notice']; ?></textarea>
                        <span style="color:#ccc;">(200字以内)</span>
                        <i></i>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row" style="padding-top: 0;">
            <input type="hidden" id="house_id" value="<?php echo $_GET['house_id']; ?>">
<!--            <button type="button" class="btn btn-primary">上一步</button>-->
            <button type="button" class="btn btn-primary add-three">保存并继续</button>
            <button type="button" class="btn btn-primary commit-update">提交修改</button>
        </div>
    </div>
</section>
<script>
    $(function () {
        function conservation(){
            var status=1;
            var minday = $('.minday').val();//
            var reg1 = /^(0|[1-9][0-9]*)$/;
            var len2 = $(".limit_len2 textarea").val().length;
            if (len2 > 200) {
                var status=0;
                $(".limit_len2 i").text("字数控制在200字以内").css("display", "block").css("color",'red');
            } else {
                $(".limit_len2 i").text("")
            }
            var len3 = $(".limit_len3 textarea").val().length;
            if (len3 > 200) {
                var status=0;
                $(".limit_len3 i").text("字数控制在200字以内").css("display", "block").css("color",'red');
            } else {
                $(".limit_len3 i").text("")
            }
            if(!reg1.test(minday)){
                console.log(567);
                var status=0;
                $(".minday_tip").text("大于0的整数")
            }else{
                $(".minday_tip").text("")
            }
            var maxday = $('.maxday').val();
            var reg2 = /^(0|[1-9][0-9]*)$/;
            if(!reg2.test(maxday)){
                var status=0;
                $(".maxday_tip").text("大于等于0的整数")
            }else{
                $(".maxday_tip").text("")
            }
            var beday = $(".beforeday").val();
            var reg3 = /^(0|[1-9][0-9]*)$/;
            if(!reg3.test(beday)){
                var status=0;
                $(".be_day").text("大于等于0的整数")
            }else{
                $(".be_day").text("")
            }
            return status;
        }
        $('.add-three').click(function () {
            var validate_status = conservation();
            if (validate_status == 0) {
                return false;
            }
            var house_id = $('#house_id').val();
            var minday = $('.minday').val();//最少入住天数
            var maxday = $('.maxday').val();//最多入住天数
            var beforeday = $('.beforeday').val();//提前入住天数
            var intime = $('.intime option:selected').val();
            var outtime = $('.outtime option:selected').val();
            var sex = $("input[name='gnm']:checked").val();
            var waibing = $("input[name='gn']:checked").val();
            var secret_notice = $('.secret_notice').val();
            var notice = $('.notice').val();
            var limit_arr = new Array;
            //admin:ys time:2017/11/10 content:添加民宿预订方式更改功能
            var is_realtime = $("input[name='is_realtime']:checked").val();
            $("input[name='limit']:checkbox:checked").each(function (i) {
                limit_arr[i] = $(this).val();
            })

            if (limit_arr) {
                var limit_str = limit_arr.join(',');
            } else {
                var limit_str = '';
            }
            if(parseInt(minday)>parseInt(maxday)){
                layer.open({
                    content: '最少入住天数不能大于最大入住天数',
                });
                return false;
            }
            if (house_id > 0 && minday > 0) {
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['add-three']) ?>",
                    data: {
                        minday: minday,
                        house_id: house_id,
                        intime: intime,
                        outtime: outtime,
                        sex: sex,
                        is_welcome: waibing,
                        limit: limit_str,
                        maxday: maxday,
                        beforeday: beforeday,
                        secret_notice: secret_notice,
                        notice: notice,
                        //admin:ys time:2017/11/10 content:添加民宿预订方式更改功能
                        is_realtime:is_realtime
                    },
                    success: function (data) {
                        if (data == -1) {
                            layer.open({
                                content: '所填信息有误',
                            });
                        }
                        if (data == -2) {
                            layer.open({
                                content: '上传失败',
                            });
                        }
                        if (data == -3) {
                            layer.open({
                                content: '数字格式不正确',
                            });
                        }
                        if (data == 1) {
                            location.href = "<?php echo \yii\helpers\Url::to(['add-four','house_id'=>$_GET['house_id']]) ?>"
                        }
                    }
                });
            } else {
                layer.open({
                    content: '所填信息有误',
                });
            }
        })


        $('.commit-update').click(function () {
            var validate_status = conservation();
            if (validate_status == 0) {
                return false;
            }
            var house_id = $('#house_id').val();
            var minday = $('.minday').val();//最少入住天数
            var maxday = $('.maxday').val();//最多入住天数
            var beforeday = $('.beforeday').val();//提前入住天数
            var intime = $('.intime option:selected').val();
            var outtime = $('.outtime option:selected').val();
            var sex = $("input[name='gnm']:checked").val();
            var waibing = $("input[name='gn']:checked").val();
            var secret_notice = $('.secret_notice').val();
            var notice = $('.notice').val();
            //admin:ys time:2017/11/10 content:添加民宿预订方式更改功能
            var is_realtime = $("input[name='is_realtime']:checked").val();
            var limit_arr = new Array;
            $("input[name='limit']:checkbox:checked").each(function (i) {
                limit_arr[i] = $(this).val();
            })

            if (limit_arr) {
                var limit_str = limit_arr.join(',');
            } else {
                var limit_str = '';
            }
            if(parseInt(minday)>parseInt(maxday)){
                layer.open({
                    content: '最少入住天数不能大于最大入住天数',
                });
                return false;
            }
            if (house_id > 0 && minday > 0) {
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['add-three']) ?>",
                    data: {
                        minday: minday,
                        house_id: house_id,
                        intime: intime,
                        outtime: outtime,
                        sex: sex,
                        is_welcome: waibing,
                        limit: limit_str,
                        maxday: maxday,
                        beforeday: beforeday,
                        secret_notice: secret_notice,
                        notice: notice,
                        //admin:ys time:2017/11/10 content:添加民宿预订方式更改功能
                        is_realtime:is_realtime
                    },
                    success: function (data) {
                        if (data == -1) {
                            layer.open({
                                content: '所填信息有误',
                            });
                        }
                        if (data == -2) {
                            layer.open({
                                content: '上传失败',
                            });
                        }
                        if (data == -3) {
                            layer.open({
                                content: '数字格式不正确',
                            });
                        }
                        if (data == 1) {
                            location.href = "<?php echo \yii\helpers\Url::to(['house-details/index']) ?>"
                        }
                    }
                });
            } else {
                layer.open({
                    content: '所填信息有误',
                });
            }
        })
    })
</script>

