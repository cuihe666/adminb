<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = '公司资质修改';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/auth_company.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/yanzheng.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/commodity-change/css/travel-activity-manage-change.css">
<script>
    var token = '<?php echo $token;?>';
</script>
<!--上传图片控件-->
<script src="http://cdn.staticfile.org/Plupload/2.1.1/plupload.full.min.js"></script>
<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/upload_img.js"></script>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/auth_company.css"/>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/reset.css"/>
<style>
    .address .add-address input.city1{ background:none; margin-top:12px; padding-left:0;}
    .region123{ margin-left:0; border:1px solid #efefef; border-top:0; margin-top:-11px; height: 330px; overflow-y: scroll; position:absolute; z-index:9; width:280px; background-color: #fff;bottom:215px;}

    /*.region123{ margin-left:0; border:1px solid #efefef; border-top:0; margin-top:-11px; height: 330px; overflow-y: scroll; position:absolute; z-index:9; width:280px; background-color: #fff; top:53px;}*/
    .region123 li{ height: 26px; line-height: 26px; cursor: pointer; padding-left:10px;z-index:100000}
    .address .add-address input.city1{ margin-right:0;}
    .company_r .company_ins,.mess-cont li input {
        color:#333
    }
    @media screen and (max-width:1220px){
        .region123{
            bottom:197px;
        }
    }
    .rignt-con ul>li{
       padding:8px;
    }

</style>
<style>
    #browse{
        background-color:transparent;
        border:1px solid #ccc;
        width:200px;
        height:150px;
        z-index:1;
        /*background:url(images/add_pic.png) no-repeat center center;
        background-size:50px;*/
    }
    .file{
        position:relative;
    }
    .file-list{
        position:absolute;
        left:0;
        top:0;
        width:200px;
        height:150px;

    }
    .file-list .add_img{
        width:200px;
        height:150px;
        z-index: 2;
    }
    .file-list .dele_img{
        position:absolute;
        right:0;
        top:0;
        width:20px;
        z-index:3;
    }
    .container {
        position:relative;
        width:200px;
        height:150px;
    }
    .container .jia_img{
        position:absolute;
        left:50%;
        top:50%;
        width:50px;
        transform: translate(-50%,-50%);
        -webkit-transform: translate(-50%,-50%);
        -o-transform: translate(-50%,-50%);
        -moz-transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
    }
</style>
<style>
    #browse0,#browse2,#browse3,#browse4,#browse5,#browse6,#browse7,#browse8{
        background-color:transparent;
        border:1px solid #ccc;
        width:200px;
        height:150px;
        z-index:1;
        /*background:url(images/add_pic.png) no-repeat center center;
        background-size:50px;*/
    }
    .file{
        position:relative;
    }
    .file-list,.file-list2,.file-list3,.file-list4,.file-list5,.file-list6,.file-list7,.file-list8{
        position:absolute;
        left:0;
        top:0;
        width:200px;
        height:150px;

    }
    .file-list .add_img,.file-list2 .add_img,.file-list3 .add_img,.file-list4 .add_img,.file-list5 .add_img,.file-list6 .add_img,.file-list7 .add_img,.file-list8 .add_img{
        width:200px;
        height:150px;
        z-index: 2;
    }
    .file-list .dele_img,.file-list2 .dele_img,.file-list3 .dele_img,.file-list4 .dele_img,.file-list5 .dele_img,.file-list6 .dele_img,.file-list7 .dele_img,.file-list8 .dele_img{
        position:absolute;
        right:0;
        top:0;
        width:20px;
        z-index:3;
    }
    .container,.container2,.container3,.container4,.container5,.container6,.container7,.container8 {
        position:relative;
        width:200px;
        height:150px;
    }
    .container .jia_img,.container2 .jia_img,.container3 .jia_img,.container4 .jia_img,.container5 .jia_img,.container6 .jia_img,.container7 .jia_img,.container8 .jia_img{
        position:absolute;
        left:50%;
        top:50%;
        width:50px;
        transform: translate(-50%,-50%);
        -webkit-transform: translate(-50%,-50%);
        -o-transform: translate(-50%,-50%);
        -moz-transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
    }
    .activity_description .file{ width:198px; height:145px;}
    .activity_description .add_img{ width:198px; height:145px; margin-left:0;}
    .activity_description li{border:0}
</style>
</head>
<body>
<div class="shenhe-sxh">
    <div class="left">
    </div>
    <div class="right">
        <?= Html::beginForm(Url::to('update-company'), 'post', ['enctype' => 'multipart/form-data']) ?>
        <div class="part_one mess-cont">
            <div class="top">
                <p style="width:200px">
                    <b>帐号:<?php echo $model->user->mobile ?></b>
                </p>
                <hr>
            </div>
            <div class="rignt-con activity_description">
                <ul>
                    <li class="clearfix">
                        <span class="title_l fl">公司注册地：</span>
                        <div class="company_r fl count">
                            <?php if ($model->isNewRecord){$model->reg_addr_type = 1; }?>
                            <div class="lxs_type">
                                <input type="radio" <?=($model->reg_addr_type == 1)?'checked':''?> disabled /><label for="lxs_type">中国大陆</label>
                            </div>
                            <div class="lxs_type">
                                <input type="radio" <?=($model->reg_addr_type == 2)?'checked':''?> disabled /><label for="lxs_type">港澳地区</label>
                            </div>
                            <div class="lxs_type">
                                <input type="radio" <?=($model->reg_addr_type == 3)?'checked':''?> disabled /><label for="lxs_type">中国台湾</label>
                            </div>
                            <div class="lxs_type">
                                <input type="radio" <?=($model->reg_addr_type == 4)?'checked':''?> disabled /><label for="lxs_type">海外</label>
                            </div>
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">公司注册国家省市：</span>
                        <div class="company_r fl tg_city1 count">
                            <input type="text" id="regcity" class="city1" name="TravelCompany[whole]" value="<?=($model && $model->reg_country && $model->reg_province && $model->reg_city)?\backend\models\DtCitySeas::getname([$model->reg_city,$model->reg_province,$model->reg_country]):(($model && $model->reg_country && $model->reg_province)?\backend\models\DtCitySeas::getname([$model->reg_province,$model->reg_country]):'')?>" style="width: 312px; padding-left:10px;float: left" maxlength="30" placeholder="请输入省市名称" autoComplete= "Off" />
                            <input type="hidden" name="TravelCompany[reg_country]" class="cityhid" value="<?=($model  && $model->reg_country && $model->reg_country)?$model->reg_country:''?>" tg=<?=($model && $model->reg_country)?"1":"0"?> id="country" />
                            <input type="hidden" name="TravelCompany[reg_province]" class="cityhid" value="<?=($model  && $model->reg_country && $model->reg_province)?$model->reg_province:''?>" tg=<?=($model && $model->reg_country && $model->reg_province)?"1":"0"?> id="prov" />
                            <input type="hidden" name="TravelCompany[reg_city]" class="cityhid" value="<?=($model  && $model->reg_country && $model->reg_city)?$model->reg_city:''?>" tg=<?=($model  && $model->reg_country && $model->reg_city)?"1":"0"?> id="city" />
                            <input type="hidden" name="TravelCompany[reg_county]" class="cityhid" value="<?=($model  && $model->reg_country && $model->reg_county)?$model->reg_county:''?>" tg=<?=($model  && $model->reg_country && $model->reg_city)?"1":"0"?> id="county" />
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">类型选择：</span>
                        <div class="company_r fl travel_agency">
                            <?php if ($model->isNewRecord){$model->group_type = 1; }?>
                            <div class="lxs_type lxs">
                                <input type="radio" <?=($model->group_type == 1)?'checked':''?> disabled /><label for="lxs_lxs">旅行社</label>
                            </div>
                            <div class="lxs_type notlxs">
                                <input type="radio" <?=($model->group_type == 2)?'checked':''?> disabled /><label for="lxs_notlxs">非旅行社</label>
                            </div>
                            <p style="color:#ccc">请根据您的实际情况选择对应的公司性质</p>
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">公司全称：</span>
                        <div class="company_r fl">
                            <?= Html::activeInput('text', $model, 'name', ['class' => 'ipt_long cmp_name ','maxlength'=>"50"]) ?>
                            <p style="color:#ccc">公司全称需与您的营业执照上公司注册名称完全一致</p>
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">公司地址：</span>
                        <div class="company_r fl">
                            <?= Html::activeInput('text', $model, 'company_address', ['class' => 'ipt_long cmp_address ','maxlength'=>"50"]) ?>
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">公司介绍：</span>
                        <div class="company_r fl">
                            <?= Html::activeTextarea($model, 'recommend', ['class' => 'company_ins','maxlength'=>"300"]) ?>
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">主页品牌名称：</span>
                        <div class="company_r fl">
                            <?= Html::activeInput('text', $model, 'brandname', ['class' => 'ipt_long first_name ','maxlength'=>"10"]) ?>
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">头像：</span>
                        <div class="company_r fl">
                            <div class="tg_picbox">
                                <div class="file" id="file0" style="width: 198px;height: 145px;">
                                    <p id="container0" class="container0 tgpic_item">
                                        <button id="browse0" style="width: 198px;height: 145px;opacity: 0;"></button>
                                        <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto; left:35%!important; top:25%!important;<?=($model && $model->travel_avatar)?'display:none':''?>">
                                        <input type="hidden" value="0" class="idcardz upload_status">
                                        <input type="hidden" value="<?=$model->travel_avatar?>" name="TravelCompany[travel_avatar]" class="card_pic0 hide_val" />
                                    </p>
                                    <div class="file-list0" style="position: relative">
                                        <?php if($model->travel_avatar): ?>
                                            <img src="<?=$model->travel_avatar?>" alt="" class="add_img">
                                            <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                        <?php else:?>
                                            <img src="" alt="" class="add_img">
                                        <?php endif;?>
                                    </div>
                                </div>

                                <i></i>
                            </div>
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">业务联系人姓名：</span>
                        <div class="company_r fl">
                            <?= Html::activeInput('text', $model, 'business_name', ['class' => 'ipt_long cpy_name ','maxlength'=>"10"]) ?>
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">业务联系人电话：</span>
                        <div class="company_r fl">
                            <?= Html::activeInput('text', $model, 'business_tel', ['class' => 'ipt_long cpy_phone ','maxlength'=>"20", 'onkeyup' => "value=value.replace(/[^1234567890]+/g,'')"]) ?>
                            <p style="color:#ccc">该手机号将用于接收审核结果的短信通知，境外手机号填写格式为国家代码+号码</p>
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">邮箱：</span>
                        <div class="company_r fl">
                            <?= Html::activeInput('text', $model, 'business_email', ['class' => 'ipt_long cpy_email ','maxlength'=>"30"]) ?>
                            <p style="color:#ccc">该邮箱将用于接收审核结果的邮件通知</p>
                            <i></i>
                        </div>
                    </li>
                    <?php
                    if($model -> reg_addr_type == 1){
                        ?>
                        <li class="clearfix">
                            <span class="title_l fl">营业执照副本：</span>
                            <div class="company_r fl">
                                <div class="tg_picbox">
                                    <div class="file" id="file1">
                                        <p id="container1" class="container1 tgpic_item">
                                            <button id="browse1" class="browse1" style="width: 198px;height: 145px;opacity: 0;"></button>
                                            <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto; left:35%!important; top:25%!important;<?=($model && $model->license)?'display:none':''?>">
                                            <input type="hidden" value="0" class="idcardz upload_status">
                                            <input type="hidden" value="<?=$model->license?>" name="TravelCompany[license]" class="card_pic1 hide_val" />
                                        </p>
                                        <div class="file-list1" style="position: relative">
                                            <?php if($model->license): ?>
                                                <img src="<?=$model->license?>" alt="" class="add_img">
                                                <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                            <?php else:?>
                                                <img src="" alt="" class="add_img">
                                            <?php endif;?>
                                        </div>
                                    </div>

                                    <i class="tip1"></i>
                                </div>
                                <i></i>
                            </div>
                        </li>
                        <?php
                        if($model->group_type == 1){
                        ?>
                            <li class="clearfix">
                                <span class="title_l fl">旅行社经营资格证：</span>
                                <div class="company_r fl">
                                    <div class="tg_picbox">
                                        <div class="file" id="file2">
                                            <p id="container2" class="container2 tgpic_item">
                                                <button id="browse2" class="browse2" style="width: 198px;height: 145px;opacity: 0;"></button>
                                                <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto; left:50%!important; top:50%!important;<?=($model && $model->operation)?'display:none':''?>">
                                                <input type="hidden" value="0" class="idcardz upload_status">
                                                <input type="hidden" value="<?=$model->operation?>" name="TravelCompany[operation]" class="card_pic2 hide_val" />
                                            </p>
                                            <div class="file-list2">
                                                <?php if($model->operation): ?>
                                                    <img src="<?=$model->operation?>" alt="" class="add_img">
                                                    <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                                <?php else:?>
                                                    <img src="" alt="" class="add_img">
                                                <?php endif;?>
                                            </div>
                                        </div>
                                        <i class="tip2"></i>
                                    </div>
                                    <i></i>
                                </div>
                            </li>
                            <li class="clearfix">
                                <span class="title_l fl">旅行社责任险保险单：</span>
                                <div class="company_r fl">
                                    <div class="tg_picbox">
                                        <div class="file" id="file3">
                                            <p id="container3" class="container3 tgpic_item">
                                                <button id="browse3" class="browse3" style="width: 198px;height: 145px;opacity: 0;"></button>
                                                <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto; left:50%!important; top:50%!important;<?=($model && $model->policy)?'display:none':''?>">
                                                <input type="hidden" value="0" class="idcardz upload_status">
                                                <input type="hidden" value="<?=$model->policy?>" name="TravelCompany[policy]" class="card_pic3 hide_val" />
                                            </p>
                                            <div class="file-list3">
                                                <?php if($model->policy): ?>
                                                    <img src="<?=$model->policy?>" alt="" class="add_img">
                                                    <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                                <?php else:?>
                                                    <img src="" alt="" class="add_img">
                                                <?php endif;?>
                                            </div>
                                        </div>
                                        <i class="tip3"></i>
                                    </div>
                                    <i></i>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                        <li class="clearfix">
                            <span class="title_l fl">企业法人身份证(选填)：</span>
                            <div class="company_r fl">
                                <div class="fl tg_picbox">
                                    <div class="zheng">
                                        <div class="file" id="file4">
                                            <p id="container4" class="container4 tgpic_item">
                                                <button id="browse4" class="browse4" style="width: 198px;height: 145px;opacity: 0;"></button>
                                                <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto; left:50%!important; top:50%!important;<?=($model && $model->corporation_id_a)?'display:none':''?>">
                                                <input type="hidden" value="0" class="idcardz upload_status">
                                                <input type="hidden" value="<?=$model->corporation_id_a?>" name="TravelCompany[corporation_id_a]" class="card_pic4 hide_val" />
                                            </p>
                                            <div class="file-list4">
                                                <?php if($model->corporation_id_a): ?>
                                                    <img src="<?=$model->corporation_id_a?>" alt="" class="add_img">
                                                    <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                                    <?php else:?>
                                                    <img src="" alt="" class="add_img">
                                                <?php endif;?>
                                            </div>
                                        </div>
                                        <p class="zigezheng" style="width: 200px;margin-top: 10px">正面</p>
                                        <i class="tip4"></i>
                                    </div>
                                    <div class="fan">
                                        <div class="file" id="file5">
                                            <p id="container5" class="container5 tgpic_item">
                                                <button id="browse5" class="browse6" style="width: 198px;height: 145px;opacity: 0;"></button>
                                                <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto; left:50%!important; top:50%!important;<?=($model && $model->corporation_id_b)?'display:none':''?>">
                                                <input type="hidden" value="0" class="idcardz upload_status">
                                                <input type="hidden" value="<?=$model->corporation_id_b?>" name="TravelCompany[corporation_id_b]" class="card_pic5 hide_val" />
                                            </p>
                                            <div class="file-list5">
                                                <?php if($model->corporation_id_b): ?>
                                                    <img src="<?=$model->corporation_id_b?>" alt="" class="add_img">
                                                    <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                                <?php else:?>
                                                    <img src="" alt="" class="add_img">
                                                <?php endif;?>
                                            </div>
                                        </div>
                                        <p class="zigezheng" style="width: 200px;margin-top: 10px">反面</p>
                                        <i class="tip5"></i>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php
                    }else if(in_array($model -> reg_addr_type,[2,3,4])){
                        ?>
                        <li class="clearfix">
                            <span class="title_l fl">公司登记注册文件：</span>
                            <div class="company_r fl">
                                <div class="tg_picbox">
                                    <!--                    2017年6月6日14:32:58 宋杏会-->
                                    <div class="file" id="file11">
                                        <p id="container11" class="container11 tgpic_item">
                                            <button id="browse11" class="browse11" style="width: 198px;height: 145px;opacity: 0;"></button>
                                            <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto;<?=($model && $model->reg_file)?'display:none':''?>">
                                            <input type="hidden" value="0" class="idcardz upload_status">
                                            <input type="hidden" value="<?=$model->reg_file?>" name="TravelCompany[reg_file]" class="card_pic11 hide_val" />
                                        </p>
                                        <div class="file-list11">
                                            <?php if($model->reg_file): ?>
                                                <img src="<?=$model->reg_file?>" alt="" class="add_img">
                                                <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                            <?php else:?>
                                                <img src="" alt="" class="add_img">
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <i class="tip"></i>
                                </div>
                                <i></i>
                            </div>
                        </li>
                        <?php
                        if($model->group_type == 1){
                            ?>
                            <li class="clearfix">
                                <span class="title_l fl">行业经营许可证(选填)：</span>
                                <div class="company_r fl">
                                    <div class="tg_picbox">
                                        <!--                    2017年6月6日14:40:56 宋杏会-->
                                        <div class="file" id="file12">
                                            <p id="container12" class="container12 tgpic_item">
                                                <button id="browse12" class="browse12" style="width: 198px;height: 145px;opacity: 0;"></button>
                                                <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto;<?=($model && $model->trade_license)?'display:none':''?>">
                                                <input type="hidden" value="0" class="idcardz upload_status">
                                                <input type="hidden" value="<?=$model->trade_license?>" name="TravelCompany[trade_license]" class="card_pic12 hide_val" />
                                            </p>
                                            <div class="file-list12">
                                                <?php if($model->trade_license): ?>
                                                    <img src="<?=$model->trade_license?>" alt="" class="add_img">
                                                    <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                                <?php else:?>
                                                    <img src="" alt="" class="add_img">
                                                <?php endif;?>
                                            </div>
                                        </div>
                                        <i class="tip2"></i>
                                    </div>
                                    <i></i>
                                </div>
                            </li>
                            <li class="clearfix">
                                <span class="title_l fl">旅游保险证明(选填)：</span>
                                <div class="company_r fl">
                                    <div class="tg_picbox">
                                        <!--                    2017年6月6日14:42:48 宋杏会-->
                                        <div class="file" id="file13">
                                            <p id="container13" class="container13 tgpic_item">
                                                <button id="browse13" class="browse13" style="width: 198px;height: 145px;opacity: 0;"></button>
                                                <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto;<?=($model && $model->travel_insurance)?'display:none':''?>">
                                                <input type="hidden" value="0" class="idcardz upload_status">
                                                <input type="hidden" value="<?=$model->travel_insurance?>" name="TravelCompany[travel_insurance]" class="card_pic13 hide_val" />
                                            </p>
                                            <div class="file-list13">
                                                <?php if($model->travel_insurance): ?>
                                                    <img src="<?=$model->travel_insurance?>" alt="" class="add_img" style="margin-left: 0;width: 198px;height: 145px;">
                                                    <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                                <?php else:?>
                                                    <img src="" alt="" class="add_img">
                                                <?php endif;?>
                                            </div>
                                        </div>
                                        <i class="tip3"></i>
                                    </div>
                                    <i></i>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="clearfix">
                            <span class="title_l fl">企业法人身份证件：</span>
                            <div class="company_r fl">
                                <div class="fl tg_picbox">
                                    <div class="zheng">
                                        <!--                        2017年6月6日14:44:34 宋杏会-->
                                        <div class="file" id="file9">
                                            <p id="container9" class="container9 tgpic_item">
                                                <button id="browse9" class="browse9" style="width: 198px;height: 145px;opacity: 0;"></button>
                                                <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto;<?=($model && $model->corporation_id_a)?'display:none':''?>">
                                                <input type="hidden" value="0" class="idcardz upload_status">
                                                <input type="hidden" value="<?=$model->corporation_id_a?>" name="TravelCompany[corporation_id_a]" class="card_pic9 hide_val" />
                                            </p>
                                            <div class="file-list9">
                                                <?php if($model->corporation_id_a): ?>
                                                    <img src="<?=$model->corporation_id_a?>" alt="" class="add_img">
                                                    <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                                <?php else:?>
                                                    <img src="" alt="" class="add_img">
                                                <?php endif;?>
                                            </div>
                                        </div>

                                        <p class="zigezheng" style="width: 200px;margin-top: 10px">正面</p>
                                        <i class="tip4"></i>
                                    </div>
                                    <div class="fan">
                                        <!--                        2017年6月6日14:47:45-->
                                        <div class="file" id="file10">
                                            <p id="container10" class="container10 tgpic_item">
                                                <button id="browse10" class="browse10" style="width: 198px;height: 145px;opacity: 0;"></button>
                                                <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto;<?=($model && $model->corporation_id_b)?'display:none':''?>">
                                                <input type="hidden" value="0" class="idcardz upload_status">
                                                <input type="hidden" value="<?=$model->corporation_id_b?>" name="TravelCompany[corporation_id_b]" class="card_pic10 hide_val" />
                                            </p>
                                            <div class="file-list10">
                                                <?php if($model->corporation_id_b): ?>
                                                    <img src="<?=$model->corporation_id_b?>" alt="" class="add_img">
                                                    <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                                <?php else:?>
                                                    <img src="" alt="" class="add_img">
                                                <?php endif;?>
                                            </div>
                                        </div>

                                        <p class="zigezheng" style="width: 200px;margin-top: 10px">反面</p>
                                        <i class="tip5"></i>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php
                    }
                    ?>

                    <li class="clearfix">
                        <span class="title_l fl">申请人身份证：</span>
                        <div class="company_r fl">
                            <div class="fl tg_picbox">
                                <div class="zheng">
                                    <div class="file" id="file6">
                                        <p id="container6" class="container6 tgpic_item">
                                            <button id="browse6" class="browse6" style="width: 198px;height: 145px;opacity: 0;"></button>
                                            <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto; left:50%!important; top:50%!important;<?=($model && $model->proposer_a)?'display:none':''?>">
                                            <input type="hidden" value="0" class="idcardz upload_status">
                                            <input type="hidden" value="<?=$model->proposer_a?>" name="TravelCompany[proposer_a]" class="card_pic6 hide_val" />
                                        </p>
                                        <div class="file-list6">
                                            <?php if($model->proposer_a): ?>
                                                <img src="<?=$model->proposer_a?>" alt="" class="add_img">
                                                <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                            <?php else:?>
                                                <img src="" alt="" class="add_img">
                                            <?php endif;?>
                                        </div>
                                    </div>

                                    <p class="zigezheng" style="width: 200px;margin-top: 10px">正面</p>
                                    <i class="tip6"></i>
                                </div>
                                <div class="fan">
                                    <div class="file" id="file7">
                                        <p id="container7" class="container7 tgpic_item">
                                            <button id="browse7" class="browse7" style="width: 198px;height: 145px;opacity: 0;"></button>
                                            <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto; left:50%!important; top:50%!important;<?=($model && $model->proposer_b)?'display:none':''?>">
                                            <input type="hidden" value="0" class="idcardz upload_status">
                                            <input type="hidden" value="<?=$model->proposer_b?>" name="TravelCompany[proposer_b]" class="card_pic7 hide_val" />
                                        </p>
                                        <div class="file-list7">
                                            <?php if($model->proposer_b): ?>
                                                <img src="<?=$model->proposer_b?>" alt="" class="add_img">
                                                <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                            <?php else:?>
                                                <img src="" alt="" class="add_img">
                                            <?php endif;?>
                                        </div>
                                    </div>

                                    <p class="zigezheng" style="width: 200px;margin-top: 10px">反面</p>
                                    <i class="tip7"></i>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php

                    if($model->group_type == 1){
                    ?>
                        <li class="clearfix">
                            <span class="title_l fl">税务许可证明(选填)：</span>
                            <div class="company_r fl">
                                <div class="tg_picbox">
                                    <div class="file" id="file8">
                                        <p id="container8" class="container8 tgpic_item">
                                            <button id="browse8" class="browse8" style="width: 198px;height: 145px;opacity: 0;"></button>
                                            <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto; left:50%!important; top:50%!important;<?=($model && $model->tax_certificate)?'display:none':''?>">
                                            <input type="hidden" value="0" class="idcardz upload_status">
                                            <input type="hidden" value="<?=$model->tax_certificate?>" name="TravelCompany[tax_certificate]" class="card_pic8 hide_val" />
                                        </p>
                                        <div class="file-list8">
                                            <?php if($model->tax_certificate): ?>
                                                <img src="<?=$model->tax_certificate?>" alt="" class="add_img">
                                                <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                            <?php else:?>
                                                <img src="" alt="" class="add_img">
                                            <?php endif;?>
                                        </div>
                                    </div>

                                    <i></i>
                                </div>
                                <i class="tip8"></i>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="clearfix">
                        <span class="title_l fl">财务联系人姓名：</span>
                        <div class="company_r fl">
                            <?= Html::activeInput('text', $model, 'finance_name', ['class' => 'ipt_long cpy_name ','maxlength'=>"10"]) ?>
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">财务联系人电话：</span>
                        <div class="company_r fl">
                            <?= Html::activeInput('text', $model, 'finance_tel', ['class' => 'ipt_long cpy_phone ','maxlength'=>"20", 'onkeyup' => "value=value.replace(/[^1234567890]+/g,'')"]) ?>
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">邮箱：</span>
                        <div class="company_r fl">
                            <?= Html::activeInput('text', $model, 'finance_email', ['class' => 'ipt_long cpy_email ','maxlength'=>"50"]) ?>
                            <p>电子邮箱用于接收棠果旅行通知、财务对账单等、务必正确畅通</p>
                            <i></i>
                        </div>
                    </li>
                    <li class="clearfix">
                        <span class="title_l fl">收款账号类型：</span>
                        <div class="fl card_type_box">
                            <div class="card_t bank_card fl">
                                <input type="radio" id="bank_c"  name="travelAccountBank[account_type]" value="1"  class="c_radio fl" <?=($model->bank && $model->bank->account_type == 2)?'':'checked="checked"'?>><label for="bank_c" class="fl">银行账号</label>
                            </div>
                            <div class="card_t zfb_card fl">
                                <input type="radio" id="zfb_c"   name="travelAccountBank[account_type]" value="2"  class="c_radio fl" <?=($model->bank && $model->bank->account_type == 2)?'checked="checked"':''?> ><label for="zfb_c" class="fl">支付宝</label>
                            </div>
                        </div>
                    </li>
                    <li class="card_show clearfix" style="display:<?=($model->bank->account_type == 2)?'none':'list-item;'?>" >
                        <span class="title_l fl">开户名称：</span>
                        <input type="text" class="inputone card_name fl" name="travelAccountBank[account_name]" value="<?=($model->bank  && $model->bank->account_type == 1)?$model->bank->account_name:''?>"  >
                        <i class="fl"></i>
                    </li>
                    <li class="card_show clearfix" style="display:<?=($model->bank->account_type == 2)?'none':'list-item;'?>" >
                        <span class="title_l fl">收款账号：</span>
                        <input type="text" class="inputone card_num fl" name="travelAccountBank[account_num]"  value="<?=($model->bank  && $model->bank->account_type == 1)?$model->bank->account_num:''?>" >
                        <i class="fl"></i>
                    </li>
                    <li class="card_show clearfix" style="display:<?=($model->bank->account_type == 2)?'none':'list-item;'?>" >
                        <span class="title_l fl">开户行：</span>
                        <div class="company_r fl">
                            <input type="text" class="inputone card_address" name="travelAccountBank[account_bank]"  value="<?=($model->bank  && $model->bank->account_type == 1)?$model->bank->account_bank:''?>" >
                            <p>收款信息审核通过后无法修改，如须修改，请联系客服</p>
                        </div>
                        <i class="fl"></i>
                    </li>
                    <li class="zfb_show clearfix" style="display:<?=($model->bank->account_type == 2)?'list-item;':'none'?>" >
                        <span class="title_l fl">支付宝名称：</span>
                        <input type="text" class="inputone zfb_name fl" name="travelAccountBank[account_name_ali]" value="<?=($model->bank  && $model->bank->account_type == 2)?$model->bank->account_name:''?>"  >
                        <i class="fl"></i>
                    </li>
                    <li class="zfb_show clearfix" style="display:<?=($model->bank->account_type == 2)?'list-item;':'none'?>"  >
                        <span class="title_l fl">支付宝账号：</span>
                        <div class="company_r fl">
                            <input type="text" class="inputone zfb_num" name="travelAccountBank[account_num_ali]" value="<?=($model->bank  && $model->bank->account_type == 2)?$model->bank->account_num:''?>" >
                            <p>收款信息审核通过后无法修改，如须修改，请联系客服</p>
                        </div>
                        <i class="fl"></i>
                    </li>
                </ul>
            </div>
            <div class="submitbtn">
                <input type="hidden" name="company_id" value="<?=$model->id?>" />
                <input type="hidden" name="user_id" value="<?=$model->uid?>" />
                <input type="hidden" name="auth" value="<?=$auth?>"/>
                <button class="submit" style="background: #169bd5;color: white;border: none;">保存</button>
                <a href="<?php echo Yii::$app->request->getReferrer() ?>" class="btn-cancle">返回</a>
            </div>
        </div>
        <?= Html::endForm();?>
    </div>
</div>
<script>
    $(function(){
        $("#regcity").bind("input propertychange",function(){
            var _this = $(this);
            var name = $(this).val();
            $(this).siblings(".cityhid").val("");
            $(this).siblings(".cityhid").attr("tg",0);
            if(name!=''){
                $.ajax({
                    type: 'GET',
                    url: '<?= \yii\helpers\Url::toRoute(["region/getcity"])?>',
                    data: {"name": name},
                    dataType: 'json',
                    success: function (data) {

                        if(data!=""){
                            var html = '<ul style="position: absolute;left: 626px;top: 336px;" id="city1" class="form-control region123" name="TravelCompany[reg_city]" >';
                            $.each(data, function(index, content){
                                html += '<li value="'+index+'">'+content.replace(name, '<b style="color:red; font-weight:normal">'+name+'</b>')+'</li>';
                            });
                            html += '</ul>';

//                            $("#city1").remove();

                            _this.next("#city1").remove();
                            $(_this).after(html);

                        }
                        else{
//                           $('#regcity').val(''); // 2017年6月3日15:36:46 宋杏会 QQ浏览器输入不显示城市选择
                            _this.next("#city1").remove();
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        /*_this.val("");
                         _this.blur();*/
                    }
                });
            }
            else{

                $(this).next("#city1").remove();
            }
        });
        $("body").click(function(){
            $(".region123").hide()
        })
        $("body").on("click",".region123 li",function(){
            var code = $(this).attr("value");
            var name = $(this).text();
            var nameArr = name.split(",");
            var codeArr = code.split(",");
            var wholename = '';
            $.each(nameArr,function(a,b){
                wholename += b + ',';
            })
//            console.log(codeArr);return false;
            $(this).parent().siblings(".city1").val(wholename);
            $(this).parent().siblings(".cityhid").val(code);
            $(this).parent().siblings(".cityhid").attr("tg",1);
            $(this).parent().remove();
            $('#country').val(codeArr[0]);
            $('#prov').val(codeArr[1]);
            $('#city').val(codeArr[2]);
            $('#county').val(codeArr[3]);
        });
        function tgCity(ev,city){
            $(document).on("click",function(){
                if($(ev).val()=="" && $(ev).attr("tg")=="0"){
                    var code = $(city).find("li:first-child").attr("value");
                    var name = $(city).find("li:first-child").text();
                    var nameArr = name.split(",");
                    $(city).find(".city1").val(nameArr[0]);
                    $(city).find(".cityhid").val(code);
                    $(city).find("ul").remove();
                }

            })
        }
        $("#regcity").on("change", function(){
            tgCity("input[name='TravelCompany[reg_country]']",".tg_city1");
            tgCity("input[name='TravelCompany[reg_province]']",".tg_city1");
            tgCity("input[name='TravelCompany[reg_city]']",".tg_city1");
            tgCity("input[name='TravelCompany[reg_county]']",".tg_city1");
        })

//        tgCity("input[name='TravelCompany[reg_country]']",".tg_city1");
//        tgCity("input[name='TravelCompany[reg_province]']",".tg_city1");
//        tgCity("input[name='TravelCompany[reg_city]']",".tg_city1");
//        tgCity("input[name='TravelCompany[reg_county]']",".tg_city1");


    })

    function previewImage(file, callback) {//file为plupload事件监听函数参数中的file对象,callback为预览图片准备完成的回调函数
        if (!file || !/image\//.test(file.type)) return; //确保文件是图片
        if (file.type == 'image/gif') {//gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
            var fr = new mOxie.FileReader();
            fr.onload = function () {
                callback(fr.result);
                fr.destroy();
                fr = null;
            }
            fr.readAsDataURL(file.getSource());
        } else {
            var preloader = new mOxie.Image();
            preloader.onload = function () {
                preloader.downsize(300, 300);//先压缩一下要预览的图片,宽300，高300
                var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                callback && callback(imgsrc); //callback传入的参数为预览图片的url
                preloader.destroy();
                preloader = null;
            };
            preloader.load(file.getSource());
        }
    }
    // 点击保存按钮进行验证
//    $(".submit").on("click", function(){
//        console.log(11)
//        for(var i = 0; i < $(".lxs_type").length; i++){
//            if($(".lxs_type").eq(i).find("input").attr("checked")){
//                console.log(i);
//                break;
//            }
//        }
//        return false;
//    })
</script>
<?php if (Yii::$app->session->hasFlash('errors')) { ?>
<script>layer.alert("<?=Yii::$app->session->getFlash('errors')?>", {time: 0,})</script>
<?php } ?>