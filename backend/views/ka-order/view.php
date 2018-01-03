<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'KA定制订单详情';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/shenhe_sxh.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/shenhe.js"></script>
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
    -->
</style>
<div class="right">
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
               <!-- <b class="b1">
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
                        elseif($model->custom_type == 2)
                            echo "游玩";
                        */?>主题：
                    </span>
                    <?php
/*                    if($model->custom_type==3){
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
                                <p class="file"><span>附件：<?php echo $v;?> </span><a href="<?php echo Yii::$app->params['imgUrl'].$v;?>" target="_blank" class="download-kafiles">下载</a></p>
                                <?php
                            endforeach;
                        }
                        ?>
                    </div>
                </div>
                <?php endforeach;?>

            <?php }?>
            <div class="follow-div">
                <div class="follow-time">
                    是否已完成定制：
                    <label name="nba" for="nba" class="checked " <?php if($model->follow_status==2){?>style=" color:#008c3c"<?php }?>>
                        <i><?php echo Yii::$app->params['follow_status'][$model->follow_status];?></i>
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
            <a href="javascript:showDivFun();" class="btn1"><button type="button" class="btn1 btn btn-sm btn-primary">查看操作日志</button></a>
            &nbsp;&nbsp;<a href="<?php echo  Url::to(['ka-order/'.$url]) ?>" class="btn1"><button type="button" class="btn1 btn btn-sm btn-primary">返回</button></a>
        </div>
    </div>
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

