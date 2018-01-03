<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '基本信息';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\ScrollAsset::register($this);
?>

<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

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
    /*2017年5月4日22:04:24 zjl */
    .rummery_tab>li>a { cursor: default;}
</style>


<body class="hold-transition skin-blue sidebar-mini">


<!-- Content Wrapper. Contains page content -->
<div class="wrapper-content animated fadeInRight" style="background-color: #F2F2F2;">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <ul class="rummery_tab clearfix">
            <!--                2017年5月4日22:04:45 zjl -->
            <li class="current col-sm-8"><a href="javascript:;">酒店信息</a></li>
            <li class="col-sm-8"><a href="javascript:;">酒店政策</a></li>
            <li class="col-sm-8"><a href="javascript:;">服务设施</a href="###"></li>
            <li class="col-sm-8"><a href="javascript:;">房型管理</a></li>
            <li class="col-sm-8"><a href="javascript:;">房态房价设置</a></li>
            <li class="col-sm-8"><a href="javascript:;">图片管理</a></li>
            <li class="col-sm-8"><a href="javascript:;">关联供应商</a></li>
            <li class="col-sm-8"><a href="javascript:;">联系人信息</a></li>
        </ul>
        <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'hotel-form']) ?>
        <div class="rummery_con">
            <div class="rummery_item rummery_detail">
                <div class="xhh_conent hotel_information">
                    <ul class="conent-message">
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>酒店名称：</span>
                            <input class="grogshop" type="" name="Hotel[complete_name]" id="bankname" maxlength="20" value="" onblur="hotelname($('#bankname'),$('.bankname_b'));">
                            <b class="hotel_information_tips bankname_b">请输入酒店的完整名称</b>
                        </li>
                        <li>
                            <i style="width:15px;height:5px;float: left;"></i>
                            <span>酒店简称：</span>
                            <input type="" name="Hotel[short_name]" id="hostshort" value="" onblur="hostshorts($('#bankname'),$('.bankname_b'));">
                            <b class="hostshort_b">请输入酒店的简称，不能超过10个字符</b>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>酒店类型：</span>
                            <?= Html::activeDropDownList($model, 'type', Yii::$app->params['hotel_type'], ['class' => 'hotel_information_select', 'prompt' => '请选择酒店类型']) ?>
                            <i class="jd_type"></i>
                        </li>
                        <!--<li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>等&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;级：</span>
                            <select class="hotel_information_select" name="">
                                <option value="浪漫主题">浪漫主题</option>
                                <option value="品牌连锁">品牌连锁</option>
                                <option value="经济型">经济型</option>
                                <option value="三星/舒适">三星/舒适</option>
                                <option value="四星/高档">四星/高档</option>
                                <option value="五星/豪华">五星/豪华</option>
                                <option value="酒店式公寓">酒店式公寓</option>
                            </select>
                        </li>-->
                        <li class="wire"></li>
                        <li class="user-backend-form">
                            <i>*&nbsp;&nbsp;</i>
                            <span>省/市/区：</span>
                            <?= Html::activeDropDownList($model, 'province', $provice, ['class' => 'hotel_information_select region', 'prompt' => '请选择省份', 'id' => 'region1','level'=>2]) ?>
                            <select class="hotel_information_select region" id="region2" name="Hotel[city]" level="3">
                                <option value="0" selected="selected">请选择城市</option>
                            </select>
                            <select class="hotel_information_select region" id="region3" name="Hotel[area]" level="4">
                                <option value="0" selected="selected">请选择区域</option>
                            </select>

                            <i class="tishi"></i>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>酒店地址：</span>
                            <input class="grogshop" type="" name="" id="" value="" />
                            <input id="grogshop_position" type="button" name="" id="" value="自动定位" />
                        </li>
                        <li>
                            <i style="padding-right: 15px;"></i>
                            <span>经纬度：</span>
                            <input type="text" style="width: 700px" name="Hotel[Lati_Long_tude]" id="ccc_ys" value="" placeholder="  填写经纬度样例：116.375652,116.460437（经度 + 纬度，中间用英文逗号隔开，错误信息将不会记录入库）"/>
                            <span style="color: red;padding-left: 10px;" id="Lati_Long_tude_error_note"></span>
                            <script>
                                $("#ccc_ys").blur(function () {
                                    var str = $(this).val();
                                    if (str != '') {//填写经纬度
                                        if (str.indexOf(',') >= 0 ) {//包含有
                                            $("#Lati_Long_tude_error_note").html("");
                                        } else {//未包含有
                                            $("#Lati_Long_tude_error_note").html("经纬度填写格式有误！");
                                        }
                                    } else {//没有填写经纬度
                                        $("#Lati_Long_tude_error_note").html("");
                                    }
                                });
                            </script>
                        </li>
                        <li style="height:auto;">
                            <i style="width:15px;height:5px;float: left;"></i>
                            <span style="float:left;">地理位置：</span>
                            <div style="float:left;position: relative;" class="grogshop_map">
                                <div id="map" style="width:100%;height:480px;margin:0 auto;"></div>
                                <div id="tip" style="width:600px;">
                                    <input type="text" id="pac-input" name="Hotel[address]" onblur="mapeg()" placeholder="请输入关键字：(选定后搜索)" autocomplete="off">

                                </div>
                                <span id="tip_span" style="background-color:#fff;padding-left:10px;padding-right:10px;position:absolute;font-size:12px;border-radius:3px;border:1px solid #ccc;line-height:30px;top: -96px; width: 70px;  right: 110px; cursor: pointer; ">自动定位</span>

                            </div>

                            <i class="maphint" style="margin-left:52px;"></i>

                            <div style="clear: both;"></div>
                            <input type="hidden" name="Hotel[longitude]" id="lng" style="width: 100px;" value=""/>
                            <input type="hidden" name="Hotel[latitude]" id="lat" style="width: 100px;" value=""/>
                            <input type="hidden" name="Hotel[address1]" id="address" style="width: 100px;" value=""/>
                            <input type="hidden" name="city_code_n" id="city_code_n" style="width: 100px;" value="" />
                        </li>
<!--                        <li style="height: auto; position: relative">-->
<!--                            <div style="float: left;width: 90px;height: 40px">-->
<!--                                <i style="color: red">*&nbsp;&nbsp;</i>-->
<!--                                <span>交通信息：</span>-->
<!--                            </div>-->
<!--                            <span style="width:auto;">-->
<!--                                <table>-->
<!--                                    <thead>-->
<!--                                        <tr class="traffic-info">-->
<!--                                            <td style="width: 137px">地点类别<input type="button" id="add-traffic-info-btn" value="新增"/></td>-->
<!--                                            <td style="width: 155px">名称/位置</td>-->
<!--                                            <td style="width: 91px">距离</td>-->
<!--                                            <td style="width: 251px">如何到达酒店</td>-->
<!--                                            <td style="width: 126px">操作</td>-->
<!--                                        </tr>-->
<!--                                    </thead>-->
<!--                                    <tbody id="traffic-tbody">-->
<!--                                        <tr class="traffic-info traffic-info-td">-->
<!--                                            <td>-->
<!--                                                <select name="location">-->
<!--                                                    <option value="0">请选择地点类别</option>-->
<!--                                                    <option value="1">机场</option>-->
<!--                                                    <option value="2">火车站/汽车站</option>-->
<!--                                                    <option value="3">市中心</option>-->
<!--                                                </select>-->
<!--                                            </td>-->
<!--                                            <td>-->
<!--                                                <input type="text" name="traffic-name-or-location" style="border: none; width: 90%">-->
<!--                                            </td>-->
<!--                                            <td>-->
<!--                                                <input type="text" name="traffic-distance" style="border: none; width: 60%">Km-->
<!--                                            </td>-->
<!--                                            <td>-->
<!--                                                <input type="text" name="traffic-arrive-hotel" style="border: none;width: 90%">-->
<!--                                            </td>-->
<!--                                            <td>-->
<!--                                                <input type="button" class="traffic-save-btn" value="保存">-->
<!--                                                <input type="button" class="traffic-del-btn" value="删除">-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                    </tbody>-->
<!--                                </table>-->
<!--                            </span>-->
<!--                            <script>-->
<!--                                /*交通信息start*/-->
<!--                                $(function(){-->
<!--                                    // 添加交通信息-->
<!--                                    $('body').on('click', '#add-traffic-info-btn', function () {-->
<!--                                        $('#traffic-tbody').append('<tr class="traffic-info traffic-info-td">\n' +-->
<!--                                            '                                            <td>\n' +-->
<!--                                            '                                                <select name="location">\n' +-->
<!--                                            '                                                    <option value="0">请选择地点类别</option>\n' +-->
<!--                                            '                                                    <option value="1">机场</option>\n' +-->
<!--                                            '                                                    <option value="2">火车站/汽车站</option>\n' +-->
<!--                                            '                                                    <option value="3">市中心</option>\n' +-->
<!--                                            '                                                </select>\n' +-->
<!--                                            '                                            </td>\n' +-->
<!--                                            '                                            <td>\n' +-->
<!--                                            '                                                <input type="text" name="traffic-name-or-location" style="border: none; width: 90%">\n' +-->
<!--                                            '                                            </td>\n' +-->
<!--                                            '                                            <td>\n' +-->
<!--                                            '                                                <input type="text" name="traffic-distance" style="border: none; width: 60%">Km\n' +-->
<!--                                            '                                            </td>\n' +-->
<!--                                            '                                            <td>\n' +-->
<!--                                            '                                                <input type="text" name="traffic-arrive-hotel" style="border: none;width: 90%">\n' +-->
<!--                                            '                                            </td>\n' +-->
<!--                                            '                                            <td>\n' +-->
<!--                                            '                                                <input type="button" class="traffic-save-btn" value="保存">\n' +-->
<!--                                            '                                                <input type="button" class="traffic-del-btn" value="删除">\n' +-->
<!--                                            '                                            </td>\n' +-->
<!--                                            '                                        </tr>');-->
<!--                                    });-->
<!--                                    // 删除交通信息-->
<!--                                    $('body').on('click', '.traffic-del-btn', function (event) {-->
<!--                                        /*判断只剩一个就返回*/-->
<!--                                        if($('.traffic-info-td').length == '1'){-->
<!--                                            return false;-->
<!--                                        }-->
<!--                                        $(this).parent().parent().remove();-->
<!--                                    });-->
<!---->
<!--                                });-->
<!---->
<!--                                /*交通信息end*/-->
<!--                            </script>-->
<!--                        </li>-->
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>前台电话：</span>

                                <span style="width:auto;">
                                    <input type="radio" name="Hotel[mobile_type]" id="radio1" style="width:13px;margin-right:5px;" value="0" >座机：
                                    <input class="grogshop_code" type="text" id="phonearea" name="Hotel[mobile_area]"  onblur="areaNum()" disabled="disabled"><b style="color:#ccc;">—</b><input class="grogshop_phone" id="phpnebody" type="text" name="Hotel[mobile]" disabled="disabled" onblur="phone()"><i class="phonehint" style="color:red;font-size:12px;margin-left: 10px;"></i>
                                </span>
                        </li>
                        <li>
                            <i style="padding-right: 15px;"></i>
                            <span></span>

                                <span style="width:auto;">
                                    <input type="radio" id="radio2" name="Hotel[mobile_type]" style="width:13px;margin-right:5px;" class="shouji_inp" value="1">手机：
                                    <input type="text" style="width:150px;" class="shouji_sxh" onblur="mobile()" name="Hotel[mobile]" disabled="disabled" id="mobile_m">
                                </span>
                            <i style="color:red;font-size:12px;" class="tip_sxh"></i>
                        </li>

                        <li>
                            <i style="width:15px;height:5px;float: left;"></i>
                            <span>酒店传真：</span>
                            <input class="grogshop_code" type="" name="Hotel[fax_area]" onblur="faxs()" id="fax" value=""><b style="color:#ccc;">—</b><input class="grogshop_phone" type="" name="Hotel[fax]" id="faxbody" value="" onblur="faxs()"><i class="faxtishi"></i>
                        </li>
                        <li>
                            <i style="width:15px;height:5px;float: left;"></i>
                            <span>邮编：</span>
                            <input onblur="codes()" type="" name="Hotel[postcode]" id="code" value="">
                            <i class="code_hint"></i>
                        </li>
                        <li class="wire"></li>
                        <li>
                            <i style="width:15px;height:5px;float: left;"></i>
                            <span>开业年份：</span>
                            <input id="grogshop_year" type="" name="Hotel[opening_year]" value="" onkeyup="value=value.replace(/[^1234567890-]+/g,'')" maxlength="4"> <b class="unit">年</b>
                        </li>
                        <li>
                            <i style="width:15px;height:5px;float: left;"></i>
                            <span>最新装修：</span>
                            <input id="grogshop_year" type="" name="Hotel[renovation_year]" value="" onkeyup="value=value.replace(/[^1234567890-]+/g,'')" maxlength="4"> <b class="unit">年</b>
                        </li>
                        <li>
                            <i>&nbsp;&nbsp;&nbsp;</i>
                            <span>客房总数：</span>
                            <input id="grogshop_year" type="" name="Hotel[total_stock]" value="" onkeyup="value=value.replace(/[^1234567890-]+/g,'')" maxlength="4"> <b class="unit">间</b>
                        </li>
                        <li>
                            <i class="left">*&nbsp;&nbsp;</i>
                            <span class="left">酒店简介：</span>
                            <textarea class="text left" name="Hotel[introduction]" id="brief" onblur="briefs()" rows="" cols=""></textarea>
                            <i class="briefhint"></i>
                        </li>
                        <div style="clear: both;"></div>
                        <li>
                            <i class="left">&nbsp;&nbsp;&nbsp;</i>
                            <span class="left">酒店特色：</span>
                            <textarea class="text left" name="Hotel[feature]" rows="" cols=""></textarea>

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
                    //_this.nextAll().remove();
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
            },
            /*
             error: function (XMLHttpRequest, textStatus, errorThrown) {

             }*/
        });
    });
</script>


<!--高德地图-->
<script>
    $(function () {
        var listen;
        $('#pac-input').focus(function () {
            var prov_code = $('#region1 option:selected').val();     //获取当前选择省份的code值
            var city_code = $('#region2 option:selected').val();     //获取当前选择城市的code值
            var area_code = $('#region3 option:selected').val();     //获取当前选择区域的code值
            if (parseInt(prov_code) > 0 && parseInt(city_code) > 0 && parseInt(area_code) > 0) {
                var auto = new AMap.Autocomplete({
                    input: "pac-input"       //绑定 详细地址输入框的id
                });
                listen = AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
            }
        })

        //当下拉选择省份时
        $('#region1').change(function () {
            document.getElementById("lng").value = '';            //清空经度
            document.getElementById("lat").value = '';            //清空维度
            document.getElementById("address").value = '';       //清空详细地址
            var name = $('#region1 option:selected').html();     //获取当前选中的省份的名称
            initGDmap();                  //初始化高德地图
            map.setCity(name);            //地图定位到当前选中的省份
            $('#map').show();

        });
        //当下拉选择城市时
        $(".user-backend-form").on("change","#region2",function(){
            document.getElementById("lng").value = '';           //清空经度
            document.getElementById("lat").value = '';           //清空维度
            document.getElementById("address").value = '';      //清空详细地址
            var name = $('#region2 option:selected').val();     //获取当前选中的城市的名称
            //获取当前城市的区号，为下面自动定位使用。
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['region/getcityno']) ?>",
                data: {
                    code:name,
                },
                success: function (data) {
                    $("#city_code_n").val(data);
                }
            })
            initGDmap();                  //初始化高德地图
            map.setCity(name);            //地图定位到当前选中的城市
            $('#map').show();
            //map.setCity(name);

        });
        //当下拉选择区域时
        $(".user-backend-form").on("change","#region3",function(){
            document.getElementById("lng").value = '';               //清空经度
            document.getElementById("lat").value = '';               //清空维度
            document.getElementById("address").value = '';          //清空详细地址
            var name = $('#region3 option:selected').html();       //获取当前选中的城市的名称
            var city_name = $('#region2 option:selected').html();  //获取当前选中的省份的名称
            initGDmap();                  //初始化高德地图
            AMap.event.addListener(map, "click", _onClick); //绑定事件，返回监听对象
            map.setCity(city_name + name);
            $('#map').show();
            map.setCity(name);
        })
    })

    //初始化高德地图
    function initGDmap() {
        document.getElementById("lng").value = ''
        document.getElementById("lat").value = '';
        map = new AMap.Map("map", {
            resizeEnable: true,
            zoom: 10,//地图显示的缩放级别
        });

        var marker = new AMap.Marker({
//            map: map,
//            position: [longitude, latitude],
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
        //geocoder_google = new google.maps.Geocoder();
//                    initMap();
    }


    $("#tip_span").on("click",function(){
        var keywords = $(this).siblings("#tip").find("#pac-input").val();
        //alert(keywords);
        /* map = new AMap.Map("map", {
         resizeEnable: true,
         zoom: 13,//地图显示的缩放级别
         center: [lng, lat]
         });*/
        map.clearMap();    //清除地图上的所有标记
        var geocoder = new AMap.Geocoder({
            city: $("#city_code_n").val(), //城市，默认：“全国”
            radius: 1000 //范围，默认：500
        });
        //地理编码,返回地理编码结果
        geocoder.getLocation(keywords, function(status, result) {
            console.log(result);
            if (status === 'complete' && result.info === 'OK') {
                var resultStr = "";
                //地理编码结果数组
                var geocode = result.geocodes;
                for (var i = 0; i < geocode.length; i++) {
                    //拼接输出html
                    resultStr += "";
                    addMarker(i, geocode[i]);
                }
                map.setFitView();
                document.getElementById("lng").value = geocode[0].location.getLng();
                document.getElementById("lat").value = geocode[0].location.getLat();
                document.getElementById("address").value   = keywords;
                document.getElementById("pac-input").value = keywords;

                //document.getElementById("result").innerHTML = resultStr;
            }
        });
        function addMarker(i, d) {
            var marker = new AMap.Marker({
                map: map,
                position: [ d.location.getLng(),  d.location.getLat()]
            });
            var infoWindow = new AMap.InfoWindow({
                autoMove: true,
                content: d.formattedAddress,
                offset: {x: 0, y: -30}
            });
            infoWindow.setContent(d.formattedAddress);
            infoWindow.open(map, marker.getPosition());
        }
    })

</script>
<!--高德地图-->


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
