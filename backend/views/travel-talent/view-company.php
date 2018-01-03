<?php
use yii\helpers\Url;
$this->title = '企业资质信息查看';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/shenhe_sxh.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/viewer.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/shenhe.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>
<!--<link rel="stylesheet" href="<? //= Yii::$app->request->baseUrl ?>/yulan/dist/zoomify.min.css">-->
<style>
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
        font-family: "Microsoft Yahei";
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

    textarea {
        outline: none;
        resize: none;
    }

    .part_two {
        height: inherit;
    }

    /*2017年5月18日12:11:11 查看图片插件样式*/
    #dowebok li {
        display: inline-block;
        width: 200px;
        margin:0 10px 20px 0;
    }

    /*2017年5月24日15:12:00 宋杏会 资质照片上传高度拉伸*/
    /*#dowebok li img {*/
    /*width: 100%;*/
    /*}*/
    #dowebok li img {
        width: 100%;
        height: 150px;
    }

    /*.widspan{*/
    /*display: inline-block;*/
    /*width:70px;*/
    /*}*/
    /*.widspan2{*/
    /*margin-left:30px;*/
    /*}*/
    /*2017年6月3日16:15:01 xhh 公司资质排版错乱*/
    .rignt-con p span:first-child {
        display: inline-block;
        width: 150px;
    }
    .rignt-con input[type="text"]{
        width: 260px!important;
    }
</style>

<div class="right">
    <div class="part_one">
        <div class="top">
            <hr>
        </div>
        <div class="rignt-con">
            <p>
                <span style="width:55px;display:inline-block;">账号</span>

            </p>
            <p>
                <span>公司名称</span>
                <input type="text" value="<?php echo $model->name; ?>" readonly='true'>
            </p>

            <p>
                <span>类型</span>
                <input type="text" value="<?php echo Yii::$app->params['group_type'][$model->group_type]; ?>"
                       readonly='true'>
            </p>

            <p>
                <span>注册地址</span>
                <input type="text" value="<?php echo Yii::$app->params['reg_addr_type'][$model->reg_addr_type]; ?>"
                       readonly='true'>
            </p>

            <p>
                <span>详细区域</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo \backend\service\CommonService::get_city_name($model->reg_country); ?>---
                <?php echo \backend\service\CommonService::get_city_name($model->reg_province); ?>---
                <?php echo \backend\service\CommonService::get_city_name($model->reg_city); ?>

            </p>
            <p>
                <span>品牌名称</span>
                <input type="text" value="<?php echo $model->brandname; ?>" readonly='true'>
            </p>

            <p class="div-sxh2">
                <span>头像</span>
                <ul id="dowebok">
                    <li>
                    <?php if($model->travel_avatar):?>
                    <img src="<?php  echo $model->travel_avatar ?>" alt="">
                    <?php endif;?>
                    </li>
            <p>
                <span> 联系姓名</span>
                <input type="text" value="<?php echo $model->business_name; ?>" readonly='true'>
            </p>
            <p>
                <span>联系电话</span>
                <input type="text" value="<?php echo $model->business_tel; ?>" readonly='true'>
            </p>
            <p>
                <span>联系邮箱</span>
                <input type="text" value="<?php echo $model->business_email; ?>" readonly='true'>
            </p>


            <p class="div-sxh2">
                <span>公司简介</span>
                <textarea readonly="readonly"><?php echo $model->recommend; ?></textarea>
            </p>
            <!--            国内旅行社-->
            <?php if ($model->reg_addr_type == 1 && $model->group_type == 1): ?>

                <p class="div-sxh2">
                    <span>营业执照副本</span>
                    <ul id="dowebok">
                        <li>
                            <?php if($model->license):?>
                            <img data-original="<?php echo $model->license ?>" src="<?php echo $model->license ?>"
                                 alt=""
                                 class="example img-rounded">
                            <?php endif;?>
                        </li>


                <p class="div-sxh2">
                    <span>旅行社经营资格证：</span>

                <li>
                <?php if($model->operation):?>
                    <img data-original="<?php echo $model->operation ?>" src="<?php echo $model->operation ?>" alt=""
                         class="example img-rounded">
                <?php endif;?>
                </li>

                <p class="div-sxh2">
                    <span>旅行社责任险保险单：</span>

                <li>
                <?php if($model->policy):?>
                <img data-original="<?php echo $model->policy ?>" src="<?php echo $model->policy ?>" alt=""
                         class="example img-rounded">
                <?php endif;?>
                </li>


                <p class="div-sxh2">
                    <span>企业法人身份证：<br />（选填）</span>

                <li>
                <?php if($model->corporation_id_a):?>
                    <img data-original="<?php echo $model->corporation_id_a ?>"
                         src="<?php echo $model->corporation_id_a ?>"
                         alt=""
                         class="example img-rounded">
                <?php endif;?>
                </li>
                <li>
                    <?php if($model->corporation_id_b):?>
                    <img data-original="<?php echo $model->corporation_id_b ?>"
                         src="<?php echo $model->corporation_id_b ?>"
                         alt=""
                         class="example img-rounded">
                    <?php endif;?>
                </li>

                </p>


                <p class="div-sxh2">
                    <span>申请人身份证：</span>

                <li>
                <?php if($model->proposer_a):?>
                <img data-original="<?php echo $model->proposer_a ?>" src="<?php echo $model->proposer_a ?>"
                         alt=""
                         class="example img-rounded">
                <?php endif;?>
                </li>
                <li>
                    <?php if($model->proposer_b):?>
                    <img data-original="<?php echo $model->proposer_b ?>" src="<?php echo $model->proposer_b ?>"
                         alt=""
                         class="example img-rounded">
                    <?php endif;?>
                </li>

                <!--                <img src="--><?php //echo $model->license ?><!--" alt="" class="example img-rounded">-->
                <!--                <img src="-->
                <?php //echo $model->operation ?><!--" alt="" class="example img-rounded">-->
                <!--                    <img src="images/pic-6@2x.png" alt="" style="margin-left:100px;margin-top:20px;">-->
                </p>

                <p class="div-sxh2">
                    <span>税务许可：<br />（选填）</span>

                <li>
                <?php if($model->tax_certificate):?>
                <img data-original="<?php echo $model->tax_certificate ?>"
                         src="<?php echo $model->tax_certificate ?>" alt="" class="example img-rounded">
                <?php endif;?>
                </li>

                </ul>

                </p>
                <p>
                    <span>财务人姓名</span>
                    <input type="text" value="<?php echo $model->finance_name; ?>" readonly='true'>
                </p>

                <p>
                    <span>财务人电话</span>
                    <input type="text" value="<?php echo $model->finance_tel; ?>" readonly='true'>
                </p>
                <p>
                    <span>财务人邮箱</span>
                    <input type="text" value="<?php echo $model->finance_email; ?>" readonly='true'>
                </p>
                <?php if ($model['bank']->account_type == 1): ?>
                    <p>
                        <span>开户名称</span>
                        <input type="text" value="<?php echo $model['bank']->account_name; ?>" readonly='true'>
                    </p>
                    <p>
                        <span>收款号</span>
                        <input type="text" value="<?php echo $model['bank']->account_num; ?>" readonly='true'>
                    </p>

                    <p>
                        <span>开户行</span>
                        <input type="text" value="<?php echo $model['bank']->account_bank; ?>" readonly='true'>
                    </p>


                <?php endif ?>

                <?php if ($model['bank']->account_type == 2): ?>
                    <p>
                        <span>支付宝名称</span>
                        <input type="text" value="<?php echo $model['bank']->account_name; ?>" readonly='true'>
                    </p>
                    <p>
                        <span>支付宝帐号</span>
                        <input type="text" value="<?php echo $model['bank']->account_num; ?>" readonly='true'>
                    </p>


                <?php endif ?>

            <?php endif ?>

            <!--非旅行社-->
            <?php if ($model->reg_addr_type == 1 && $model->group_type == 2): ?>

                <p class="div-sxh2">
                    <span>营业执照副本</span>
                    <ul id="dowebok">
                        <li>
                            <?php if($model->license):?>
                            <img data-original="<?php echo $model->license ?>" src="<?php echo $model->license ?>"
                                 alt=""
                                 class="example img-rounded">
                            <?php endif;?>
                        </li>


                <p class="div-sxh2">
                    <span>企业法人身份证：<br />（选填）</span>

                <li>
                <?php if($model->corporation_id_a):?>
                <img data-original="<?php echo $model->corporation_id_a ?>"
                         src="<?php echo $model->corporation_id_a ?>"
                         alt=""
                         class="example img-rounded">
                <?php endif;?>
                </li>
                <li>
                    <?php if($model->corporation_id_b):?>
                    <img data-original="<?php echo $model->corporation_id_b ?>"
                         src="<?php echo $model->corporation_id_b ?>"
                         alt=""
                         class="example img-rounded">
                    <?php endif;?>
                </li>

                </p>


                <p class="div-sxh2">
                    <span>申请人身份证：</span>

                <li>
                    <?php if($model->proposer_a):?>
                    <img data-original="<?php echo $model->proposer_a ?>" src="<?php echo $model->proposer_a ?>"
                         alt=""
                         class="example img-rounded">
                    <?php endif;?>
                </li>
                <li>
                    <?php if($model->proposer_b):?>
                    <img data-original="<?php echo $model->proposer_b ?>" src="<?php echo $model->proposer_b ?>"
                         alt=""
                         class="example img-rounded">
                    <?php endif;?>
                </li>
                </ul>
                </p>


                <p>
                    <span>财务人姓名</span>
                    <input type="text" value="<?php echo $model->finance_name; ?>" readonly='true'>
                </p>

                <p>
                    <span>财务人电话</span>
                    <input type="text" value="<?php echo $model->finance_tel; ?>" readonly='true'>
                </p>
                <p>
                    <span>财务人邮箱</span>
                    <input type="text" value="<?php echo $model->finance_email; ?>" readonly='true'>
                </p>
                <?php if ($model['bank']->account_type == 1): ?>
                    <p>
                        <span>开户名称</span>
                        <input type="text" value="<?php echo $model['bank']->account_name; ?>" readonly='true'>
                    </p>
                    <p>
                        <span>收款号</span>
                        <input type="text" value="<?php echo $model['bank']->account_num; ?>" readonly='true'>
                    </p>

                    <p>
                        <span>开户行</span>
                        <input type="text" value="<?php echo $model['bank']->account_bank; ?>" readonly='true'>
                    </p>


                <?php endif ?>

                <?php if ($model['bank']->account_type == 2): ?>
                    <p>
                        <span>支付宝名称</span>
                        <input type="text" value="<?php echo $model['bank']->account_name; ?>" readonly='true'>
                    </p>
                    <p>
                        <span>支付宝帐号</span>
                        <input type="text" value="<?php echo $model['bank']->account_num; ?>" readonly='true'>
                    </p>


                <?php endif ?>

            <?php endif ?>

            <!--港澳台和海外旅行社-->
            <?php if ($model->reg_addr_type != 1 && $model->group_type == 1): ?>

                <p class="div-sxh2">
                    <span>公司登记注册文件</span>
                    <ul id="dowebok">
                        <li>
                            <?php if($model->reg_file):?>
                            <img data-original="<?php echo $model->reg_file ?>" src="<?php echo $model->reg_file ?>"
                                 alt=""
                                 class="example img-rounded">
                            <?php endif;?>
                        </li>


                <p class="div-sxh2">
                    <span>行业经营许可证：<br />（选填）</span>

                <li>
                <?php if($model->trade_license):?>
                <img data-original="<?php echo $model->trade_license ?>"
                         src="<?php echo $model->trade_license ?>"
                         alt=""
                         class="example img-rounded">
                <?php endif;?>
                </li>


                </p>

                <p class="div-sxh2">
                    <span>旅游保险证明：<br />（选填）</span>

                <li>
                <?php if($model->travel_insurance):?>
                <img data-original="<?php echo $model->travel_insurance ?>"
                         src="<?php echo $model->travel_insurance ?>"
                         alt=""
                         class="example img-rounded">
                <?php endif;?>
                </li>

                </p>
                <p class="div-sxh2">
                    <span>企业法人身份证：</span>

                <li>
                <?php if($model->corporation_id_a):?>
                <img data-original="<?php echo $model->corporation_id_a ?>"
                         src="<?php echo $model->corporation_id_a ?>"
                         alt=""
                         class="example img-rounded">
                <?php endif;?>
                </li>
                <li>
                    <?php if($model->corporation_id_b):?>
                    <img data-original="<?php echo $model->corporation_id_b ?>"
                         src="<?php echo $model->corporation_id_b ?>"
                         alt=""
                         class="example img-rounded">
                    <?php endif;?>
                </li>


                <p class="div-sxh2">
                    <span>申请人身份证：</span>

                <li>
                <?php if($model->proposer_a):?>
                <img data-original="<?php echo $model->proposer_a ?>" src="<?php echo $model->proposer_a ?>"
                         alt=""
                         class="example img-rounded">
                <?php endif;?>
                </li>
                <li>
                    <?php if($model->proposer_b):?>
                    <img data-original="<?php echo $model->proposer_b ?>" src="<?php echo $model->proposer_b ?>"
                         alt=""
                         class="example img-rounded">
                    <?php endif;?>
                </li>


                <p class="div-sxh2">
                    <span>税务许可证明：<br />（选填）</span>

                <li>
                <?php if($model->tax_certificate):?>
                <img data-original="<?php echo $model->tax_certificate ?>"
                         src="<?php echo $model->tax_certificate ?>"
                         alt=""
                         class="example img-rounded">
                <?php endif;?>
                </li>
                </ul>
                </p>


                <p>
                    <span>财务人姓名</span>
                    <input type="text" value="<?php echo $model->finance_name; ?>" readonly='true'>
                </p>

                <p>
                    <span>财务人电话</span>
                    <input type="text" value="<?php echo $model->finance_tel; ?>" readonly='true'>
                </p>
                <p>
                    <span>财务人邮箱</span>
                    <input type="text" value="<?php echo $model->finance_email; ?>" readonly='true'>
                </p>
                <?php if ($model['bank']->account_type == 1): ?>
                    <p>
                        <span>开户名称</span>
                        <input type="text" value="<?php echo $model['bank']->account_name; ?>" readonly='true'>
                    </p>
                    <p>
                        <span>收款号</span>
                        <input type="text" value="<?php echo $model['bank']->account_num; ?>" readonly='true'>
                    </p>

                    <p>
                        <span>开户行</span>
                        <input type="text" value="<?php echo $model['bank']->account_bank; ?>" readonly='true'>
                    </p>


                <?php endif ?>

                <?php if ($model['bank']->account_type == 2): ?>
                    <p>
                        <span>支付宝名称</span>
                        <input type="text" value="<?php echo $model['bank']->account_name; ?>" readonly='true'>
                    </p>
                    <p>
                        <span>支付宝帐号</span>
                        <input type="text" value="<?php echo $model['bank']->account_num; ?>" readonly='true'>
                    </p>


                <?php endif ?>

            <?php endif ?>

            <!--港澳台和海外非旅行社-->
            <?php if ($model->reg_addr_type != 1 && $model->group_type == 2): ?>

                <p class="div-sxh2">
                    <span>公司登记注册文件</span>
                    <ul id="dowebok">
                        <li>
                            <?php if($model->reg_file):?>
                            <img data-original="<?php echo $model->reg_file ?>" src="<?php echo $model->reg_file ?>"
                                 alt=""
                                 class="example img-rounded">
                            <?php endif;?>
                        </li>


                <p class="div-sxh2">
                    <span>企业法人身份证：</span>

                <li>
                <?php if($model->corporation_id_a):?>
                <img data-original="<?php echo $model->corporation_id_a ?>"
                         src="<?php echo $model->corporation_id_a ?>"
                         alt=""
                         class="example img-rounded">
                <?php endif;?>
                </li>
                <li>
                    <?php if($model->corporation_id_b):?>
                    <img data-original="<?php echo $model->corporation_id_b ?>"
                         src="<?php echo $model->corporation_id_b ?>"
                         alt=""
                         class="example img-rounded">
                    <?php endif;?>
                </li>


                <p class="div-sxh2">
                    <span>申请人身份证：</span>

                <li>
                <?php if($model->proposer_a):?>
                <img data-original="<?php echo $model->proposer_a ?>" src="<?php echo $model->proposer_a ?>"
                         alt=""
                         class="example img-rounded">
                <?php endif;?>
                </li>
                <li>
                    <?php if($model->proposer_b):?>
                    <img data-original="<?php echo $model->proposer_b ?>" src="<?php echo $model->proposer_b ?>"
                         alt=""
                         class="example img-rounded">
                    <?php endif;?>
                </li>

                </p>

                <p>
                    <span>财务人姓名</span>
                    <input type="text" value="<?php echo $model->finance_name; ?>" readonly='true'>
                </p>

                <p>
                    <span>财务人电话</span>
                    <input type="text" value="<?php echo $model->finance_tel; ?>" readonly='true'>
                </p>
                <p>
                    <span>财务人邮箱</span>
                    <input type="text" value="<?php echo $model->finance_email; ?>" readonly='true'>
                </p>
                <?php if ($model['bank']->account_type == 1): ?>
                    <p>
                        <span>开户名称</span>
                        <input type="text" value="<?php echo $model['bank']->account_name; ?>" readonly='true'>
                    </p>
                    <p>
                        <span>收款号</span>
                        <input type="text" value="<?php echo $model['bank']->account_num; ?>" readonly='true'>
                    </p>

                    <p>
                        <span>开户行</span>
                        <input type="text" value="<?php echo $model['bank']->account_bank; ?>" readonly='true'>
                    </p>


                <?php endif ?>

                <?php if ($model['bank']->account_type == 2): ?>
                    <p>
                        <span>支付宝名称</span>
                        <input type="text" value="<?php echo $model['bank']->account_name; ?>" readonly='true'>
                    </p>
                    <p>
                        <span>支付宝帐号</span>
                        <input type="text" value="<?php echo $model['bank']->account_num; ?>" readonly='true'>
                    </p>


                <?php endif ?>

            <?php endif ?>


        </div>
    </div>

    <div class="part_two">
        <div class="top">
            <p>
                <b>
                    审核列表
                </b>
            </p>
            <hr>
            <?php if (is_array($logs) && !empty($logs)): ?>
                <div class="right-r">
                    <p>
                        操作日志：
                    </p>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td>时间</td>
                            <td>操作人</td>
                            <td>操作内容</td>
                            <td>原因</td>
                            <td>备注</td>
                        </tr>
                        <?php foreach ($logs['list'] as $k => $v): ?>
                            <tr>
                                <td><?php echo $v['create_time'] ?></td>
                                <td><?php echo $v['uname'] ?></td>
                                <td>
                                    <?php
                                    if ($v['status'] == 1) {
                                        echo '通过审核/上线';
                                    } elseif ($v['status'] == 2) {
                                        echo '下线';
                                    } elseif ($v['status'] == 3) {
                                        echo '未通过审核';
                                    } elseif ($v['status'] == 8) {
                                        echo '修改信息';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $v['reason'] ?></td>
                                <td><?php echo $v['remarks'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif ?>
            <div class="right-l-btn">
                <a href="<?php echo Yii::$app->request->getReferrer() ?>" class="btn1"><button type="button" class="btn1">返回</button></a>
            </div>
        </div>
    </div>
</div>
<!--2017年5月18日11:51:55 替换公司资质和个人资质的图片查看插件-->
<script>
    var viewer = new Viewer(document.getElementById('dowebok'), {
        url: 'data-original'
    });
</script>