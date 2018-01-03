<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '用户详情';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/shenhe_sxh.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/shenhe.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<!--图片放大控件-->
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/viewer.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/viewer.min.js"></script>

<style>
    <!--
    .rignt-con p span{ width:120px; }
    .div-sxh b{ display:inline-block;}
    .div-sxh .b1{ width:30%;}
    .div-sxh .b2{ width:30%;}
    .div-sxh .b3{ width:auto;}
    h4.follow1{ margin-top:20px; border-bottom: 1px solid #666; heigh:38px; line-height:38px; font-weight:bold;}
    .rignt-con .follow-text p{ margin-bottom: 0;}
    .rignt-con .follow-text p span{ width:auto; display: inline; text-align: left;}
    .follow-div{ width:910px; margin:20px 0;}
    .follow-text{ margin-top:15px;}
    .follow-text{border: 1px solid #797979; color:#949494; line-height:26px; padding:20px; padding-bottom:0px;}
    .follow-text .file{ color:#333333; height:40px; line-height:40px; }
    .rignt-con .follow-text p.file span{ display: inline-block; width: 760px;}
    .download-kafiles{ color:#333; border:1px solid #ccc; background-color: #fff; display: inline-block; width:80px; height:30px;
        line-height:30px; margin:0; padding:0; margin-left:15px; border-radius:3px; text-align: center;}

    /*弹出*/
    .mydiv {
        line-height: 20px;
        border: 1px solid #0080FF;
        font-size: 12px;
        z-index: 999;
        width: 800px;
        max-height:500px;
        overflow-y:scroll;
        left: 40%;
        top: 23%;
        margin-left: -150px !important; /*FF IE7 该值为本身宽的一半 */
        margin-top: -60px !important; /*FF IE7 该值为本身高的一半*/
        margin-top: 0px;
        position: fixed !important; /* FF IE7*/
        position: absolute; /*IE6*/
        background-color: #fff;
        border: 1px solid #797979;
    }
    .close-div{background-color:#169BD5; color:#fff; margin:20px auto; width:100px; display:block;}
    .follow-logs{width:90%; margin:20px auto;}
    .follow-logs h3{text-align: center;}
    .follow-logs table{ width:100%; border:1px solid #797979;}
    .follow-logs table th{ border:1px solid #797979; height:30px; line-height:30px; text-align: center;}
    .follow-logs table td{ border:1px solid #797979; height:30px; line-height:30px; text-align: center;}
    .part_two .right-l-btn button.btn1 {
        background-color: #3c8dbc;
        border: 1px solid #555;
    }
    .table_info,.table_list_log{ width:95%; border-top:1px solid #999; border-right:1px solid #999;}
    .table_info th,.table_info td{ border-left:1px solid #999; border-bottom: 1px solid #999; height: 42px; line-height: 42px;}
    .table_info th{ width:20%; text-align: right; padding-right: 10px; background-color:#F2F2F2; font-weight: normal; }
    .table_info td{ padding-left: 15px; text-align: left;}

    .table_list_log th,.table_list_log td{ height: 32px; line-height: 32px; text-align: center; font-weight: normal; border-left:1px solid #999; border-bottom: 1px solid #999;}

    /*2017年5月18日12:11:11 查看图片插件样式*/
    #dowebok li{
        display: inline-block;
        width:200px ;
        margin:0 10px 0 0;
    }

    #dowebok li img{
        width: 100%;
    }

    -->
</style>
<div class="right">
    <div class="part_one">
        <div class="top">
            <hr>
        </div>
        <div class="rignt-con" style="border:0;">
            <h4 class="follow1">基本信息</h4>
            <table class="table_info" cellspacing="0" cellpadding="0">
                <tr>
                    <th>用户ID：</th>
                    <td><?=$info['id'];?></td>
                </tr>
                <tr>
                    <th>账号：</th>
                    <td><?=$info['mobile'];?></td>
                </tr>
                <tr>
                    <th>昵称：</th>
                    <td><?=$info['nickname'];?></td>
                </tr>
                <tr>
                    <th>注册时间：</th>
                    <td><?=$info['create_time'];?></td>
                </tr>
                <tr>
                    <th>城市：</th>
                    <td><?=$city['city'];?></td>
                </tr>
                <tr>
                    <th>区域：</th>
                    <td><?=$city['area'];?></td>
                </tr>
                <tr>
                    <th>状态：</th>
                    <td><?= empty(Yii::$app->params['house']['house_auth_status'][$info['auth']]) ? '' : Yii::$app->params['house']['house_auth_status'][$info['auth']]?></td>
                </tr>
            </table>
            <h4 class="follow1">认证信息</h4>
            <table class="table_info" cellspacing="0" cellpadding="0">
                <tr>
                    <th>姓名：</th>
                    <td><?=$info['name'];?></td>
                </tr>
                <tr>
                    <th>身份证号：</th>
                    <td><?=$info['number'];?></td>
                </tr>
                <tr>
                    <th>照片：</th>
                    <td style="padding:15px;">
                        <ul id="dowebok" class="div-sxh2_add">
                            <li>
                                <?php if($info['number_pic']):?>
                                    <img data-original="<?= (stripos($info['number_pic'], 'img.tgljweb.com') === false) ? ('http://img.tgljweb.com/'.$info['number_pic']) : $info['number_pic']?>" src="<?= (stripos($info['number_pic'], 'img.tgljweb.com') === false) ? ('http://img.tgljweb.com/'.$info['number_pic']) : $info['number_pic']?>" alt="" class="example img-rounded">
                                <?php endif;?>
                            </li>
                        </ul>

                    </td>
                </tr>
                <tr>
                    <th>更新时间：</th>
                    <td><?=$info['update_time'];?></td>
                </tr>
            </table>
            <h4 class="follow1">操作日志</h4>
            <table class="table_list_log" cellspacing="0" cellpadding="0">
                <tr>
                    <th>操作人</th>
                    <th>时间</th>
                    <th>操作事件</th>
                    <th>备注</th>
                </tr>
                <?php
                if($logs):
                foreach($logs as $key=>$val):
                ?>
                <tr>
                    <td><?=$val['optname']?></td>
                    <td><?=$val['opttime']?></td>
                    <td><?=Yii::$app->params['house']['house_auth_status'][$val['afterstatus']]?></td>
                    <td><?=$val['reason']?></td>
                </tr>
                <?php
                endforeach;
                endif;
                ?>
            </table>
        </div>
        <div class="part_two">
            <div class="right-l-btn" style="text-align: center">
                <input type="hidden" name="uid" value="<?=$info['id'];?>" class="uid" />
                <?php
                if($info['auth']==1):
                ?>
                <a href="javascript:;" class="btn1"><button type="button" class="btn1 btn btn-sm btn-primary sub_check">审核</button></a>
                <?php
                endif;
                ?>
                &nbsp;&nbsp;<a href="<?php echo Yii::$app->request->getReferrer() ?>" class="btn1"><button type="button" class="btn1 btn btn-sm btn-primary">返回</button></a>
            </div>
        </div>
    </div>

</div>



<!--弹出框-->
<style>
    .modal-content{width:700px; left:20%;}
    .modal-body p{ line-height: 32px; margin-bottom:10px;}
    .modal-body p label{ width:140px; display: inline-block; text-align: right; font-weight: normal; padding-right:5px;}
    .modal_text{ width:80px; height:30px; line-height: 30px; border:1px solid #ccc; padding:0 4px;}
    .higo_name{ width:500px; height: 30px; line-height: 30px; display: inline-block;}
    .modal-footer{ text-align: center;}
    .close_1,.m_commit{ margin: 0 auto; display: inline-block; width: 120px;}
    .t_name{ text-align: center; margin-bottom: 30px;}
    .modal_i{ display: block; font-style: normal; font-size: 12px; color: #FF0000;}
    .m_remark{ font-style: normal; font-size:12px; color: #FF0000; display: inline-block; margin-left:5px;}
    .clear{ clear: both;}
    .moda1_sort,.moda1_reject{display: none;}
    .m_reason{width:400px; height:120px; border: 1px solid #ccc;}
    .check_select{ width: 140px; border:1px solid #ccc;}
    .check_reason span{ display: block;}

    .default{ display: none;}
</style>
<div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="more_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title t_name" id="myLargeModalLabel"></h4>-->
            </div>
            <!--        驳回弹框            -->
            <div class="moda1_reject">
                <div class="modal-body" style="overflow: hidden;">
                    <h4 class="modal-title t_name" id="myLargeModalLabel">审核</h4>
                    <p>
                        <label style="float: left">审核：</label>
                        <select name="check_status" class="check_select">
                            <option value="2">通过</option>
                            <option value="3">不通过</option>
                        </select>
                    </p>
                    <p class="check_reason default">
                        <label style="float: left; height: 150px;">具体原因：</label>
                        <span><input type="checkbox" name="check_reason[]" value="1"> 照片模糊不清晰</span>
                        <span><input type="checkbox" name="check_reason[]" value="2"> 照片非身份证照片</span>
                        <span><input type="checkbox" name="check_reason[]" value="3"> 姓名与照片中不对应</span>
                        <span><input type="checkbox" name="check_reason[]" value="4"> 身份证号与照片中不对应</span>
                    </p>
                    <p style="clear: both"></p>
                    <p class="default">
                        <label style="float: left">自定义原因：</label>
                        <textarea name="reason" class="m_reason"></textarea>
                        <em class="m_remark m_reason_e" style="display: block; margin-left: 140px;"></em>
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="higo_id" class="m_higo_id" value="" />
                    <button type="button" class="btn btn-primary m_commit_r">提交</button>
                    <button type="button" class="btn btn-default close_1" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //弹出调用的方法
    function showDivFun(){
        document.getElementById('popDiv').style.display='block';
    }
    //关闭事件
    function closeDivFun(){
        document.getElementById('popDiv').style.display='none';
    }


    //点击驳回弹出框
    $(".sub_check").click(function(){
        var id = $(".uid").val();
        $(".moda1_reject").show();
        $("#more_modal").modal("show");
        $(".moda1_reject .m_higo_id").val(id);
    })

    $(".check_select").change(function(){
        if($(this).val()==3){
            $(".default").show();
        }
        if($(this).val()==2){
            $(".default").hide();
        }
    })

    //排序弹框提交按钮ajax处理数据
    $(".m_commit_r").click(function(){
        var m_reason = $(".m_reason").val();
        var user_id = $(".uid").val();
        var status = $(".check_select").val();
        var reasonOther = $(".m_reason").val();
        var reasonArr = new Array();
        $("input[name='check_reason[]']:checked").each(function(){
            reasonArr.push($(this).val());
        })
        var reasonStr = reasonArr.join(",");
        if(status == 3 && reasonStr == "" && reasonOther == ""){
            $(".m_reason_e").text("请选择具体原因或者填写自定义原因");
            return false;
        }else{
            $(".m_reason_e").text("");
        }
        $.post("<?=Url::to(["user/update-status"])?>", {
            "PHPSESSID": "<?php echo session_id();?>",
            "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
            data: {
                "uid":user_id,
                "status":status,
                "reasonOther":reasonOther,
                "reasonStr":reasonStr,
            },
        }, function (data) {
            var obj = eval("("+data+")");
            $("#more_modal").modal("hide");
            layer.alert(obj.msg);
            window.location.href="<?php echo Yii::$app->request->getReferrer() ?>";
        });
    })



</script>

<!--2017年5月18日11:51:55 替换公司资质和个人资质的图片查看插件-->
<script>
    var viewer = new Viewer(document.getElementById('dowebok'), {
        url: 'data-original'
    });

</script>
