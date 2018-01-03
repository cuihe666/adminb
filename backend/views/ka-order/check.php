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

    .follow-div{ width:96%; margin:20px auto;}
    .follow-text{ margin-top:15px;}
    .follow-text{border: 1px solid #797979; color:#949494; line-height:26px; padding:20px; padding-bottom:0px;}
    .follow-text .file{ color:#333333;}
    -->
</style>
<?php
$form = ActiveForm::begin(['action' => ['ka-order/index'],'method'=>'post']); ?>
<div class="right">
    <div class="part_one">
        <div class="top">
            <p>
                <b>
                    KA定制订单详情
                </b>
            </p>
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
                        <?php if($v['follow_file']!=null || $v['follow_file']!=''){?>
                        <p class="file">附件：<?php echo $v['follow_file'];?> <a href="$v['follow_file']">下载</a></p>
                        <?php }?>
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
    <div class="part_two">
        <div class="right-l-btn" style="text-align: center">
            <a href="javascript:void(0);" class="btn1"><button type="button" class="btn1 btn btn-sm btn-primary">查看操作日志</button></a>
            &nbsp;&nbsp;<a href="<?php echo  Url::to(['ka-order/index']) ?>" class="btn1"><button type="button" class="btn1 btn btn-sm btn-primary">返回</button></a>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

