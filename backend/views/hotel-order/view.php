<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\HotelOrder */

$this->title = '订单详情展示:' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hotel Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\VueAsset::register($this);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
<div class="hotel-order-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'status',
                'label' => '订单状态',
                'value' => function($model) {
                    if ($model->is_deny == 1) {
                        return '酒店拒单';
                    } else {
                        return Yii::$app->params['hotel_order_status'][$model->status];
                    }
                }
            ],
            'order_num',
            'create_time',
            'in_time',
            'out_time',
            'update_time',
            'transaction_id',
            'order_mobile',
            [
                'attribute' => 'pay_platform',
                'label' => '支付方式',
                'value' => Yii::$app->params['pay_type'][$model->pay_platform]
            ]
        ],
    ]) ?>

</div>

<div class="row" style="margin-bottom: 30px;" id="order_page">
    <div class="col-xs-6">
        <button type="button" class="btn btn-default" @click="openLog(<?= $model->id ?>)"> 查看操作日志</button>
        <!--        <button type="button" class="btn btn-default"> 确认订单</button>-->
        <?php if (in_array($model->status, ['11', '12', '0'])): ?>
            <button type="button" class="btn btn-default"
                    @click="openModel('/hotel-order/cancel?id=<?= $model->id ?>')"> 取消订单
            </button>
        <?php endif ?>
        <?php if ($model->is_deny == 1 && $model->status == 11): ?>
            <button type="button" class="btn btn-default"
                    @click="openDenyModel('/hotel-order/deny?id=<?= $model->id ?>')">
                拒绝
            </button>
        <?php endif ?>
    </div>

    <!-- Modal cancel order -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="transition: all 1s;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
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

                    <transition mode="out-in" enter-active-class="animated flipInX"
                                leave-active-class="animated flipOutX">
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
                    <button type="button" class="btn btn-primary" v-else>确定<i class="el-icon-loading"></i></button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal cancel order -->
    <div class="modal fade" id="denyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="transition: all 1s;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">提示:</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <label style="float: left">状态：</label>
                        <span class="check_status">拒绝</span>
                    </p>
                    <p>
                        <label style="float: left">备注：</label>
                        <textarea name="remarks" class="remarks" cols="60" rows="5"
                                  v-model="modelDenyInfo.msg"></textarea>
                    </p>

                    <transition mode="out-in" enter-active-class="animated flipInX"
                                leave-active-class="animated flipOutX">
                        <p v-if="modelInfo.isError" key="1">
                            <label style="float: left; width: 70px;">提示信息: </label>
                            <span style="color: #f0ad4e;">{{ modelDenyInfo.errorInfo }}</span>
                        </p>
                        <p v-else key="2" style="height: 18.89px">
                        </p>
                    </transition>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" @click="closeDenyModel()" v-if="!postLock">确定</button>
                    <button type="button" class="btn btn-primary" v-else>确定<i class="el-icon-loading"></i></button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal show log -->
    <div class="modal fade" id="myLog" tabindex="-1" role="dialog" aria-labelledby="myLogLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="transition: all 1s;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">操作记录</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>操作时间</th>
                            <th>操作人</th>
                            <th>操作内容</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="logList == null">
                            <td><i class="el-icon-loading"></i></td>
                            <td><i class="el-icon-loading"></i></td>
                            <td><i class="el-icon-loading"></i></td>
                        </tr>
                        <tr v-else v-for="(item,index) in logList">
                            <td>{{ item.time }}</td>
                            <td>{{ item.handler }}</td>
                            <td>{{ item.content }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>


</div>
<div class="row">
    <div class="col-xs-12 table-responsive">
        <h2 class="page-header">
            <i class="fa fa-globe"></i>订单信息
            <!--            <small class="pull-right">Date: 2/10/2014</small>-->
        </h2>
        <table class="table table-striped table-bordered table-hover">
            <caption>订单总览</caption>
            <thead>
            <tr>
                <th>入住时间</th>
                <th>总价</th>
                <th>优惠券金额(元)</th>
                <th>实付金额(元)</th>
                <th>酒店收入(元)</th>
                <th>棠果收入(元)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td> <?= $model->in_time ?> - <?= $model->out_time ?></td>
                <td> <?= $model->order_total ?></td>
                <!-- @2017-11-13 11:45:44 fuyanfei to update hotel_coupon.money           -->
                <td> <?= sprintf("%.2f", $coupon['money']) ?></td>
                <td> <?= $model->pay_total ?></td>
                <td> <?= $model->hotel_income ?> </td>
                <td> <?= $model->tango_income ?> </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /.col -->
</div>


<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <caption>订单细则</caption>
            <thead>
            <tr>
                <th>入住时间</th>
                <th>房型</th>
                <th>底价(元)</th>
                <th>卖价(元)</th>
                <th>佣金比例(%)</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td> <?= $order->datetime ?></td>
                    <td> <?= $order->houseName->name ?></td>
                    <td> <?= $order->price ?></td>
                    <td> <?= $order->sell_price ?> </td>
                    <td> <?= $order->scale ?> </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.col -->
</div>


<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <h2 class="page-header">
            <i class="fa fa-globe"></i>酒店信息
            <!--            <small class="pull-right">Date: 2/10/2014</small>-->
        </h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <tr>
                    <th style="width:50%">酒店ID</th>
                    <td><?= $hotel->id ?></td>
                </tr>
                <tr>
                    <th>酒店标题</th>
                    <td><?= $hotel->complete_name ?></td>
                </tr>
                <tr>
                    <th>酒店地址</th>
                    <td>
                        <?= $hotel->getWholeAddress() ?>
                    </td>
                </tr>
                <tr>
                    <th>酒店电话</th>
                    <td><?= $hotel->getWholeMobile() ?></td>
                </tr>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>


<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <h2 class="page-header">
            <i class="fa fa-globe"></i>入住人信息
            <!--            <small class="pull-right">Date: 2/10/2014</small>-->
        </h2>
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>编号</th>
                    <th>真实姓名</th>
                    <th>证件类型</th>
                    <th>证件号码</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($guests as $index => $guest): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= $guest->guest_name ?></td>
                        <td>暂缺字段</td>
                        <td>暂缺字段</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>


<div class="row" style="margin-top: 20px;margin-bottom: 20px;">
    <div class="col-xs-12">
        <h2 class="page-header">
            <i class="fa fa-globe"></i>下单人信息
            <!--            <small class="pull-right">Date: 2/10/2014</small>-->
        </h2>
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>用户ID</th>
                    <th>用户昵称</th>
                    <th>用户账号</th>
                    <th>用户性别</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= $user->uid ?></td>
                    <td><?= $user->nickname ?></td>
                    <td><?= $user->getAccount() ?></td>
                    <td><?= Yii::$app->params['sex'][$user->gender]; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>

<script>
    var order = new Vue({
        el: "#order_page",
        data: {
            modelInfo: {
                msg: '',
                url: '',
                isError: false,
                errorInfo: '请输入取消订单的原因'
            },

            modelDenyInfo: {
                msg: '',
                url: '',
                isError: false,
                errorInfo: '请输入取消订单的原因'
            },
            postLock: false,
            order_id: 0,
            logList: null
        },
        methods: {
            openModel: function (url) {
                this.resetModelInfo();
                this.modelInfo.url = url;
                $("#myModal").modal('show');
            },

            openDenyModel: function (url) {
                this.resetModelInfo();
                this.modelDenyInfo.url = url;
                $("#denyModal").modal('show');
            },
            closeModel: function () {
                var postData = new FormData();
                var msg = this.modelInfo.msg;
                var postUrl = this.modelInfo.url;
                var _self = this;
                postData.append('desc', msg);
                postData.append('_csrf-backend', '<?= Yii::$app->request->csrfToken ?>');

                if (this.postLock) {
                    return
                }
                this.postLock = true;
                axios.post(postUrl, postData).then(function (res) {
                    _self.postLock = false;
                    console.log(res.data.code, 'done');
                    if (res.data.code == 200) {
                        console.log(res.code, 'done');
                        $('#myModal').modal('hide');
                        _self.resetModelInfo();
                        location.reload(true);
                    } else {
                        _self.modelInfo.isError = true;
                        _self.modelInfo.errorInfo = res.data.message;
                    }
                }).catch(function (res) {
                    console.log(res)
                    _self.postLock = false;

                })
            },

            closeDenyModel: function () {
                var postData = new FormData();
                var msg = this.modelDenyInfo.msg;
                var postUrl = this.modelDenyInfo.url;
                var _self = this;
                postData.append('desc', msg);
                postData.append('_csrf-backend', '<?= Yii::$app->request->csrfToken ?>');

                if (this.postLock) {
                    return
                }
                this.postLock = true;
                axios.post(postUrl, postData).then(function (res) {

                    _self.postLock = false;
                    console.log(res.data.code, 'done');
                    if (res.data.code == 200) {

                        console.log(res.code, 'done');
                        $('#myModal').modal('hide');
                        _self.resetModelInfo();
                        location.reload(true);
                    } else {
                        _self.modelInfo.isError = true;
                        _self.modelInfo.errorInfo = res.data.message;
                    }
                }).catch(function (res) {
                    console.log(res)
                    _self.postLock = false;

                })
            },
            //重置信息
            resetModelInfo: function () {
                this.modelInfo.msg = '';
                this.modelInfo.isError = false;
                this.modelInfo.errorInfo = '';
            },
            //打开 log 信息
            openLog: function (id) {
                $("#myLog").modal('show');
                this.order_id = id;
                this.fetchLog();
            },
            closeLog: function () {
                $("#myLog").modal('hide');
            },
            fetchLog: function () {
                var _self = this
                if (this.logList == null) {
                    axios.get('/hotel-order/log?id=' + this.order_id)
                        .then(function (res) {
                            if (res.data.code == 200) {
                                _self.logList = res.data.data;
                                console.log(_self.logList)
                            } else {
                                _self.logList = [
                                    {
                                        "time": "暂无数据",
                                        "handler": "暂无数据",
                                        "content": "暂无数据"
                                    }
                                ]
                            }
                        })
                }
            }
        }
    });
</script>