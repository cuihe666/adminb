<?php
use yii\helpers\Url;

?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/shenhe_sxh.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/viewer.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/shenhe.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>

<!--<link rel="stylesheet" href="<?//= Yii::$app->request->baseUrl ?>/yulan/dist/zoomify.min.css">-->
<style>
    textarea{outline:none;resize:none;}

    .part_two .right-r{
        float:inherit;
    }
    .part_two .right-l{
        float:inherit;
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
    .part_two .right-r{
        width:100%;
        margin-top:0;
    }
    .part_two{
        height:inherit;
    }
/*2017年5月18日12:11:11 查看图片插件样式*/
    #dowebok1 li,#dowebok li,#dowebok2 li {
        display: inline-block;
        width:200px ;
        margin:0 10px 0 0;
    }

    #dowebok1 li img,#dowebok li img,#dowebok2 li img {
        width: 100%;
    }

    /*2017年5月24日14:52:23 更改css 宋杏会*/
    .widspan{
        display: inline-block;
        width:88px;
        text-align: right;
    }
    .widspan2{
        margin-left:30px;
    }
    .rignt-con input,.rignt-con .div-sxh2 textarea{
        /*background-color: transparent;*/
        /*border:none;*/
        /*padding-top:0;*/
    }
    .rignt-con input{
        margin-left:15px;
    }
    .div-sxh_add input[type="radio"]{
        display:inline-block;
        height:inherit;
    }
    .div-sxh_add em{
        font-style: normal;
        font-weight: normal;
    }
    .div-sxh2_add em{
        font-style: normal;
        font-weight: normal;
        display:block;
        text-align: center;
        margin-top:5px;
    }
    .img-rounded{
        /*border-radius: 0;*/
    }
    #dowebok li img{
       height:150px;   /*公司审核上传图片拉长 所以给图片加了个高度 4:3*/
    }

</style>

<div class="right">
    <div class="part_one">
        <div class="top">
            <p>
                <b>
                    个人资质审核
                </b>
            </p>
            <hr>
        </div>
        <div class="rignt-con">
            <p>
                <span class="widspan">账号:</span>
                <input type="text" value="<?php echo \backend\models\TravelPerson::getUser($model->uid)['mobile'] ?>">
            </p>
            <p class="div-sxh2">
                <span class="widspan">头像</span>
                <ul id="dowebok2">
                    <li>
                        <?php if($model->travel_avatar):?>
                        <img data-original="<?php echo $model->travel_avatar ?>" src="<?php echo $model->travel_avatar ?>" alt="" class="example img-rounded">
                        <?php endif;?>
                    </li>
                </ul>
            </p>

            <p class="div-sxh">
                <b>
                    <span class="widspan">主页昵称:</span>
                    <input type="text" value="<?php echo $model->nick_name; ?>" readonly>
                </b>
            </p>
            <p class="div-sxh">
                <span class="widspan">联系电话:</span>
                <input type="text" value="<?php echo $model->mobile ?>" readonly>
            </p>
            <p class="div-sxh">
                <span class="widspan">星座:</span>
                <input type="text" value="<?php echo Yii::$app->params['constellation'][$model->constellation] ?>" readonly>
            </p>
            <p class="div-sxh">
                <span class="widspan">性别:</span>
                <input type="text" value="<?php echo @Yii::$app->params['sex'][$model->sex] ?>" readonly>
            </p>
            <p class="div-sxh">
                <b>
                    <span class="widspan">职业:</span>
                    <input type="text" value="<?php echo $model->profession ?>" readonly>
                </b>
            </p>
            <p class="div-sxh">
                <span class="widspan">邮箱:</span>
                <input type="text" value="<?php echo $model->email; ?>" readonly>
            </p>
            <p class="div-sxh2">
                <span class="widspan">个人简介:</span>
                <textarea readonly><?php echo $model->recommend ?> </textarea>
            </p>
            <p class="div-sxh">
                <b>
                    <span class="widspan">姓名:</span>
                    <input type="text" value="<?php echo $model->name; ?>" readonly>
                </b>
            </p>
            <p class="div-sxh2">
                <span class="widspan">身份证件照片: <i style="color:#aaa;display:block;text-align:center">(身份证/护照)</i></span>
                <ul id="dowebok" class="div-sxh2_add">
                    <li>
                        <?php if($model->card_pic_zheng):?>
                        <img data-original="<?php echo $model->card_pic_zheng ?>" src="<?php echo $model->card_pic_zheng ?>" alt="" class="example img-rounded">
                        <em>正面</em>
                        <?php endif;?>
                    </li>
                    <li>
                        <?php if($model->card_pic_fan):?>
                        <img data-original="<?php echo $model->card_pic_fan ?>" src="<?php echo $model->card_pic_fan ?>" alt="" class="example img-rounded">
                        <em>反面</em>
                        <?php endif;?>
                    </li>
                </ul>
            </p>
            <p class="div-sxh2">
                <span class="widspan">导游证照片: <i style="color:#aaa;display:block;text-align:center">选填</i></span>
                <ul id="dowebok1">
                    <li>
                        <?php if($model->guide_pic):?>
                        <img data-original="<?php echo $model->guide_pic ?>" src="<?php echo $model->guide_pic ?>" alt="" class="example img-rounded">
                        <?php endif;?>
                    </li>
                </ul>
            </p>
            <p class="div-sxh">
                <b>
                    <span class="widspan">身份证件号:</span>
                    <input type="text" value="<?php echo $model->card ?>" readonly>
                </b>
            </p>
            <p class="div-sxh div-sxh_add">
                <span class="widspan">收款账号类型:</span>
                <label>
                    <input name="gname" value="1" type="radio" <?php if($bankInfo['account_type']==1) echo "checked";?> disabled>
                    <em>银行卡</em>
                </label>
                <label>
                    <input name="gname" value="2" type="radio" <?php if($bankInfo['account_type']==2) echo "checked";?> disabled>
                    <em>支付宝</em>
                </label>
            </p>
            <?php
                //银行账户信息
                if($bankInfo['account_type']==1):
            ?>
                <p class="div-sxh">
                    <b>
                        <span class="widspan">持卡人:</span>
                        <input type="text" value="<?=$bankInfo['account_name']?>" readonly>
                    </b>
                </p>
                <p class="div-sxh">
                    <b>
                        <span class="widspan">银行卡卡号:</span>
                        <input type="text" value="<?=$bankInfo['account_num']?>" readonly>
                    </b>
                </p>
                <p class="div-sxh">
                    <b>
                        <span class="widspan">开户行:</span>
                        <input type="text" value=<?=$bankInfo['account_bank']?> readonly>
                    </b>
                </p>
            <?php
                endif;
            ?>
            <?php
            //支付宝账户信息
            if($bankInfo['account_type']==2):
                ?>
                <p class="div-sxh">
                    <b>
                        <span class="widspan">支付宝名称:</span>
                        <input type="text" value="<?=$bankInfo['account_name']?>" readonly>
                    </b>
                </p>
                <p class="div-sxh">
                    <b>
                        <span class="widspan">支付宝账号:</span>
                        <input type="text" value="<?=$bankInfo['account_num']?>" readonly>
                    </b>
                </p>
            <?php
                endif;
            ?>
        </div>
    </div>
    <div class="part_two">
        <div class="top">
            <p>
                <b>
                    审核
                </b>
            </p>
            <hr>
            <?php if ($model['status'] == 0): ?>
                <div class="rignt-con right-con2 right-l">
                    <div class="right-l-con current-dis">
                        <p>
                            <span class="light-sxh">审核：</span>
                        <form style="display: inline-block;">
                            <input type="radio" id="nba" name="status" value="1" checked="'true">
                            <label name="nba" for="nba" class="checked label">
                                <i>通过审核</i>
                            </label>
                            <input class="nvradio" type="radio" name="status" value="2" id='cba'>
                            <label name="cba" for="cba" class="label2">
                                <i>未通过审核</i>
                            </label>
                        </form>
                        </p>
                        <div class="dis-sxh">
                            <p>
                                <span class="light-sxh">备注：</span>
                                <textarea placeholder="选填" id="des"></textarea>
                            </p>
                        </div>
                        <div class="dis-sxh2">
                            <p>
                                <span class="light-sxh">原因：</span>
                                <textarea placeholder="必填" id="reason"></textarea>
                            </p>
                        </div>
                    </div>
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
                                <?php foreach ($logs as $k => $v): ?>
                                    <tr>
                                        <td><?php echo $v['create_time'] ?></td>
                                        <td><?php echo $v['uname'] ?></td>
                                        <td><?php if ($v['status'] == 1) {
                                                echo '通过审核';
                                            }
                                            if ($v['status'] == 2) {
                                                echo '未通过审核';
                                            } ?></td>
                                        <td><?php echo $v['reason'] ?></td>
                                        <td><?php echo $v['remarks'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif ?>
                    <div class="right-l-btn">
                        <a href="<?php echo Yii::$app->request->getReferrer() ?>" class="btn1"><button type="button" class="btn1">返回</button></a>
                        <button type="submit" class="btn2 ajaxbtn" style="margin-left: 50px;">提交</button>
                    </div>
                </div>
            <?php endif ?>
            <?php if ($model['status'] == 1): ?>
                <div class="rignt-con right-con2 right-l">
                    <div class="right-l-con current-dis">
                        <p>
                            <span class="light-sxh">审核：</span>
                        <form style="display: inline-block;">
                            <input type="radio" id="nba" name="status" value="1" checked="'true">
                            <label name="nba" for="nba" class="checked label">
                                <i>已通过</i>
                            </label>

                        </form>
                        </p>
                        <div class="dis-sxh">
                            <p>
                                <span class="light-sxh">备注：</span>
                                <textarea id="des" readonly> <?php echo $model['remarks'] ?></textarea>
                            </p>
                        </div>
                    </div>
                </div>


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
                            <?php foreach ($logs as $k => $v): ?>
                                <tr>
                                    <td><?php echo $v['create_time'] ?></td>
                                    <td><?php echo $v['uname'] ?></td>
                                    <td><?php if ($v['status'] == 1) {
                                            echo '通过审核';
                                        }
                                        if ($v['status'] == 2) {
                                            echo '未通过审核';
                                        } ?></td>
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

            <?php endif ?>

            <?php if ($model['status'] == 2): ?>
                <div class="rignt-con right-con2 right-l">
                    <div class="right-l-con current-dis">
                        <p>
                            <span class="light-sxh">审核：</span>
                        <form style="display: inline-block;">
                            <input type="radio" id="nba" name="status" value="1" checked="'true">
                            <label name="nba" for="nba" class="checked label">
                                <i>未通过</i>
                            </label>

                        </form>
                        </p>
                        <div class="dis-sxh">
                            <p>
                                <span class="light-sxh">备注：</span>
                                <textarea id="des" readonly> <?php echo $model['remarks'] ?></textarea>
                            </p>
                        </div>
                        <div class="dis-sxh2" style="display:block">
                            <p>
                                <span class="light-sxh">原因：</span>
                                <textarea placeholder="必填" id="reason" readonly><?php echo $model['reason'] ?></textarea>
                            </p>
                        </div>
                    </div>
                </div>


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
                            <?php foreach ($logs as $k => $v): ?>
                                <tr>
                                    <td><?php echo $v['create_time'] ?></td>
                                    <td><?php echo $v['uname'] ?></td>
                                    <td><?php if ($v['status'] == 1) {
                                            echo '通过审核';
                                        }
                                        if ($v['status'] == 2) {
                                            echo '未通过审核';
                                        } ?></td>
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

            <?php endif ?>
        </div>
    </div>
</div>
<script>

    $('.ajaxbtn').click(function () {
        var id = <?php echo $_GET['id'] ?>;
        var status = $('input[name="status"]:checked').val();
        var reason = $('#reason').val();
        var des = $("#des").val();
        var status_val = ['1','2'];
        var statusIsOkay = status_val.indexOf(status);
        if(statusIsOkay == '-1'){
            return false;
        }
        if (status == 2) {
            if (reason == '') {
                layer.alert('原因不能为空');
                return false;

            }

        }


        layer.confirm('确认要进行此操作吗', {icon: 3, title: '友情提示'}, function (index) {
            $.post("<?=Url::to(["travel-person/check"])?>", {
                "PHPSESSID": "<?php echo session_id();?>",
                "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                data: {
                    id: id,
                    status: status,
                    des: des,
                    reason: reason,

                },
            }, function (data) {
                data = $.parseJSON(data);
//                console.log(data);return false;
                if (data.status == 1) {

                    layer.alert('操作成功');
                    /*window.location.href = '//php echo \yii\helpers\Url::to(['travel-person/index']) ?>';*/
                    //2017年6月23日18:12:39      付燕飞 修改，操作成功后跳转回的页面记录搜索条件
                    window.location.href = '<?php echo Yii::$app->request->getReferrer() ?>';

                }


            });
        });


    })


</script>
<!--2017年5月18日11:51:55 替换公司资质和个人资质的图片查看插件-->
<script>
    var viewer = new Viewer(document.getElementById('dowebok1'), {
        url: 'data-original'
    });
    var viewer = new Viewer(document.getElementById('dowebok'), {
        url: 'data-original'
    });
    var viewer = new Viewer(document.getElementById('dowebok2'), {
        url: 'data-original'
    });
</script>
<!--<script src="<?//= Yii::$app->request->baseUrl ?>/yulan/dist/zoomify.min.js"></script>-->
<!--<script type="text/javascript">-->
<!--    $('.example').zoomify();-->
<!--</script>-->