<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/4/24
 * Time: 下午3:24
 */
use yii\helpers\Html;
use backend\assets\HotelAsset;


//
$this->title = '酒店供应商';
$this->params['breadcrumbs'][] = $this->title;
HotelAsset::register($this);
\backend\assets\VueAsset::register($this);
\backend\assets\HotelSupplierUploadAsset::register($this);

$error_info = Yii::$app->session->getFlash('error_info',[]);
\backend\assets\ScrollAsset::register($this);
?>

<style>
    [v-cloak]{
        display: none;
    }

    .del_button{
        position: absolute;
        right: 5px;
        top: 5px;
        line-height: normal;
        color: white;
        z-index: 999;
        cursor: pointer;
    }
    .del_button:hover{
        color: #ee5f5b;
    }
    .error_info{
        color: red;
        margin-left: 20px;
    }
    .uploader .filelist li{
        height:132px !important;
    }
    .uploader .filelist div.file-panel{
        bottom:27px;
    }
    .conent-message2>li{
        clear:both;
    }
    .conent-message li{
        height:auto;
    }
    /*2017年5月10日15:12:38酒店管理的资质管理页面供应商输入框大小*/
    #gys_hinese{
        width:415px;
    }
    .am-pinch-zoom img{ width: auto;}
</style>
<!-- 页面css -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/amaze/css/amazeui.css">
<script src="<?= Yii::$app->request->baseUrl ?>/amaze/js/amazeui.min.js"></script>



<?= \backend\widgets\ElementAlertWidget::widget() ?>

<section class="content" id="credential" v-cloak>
    <div class="rummery_top">
<!--        通用的导航头-->
        <?= \backend\widgets\HotelSupplierListWidget::widget([
            'current_url' => Yii::$app->controller->action->id,
            'body' => Yii::$app->params['hotel_supplier_nav'],
            'query' => Yii::$app->getRequest()->queryString,
        ]) ?>


        <div class="rummery_con">
            <form action="<?= \yii\helpers\Url::toRoute('hotel-supplier/credentials?id=').$supplier_id ?>" method="post" >


            <div class="rummery_item rummery_sevice" style="display: block;">
                <ul class="conent-message conent-message2">
                    <li>
                        <i>*&nbsp;&nbsp;</i>
                        <span style="width:152px;">供应商名称：</span>
                        <input type="" name="" id="gys_hinese" value="<?= $model->name ?>" placeholder="请输入供应商名称" disabled>
<!--                        <i class="gys_hinese_b">请认真填写</i>-->
                    </li>
                    <li style="height: 40px;">
                        <p class="left" style="width:131px;">
                            <i style="color:red;">*&nbsp;&nbsp;</i>
                            <span>协议有效期：</span>

                        </p>


                        <div class="input-append date left uplist" id="rili" data-date="2012-12-02" data-date-format="yyyy-dd-mm">
                            <input id="d422" name="start_time" value="<?= $model->start_time ?>" class="Wdate" type="text" onfocus="var d4312=$dp.$('d4312');WdatePicker({readOnly:true,onpicked:function(){d4312.focus()}})" placeholder="请设置起始日期" readonly="">至
                            <input id="d4312" class="Wdate" name="end_time" value="<?= $model->end_time ?>" type="text" placeholder="请设置结束日期" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'d422\')}',readOnly:true})" readonly="">
                            <input type="hidden" class="sxh-hidden">
                            <em id="date-em" style="color:red;margin-left: 20px;font-style: normal;"></em>
                        </div>


                    </li>

                    <li>
                        <div class="form-group" style="padding-top:30px;" id="picture_map2">
                            <div class="row left">
                                <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">营业执照展示</span>
                                <?php if(isset($error_info['business_license'])): ?>
                                    <i class="error_info" ><?=  $error_info['business_license'] ?></i>
                                <?php endif ?>
                            </div>
                            <div class="row" style="width:90%;margin:0 0 10px 145px;padding:0px;box-sizing:border-box;">
                                <div class="col-md-12">
                                    <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default"
                                        data-am-gallery="{ pureview: true }">

                                            <li style="width:200px;height: 150px;margin:0 20px 10px 0;padding:0;position: relative;" v-for="(item,index) in image_list.business_license">
                                                <div v-if="item.type == 'image'" class="am-gallery-item" style="width:100%;height:100%;">
                                                    <a v-bind:href="['http://img.tgljweb.com/' + item ]">
                                                        <img style="width:100%;height:100%;margin-right:20px;" v-bind:src="['http://img.tgljweb.com/' + item.url ]"/>
                                                    </a>
                                                </div>
                                                <i v-if="item.type == 'image'" class="del_button" style="color: silver" @click="delImage(index,'business_license')">删除</i>
                                                <div v-else class="list-group" style="text-align: center">
                                                    <a style="padding: 0px;height: 50px;white-space: nowrap;text-overflow: ellipsis;" href="javascript:;" class="list-group-item active">{{ item.name }}</a>
                                                    <a style="padding: 0px;height: 50px" :href="['http://img.tgljweb.com/' + item.url ]" target="_blank" class="list-group-item">下载</a>
                                                    <a style="padding: 0px;height: 50px" href="javascript:;" @click="delImage(index,'business_license')" class="list-group-item">删除</a>
                                                </div>
                                            </li>

                                    </ul>
                                </div>

                            </div>
                        </div>
                    </li>
                    <li style="height:auto;">
                        <p class="left" style="width:131px;">
                            <i style="color:red;">*&nbsp;&nbsp;</i>
                            <span>营业执照：</span>
                        </p>
                        <div id="wrapper" class="left uplist">
                            <div id="container" style="width: 536px;">
                                <div id="uploader" class="uploader">
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
                            </div>
                        </div>
                        <i class="zhizhao"></i>
                        <div style="clear: both;"></div>
                    </li>

                    <li>
                        <div class="form-group"  id="picture_map2">
                            <div class="row left">
                                <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">行业许可证展示</span>
                                <?php if(isset($error_info['license'])): ?>
                                    <i class="error_info" ><?=  $error_info['license'] ?></i>
                                <?php endif ?>
                            </div>
                            <div class="row mal" style="width:90%;margin:0 0 10px 145px;padding:0px;box-sizing:border-box;">
                                <div class="col-md-12">
                                    <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default"
                                        data-am-gallery="{ pureview: true }">

                                        <li style="width:200px;height: 150px;margin:0 20px 10px 0;padding:0;position: relative;" v-for="(item,index) in image_list.license">
                                            <div v-if="item.type == 'image'" class="am-gallery-item" style="width:100%;height:100%;">
                                                <a v-bind:href="['http://img.tgljweb.com/' + item ]">
                                                    <img style="width:100%;height:100%;margin-right:20px;" v-bind:src="['http://img.tgljweb.com/' + item.url ]"/>
                                                </a>
                                            </div>
                                            <i v-if="item.type == 'image'" class="del_button" style="color: silver" @click="delImage(index,'license')">删除</i>
                                            <div v-else class="list-group" style="text-align: center">
                                                <a style="padding: 0px;height: 50px;white-space: nowrap;text-overflow: ellipsis;" href="javascript:;" class="list-group-item active">{{ item.name }}</a>
                                                <a style="padding: 0px;height: 50px" :href="['http://img.tgljweb.com/' + item.url ]" target="_blank" class="list-group-item">下载</a>
                                                <a style="padding: 0px;height: 50px" href="javascript:;" @click="delImage(index,'license')" class="list-group-item">删除</a>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                            </div>
                        </div>
                    </li>
                    <li style="height:auto;">
                        <p class="left" style="width:131px;">
                            <i style="color:red;">*&nbsp;&nbsp;</i>
                            <span>特种行业许可证：</span>
                        </p>
                        <div id="wrapper2" class="left uplist">
                            <div id="container2" style="width: 536px;">

                                <div id="uploader2" class="uploader">
                                    <div class="queueList">
                                        <div id="dndArea2" class="placeholder">
                                            <div id="filePicker_click2" class="webuploader-container"><div class="webuploader-pick">点击选择图片</div><div id="rt_rt_1befdbp0412q4mp1b881129b95a" style="position: absolute; top: 20px; left: 358px; width: 168px; height: 44px; overflow: hidden; bottom: auto; right: auto;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div>
                                        </div>
                                        <ul class="filelist"></ul></div>
                                    <div class="statusBar" style="display:none;">
                                        <div class="progress" style="display: none;">
                                            <span class="text">0%</span>
                                            <span class="percentage" style="width: 0%;"></span>
                                        </div>
                                        <div class="info">共0张（0B），已上传0张</div>
                                        <div class="btns">
                                            <div id="filePicker_start2" class="webuploader-container"><div class="webuploader-pick">继续添加</div><div id="rt_rt_1befdbp051901p6ckrtl2l1j6hd" style="position: absolute; top: 0px; left: 0px; width: 1px; height: 1px; overflow: hidden;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div>
                                            <div class="uploadBtn state-pedding">开始上传</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <i class="xukezheng"></i>
                        <div style="clear: both;"></div>
                    </li>

                    <li>

                        <div class="form-group" id="picture_map2">
                            <div class="row left">
                                <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">协议展示</span>
                                <?php if(isset($error_info['agreement'])): ?>
                                    <i class="error_info" ><?=  $error_info['agreement'] ?></i>
                                <?php endif ?>
                            </div>
                            <div class="row mal" style="width:90%;margin:0 0 10px 145px;padding:0px;box-sizing:border-box;">
                                <div class="col-md-12">
                                    <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default"
                                        data-am-gallery="{ pureview: true }">

                                        <li style="width:200px;height: 150px;margin:0 20px 10px 0;padding:0;position: relative;" v-for="(item,index) in image_list.agreement">
                                            <div v-if="item.type == 'image'" class="am-gallery-item" style="width:100%;height:100%;">
                                                <a v-bind:href="['http://img.tgljweb.com/' + item ]">
                                                    <img style="width:100%;height:100%;margin-right:20px;" v-bind:src="['http://img.tgljweb.com/' + item.url ]"/>
                                                </a>
                                            </div>
                                            <i v-if="item.type == 'image'" class="del_button" style="color: silver" @click="delImage(index,'agreement')">删除</i>
                                            <div v-else class="list-group" style="text-align: center">
                                                <a style="padding: 0px;height: 50px;white-space: nowrap;text-overflow: ellipsis;" href="javascript:;" class="list-group-item active">{{ item.name }}</a>
                                                <a style="padding: 0px;height: 50px" :href="['http://img.tgljweb.com/' + item.url ]" target="_blank" class="list-group-item">下载</a>
                                                <a style="padding: 0px;height: 50px" href="javascript:;" @click="delImage(index,'agreement')" class="list-group-item">删除</a>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                            </div>
                        </div>
                    </li>

                    <li style="height:auto;">
                        <p class="left" style="width:131px;">
                            <i style="color:red;">*&nbsp;&nbsp;</i>
                            <span>合作协议：</span>
                        </p>
                        <div id="wrapper3" class="left uplist">
                            <div id="container3" style="width: 536px;">

                                <div id="uploader3" class="uploader">
                                    <div class="queueList">
                                        <div id="dndArea3" class="placeholder">
                                            <div id="filePicker_click3" class="webuploader-container"><div class="webuploader-pick">点击选择图片</div><div id="rt_rt_1befdbp091qnp1uvq1j8g1kbh1lakh" style="position: absolute; top: 20px; left: 358px; width: 168px; height: 44px; overflow: hidden; bottom: auto; right: auto;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div>
                                        </div>
                                        <ul class="filelist"></ul></div>
                                    <div class="statusBar" style="display:none;">
                                        <div class="progress" style="display: none;">
                                            <span class="text">0%</span>
                                            <span class="percentage" style="width: 0%;"></span>
                                        </div>
                                        <div class="info">共0张（0B），已上传0张</div>
                                        <div class="btns">
                                            <div id="filePicker_start3" class="webuploader-container"><div class="webuploader-pick">继续添加</div><div id="rt_rt_1befdbp0abkrdicslnev8fcvk" style="position: absolute; top: 0px; left: 0px; width: 1px; height: 1px; overflow: hidden;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div>
                                            <div class="uploadBtn state-pedding">开始上传</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <i class="xieyi"></i>
                        <div style="clear: both;"></div>
                    </li>


                    <li>
                        <div class="form-group"  >
                            <div class="row left">
                                <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">其他展示</span>
                                <?php if(isset($error_info['other'])): ?>
                                    <i class="error_info" ><?=  $error_info['other'] ?></i>
                                <?php endif ?>
                            </div>
                            <div class="row mal" style="width:90%;margin:0 0 10px 145px;padding:0px;box-sizing:border-box;">
                                <div class="col-md-12">
                                    <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2am-avg-md-3 am-avg-lg-4 am-gallery-default"
                                        data-am-gallery="{ pureview: true }">

                                        <li style="width:200px;height: 150px;margin:0 20px 10px 0;padding:0;position: relative;" v-for="(item,index) in image_list.other">
                                            <div v-if="item.type == 'image'" class="am-gallery-item" style="width:100%;height:100%;">
                                                <a v-bind:href="['http://img.tgljweb.com/' + item ]">
                                                    <img style="width:100%;height:100%;margin-right:20px;" v-bind:src="['http://img.tgljweb.com/' + item.url ]"/>
                                                </a>
                                            </div>
                                            <i v-if="item.type == 'image'" class="del_button" style="color: silver" @click="delImage(index,'other')">删除</i>
                                            <div v-else class="list-group" style="text-align: center">
                                                <a style="padding: 0px;height: 50px;white-space: nowrap;text-overflow: ellipsis;" href="javascript:;" class="list-group-item active">{{ item.name }}</a>
                                                <a style="padding: 0px;height: 50px" :href="['http://img.tgljweb.com/' + item.url ]" target="_blank" class="list-group-item">下载</a>
                                                <a style="padding: 0px;height: 50px" href="javascript:;" @click="delImage(index,'other')" class="list-group-item">删除</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>

                    </li>

                    <li style="height:auto;">
                        <p class="left" style="width:131px;">
                            <i style="color:red;">&nbsp;&nbsp;</i>
                            <span>其他：</span>
                        </p>
                        <div id="wrapper4" class="left uplist">
                            <div id="container4" style="width: 536px;">
                                <div id="uploader4" class="uploader webuploader-container">
                                    <div class="queueList">
                                        <div id="dndArea4" class="placeholder">
                                            <div id="filePicker_click4" class="webuploader-container"><div class="webuploader-pick">点击选择图片</div><div id="rt_rt_1befdbp0d1651lqdgs2cb213cho" style="position: absolute; top: 20px; left: 358px; width: 168px; height: 44px; overflow: hidden; bottom: auto; right: auto;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div>
                                        </div>
                                        <ul class="filelist"></ul></div>
                                    <div class="statusBar" style="display:none;">
                                        <div class="progress" style="display: none;">
                                            <span class="text">0%</span>
                                            <span class="percentage" style="width: 0%;"></span>
                                        </div>
                                        <div class="info">共0张（0B），已上传0张</div>
                                        <div class="btns">
                                            <div id="filePicker_start4" class="webuploader-container"><div class="webuploader-pick">继续添加</div><div id="rt_rt_1befdbp0e1df88mh11oq6401nl2r" style="position: absolute; top: 0px; left: 0px; width: 1px; height: 1px; overflow: hidden;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div>
                                            <div class="uploadBtn state-pedding">开始上传</div>
                                        </div>
                                    </div>
                                    <div id="rt_rt_1befdbovuibf1pf11cotqd9361" style="position: absolute; top: -802px; left: 381px; width: 168px; height: 44px; overflow: hidden; bottom: auto; right: auto;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </li>
                </ul>
                <div style="display: none;" id="input_hidden_block"></div>
                <div>
<!--                    <input type="button" class="zizhi_button message-footer-save" id="credential_submit" value="保存设置" onclick="baocun()">-->
<!--                    <input type="button" class="zizhi_button message-footer-save" value="保存设置">-->
                    <?= Html::submitButton('保存设置',['class' => 'zizhi_button message-footer-save']) ?>
                </div>
                <p style="font-size:13px;color:#ccc;margin-left: 200px;">
                    可上传的文件类型包括：图片、word、Excel、PPT、压缩文件等
                </p>
            </div>
            </form>

        </div>
    </div>


</section>

<script>
    var upload_type = 'hotelSupplier';
    var upload_id = '<?= $model->id ?>';
    var vm_credential = new Vue({
        el: '#credential',
        data: {
            msg : 'hello',
            image_list: {
                'business_license': <?= $model->business_license ?>,
                'license': <?= $model->license ?>,
                'agreement': <?= $model->agreement ?>,
                'other': <?= $model->other ?>
            },
            wait_to_upload: {
                "business_license":0,
                "license":0,
                "agreement":0,
                "other":0
            },
            k_v: {
                "business_license":"营业执照",
                "license":"特种行业许可证",
                "agreement":"协议展示",
                "other":"其他"
            }
        },
        methods: {
            delImage: function(index,name){
//                console.log(this.image_list[name]);
//                console.log(index)
//                console.log(name)
                var _self = this;
                this.$confirm('确定要删除吗？点击确定将直接删除','提示',{
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(function () {
                    var url = '/hotel-supplier/del-image?<?= Yii::$app->getRequest()->queryString ?>';
                    var post_body = {
                        index: index,
                        name: name
                    };
                    _self.requestBody(url,post_body,function(res){
                        if(res.data.code == 200){
                            _self.$message({
                                type: 'success',
                                message: '删除成功!'
                            });
                        }
                    })
                });
            },
            //使用的 http 请求方法
            requestBody: function (url,params,callback) {
                var _self = this;
                axios.post(url,params)
                    .then(function(res){
//                        console.log(res);
                        callback(res)
                        var index = res.data.msg.index;
                        var name = res.data.msg.name;
                        if(res.data.code == 200){
                            _self.delImageList(index,name);
                        }

                    })
                    .catch(function (error) {
//                        console.log(error)
                    })
            },
            delImageList: function(index,name){
                this.image_list[name].splice(index,1);
            },
            checkImg: function () {
                var data = this.wait_to_upload;
                var res = true;
//                var error_list = [];
//                //循环判定错误信息
//                console.log(data)
//                for(key in data){
//                    if(data[key] > 0){
//                        error_list.push("<" + this.k_v[key] + ">" + '有图片未上传,请先上传再提交');
//                        res = false;
//                    }
//                }

                if(!res){
                    var _self = this;
                    //由于同时打印的时候会导致弹窗重叠起来,添加了一个计时器
                    var timer = setInterval(function () {
                        if(error_list.length > 0){
                            var error = error_list.shift();
                            _self.alertInfo(error);
                        }else{
                            clearInterval(timer)
                        }
                    },200)
                }
                return res;
            },
            alertInfo: function(msg,offset){
                this.$notify({
                    title: '警告',
                    message: msg,
                    type: 'warning',
                    offset: offset
                });
            },
            //用于统计还有多少没上传的图片
            addNum: function(type){
                this.wait_to_upload[type] ++;
                console.log(this.wait_to_upload[type],'add',type,this.wait_to_upload)
            },
            delNum: function(type){
                this.wait_to_upload[type] = 0;
                console.log(this.wait_to_upload[type],'del',type,this.wait_to_upload)
            },
            //表单提交事件
            onSubmit: function(event){
                if(this.checkImg()){
                    //通过验证后的提交
                    event.returnValue = true;
                }
                return false;
            }
        },
        mounted: function(){
//            console.log(this.image_list);

        }

    })


</script>