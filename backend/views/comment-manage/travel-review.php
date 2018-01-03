<?php
/**
 * User: snowno
 * Date: 2017/11/6 0006
 * Time: 15:18
 */
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
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
                <?php $form = ActiveForm::begin(); ?>
                <input type="hidden" name="Comment[cid]" value="<?=$model->id?>"  >
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
                            <span id="JsStrokeStar" data-num="<?=$model->starlevel->grade_scheduling?>"></span>
                         </span>
                    </div>
                    <div class="input-group">
                        <span>导游讲解：</span>
                        <span class="demo">
                            <span id="JsGuideStar" data-num="<?=$model->starlevel->grade_guide?>"></span>
                         </span>
                    </div>
                    <div class="input-group">
                        <span>领队服务：</span>
                        <span class="demo">
                            <span id="JsLeadeStar" data-num="<?=$model->starlevel->grade_leader_service?>"></span>
                         </span>
                    </div>
                    <div class="input-group">
                        <span>描述相符：</span>
                        <span class="demo">
                            <span id="JsDescripStar" data-num="<?=$model->starlevel->grade_describe?>"></span>
                         </span>
                    </div>
                </div>
                <div class="comment-info-text">
                    <?= $form->field($model, 'content')->textarea(['maxlength' => true, 'cols'=>270 ]) ?>
                </div>
                <div class="comment-info-imgs">
                    <span>点评图片：</span>
                    <div class="comment-info-imgs-right">
                        <?php
                        if($model->pic != ''){
                        ?>
                        <input type="button" id="del" value="删除图片">
                        <ul>
                            <?php
                                $pic_arr = explode(',',trim($model->pic,','));
                                foreach($pic_arr as $k=>$v){
                            ?>
                            <li>
                                <input type="checkbox" class="checkbox-in-img" name="del[]" >
                                <img src="<?=Yii::$app->params['imgUrl'].$v?>" class="img-item">
                                <input type="hidden" name="Comment[pic_arr][]" value="<?=$v?>" >
                            </li>
                            <?php
                                }
                            ?>
                        </ul>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="comment-info-essence">
                    <span>精华点评：</span>
                    <input type="checkbox" id="checkb"  name="Comment[quintessence]" <?=($model->quintessence == 1)?'checked':''?> value="<?=($model->quintessence == 1)?'1':'0'?>" >
                </div>
                    <div class="comment-info-btn">
                        <?php
                        if($model->state ==0){
                        ?>
                        <input type="hidden" name="Comment[state]" value="" id="state">
                        <span class="btn btn-primary pass" state="1">审核通过</span>
                        <span class="btn btn-danger unpass" state="2">审核不通过</span>
                            <?php
                        }
                        ?>
                        <a href="<?=Url::to(['comment-manage/travel-index'])?>" ><input type="button" class="btn btn-info" value="返回" ></a>
                    </div>

                <?php ActiveForm::end(); ?>
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
        $('#checkb').change(function(){
            if ($("#checkb").get(0).checked) {
                $(this).val(1);
            }else{
                $(this).val(0);
            }

            console.log($(this).val());
        })

        $('#JsOverAllStar').raty({
            path     : '<?= Yii::$app->request->baseUrl ?>/images',
            starHalf : 'star-half.png',
            starOff  : 'star-off.png',
            starOn   : 'star-on.png',
            half : true,
            halfShow : true,
//            readOnly : true,
            scoreName : 'StarLevel[grade]',
            score : function () {
                return $(this).attr("data-num");
            },
            click : function (score, evt) {
                if(score < 1){
                    alert('至少需要选择一颗星');
                    $(this).find('input').val(1);
                }
            }
        });
        $('#JsStrokeStar').raty({
            path     : '<?= Yii::$app->request->baseUrl ?>/images',
            starHalf : 'star-half.png',
            starOff  : 'star-off.png',
            starOn   : 'star-on.png',
            scoreName : 'StarLevel[grade_scheduling]',
            half : true,
            halfShow : true,
            score : function () {
                return $(this).attr("data-num");
            },
            click : function (score, evt) {
                if(score < 1){
                    alert('至少需要选择一颗星');
                    $(this).find('input').val(1);
                }
            }
        });
        $('#JsGuideStar').raty({
            path     : '<?= Yii::$app->request->baseUrl ?>/images',
            starHalf : 'star-half.png',
            starOff  : 'star-off.png',
            starOn   : 'star-on.png',
            scoreName : 'StarLevel[grade_guide]',
            half : true,
            halfShow : true,
            score : function () {
                return $(this).attr("data-num");
            },
            click : function (score, evt) {
                if(score < 1){
                    alert('至少需要选择一颗星');
                    $(this).find('input').val(1);
                }
            }
        });
        $('#JsLeadeStar').raty({
            path     : '<?= Yii::$app->request->baseUrl ?>/images',
            starHalf : 'star-half.png',
            starOff  : 'star-off.png',
            starOn   : 'star-on.png',
            scoreName : 'StarLevel[grade_leader_service]',
            half : true,
            halfShow : true,
            score : function () {
                return $(this).attr("data-num");
            },
            click : function (score, evt) {
                if(score < 1){
                    alert('至少需要选择一颗星');
                    $(this).find('input').val(1);
                }
            }
        });
        $('#JsDescripStar').raty({
            path     : '<?= Yii::$app->request->baseUrl ?>/images',
            starHalf : 'star-half.png',
            starOff  : 'star-off.png',
            starOn   : 'star-on.png',
            scoreName : 'StarLevel[grade_describe]',
            half : true,
            halfShow : true,
            score : function () {
                return $(this).attr("data-num");
            },
            click : function (score, evt) {
                if(score < 1){
                    alert('至少需要选择一颗星');
                    $(this).find('input').val(1);
                }
            }
        });

        //图片预览
        $('body').off().on('click', '.img-item', function (e) {
            drawToCanvas(e.currentTarget.src, this);
        });

        //canvas code
        function drawToCanvas(imgData, item){
            var current_dom = item;
            var cvs = $("#cvs")[0];
            var ctx = cvs.getContext('2d');
            cvs.width = 500;
            cvs.height = 500;
            var x = cvs.width/2;
            var y = cvs.height/2;
            var img = new Image();
            var strDataURI;
            ctx.save();
            ctx.clearRect(0, 0, cvs.width, cvs.height);
            img.crossOrigin = "anonymous";
            img.src = imgData;
            img.onload = function () {
                ctx.globalCompositeOperation = "destination-over";
                ctx.drawImage(img, 0, 0, cvs.width, cvs.height);
            };
            $(".layer-display").show();
            //逆时针旋转
            $(".left-rotate").off('click').on('click', function () {
                ctx.clearRect(0, 0, cvs.width, cvs.height);
                ctx.translate(x, y);
                ctx.rotate(-Math.PI/2);
                ctx.translate(-x, -y);
                ctx.drawImage(img, 0, 0, cvs.width, cvs.height);
                //导出base64格式的图片数据
                strDataURI = cvs.toDataURL("image/png", 1.0);
            });
            //顺时针旋转
            $(".right-rotate").off('click').on('click', function () {
                ctx.clearRect(0, 0, cvs.width, cvs.height);
                ctx.translate(x, y);
                ctx.rotate(Math.PI/2);
                ctx.translate(-x, -y);
                ctx.drawImage(img, 0, 0, cvs.width, cvs.height);
                //导出base64格式的图片数据
                strDataURI = cvs.toDataURL("image/png", 1.0);
            });
            //关闭上传图片事件
            $(".close-btn").off('click').on('click', function () {
                ctx.restore();
                if(strDataURI){
                    $(current_dom).attr('src', strDataURI);
                    console.log($(current_dom));
                    $(current_dom).parent().find($("input[type='hidden']")).val(strDataURI);
                    strDataURI = '';
                }
                $(".layer-display").hide();
            });

        }
        //审核
        $('.pass').click(function(){
            var state = $(this).attr('state');
            $('#state').val(state);
            if ($("#checkb").get(0).checked) {
                $("#checkb").val(1);
            }else{
                $("#checkb").val(0);
            }
            $('#w0').submit();
        })
        //审核不通过unpass
        $('.unpass').click(function(){
            var state = $(this).attr('state');
            $('#state').val(state);
            if ($("#checkb").get(0).checked) {
                $("#checkb").val(1);
            }else{
                $("#checkb").val(0);
            }
            $('#w0').submit();
        })
        //删除图片
        $("#del").off('click').on('click', function () {
            $.each($(".checkbox-in-img"), function (index, item) {
               if(item.checked){
                   $(item).parent().remove();
               }
            });
        });
    });
</script>
