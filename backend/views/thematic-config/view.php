<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "【".$activity['name']."】配置";
$this->params['breadcrumbs'][] = $this->title;

?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/gobal.css" />
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/activity_config.css" />
<script>
    var thematic_id = "<?=$activity['id']?>";
    var add_content_url = "<?php echo \yii\helpers\Url::to(['add-content','id'=>$activity['id']]) ?>";
    var to_content_url = "<?php echo \yii\helpers\Url::to(['content','id'=>$activity['id']]) ?>";
    var add_goods_module_url = "<?php echo \yii\helpers\Url::to(['add-goods-module','id'=>$activity['id']]) ?>";
    var to_goods_module_url = "<?php echo \yii\helpers\Url::to(['goods','id'=>$activity['id'],'module_type'=>1]) ?>";
    var del_module_url = "<?php echo \yii\helpers\Url::to(['del-module','id'=>$activity['id']]) ?>";
    var to_index_url = "<?php echo \yii\helpers\Url::to(['index','id'=>$activity['id']]) ?>";
</script>
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/activity_config.js"></script>
<style>

</style>
<?php
if (Yii::$app->session->hasFlash('success')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('success')?>")</script>
<?php } ?>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <!--title-->
        <div class="config_title">
            <h1>配置</h1>
        </div>
        <!--config 内容-->
        <div class="config_box clearfix">
            <!--左侧tab选择-->
            <div class="config_l fl">
                <ul>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/index','id'=>$activity['id']]) ?>">设置色调</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/title-pic','id'=>$activity['id']]) ?>">头图模块</a></li>
                    <?php
                    if(!empty($add_menu)){
                        foreach ($add_menu as $key => $val):
                            if($val[1]==1){
                                $url = \yii\helpers\Url::to(['thematic-config/goods','id'=>$activity['id'],'mid'=>$val[0],'module_type'=>1]);
                            }
                            elseif($val[1]==2){
                                $url = \yii\helpers\Url::to(['thematic-config/content','id'=>$activity['id'],'mid'=>$val[0]]);
                            }
                            $class = "";
                            if(isset(Yii::$app->request->get()['mid'])){
                                if($val[0]==Yii::$app->request->get()['mid'])
                                    $class = "current";
                                else
                                    $class = "";
                            }
                            ?>
                            <li class="po_re"><a href="<?php echo $url ?>" class="<?=$class?>"><?=$val[2]?></a><span class="del po_ab" data="<?=$val[0]?>" data-key="<?=$key?>" data-type="<?=$val[1]?>">X</span></li>
                            <?php
                        endforeach;
                    }
                    ?>
                    <li><a href="javascript:;" class="add_own">添加自定义内容</a></li>
                    <li><a href="javascript:;" class="add_module">添加商品模块</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/goods-cat','id'=>$activity['id']]) ?>">商品分类模块</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/book-log','id'=>$activity['id']]) ?>">预定记录</a></li>
                    <li><a href="###" class="current">预览发布</a></li>
                </ul>
            </div>
            <!--右侧内容区-->
            <div class="config_r fl">
                <div class="config_r_title">发布</div>
                <p class="tips">提示：点击发布即发布此专题活动，发布后可在活动列表查看。</p>
                <!--配置、模板-->
                <div class="config_tab clearfix">
                    <ul class="config_tap fl">
                        <li class="current">配置</li>
                        <!--<li>模板</li>-->
                    </ul>
                    <!--todo 需要添加商品-->
                </div>
                <!--config_con 配置内容区  config_color 设置颜色-->
                <div class="config_con config_color">
                    <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'activity_form']) ?>
                        <div class="qrcode_view">
                            <img src="<?= \yii\helpers\Url::to(['qrcode/buildqrcode','url' => $activity['h5_link']])?>" class="qrcode_img" />
                            <span class="qrcode_span">手机扫码二维码进行预览</span>
                        </div>
                        <!--提交按钮-->
                        <div class="c_submit">
                            <input type="hidden" name="thematic_id" value="<?= $activity['id']?>" />
                            <button class="c_button button_sure button_release">发布</button>
                        </div>
                    <?= Html::endForm();?>
                </div>
            </div>
        </div>
    </div>
</div>


