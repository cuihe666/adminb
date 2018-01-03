<?php
use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model backend\models\UserBackend */

$this->title = '房型管理';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\ScrollAsset::register($this);
?>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">

<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/bootstrap/css/bootstrap-datetimepicker.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
      page. However, you can choose any other skin. Make sure you
      apply the skin class to the body tag so the changes take effect.
-->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/skins/skin-blue.min.css">
<!--new link-->
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/dist/css/rummery.css"/>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/gobal.css" />
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/xhhgrogshop.css" />
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/layer/skin/default/layer.css"/>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
    .hotel_information_tips,.hostshort_b{
        color:red;
    }
</style>



<body class="hold-transition skin-blue sidebar-mini">


    <!-- Content Wrapper. Contains page content -->
    <div class="wrapper-content animated fadeInRight" style="background-color: #F2F2F2;">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <ul class="rummery_tab clearfix">
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/update','id'=>$id]) ?>">酒店信息</a></li>
                <!-- 酒店2.1 添加酒店账户信息 ↓ admin:ys time:2017/11/3 -->
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-account','id'=>$id]) ?>">账号信息</a></li>
                <!-- 完 ↑ -->
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/two','id'=>$id]) ?>">酒店政策</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/three','id'=>$id]) ?>">服务设施</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/four','id'=>$id]) ?>">房型管理</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/set-price','hotel_id'=>$id]) ?>">房态房价设置</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/hotel-pic','id'=>$id]) ?>">图片管理</a></li>
                <li class="col-sm-8 current"><a href="###">关联供应商</a></li>
                <li class="col-sm-8"><a href="<?php echo \yii\helpers\Url::to(['hotel/contact','id'=>$id]) ?>">联系人信息</a></li>
            </ul>

            <div class="rummery_con">
                <div class="rummery_item rummery_supply">
                    <div class="search-box clearfix" style="margin: 0 0 20px 20px;">
                        <div class="search-item">
                            <?= Html::beginForm(['hotel/supplier','id'=>$id], 'get', ['class' => 'form-horizontal', 'id' => 'addForm','style'=>"float:left;"]) ?>
                            <div class="search-item">
                                <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                    <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control input', 'placeholder' => '请输入供应商名称或ID','value'=>$searchModel->name]) ?>
                                </div>
                            </div>


                            <div class="search-item">
                                <div class="input-group" style="width: 200px;margin-right: 5px;">
                                    <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                                    <?= Html::a("清空",$url = ['hotel/supplier','id'=>$id],$options = ['class' => 'btn btn-sm btn-primary',"style"=>"line-height:30px; color:#fff;"]) ?>
                                </div>
                            </div>

                            <?= Html::endForm() ?>
                        </div>
                    </div>

                    <?php
                    $gridColumns = [
                        'id',
                        'name',
                        ['attribute' => 'city',
                            'header' => '城市',
                            'value' => function ($model) {
                                return $model->cityName->name;
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '是否有效',
                            'template' => '<div>{view}</div> ',
                            'buttons' => [
                                'view' => function ($url, $model, $key)  use($HotelModel){
                                    $start = strtotime($model->start_time);
                                    $end = strtotime($model->end_time);
                                    $curr = time();
                                    if($curr<=$end && $curr>=$start){
                                        return "有效";
                                    }
                                    else{
                                        return "无效";
                                    }
                                },
                            ],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '酒店名称',
                            'template' => '<div>{view}</div> ',
                            'buttons' => [
                                'view' => function ($url, $model, $key)  use($HotelModel){
                                    return $HotelModel->complete_name;
                                },
                            ],
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '酒店类型',
                            'template' => '<div>{view}</div> ',
                            'buttons' => [
                                'view' => function ($url, $model, $key)  use($HotelModel){
                                    return Yii::$app->params['hotel_type'][$HotelModel->type];
                                },
                            ],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '关联状态',
                            'template' => '<div>{view}</div> ',
                            'buttons' => [
                                'view' => function ($url, $model, $key)  use($HotelModel){
                                    if($HotelModel->supplier_id==$key){
                                        if($HotelModel->supplier_relation==0){
                                            return "已申请";
                                        }
                                        else{
                                            return "已关联";
                                        }
                                    }
                                    else{
                                        return "未关联";
                                    }
                                   /* if($key==$HotelModel->supplier_id && $HotelModel->supplier_relation==1)
                                        return "已关联";
                                    else
                                        return "未关联";*/
                                    //return Yii::$app->params['hotel_relation_status'][$HotelModel->supplier_relation];
                                },
                            ],
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '操作',
                            'template' => '<div>{view}{update}</div> ',
                            'buttons' => [
                                'view' => function ($url, $model, $key) use($HotelModel) {
                                    return Html::a('查看供应商',['hotel-supplier/add', 'id' => $key], ['target'=>'_blank','class' => 'btn btn-info','type'=>1,'data'=>$model->id,'style'=>'margin-right:10px; color:#fff;']);
                                },
                                'update' => function ($url, $model, $key) use($HotelModel) {
                                    if($HotelModel->supplier_id==$key){
                                        if($HotelModel->supplier_relation==0){
                                            return Html::a('等待审核', 'javascript:;', ['class' => 'btn btn-default','style'=>'margin-right:10px;']);
                                        }
                                        else{
                                            return Html::a('解除关联', 'javascript:;', ['class' => 'btn btn-danger btn_status','type'=>2,'data'=>$model->id,'style'=>'margin-right:10px;']);
                                        }
                                    }
                                    else{
                                        return Html::a('申请关联', 'javascript:;', ['class' => 'btn btn-info btn_status','type'=>0,'data'=>$model->id,'style'=>'margin-right:10px;']);
                                    }
                                   /* if($key==$HotelModel->supplier_id && $HotelModel->supplier_relation==1)
                                        return Html::a('解除关联', 'javascript:;', ['class' => 'btn btn-danger btn_status','type'=>0,'data'=>$model->id,'style'=>'margin-right:10px;']);
                                    else
                                        return Html::a('关联', 'javascript:;', ['class' => 'btn btn-info btn_status','type'=>1,'data'=>$model->id,'style'=>'margin-right:10px;']);*/
                                   /* if($HotelModel->supplier_relation==0){
                                        return Html::a('关联', 'javascript:;', ['class' => 'btn btn-info btn_status','type'=>1,'data'=>$model->id,'style'=>'margin-right:10px;']);
                                    }
                                    else{
                                        return Html::a('解除关联', 'javascript:;', ['class' => 'btn btn-danger btn_status','type'=>0,'data'=>$model->id,'style'=>'margin-right:10px;']);
                                    }*/
                                },
                            ],
                        ],


                    ];

                    // Renders a export dropdown menu
                   /* echo ExportMenu::widget([
                        'dataProvider' => $dataProvider
                        ,'columns' => $gridColumns
                    ]);*/

                    // You can choose to render your own GridView separately
                    // You can choose to render your own GridView separately
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
                        'pager' => [
                            'firstPageLabel' => '首页',
                            'lastPageLabel' => '尾页',
                        ],
                    ]);
                    ?>

                </div>
                <input type="hidden" name="hotel_id" class="hotel_id" value="<?=$id?>" />
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <div class="control-sidebar-bg"></div>


<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="<?= Yii::$app->request->baseUrl ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/app.min.js"></script>
<!--new link-->
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/rummery.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/dist/js/gobal.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/layer/layer.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
<script>
    /*点击修改酒店状态*/
    $(document).on('click','.btn_status',function(){
        var _this = $(this);
        layer.confirm('您确定操作吗？', {
            btn: ['确定','取消'], //按钮
            shade: false //不显示遮罩
        }, function(index){
            var supplier_id = _this.attr("data");    //当前供应商id
            var oprtype  =_this.attr("type");        //操作类型 0：未关联，1：已关联
            var hotel_id = $(".hotel_id").val();    //酒店id
            $.ajax({
                type: 'POST',
                url: '<?= \yii\helpers\Url::toRoute(["relation-supplier"])?>',
                data: {
                    supplier_relation: oprtype,
                    hotel_id:hotel_id,
                    supplier_id:supplier_id,
                },
                dataType: 'json',
                success: function (data) {
                    if(data>=0){
                        location.reload();
                        //location.href = '<?php echo \yii\helpers\Url::to(['hotel/supplier','id'=>$id]) ?>';
                    }
                    if(data==-1){
                        layer.alert("参数有误");
                    }
                    if(data==-2){
                        layer.alert("操作失败");
                    }
                },
            });
        })
    })
</script>
</html>

