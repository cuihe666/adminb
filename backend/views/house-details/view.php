<!-- 页面css -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/cobber.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/amaze/css/amazeui.css">

<script src="<?= Yii::$app->request->baseUrl ?>/common/js/jquery.min.js"></script>

<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/dist/js/app.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/amaze/js/amazeui.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>

<!--2017年5月23日17:47:23 日历控件fullcalendar 宋杏会-->
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/fullcalendar.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/fullcalendar.print.css"/>
<script src="<?= Yii::$app->request->baseUrl ?>/js/fullcalendar.js"></script>


<!-- 百度上传图片 -->
<script type="text/javascript"
        src="http://maps.google.cn/maps/api/js?key=AIzaSyDTGzrVtaszLJYj7pzMNB2ZWDEeVhIN0Dw&sensor=false&libraries=places&language=zh-CN"></script>
<script type="text/javascript"
        src="http://webapi.amap.com/maps?v=1.3&key=617da82831edeaf0c65e7352adf79479&plugin=AMap.Autocomplete,AMap.PlaceSearch,AMap.Geocoder"></script>
<script src="http://webapi.amap.com/ui/1.0/main.js"></script>
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
        font-weight: normal;
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
        float: right;
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

    textarea {
        outline: none;
        padding: 5px 0 0 5px;
    }

    /*#myModal6 label {*/
    /*display: inline-block;*/
    /*margin-right: 15px;*/
    /*}*/

    /*#myModal6 label input {*/
    /*float: left;*/
    /*}*/

    /*#myModal6 .row {*/
    /*margin-top: 5px*/
    /*}*/

    /*#myModal6 label em {*/
    /*font-style: normal;*/
    /*color: #999;*/
    /*font-weight: normal;*/
    /*display: inline-block;*/
    /*margin-top: 0px;*/
    /*margin-left: 3px;*/
    /*font-size: 14px;*/
    /*}*/

    /*#myModal6 span {*/
    /*display: inline-block;*/
    /*font-size: 14px;*/
    /*}*/

    .table-responsive > .table td {
        text-align: left !important;
    }

    .gmnoprint {
        display: none;
    }

    #detail_title {
        position: fixed;
        left: 260px;
        top: 130px;
        background-color: #ccc;
        width: 100%;
        padding-top: 0px;
        height: 26px;
        padding-left: 15px;
        box-sizing: border-box;
        z-index: 999;
    }

    #detail_title a {
        color: #fff;
    }

    #detail_title span {
        padding-top: 0;
        margin-right: 5px;
        display: inline-block;
        padding: 0 10px;
        font-size: 14px;
    }

    #detail_title .current_link {
        background-color: #3c8dbc;
        border: none;
    }

    #detail_title .current_link a {
        color: #fff;
    }

    /*后台管理系统实拍图片*/
    .introduce {
        width: 980px;
        margin: 0 auto;
    }

    .lay_03 {
        width: 100%;
    }

    .right_3 {
        width: 767px;
        float: left;
    }

    .caselist_1 {
        clear: both;
        margin-top: 20px;
    }

    .caselist_1 li {
        width: 181px;
        height: 173px;
        float: left;
        padding: 0px 10px;
        text-align: center;
        background: url(<?= Yii::$app->request->baseUrl ?>/images/case_li_bg.png) no-repeat center bottom;
        line-height: 20px;
    }

    .caselist_1 li img {
        margin-bottom: 10px;
    }

    #content {
        margin: 0 auto;
    }

    #tse .clearfix1 div {
        float: left;
        padding: 0 17px;
    }

    .fl {
        float: left;
        padding-left: 10px;
        font-size: 13px;
    }

    .fl2 {
        padding-left: 15px;
        font-size: 13px;
    }

    .checkbox_box > input, .checkbox_box2 > input {
        margin: 4px 5px 0 0;
    }

    ul {
        padding-left: 0;
    }

    .cause_box {
        margin-top: 20px;
    }

    .lable_title {
        display: block;
        font-size: 13px;
        font-weight: normal;
        text-indent: 6px;
        margin-top: 10px;
    }

    .checkbox_box {
        padding-left: 22px;
    }

    /*@2017-11-7 15:50:38 fuyanfei to add 房屋图片的标签配置--------minsu 320*/
    .house_tag{ overflow: hidden; height: 32px; margin-top:5px; }
    .house_tag span{ display: inline-block; height: 28px; line-height: 28px;}
    .house_tag select{ height: 26px; line-height: 26px; width:140px;}
</style>


<script>
    $(function () {
        $("#detail_title span").click(function () {
            $(this).addClass("current_link").siblings().removeClass("current_link")
        })
        /*  $("#picture_map_a").click(function () {
         var h = $("#base_message").height()+400;
         console.log(h)

         })*/
        if ($(document).scrollTop() > 0) {
            $("#detail_title").animate({"top": 0});
        }
        $(document).scroll(function () {
            var top = $(document).scrollTop();
            // console.log(top)
            if (top > 20) {
                $("#detail_title").css({"top": "0", "left": "245px"})
                /*  $("#base_message_a").click(function () {

                 })


                 $("#picture_map2_a").click(function () {

                 })
                 $("#price_rule_a").click(function () {

                 })*/

            } else {
                $("#detail_title").css({"top": "130px", "left": "260px"})
            }

        })
    })
</script>

<section class="content-header" style="position: relative;">
    <h5>
        当前位置:首页 > 民宿管理 > 房源详情
    </h5>
    <hr>
    <div class="row" id="detail_title">
        <span style="cursor: pointer" class="current_link">
            <a href="#base_message" id="base_message_a">基本信息</a>
        </span>
        <span style="cursor: pointer">
            <a href="#picture_map" id="picture_map_a">地图</a>
        </span>
        <span style="cursor: pointer">
            <a href="#picture_map2" id="picture_map2_a">实拍照片</a>
        </span>
        <span style="cursor: pointer">
            <a href="#price_rule" id="price_rule_a">价格规则</a>
        </span>
        <span style="cursor: pointer">
            <a href="#ruzhu_note">入住须知</a>
        </span>
        <span style="cursor: pointer">
            <a href="#house_dep">房屋描述</a>
        </span>
    </div>
</section>

<section class="content" id="content" style="width:80%;">
    <div class="form-group" style="padding-top:30px;" id="base_message">
        <input type="hidden" id="house_id" value="<?= $data['house_id'] ?>">
        <div class="row" id="base">
            <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">基本信息</span>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td style="text-align: right!important;width:130px;">房屋标题:</td>
                    <td>
                        <?= $data['title'] ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">出租类型:</td>
                    <td>
                        <?= Yii::$app->params['roommode'][$data['roommode']] ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">房源类型:</td>
                    <td>
                        <?= $roomtype ?>
                    </td>
                </tr>
                <tr class="acreage">
                    <td style="text-align: right!important;width:130px;">房源面积:</td>
                    <td>
                        <label>
                            <span><?= $data['roomsize'] ?></span>
                            <em>平米</em>
                            <em>宜住人数</em>
                            <span><?= $data['minguest'] ?></span>人
                            <em>最多入住人数</em>
                            <span><?= $data['maxguest'] ?></span>人
                        </label>
                    </td>
                </tr>
                <tr class="acreage acreage2">
                    <td style="text-align: right!important;width:130px;">户型:</td>
                    <td>
                        <span><?= $data['roomnum'] ?></span>&nbsp;
                        <span>室</span>
                        <span><?= $data['officenum'] ?></span>&nbsp;
                        <span>厅</span>
                        <span><?= $data['kitchenum'] ?></span>&nbsp;
                        <span>厨</span>
                        <span><?= $data['bathnum'] ?></span>&nbsp;
                        <span>卫</span>
                        <span><?= $data['balconynum'] ?></span>&nbsp;
                        <span>阳台</span>
                    </td>
                </tr>
                <?php foreach ($bed_data as $k => $val) { ?>
                    <tr class="acreage acreage2">
                        <td style="text-align: right!important;width:130px;">床铺信息:&nbsp;<?= $k + 1; ?>&nbsp;</td>
                        <td>
                            <span><?= Yii::$app->params['bed_type'][$val['bed_type']] ?></span>
                            &nbsp;&nbsp;&nbsp;
                            <span>长</span>
                            <span><?= $val['bed_long'] ?></span>
                            <span>米&nbsp;*&nbsp;宽</span>
                            <span><?= $val['bed_wide'] ?></span>
                            <span>米</span>&nbsp;&nbsp;
                            <span><?= $val['bed_count'] ?></span>
                            <span>张</span>
                        </td>
                    </tr>
                <?php } ?>
                <tr class="acreage acreage2">
                    <td style="text-align: right!important;width:130px;">同类房源:</td>
                    <td>
                        <span><?= $data['total_stock'] ?></span>
                        <span style="color:#ccc">*含此房源（朝向、户型、房间面积相同；家具家电、装修同档的房间）</span>
                    </td>
                </tr>
                <tr class="acreage acreage2">
                    <td style="text-align: right!important;width:130px;">房屋排序:</td>
                    <td>
                        <?= $data['tango_weight'] ?>
                        <!--                               style="width:80px;text-align: center;">-->
                        <!--                        <span style="color:#ccc">*越大越靠前</span>-->
                        <!--                        <span>有效时间</span>-->
                        <!--                        <input id="date_start" name="TravelHigo[start_time]" value="" class="Wdate" type="text"-->
                        <!--                               onfocus="var date_end=$dp.$('date_end');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){date_end.focus()}})"-->
                        <!--                        / style="width:20%;margin-top: 5px;">--->
                        <!--                        <input id="date_end" class="Wdate" name="TravelHigo[end_time]" value="" type="text"-->
                        <!--                               onFocus="WdatePicker({minDate:'#F{$dp.$D(\'date_start\')}',readOnly:true,maxDate:'#F{$dp.$D(\'date_start\',{M:+6})}'})"-->
                        <!--                               style="width:20%;margin-top:5px;"/>-->
                    </td>
                </tr>

                <!--                <tr>-->
                <!--                    <td style="text-align: right!important;width:130px;">是否置顶显示:</td>-->
                <!--                    <td>-->
                <!--                       -->
                <!---->
                <!--                    </td>-->
                <!--                </tr>-->
                <tr class="acreage acreage2">
                    <td style="text-align: right!important;width:130px;">所在省:</td>
                    <td>
                        <span><?= $province ?></span>

                    </td>
                </tr>

                <tr class="acreage acreage2">
                    <td style="text-align: right!important;width:130px;">所在城市:</td>
                    <td>
                        <span><?= $city ?></span>

                    </td>
                </tr>

                <tr class="acreage acreage2">
                    <td style="text-align: right!important;width:130px;">所在区域:</td>
                    <td>
                        <span><?= $area ?></span>

                    </td>
                </tr>
                <tr class="acreage acreage2">
                    <td style="text-align: right!important;width:130px;">房屋地址:</td>
                    <td>
                        <span><?= $address ?></span>
                    </td>
                </tr>
                <?php if ($data['status'] == 3): ?>
                    <tr class="acreage acreage2">
                        <td style="text-align: right!important;width:130px;">未通过原因:</td>
                        <td><?php if (!empty($reson)): ?>
                                <span><?= $reson['reson'] . $reson['detail_reson'] ?></span>

                            <?php endif ?>
                        </td>
                    </tr>

                <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group" id="picture_map" style="padding-top: 30px">
        <div class="row" id="picture">
            <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">地图</span>
        </div>
        <div class="row" style="width:90%;margin:0 auto 10px;padding:0px;box-sizing:border-box;">
            <div class="col-md-12">
                <div style="margin-top:10px;position: relative;">
                    <div id="map" style="width:100%;height:380px;margin:0 auto;"></div>
                    <span
                            style="position: absolute;right:0;bottom:10px;background-color: rgba(0,0,0,0.5);color:#fff;padding:5px 10px;display: inline-block;"
                            class="house_adds">房源位置:<?php echo $address; ?></span>
                </div>
                <script>
                    var map;
                    var marker;
                    var infowindow;
                    var geocoder;
                    var markersArray = [];
                    function initMap() {
                        var lat =<?php echo $data['latitude'] ?>;
                        var lng =<?php echo $data['longitude'] ?>;
                        map_google = new google.maps.Map(document.getElementById('map'), {
                            center: {lat: lat, lng: lng},
                            zoom: 13
                        });
                        geocoder_google = new google.maps.Geocoder();
                        //监听点击地图事件
//                        google.maps.event.addListener(map, 'click', function (event) {
//                            placeMarker(event.latLng);
//                        });


//                        var input = document.getElementById('pac-input');
//
//                        var infowindow = new google.maps.InfoWindow();
//                        var marker = new google.maps.Marker({
//                            map: map,
//                            anchorPoint: new google.maps.Point(0, -29)
//                        });
                        var latlng = new google.maps.LatLng(lat, lng);
                        placeMarker(latlng);
                        marker_google = new google.maps.Marker({
                            position: latlng,
                            map: map_google
                        });

                    }

                    function placeMarker(location) {
                        clearOverlays(infowindow);//清除地图中的标记
                        marker_google = new google.maps.Marker({
                            position: location,
                            map: map_google
                        });
                        markersArray.push(marker_google);
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
                                map: map
                            });
                            markersArray.push(marker);
                            attachSecretMessage(marker, latlng);
                        }
                    }

                    //高德地图初始化
                    function initGDmap() {
                        lat =<?php echo $data['latitude'] ?>;
                        lng =<?php echo $data['longitude'] ?>;
                        map = new AMap.Map("map", {
                            resizeEnable: true,
                            zoom: 15,//地图显示的缩放级别
                            center: [lng, lat]
                        });


                        var marker = new AMap.Marker({
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
                                console.log(result);
                                var format_address = result.regeocode.addressComponent.province + result.regeocode.addressComponent.city + result.regeocode.addressComponent.district + result.regeocode.addressComponent.street + result.regeocode.addressComponent.streetNumber;
                                var infoWindow = new AMap.InfoWindow({
                                    autoMove: true,
                                    offset: {x: 0, y: -30}
                                });
                                infoWindow.setContent(format_address);
                                infoWindow.open(map, lnglatXY);
                            }
                        });

                    }

                    window.onload = function () {
                        <?php if($data['national'] != 10001){ ?>
                        initMap();
                        <?php }else{ ?>
                        initGDmap();
                        <?php } ?>
                    }
                </script>

            </div>

        </div>
    </div>
    <div class="form-group" style="padding-top:30px;" id="picture_map2">
        <div class="row">
            <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">实拍照片</span>
        </div>
        <div class="row" style="width:90%;margin:0 auto 10px;padding:0px;box-sizing:border-box;">
            <div class="col-md-12">
                <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default"
                    data-am-gallery="{ pureview: true }">

                    <li>
                        <div class="am-gallery-item">
                            <a href="http://img.tgljweb.com/<?php echo $data['cover_img']; ?>" class="">
                                <img src="http://img.tgljweb.com/<?php echo $data['cover_img']; ?>"
                                     style="height: 145px;"/>
                            </a>
                        </div>
                        <p class="house_tag">
                            <span>标签配置：</span>
                            <?=Yii::$app->params['house']['house_img_label'][intval($coverImg['img_label'])]?>
                        </p>
                    </li>
                    <?php if ($img) {
                        ?>

                        <?php foreach ($img as $k => $v): ?>
                            <li>
                                <div class="am-gallery-item">
                                    <a href="http://img.tgljweb.com/<?php echo $v['img_url']; ?>">
                                        <img src="http://img.tgljweb.com/<?php echo $v['img_url']; ?>" style="height: 145px;"/>
                                    </a>
                                </div>
                                <p class="house_tag">
                                    <span>标签配置：</span>
                                    <?=Yii::$app->params['house']['house_img_label'][intval($v['img_label'])]?>
                                </p>
                            </li>
                        <?php endforeach ?>
                    <?php } ?>
                </ul>
                <style>
                    .am-gallery .figure_first {
                        position: absolute;
                        left: 0;
                        top: -19px;
                        z-index: 4;
                        color: red;
                        width: 0;
                        height: 0;
                        border-top: 36px solid transparent;
                        border-bottom: 36px solid transparent;
                        border-right: 36px solid red;
                        transform: rotate(46deg);
                        -webkit-transform: rotate(46deg);
                        -moz-transform: rotate(46deg);
                        -o-transform: rotate(46deg);
                        -ms-transform: rotate(46deg);
                    }

                    .am-gallery .figure_des {
                        position: absolute;
                        left: 6px;
                        top: 8px;
                        z-index: 5;
                        font-size: 14px;
                        color: #fff;
                    }

                    .am-pureview-direction a:before {
                        font-size: 40px;
                    }

                    .am-pureview-actions a {
                        left: 97%;
                    }

                    .am-icon-chevron-left:before {
                        content: "";
                        width: 33px;
                        height: 45px;
                        background: url(<?= Yii::$app->request->baseUrl ?>/images/cha.png) no-repeat 100%;
                    }
                </style>
                <script>
                    $(function () {
                        $(".am-gallery li").first().css("position", "relative").append("<b class='figure_first' ></b>" + "<i class='figure_des'>首图</i>")
                    })
                </script>

            </div>

        </div>
    </div>
    <div class="form-group" style="padding-top:30px;" id="price_rule">
        <div class="row">
            <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">价格规则</span>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td style="text-align: right!important; width: 130px;">价格:</td>
                    <td>
                        <span style="padding:5px 10px;" modal_name="#myModal5" id="fullcal"
                              class="price-modal"><?= $data['price'] ?></span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">押金:</td>
                    <?php if ($data['is_deposit'] == 1) { ?>
                        <td>线下押金:<?= $data['deposit'] ?>元</td>
                    <?php } else { ?>
                        <td>不收取</td>
                    <?php } ?>

                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">清洁费:</td>
                    <td><?php if (!empty($data['clean_fee'])) {
                            echo $data['clean_fee'];
                        } else {
                            echo '0';
                        } ?>&nbsp;&nbsp;间/次
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">超额费用:</td>
                    <td><?php if (!empty($data['over_fee'])) {
                            echo $data['over_fee'];
                        } else {
                            echo '0';
                        } ?>&nbsp;&nbsp;元/晚
                    </td>
                </tr>
                <tr class="acreage acreage2 acreage3 ">
                    <td style="text-align: right!important;width:130px;">退款规则:</td>
                    <td style="text-align: inherit!important;">
                        <?php if ($data['refund_rule'] == 1) {
                            echo "入住前1天14:00之前申请退款,无条件退款<br/>
1、要获得全额住宿费用退款，房客必须在入住日期当天前1天14：00前取消预订。例如，如果入住日期是周五，则需在该周周四的14：00之前取消预订<br/>
2、如果房客在入住日14：00前24小时内取消预订，首晚房费将不可退还<br/>
3、如果房客已入住但决定提前退房，那么扣除未消费的头一天的房费，其余部分退还给房客";
                        } ?>

                        <?php if ($data['refund_rule'] == 2) {
                            echo "入住前5天14：00点前取消预订可获得全额退款<br/>
1、要获得住宿费用的全额退款，房客必须在入住日期，前5天14：00前取消预订。例如，如果入住日期是周五，则需在前一个周日的14：00之前取消预订<br/>
2、如果房客提前不到5天退订，那么首晚房费将不可退还，但剩余的天数将退还50%的房费<br/>
3、如果房客已入住但决定提前退房，那么扣除未消费的头一天的房费，其余部分50%退还给房客";
                        } ?>

                        <?php if ($data['refund_rule'] == 3) {
                            echo "入住前1周14：00点前取消预订可获得50%退款<br/>
1、要获得50%的住宿费用退款，房客必须在入住日期，前7天14：00前取消预订，否则不予退款。例如，入住日期是周五，则需在前一个周五的14：00之前取消预订。周四的14：00之前取消预订<br/>
2、如果房客未能在7天前取消预订，未住宿天数的房费将不予退还<br/>
3、如果房客已入住但决定提前退房，剩余天数的房费将不予退还";
                        } ?>

                        <?php if ($data['refund_rule'] == 4) {
                            echo "房客支付后取消预订将不退还任何费用<br/>
1、预订成功之后，若要取消预订，将不退还任何费用";
                        } ?>

                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group" id="ruzhu_note" style="padding-top: 30px;">
        <div class="row">
            <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">入住须知</span>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td style="text-align: right!important;width:130px;">入住规则:</td>
                    <td>
                        <span>最少入住天数：</span>
                        <span style="display: inline-block;margin-right:5px;"><?= $data['minday'] ?></span>&nbsp;&nbsp;
                        <span>最多入住天数:</span>
                        <span style="display: inline-block;margin-right:5px;"><?php if (!empty($data['maxday'])) {
                                echo $data['maxday'];
                            } else {
                                echo '不限制';
                            } ?></span>&nbsp;&nbsp;
                        <span>提前预定天数:</span>
                        <span>
							<?php if (@$data['beforeday'] == 0) { ?>
                                不限制
                            <?php } else { ?>
                                <?php echo @$data['beforeday'] ?>&nbsp;天
                            <?php } ?>
						</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">入离时间:</td>
                    <td>
                        <span>最早入住时间</span>
                        <span style="display: inline-block;margin-right:5px;"><?= $data['intime'] ?>:00</span>
                        <span>最晚退房时间</span>
                        <span style="display: inline-block;margin-right:5px;"><?= $data['outtime'] ?>:00</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">接纳性别:</td>
                    <td>
                        <span><?= @Yii::$app->params['house_sex'][$data['sex']] ?></span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">是否接纳外宾:</td>
                    <td>
                        <span><?= @ Yii::$app->params['is_welcome'][$data['is_welcome']] ?></span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">禁止行为(选填):</td>
                    <td>

                        <span><?= @$limit_info ? $limit_info : '无' ?></span>&nbsp;&nbsp;

                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">其他费用(选填)</td>
                    <td class="limit_len">
                        对水费、电费、燃气费等其他费用有其他要求进行描述
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">隐藏贴士(选填):</td>
                    <td class="limit_len2">
                        <?= $data['secret_notice'] ? $data['secret_notice'] : '无' ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">其他房客须知(选填):</td>
                    <td class="limit_len3">
                        <?= $data['notice'] ? $data['notice'] : '无' ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group" id="house_dep" style="padding-top: 30px;">
        <div class="row">
            <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">房屋描述</span>
        </div>
        <div class="table-responsive" style="overflow-x:inherit">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td style="text-align: right!important;width:130px;">配套设施:</td>
                    <td style="text-align: left!important;padding-left:20px;position: relative;">
                        <div class="row" style="width:80%;">

                            <label class="appliances">
                                <?= $house_fac ?>
                            </label>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">房源描述:</td>
                    <td class="limit_len4">
                        <?= $data['introduce'] ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">房源亮点:</td>
                    <td class="limit_len4">
                        <?= $data['house_highlights'] ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">周边设施:</td>
                    <td class="limit_len6">
                        <?= $data['nearby_intro'] ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row" style="padding-top: 0;margin-top: 10px;position: fixed;left:380px;
        bottom:0;">
            <button type="button" class="btn btn-primary go_last" style="background-color: orange;border:none;">返回上一页
            </button>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

            <button class="btn  btn-danger check_house">审核房源</button>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            <button class="btn  btn-warning  sort">排序</button>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            <button class="btn  btn-success  comment">添加评论</button>
        </div>
    </div>

    <!--2017年5月23日17:44:23 价格规则 添加价格modal 宋杏会-->

    <div class="modal" id="myModal5">
        <div class="modal-dialog" style="background-color: #fff;">
            <div class="modal-content">
                <div class="calendarWrapper">
                    <div id="calendar" class="dib"></div>
                </div>
                <style>
                    .fc-header td {
                        padding-top: 10px;
                    }

                    .fc-event {
                        border: none;
                        background: transparent !important;
                    }

                    .fc-event-inner {
                        text-align: center;
                        margin-top: 5px;
                    }

                    .fc-event-title {

                    }
                </style>
                <script>
                    $(document).ready(function () {
                        var date = new Date();
                        var d = date.getDate();
                        var m = date.getMonth();
                        var y = date.getFullYear();
                        var initialLangCode = 'en';
                        $('#calendar').fullCalendar({

                            buttonText: {
                                prev: "<span class='fc-text-arrow'>&lsaquo;上个月</span>",
                                next: "<span class='fc-text-arrow'>下个月&rsaquo;</span>"
                            },
                            editable: false,
                            weekends: true,
                            defaultDate: '2016-06-06',
                            eventSources:[
                                {events:[
                                    <?php
                                    foreach ($date_price as $k => $v) {

                                    ?>

                                    {
                                        title: '<?php
                                            echo '￥' . $v;
                                            ?>',
                                        start: '<?php  echo $k;?>'
                                    },
                                    <?php
                                    }

                                    ?>
                                ]},
                                {events:[
                                    <?php
                                    foreach ($date_stock as $ks => $vs) {

                                    ?>

                                    {
                                        title: '<?php
                                            echo $vs;
                                            ?>',
                                        start: '<?php  echo $ks;?>'
                                    },
                                    <?php
                                    }

                                    ?>
                                ]},
                            ],

                        });
                        $("#fullcal").click(function () {
                            $("#myModal5").show();
                            $('#calendar').fullCalendar('render');
                        })
                        $("#fullcal_close").click(function () {
                            $("#myModal5").hide();
                            $(".modal-backdrop.in").hide()
                        })
                    })
                    /** 绑定事件到日期下拉框 **/
                    $(function () {
                        $("#fc-dateSelect").delegate("select", "change", function () {
                            var fcsYear = $("#fcs_date_year").val();
                            var fcsMonth = $("#fcs_date_month").val();
                            $("#calendar").fullCalendar('gotoDate', fcsYear, fcsMonth);
                        });

                    });

                </script>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-default" id="fullcal_close">关闭</button>
            </div>
        </div>
    </div>

    <!--end-->


    <!-- 审核房源 -->
    <div class="modal fade" id="check_house" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">请选择房源状态</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>请选择</label>
                        <select class="form-control se" id="house_status">
                            <?php if ($data['status'] == 0): ?>
                                <option
                                        value="1">
                                    通过
                                </option>

                                <option
                                        value="3">
                                    不通过
                                </option>
                            <?php endif ?>
                            <?php if ($data['status'] == 3): ?>
                                <option value="1">通过</option>
                            <?php endif ?>
                            <?php if ($data['status'] == 1 && $data['online'] == 1): ?>
                                <option value="4">下架</option>
                            <?php endif ?>


                            <?php if ($data['status'] == 1 && $data['online'] == 0): ?>
                                <option value="1">
                                    上架
                                </option>

                                <option value="3">不通过</option>
                            <?php endif ?>
                        </select>
                        <!--                    <textarea class="reason" placeholder="驳回原因" id="tse" cols="30" rows="10"-->
                        <!--                              style="width:100%;height:150px;margin-top:20px;"></textarea>-->
                        <div id="tse">

                            <ul>
                                <li style="margin:10px 0 0 2px;">提示</li>
                                <li class="house_names clearfix1">
                                    <label for="" class="lable_title">问题区域：</label>
                                    <?php if (!empty($reson)) : ?>
                                        <?php $type = explode(',', $reson['type']) ?>
                                        <div class="checkbox_box fl"><input type="checkbox" name="error" class="fl"
                                                                            value="1" <?php if (in_array('1', $type)) {
                                                echo 'checked';
                                            } ?>/><span class="fl">房源信息</span>
                                        </div>
                                        <div class="checkbox_box fl"><input type="checkbox" name="error" class="fl"
                                                                            value="2" <?php if (in_array('2', $type)) {
                                                echo 'checked';
                                            } ?>/><span class="fl">房源描述</span>
                                        </div>
                                        <div class="checkbox_box fl"><input type="checkbox" name="error" class="fl"
                                                                            value="3" <?php if (in_array('3', $type)) {
                                                echo 'checked';
                                            } ?>/><span class="fl">房源图片</span>
                                        </div>
                                        <div class="checkbox_box fl"><input type="checkbox" name="error" class="fl"
                                                                            value="4" <?php if (in_array('4', $type)) {
                                                echo 'checked';
                                            } ?>/><span class="fl">配套设施</span>
                                        </div>
                                        <div class="checkbox_box fl"><input type="checkbox" name="error" class="fl"
                                                                            value="5" <?php if (in_array('5', $type)) {
                                                echo 'checked';
                                            } ?>/><span class="fl">价格规则</span>
                                        </div>

                                    <?php else: ?>
                                        <div class="checkbox_box fl"><input type="checkbox" name="error" class="fl"
                                                                            value="1"/><span class="fl">房源信息</span>
                                        </div>
                                        <div class="checkbox_box fl"><input type="checkbox" name="error" class="fl"
                                                                            value="2"/><span class="fl">房源描述</span>
                                        </div>
                                        <div class="checkbox_box fl"><input type="checkbox" name="error" class="fl"
                                                                            value="3"/><span class="fl">房源图片</span>
                                        </div>
                                        <div class="checkbox_box fl"><input type="checkbox" name="error" class="fl"
                                                                            value="4"/><span class="fl">配套设施</span>
                                        </div>
                                        <div class="checkbox_box fl"><input type="checkbox" name="error" class="fl"
                                                                            value="5"/><span class="fl">价格规则</span>
                                        </div>


                                    <?php endif ?>
                                    <div style="clear: both;"></div>
                                </li>
                                <div style="clear: both;"></div>
                            </ul>
                            <ul class="cause_box">
                                <li class="house_names clearfix">
                                    <label for="" class="lable_title">具体原因：</label>

                                    <?php if (!empty($reson)) : ?>
                                        <?php $resons = explode('/n', $reson['reson']) ?>


                                        <div class="checkbox_box2 fl2">
                                            <input type="checkbox" name="cause" class="fl"
                                                   value="床上不能空着，要有床品。" <?php if (in_array('床上不能空着，要有床品。', $resons)) {
                                                echo 'checked';
                                            } ?>/>
                                            <span class="fl2">床上不能空着，要有床品。</span>
                                        </div>

                                        <div class="checkbox_box2 fl2">
                                            <input type="checkbox" name="cause" class="fl"
                                                   value="房源描述不能低于15字，禁止出现联系方式，标点符号。" <?php if (in_array('房源描述不能低于15字，禁止出现联系方式，标点符号。', $resons)) {
                                                echo 'checked';
                                            } ?>/>
                                            <span class="fl2">房源描述不能低于15字，禁止出现联系方式，标点符号</span></div>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value="房源照片必须要有卧室、厨房、客厅、卫生间、外景，不少于7张照片。" <?php if (in_array('房源照片必须要有卧室、厨房、客厅、卫生间、外景，不少于7张照片。', $resons)) {
                                                echo 'checked';
                                            } ?>/><span
                                                    class="fl2">房源照片必须要有卧室、厨房、客厅、卫生间、外景，不少于7张照片。</span>
                                        </div>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value="房源质量不属于棠果旅居民宿合作范围的房源将不予上线，例如：酒店、宾馆。" <?php if (in_array('房源质量不属于棠果旅居民宿合作范围的房源将不予上线，例如：酒店、宾馆。', $resons)) {
                                                echo 'checked';
                                            } ?>/><span
                                                    class="fl2">房源质量不属于棠果旅居民宿合作范围的房源将不予上线，例如：酒店、宾馆。</span>
                                        </div>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value="照片内带有标识水印、人工合成的文字、重复、修改涂抹痕迹、画面模糊、内容与房源信息无关、过于脏乱、设施过于老旧、广告及宣传品、联系方式、地址信息、反动、色情、暴力、污言秽语、人物、概念图、模拟图、拼接图、截图、拉伸变形、过于倾斜。" <?php if (in_array('照片内带有标识水印、人工合成的文字、重复、修改涂抹痕迹、画面模糊、内容与房源信息无关、过于脏乱、设施过于老旧、广告及宣传品、联系方式、地址信息、反动、色情、暴力、污言秽语、人物、概念图、模拟图、拼接图、截图、拉伸变形、过于倾斜。', $resons)) {
                                                echo 'checked';
                                            } ?>/><span
                                                    class="fl2">照片内带有标识水印、人工合成的文字、重复、修改涂抹痕迹、画面模糊、内容与房源信息无关、过于脏乱、设施过于老旧、广告及宣传品、联系方式、地址信息、反动、色情、暴力、污言秽语、人物、概念图、模拟图、拼接图、截图、拉伸变形、过于倾斜。</span>
                                        </div>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value="文字信息与房源图片中所体现的房源情况应保持一致，如卧室数、床数、卫生间数量、厨房数量等。" <?php if (in_array('文字信息与房源图片中所体现的房源情况应保持一致，如卧室数、床数、卫生间数量、厨房数量等。', $resons)) {
                                                echo 'checked';
                                            } ?>/><span
                                                    class="fl2">文字信息与房源图片中所体现的房源情况应保持一致，如卧室数、床数、卫生间数量、厨房数量等。</span>
                                        </div>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value="卫生间图片要包含马桶和地面。" <?php if (in_array('卫生间图片要包含马桶和地面。', $resons)) {
                                                echo 'checked';
                                            } ?>/><span
                                                    class="fl2">卫生间图片要包含马桶和地面。</span></div>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value="图片模糊不清。。" <?php if (in_array('图片模糊不清。', $resons)) {
                                                echo 'checked';
                                            } ?>/><span class="fl2">图片模糊不清。</span>
                                        </div>


                                    <?php else: ?>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value="床上不能空着，要有床品。"/><span class="fl2">床上不能空着，要有床品。</span>
                                        </div>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value="房源描述不能低于15字，禁止出现联系方式，标点符号。"/><span
                                                    class="fl2">房源描述不能低于15字，禁止出现联系方式，标点符号。</span></div>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value="房源照片必须要有卧室、厨房、客厅、卫生间、外景，不少于7张照片。"/><span
                                                    class="fl2">房源照片必须要有卧室、厨房、客厅、卫生间、外景，不少于7张照片。</span>
                                        </div>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value="房源质量不属于棠果旅居民宿合作范围的房源将不予上线，例如：酒店、宾馆。"/><span
                                                    class="fl2">房源质量不属于棠果旅居民宿合作范围的房源将不予上线，例如：酒店、宾馆。</span>
                                        </div>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value=照片内带有标识水印、人工合成的文字、重复、修改涂抹痕迹、画面模糊、内容与房源信息无关、过于脏乱、设施过于老旧、广告及宣传品、联系方式、地址信息、反动、色情、暴力、污言秽语、人物、概念图、模拟图、拼接图、截图、拉伸变形、过于倾斜。"/><span
                                                    class="fl2">照片内带有标识水印、人工合成的文字、重复、修改涂抹痕迹、画面模糊、内容与房源信息无关、过于脏乱、设施过于老旧、广告及宣传品、联系方式、地址信息、反动、色情、暴力、污言秽语、人物、概念图、模拟图、拼接图、截图、拉伸变形、过于倾斜。</span>
                                        </div>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value="文字信息与房源图片中所体现的房源情况应保持一致，如卧室数、床数、卫生间数量、厨房数量等"/><span
                                                    class="fl2">文字信息与房源图片中所体现的房源情况应保持一致，如卧室数、床数、卫生间数量、厨房数量等</span>
                                        </div>
                                        <div class="checkbox_box2 fl2"><input type="checkbox" name="cause" class="fl"
                                                                              value="图片模糊不清。"/><span
                                                    class="fl2">图片模糊不清。</span></div>


                                    <?php endif ?>


                                </li>
                            </ul>

                            <label for="" class="lable_title">具体原因：</label>

                            <?php if (!empty($reson)) : ?>

                                <textarea name="detail_reson" style="width:500px;height:50px; resize: none"
                                          id='detail_reson'><?php echo $reson['detail_reson'] ?></textarea>
                            <?php else: ?>
                                <textarea name="detail_reson" style="width:500px;height:50px; resize: none"
                                          id='detail_reson'></textarea>
                            <?php endif ?>


                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            $("#tse").hide();
                            var aa = $(".se option:selected");
                            var aaval = aa.val();
                            if (aaval === "3") {
                                $("#tse").show();
                            } else if (aaval === "1") {
                                $("#tse").hide();
                            }
                            $(".se").change(function () {
                                var aa = $(".se option:selected");
                                var aaval = aa.val();
                                if (aaval === "3") {
                                    $("#tse").show();
                                } else if (aaval === "1") {
                                    $("#tse").hide();
                                }
                            });
                        });
                    </script>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary status_save">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

                </div>
            </div>
        </div>
    </div>
    <!-- 排序 -->

    <div class="modal fade" id="sort" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">输入排序值</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputSuccess"
                               onkeyup="value=value.replace(/[^1234567890-]+/g,'')">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary sort_save">保存</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 添加评论 -->

    <div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">请输入评论内容</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <?php if ($data['national'] == 10001): ?>
                            <textarea class="form-control" cols="4" rows="4" id='comment_inner' maxlength="1000"
                                      placeholder="最多不超过1000字"></textarea>
                        <?php else: ?>
                            <textarea class="form-control" cols="4" rows="4" id='comment_inner' maxlength="2000"
                                      placeholder="最多不超过2000字"></textarea>
                        <?php endif ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary comment_save">保存</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="am-modal am-modal-alert" tabindex="-1" id="my-alert">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">Amaze UI</div>
            <div class="am-modal-bd">
                Hello world！
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn">确定</span>
            </div>
        </div>
    </div>

    <style>
        td {
            text-align: center;
        }
    </style>
    <script>
        $('.check_house').click(function () {
            $('#check_house').modal();

        })


        $('.status_save').click(function () {
            var house_status = $("#house_status").find("option:selected").val();
            var house_id = $("#house_id").val();

            var errors = new Array();
            var resons = new Array();
            var detail_reson = $('#detail_reson').val();
            $('input[name="error"]:checked').each(function () {
                errors.push($(this).val());//向数组中添加元素
            });
            $('input[name="cause"]:checked').each(function () {
                resons.push($(this).val());//向数组中添加元素
            });
            var idstr = errors.join(',');//将数组元素连接起来以构建一个字符串

            var res = resons.join('/n');//将数组元素连接起来以构建一个字符串
            if (house_status == 3) {
                if (idstr == '') {
                    layer.alert('问题区域不为空', {icon: 2});
                    return false;
                }


                if (res == '' && detail_reson == '') {
                    layer.alert('具体原因不能为空', {icon: 2});
                    return false;
                }

            }
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['status']) ?>",
                data: {
                    house_status: house_status,
                    house_id: house_id,
                    reason: res,
                    errors: idstr,
                    detail_reson: detail_reson
                },
                success: function (data) {
                    console.log(data);
                    if (data == 1) {
                        $('#check_house').modal('hide')
                        layer.alert('操作成功', {icon: 1});
                        location.href = '<?php echo \yii\helpers\Url::to(['house-details/index']) ?>';
                    }

                }
            })
        })

        $('.sort').click(function () {
            $('#sort').modal();


        })

        $('.sort_save').click(function () {
            var house_id = $("#house_id").val();
            var sort_num = parseInt($("#inputSuccess").val());
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['sort']) ?>",
                data: {sort_num: sort_num, house_id: house_id},
                success: function (data) {
                    if (data == 1) {
                        $('#sort').modal('hide')
                        layer.alert('操作成功', {icon: 1});
                    }

                }
            })
        })

        $('.comment').click(function () {
            $('#comment').modal();


        })

        $('.comment_save').click(function () {
            var house_id = $("#house_id").val();
            var comment_inner = $('#comment_inner').val();
            if (comment_inner == '') {
                layer.alert('内容不能为空', {icon: 1});
                return false;
            }
            var long = <?php if ($data['national'] == 10001) {
                echo 1000;
            } else {
                echo 2000;
            }?>;

            if (comment_inner.length > long) {
                layer.alert('输入文字过长!', {icon: 1});
                return false;
            }


            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['comment']) ?>",
                data: {comment_inner: comment_inner, house_id: house_id},
                success: function (data) {
                    if (data == 1) {
                        $('#comment').modal('hide')
                        layer.alert('操作成功', {icon: 1});
                    }

                }
            })
        })

    </script>

    <script>
        $('.go_last').click(function () {
            location.href = '<?php echo \yii\helpers\Url::to(['house-details/index']) ?>';
        })
    </script>


