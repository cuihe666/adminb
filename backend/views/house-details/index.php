<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '房源列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>

<script>
    function city(obj) {
        $.get("<?=Url::to(["house-details/getcity"])?>" + "?id=" + $(obj).val(), function (data) {
            $("#bank_city").html(data);
        });

    }

    function area(obj) {
        $.get("<?=Url::to(["house-details/getarea"])?>" + "?id=" + $(obj).val(), function (data) {
            $("#bank_area").html(data);
        });

    }
</script>

<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="search-box clearfix">
                            <div class="search-item">
                                <?= Html::beginForm(['house-details/index'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item" style="width: 200px;margin-right: 5px;">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'type', [1 => '创建时间', 2 => '修改时间', 3 => '审核时间'], ['class' => 'form-control']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 18px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'start_time',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请输入起始时间',
                                                'class' => 'form-control',
                                                'readonly' => true,
                                            ],
                                            'pluginOptions' => [
                                                'timePicker' => false,
                                                'timePickerIncrement' => 30,
                                                'locale' => [
                                                    'format' => 'Y-m-d'
                                                ]
                                            ]
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 's_status', [-1 => '待完善', 4 => '待提交', 6 => '待审核', 3 => '审核未通过', 1 => '已上架', 2 => '已下架'], ['class' => 'form-control', 'prompt' => '房源状态']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'city_name', ['class' => 'form-control input', 'placeholder' => '按城市或区域搜索']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'title', ['class' => 'form-control input', 'placeholder' => '按房源标题搜索']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'mobile', ['class' => 'form-control input', 'placeholder' => '按手机号搜索']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'province', ArrayHelper::map(\backend\service\CommonService::get_province(), 'code', 'name'), ['class' => 'form-control', 'prompt' => '请选择省', 'onchange' => "city(this)"]) ?>
                                    </div>
                                </div>


                                <?php if (isset(Yii::$app->request->queryParams['HouseDetailsQuery']['province']) && Yii::$app->request->queryParams['HouseDetailsQuery']['province'] > 0): ?>
                                    <?php $city_id = Yii::$app->request->queryParams['HouseDetailsQuery']['province']; ?>

                                    <div class="search-item">
                                        <div class="input-group"
                                             style="width: 120px; float: left;margin-right: 18px;">
                                            <?= Html::activeDropDownList($searchModel, 'city', ArrayHelper::map(\backend\service\CommonService::get_city($city_id), 'code', 'name'), ['class' => 'form-control', 'prompt' => '请选择城市', 'id' => 'bank_city', 'onchange' => "area(this)"]) ?>
                                        </div>
                                    </div>

                                <?php else: ?>
                                    <div class="search-item">
                                        <div class="input-group"
                                             style="width: 120px; float: left;margin-right: 18px;">
                                            <?= Html::activeDropDownList($searchModel, 'city', [], ['class' => 'form-control', 'prompt' => '请选择城市', 'id' => 'bank_city', 'onchange' => "area(this)"]) ?>
                                        </div>
                                    </div>
                                <?php endif ?>

                                <?php if (isset(Yii::$app->request->queryParams['HouseDetailsQuery']['city']) && Yii::$app->request->queryParams['HouseDetailsQuery']['city'] > 0): ?>
                                    <?php $area_id = Yii::$app->request->queryParams['HouseDetailsQuery']['city']; ?>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                            <?= Html::activeDropDownList($searchModel, 'area', ArrayHelper::map(\backend\service\CommonService::get_city($area_id), 'code', 'name'), ['class' => 'form-control', 'prompt' => '请选择区域', 'id' => 'bank_area']) ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="search-item">
                                        <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                            <?= Html::activeDropDownList($searchModel, 'area', [], ['class' => 'form-control', 'prompt' => '请选择区域', 'id' => 'bank_area']) ?>
                                        </div>
                                    </div>
                                <?php endif ?>


                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'country', [1 => '国内', 2 => '海外'], ['class' => 'form-control', 'prompt' => '选择国家']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'low_price', ['class' => 'form-control input', 'placeholder' => '最低价格']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'height_price', ['class' => 'form-control input', 'placeholder' => '最高价格']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'house_type', $houseType, ['class' => 'form-control', 'prompt' => '房源类型']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'house_id', ['class' => 'form-control input houseidvalidate','id'=>'houseidval', 'placeholder' => '房源ID']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeInput('text', $searchModel, 'salesman', ['class' => 'form-control input', 'placeholder' => '房管员姓名']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'up_type', [0 => 'app上传' ,1 => '特殊上传' ,2 => '合伙人' ,3 => 'PC房东',4 => '番茄来了' ,5 => '同程'], ['class' => 'form-control', 'prompt' => '上传方式']) ?>
                                    </div>
                                </div>
                                <!-- admin:ys time:2017/11/10 content:添加房源筛选条件（及时预定/二次确认） -->
                                <div class="search-item">
                                    <div class="input-group"
                                         style="width: 120px; float: left;margin-right: 18px;">
                                        <?= Html::activeDropDownList($searchModel, 'is_realtime', Yii::$app->params['house_is_realtime_type'], ['class' => 'form-control', 'prompt' => '预订方式']) ?>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="input-group" style="width: 280px; float: left;margin-right: 18px;">

                                        <!--                                    <button type="button" class="btn btn-sm btn-primary"> 搜索</button>-->
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                        &nbsp;
                                        <!--                                    <button type="button" class="btn btn-sm btn-primary"> 搜索</button>-->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                批量下架 <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li role="separator" id="mutiDown"><a href="#">全部下架</a></li>
                                                <li role="separator" id="singleDown" ><a href="#">下架</a></li>
                                                <li role="separator" id="alertview"><a href="#">操作记录</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <?= Html::endForm() ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                use kartik\export\ExportMenu;

                $gridColumns = [

                    [
                        "class" => 'yii\grid\CheckboxColumn',
                        "name" => "id",
                    ],
                    'id',
                    ['attribute' => 'user.mobile',
                        'header' => '房东帐号',
                        'format' => 'raw',
                        'value' => function ($model) {
                            //超链接
                            return Html::a($model->user['mobile'], ['house-details/userview', 'id' => $model->uid]);
                        },
                    ],
                    [
                        'header' => '标题',
                        'format' => 'raw',
                        'value' => function ($model) {
                            //超链接
//                            if ($model->up_type == 5) {//同程上传的房源，标题展示方式为 房源名 + 酒店名
//                                return Html::a($model->househotel->res_name.'_'.$model->househotel->res_pro_name, ['house-details/view', 'id' => $model->id]);
//                            } else {
                                return Html::a($model->title, ['house-details/view', 'id' => $model->id]);
//                            }
                        },
                    ],
                    //roomtype
                    [
                        'header' => '房源类型',
                        //'format' => 'raw',
                        'value' => function ($model) use($houseType) {
                            return $model->code_name;
                        },
                    ],
                    ['attribute' => 'houseserach.city',
                        'value' => function ($model) {
                            return \backend\service\CommonService::get_city_name($model->houseserach['city'] ? $model->houseserach['city'] : $model->houseserach['province']);
                        },],
                    'houseserach.price',
                    'houseserach.comment_count',
//                    ['label' => '排序值', 'attribute' => 'houseserach.tango_weight1', 'value' => 'houseserach.tango_weight'],//<=====加入这句
                    [
                        'attribute' => 'tango_weight',
                        'headerOptions' => ['width' => '20px'],
                        'value' => 'houseserach.tango_weight',
                        'class' => 'kartik\grid\EditableColumn',
                        'options' => ['class' => 'form-control',],

                        'editableOptions' => [
                            'asPopover' => true,
                            'buttonsTemplate' => '{submit}',
                            'submitButton' => [
                                'icon' => '<span class="">保存</span>'
                            ],
                            'formOptions' => [

                            ],
                        ],
                    ],

                    ['attribute' => 'houseserach.status',
                        'value' => function ($model) {
                            if ($model->houseserach['status'] == 1 && $model->houseserach['online'] == 0) {
                                return '已下架';
                            }

                            if ($model->houseserach['status'] == -1) {
                                return '待完善';
                            }

                            if ($model->houseserach['status'] == 1 && $model->houseserach['online'] == 1) {
                                return '已上架';
                            }
                            if ($model->houseserach['status'] == 0) {
                                return '待审核';
                            }
                            if ($model->houseserach['status'] == 3) {
                                return '未通过';
                            }
                            if ($model->houseserach['status'] == 4) {
                                return '待提交';
                            }

                        }],

                    'create_time',
                    'update_date',
                    'salesman',

                    ['attribute' => 'check_time',
                        'header' => '审核时间',
                        'value' => function ($model) {

                            return $model->check_time ? $model->check_time : '暂无';
                        }],

                    ['attribute' => 'up_type',
                        'header' => '上传方式',
                        'value' => function ($model) {

                            return Yii::$app->params['up_type'][$model->up_type];
                        }],
                    // admin:ys time:2017/11/10 content:添加房源预订方式展示列（及时预定/二次确认）
                    [
                        'label' => '预订方式',
                        'value' => function ($model) {
                            return Yii::$app->params['house_is_realtime_type'][$model->is_realtime];
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {view}
                                    {showpic}
                                    {update-one}
                                </div> ',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('查看', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                            },

                            'showpic' => function ($url, $model, $key) {
                                return Html::a('修改首图', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                            },
                            'update-one' => function ($url, $model, $key) {
//                                return Html::a('修改房源', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                                return Html::a('修改房源', ['house/update-one', 'house_id' => $key], ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                            },
                        ],],

                ];

                // Renders a export dropdown menu
                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns
                ]);

                // You can choose to render your own GridView separately
                // You can choose to render your own GridView separately
                echo GridView::widget([
                    'export' => false,

                    'dataProvider' => $dataProvider,
                    "options" => ["class" => "grid-view", "style" => "overflow:auto", "id" => "grid"],
                    'columns' => $gridColumns,
                    'pager' => [
                        'firstPageLabel' => '首页',
                        'lastPageLabel' => '尾页',
                    ],
                ]);
                ?>

            </div>
            <?php echo Html::a("批量修改房管员", "javascript:void(0);", ["class" => "btn btn-primary check"]) ?>
        </div>
    </div>
</div>
<style>
    tr, th {
        text-align: center;
    }

    .pagination {
        float: right;
    }

</style>

<div class="modal fade" id="salesman" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="color:red">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">请输入管理员名称</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <input type="text" class="form-control" id="salesman_name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary salesman_save">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="more_modal_load">
    <div class="modal-dialog modal-lg" role="document">
        <div class="load-div">
            <div class="">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title t_name" id="myLargeModalLabel"></h4>-->
            </div>
            <!--        驳回弹框            -->
            <div class="moda1_reject_load">
            <img  src="<?= Yii::$app->request->baseUrl ?>/images/loading.gif" alt="">
            </div>
        </div>
    </div>
</div>
<div class="modal fade house_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="more_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="load-ing ">
                <img style="display: none;margin-left: 40%;" src="<?= Yii::$app->request->baseUrl ?>/images/loading.gif" alt="">
            </div>
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title t_name" id="myLargeModalLabel"></h4>-->
            </div>
            <!--        驳回弹框            -->
            <div class="moda1_reject">
                <div class="modal-body" style="overflow: hidden;">
                    <?php
                    $list = \backend\models\HouseBatchUpdateStatus::getValid();

                    ?>
                    <table class="list-table">
                        <tr>
                            <th>操作人</th>
                            <th>时间</th>
                            <th>下架房源</th>
                            <th>操作</th>
                        </tr>
                        <?php
                        if(!empty($list)){
                            foreach($list as $k => $v){
                                $queryreason = $v->search_query_notnull;
                                if($queryreason){
                                    $queryreason = json_decode($queryreason);
                                }
                                $reason = \backend\models\HouseBatchUpdateStatus::getReason($queryreason);
                                ?>
                                <tr>
                                    <td><?=\backend\models\UserBackend::findIdentity($v->admin_uid)['username']?></td>
                                    <td><?=$v->create_time?></td>
                                    <td title="<?=$reason?>" style="max-width: 250px;word-break:break-all;" ><?=$reason?></td>
                                    <td><button class="recover btn btn-primary" hid="<?=$v->update_house_id_str?>" but_id="<?=$v->id?>" >恢复</button>|
                                        <a href="<?=Url::to(["house-details/viewdown",'batch_id'=>$v->id])?>" style="color:white"><button class="viewdown  btn btn-primary"  hid="<?=$v->update_house_id_str?>" but_id="<?=$v->id?>"  >查看</button></a>
                                    </td>
                                </tr>
                            <?php
                                }
                            }else{
                                ?>
                            <tr>
                                <td colspan="4">暂无数据</td>
                            </tr>
                        <?php
                            }
                            ?>
                    </table>
                    <img id="loading"  src="<?= Yii::$app->request->baseUrl ?>/images/loading.gif" alt="">

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" class="m_user_id" value="" />
                    <div id="col_list">
                        <button type="button" class="btn btn-default close_1" data-dismiss="modal" >关闭</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--弹出框-->
<style>
    .modal-content{width:900px; left:20%;}
    .modal-body p{ line-height: 32px; margin-bottom:10px;}
    .modal-body p label{ width:140px; display: inline-block; text-align: right; font-weight: normal; padding-right:5px;}
    .modal_text{ width:80px; height:30px; line-height: 30px; border:1px solid #ccc; padding:0 4px;}
    .higo_name{ width:500px; height: 30px; line-height: 30px; display: inline-block;}
    .modal-footer{ text-align: center;}
    .close_1,.m_commit{ margin: 0 auto; display: inline-block; width: 120px;}
    .t_name{ text-align: center; margin-bottom: 30px;}
    .modal_i{ display: block; font-style: normal; font-size: 12px; color: #FF0000;}
    .m_remark{ font-style: normal; font-size:12px; color: #FF0000; display: inline-block; margin-left:5px;}
    .clear{ clear: both;}
    .moda1_reject{display: none;}
    .m_reason{width:400px; height:120px;}
    .list-table{width:800px}
    .list-table tr td{height:40px;}
    .list-table tr th eq(0){width:10%;}
    .list-table tr th eq(1){width:10%;}
    .list-table tr th eq(2){width:40%;}
    .list-table tr th eq(3){width:40%;}
    .list-table tr td eq(0){width:10%;}
    .list-table tr td eq(1){width:10%;}
    .list-table tr td eq(2){width:40%;}
    .list-table tr td eq(3){width:40%;}
    tr, th {
        text-align: center;
    }

    .pagination {
        float: right;
    }
    #loading{
        display: none;
    }
    .load-div{
        position: relative;
        z-index: 100000;
    }
    .moda1_reject_load{
        z-index: 1000011;
        position: absolute;
        top: -50%;
        left: 50%;
        /*transform: translate(-50%, -50%);*/
    }
    .moda1_reject_load img{
        z-index: 1000011;
    }
    .loaded-ing{
        width: 100%;
        height: 100%;
        /*background: rgba(0,0,0,0.3);*/
        position: absolute;
        top: 0;
        left: 0;
    }
    .loading-block{
        background: rgba(0,0,0,0.3);
    }

</style>

<script>
    $('.check').click(function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        if (keys.length == 0) {
            layer.alert("请先选择要修改的列");
            return false;
        }
        $('#salesman').modal();
        $('.salesman_save').click(function () {
            var name = $('#salesman_name').val();
            if (name == '') {
                layer.alert("名称不能为空");
                return false;

            }
            $.post("<?=Url::to(["house-details/salesman"])?>", {
                    "PHPSESSID": "<?php echo session_id();?>",
                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                    data: {keys: keys, name: name},
                },
                function (data) {
                    if (data == 1) {
                        layer.alert("添加成功");
                        location.reload();
                    }
                }
            )
        })


    })
    $(function(){
        $('.houseidvalidate').blur(function(){
            var regid =/^[\d-]*$/; // id数字
            var hid  = $('#houseidval').val();
            if(!regid.test(hid)){
                    alert('房源ID必须为数字');
                    $('#houseidval').val('');
                    return false;
                }
        });

        $('#mutiDown').click(function(){
            var h_id = '';
            var params = $.trim(window.location.search);
            params = decodeURI(params);
//            console.log(params);return false;
            var param = params.split('&');
            if(params.length == 0){
                layer.alert("全部下架搜索条件不能为空");
            }
            if (params.substr(0,1)=='?') {
                params = params.substr(1);
            }

            s = params.split('&');
            layer.confirm('确认后所选房源将下架，您确定吗？',function(){
                //批量下架操作
                $("input[name='id_all[]']:checked").each(function(){
                    h_id += ','+ $(this).val();
                });
                $.ajax({
                    type: "post",
                    data: {PHPSESSID: "<?php echo session_id();?>",
                        "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                        house_id_str: h_id,
                        params_part:s,
                    },
                    contentType: "application/x-www-form-urlencoded; charset=utf-8",
                    url: "<?=Url::to(["house-details/putoff-status"])?>",
                    beforeSend: function () {
                        $('#layui-layer1').hide();
                        $('#more_modal_load').modal("show");
                        $(".moda1_reject_load").show();
                    },
                    success: function (data) {
                        data = $.parseJSON(data);
                        if (data.status == 1) {
                            layer.alert("批量下架成功");
                            location.reload();
                        }else{
                            layer.alert(data.msg);
                            //add 20171102 20:45
                            $('#more_modal_load').modal("hide");
                            $(".moda1_reject_load").hide();
                            //add end
                        }
                    },
                    complete: function () {
//                        $('#more_modal_load').modal("hide");
//                        $(".moda1_reject_load").hide();
                    },
                    error: function (data) {
                        console.info("error: " + data.responseText);
                    }
                });

            })
        });
//        $('#more_modal_load').modal("show");
//        $(".moda1_reject_load").show();
        //单个所选下架
        $('#singleDown').click(function(){
            var ids = '';
           $("input[name='id[]']:checked").each(function(){
                ids += ','+ $(this).val();
            });
            layer.confirm('确认后所选房源将下架，您确定吗？',function(){
                if(ids.length == 0){
                    layer.alert('无有效房源');
                }
                _this = $(this);
                $.ajax({
                    type: "post",
                    data: {PHPSESSID: "<?php echo session_id();?>",
                        "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                        hid_str: ids,
                    },
                    url: "<?=Url::to(["house-details/putoff-single-status"])?>",
                    beforeSend: function () {
                        $('#layui-layer1').hide();
                        $('#more_modal_load').modal("show");
                        $(".moda1_reject_load").show();
                    },
                    success: function (data) {
                        data = $.parseJSON(data);
                        if (data.status == 1) {
                            layer.alert("下架成功");
                            location.reload();
                        }else{
                            layer.alert(data.msg);
                            //add 20171102 20:45
                            $('#more_modal_load').modal("hide");
                            $(".moda1_reject_load").hide();
                            //
                        }
                    },
                    complete: function () {
//                        $('#more_modal_load').modal("hide");
//                        $(".moda1_reject_load").hide();
                    },
                    error: function (data) {
                        console.info("error: " + data.responseText);
                    }
                });
            })
        })

        $('#alertview').click(function(){
            $('#more_modal').modal("show");
            $(".moda1_reject").show();
        });

        $('.recover').click(function(){
            var hid_str = $(this).attr('hid');
            var id = $(this).attr('but_id');
            var _this = $(this);
            layer.confirm('确认后房源状态将恢复上架，您确定吗？',function(){

                $.ajax({
                    type: "post",
                    data: {PHPSESSID: "<?php echo session_id();?>",
                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                    hid_str: hid_str,
                    id:id
                    },
//                    contentType: "application/json",
                    url: "<?=Url::to(["house-details/do-recover"])?>",
                    beforeSend: function () {
                        $('#layui-layer1').hide();
                        $('.load-ing').addClass('loaded-ing loading-block');
                        $('.load-ing').children().css('display','block');
                    },
                    success: function (data) {
                        data = $.parseJSON(data);
                        if (data.status == 1) {
                            _this.parent().parent().remove();
                            layer.alert("恢复成功");
                        }else{
                            layer.alert(data.msg);
                        }
                    },
                    complete: function () {
                        $('.load-ing').removeClass('loaded-ing loading-block');
                        $('.load-ing').children().css('display','none');
                    },
                    error: function (data) {
                        console.info("error: " + data.responseText);
                    }
                });



            });

        })

    })
</script>



