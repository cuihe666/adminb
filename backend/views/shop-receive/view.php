<?php
use yii\helpers\Url;

$this->title = '收款单详情';

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


            <table id="example2" class="table table-bordered table-hover">
                <tr>
                    <td>收款单号：</td>
                    <td><?= $receiveData['receive_num'] ?></td>
                    <td>收款单类型：</td>
                    <td><?= Yii::$app->params['shop']['shop_receive'][$receiveData['type']] ?></td>
                    <td>收款单状态：</td>
                    <td><?= Yii::$app->params['shop']['receive_status'][$receiveData['status']] ?></td>
                </tr>
                <tr>
                    <td>订单编号：</td>
                    <td><?= $orderData['order_num'] ?></td>
                    <td>支付方式：</td>
                    <td><?= Yii::$app->params['shop']['pay_type'][$receiveData['pay_type']] ?></td>
                    <td>收款金额：</td>
                    <td><?= $receiveData['true_receive'] ?></td>
                </tr>
                <tr>
                    <td>第三方单号：</td>
                    <td><?= $receiveData['transaction_id'] ?></td>
                    <td>创建时间：</td>
                    <td><?= date('Y-m-d H:i:s', $receiveData['create_time']) ?></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>变更单号：</td>
                    <td><?= $refundNum ?></td>
                    <td>买家账号：</td>
                    <td><?= \backend\models\ShopReceive::getUserName($receiveData['order_id']) ?></td>
                    <td></td>
                    <td></td>
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
                <h3 class="box-title">帐目名细</h3>

            </div>


            <table id="example2" class="table table-bordered table-hover">
                <tr>
                    <td>商品编号：</td>
                    <td>商品标题</td>
                    <td>商品单价</td>
                    <td>数量</td>
                    <td>运费：</td>

                </tr>

                <?php
                $total = 0;

                if ($orderDetail): foreach ($orderDetail as $k => $v):


                    ?>

                    <tr>
                        <td><?= $v['goods_num'] ?></td>
                        <td><?= $v['title'] ?></td>
                        <td><?php
                            if ($receiveData['type'] == 2) {
                                echo $v['cost_price'];

                                $total += $total;

                            } else {

                                switch ($v['pay_type']) {
                                    case 1:
                                        echo $money = $v['point'] / 10;
                                        $total += $money;
                                        break;


                                    case 2:
                                        echo $v['price'];
                                        $total += $v['price'];
                                        break;

                                }


                            }


                            ?></td>
                        <td><?= $v['num'] ?></td>
                        <td></td>

                    </tr>
                    <?php
                endforeach;
                endif ?>


            </table>


            <table id="example2" class="table table-bordered table-hover">
                <tr>
                    <td>应收金额：</td>
                    <td>实收金额</td>
                    <td>待收金额：</td>

                </tr>
                <tr>
                    <td><?= $receiveData['receivable'] ?></td>
                    <td>
                        <?php

                        if ($receiveData['status'] == 2):
                            echo $receiveData['true_receive'];
                        else:
                            echo 0;
                        endif;
                        ?>
                    </td>
                    <td>
                        <?php

                        if ($receiveData['status'] == 1):
                            echo $receiveData['true_receive'];
                        else:
                            echo 0;
                        endif;
                        ?>

                    </td>

                </tr>


            </table>


            <?php if ($receiveData['type'] == 2): ?>

                <table id="example2" class="table table-bordered table-hover">
                    <tr>
                        <td>代理商帐号：</td>
                        <td><?= $adminUser ?></td>

                        <td>代理商联系电话:</td>
                        <td><?= $adminPhone ?></td>


                    </tr>


                </table>
            <?php endif ?>

            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>


<div class="row" style="padding-top: 0;margin-top: 10px;position: fixed;left:620px;
        bottom:0;">
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <?php if ($receiveData['type'] == 2 && $receiveData['status'] == 1): ?>
        <button class="btn  btn-info btn_submit">确认收款</button>
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

    <?php endif ?>


    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <button class="btn  btn-info  comment" onclick="goback()">返回</button>
</div>


<script>
    $('.btn_submit').click(function () {
        var id = <?php echo $receiveData['id'] ?>;

        $.post("<?=Url::to(["check"])?>", {
            "PHPSESSID": "<?php echo session_id();?>",
            "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
            data: {id: id},
        }, function (data) {
            if (data == 1) {
                layer.alert('操作成功');


                window.location.href = '<?php echo $url ?>';

            }


        });

    })
    function goback() {
        window.location.href = '<?php echo $url ?>';
    }


</script>