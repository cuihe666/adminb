<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\tools\Helper;
use backend\controllers\CouponController;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CouponBatchQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '优惠券批次列表';
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\VueAsset::register($this);
//用于加载状态的显示情况
$loading_list = [];

//通用操作按钮
$button_array = [
    'update' => function($url,$model,$key){
        $option = [
            'title' => '查看',
            'aria-label' => '查看',
            'data-pjax' => 0,
//                    'target' => '_blank',
        ];
        return Html::a('查看',$url,$option);
    },

    'special' => function($url,$model,$key){
        if($model->type == 0) return null;
        $option = [
            'title' => '指定产品',
            'aria-label' => '指定产品',
            'data-pjax' => 0
        ];
        return ' | '.Html::a('指定产品',$url,$option);
    },
//            'show' => function($url,$model,$key){
//                if($model->mode != 1){
//                    return null;
//                }
//                $batch_code = $model->batch_code;
//                $option = [
//                    'title' => '优惠券',
//                    '@click' => "coupon_list.openModal('{$batch_code}')"
//                ];
//                return ' | '.Html::a('优惠券','###',$option);
//            }
    'list' => function($url,$model,$key){
        if($model->status < 1){
            return null;
        }
        return ' | '.Html::a('领取详情',$url);
    },
    'delete' => function($url,$model,$key){
        return null;
    }

];
//管理员角色可看到的操作按钮
if(Helper::checkPermission(CouponController::$admin_role)){
    $admin_button = [
        'delete' => function($url,$model,$key){
            if($model->status != 0) return null;
            $option = [
                'title' => '删除',
                'aria-label' => '删除',
                'data-confirm' => '您确定要删除此项吗?',
                'data-method' => 'post',
                'data-pjax' => 0
            ];
            return ' | '.Html::a('删除',$url,$option);
        },
        'forbidden' => function($url,$model,$key){
            if($model->status == 0 || $model->status == 4) return null;
            $title = '禁用';
            $option = [
                'title' => $title,
                'aria-label' => $title,
                'data-confirm' => "您确定要{$title}此项吗?此项为不可逆操作!",
                'data-method' => 'post',
                'data-pjax' => 0
            ];
            return ' | '.Html::a($title,$url,$option);
        },
        'confirm' => function($url,$model,$key){
            if($model->status != 0) return null;
            $option = [
                'title' => '激活',
                '@click' => "alertInfo('{$url}','loading_{$key}')",
                'v-else' => ''
            ];
            return ' | '.Html::a('<i v-if="loading" class="el-icon-loading"></i>','javascript:;',['v-if'=>"loading_list.loading_{$key}"]) . Html::a('激活','javascript:;',$option);
        },
    ];
    $button_array = array_merge($button_array,$admin_button);
}

$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    'id',
    [
        'attribute' => 'title',
        'value' => function($model) use(&$loading_list){
            $loading_list["loading_{$model->id}"] = false;

            return Html::a($model->title,"/coupon/update?id={$model->id}");
        },
        'format' => 'raw',
    ],
    'batch_code',
    [
        'attribute' => 'type',
        'value' => function($model){
            return Yii::$app->params['coupon_type'][$model->type];
        }
    ],
    [
        'attribute' => 'is_forever',
        'value' => function($model){
            $status = $model->is_forever;
            if($status == 1){
                return '永久有效';
            }else{
                $start = substr($model->start_time,0,10);
                $end = substr($model->end_time,0,10);
                return $start . ' => ' . $end;
            }
        }
    ],
    'amount',
     'rule',
     'create_name',
    [
        'attribute' => 'status',
        'value' => function($model){
            return Yii::$app->params['coupon_status'][$model->status];
        }
    ],

    [
        'class' => 'yii\grid\ActionColumn',
        'header' => '操作',
        'template' => '{update}{delete}{confirm}{special}{show}{forbidden}{list}',
        'buttons' => $button_array
    ],
];
?>
<?= \backend\widgets\ElementAlertWidget::widget();?>
<div class="coupon-batch-index">
    <p>
        <?= Html::a('新增优惠券批次', ['create'], ['class' => 'btn btn-success']) ?>
        <?= \backend\widgets\DistributeCouponWidget::widget() ?>
    </p>
</div>
<div class="wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox" v-cloak id="coupon_box">

                <?php
                // You can choose to render your own GridView separately
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $columns,
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
<div class="modal fade" id="couponList" tabindex="-1" role="dialog" aria-labelledby="couponListLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">优惠券列表</h4>
            </div>
            <div class="modal-body">
                <el-table
                    :data="tableData"
                    v-loading="loading"
                    max-height = "450"
                    min-height = "100"
                    style="width: 100%">
                    <el-table-column
                        prop="redeem_code"
                        label="激活码"
                        width="180">
                    </el-table-column>

                    <el-table-column
                        prop="rule"
                        label="需要满减">
                    </el-table-column>

                    <el-table-column
                        prop="amount"
                        label="金额">
                    </el-table-column>

                    <el-table-column
                        prop="lifetime"
                        label="有效时间"
                        width="180"
                    >
                    </el-table-column>
                </el-table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<script>
    var loading_list = <?= json_encode($loading_list) ?>;
    console.log(loading_list)
    var csrf_token = '<?= Yii::$app->request->csrfToken ?>';
    var coupon_batch = new Vue({
        el: '#coupon_box',
        data: {
            loading : false,
            loading_list: loading_list
        },
        methods: {
             alertInfo: function(url,status){
                 var _self = this;

                 this.$confirm('是否激活?激活后将不可再修改', '提示', {
                     confirmButtonText: '确定',
                     cancelButtonText: '取消',
                     type: 'warning'
                 }).then(function(){
                     _self.postMethod(url,status);
                 }).catch(function(){
                     _self.loading = false;
                     _self.loading_list[status] = false;
                     _self.message('已取消','info');
                 })
             },
            //消息提示发放
            message: function(msg,type){
                this.$message({
                    type: type,
                    message: msg
                });
            },
            postMethod: function(url,status){
                var _self = this;
                var data = new FormData();
                data.append('_csrf-backend', csrf_token);
                _self.loading = true;
                _self.loading_list[status] = true;

                axios.post(url,data).then(function(res){
                    _self.loading = false;
                    _self.loading_list[status] = false;
//                    console.log(res);

                    if(res.data.code == 200){
                        _self.message('已生成优惠券','success');
                        location.reload();
                    }else{
                        _self.message(res.data.error,'error');
                    }
                }).catch(function (error) {
                    _self.loading = false;
                    _self.loading_list[status] = false;
                    console.log('error',error);
                    _self.message('没有权限或者服务器繁忙','warning');
                })
            }
        }
    });

    //显示优惠券列表
    var coupon_list = new Vue({
        el: '#couponList',
        data: {
            coupon_list : [],
            tableData: [],
            loading: false
        },
        methods: {
            getList: function(batch_code){
                var _self = this;
                _self.tableData = [];
                _self.loading = true;
                var url = '/coupon/ticket-list?batch_code=' + batch_code;

                axios.get(url)
                    .then(function(res){
                        _self.loading = false;
                        _self.tableData = _self.generateTableData(res.data.body);
                    })
                    .catch(function(error){
                        _self.loading = false;
                        console.log(error)
                    })

            },
            openModal: function(batch_code){
                console.log(batch_code,'openModal');
                $('#couponList').modal('show');
                this.getList(batch_code)
            },
            generateTableData: function(data){
                var  res = [];
                res = data.map(function(row){
                    if(row.is_forever == "0"){
                        row.lifetime = row.start_time.substr(2,9) + ' > ' + row.end_time.substr(2,9);
                    }else{
                        row.lifetime = '永久有效'
                    }
                    return row
                });
                return res
            }
        }
    })
</script>
