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

    var update_goods_sort = "<?php echo \yii\helpers\Url::to(['update-goods-cat-sort','id'=>$activity['id']]) ?>";
    var del_goods = "<?php echo \yii\helpers\Url::to(['del-goods-cat','id'=>$activity['id']]) ?>";
    var save_goods_cat = "<?php echo \yii\helpers\Url::to(['save-goods-cat','id'=>$activity['id']]) ?>";
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
                    <li><a href="###" class="current">商品分类模块</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/book-log','id'=>$activity['id']]) ?>">预定记录</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/view','id'=>$activity['id']]) ?>">预览发布</a></li>

                </ul>
            </div>
            <!--右侧内容区-->
            <div class="config_r fl">
                <div class="config_r_title">商品分类模块</div>
                <p class="tips">提示：此处分类配置展示的商品，分类TAB悬浮在页面顶部。目前最多只支持4个分类！</p>
                <!--配置、模板-->
                <div class="config_tab clearfix">
                    <ul class="config_tap fl">
                        <li class="current">配置</li>
                        <li>模板</li>
                    </ul>
                    <!--todo 需要添加商品-->
                    <a class="add_one_goods add_classify fr" href="javascript:;">
                        <span>+</span>添加分类
                    </a>
                </div>
                <!--config_con 配置内容区  config_color 设置颜色-->
                <div class="config_con config_module">
                    <!--配置-->
                    <div class="c_module_item c_show">
                        <div class="operate_bar clearfix">
                            <div class="check fl">
                                <input type="checkbox" name="checkall" id="checkall"/><label for="checkall">全选</label>
                            </div>
                            <div class="del fr">删除</div>
                        </div>
                        <div class="m_configure">
                            <ul class="c_configure">
                                <li>选择</li>
                                <li>分类名称</li>
                                <li>包含商品管理</li>
                                <li>商品个数</li>
                                <li>位置</li>
                            </ul>
                            <div class="con_configure">
                                <?php
                                if(count($goods_cat)>0) {
                                    foreach ($goods_cat as $key => $val):
                                        ?>
                                        <ul class="model_configure tag clearfix clear">
                                            <li class="first_li key_li">
                                                <input type="checkbox" name="goods_id[]" id="" class="goods_id"  value="<?= $val['id'];?>" />
                                            </li>
                                            <li>
                                                <input type="text" placeholder="" class="goods_name" maxlength="6" value="<?= $val['category_name'];?>"  autocomplete="off" />
                                            </li>
                                            <li>
                                                <a href="<?php echo \yii\helpers\Url::to(['thematic-config/goods','id'=>$activity['id'],'mid'=>$val['id'],'module_type'=>2]) ?>" class="f_goods">商品管理</a>
                                            </li>
                                            <li>
                                                <span><?= $val['num'];?></span>
                                            </li>
                                            <li class="pos sort_li">
                                                <span class="up" data="<?= $val['sort'];?>">&uarr;</span>
                                                <span class="down" data="<?= $val['sort'];?>">&darr;</span>
                                            </li>
                                        </ul>
                                        <?php
                                    endforeach;
                                    if(count($goods_cat)==1):
                                    ?>
<!--                                        <ul class="model_configure tag clearfix clear">-->
<!--                                            <li class="first_li key_li">-->
<!--                                                <input type="checkbox" name="goods_id[]" id="" class="goods_id"  value="" />-->
<!--                                            </li>-->
<!--                                            <li>-->
<!--                                                <input type="text" placeholder="" class="goods_name" maxlength="6">-->
<!--                                            </li>-->
<!--                                            <li>-->
<!--                                                <a href="" class="f_goods">商品管理</a>-->
<!--                                            </li>-->
<!--                                            <li>-->
<!--                                                <span>0</span>-->
<!--                                            </li>-->
<!--                                            <li class="pos sort_li">-->
<!--                                                <span class="up">&uarr;</span>-->
<!--                                                <span class="down"">&darr;</span>-->
<!--                                            </li>-->
<!--                                        </ul>-->
                                <?php
                                    endif;
                                }
                                else {
                                    ?>
                                    <!--<ul class="model_configure tag clearfix clear">
                                        <li class="first_li key_li">
                                            <input type="checkbox" name="goods_id[]" id="" class="goods_id"  value="" />
                                        </li>
                                        <li>
                                            <input type="text" placeholder="" class="goods_name" maxlength="6">
                                        </li>
                                        <li>
                                            <a href="" class="f_goods">商品管理</a>
                                        </li>
                                        <li>
                                            <span>0</span>
                                        </li>
                                        <li class="pos sort_li">
                                            <span class="up">&uarr;</span>
                                            <span class="down"">&darr;</span>
                                        </li>
                                    </ul>
                                    <ul class="model_configure tag clearfix clear">
                                        <li class="first_li key_li">
                                            <input type="checkbox" name="goods_id[]" id="" class="goods_id"  value="" />
                                        </li>
                                        <li>
                                            <input type="text" placeholder="" class="goods_name" maxlength="6">
                                        </li>
                                        <li>
                                            <a href="" class="f_goods">商品管理</a>
                                        </li>
                                        <li>
                                            <span>0</span>
                                        </li>
                                        <li class="pos sort_li">
                                            <span class="up">&uarr;</span>
                                            <span class="down"">&darr;</span>
                                        </li>
                                    </ul>-->
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <!--提交按钮-->
                        <!--<div class="c_submit">
                            <button class="c_button button_cancel">取消</button>
                            <button class="c_button button_sure">保存</button>
                        </div>-->
                    </div>
                    <!--模板-->
                    <!--模板  c_show 代表显示-->
                    <div class="c_module_item ">
                        <div class="m_item clearfix">
                            <div class="m_btn_box fl"><p class="m_btn current"><?php if(count($goods_cat)>0){echo $model['good_category_temp']=='default' ? "使用中" : "使用";} else{ echo "使用中";}?></p></div>
                            <div class="m_item_box fl">
                                <div class="default_box">
                                    <ul class="default_item_header clearfix">
                                        <li class="current">北京</li>
                                        <li>上海</li>
                                        <li>广州</li>
                                        <li>深圳</li>
                                    </ul>
                                    <div class="default_item_con">
                                        <div class="m_default c_show clearfix">
                                            <div class="item_c item_l fl">
                                                <img src="<?= Yii::$app->request->baseUrl ?>/dist/img/photo1.png" alt="" />
                                                <p>产品名称</p>
                                                <span>¥1000</span>
                                                <button disabled="disabled" style="cursor: pointer">立即查看</button>
                                            </div>
                                            <div class="item_c item_r fr">
                                                <img src="<?= Yii::$app->request->baseUrl ?>/dist/img/photo1.png" alt="" />
                                                <p>产品名称</p>
                                                <span>¥1000</span>
                                                <button disabled="disabled" style="cursor: pointer">立即查看</button>
                                            </div>
                                        </div>
                                        <div class="m_default clearfix">
                                            <div class="item_c item_l fl">
                                                <img src="<?= Yii::$app->request->baseUrl ?>/dist/img/photo1.png" alt="" />
                                                <p>产品名称</p>
                                                <span>¥2000</span>
                                                <button disabled="disabled" style="cursor: pointer">立即查看</button>
                                            </div>
                                            <div class="item_c item_r fr">
                                                <img src="<?= Yii::$app->request->baseUrl ?>/dist/img/photo1.png" alt="" />
                                                <p>产品名称</p>
                                                <span>¥2000</span>
                                                <button disabled="disabled" style="cursor: pointer">立即查看</button>
                                            </div>
                                        </div>
                                        <div class="m_default clearfix">
                                            <div class="item_c item_l fl">
                                                <img src="<?= Yii::$app->request->baseUrl ?>/dist/img/photo1.png" alt="" />
                                                <p>产品名称</p>
                                                <span>¥3000</span>
                                                <button disabled="disabled" style="cursor: pointer">立即查看</button>
                                            </div>
                                            <div class="item_c item_r fr">
                                                <img src="<?= Yii::$app->request->baseUrl ?>/dist/img/photo1.png" alt="" />
                                                <p>产品名称</p>
                                                <span>¥3000</span>
                                                <button disabled="disabled" style="cursor: pointer">立即查看</button>
                                            </div>
                                        </div>
                                        <div class="m_default clearfix">
                                            <div class="item_c item_l fl">
                                                <img src="<?= Yii::$app->request->baseUrl ?>/dist/img/photo1.png" alt="" />
                                                <p>产品名称</p>
                                                <span>¥4000</span>
                                                <button disabled="disabled" style="cursor: pointer">立即查看</button>
                                            </div>
                                            <div class="item_c item_r fr">
                                                <img src="<?= Yii::$app->request->baseUrl ?>/dist/img/photo1.png" alt="" />
                                                <p>产品名称</p>
                                                <span>¥4000</span>
                                                <button disabled="disabled" style="cursor: pointer">立即查看</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <!-- <div class="m_item clearfix">
                            <div class="m_btn_box fl"><p class="m_btn">使用</p></div>
                            <div class="m_item_box fl">

                                <div class="m_module2 ">
                                    <div class="item_c item_t">
                                        <img src="img/img.jpg" alt="" />
                                        <p>新春赏花时</p>
                                        <span>¥1000</span>
                                        <button>立即查看</button>
                                    </div>
                                    <div class="item_c item_r">
                                        <img src="img/img.jpg" alt="" />
                                        <p>新春赏花时</p>
                                        <span>¥1000</span>
                                        <button>立即查看</button>
                                    </div>
                                </div>
                            </div>
                        </div>-->


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


