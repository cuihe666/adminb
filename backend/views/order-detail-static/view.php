<?php

$this->title = '订单详情';

?>

<style>
    .table-bordered td {
        text-align: center;
    }

    .table-bordered th {
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <!--        <p class="lead">Amount Due 2/22/2014</p>-->

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <tr>
                    <th style="width:50%">订单号</th>
                    <td><?php echo $order_data['order_num']; ?></td>
                </tr>
                <tr>
                    <th>订单状态</th>
                    <td><?php echo $order_data['refund_stauts'] ? Yii::$app->params['refund_status'][$order_data['refund_stauts']] : Yii::$app->params['order_status'][$order_data['order_stauts']] ?><?php if($order_data['order_stauts']==12):?><b style="color: #FF0000;">（原因：<?=$order_data['refuse_content']?>）</b><?php endif;?></td>
                </tr>
                <tr>
                    <th>创建时间</th>
                    <td><?php echo $order_data['create_time']; ?></td>
                </tr>
                <tr>
                    <th>入住时间</th>
                    <td><?php echo $order_data['in_time']; ?></td>
                </tr>
                <tr>
                    <th>退房时间</th>
                    <td><?php echo $order_data['out_time']; ?></td>
                </tr>
                <tr>
                    <th>第三方订单号</th>
                    <td><?php echo $order_data['transaction_id']; ?></td>
                </tr>
                <tr>
                    <th>支付方式</th>
                    <td><?php echo Yii::$app->params['pay_type'][$order_data['pay_platform']] ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>单价</th>
                <th>入住天数</th>
                <th>预订房间数</th>
                <th>订单总价(元)</th>
                <th>优惠券金额(元)</th>
                <th>实付金额(元)</th>
                <th>房东收入(元)</th>
                <th>代理商收入(元)</th>
                <th>棠果收入(元)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo $order_data['house_price']; ?></td>
                <td><?php echo $order_data['day_num']; ?>&nbsp;</td>
                <td><?php echo $order_data['book_house_count']; ?>&nbsp;</td>
                <td><?php echo $order_total; ?>&nbsp;&nbsp;&nbsp;<span
                            style="color:red;font-weight:800;" class="show">查看详情</span></td>
                <td><?php echo $order_data['coupon_amount']; ?></td>
                <td><?php echo $order_data['pay_amount']; ?></td>
                <td><?php echo $order_data['landlady_income']; ?></td>
                <td><?php echo $order_data['agent_income']; ?></td>
                <td><?php echo $order_data['tangguo_income']; ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /.col -->
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <h2 class="page-header">
            <i class="fa fa-globe"></i>房源信息
            <!--            <small class="pull-right">Date: 2/10/2014</small>-->
        </h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <tr>
                    <th style="width:50%">房源ID</th>
                    <td><?php echo $house_data['id']; ?></td>
                </tr>
                <tr>
                    <th>房源标题</th>
                    <td><?php echo $house_data['title']; ?></td>
                </tr>
                <tr>
                    <th>房源地址</th>
                    <td><?php echo $house_data['address']; ?></td>
                </tr>
                <tr>
                    <th>房东电话</th>
                    <td><?php echo $house_data['mobile']; ?></td>
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
                <?php foreach ($ruzhu_data as $k => $v): ?>
                    <tr>
                        <td><?php echo $k + 1; ?></td>
                        <td><?php echo $v['guest_name']; ?></td>
                        <td><?php echo Yii::$app->params['card_type'][$v['guest_card_type']]; ?></td>
                        <td><?php echo $v['guest_card_num']; ?></td>
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
                    <td><?php echo $xiadan_data['id']; ?></td>
                    <td><?php echo $xiadan_data['nickname']; ?></td>
                    <td><?php echo $xiadan_data['mobile']; ?></td>
                    <td><?php echo Yii::$app->params['sex'][$xiadan_data['gender']]; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>


<?php if ($order_data['order_stauts'] == 3):
    if ($log):
        ?>


        <div class="row" style="margin-top: 20px;margin-bottom: 20px;">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe">后台操作日志</i>
                    <!--            <small class="pull-right">Date: 2/10/2014</small>-->
                </h2>
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>管理员帐号</th>
                            <th>操作时间</th>
                            <th>操作事件</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $log['admin']; ?></td>
                            <td><?php echo date("Y-m-d H:i:s", $log['create_time']); ?></td>
                            <td><?php echo $log['remark'] ?></td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
    <?php endif ?>
<?php endif ?>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">价格展示</h4>
            </div>
            <div class="modal-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>日期</th>
                        <th>价格</th>
                        <?php if ($order_data['order_type'] == 1): ?>
                            <th>底价</th>
                        <?php endif ?>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($date_prices) : ?>
                        <?php foreach ($date_prices as $k => $v): ?>
                            <tr>
                                <td><?php echo $v['hotel_date'] ?></td>
                                <td><?php echo $v['money'] ?></td>
                                <?php if ($order_data['order_type'] == 1): ?>
                                    <td><?php echo $v['original_price'] ?></td>
                                <?php endif ?>

                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>

                </table>

            </div>

        </div>
    </div>
</div>
<script>

    $('.show').click(function () {
        $('.modal').modal();


    })


</script>





