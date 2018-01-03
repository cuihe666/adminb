<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'KA定制订单详情';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/shenhe_sxh.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"  type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/shenhe.js"  type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>

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
    .follow-div{ width:910px; margin:0 0 40px 0;}
    .follow-text{ margin-top:15px;}
    .follow-text{border: 1px solid #797979; color:#949494; line-height:26px; padding:20px;}
    .follow-text .file{ color:#333333; height:40px; line-height:40px; }
    .rignt-con .follow-text p.file span{ display: inline-block; width: 760px;}
    .button22{ background: none; border:1px solid #797979; color:#333333; width:100px;}
    .subka{ background-color:#367ea9; width:100px; height:30px; line-height:30px; color:#fff; border:0; border-radius:3px;}

    .download-kafiles{ color:#333; border:1px solid #ccc; background-color: #fff; display: inline-block; width:80px; height:30px;
        line-height:30px; margin:0; padding:0; margin-left:15px; border-radius:3px; text-align: center;}

    /*弹出 操作日志*/
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
    .close-div{background-color:#367ea9; color:#fff; margin:20px auto; width:100px; display:block;}
    .follow-logs{width:90%; margin:20px auto;}
    .follow-logs h3{text-align: center;}
    .follow-logs table{ width:100%; border:1px solid #797979;}
    .follow-logs table th{ border:1px solid #797979; height:30px; line-height:30px; text-align: center;}
    .follow-logs table td{ border:1px solid #797979; height:30px; line-height:30px; text-align: center;}

    .j_upload_file_btn{width:86px; height:26px; border:1px solid #797979; line-height:26px; background: none;}

    -->
</style>
<div class="right">
    <form action="" method="post" enctype="multipart/form-data" id="form-follow">
    <div class="part_one">
        <div class="top">
            <hr>
        </div>
        <div class="rignt-con" style="border:0;">
            <h4 class="follow1">跟进定制订单</h4>
            <p class="div-sxh">
                <b class="b1">
                    <span>提交时间：</span>
                    <?php echo date('Y-m-d H:i:s', $model->add_time); ?>
                </b>
                <b class="b2">
                    <span>定制类型：</span>
                    <?php echo Yii::$app->params['custom_type'][$model->custom_type]; ?>
                </b>
            </p>
            <p class="div-sxh">
                <!--<b class="b1">
                    <span>出 发 地：</span>
                    <?php /*echo $model->departure; */?>
                </b>-->
                <b class="b2">
                    <span>目 的 地：</span>
                    <?php
                    if($model->destination)
                        echo $model->destination;
                    else
                        echo "未填写";
                    ?>
                </b>
                <b class="b1">
                    <span>预计出发日期：</span>
                    <?php
                    if($model->departure_time)
                        echo date('Y-m-d', $model->departure_time);
                    else
                        echo "未填写";
                    ?>
                </b>
            </p>
            <p class="div-sxh">
                <!--<b class="b1">
                    <span>预计出发日期：</span>
                    <?php /*echo date("Y-m-d",$model->departure_time); */?>
                </b>-->
                <b class="b2">
                    <span>出行人数：</span>
                    <?php echo $model->adult_num."成人&nbsp;".$model->children_num."儿童"; ?>
                </b>
                <b class="b3">
                    <span>人均预算：</span>
                    <?php echo $model->budget."元/人"; ?>
                </b>
            </p>
            <!--<p class="div-sxh">
                <b class="b1">
                    <span>当地住宿：</span>
                    <?php /*echo Yii::$app->params['stayed_status'][$model->stayed_id]; */?>
                </b>
                <b class="b2">
                    <span>
                        <?php
/*                        if($model->custom_type == 1)
                            echo "定制";
                        elseif($model->custom_type == 2){
                            echo "游玩";
                        }
                        */?>主题：</span>
                    <?php
/*                        if($model->custom_type==3){
                            echo "无";
                        }
                    else {
                        echo $model->custom_type == 1 ? Yii::$app->params['customized_theme_status'][$model->customized_theme] : Yii::$app->params['play_theme_status'][$model->play_theme];
                    }
                    */?>
                </b>
            </p>-->
            <p class="div-sxh">
                <b class="b1">
                    <span>联系人：</span>
                    <?php echo $model->linkman; ?>
                </b>
                <b class="b2">
                    <span>手机号：</span>
                    <?php echo $model->tel; ?>
                </b>
                <!--<b class="b3">
                    <span>电子邮箱：</span>
                    <?php /*echo $model->email; */?>
                </b>-->
            </p>
            <p class="div-sxh">
                <b class="b1" style="width: auto">
                    <span>特殊要求：</span>
                    <?php
                    if($model->remarks)
                        echo $model->remarks;
                    else
                        echo "无";
                    ?>
                </b>
            </p>

            <h4 class="follow1">跟进情况</h4>
            <?php
            if($follows==null){
                echo "暂无跟进情况";
            }
            else{
            ?>

                <?php foreach ($follows as $k => $v): ?>
                <div class="follow-div">
                    <div class="follow-time">
                        跟进记录：<?php echo date("Y-m-d H:i:s",$v['follow_time']);?>
                    </div>
                    <div class="follow-text">
                        <p class="text"><?php echo $v['follow_remark'];?></p>
                        <?php
                            if($v['follow_file']!=null || $v['follow_file']!=''){
                                $fileArr = explode(",",$v['follow_file']);
                                foreach($fileArr as $k=>$v):
                                    ?>
                                <p class="file"><span>附件：<?php echo $v;?></span> <a href="<?php echo Yii::$app->params['imgUrl'].$v;?>" class="download-kafiles">下载</a></p>
                        <?php
                                endforeach;
                            }
                        ?>
                    </div>
                </div>
                <?php endforeach;?>

            <?php }?>
                <input type="hidden" name="orderid" id="orderid" value="<?php echo $model->orderid;?>" />
                <div class="follow-div">
                    <div class="follow-time">
                        跟进记录：
                    </div>
                    <div class="follow-text" style="padding:8px; border:0;">
                        <p class="text" style="margin-bottom: 20px;">
                            <textarea id="uploadEditor" class="follow_remark" style="width:900px; height:220px; resize: none;" name="follow_remark"></textarea>
                        </p>
                        <button type="button" id="j_upload_file_btn" class="j_upload_file_btn">附件上传</button>
                        <span style="padding-left:10px; color:#c9302c;">备注：可上传.doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .txt,.rar, .zip, .tar, .gz, .7z格式的文件</span>
                        <ul id="upload_file_wrap"></ul>
                    </div>
                </div>
                <div class="follow-div">
                    <div class="follow-time">
                        是否已完成定制：
                        <input type="checkbox" value="2" name="follow_status" style="display:inline-block; height:auto;" />
                        <label name="nba" for="nba" class="checked ">
                            <i>已完成</i>
                        </label>
                    </div>
                </div>
        </div>
    </div>
    <?php
    if($model->follow_status==0)
        $url = "index";
    if($model->follow_status==1)
        $url = "indexa";
    if($model->follow_status==2)
        $url = "indexb";
    ?>
    <div class="part_two">
        <div class="right-l-btn" style="text-align: center">
            <a href="javascript:showDivFun();" class="btn1"><button type="button" class="btn1 btn btn-sm btn-primary button22">查看操作日志</button></a>
            &nbsp;&nbsp;
            <a href="<?php echo  Url::to(['ka-order/'.$url]) ?>" class="btn1"><button type="button" class="btn1 btn btn-sm btn-primary button22">返回</button></a>
            &nbsp;&nbsp;
            <input type="hidden" name="filePath" value="" id="filePath" />
            <input type="button" name="sub" value="提交" onclick="checkForm()" class="subka" />
        </div>
    </div>
    </form>
</div>

<div id="popDiv" class="mydiv" style="display:none;">
    <div align="right" style="padding:2px;z-index:2000;font-size:12px;cursor:pointer;position:absolute;right:0;" onclick="closeDivFun()">
        <span style="border:1px solid #000;width:12px;height:12px;line-height:12px;text-align:center;display:block;background-color:#FFFFFF;left:-20px;">×</span>
    </div>
    <div class="follow-logs">
        <?php if(($follows)!=null){?>
            <h3>操作日志</h3>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th>时间</th>
                    <th>操作人</th>
                    <th>操作内容</th>
                </tr>
                <?php foreach ($follows as $k => $v): ?>
                    <tr>
                        <td><?php echo date("Y-m-d H:i:s",$v['follow_time'])?></td>
                        <td><?php echo $v['follow_adminname'];?></td>
                        <td><?php echo $v['follow_logs'];?></td>
                    </tr>
                <?php endforeach;?>
            </table>
            <?php
        }else{
            echo "<h4 style='text-align: center; margin:50px auto;'>暂无操作日志！</h4>";
        }?>
    </div>
    <a href="javascript:closeDivFun()" class="btn1 btn btn-sm btn-primary button22 close-div">关闭窗口</a>
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

</script>
<!-------------submit提交验证------------------>
<script type="text/javascript">
    var post_flag = false;
    function checkForm(){
        if(UE.getEditor('uploadEditor').getContentTxt()==""){
            layer.alert("请填写跟进记录");
            $(".follow_remark").focus();
            return false;
        } else{
            if(post_flag) {
                layer.alert('请不要重复提交订单');
                return;
            }
            post_flag = true;
            if($("#upload_file_wrap").text()!=""){
                var filePath = "";
                $("#upload_file_wrap li a").each(function () {
                    filePath += $(this).text()+",";
                });
                $("#filePath").val(filePath);
            }
            $("#form-follow").submit();
        }

    }
</script>
<!------------上传图片控件-------------------->
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/ueditor/ueditor.all.js"></script>
<!-- 使用ue -->
<script type="text/javascript">

    // 实例化编辑器，这里注意配置项隐藏编辑器并禁用默认的基础功能。
    /*var ue = UE.getEditor('uploadEditor');*/

    var uploadEditor = UE.getEditor("uploadEditor", {
        isShow: true,
        focus: false,
        enableAutoSave: true,
        autoSyncData: true,
        autoFloatEnabled:true,
        wordCount: true,
        sourceEditor: false,
        scaleEnabled:false,
        elementPathEnabled:false,
        maximumWords:2000,
        toolbars: [[
            'bold', 'forecolor', 'selectall', 'cleardoc', '|',
            'fontfamily', 'fontsize', '|',
            'attachment']]
    });
    //给编辑器传递参数filename和kaid，    付燕飞2017年3月23日10:48:10
    uploadEditor.ready(function() {
        uploadEditor.execCommand('serverparam', function(editor) {
            return {
                'filename': 'kafiles',
                'kaid':$("#orderid").val(),
            };
        });
    });

    // 监听编辑器输入字数超过最大字数后不允许输入动作   付燕飞2017年3月23日11:41:35添加
    uploadEditor.addListener("keyup", function(type, event) {
        var count = uploadEditor.getContentLength(true);
        if(count>2000){
            var contentText = uploadEditor.getContentTxt();
            uploadEditor.setContent(contentText.substring(0, 2000));
        }
    });

    // 监听上传附件组件的插入动作
    uploadEditor.ready(function () {
        uploadEditor.addListener("afterUpfile",_afterUpfile);
    });

    document.getElementById('j_upload_file_btn').onclick = function () {
        var dialog = uploadEditor.getDialog("attachment");
        dialog.title = '附件上传';
        dialog.render();
        dialog.open();
    };

    // 附件上传
    function _afterUpfile(t, result) {
        var fileHtml = '';
        for(var i in result){
            //判断上传附件的路径是否在编辑器的内容当中[编辑器为ifames框架加载，因此需要通过$("#ueditor_0").contents()获取ifames框架中的内容]。
            //如果存在的话，删除找到的a标签的父级元素p标签。
            if($("#ueditor_0").contents().find("a[href='"+result[i].url+"']")){
                $("#ueditor_0").contents().find("a[href='"+result[i].url+"']").parent().remove();
            }
            fileHtml += '<li><a href="'+result[i].url+'" target="_blank">'+result[i].url+'</a></li>';
        }
        $("#upload_file_wrap").append(fileHtml);
    }
</script>


