<?php

$this->title = '变更单详情';


?>

<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">基本信息</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <td>变更单号：</td>
                        <td><?= $refundData['refund_num'] ?></td>
                        <td>取消时间：</td>
                        <td><?= date("Y-m-d H:i:s", $refundData['create_time']) ?></td>

                    </tr>
                    <tr>
                        <td>订单编号：</td>
                        <td><?= $orderData['order_num'] ?></td>
                        <td><p id='userLog' style="width: 90px;" class="btn btn-info">操作日志</p></td>
                        <td></td>

                    </tr>
                    <tr>
                        <td>采购单号：</td>
                        <td><?= $purchaseData['purchase_num'] ?></td>
                        <td></td>
                        <td></td>


                    </tr>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">审核信息</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <td>发起方：</td>
                        <td>
                            <?php
                            $arr = [1 => '买家', 2 => '卖家', 3 => '后台'];
                            if (array_key_exists($refundData['sponsor'], $arr)) {
                                echo $arr[$refundData['sponsor']];
                            }

                            ?>

                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>状态：</td>
                        <td><?php echo Yii::$app->params['shop']['refund_status'][$refundData['status']] ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><p id='AdminLog' style="width: 90px;" class="btn btn-info">操作日志</p></td>
                        <td colspan="5"></td>


                    </tr>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">商品信息</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">

                <?php if ($goodsData):
                    foreach ($goodsData as $k => $v):
                        ?>
                        商品<?= $k + 1 ?>:
                        <table class="table table-bordered table-hover">
                            <tr>
                                <td>商品类型：</td>
                                <td><?php
                                    $arr = [1 => '旅行', 2 => '特产', 3 => '科技', 4 => '家居'];
                                    if (array_key_exists($v['operate_category'], $arr)) {
                                        echo $arr[$v['operate_category']];
                                    } else {
                                        echo '暂无';
                                    }


                                    ?></td>
                                <td>商品价格：</td>
                                <td><?= $v['price'] + $v['point'] / 10 ?></td>
                                <td>商品数量:</td>
                                <td><?= $v['num'] ?></td>
                            </tr>
                            <tr>
                                <td>商品状态：</td>
                                <td><?= Yii::$app->params['shop']['goods_status'][$v['status']] ?></td>
                                <td>商品上传时间：</td>
                                <td><?= $v['created_at'] ?></td>
                                <td>商品上传人：</td>
                                <td><?= $v['principal'] ?></td>
                            </tr>
                            <tr>
                                <td>商品名称：</td>
                                <td><?= $v['title'] ?></td>
                                <td>商品审核时间</td>
                                <td><?= \backend\models\ShopGoods::getTime($v['id'], 30) ?></td>
                                <td>卖家账号：</td>
                                <td><?= $v['admin_username'] ?></td>


                            </tr>
                            <tr>
                                <td>商品编号：</td>
                                <td><?= $v['goods_num'] ?></td>
                                <td>商品上架时间：</td>
                                <td><?= \backend\models\ShopGoods::getTime($v['id'], 20) ?></td>
                                <td>卖家手机：</td>
                                <td><?= $v['principal_phone'] ?></td>
                            </tr>

                        </table>
                        <br>
                    <?php endforeach;
                endif ?>


            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">物流状态</h3>

            </div>

            <div class="box-body">
                <el-steps :active="
                  <?php
                switch ($orderData['status']) {
                    case  0:
                        echo 0;
                        break;
                    case  5:
                        echo 1;
                        break;
                    case  10:
                        echo 2;
                        break;
                    case  20:
                        echo 3;
                        break;
                    default:
                        echo 0;
                        break;


                }


                ?>

" finish-status="success" id="status">
                    <el-step title="待发货"></el-step>
                    <el-step title="已发货" description="发货时间:<?php if ($sendStar) {
                        echo date('Y-m-d H:i:s', $sendStar);
                    }
                    ?>"></el-step>
                    <el-step title="已签收"
                             description="收货时间:<?php if ($sendEnd) {
                                 echo date('Y-m-d H:i:s', $sendEnd);
                             } ?>"></el-step>
                </el-steps>

                <!-- /.box-body -->
            </div>


        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">买家信息</h3>

            </div>


            <!-- /.box-header -->


            <table id="example2" class="table table-bordered table-hover">
                <tr>
                    <td>买家账号</td>
                    <td><?= $customerAccount ?></td>
                    <td>买家姓名</td>
                    <td><?= $addressData['name'] ?></td>
                </tr>
                <tr>
                    <td>买家手机</td>
                    <td><?= $customerAccount ?></td>
                    <td>买家地址</td>

                    <td><?= \backend\service\CommonService::getCityName($addressData['province']) . '&nbsp;&nbsp;' . \backend\service\CommonService::getCityName($addressData['city']) . '&nbsp;&nbsp;' . \backend\service\CommonService::getCityName($addressData['area']) . '&nbsp;&nbsp;' . $addressData['address'] ?></td>


                </tr>
                <tr>


                    <td>订单金额</td>
                    <td><?= $orderData['price_total'] . '元' . $orderData['point_total'] . '分' ?></td>
                    <?php

                    $receiveNums = '';
                    foreach ($receiveData as $k => $v) {
                        $receiveNums .= $v['receive_num'] . ',';

                    }
                    $receiveNum = rtrim($receiveNums, ',')
                    ?>

                    <?php if ($refundData['status'] == 20):

                        ?>
                        <td>收款单号</td>

                        <td><?php echo $receiveNum ?></td>
                    <?php else: ?>


                        <td>订单状态</td>
                        <td><?= Yii::$app->params['shop']['order_status'][$orderData['status']] ?></td>
                    <?php endif ?>
                </tr>
                <tr>
                    <td>应退金额</td>
                    <td><?= $refundData['refund_money'] . '元' . $refundData['point_total'] . '分' ?></td>
                    <?php if ($refundData['status'] == 20):

                        ?>
                        <td>付款单</td>
                        <td><?= implode(',', $customerPayNum) ?></td>

                    <?php else: ?>
                        <td>收款单号</td>
                        <td>
                            <?= $receiveNum;
                            ?>
                        </td>
                    <?php endif ?>


                </tr>
            </table>

            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">卖家信息</h3>

            </div>


            <!-- /.box-header -->


            <table id="example2" class="table table-bordered table-hover">
                <tr>
                    <td>卖家账号</td>
                    <td><?= $supplierData['admin_username'] ?></td>
                    <td>卖家姓名</td>
                    <td><?= $supplierData['principal'] ?></td>
                </tr>
                <tr>
                    <td>卖家手机</td>
                    <td><?= $supplierData['principal_phone'] ?></td>
                    <td>卖家店铺名称</td>
                    <td><?= $supplierData['name'] ?></td>

                </tr>
                <tr>
                    <td>采购单金额</td>
                    <td><?= $purchaseData['total'] ?></td>

                    <?php if ($refundData['status'] == 20): ?>
                        <td>付款单号:</td>
                        <td><?= $agentPayNum ?></td>
                    <?php else: ?>
                        <td>采购单状态</td>
                        <td><?= Yii::$app->params['shop']['shop_purchase'][$purchaseData['status']] ?></td>

                    <?php endif ?>
                </tr>

                <tr>
                    <?php if ($agentReceive): ?>
                        <td>应收金额:</td>
                        <td><?php echo $refundData['point_total'] . '积分' . $refundData['refund_money'] . '元' ?></td>

                        <td>收款单号:</td>
                        <td><?= $agentReceive ?></td>
                    <?php endif ?>


                </tr>


                <?php if ($newPurchaseNum): ?>
                    <tr>
                        <td>采购单号:</td>
                        <td><?= $newPurchaseNum ?></td>
                        <td></td>
                        <td></td>

                    </tr>
                <?php endif ?>


            </table>

            <!-- /.box - body-->
        </div>
        <!-- /.box-->
    </div>
</div>


<div class="row" style="padding-top: 0;margin-top: 10px;position: fixed;left:620px;
        bottom:0;">
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;


    <!--    <button class="btn  btn-info check_house btn_submit" > 提交</button > -->
    <!--    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;-->


    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <button class="btn  btn-info  comment" onclick="goback()"> 返回</button>
</div>
<script>

    function goback() {
        window.location.href = '<?php echo $url ?>';
    }

    $('#userLog').mouseover(function () {

        $('.userLog').modal()

    })

    $('#AdminLog').mouseover(function () {

        $('.AdminLog').modal()

    })


</script>

<!--日志模态框-->


<div class="modal fade userLog" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="gridSystemModalLabel">用户操作日志</h4>
            </div>
            <div class="modal-body">

                <table id="example2" class="table table-bordered table-hover">
                    <tr>
                        <td>时间:</td>
                        <td>原因</td>
                        <td>详情</td>
                    </tr>
                    <?php if ($refundLogs):
                        foreach ($refundLogs as $k => $v):
                            ?>
                            <tr>
                                <td><?= date("Y-m-d H:i:s", $v['create_time']) ?></td>
                                <td><?= $v['reason'] ?></td>
                                <td><?= $v['detail'] ?></td>
                            </tr>

                            <?php

                        endforeach;
                    endif ?>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--日志模态框-->


<div class="modal fade AdminLog" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="gridSystemModalLabel">供应商操作日志</h4>
            </div>
            <div class="modal-body">

                <table id="example2" class="table table-bordered table-hover">
                    <tr>
                        <td>时间:</td>
                        <td>原因</td>
                        <td>详情</td>
                    </tr>
                    <?php if ($AdminRefundLogs):
                        foreach ($AdminRefundLogs as $k => $v):
                            ?>
                            <tr>
                                <td><?= date("Y-m-d H:i:s", $v['create_time']) ?></td>
                                <td><?= $v['reason'] ?></td>
                                <td><?= $v['detail'] ?></td>
                            </tr>

                            <?php

                        endforeach;
                    endif ?>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--日志模态框-->