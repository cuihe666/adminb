<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '专题活动-二维码管理列表';
$this->params['breadcrumbs'][] = $this->title;

//获取专题活动的名称
$thematicActivityName   = isset($thematicActivityInfo['name']) ? $thematicActivityInfo['name'] : '';
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/regexp.js"></script>
<style>
    #w5-success{display: none;}
    .btn-group, .btn-group-vertical{margin-top: 10px;}
    .name_a{ cursor: pointer}
</style>
<?php
if (Yii::$app->session->hasFlash('success')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('success')?>")</script>
<?php } ?>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix" style="margin: -50px 0 0 20px;">
                            <div class="search-item">
                                <?= Html::beginForm($refreshUrl, 'get', ['class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <?= Html::a('创建二维码', null, ['class' => 'btn btn-success jsCreateQrcode','style'=>"float:left; margin-right:20px; margin-top:10px;"]) ?>


                                <?= Html::endForm() ?>
                            </div>
                        </div>
                        <?php
                        use kartik\export\ExportMenu;
                        //处理自定义参数名称的操作
                        $customParamsShowStrAction = function($customParams){
                            return $customParams=='default' ? '<span style=\'color:red\'>默认</span>' : $customParams;
                        };
                        $gridColumns = [
                            [
                                'class'     => 'yii\grid\SerialColumn',
                                'header'    => '序号'
                            ],
                            [
                                'header'    => '二维码ID',
                                'attribute' => 'id',
                                'format'    => 'raw',
                                'value'     => function ($model) {
                                    return $model->id;
                                },
                            ],
                            [
                                'header'    => '专题名称',
                                'attribute' => '',
                                'format'    => 'raw',
                                'value'     => function ($model)use($thematicActivityName){
                                    return $thematicActivityName;
                                },
                            ],
                            [
                                'header'    => '自定义参数',
                                'attribute' => 'custom_params',
                                'format'    => 'raw',
                                'value'     => function ($model) use($customParamsShowStrAction) {
                                    return $customParamsShowStrAction($model->custom_params);
                                },
                            ],
                            [//二维码url
                                'header'    => '链接',
                                'attribute' => 'qrcode_url',
                                'format'    => 'raw',
                                'value'     => function ($model) {
                                    return $model->qrcode_url;
                                },
                            ],
                            [
                                'header'    => '描述',
                                'attribute' => 'desc',
                                'format'    => 'raw',
                                'value'     => function ($model) {
                                    return $model->desc;
                                },
                            ],
                            [
                                'header'    => '浏览量',
                                'attribute' => 'request_num',
                                'format'    => 'raw',
                                'value'     => function ($model) {
                                    return $model->request_num;
                                },
                            ],
                            //操作
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {operation}
                                </div> ',
                                'buttons' => [
                                    'operation' => function ($url, $model, $key) use($tid,$customParamsShowStrAction) {
                                        $str = '';
$newUserTotalUrl = Url::toRoute(['thematic-qrcode/newusertotal','thematic_qrcode_id'=>$key,'tid'=>$tid]);
$str .= <<<EOF
<a href="{$newUserTotalUrl}" class="operation_status" style="color: #337ab7;" id="{$key}-y" >新增用户统计</a>
EOF;

$orderTotalUrl = Url::toRoute(['thematic-qrcode/ordertotal','thematic_qrcode_id'=>$key,'tid'=>$tid]);
$str .= <<<EOF
|<a href="{$orderTotalUrl}" class="operation_status" style="color: #337ab7;" id="{$key}-y" >订单统计</a>
EOF;

$customParamsShowStr = $customParamsShowStrAction($model->custom_params);
$showQrcodeActionUrl = Url::toRoute(['qrcode/buildqrcode','url'=>$model->qrcode_url]);
$str .= <<<EOF
|<a href="javascript:void(0);" class="operation_status jsShowQrcode" data-sub-title="{$customParamsShowStr}" data-qrcode-url="{$showQrcodeActionUrl}" style="color: #337ab7;" id="{$key}-y" >查看二维码</a>
EOF;
                                        return $str;
                                    },
                                ],
                            ],
                        ];
                        echo ExportMenu::widget([
                            'dataProvider' => $dataProvider
                            , 'columns' => $gridColumns
                        ]);
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'pager' => [
                                'firstPageLabel' => '首页',
                                'lastPageLabel' => '尾页',
                                'prevPageLabel' => '上一页',
                                'nextPageLabel' => '下一页',
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- 创建二维码 弹框 start -->
<style>
    .modal-content{width:700px; left:20%;}
    .modal-body p{ line-height: 32px; margin-bottom:10px;}
    .modal-body p label{ width:140px; display: inline-block; text-align: right; font-weight: normal; padding-right:5px;}
    .modal_text{ width:400px; height:30px; line-height: 30px; border:1px solid #ccc; padding:0 4px;}
    .modal-footer{ text-align: center;}
    .close_1{ margin: 0 auto; display: inline-block; width: 120px;}
    .t_name{ text-align: center; margin-bottom: 30px;}
    .modal_i{ display: block; font-style: normal; font-size: 12px; color: #FF0000;}
    .clear{ clear: both;}
    .red{color:#f00;}
    .no-resize{resize: none;}
    .modal-textarea{
        border:1px solid #ccc;
        padding:0 4px;
        font-size:14px;
    }
</style>
<div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="create_qrcode_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title t_name" id="myLargeModalLabel"></h4>-->
                <h4 class="modal-title text-center">创建二维码</h4>
            </div>
            <form id="create_qrcode_form" action="#">
                <div class="modal-body" style="overflow: hidden;">
                    <!--<h4 class="modal-title t_name" id="myLargeModalLabel"></h4>-->
                    <p>
                        <label style="float: left">专题名称：</label>
                        <?= $thematicActivityName ?>
                    </p>
                    <p>
                        <label style="float: left"><span class="red">*</span>自定义参数：</label>
                        <input type="text" class="modal_text" name="custom_params" value="" maxlength="10" placeholder="最大10字">
                    </p>
                    <p>
                        <label style="float: left">描述：</label>
                        <textarea class="form-control no-resize modal-textarea" name="desc" rows="10" maxlength="200" placeholder="最大200字"></textarea>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary jsCreateBtn">创建</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 创建二维码 弹框 end -->

<!-- 查看二维码 弹框 start -->
<div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="show_qrcode_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title t_name" id="myLargeModalLabel"></h4>-->
                <h4 class="modal-title text-center">自定义参数-<span class="jsShowSubTitle"></span></h4>
            </div>
            <form id="create_qrcode_form" action="#">
                <div class="modal-body" style="overflow: hidden;text-align:center;">
                    <!--<h4 class="modal-title t_name" id="myLargeModalLabel"></h4>-->
                    <img class="jsShowQrcodeImg" width="300" src="" alt="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 查看二维码 弹框 end -->

<script>
    $(function(){
        var $createQrcodeModal = $('#create_qrcode_modal');
        var $showQrcodeModal = $('#show_qrcode_modal');
        var tid = '<?= $tid ?>';
        var refreshUrl = '<?= $refreshUrl ?>';
        /*******************点击创建二维码 弹出框 ********************/
        $(".jsCreateQrcode").off().on('click',function(){
            //每次点击打开都是重置后的表单
            $('#create_qrcode_form')[0].reset();
            $createQrcodeModal.modal("show");
        });

        /*******************创建二维码 弹出框,点击创建按钮触发 ********************/
        var isCreateQrcodeAjaxDo = true;//是否能够触发ajax
        $createQrcodeModal.find('.jsCreateBtn').off().on('click',function(){
            if( !isCreateQrcodeAjaxDo ){
                return false;
            }
            //自定义参数
            var customParams = $.trim($createQrcodeModal.find('input[name="custom_params"]').val());
            //描述
            var desc        = $.trim($createQrcodeModal.find('textarea[name="desc"]').val());
            //正则匹配中文字符数字
            var regResult   = regexpChineseStringNum(customParams,{
                min:1,
                max:10
            });
            if( !regResult ){
                layerAlertErr('请输入正确规则的自定义参数');
                return false;
            }
            //loading加载效果
            var loadIndex = layer.load();
            isCreateQrcodeAjaxDo = false;
            $.ajax({
                type:'POST',
                url:'<?= Url::toRoute("thematic-qrcode/createqrcode")?>',
                data:{
                    'tid' : tid,
                    'custom_params' : customParams,
                    'desc' : desc
                },
                dataType:'json',
                complete:function(){
                    layer.close(loadIndex);
                },
                success:function(response){
                    var status  = response.status || '';
                    var info    = response.info || '';
                    var data    = response.data || {};
                    if( status=='ok' ){
                        layerAlertMsgSucc('操作成功',function(){
                            window.location.href = refreshUrl;
                            $createQrcodeModal.modal("hide");
                        });
                        return false;
                    }
                    isCreateQrcodeAjaxDo = true;
                    layerAlertErr(info);
                },
                error:function(){
                    isCreateQrcodeAjaxDo = true;
                    layerAlertErr('操作失败,请重新尝试!');
                }
            });
        });


        /*******************点击查看二维码 弹出框 ********************/
        $('.jsShowQrcode').off().on('click',function(){
            var $this = $(this);
            var subTitle = $.trim($this.attr('data-sub-title'));
            var qrcodeUrl = $.trim($this.attr('data-qrcode-url'));
            if( !qrcodeUrl ){
                layerAlertErr('显示二维码的url地址不存在');
                return false;
            }
            var $showQrcodeImg = $showQrcodeModal.find('.jsShowQrcodeImg');
            var $showSubTitle = $showQrcodeModal.find('.jsShowSubTitle');

            //加载图片显示
            $showQrcodeImg.attr('src',qrcodeUrl);
            //显示副标题
            $showSubTitle.html(subTitle);
            $showQrcodeModal.modal('show');
        });


        //错误提示框
        function layerAlertErr(msg){
            layer.alert(msg, {icon: 2});
        }

        //成功提示框
        function layerAlertMsgSucc(msg,callback,time){
            time = time || 1000;
            layer.msg(msg, {
                icon: 1,
                time: time //2秒关闭（如果不配置，默认是3秒）
            }, callback);
        }

    });
</script>

