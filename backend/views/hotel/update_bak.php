<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '编辑基本信息';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\ScrollAsset::register($this);
?>

<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/bootstrap/css/bootstrap-datetimepicker.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
      page. However, you can choose any other skin. Make sure you
      apply the skin class to the body tag so the changes take effect.
-->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/skins/skin-blue.min.css">
<!--new link-->
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/dist/css/rummery.css"/>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/gobal.css" />
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/xhhgrogshop.css" />
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/layer/skin/default/layer.css"/>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
    .hotel_information_tips,.hostshort_b{
        color:red;
    }
</style>



<body class="hold-transition skin-blue sidebar-mini">


    <!-- Content Wrapper. Contains page content -->
    <div class="wrapper-content animated fadeInRight" style="background-color: #F2F2F2;">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <ul class="rummery_tab clearfix">
                <li class="current col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/add']) ?>">酒店信息</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/two','id'=>$model->id]) ?>">酒店政策</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/three','id'=>$model->id]) ?>">服务设施</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/four','id'=>$model->id]) ?>">房型管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/set-price','hotel_id'=>$model->id]) ?>">房态房价设置</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-pic','id'=>$model->id]) ?>">图片管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/supplier','id'=>$model->id]) ?>">关联供应商</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/contact','id'=>$model->id]) ?>">联系人信息</a></li>
            </ul>
            <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form']) ?>
            <div class="rummery_con">
                <div class="rummery_item rummery_detail">
                    <div class="xhh_conent hotel_information">
                        <ul class="conent-message">
                            <li>
                                <i>*&nbsp;&nbsp;</i>
                                <span>酒店名称：</span>
                                <input class="grogshop" type="" name="Hotel[complete_name]" id="bankname" maxlength="20" value="<?=$model->complete_name?>" onblur="hotelname($('#bankname'),$('.bankname_b'));">
                                <b class="hotel_information_tips bankname_b"></b>
                            </li>
                            <li>
                                <i style="width:15px;height:5px;float: left;"></i>
                                <span>酒店简称：</span>
                                <input type="" name="Hotel[short_name]" id="hostshort" value="<?=$model->short_name?>" onblur="hostshort($('#bankname'),$('.bankname_b'));">
                                <b class=" hostshort_b"></b>
                            </li>
                            <li>
                                <i>*&nbsp;&nbsp;</i>
                                <span>酒店类型：</span>
                                <?= Html::activeDropDownList($model, 'type', Yii::$app->params['hotel_type'], ['class' => 'hotel_information_select', 'prompt' => '请选择酒店类型']) ?>
                                <i class="jd_type"></i>
                            </li>

                            <li class="wire"></li>
                            <li class="user-backend-form">
                                <i>*&nbsp;&nbsp;</i>
                                <span>省/市/区：</span>
                                <?= Html::activeDropDownList($model, 'province', $provice, ['class' => 'hotel_information_select region', 'prompt' => '请选择省份', 'id' => 'region1','level'=>2]) ?>
                                <?= Html::activeDropDownList($model, 'city', $city, ['class' => 'hotel_information_select region', 'prompt' => '请选择城市', 'id' => 'region2','level'=>3]) ?>
                                <?= Html::activeDropDownList($model, 'area', $area, ['class' => 'hotel_information_select region', 'prompt' => '请选择城市', 'id' => 'region3','level'=>4]) ?>
                                <i class="tishi"></i>
                            </li>
                            <li>
                                <i>*&nbsp;&nbsp;</i>
                                <span>酒店地址：</span>
                                <!--<input class="grogshop" type="" name="" id="" value="" />
                                <input id="grogshop_position" type="button" name="" id="" value="自动定位" />-->

                            </li>
                            <li style="height:auto;">
                                <i style="width:15px;height:5px;float: left;"></i>
                                <span style="float:left;">地理位置：</span>
                                <div style="float:left;position: relative;" class="grogshop_map">
                                    <div id="map" style="width:100%;height:480px;margin:0 auto;"></div>
                                    <div id="tip">
                                        <input type="text" id="pac-input" name="Hotel[address]" value="<?=$model->address?>" onblur="pacinput()" placeholder="请输入关键字：(选定后搜索)" style="width:770px" autocomplete="off" />

                                        <script>
                                            function pacinput() {
                                                if ($("#pac-input").val() != "") {
                                                    $(".address_tip").text("")
                                                }
                                            }
                                        </script>

                                    </div>

                                </div>
                                <i class="maphint" style="margin-left:52px;"></i>

                                <div style="clear: both;"></div>
                                <input type="hidden" name="Hotel[longitude]" id="lng" style="width: 100px;" value="<?=$model->longitude?>"/>
                                <input type="hidden" name="Hotel[latitude]" id="lat" style="width: 100px;" value="<?=$model->latitude?>"/>
                                <input type="hidden" name="Hotel[address1]" id="address" style="width: 100px;" value="<?=$model->address?>"/>
                            </li>
                            <li>
                                <i>*&nbsp;&nbsp;</i>
                                <span>前台电话：</span>
                                <input class="grogshop_code" type="" id="phonearea" name="Hotel[mobile_area]" value="<?=$model->mobile_area?>" onblur="phone()"><b style="color:#ccc;">—</b><input class="grogshop_phone" id="phpnebody" type="" name="Hotel[mobile]" value="<?=$model->mobile?>" onblur="phone()"><i class="phonehint"></i>
                            </li>
                            <li>
                                <i style="width:15px;height:5px;float: left;"></i>
                                <span>酒店传真：</span>
                                <input class="grogshop_code" type="" name="Hotel[fax_area]" onblur="fax()" id="fax" value="<?=$model->fax_area?>"><b style="color:#ccc;">—</b><input class="grogshop_phone" type="" name="Hotel[fax]" id="faxbody" value="<?=$model->fax?>" onblur="fax()"><i class="faxtishi"></i>
                            </li>
                            <li>
                                <i style="width:15px;height:5px;float: left;"></i>
                                <span>邮编：</span>
                                <input onblur="code()" type="" name="Hotel[postcode]" id="code" value="<?=$model->postcode?>">
                                <i class="code_hint"></i>
                            </li>
                            <li class="wire"></li>
                            <li>
                                <i>&nbsp;&nbsp;&nbsp;</i>
                                <span>开业年份：</span>
                                <input id="grogshop_year" type="" name="Hotel[opening_year]" value="<?=$model->opening_year?>" onkeyup="value=value.replace(/[^1234567890-]+/g,'')" maxlength="4"> <b class="unit">年</b>
                            </li>
                            <li>
                                <i>&nbsp;&nbsp;&nbsp;</i>
                                <span>最新装修：</span>
                                <input id="grogshop_year" type="" name="Hotel[renovation_year]" value="<?=$model->renovation_year?>" onkeyup="value=value.replace(/[^1234567890-]+/g,'')" maxlength="4"> <b class="unit">年</b>
                            </li>
                            <li>
                                <i>&nbsp;&nbsp;&nbsp;</i>
                                <span>客房总数：</span>
                                <input id="grogshop_year" type="" name="Hotel[total_stock]" value="<?=$model->total_stock?>" onkeyup="value=value.replace(/[^1234567890-]+/g,'')" maxlength="4"> <b class="unit">间</b>
                            </li>
                            <li>
                                <i class="left">*&nbsp;&nbsp;</i>
                                <span class="left">酒店简介：</span>
                                <textarea class="text left" name="Hotel[introduction]" id="brief" onblur="brief()" rows="" cols=""><?=$model->introduction?></textarea>
                                <i class="briefhint"></i>
                            </li>
                            <div style="clear: both;"></div>
                            <li>
                                <i class="left">&nbsp;&nbsp;&nbsp;</i>
                                <span class="left">酒店特色：</span>
                                <textarea class="text left" name="Hotel[feature]" rows="" cols=""><?=$model->feature?></textarea>

                            </li>
                            <div style="clear: both;"></div>
                        </ul>
                        <div class="message-footer">
                            <input class="message-footer-save" style="margin-bottom: 20px;" type="button" name="" onclick="save()" id="" value="保存并继续">
                            <!--<input class="message-footer-cancel" type="button" name="" id="" value="取消" />-->
                        </div>
                    </div>
                </div>
            </div>
            <?= Html::endForm();?>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <div class="control-sidebar-bg"></div>


<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="<?= Yii::$app->request->baseUrl ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/app.min.js"></script>
<!--new link-->
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/rummery.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/gobal.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
<!--地图-->
<link rel="stylesheet" href="http://cache.amap.com/lbs/static/main.css?v=1.0?v=1.0" />
<!--<script src="http://cache.amap.com/lbs/static/es5.min.js"></script>-->
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=617da82831edeaf0c65e7352adf79479&plugin=AMap.ToolBar"></script>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=617da82831edeaf0c65e7352adf79479"></script>
<script type="text/javascript"
        src="http://webapi.amap.com/maps?v=1.3&key=617da82831edeaf0c65e7352adf79479&plugin=AMap.Autocomplete,AMap.PlaceSearch,AMap.Geocoder"></script>
<script src="http://webapi.amap.com/ui/1.0/main.js"></script>

<script>
    $(".user-backend-form").on("change",".region",function(){
        var code = $(this).val();
        var level = $(this).attr("level");
        var _this = $(this);
        var nextLevel = parseInt(level)+1;
        if(code==""){
            $(this).nextAll().find("option").remove();
            if(level==2){
                $("#region"+level).append("<option value=''>请选择城市</option>");
                $("#region"+nextLevel).append("<option value=''>请选择区县</option>");
            }
            if(level==3){
                $("#region"+level).append("<option value=''>请选择区县</option>");
            }
        }
        $.ajax({
            type: 'GET',
            url: '<?= \yii\helpers\Url::toRoute(["region/getregion"])?>',
            data: {"level": level,"code":code},
            dataType: 'json',
            success: function (data) {
                if(data || data.length>0){
                    var html = "";
                    $.each(data, function(index, content){
                        html += '<option value="'+index+'">'+content+'</option>';
                    });
                    _this.nextAll().find("option").remove();
                    var sel = "#region"+level;
                    var sel2 = "#region"+nextLevel;
                    var label = "";
                    var nextlabel = "";
                    if(level==2){
                        label = "城市";
                        nextlabel = "区县";

                    }
                    if(level==3){
                        label = "区县";
                        nextlabel = "区县";
                    }

                    $(sel).append("<option value=''>请选择"+label+"</option>");
                    $(sel).append(html);
                    $(sel2).append("<option value=''>请选择"+nextlabel+"</option>");
                }
            },/*
             error: function (XMLHttpRequest, textStatus, errorThrown) {

             }*/
        });
        /*  else{
          if(level==2){
                var html = '<select id="region2" class="hotel_information_select region" name="Hotel[city]" level="3"><option value="0">请选择城市</option></select>';
                $(this).after();
            }
        }*/
    });
</script>


<!--高德地图-->
<script>
    $(function () {
        var listen;
        var gdclick;
        $('#pac-input').focus(function () {
            //var country_code = $('#bank_country option:selected').val();
            var prov_code = $('#region1 option:selected').val();
            var city_code = $('#region2 option:selected').val();
            var area_code = $('#region3 option:selected').val();
//                        console.log(country_code);
//                        console.log(prov_code);
            if (parseInt(prov_code) > 0 && parseInt(city_code) > 0 && parseInt(area_code) > 0) {
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

        $('#region1').change(function () {
            document.getElementById("lng").value = ''
            document.getElementById("lat").value = '';
            document.getElementById("address").value = '';
            document.getElementById("pac-input").value = '';
            $("#pac-input").val('');
            $('.pac1').show();
            $('.pac').hide();
            var name = $('#region1 option:selected').html();

//                            initGDmap();
            $('#map1').hide();
            map.setCity(name);
            $('#map').show();

        })
        $('#region2').change(function () {
            document.getElementById("lng").value = ''
            document.getElementById("lat").value = '';
            document.getElementById("address").value = '';
            $('.pac1').show();
            $('.pac').hide();
            var name = $('#region2 option:selected').val();

            restMap();
            $('#map1').hide();
            map.setCity(name);
            $('#map').show();

            map.setCity(name);
        })
        $('#region3').change(function () {
            document.getElementById("lng").value = ''
            document.getElementById("lat").value = '';
            document.getElementById("address").value = '';
            var name = $('#region3 option:selected').html();
            var city_name = $('#region2 option:selected').html();


            $('#pac-input').val('');
            $('#doornum').val('');
            $('.pac1').hide();
            $('.pac').show();
//                            initGDmap();
            AMap.event.addListener(map, "click", _onClick); //绑定事件，返回监听对象
            $('#map1').hide();
            map.setCity(city_name + name);
            $('#map').show();

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

        $('#region1').change(function () {
            document.getElementById("lng").value = ''
            document.getElementById("lat").value = '';
            document.getElementById("address").value = '';
            var country_code = $('#region1 option:selected').val();
            var name = $('#region1 option:selected').html();
            if (country_code == 0) {
                $('#map').show();
                $('#map1').hide();
                initGDmap();
            }

            initGDmap(1);
            $('#map1').hide();
            map.setCity(name);
            $('#map').show();

        })
    })
    function restMap() {
        lat =<?php echo $model['latitude'] ?>;
        lng =<?php echo $model['longitude'] ?>;
        map = new AMap.Map("map", {
            resizeEnable: true,
            zoom: 15,//地图显示的缩放级别
            center: [lng, lat]
        });
        AMap.event.removeListener(gdclick);
    }
    function initGDmap() {
        lat =<?php echo $model['latitude'] ?>;
        lng =<?php echo $model['longitude'] ?>;
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
                    /*document.getElementById("pac-input").value = result.regeocode.formattedAddress;*/
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
                    document.getElementById("address").value   = result.regeocode.formattedAddress;
                    /*document.getElementById("pac-input").value = result.regeocode.formattedAddress;*/
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
        initGDmap();
       /* var old_country = $('.old_country').val();
        if (old_country == 10001) {
            initGDmap();
        }else{
            $('.pac1').show();
            $('.pac').hide();
            $('#map').hide();
//                            initMap();
            $('#map1').show();
            initMap();
            initMap();
        }
        geocoder_google = new google.maps.Geocoder();*/
//                    initMap();
    }
</script>
<!--高德地图-->


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>

