<?php
use yii\helpers\Url;
$this->title = '付款单详情';
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
                    <td>付款单号：</td>
                    <td><?= $payData['pay_num'] ?></td>
                    <td>付款单类型：</td>
                    <td><?php
                        $arr = [1 => '支付供应商', 2 => '客户退款', 3 => '积分兑换', 4 => '积分返还'];

                        if (array_key_exists($payData['type'], $arr)) {

                            echo $arr[$payData['type']];

                        }

                        ?></td>
                    <td>付款单状态：</td>
                    <td>
                        <?php

                        $arr = [0 => '待确认', 1 => '待付款', 2 => '已付款', 3 => '已取消'];

                        if (array_key_exists($payData['status'], $arr)) {

                            echo $arr[$payData['status']];

                        }
                        ?>

                    </td>
                </tr>
                <tr>
                    <td>采购编号：</td>
                    <td><?= $purchaseNum ?></td>
                    <td>支付方式：</td>
                    <td>
                        <?php

                        $arr = [1 => '支付宝', 2 => '微信', 3 => '积分'];

                        if (array_key_exists($payData['pay_type'], $arr)&& $payData['type']!=1) {

                            echo $arr[$payData['pay_type']];

                        }
                        if($payData['type']==1)
                        {
                            echo '银行转帐';
                        }

                        ?>

                    </td>
                    <td>付款金额：</td>
                    <td><?php echo $payData['payable'] ?></td>
                </tr>
                <tr>
                    <td>第三方单号：</td>
                    <td><?= $payData['transaction_id'] ?></td>
                    <td>创建时间：</td>
                    <td><?php echo date('Y-m-d H:i:s', $payData['create_time']) ?></td>
                    <td>付款人 ：</td>
                    <td>
                        <?php if ($payData['type'] != 1): ?>
                            平台
                        <?php endif ?>
                        <?php if ($payData['type'] == 1):
                            echo $payData['pay_uname']
                            ?>
                        <?php endif ?>

                    </td>
                </tr>
                <tr>
                    <td>变更单号：</td>
                    <td><?= $refundData['refund_num'] ?></td>
                    <td>买家账号：</td>
                    <td><?= $account ?></td>
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
                <h3 class="box-title">帐目明细</h3>

            </div>


            <!-- /.box-header -->


            <table id="example2" class="table table-bordered table-hover">
                <tr>
                    <td>商品编号：</td>
                    <td>商品标题:</td>
                    <td>商品单价:</td>
                    <td>商品数量:</td>
                    <td>运费：</td>

                </tr>

                <?php

                if ($orderDetail): foreach ($orderDetail as $k => $v):


                    ?>

                    <tr>
                        <td><?= $v['goods_num'] ?></td>
                        <td><?= $v['title'] ?></td>
                        <td><?php
                            if ($payData['type'] == 3 or $payData['type'] == 2 or $payData['type'] == 4) {
                                echo $v['point'] / 10 + $v['price'];
                            }
                            if ($payData['type'] == 1) {
                                echo $v['cost_price'];
                            }
                            ?></td>
                        <td><?= $v['num'] ?></td>
                        <td></td>

                    </tr>
                    <?php
                endforeach;
                endif ?>
                <tr>
                    <td></td>
                    <td>总计：</td>
                    <td><?= $payData['payable']; ?></td>
                    <td></td>
                    <td><?= $orderData['freight'] ?></td>

                </tr>


            </table>


            <table id="example2" class="table table-bordered table-hover">
                <tr>
                    <td>应付金额：</td>
                    <td>实付金额</td>
                    <td>待付金额：</td>

                </tr>
                <tr>
                    <td><?php

                        if (in_array($payData['status'], [0, 1, 2])) {
                            echo $payData['payable'];
                        } else {
                            echo 0;
                        }


                        ?></td>
                    <td><?php
                        if ($payData['status'] == 2) {
                            echo $payData['true_pay'];
                        } else {
                            echo 0;
                        }

                        ?></td>
                    <td>

                        <?php

                        if (in_array($payData['status'], [0, 1])) {
                            echo $payData['wait_pay'];
                        } else {
                            echo 0;
                        }


                        ?>

                    </td>

                </tr>


            </table>

            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
<?php if ($payData['type'] == 1) : ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">账号信息</h3>

                </div>


                <!-- /.box-header -->


                <table id="example2" class="table">


                    <tr>
                        <td>选择账户</td>
                        <td>非备案帐号</td>
                        <td></td>
                        <td></td>

                    </tr>
                    <tr>
                        <td>开户名</td>
                        <td><?= $adminData['account_name'] ?></td>
                        <td>银行账号</td>
                        <td><?= $adminData['bank_num'] ?></td>
                    </tr>
                    <tr>
                        <td>银行名称</td>
                        <td><?= $adminData['bank_name'] ?></td>
                        <td>开户支行</td>
                        <td><?= $adminData['bank_branch_name'] ?></td>
                    </tr>


                </table>

                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
<?php endif ?>

<div class="row" style="padding-top: 0;margin-top: 10px;position: fixed;left:620px;
        bottom:0;">


    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <?php if ($payData['type'] == 1 && $payData['status'] == 1 && $orderData['status'] == 20 && $refundOk): ?>
        <button class="btn  btn-info btn_submit">确认付款</button>

        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <?php endif ?>

    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <button class="btn  btn-info  comment" onclick="goback()">返回</button>
</div>
<script>
    $('.btn_submit').click(function () {
        var id = <?php echo $payData['id'] ?>;

        $.post("<?=Url::to(["check"])?>", {
            "PHPSESSID": "<?php echo session_id();?>",
            "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
            data: {id: id},
        }, function (data) {

            if (data == -1) {
                layer.alert('请等订单完成后再执行此操作');
                window.location.reload()


            }
            if (data == 1) {
                layer.alert('操作成功');
                window.location.reload()


            }


        });

    })

    function goback() {
        window.location.href = '<?php echo $url ?>';
    }


</script>