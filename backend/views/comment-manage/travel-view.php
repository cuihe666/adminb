<?php
/**
 * User: snowno
 * Date: 2017/11/6 0006
 * Time: 15:18
 */
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;

?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/travel-review.css">
<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">

                            <div class="search-item">
                                <div class="comment-info-ids">
                                    <div class="search-item">
                                        <div class="input-group">
                                            <b>订单号：</b><?=$model->travelorder->order_no?>
                                        </div>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group">
                                            <b>点评id：</b><?=$model->id?>
                                        </div>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group">
                                            <b>用户id：</b><?=$model->uid?>
                                        </div>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group">
                                            <b>产品名称：</b><?=$model->obj_name?>
                                        </div>
                                    </div>
                                    <div class="search-item">
                                        <div class="input-group">
                                            <b>产品id：</b><?=$model->obj_id?>
                                        </div>
                                    </div>
                                </div>

                                <div class="comment-info-times">
                                    <div class="search-item">
                                        <div class="input-group">
                                            <b>下单时间：</b><?=$model->travelorder->create_time?>
                                        </div>
                                    </div>
                                    <div></div>
                                    <div class="search-item">
                                        <div class="input-group">
                                            <b>点评时间：</b><?=$model->create_time?>
                                        </div>
                                    </div>
                                    <div></div>
                                    <div class="input-group">
                                        <b>点评状态：</b><?=$model->state==0?('未审核') :($model->state == 1? '审核通过' : '审核不通过');?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <?php
                    //审核内容
                ?>
                <div class="comment-info-stars">
                    <div class="input-group">
                        <span>综合评分：</span>
                        <span class="demo">
                            <span id="JsOverAllStar" data-num="<?=$model->grade?>"></span>
                         </span>
                    </div>
                    <div class="input-group">
                        <span>行程安排：</span>
                        <span class="demo">
                            <span id="JsLocalStar" data-num="<?=$model->starlevel->grade_scheduling?>"></span>
                         </span>
                    </div>
                    <div class="input-group">
                        <span>导游安排：</span>
                        <span class="demo">
                            <span id="JsFacilityStar" data-num="<?=$model->starlevel->grade_guide?>"></span>
                         </span>
                    </div>
                    <div class="input-group">
                        <span>领队服务：</span>
                        <span class="demo">
                            <span id="JsHealthStar" data-num="<?=$model->starlevel->grade_leader_service?>"></span>
                         </span>
                    </div>
                    <div class="input-group">
                        <span>描述相符：</span>
                        <span class="demo">
                            <span id="JsDescStar" data-num="<?=$model->starlevel->grade_describe?>"></span>
                         </span>
                    </div>
                </div>
                <div class="comment-info-text">
                    <span>点评内容：</span>
                    <textarea name="" disabled id=""><?=$model->content?></textarea>
                </div>
                <div class="comment-info-imgs">
                    <span>点评图片：</span>
                    <div class="comment-info-imgs-right">
<!--                        <button >删除图片</button>-->
                        <ul>
                            <?php
                            if($model->pic != ''){
                                $pic_arr = explode(',',trim($model->pic,','));
                                foreach($pic_arr as $k=>$v){
                            ?>
                            <li>
<!--                                <input type="checkbox" class="checkbox-in-img">-->
                                <img src="<?=Yii::$app->params['imgUrl'].$v?>" class="img-item">
                            </li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="comment-info-essence">
                    <span>精华点评：</span>
                    <input type="checkbox" disabled <?=($model->quintessence == 1)?'checked value="1"':' value="0"'?>>
                </div>
                <div class="outer-layer layer-display">
                    <div class="close-btn">X</div>
                    <div class="inner-canvas">
                        <div class="left-rotate"><img src="<?= Yii::$app->request->baseUrl ?>/images/counterClockWise.png" alt="逆时针"></div>
                        <div class="right-rotate"><img src="<?= Yii::$app->request->baseUrl ?>/images/clockWise.png" alt="顺时针"></div>
                        <canvas id="cvs" class="img-canvas"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/star/jquery.raty.min.js"></script>
<script>
    $(document).ready(function () {
        $('#JsOverAllStar').raty({
            path     : '<?= Yii::$app->request->baseUrl ?>/images',
            cancel   : false,
            cancelOff: 'cancel-off.png',
            cancelOn : 'cancel-on.png',
            half     : true,
            size     : 24,
            readOnly : true,
            starHalf : 'star-half.png',
            starOff  : 'star-off.png',
            starOn   : 'star-on.png',
            halfShow : true,
            score : function () {
                return $(this).attr("data-num");
            },
            click : function (score, evt) {
                alert(score);
            }
        });
        $('#JsLocalStar').raty({
            path     : '<?= Yii::$app->request->baseUrl ?>/images',
            cancel   : false,
            cancelOff: 'cancel-off.png',
            cancelOn : 'cancel-on.png',
            half     : true,
            size     : 24,
            readOnly : true,
            starHalf : 'star-half.png',
            starOff  : 'star-off.png',
            starOn   : 'star-on.png',
            halfShow : true,
            score : function () {
                return $(this).attr("data-num");
            },
            click : function (score, evt) {
                alert(score);
            }
        });
        $('#JsFacilityStar').raty({
            path     : '<?= Yii::$app->request->baseUrl ?>/images',
            cancel   : false,
            cancelOff: 'cancel-off.png',
            cancelOn : 'cancel-on.png',
            half     : true,
            size     : 24,
            starHalf : 'star-half.png',
            starOff  : 'star-off.png',
            starOn   : 'star-on.png',
            readOnly : true,
            halfShow : true,
            score : function () {
                return $(this).attr("data-num");
            },
            click : function (score, evt) {
                alert(score);
            }
        });
        $('#JsHealthStar').raty({
            path     : '<?= Yii::$app->request->baseUrl ?>/images',
            cancel   : false,
            cancelOff: 'cancel-off.png',
            cancelOn : 'cancel-on.png',
            half     : true,
            size     : 24,
            readOnly : true,
            starHalf : 'star-half.png',
            starOff  : 'star-off.png',
            starOn   : 'star-on.png',
            halfShow : true,
            score : function () {
                return $(this).attr("data-num");
            },
            click : function (score, evt) {
//                alert(score);
            }
        });
        $('#JsDescStar').raty({
            path     : '<?= Yii::$app->request->baseUrl ?>/images',
            cancel   : false,
            cancelOff: 'cancel-off.png',
            cancelOn : 'cancel-on.png',
            half     : true,
            size     : 24,
            readOnly : true,
            starHalf : 'star-half.png',
            starOff  : 'star-off.png',
            starOn   : 'star-on.png',
            halfShow : true,
            score : function () {
                return $(this).attr("data-num");
            },
            click : function (score, evt) {
//                alert(score);
            }
        });

    });
</script>
