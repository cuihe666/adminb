<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = '个人资质修改';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/shenhe_sxh.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/viewer.min.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/commodity-change/css/travel-activity-manage-change.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/shenhe.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>
<script>
    var token = '<?php echo $token;?>';
</script>
<!--上传图片控件-->
<script src="http://cdn.staticfile.org/Plupload/2.1.1/plupload.full.min.js"></script>
<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/upload_img.js?v=88"></script>
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
        width:100px;
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
    .rignt-con select{
        margin-left:15px;
        border: 1px solid #ccc;
        width: 100px;
        height: 30px; line-height: 30px;
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
        /*height:150px;   !*公司审核上传图片拉长 所以给图片加了个高度 4:3*!*/
    }

    .div-sxh input[type="text"]{
        width: 260px!important;
    }

</style>

<div class="right">
    <div class="part_one">
        <div class="top">
            <hr>
        </div>
        <?= Html::beginForm(Url::to('update-person'), 'post', ['enctype' => 'multipart/form-data',"class"=>'person_form']) ?>
            <div class="rignt-con activity_description">
                <p class="div-sxh2">
                    <span class="widspan">头像:</span>
                    <ul style="margin-left:115px!important;">
                        <li style="width: 175px;height: 140px;">
                            <div class="file" id="files">
                                <p id="container0" class="container0 tgpic_item">
                                    <button id="browse0" class="browse0" style="width: 173px;height: 138px;opacity: 0; top:-12px;"></button>
                                    <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto; left:30%!important; top:24%!important;<?=($model && $model->travel_avatar)?'display:none':''?>">
                                    <input type="hidden" value="0" class="idcardz upload_status">
                                    <input type="hidden" value="<?=$model->travel_avatar?>" name="TravelPerson[travel_avatar]" class="card_pic0 hide_val" />
                                </p>
                                <div class="file-list0" style="position: relative">
                                    <?php if($model->travel_avatar): ?>
                                    <img src="<?=$model->travel_avatar?>" alt="" class="add_img" style="margin-left: 0;width: 173px;height: 138px;">
                                    <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                    <?php else:?>
                                    <img src="" alt="" class="add_img" style="margin-left: 0;width: 173px;height: 138px;">
                                    <?php endif;?>

                                </div>
                            </div>
                        </li>
                    </ul>
                </p>
                <p class="div-sxh">
                    <b>
                        <span class="widspan">主页昵称:</span>
                        <input type="text" value="<?php echo $model->nick_name; ?>" name="TravelPerson[nick_name]" class="nick_name" />
                    </b>
                </p>
                <p class="div-sxh">
                    <span class="widspan">联系电话:</span>
                    <input type="text" value="<?php echo $model->mobile ?>" name="TravelPerson[mobile]" class="mobile" maxlength="20" onkeyup="value=value.replace(/[^1234567890]+/g,'')" />
                </p>
                <p class="div-sxh">
                    <span class="widspan">星座:</span>
                    <?= Html::activeDropDownList($model, 'constellation',Yii::$app->params['constellation'] , ['class' => 'mess-select constellation']) ?>
                </p>
                <p class="div-sxh">
                    <span class="widspan">性别:</span>
                    <?= Html::activeDropDownList($model, 'sex',Yii::$app->params['sex'] , ['class' => 'mess-select sex']) ?>
                </p>
                <p class="div-sxh">
                    <b>
                        <span class="widspan">职业:</span>
                        <input type="text" value="<?php echo $model->profession ?>" name="TravelPerson[profession]" class="profession" />
                    </b>
                </p>
                <p class="div-sxh">
                    <span class="widspan">邮箱:</span>
                    <input type="text" value="<?php echo $model->email; ?>" name="TravelPerson[email]" class="email" />
                </p>
                <p class="div-sxh2">
                    <span class="widspan">个人简介:</span>
                    <textarea name="TravelPerson[recommend]" class="recommend" maxlength="300"><?php echo $model->recommend ?> </textarea>
                </p>
                <p class="div-sxh2">
                    <span class="widspan">身份证件照片: <i style="color:#aaa;display:block;text-align:center">(身份证/护照)</i></span>
                    <ul id="dowebok" class="div-sxh2_add">
                        <li>
                            <ul style="margin: 0!important;">
                                <li>
                                    <div class="file" id="files" style="width: 198px;height: 145px;">
                                        <p id="container1" class="container1 tgpic_item">
                                            <button id="browse1" class="browse1" style="width: 198px;height: 145px;opacity: 0;"></button>
                                            <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto;left: 32%!important;top: 25%!important;<?=($model && $model->card_pic_zheng)?'display:none':''?>">
                                            <input type="hidden" value="0" class="idcardz upload_status" />
                                            <input type="hidden" value="<?=$model->card_pic_zheng?>" name="TravelPerson[card_pic_zheng]" class="card_pic1 hide_val" />
                                        </p>
                                        <div class="file-list1" style="position: relative">
                                            <?php if($model->card_pic_zheng): ?>
                                                <img src="<?=$model->card_pic_zheng?>" alt="" class="add_img" style="margin-left: 0;width: 198px;height: 145px;">
                                                <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;" alt="55">
                                            <?php else:?>
                                                <img src="" alt="" class="add_img" style="margin-left: 0;width: 198px;height: 145px;">
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <em>正面</em>
                        </li>
                        <li>
                            <ul style="margin: 0!important;">
                                <li>
                                    <div class="file" id="files" style="width: 198px;height: 145px;">
                                        <p id="container2" class="container2 tgpic_item">
                                            <button id="browse2" class="browse2" style="width: 198px;height: 145px;opacity: 0;"></button>
                                            <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto;left: 32%!important;top: 25%!important;<?=($model && $model->card_pic_fan)?'display:none':''?>">
                                            <input type="hidden" value="0" class="idcardz upload_status">
                                            <input type="hidden" value="<?=$model->card_pic_fan?>" name="TravelPerson[card_pic_fan]" class="card_pic2 hide_val" />
                                        </p>
                                        <div class="file-list2" style="position: relative">
                                            <?php if($model->card_pic_fan): ?>
                                                <img src="<?=$model->card_pic_fan?>" alt="" class="add_img" style="margin-left: 0;width: 198px;height: 145px;">
                                                <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;" alt="6">
                                            <?php else:?>
                                                <img src="" alt="" class="add_img" style="margin-left: 0;width: 198px;height: 145px;">
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <em>反面</em>
                        </li>
                    </ul>
                </p>
                <p class="div-sxh2">
                    <span class="widspan">导游证照片: <i style="color:#aaa;display:block;text-align:center">选填</i></span>
                    <ul id="dowebok1">
                        <li>
                            <div class="file" id="files" style="width: 198px;height: 145px;">
                                <p id="container3" class="container3 tgpic_item">
                                    <button id="browse3" class="browse3" style="width: 198px;height: 145px;opacity: 0;"></button>
                                    <img src="../commodity-change/image/add_pic.png" alt="" class="jia_img" style="width: auto; left:32%!important; top:25%!important;<?=($model && $model->guide_pic)?'display:none':''?>">
                                    <input type="hidden" value="0" class="idcardz upload_status">
                                    <input type="hidden" value="<?=$model->guide_pic?>" name="TravelPerson[guide_pic]" class="card_pic3 hide_val" />
                                </p>
                                <div class="file-list3" style="position: relative">
                                    <?php if($model->guide_pic): ?>
                                        <img src="<?=$model->guide_pic?>" alt="" class="add_img" style="margin-left: 0;width: 198px;height: 145px;">
                                        <img src="../commodity-change/image/shanchu.png" class="dele_img" style="width: 20px;height: 20px;margin-left: 0;position: absolute;right: 0;top: 0; z-index:3;">
                                    <?php else:?>
                                        <img src="" alt="" class="add_img" style="margin-left: 0;width: 198px;height: 145px;">
                                    <?php endif;?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </p>
                <p class="div-sxh">
                    <b>
                        <span class="widspan">真实姓名:</span>
                        <input type="text" value="<?php echo $model->name; ?>" name="TravelPerson[name]" class="name" />
                    </b>
                </p>
                <p class="div-sxh">
                    <b>
                        <span class="widspan">身份证件号:</span>
                        <input type="text" value="<?php echo $model->card ?>" name="TravelPerson[card]" class="card" />
                    </b>
                </p>
                <p class="div-sxh div-sxh_add">
                    <span class="widspan">收款账号类型:</span>
                    <label data="0" class="acction_label">
                        <input value="1" type="radio" <?php if($bankInfo['account_type']==1 || $bankInfo['account_type']==0) echo "checked";?> name="account_type" />
                        <em>银行卡</em>
                    </label>
                    <label data="1" class="acction_label">
                        <input value="2" type="radio" <?php if($bankInfo['account_type']==2) echo "checked";?> name="account_type" />
                        <em>支付宝</em>
                    </label>
                    <input type="hidden" name="bankInfoId" value="<?= $bankInfo['id']?>" />
                </p>
                <div class="bank" style="<?=$bankInfo['account_type'] == 1 || $bankInfo['account_type']==0 ? 'display:block' : 'display:none'?>" >
                    <p class="div-sxh">
                        <b>
                            <span class="widspan">持卡人:</span>
                            <input type="text" value="<?=$bankInfo['account_type'] == 1 ? $bankInfo['account_name'] : ''?>" name="account_name1" class="account_name1" />
                        </b>
                    </p>
                    <p class="div-sxh">
                        <b>
                            <span class="widspan">银行卡卡号:</span>
                            <input type="text" value="<?=$bankInfo['account_type'] == 1 ? $bankInfo['account_num'] : ''?>" name="account_num1" class="account_num1" />
                        </b>
                    </p>
                    <p class="div-sxh">
                        <b>
                            <span class="widspan">开户行:</span>
                            <input type="text" value="<?=$bankInfo['account_type'] == 1 ? $bankInfo['account_bank'] : ''?>" name="account_bank1" class="account_bank" />
                        </b>
                    </p>
                </div>
                <div class="zhifubao" style="<?=$bankInfo['account_type'] == 2 ? 'display:block' : 'display:none'?>" >
                    <p class="div-sxh">
                        <b>
                            <span class="widspan">支付宝名称:</span>
                            <input type="text" value="<?=$bankInfo['account_type'] == 2 ? $bankInfo['account_name'] : ''?>" name="account_name2" class="account_name2" />
                        </b>
                    </p>
                    <p class="div-sxh">
                        <b>
                            <span class="widspan">支付宝账号:</span>
                            <input type="text" value="<?=$bankInfo['account_type'] == 2 ? $bankInfo['account_num'] : ''?>" name="account_num2" class="account_num2" />
                        </b>
                    </p>
                </div>
            </div>
            <div class="submitbtn">
                <input type="hidden" name="person_id" value="<?=$model->id?>" />
                <input type="hidden" name="user_id" value="<?=$model->uid?>" />
                <input type="hidden" name="auth" value="<?=$auth?>"/>
                <button class="submit" style="background: #169bd5;color: white;border: none;">保存</button>
                <a href="<?php echo Yii::$app->request->getReferrer() ?>" class="btn-cancle">返回</a>
            </div>
        <?= Html::endForm();?>
    </div>

</div>

<script type="text/javascript">
    //银行卡/支付宝切换
    $(".acction_label").click(function(){
        var data = $(this).attr("data");
        if(data==0){
            $(".bank").show();
            $(".zhifubao").hide();
        }
        if(data==1){
            $(".zhifubao").show();
            $(".bank").hide();
        }
    })

    // 验证手机号码长度是否超过20位数
    $(".mobile").on("input", function(){
        if($(this).val().length > 20){
            $(this).blur();
            layer.alert("手机号码长度不能超过20位!");
            $(this).val($(this).val().substr(0, 20));
        }
    })

    //提交验证
    $(".submit").click(function(){
        var card_pic = $(".card_pic0").val();
        var nick_name = $(".nick_name").val();
        var mobile = $(".mobile").val();
        var constellation = $(".constellation").val();
        var sex = $(".sex").val();
        var profession = $(".profession").val();
        var email = $(".email").val();
        var recommend = $(".recommend").val();
        var card_pic1 = $(".card_pic1").val();
        var card_pic2 = $(".card_pic2").val();
        var card_pic3 = $(".card_pic3").val();
        var name = $(".name").val();
        var card = $(".card").val();
        var account_type = $("input[name='account_type']:checked").val();
        var account_name1 = $(".account_name1").val();
        var account_num1 = $(".account_num1").val();
        var account_bank = $(".account_bank").val();
        var account_name2 = $(".account_name2").val();
        var account_num2 = $(".account_num2").val();
        var reg_phone = /^1[3|4|5|7|8][0-9]\d{8}$/;
        var reg_email = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        if(card_pic==""){
            layer.alert("头像不能为空");
            return false;
        }
        if(nick_name=="" || nick_name==0){
            layer.alert("主页昵称不能为空");
            return false;
        }
        if(mobile==""){
            layer.alert("联系电话不能为空");
            return false;
        }else if(mobile.length > 20){
            $(".mobile").val($(".mobile").val().substr(0, 20));
        }
        if(profession==""){
            layer.alert("职业不能为空");
            return false;
        }
        if(email==""){
            layer.alert("邮箱不能为空");
            return false;
        } else if(!reg_email.test(email)){
            layer.alert("邮箱格式不正确");
        }
        if(recommend==""){
            layer.alert("个人简介不能为空");
            return false;
        }
        if(card_pic1=="" || card_pic1==0){
            layer.alert("身份证件正面不能为空");
            return false;
        }
        if(card_pic2=="" || card_pic2==0){
            layer.alert("身份证件反面不能为空");
            return false;
        }
        if(name==""){
            layer.alert("真实姓名不能为空");
            return false;
        }
        if(card==""){
            layer.alert("身份证件号不能为空");
            return false;
        }
        if(account_type==1){
            if(account_name1==""){
                layer.alert("持卡人不能为空");
                return false;
            }
            if(account_num1==""){
                layer.alert("银行卡卡号不能为空");
                return false;
            }
            else{
                var res = luhmCheck($(".account_num1"));
                if(res==2){
                    layer.alert("请正确填写银行卡账号");
                    return false;
                }
            }
            if(account_bank==""){
                layer.alert("开户行不能为空");
                return false;
            }
        }
        if(account_type==2){
            if(account_name2==""){
                layer.alert("支付宝名称不能为空");
                return false;
            }
            if(account_num2==""){
                layer.alert("支付宝账号不能为空");
                return false;
            }
        }
        $(".person_form").submit();


        //          银行卡号验证
        function luhmCheck(bankno) {
            var thisval = bankno.val();
            var lastNum = thisval.substr(thisval.length - 1, 1); //取出最后一位（与luhm进行比较）

            var first15Num = thisval.substr(0, thisval.length - 1); //前15或18位
            var newArr = new Array();
            for(var i = first15Num.length - 1; i > -1; i--) { //前15或18位倒序存进数组
                newArr.push(first15Num.substr(i, 1));
            }
            var arrJiShu = new Array(); //奇数位*2的积 <9
            var arrJiShu2 = new Array(); //奇数位*2的积 >9

            var arrOuShu = new Array(); //偶数位数组
            for(var j = 0; j < newArr.length; j++) {
                if((j + 1) % 2 == 1) { //奇数位
                    if(parseInt(newArr[j]) * 2 < 9)
                        arrJiShu.push(parseInt(newArr[j]) * 2);
                    else
                        arrJiShu2.push(parseInt(newArr[j]) * 2);
                } else //偶数位
                    arrOuShu.push(newArr[j]);
            }

            var jishu_child1 = new Array(); //奇数位*2 >9 的分割之后的数组个位数
            var jishu_child2 = new Array(); //奇数位*2 >9 的分割之后的数组十位数
            for(var h = 0; h < arrJiShu2.length; h++) {
                jishu_child1.push(parseInt(arrJiShu2[h]) % 10);
                jishu_child2.push(parseInt(arrJiShu2[h]) / 10);
            }

            var sumJiShu = 0; //奇数位*2 < 9 的数组之和
            var sumOuShu = 0; //偶数位数组之和
            var sumJiShuChild1 = 0; //奇数位*2 >9 的分割之后的数组个位数之和
            var sumJiShuChild2 = 0; //奇数位*2 >9 的分割之后的数组十位数之和
            var sumTotal = 0;
            for(var m = 0; m < arrJiShu.length; m++) {
                sumJiShu = sumJiShu + parseInt(arrJiShu[m]);
            }

            for(var n = 0; n < arrOuShu.length; n++) {
                sumOuShu = sumOuShu + parseInt(arrOuShu[n]);
            }

            for(var p = 0; p < jishu_child1.length; p++) {
                sumJiShuChild1 = sumJiShuChild1 + parseInt(jishu_child1[p]);
                sumJiShuChild2 = sumJiShuChild2 + parseInt(jishu_child2[p]);
            }
            //计算总和
            sumTotal = parseInt(sumJiShu) + parseInt(sumOuShu) + parseInt(sumJiShuChild1) + parseInt(sumJiShuChild2);

            //计算Luhm值
            var k = parseInt(sumTotal) % 10 == 0 ? 10 : parseInt(sumTotal) % 10;
            var luhm = 10 - k;

            if(lastNum == luhm && lastNum.length != 0) {
                return 1;
            } else {
                return 2;
            }
        }

    })

</script>