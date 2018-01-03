<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '修改优惠券';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/skin/default/datepicker.css"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
<style>
    <!--
    .hr-border{background-color:green;height:2px;border:none; margin: 0;}
    .clear{clear: both}
    .thematic_form{}
    .thematic_ul{ margin:20px auto; font-size:14px;}
    .thematic_ul li{ list-style: none; line-height: 32px; margin-bottom:10px; overflow: hidden; zoom:1; }
    .thematic_ul li label{ font-weight: normal; display: inline-block; width:150px; text-align: right; padding-right: 10px;}
    .input_text{ width:400px; height: 30px; line-height: 30px; padding:0 2px; border:1px solid #999999}
    .area_text{ width:400px; height: 100px; line-height: 20px; padding: 0 2px; border:1px solid #999999; resize: none;}
    .thematic_ul li i{ font-style: normal; color: #aaaaaa; font-size:12px; display: inline-block; margin-left:5px;}
    .a_button{ width:86px; height: 26px; line-height: 26px; color: #fff; background-color: #3c8dbc; display: inline-block; text-align: center;border-radius:3px; margin-left:10px;}
    .a_button:hover{ color: #fff;}
    .thematic_submit{ margin-left: 120px; margin-top:20px;}

    .coupon_select{ width:100px; height: 30px;line-height:30px;;}
    -->
</style>

<hr class="hr-border">
<div class="user-backend-create">
    <div class="user-backend-form">
        <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'thematic_form']) ?>
        <ul class="thematic_ul">
            <li>
                <label>优惠券礼包名称：</label>
                <input type="text" class="input_text" maxlength="15" name="Coupon1Activity[title]" value="<?=$activity['title']?>" />
                <i class="error_name prom">最多不超过15字</i>
            </li>
            <li>
                <label>预设库存量：</label>
                <input type="number" class="input_text storage" max="1000000" min="1" oninput="if(value>1000000) value=1000000" name="Coupon1Activity[storage]" value="<?=$activity['storage']?>" />
                <i class="error_storage prom">最大可设置1000000</i>
            </li>
            <li>
                <label>每日领取的最大数量：</label>
                <input type="number" class="input_text" max="100000" min="0" oninput="if(parseInt(value)>parseInt($('.storage').val())){value=$('.storage').val();}" name="Coupon1Activity[daily_max]" value="<?=$activity['daily_max']?>" />
                <i class="error_creator prom">最大可设置100000【0为不限制】</i>
            </li>
            <li>
                <label>发放开始时间：</label>
                <input id="d422" name="Coupon1Activity[start_time]" value="<?=$activity['start_time']?>" class="input_text" type="text" onfocus="var d4312=$dp.$('d4312');WdatePicker({readOnly:true,minDate:'%y-%M-{%d} 00:00:00',maxDate:'#F{$dp.$D(\'d4312\')}',dateFmt:'yyyy-MM-dd 00:00:00',onpicked:function(){d4312.focus()}})" placeholder="请设置开始时间" readonly="">
                <i class="error_start_time"></i>
            </li>
            <li>
                <label>发放结束时间：</label>
                <input id="d4312" class="input_text" name="Coupon1Activity[end_time]" value="<?=$activity['end_time']?>" type="text" placeholder="请设置结束时间" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'d422\')}',dateFmt:'yyyy-MM-dd 00:00:00',readOnly:true})" readonly="">
                <i class="error_end_time"></i>
            </li>
            <li>
                <label>状态：</label>
                <select name="Coupon1Activity[status]" class="coupon_select">
                    <option value="0" <?php if($activity['status']==0) echo "selected"?>>正常</option>
                    <option value="1" <?php if($activity['status']==1) echo "selected"?>>禁用</option>
                </select>
            </li>
            <li>
                <label>发放对象：</label>
                <?php
                $couponArr = json_decode($thematic->coupon_activity_id,true);
                ?>
                <select name="Coupon1Activity[object]" class="coupon_select" disabled>
                    <option value="0" <?php if(in_array($activity['activity_id'],$couponArr['all'])) echo "selected";?>>所有用户</option>
                    <option value="1" <?php if(in_array($activity['activity_id'],$couponArr['old'])) echo "selected";?>>老用户</option>
                    <option value="2" <?php if(in_array($activity['activity_id'],$couponArr['new'])) echo "selected";?>>新用户</option>
                </select>
            </li>
            <li style="position: relative; overflow: inherit;">
                <label>优惠券批次：</label>
                <input type="text" class="input_text coupon_batch_add" name="" value="" placeholder="请输入优惠券批次编码/标题名称" />
                <input type="hidden" class="hiddenid" name="Coupon1Activity[coupon_activity_id]" value="" tg="0" />
                <i class="error_coupon_batch"></i>
            </li>
            <?php
            if($batch)
                $style=' style="display: block;"';
            else
                $style=' style="display: none;"';
            ?>
            <div class="coupon_list" <?=$style?>>
                <p class="coupon_p_title">
                    <span class="span_info">批次名称</span>
                    <span class="span_info">批次编码</span>
                    <span class="span_info">优惠券期限</span>
                    <span class="span_info">优惠券金额</span>
                    <span class="span_info">满减规则</span>
                    <span class="span_info">每人领取数量</span>
                    <span class="span_cz">操作</span>
                </p>
                <?php
                if($batch){
                    foreach($batch as $key=>$val){
                        if($val['is_forever']==1)
                            $youxiaoqi =  "永久有效";
                        else{
                            $youxiaoqi = substr($val['start_time'],0,10) . " 至 ". substr($val['end_time'],0,10);
                        }
                ?>
                    <p class="coupon_info code_<?=$val['batch_code']?>">
                        <span class="span_info"><a href=""><?=$val['title']?></a></span>
                        <span class="span_info"><?=$val['batch_code']?></span>
                        <span class="span_info"><?=$youxiaoqi?></span>
                        <span class="span_info"><?=$val['amount']?></span>
                        <span class="span_info"><?=$val['rule']?></span>
                        <span class="span_info"><input type="number" min="1" max="<?=$val['max_num']?>" value="<?=$val['used_num']?>" style="text-align: center;" name="used_num[]"  oninput="if(value><?=$val['max_num']?>){ value=<?=$val['max_num']?>;layer.alert(\'最大值<?=$val['max_num']?>\');}" /></span>
                        <?php
                        if($val['batch_code']!=$batch[$key-1]['batch_code']):
                        ?>
                        <span class="span_cz" data="<?=$val['batch_code']?>">删除</span>
                            <?php
                            endif;
                            ?>
                        <input type="hidden" name="batch_code[]" value="<?=$val['batch_code']?>" />
                        <input type="hidden" name="batch_id[]" value="<?=$val['batch_id']?>" />
                    </p>
                <?php
                    }
                }
                ?>
            </div>
            <span class="clear"></span>
            <div class="thematic_submit">
                <input type="hidden" name="activity_id" value="<?=$activity['activity_id']?>" />
                <?= Html::a("返回",$url = ['thematic-coupon/index','id'=>$thematicId],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:22px;"]) ?>&nbsp;&nbsp;&nbsp;&nbsp;
                <?= Html::submitButton('保存', ['class' => 'btn btn-success sub']) ?>
            </div>
        </ul>
        <?= Html::endForm();?>


    </div>

</div>
<script>
    $(".thematic_submit").on("click",".sub",function(){
        var title = $("input[name='Coupon1Activity[title]']").val();
        var start_time = $("input[name='Coupon1Activity[start_time]']").val();
        var end_time = $("input[name='Coupon1Activity[end_time]']").val();
        var storage = $("input[name='Coupon1Activity[storage]']").val();
        var daily_max = $("input[name='Coupon1Activity[daily_max]']").val();
        var coupon_activity_id = $("input[name='Coupon1Activity[coupon_activity_id]']").val();

        if(title.length==0){
            $(".error_name").text("请输入优惠券礼包名称").css("color","red");
            return false;
        }
        else{
            $(".error_name").text("最多不超过15字").css("color","#aaa");
        }

        if(start_time.length==0){
            $(".error_start_time").text("请选择开始时间").css("color","red");
            return false;
        }
        else{
            $(".error_start_time").text("");
        }

        if(end_time.length==0){
            $(".error_end_time").text("请选择结束时间").css("color","red");
            return false;
        }
        else{
            $(".error_end_time").text("");
        }

        if(storage.length==0){
            $(".error_creator").text("请输入预设库存量").css("color","red");
            return false;
        }
        else{
            $(".error_storage").text("最大可设置1000000").css("color","#aaa");
        }

        if(daily_max.length==0){
            $(".error_share_title").text("请输入每日领取的最大数量").css("color","red");
            return false;
        }
        else{
            if(parseInt(daily_max)>parseInt(storage)){
                $("input[name='Coupon1Activity[daily_max]']").val(storage);
            }
        }
            $(".error_daily_max").text("最大可设置1000000").css("color","#aaa");
        }



        $(".thematic_form").submit();

    });
</script>
<!--添加优惠券批次-->
<style>
    .region123{ margin-left:0; background-color: #fff; padding-left:10px; border:1px solid #efefef; border-top:0; margin-top:-2px; height: 330px; overflow-y: scroll; position:absolute; z-index:9; width:400px; left:153px; top:32px; border:1px solid #999;}
    .region123 li{ height: 26px; line-height: 26px; cursor: pointer;}
    .region123 li span{ display: inline-block; width:178px; text-align: center;}
    .region123 li span.title{ font-weight: bold;}
    .coupon_list{ display: none;}
    .coupon_list p{ height: 24px; line-height: 24px;}
    .coupon_list p span{}
    .coupon_list p span.span_info{ width:200px; display: inline-block; text-align: center;}
    .coupon_list p.ajax_add span{ margin-right: 3px;}
    .coupon_list p span.span_cz{ width:50px; display: inline-block; text-align: center;}
    .coupon_list p.coupon_p_title span{ font-weight: bold}
</style>
<script>
//    输入框的值变换时搜索
    $(".coupon_batch_add").on("input propertychange",function(){
        var _this = $(this);
        var name = $(this).val();
        //把tg设置为0
        $(this).siblings(".hiddenid").attr("tg",0);
        if(name!=''){
            $.ajax({
                type: 'GET',
                url: '<?= \yii\helpers\Url::toRoute(["thematic-coupon/get-coupon-batch"])?>',
                data: {"name": name},
                dataType: 'json',
                success: function (data) {
                    if(data!=""){
                        var html = '<ul id="city1" class="form-control region123" name="" ><li><span class="title">批次名称</span><span class="title">批次编码</span></li>';
                        $.each(data, function(index, content){
                            html += '<li data="'+content.id+'">' +
                                '<span>'+content.title.replace(name, '<b style="color:red; font-weight:normal">'+name+'</b>')+'</span>' +
                                '<span>'+content.batch_code.replace(name, '<b style="color:red; font-weight:normal">'+name+'</b>')+'</span>' +
                                '<input type="hidden" value="'+content.is_forever+'" class="is_forever">' +
                                '<input type="hidden" value="'+content.start_time+'" class="start_time">' +
                                '<input type="hidden" value="'+content.end_time+'" class="end_time">' +
                                '<input type="hidden" value="'+content.amount+'" class="amount">' +
                                '<input type="hidden" value="'+content.rule+'" class="rule">' +
                                '<input type="hidden" value="'+content.max_num+'" class="max_num">' +
                                '</li>';
                        });
                        html += '</ul>';
                        _this.next("#city1").remove();
                        _this.after(html);
                    }
                    else{
                        _this.next("#city1").remove();
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    //alert(22);
                    /*_this.val("");
                     _this.blur();*/
                }
            });
        }
        else{
            $(this).next("#city1").remove();
        }
    });

//选择结果，并添加的列表中
    /*$("body").on("click",".region123 li",function(){
        var id = $(this).attr("data");        //优惠券id
        var name = $(this).find("span").eq(0).text();  //优惠券名称
        var code = $(this).find("span").eq(1).text();  //优惠券编码
        var is_forever = $(this).find(".is_forever").val();   //有效期
        var start_time = $(this).find(".start_time").val();   //有效期开始时间
        var end_time = $(this).find(".end_time").val();       //有效期结束时间
        var amount = $(this).find(".amount").val();           //优惠券金额
        var rule = $(this).find(".rule").val();               //优惠券满减规则
        var max_num = $(this).find(".max_num").val();        //每个账号最大可领取张数
        var hiddenid = $(".hiddenid").val();
        var idstr = hiddenid+","+id;
        $(this).parent().siblings(".coupon_batch_add").val("");   //清空输入框中的内容
        $(this).parent().siblings(".hiddenid").val(idstr);         //记录选中的优惠券
        $(this).parent().siblings(".hiddenid").attr("tg",1);
        if(is_forever==1){
            youxiaoqi = "永久有效";
        } else{
            youxiaoqi = (start_time).substr(0, 10)+"至"+(end_time).substr(0, 10);
        }
        $(".coupon_list").show();
        var html = '<p class="coupon_info ajax_add">' +
            '<span class="span_info"><a href="">'+name+'</a></span>' +
            '<span class="span_info">'+code+'</span>' +
            '<span class="span_info">'+youxiaoqi+'</span>' +
            '<span class="span_info">'+amount+'</span>' +
            '<span class="span_info">'+rule+'</span>' +
            '<span class="span_info"><input type="number" min="1" max='+max_num+' value="1" style="text-align: center;" name="used_num[]"  oninput="if(value>'+max_num+'){ value='+max_num+';layer.alert(\'最大值'+max_num+'\');}" /></span>' +
            '<span class="span_cz" data="'+id+'">删除</span>' +
            '<input type="hidden" name="batch_code[]" value="'+code+'" />' +
            '</p>';
        $(".coupon_list").append(html);
        $(this).parent().remove();
    });*/
    $("body").on("click",".region123 li",function(){
        var _this = $(this);
        var id = $(this).attr("data");        //优惠券id
        var name = $(this).find("span").eq(0).text();  //优惠券名称
        var code = $(this).find("span").eq(1).text();  //优惠券编码
        var is_forever = $(this).find(".is_forever").val();   //有效期
        var start_time = $(this).find(".start_time").val();   //有效期开始时间
        var end_time = $(this).find(".end_time").val();       //有效期结束时间
        var amount = $(this).find(".amount").val();           //优惠券金额
        var rule = $(this).find(".rule").val();               //优惠券满减规则
        var max_num = $(this).find(".max_num").val();        //每个账号最大可领取张数
        var hiddenid = $(".hiddenid").val();
        var idstr = hiddenid+","+id;
        $(this).parent().siblings(".coupon_batch_add").val("");   //清空输入框中的内容
        $(this).parent().siblings(".hiddenid").val(idstr);         //记录选中的优惠券
        $(this).parent().siblings(".hiddenid").attr("tg",1);
        $.ajax({
            type: 'GET',
            url: '<?= \yii\helpers\Url::toRoute(["thematic-coupon/get-coupon-batch-list"])?>',
            data: {"code": code},
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if(data){
                    $(".coupon_list").show();
                    var html = "";
                    $.each(data,function(key,val){
                        //优惠券有效期
                        if(val.is_forever==1){
                            youxiaoqi = "永久有效";
                        } else{
                            youxiaoqi = (val.start_time).substr(0, 10)+"至"+(val.end_time).substr(0, 10);
                        }
                        html += '<p class="coupon_info ajax_add code_'+val.batch_code+'">' +
                            '<span class="span_info"><a href="">'+val.title+'</a></span>' +
                            '<span class="span_info">'+val.batch_code+'</span>' +
                            '<span class="span_info">'+youxiaoqi+'</span>' +
                            '<span class="span_info">'+val.amount+'</span>' +
                            '<span class="span_info">'+val.rule+'</span>' +
                            '<span class="span_info"><input type="number" min="1" max='+val.max_num+' value="1" style="text-align: center;" name="used_num[]"  oninput="if(value>'+val.max_num+'){ value='+val.max_num+';layer.alert(\'最大值'+val.max_num+'\');}" /></span>';
                            if(key==0){
                                html += '<span class="span_cz" data="'+val.batch_code+'">删除</span>';
                            }
                        html += '<input type="hidden" name="batch_code[]" value="'+val.batch_code+'" />' +
                            '<input type="hidden" name="batch_id[]" value="'+val.id+'" />' +
                            '</p>';
                    });
                    $(".coupon_list").append(html);
                    _this.parent().remove();
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                //alert(22);
                /*_this.val("");
                 _this.blur();*/
            }
        });
    });

//删除相应的列表
    $("body").on("click",".span_cz",function(){
        var code = $(this).attr("data");
        //alert(code);
        $(".code_"+code).remove();
        //$(this).parent(".coupon_info").remove();
    })
</script>
