<?php
use yii\helpers\Url;

$this->title = '采购单详情';


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
                    <td>采购单号：</td>
                    <td><?= $purchaseData['purchase_num'] ?></td>
                    <td>采购单状态：</td>
                    <td><?= Yii::$app->params['shop']['shop_purchase'][$purchaseData['status']] ?></td>
                    <td>采购单创建时间：</td>
                    <td><?= date('Y-m-d H:i:s', $purchaseData['create_time']) ?></td>
                    <td>商家账号：</td>
                    <td><?= $adminUserName ?></td>
                </tr>
                <tr>
                    <td>订单号：</td>
                    <td><?= $orderData['order_num'] ?></td>
                    <td>采购金额：</td>
                    <td><?= $purchaseData['total'] ?></td>
                    <td>采购人：</td>
                    <td><?= $customer ?></td>
                    <td>商家手机：</td>
                    <td><?= $adminInfo['principal_phone'] ?>
                    </td>

                </tr>
                <tr>
                    <td>付款单号：</td>
                    <td><?= $payNum ?></td>
                    <td>店铺名称：</td>
                    <td><?= $adminInfo['name'] ?></td>
                    <td></td>
                    <td></td>
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
                <h3 class="box-title">商品信息</h3>

            </div>
            <table id="example2" class="table table-bordered table-hover">

                <tr>
                    <td>商品编号：</td>
                    <td>商品名称：</td>
                    <td>商品价格：</td>
                    <td>商品成本价:</td>
                    <td>商品规格:</td>


                </tr>
                <?php
                if ($purchaseDetails):
                    foreach ($purchaseDetails as $k => $v):
                        ?>
                        <tr>

                            <td><?= $v['goods_num'] ?></td>

                            <td><?= $v['title'] ?></td>

                            <td><?= $v['price'] + $v['point'] / 10 ?></td>

                            <td><?= $v['cost_price'] ?></td>
                            <td>
                                <?php
                                $str = '';
                                if ($v['spec_name']):
                                    foreach (json_decode($v['spec_name']) as $kk => $vv):

                                        $str .= $vv->parent_label . ':' . $vv->label . ','
                                        ?>

                                        <?php
                                    endforeach;
                                    $str = rtrim($str, ',');

                                    echo $str;
                                endif;
                                ?>

                            </td>

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

<div class="row">
    <div class="col-xs-12">
        <div class="box">

            <div class="box-header">
                <h3 class="box-title">财务信息</h3>

            </div>
            <table id="example2" class="table table-bordered table-hover">


                <tr>
                    <td>商品名称</td>
                    <td>商品数量</td>
                    <td>商品净价</td>
                    <td>运费</td>

                </tr>
                <?php
                if ($purchaseDetails):
                    $total = 0;
                    foreach ($purchaseDetails as $k => $v):


                        $total += $v['cost_price'] * $v['num'];
                        ?>


                        <tr>
                            <td><?= $v['title'] ?></td>
                            <td><?= $v['num'] ?></td>
                            <td><?= $v['cost_price'] ?></td>
                            <td></td>

                        </tr>
                        <?php
                    endforeach;
                endif ?>

                <tr>
                    <td></td>
                    <td>总计</td>
                    <td><?= $total ?></td>
                    <td><?= $purchaseData['freight'] ?></td>

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
                <h3 class="box-title">物流信息</h3>

            </div>


            <!-- /.box-header -->


            <table id="example2" class="table">


                <tr>
                    <td>收货人</td>
                    <td><?= $addressData['name'] ?></td>
                    <td></td>
                    <td></td>
                    <td>发货时间</td>
                    <td><?= $logistics['created_at'] ?></td>

                </tr>
                <tr>
                    <td>手机号</td>
                    <td><?= $addressData['mobile'] ?></td>
                    <td>物流公司：</td>
                    <td><?= $logistics['name'] ?></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>收货地址：</td>
                    <td><?= \backend\service\CommonService::getCityName($addressData['province']) . '&nbsp;&nbsp;' . \backend\service\CommonService::getCityName($addressData['city']) . '&nbsp;&nbsp;' . \backend\service\CommonService::getCityName($addressData['area']) . '&nbsp;&nbsp;' . $addressData['address'] ?></td>
                    <td>物流单号：</td>
                    <td><?= $logistics['number'] ?></td>
                    <td></td>
                    <td></td>
                </tr>


            </table>

            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>


<div class="row" style="padding-top: 0;margin-top: 10px;position: fixed;left:620px;
        bottom:0;">
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <button class="btn  btn-info  comment" onclick="goback()">返回</button>
</div>
<script>
    function goback() {
        window.location.href = '<?php echo $url ?>';
    }
</script>