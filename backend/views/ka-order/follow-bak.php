<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'KA定制订单详情';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" type="text/css" href="css/shenhe_sxh.css">
<script src="js/jquery.min.js"></script>
<script src="js/shenhe.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>

<style>
    <!--
    .rignt-con p span{ width:120px; }
    .div-sxh b{ display:inline-block;}
    .div-sxh .b1{ width:25%;}
    .div-sxh .b2{ width:25%;}
    .div-sxh .b3{ width:auto;}
    h4.follow1{ margin-top:20px; border-bottom: 1px solid #666; heigh:38px; line-height:38px; font-weight:bold;}

    .follow-div{ width:910px; margin:0 0 40px 0;}
    .follow-text{ margin-top:15px;}
    .follow-text{border: 1px solid #797979; color:#949494; line-height:26px; padding:20px; padding-bottom:0px;}
    .follow-text .file{ color:#333333;}
    .button22{ background: none; border:1px solid #797979; color:#333333; width:100px;}
    .subka{ background-color:#367ea9; width:100px; height:30px; line-height:30px; color:#fff; border:0; border-radius:3px;}
    /*弹出*/
    .mydiv {
        line-height: 20px;
        border: 1px solid #0080FF;
        font-size: 12px;
        z-index: 999;
        width: 800px;
        /*height: 420px;*/
        left: 40%;
        top: 20%;
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
    <form action="" method="post" enctype="multipart/form-data">
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
                <b class="b1">
                    <span>出 发 地：</span>
                    <?php echo $model->departure; ?>
                </b>
                <b class="b2">
                    <span>目 的 地：</span>
                    <?php echo $model->destination; ?>
                </b>
            </p>
            <p class="div-sxh">
                <b class="b1">
                    <span>预计出发日期：</span>
                    <?php
                    if(intval($model->departure_time)>0)
                        echo date('Y-m-d', $model->departure_time);
                    else
                        echo "未填写";
                    ?>
                </b>
                <b class="b2">
                    <span>出行人数：</span>
                    <?php echo $model->adult_num."成人&nbsp;".$model->children_num."儿童"; ?>
                </b>
                <b class="b3">
                    <span>人均预算：</span>
                    <?php echo $model->budget."元/人"; ?>
                </b>
            </p>
            <p class="div-sxh">
                <b class="b1">
                    <span>联系人：</span>
                    <?php echo $model->linkman; ?>
                </b>
                <b class="b2">
                    <span>手机号：</span>
                    <?php echo $model->tel; ?>
                </b>
                <b class="b3">
                    <span>电子邮箱：</span>
                    <?php echo $model->email; ?>
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
                                <p class="file">附件：<?php echo $v;?> <a href="<?php echo $v;?>">下载</a></p>
                        <?php
                                endforeach;
                            }
                        ?>
                    </div>
                </div>
                <?php endforeach;?>

            <?php }?>
                <input type="hidden" name="orderid" value="<?php echo $model->orderid;?>" />
                <div class="follow-div">
                    <div class="follow-time">
                        跟进记录：
                    </div>
                    <div class="follow-text" style="padding:8px; border:0;">
                        <p class="text">
                            <!--<textarea style="width:900px; height:220px; resize: none;" class="follow_remark" name="follow_remark"></textarea>-->
                            <textarea id="uploadEditor" class="follow_remark" style="width:900px; height:220px; resize: none;" name="follow_remark"></textarea>
                        </p>
                        <!--<input type="file" name="follow_file" id="follow_file" />-->
                        <button type="button" id="j_upload_file_btn" class="j_upload_file_btn">附件上传</button>
                        <ul id="upload_file_wrap"></ul>
                        <!-- 加载编辑器的容器 -->
                        <!--<textarea id="uploadEditor" style="display: none;"></textarea>-->
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
            <input type="submit" name="sub" value="提交" onclick="return checkForm()" class="subka" />
        </div>
    </div>
    </form>
</div>

<div id="popDiv" class="mydiv" style="display:none;">
    <div align="right" style="padding:2px;z-index:2000;font-size:12px;cursor:pointer;position:absolute;right:0;" onclick="closeDivFun()">
        <span style="border:1px solid #000;width:12px;height:12px;line-height:12px;text-align:center;display:block;background-color:#FFFFFF;left:-20px;">×</span>
    </div>
    <div class="follow-logs">
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
    function checkForm(){

        if(UE.getEditor('uploadEditor').getContentTxt()==""){
            layer.alert("请填写跟进记录");
            $(".follow_remark").focus();
            return false;
        } else{
            if($("#upload_file_wrap").text()!=""){
                var filePath = "";
                $("#upload_file_wrap li a").each(function () {
                    filePath += $(this).text()+",";
                });
                $("#filePath").val(filePath);
            }
        }

    }
</script>
<!------------上传图片控件-------------------->
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/ueditor/ueditor.all.js"></script>
<!--<script type="text/javascript" src="<?/*= Yii::$app->params['WebUrl'] */?>/vendor/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?/*= Yii::$app->params['WebUrl'] */?>/vendor/ueditor/ueditor.all.js"></script>-->
<!-- 使用ue -->
<script type="text/javascript">

    // 实例化编辑器，这里注意配置项隐藏编辑器并禁用默认的基础功能。
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
            'bold', 'italic', 'underline', 'forecolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'fontfamily', 'fontsize', '|',
            'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify',
            'attachment',

            'inserttable']]
    });

    // 监听多图上传和上传附件组件的插入动作
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
            fileHtml += '<li><a href="'+result[i].url+'" target="_blank">'+result[i].url+'</a></li>';
        }
        document.getElementById('upload_file_wrap').innerHTML = fileHtml;
    }
</script>


