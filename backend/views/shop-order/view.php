<?php

/* @var $this yii\web\View */
/* @var $model backend\models\ShopGoods */

$this->title = '订单详情';
\backend\assets\VueAsset::register($this);

?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>


<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">基本信息</h3>

            </div>

            <table id="example2" class="table table-bordered table-hover">
                <tr>
                    <td>订单号</td>
                    <td><?= $orderData['order_num'] ?></td>
                    <td>订单金额</td>
                    <td><?= $orderData['price_total'] ?>元 <?= $orderData['point_total'] ?>积分</td>
                    <td>买家账号</td>
                    <td><?= $account ?></td>


                </tr>
                <tr>

                    <td>订单状态</td>
                    <td><?php
                        if (key_exists($orderData['status'], Yii::$app->params['shop']['order_status'])) {
                            echo Yii::$app->params['shop']['order_status'][$orderData['status']];
                        }
                        ?></td>

                    <td>卖家名称</td>
                    <td><?= $supplierInfo['name'] ?></td>

                    <td>收款单号</td>
                    <td><?= implode(',', $receiveNums); ?></td>


                </tr>
                <tr>
                    <td>下单时间</td>
                    <td><?= date("Y-m-d H:i:s", $orderData['create_time']) ?></td>
                    <td>卖家帐号</td>
                    <td><?= $supplierData['admin_username'] ?></td>
                    <td>物流单号</td>
                    <td><?= $logistics['number'] ?></td>


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
                <h3 class="box-title">商品信息</h3>

            </div>

            <div class="box-footer">
                <ul class="mailbox-attachments clearfix">
                    <?php if ($orderDetail): foreach ($orderDetail as $k => $v): ?>
                        <li>

                            <img style="width: 200px;" src="<?php echo $v['title_pic'] ?>" alt="">

                            <div class="mailbox-attachment-info">
                                <p>商品名称：<?php echo $v['title'] ?></p>
                                <p>单价：<?php echo $v['price'] + $v['point'] / 10 ?></p>
                                <p>数量：<?php echo $v['num'] ?></p>
                                <?php
                                if ($v['spec_name']):
                                    foreach (json_decode($v['spec_name']) as $kk => $vv):
                                        ?>
                                        <p><?= $vv->parent_label?>:<?= $vv->label?></p>


                                        <?php

                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </li>
                        <?php
                    endforeach;
                    endif ?>


                </ul>
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
                <h3 class="box-title">核算单</h3>

            </div>

            <div class="box-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>商品名称</th>
                        <th>商品编号</th>
                        <th>商品数量（件）</th>
                        <th>价格（元）</th>
                        <th>积分</th>

                    </tr>
                    </thead>
                    <tbody>

                    <?php if ($orderDetail): foreach ($orderDetail as $k => $v): ?>
                        <tr>
                            <td><?= $v['title'] ?></td>
                            <td><?= $v['goods_num'] ?></td>
                            <td><?= $v['num'] ?></td>
                            <td><?= $v['price'] ?></td>
                            <td><?= $v['point'] ?></td>

                        </tr>
                        <?php
                    endforeach;
                    endif ?>

                </table>

                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">收货信息</h3>

            </div>

            <div class="box-body">
                <table id="example1" class="table table-bordered table-hover">


                    <tr>
                        <td>收货人姓名</td>
                        <td><?= $addressInfo['name'] ?></td>
                        <td>地址</td>
                        <td><?= \backend\service\CommonService::getCityName($addressInfo['province']) . '&nbsp;&nbsp;' . \backend\service\CommonService::getCityName($addressInfo['city']) . '&nbsp;&nbsp;' . \backend\service\CommonService::getCityName($addressInfo['area']) . '&nbsp;&nbsp;' . $addressInfo['address'] ?></td>
                    </tr>

                    <tr>
                        <td>手机号</td>
                        <td><?= $addressInfo['mobile'] ?></td>
                        <td>物流公司</td>
                        <td><?= $logistics['name'] ?></td>
                    </tr>


                </table>

                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
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
                if ($orderData['status'] == 0) {
                    echo 0;
                }

                if ($orderData['status'] == 5) {
                    echo 1;
                }
                if ($orderData['status'] == 10) {
                    echo 2;
                }

                if ($orderData['status'] == 20) {
                    echo 3;
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

<div class="row" style="padding - top: 0;margin - top: 10px;position: fixed;left:580px;
        bottom:0;">
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp

    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <button class="btn  btn-primary  comment" onclick="goback()">返回</button>
</div>


<script>
    var vue = new Vue({
        el: '#status',
        data: {
            active: 3,
        }
    });

    function goback() {
        window.location.href = '<?php echo $url ?>';
    }
</script>





