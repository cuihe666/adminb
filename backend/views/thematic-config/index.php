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
                    <li><a href="###" class="current">设置色调</a></li>
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
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/view','id'=>$activity['id']]) ?>">预览发布</a></li>
                </ul>
            </div>
            <!--右侧内容区-->
            <div class="config_r fl">
                <div class="config_r_title">设置色调</div>
                <p class="tips">提示：可设置页面整体背景色和按钮颜色，整体页面颜色搭配请咨询设计师。</p>
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
                        <div class="c_box c_bg_box">
                            <div class="c_item c_bg c_pos">
                                <p class="c_item_p">
                                    <label for="">请输入页面背景色值：</label>
                                    <input type="text" name="background_color" class="color_v" value="<?=$model['background_color']?>" placeholder="例：#FFFFFF" maxlength="7" id="bg_color" autocomplete="off"  />
                                </p>
                                <span class="color_show" style="background-color: <?=$model['background_color']?>; <?php echo $model['background_color']=='' ? 'display:none' : 'display:inline-block';?>"></span>
                                <i></i>
                            </div>
                            <div class="clear"></div>
                            <p class="c_tip c_bg_tip">默认为白色，只对专题页背景生效</p>
                        </div>
                        <div class="c_box c_btn_box">
                            <div class="c_item c_btn c_pos">
                                <p class="c_item_p">
                                    <label for="">请输入按钮背景色值：</label>
                                    <input type="text" name="button_color" class="color_v" value="<?=$model['button_color']?>" placeholder="例：#F8612D" maxlength="7" id="btn_color" autocomplete="off" />
                                </p>
                                <span class="color_show" style="background-color: <?=$model['button_color']?>"></span>
                                <i></i>
                            </div>
                            <div class="clear"></div>
                            <p class="c_tip c_btn_tip">默认为橘红色，对专题页的价格、按钮、预订记录背景色生效</p>

                        </div>
                        <!--提交按钮-->
                        <div class="c_submit">
                            <input type="hidden" name="thematic_id" value="<?=$activity['id']?>">
                            <input class="c_button button_cancel" type="reset" value="取消">
                            <button class="c_button button_sure button_color">保存</button>
                        </div>
                    <?= Html::endForm();?>
                </div>
            </div>
        </div>
    </div>
</div>


