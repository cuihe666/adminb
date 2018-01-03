<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HotelOrderQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hotel Orders';
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\VueAsset::register($this);

$gridColumns = [
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => '订单ID',
        'template' => '{view}',
        'buttons' => [
            'view' => function($url,$model){
                return Html::a($model->id,'/hotel-order/view?id='.$model->id);
            }
        ]
    ],
    'order_num',
    [
        'attribute' => 'city',
        'value' => function($model){
            $city = $model->cityName;
            if(is_null($city)){
                $name = '未识别';
            }else{
                $name =  $city->name;
            }

            return $name;
        }
    ],
    'create_time',
    [
        'label' => '支付时间',
        'value' => function($model){
             return $model->pay_time;
        }
    ],
//    'hotel_house_id',
    [
        'label' => '酒店名称',
        'value' => function($model){
            $hotel = $model->hotel;
            if(is_null($hotel)){
                $name = '未识别';
            }else{
                $name =  $hotel->complete_name;
            }

            return $model->hotel_id . ':' . $name;
        }
    ],
    'hotel_house_name',
//    'order_uid',
    [
        'label' => '下单人',
        'value' => function($model){
            $user = $model->user;
            if(is_null($user)){
                $name = '未识别';
            }else{
                $name =  $user->nickname;
            }

            return $name;
        }
    ],
    'order_mobile',
    'in_time',
    'out_time',
//    'transaction_id',
//    [
//        'attribute' => 'hotel_type',
//        'value' => function($model){
//            return Yii::$app->params['hotel_type'][$model->hotel_type];
//        }
//    ],
    [
        'attribute' => 'status',
        'value' => function($model){
            if ($model->is_deny == 1) {
                return '酒店拒单';
            } else {
                return Yii::$app->params['hotel_order_status'][$model->status];
            }

        }
    ],
    'order_total',
    [
        'label' => '优惠券',
        'value' => function($model){
            //@2017-11-13 11:46:06 fuyanfei to update hotel_coupon.money
            return sprintf("%.2f", $model->money);
        }
    ],
    'pay_total',
    'hotel_income',
    'tango_income',
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => '操作',
        'template' => '{view}{cancel}{confirm}{confirm_refund}{deny_refund}',
        'buttons' => [
            'view' => function($url,$model,$key){
                return Html::a('查看',"$url",['target'=>'_blank']);
            },
            'cancel' => function($url,$model,$key){
                if(in_array($model->status,['11','12','0'])) {
                    return '/'.Html::a('取消订单', "javascript:;",['@click' => "openModel('{$url}')"]);
                }else{
                    return null;
                }
            },
            'confirm' => function($url,$model,$key){
                if(in_array($model->status,['11'])){
                    return '/'.Html::a('确认订单',"$url");
                }
                return null;
            },
            'confirm_refund' => function ($url,$model,$key) {
                if (in_array($model->status,['31'])) {
                    return '/'.Html::a('完成退款',"#", ['class' => 'confirm_refund', 'id' => $key]);
                }
                return NULL;
            },
            'deny_refund' => function ($url,$model,$key) {
                if (in_array($model->status,['31'])) {
                    return '/'.Html::a('拒绝退款',"#", ['class' => 'deny_refund', 'id' => $key]);
                }
                return NULL;
            }
        ]
    ]
];


?>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/yulan/js/jquery-1.9.1.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<?= \backend\widgets\ElementAlertWidget::widget() ?>

<div class="booking-index" id="order_page">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <?= $this->render('_search',['searchModel' => $searchModel]) ?>

                    <?php
                    // Renders a export dropdown menu
                    echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns
                    ]);
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
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="transition: all 1s;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">提示:</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <label style="float: left">状态：</label>
                        <span class="check_status">取消订单</span>
                    </p>
                    <p>
                        <label style="float: left">备注：</label>
                        <textarea name="remarks" class="remarks" cols="60" rows="5" v-model="modelInfo.msg"></textarea>
                    </p>

                    <transition mode="out-in" enter-active-class="animated flipInX" leave-active-class="animated flipOutX">
                        <p v-if="modelInfo.isError" key="1">
                            <label style="float: left; width: 70px;">提示信息: </label>
                            <span style="color: #f0ad4e;">{{ modelInfo.errorInfo }}</span>
                        </p>
                        <p v-else key="2" style="height: 18.89px">
                        </p>
                    </transition>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" @click="closeModel()" v-if="!postLock">确定</button>
                    <button type="button"  class="btn btn-primary" v-else>确定<i class="el-icon-loading"></i></button>
                </div>
            </div>
        </div>
    </div>

</div>






<script>
    var order_list = new Vue({
        el: "#order_page",
        data: {
            modelInfo: {
                msg:'',
                url: '',
                isError: false,
                errorInfo: '请输入取消订单的原因'
            },
            postLock :false
        },
        methods: {
            openModel: function(url){
                this.resetModelInfo();
                this.modelInfo.url = url;
                $("#myModal").modal('show');
            },
            closeModel: function(){
                var postData = new FormData();
                var msg = this.modelInfo.msg;
                var postUrl = this.modelInfo.url;
                var _self = this;
                postData.append('desc',msg);
                postData.append('_csrf-backend','<?= Yii::$app->request->csrfToken ?>');

                if(this.postLock){
                    return
                }
                this.postLock = true;
                axios.post(postUrl,postData).then(function(res){
                    _self.postLock = false;
                    console.log(res.data,'done');
                    if(res.data.code == 200){
                        console.log(res.code,'done');
                        $('#myModal').modal('hide');
                        _self.resetModelInfo();
                        location.reload(true);
                    }else{
                        _self.modelInfo.isError = true;
                        _self.modelInfo.errorInfo = res.data.message;
                    }
                }).catch(function(res){
                    console.log(res)
                    _self.postLock = false;

                })
            },
            //重置信息
            resetModelInfo: function(){
                this.modelInfo.msg = '';
                this.modelInfo.isError = false;
                this.modelInfo.errorInfo = '';
            },
        }
    });
</script>
<script>
    $(document).on('click','.confirm_refund',function () {
        var id = $(this).attr("id");
        layer.confirm("您确定要完成退款吗？", {
            btn:['确定', '取消']
        }, function () {
            $.post("/hotel-order/confirm-refund",{
                "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
                data:{id:id},
                dataType:'json',
            }, function (data) {
                var info = jQuery.parseJSON(data);
                if (info == 'success') {
                    location.reload();
                } else {
                    layer.alert(info);
                }
            });
        }, function () {

        });
    });
    $(".deny_refund").click(function () {
        var id = $(this).attr("id");
        layer.confirm("您确定要拒绝退款吗？",{
            btn:['确定', '取消']
        }, function () {
            $.post("<?= \yii\helpers\Url::to(['hotel-order/deny-refund'])?>",{
                "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
                data:{id:id},
            },function (data) {
                if (data == 'success') {
                    location.reload();
                } else {
                    layer.alert(data);
                }
            });
        }, function () {

        })
    });
</script>







