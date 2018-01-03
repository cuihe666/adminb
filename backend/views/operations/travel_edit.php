<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script type="text/javascript">
        var adminId = '<?=Yii::$app->user->getId();?>';
    </script>
    <link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/reset.css">
    <link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/common.css">
    <link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/zcoperation/css/travel_edit.css">
</head>
<body style="background: white;">
<div v-cloak class="main" id="main" style="height: 99%;">
    <div class="t_header">
        <h4>当前位置 : &nbsp;运营&nbsp;>&nbsp;<a href="<?= Url::toRoute('operations/operationslocat') ?>">运营位管理</a>&nbsp;>&nbsp;<span class="tite" v-if="ids == 12"> 旅游特惠</span><span class="tite" v-if="ids == 13">自定义专题活动</span><span class="tite" v-if="ids == 14">城市列表</span></h4>
    </div>
    <div class="conts clear">
        <p class="add_new">
            <a data-toggle="modal" v-if="ids != 14" @click="edit_click(0)"><span class="glyphicon glyphicon-plus" style="margin-right: 6px"></span>新增</a>
        </p>
        <table class="table table-bordered">
<!--            特惠-->
            <thead v-if="ids == 12">
                <td style="width: 5%" class="td1">序号</td>
                <td style="width: 17%" class="td2">更改时间</td>
                <td style="width: 17%" class="td3">开始时间</td>
                <td style="width: 17%" class="td4">结束时间</td>
                <td style="width: 6%" class="td5">状态</td>
                <td style="width: 8%" class="td6">操作人</td>
                <td style="width: 20%" class="td7">操作</td>
            </thead>
<!--            自定义-->
            <thead v-if="ids == 13">
                <td style="width: 5%" class="td1">序号</td>
                <td style="width: 15%" class="td2">专题标题</td>
                <td style="width: 15%" class="td3">更改时间</td>
                <td style="width: 15%" class="td4">开始时间</td>
                <td style="width: 15%" class="td5">结束时间</td>
                <td style="width: 5%" class="td6">状态</td>
                <td style="width: 10%" class="td7">操作人</td>
                <td style="width: 20%" class="td8">操作</td>
            </thead>
<!--            城市列表-->
            <thead v-if="ids == 14">
                <td style="width: 10%" class="td1">位置名称</td>
                <td style="width: 30%" class="td2">描述</td>
                <td style="width: 20%" class="td3">最后修改时间</td>
                <td style="width: 20%" class="td4">最后操作人</td>
                <td style="width: 20%" class="td5">操作</td>
            </thead>
<!--            内容-->
            <tr v-for="(val, index) in page_type[ids]">
<!--                旅行特惠-->
                <td v-if="ids == 12">{{index + 1}}</td>
                <td v-if="ids == 12">{{change_time(val.updateTime, "sfm")}}</td>
                <td v-if="ids == 12">{{change_time(val.startTime, "sfm")}}</td>
                <td v-if="ids == 12">{{change_time(val.endTime, "sfm")}}</td>
                <td v-if="ids == 12" class="use_state">
                    <span v-if="val.enabled == 0">禁用</span>
                    <span v-if="val.enabled == 1">使用</span>
                </td>
                <td v-if="ids == 12">{{val.userName}}</td>
                <td v-if="ids == 12">
                    <a>
                        <span v-if="val.enabled == 1" @click="dele_click($event, index)">禁用</span>
                        <span v-if="val.enabled == 0" @click="dele_click($event, index)">使用</span>
                    </a>
                    <a @click="edit_click(1, 0, $event)">编辑</a>
                    <a @click="dele_click($event, index)">删除</a>
                    <input type="hidden" :value="val.id"/>
                </td>
<!--                自定义专题活动-->
                <td v-if="ids == 13">{{index + 1}}</td>
                <td v-if="ids == 13">{{val.title}}</td>
                <td v-if="ids == 13">{{change_time(val.updateTime, "sfm")}}</td>
                <td v-if="ids == 13">{{change_time(val.startTime, "sfm")}}</td>
                <td v-if="ids == 13">{{change_time(val.endTime, "sfm")}}</td>
                <td v-if="ids == 13" class="use_state">
                    <span v-if="val.enabled == 0">禁用</span>
                    <span v-if="val.enabled == 1">使用</span>
                </td>
                <td v-if="ids == 13">{{val.userName}}</td>
                <td v-if="ids == 13">
                    <a>
                        <span v-if="val.enabled == 1" @click="dele_click($event, index)">禁用</span>
                        <span v-if="val.enabled == 0" @click="dele_click($event, index)">使用</span>
                    </a>
                    <a @click="edit_click(1, 0, $event)">编辑</a>
                    <a @click="dele_click($event, index)">删除</a>
                    <input type="hidden" :value="val.id"/>
                </td>
<!--                旅行城市列表页-->
                <td v-if="ids == 14">{{val.title}}</td>
                <td v-if="ids == 14">{{val.subtitle}}</td>
                <td v-if="ids == 14">{{change_time(val.updateTime, "sfm")}}</td>
                <td v-if="ids == 14">{{val.userName}}</td>
                <td v-if="ids == 14">
                    <a data-toggle='modal' @click="edit_click(1, val.id, $event)">编辑</a>
                    <input type="hidden" :value="val.id"/>
                </td>
            </tr>
        </table>
    </div>
<!--    弹框开始-->
    <!--// 禁用、使用、删除弹框-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="cont">确定要<span class="opt"></span>该条数据吗？</div>
                <div class="modal-footer">
                    <span  id="savebut1" style="margin-right: 60px;color: white;" @click="submit_click($event)"  data-dismiss="modal">确定</span>
                    <span data-dismiss="modal" style="color: white;">取消</span>
                    <input type="hidden" name="">
                    <input type="hidden" name="">
                </div>
            </div>
        </div>
    </div>
<!--    // 城市列表编辑弹框-->
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    编辑<span></span>热门城市
                </div>
                <ul class="cont clear">
                    <li v-for="i in 12">
                        <span>城市名称</span>
                        <input class="class-name" type="text" placeholder="前台展示的文案"/>
                        <select class="provence" @change="pro_change(i, $event)">
                            <option v-if="is_china == 0" value="">省</option>
                            <option v-if="is_china == 0" v-for="re in pro_res" :value="re.cityCode" >{{re.cityName}}</option>
                            <option v-if="is_china == 1" value="">海外国家</option>
                            <option v-if="is_china == 1" v-for="re in country_res" :value="re.cityCode" >{{re.cityName}}</option>
                        </select>
                        <select class="city" >
                            <option v-if="is_china == 0" value="">市</option>
                            <option v-if="is_china == 1" value="">城市</option>
                            <option v-for="item in city_res[i].city_res" :value="item.cityCode">{{item.cityName}}</option>
                        </select>
                        <input type="hidden" value="" class="citylist_id"/>
                    </li>
                </ul>
                <div class="modal-footer">
                    <span  id="savebut" style="margin-right: 100px;color: white;" @click="edit_submit(is_china)">确定</span>
                    <span data-dismiss="modal" style="color: white;">取消</span>
                    <input type="hidden" name="" class="list_id">
                    <input type="hidden" name="">
                </div>
            </div>
        </div>
    </div>
<!--    旅行特惠、自定义专题活动弹窗-->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="tit">新增</span>
                    <button @click="add_product()" style="margin-left: 20px;background: #1888F8;padding: 4px 10px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;"><span class="glyphicon glyphicon-plus" style="color: white;">新增</span></button>
                </div>
                <ul class="cont clear">
                    <li class="li1">
                        <span>生效日期</span>
                        <input id="date_start" name="" placeholder="请选择开始日期" value="" class="Wdate" type="text" onfocus="var date_end=$dp.$('date_end');WdatePicker({readOnly:true,minDate: '%y-%M-{%d}',onpicked:function(){date_end.focus()},dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
                        <span>至</span>
                        <input id="date_end" placeholder="请选择结束日期" class="Wdate" name="" value="" type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'date_start\',{d:+1})}',dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" />
                    </li>
                    <li v-if="ids == 13" class="li3">
                        <span>专题标题名称</span>
                        <input class="tit-name" type="text" placeholder="最多10个字" maxlength="10"/>
                    </li>
                    <li class="li2">
                        <select class="travel-type">
                            <option value="1">主题线路</option>
                            <option value="2">当地活动</option>
                        </select>
                        <span>产品ID</span>
                        <input class="product-id" type="text" placeholder=""/>
                        <input type="hidden" value="" class="operationProductId"/>
                        <input type="hidden" value="" class="editType"/>
                    </li>
                    <li v-if="ids == 13" class="li3">
                        <span>查看更多(H5链接)</span>
                        <input class="more-H5" type="text" />
                    </li>
                </ul>
                <div class="modal-footer">
                    <span style="margin-right: 100px;color: white;" @click="edit_submit()">确定</span>
                    <span data-dismiss="modal" style="color: white;">取消</span>
                    <input type="hidden" name="" class="subItemId">
                    <input type="hidden" name="">
                </div>
            </div>
        </div>
    </div>
<!--    弹框结束-->
    <!--loading图-->
    <div class="wrap1" style="position: absolute;left: 0;top: 0;background: rgba(250,251,250,0.6);width: 100%;height: 99%;text-align: center;padding-top: 15%;box-sizing: border-box">
        <img src="<?= Yii::$app->request->baseUrl ?>/zcoperation/img/loading.gif"/>
    </div>
</div>

<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/jquery.min.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/newbase.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/layer/layer.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/vue.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/custorm/travel_edit.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/zcoperation/js/lib/My97DatePicker/WdatePicker.js"></script>
</body>
</html>