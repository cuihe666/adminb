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

    var update_goods_sort = "<?php echo \yii\helpers\Url::to(['update-goods-sort','id'=>$activity['id'],'mid'=>$module_id,'module_type'=>Yii::$app->request->get('module_type')]) ?>";
    var del_goods = "<?php echo \yii\helpers\Url::to(['del-goods','id'=>$activity['id'],'mid'=>$module_id,'module_type'=>Yii::$app->request->get('module_type')]) ?>";
</script>
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/activity_config.js"></script>
<style>

</style>
<?php
//if (Yii::$app->session->hasFlash('success')) { ?>
<!--    <script>layer.alert("<?/*=Yii::$app->session->getFlash('success')*/?>")</script>-->
<?php //} ?>
<?php
if (Yii::$app->session->hasFlash('errormsg')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('errormsg')?>")</script>
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
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/goods-cat','id'=>$activity['id']]) ?>"<?php if(Yii::$app->request->get()['module_type']==2) echo "class='current'"?>>商品分类模块</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/book-log','id'=>$activity['id']]) ?>">预定记录</a></li>
                    <li><a href="<?php echo \yii\helpers\Url::to(['thematic-config/view','id'=>$activity['id']]) ?>">预览发布</a></li>

                </ul>
            </div>
            <!--右侧内容区-->
            <div class="config_r fl">
                <div class="config_r_title">
                    <?php
                        if($module_type==1) echo "商品模块";
                        if($module_type==2){
                            echo "商品管理&nbsp;-&nbsp;".$goods_module['category_name'];
                        }
                    ?>
                </div>
                <p class="tips">提示：此处配置展示的商品。</p>
                <!--配置、模板-->
                <div class="config_tab clearfix">
                    <ul class="config_tap fl">
                        <li class="current">配置</li>
                        <?php if(Yii::$app->request->get()['module_type']==1):?>
                        <li>模板</li>
                        <?php endif;?>
                    </ul>
                    <!--todo 需要添加商品-->
                    <a class="add_one_goods fr" href="<?php echo \yii\helpers\Url::to(['thematic-config/add-goods','id'=>$activity['id'],'mid'=>Yii::$app->request->get()['mid'],'module_type'=>$module_type]) ?>">
                        <span>+</span>添加一个商品
                    </a>
                </div>
                <!--config_con 配置内容区  config_color 设置颜色-->
                <div class="config_con config_module">
                    <?= Html::beginForm('', 'post', ['enctype' => 'multipart/form-data',"class"=>'activity_form']) ?>

                    <!--配置-->
                    <div class="c_module_item c_show">
                        <div class="operate_bar clearfix">
                            <div class="check fl">
                                <input type="checkbox" id="checkall"/><label for="checkall">全选</label>
                            </div>
                            <div class="del fr">删除</div>
                        </div>
                        <div class="m_configure">
                            <dl class="clearfix">
                                <dd class="change">选择</dd>
                                <dd class="f_type">类型</dd>
                                <dd class="name">商品名称</dd>
                                <dd class="picture">商品主图</dd>
                                <dd class="price">价格</dd>
                                <dd class="f_status">状态</dd>
                                <dd class="position">位置</dd>
                            </dl>
                            <div class="ul_box">
                                <?php
                                if(!empty($new_goods)) {
                                foreach ($new_goods as $key => $val):

                                ?>
                                <ul class="tag clearfix">
                                    <li class="change key_li"><input type="checkbox" name="goods_id[]" id="" class="goods_id" value="<?=$val['goods_id']?>" /></li>
                                    <li class="f_type"><?php if($val['type']==1) echo "当地活动";if($val['type']==2) echo "主题线路";?></li>
                                    <li class="name"><a href="<?php echo \yii\helpers\Url::to(['thematic-config/view-goods','id'=>$activity['id'],'mid'=>Yii::$app->request->get()['mid'],'goods_id'=>$val['goods_id'],'type'=>$val['type'],'module_type'=>$module_type]) ?>"><?=$val['goods_name']?></a></li>
                                    <li class="picture"><img src="<?=$val['title_pic']?>"/></li>
                                    <li class="price"><?=$val['price']!=null ? "¥".$val['price'] : "无";?></li>
                                    <li class="f_status">
                                        <span <?php if($val['status']!=1){ echo "style='color:red;'";}?>><?=Yii::$app->params['travel_status'][$val['status']]?></span>
                                    </li>
                                    <li class="position sort_li">
                                        <span class="up" data="<?=$val['sort']?>">&uarr;</span>
                                        <span class="down" data="<?=$val['sort']?>">&darr;</span>
                                        <a href="<?php echo \yii\helpers\Url::to(['thematic-config/update-goods','id'=>$activity['id'],'mid'=>Yii::$app->request->get()['mid'],'goods_id'=>$val['goods_id'],'type'=>$val['type'],'module_type'=>$module_type]) ?>" class="goods_edit">修改</a>
                                    </li>
                                </ul>
                                    <?php
                                endforeach;
                                }
                                ?>
                            </div>
                        </div>
                        <!--提交按钮-->
                        <?php
                        if(Yii::$app->request->get()['module_type']==2) {
                            ?>
                            <div class="c_submit">
                                <a class="c_button button_cancel c_a_button"
                                   href="<?php echo \yii\helpers\Url::to(['goods-cat', 'id' => $activity['id']]) ?>">返回</a>
                                <!-- <button class="c_button button_cancel">取消</button>
                                 <button class="c_button button_sure">确定</button>-->
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <!--模板  c_show 代表显示-->
                    <div class="c_module_item ">
                        <div class="m_item clearfix">
                            <div class="m_btn_box fl"><p class="m_btn current"><?php if($goods_module['temp']){echo $goods_module['temp']=='default' ? "使用中" : "使用";}?></p></div>
                            <div class="m_item_box fl">
                                <div class="m_default clearfix">
                                    <div class="item_c item_l fl">
                                        <img src="<?= Yii::$app->request->baseUrl ?>/dist/img/photo1.png"/>
                                        <p>新春赏花时</p>
                                        <span>¥1000</span>
                                        <button disabled="disabled" style="cursor: pointer">立即查看</button>
                                    </div>
                                    <div class="item_c item_r fr">
                                        <img src="<?= Yii::$app->request->baseUrl ?>/dist/img/photo1.png"/>
                                        <p>新春赏花时</p>
                                        <span>¥1000</span>
                                        <button disabled="disabled" style="cursor: pointer">立即查看</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="m_item clearfix">
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
                    <?= Html::endForm();?>
                </div>
            </div>
        </div>
    </div>
</div>


