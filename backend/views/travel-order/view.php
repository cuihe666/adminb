<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

$this->title = '旅游订单详情';

?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<style>
    .table-bordered td{
        text-align: center;
    }
    .table-bordered th{
        text-align: center;
    }
    .save{
        width: 1400px;
    }
</style>
<div class="row save" style="margin-top: 20px;">
    <div class="col-xs-12">
            &nbsp;<input type="button" value="返回" style="margin-left: 10px; margin-top: -10px; margin-bottom: 10px;" id="go_back" class="btn btn-sm btn-primary">
        <script>
            $(function () {
                $("#go_back").click(function () {
                    window.history.back();
                });
            })
        </script>
            <!--            <small class="pull-right">Date: 2/10/2014</small>-->
        <h2 class="page-header">
            <i class="fa fa-globe"></i>&nbsp;订单详情
            <!--            <small class="pull-right">Date: 2/10/2014</small>-->
        </h2>
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th width="319px;">支付方式</th>
                    <td width="330px;"><?php echo Yii::$app->params['pay_type'][$model['pay_platform']] ?></td>
                    <th width="330px;">支付状态</th>
                    <td><?php if (empty($model['trade_no'])) {echo '未支付';} else {echo '已支付';}?></td>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>售价</th>
                        <td>￥<?php echo $model['total'];?></td>
                        <th>优惠券抵扣</th>
                        <td>￥<?php echo $model['coupon_amount']; ?></td>
                    </tr>
                    <tr>
                        <th>实付金额</th>
                        <td>￥<?php echo $model['pay_amount'];?></td>
                        <th>订单类型</th>
                        <td><?php echo Yii::$app->params['is_confirm'][$model['is_confirm']]; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>
<div class="row save" style="margin-top: 20px;">
    <div class="col-xs-12">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th width="319px;">棠果收入</th>
                    <td width="330px;">￥<?= $model['tangguo_income']?></td>
                    <th width="330px;">达人收入</th>
                    <td>￥<?= $model['daren_income']?></td>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>
<div class="row save" style="margin-top: 20px;">
    <div class="col-xs-12">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th width="319px;">联系人姓名</th>
                    <td width="330px;"><?php echo $model['contacts'] ?></td>
                    <th width="330px;">联系人手机</th>
                    <td><?php echo $model['mobile_phone']?></td>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($team_info)) {?>
                    <?php foreach ($team_info as $k => $val) {?>
                        <tr>
                            <th>出行人姓名<?= $k + 1;?></th>
                            <td><?php echo $val['name'];?></td>
                            <th>证件号<?= $k + 1;?></th>
                            <td><?php echo $val['idcard'];?></td>
                        </tr>
                    <?php }?>
                <?php }?>
                <tr>
                    <th width="319px;">体验日期</th>
                    <td width="330px;"><?= $model['activity_date']?></td>
                    <th width="330px;"></th>
                    <td ></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>
<div class="row save" style="margin-top: 20px;">
    <div class="col-xs-12">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th width="319px;">商品ID</th>
                    <td width="330px;"><?= $model['id']?></td>
                    <th width="330px;">商品名称</th>
                    <td ><?= $model['travel_name']?></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>商品品类</th>
                    <td><?php echo Yii::$app->params['type'][$model['type']];?></td>
                    <th>商品城市</th>
                    <td><?= \backend\controllers\TravelOrderController::actionWare_city($model['id'], $model['type'])?></td>
                </tr>
                <tr>
                    <th>达人姓名</th>
                    <td><?= $user_data['nickname']?></td>
                    <th>达人手机</th>
                    <td><?= $user_data['mobile']?></td>
                </tr>
                <tr>
                    <th>主题</th>
                    <td><?= \backend\controllers\TravelOrderController::actionTheme_type($model['id'], $model['type'])?></td>
                    <th></th>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>
<div class="row save" style="margin-top: 20px;">
    <div class="col-xs-12">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th width="319px;">订单状态</th>
                    <td width="330px;"><?php if ($model->refund_stauts == 0) {echo Yii::$app->params['status_order'][$model->state];} else {echo Yii::$app->params['stauts_refund'][$model->refund_stauts];}?></td>
                    <th width="330px;">预订时间</th>
                    <td ><?= $model['create_time']?></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>订单号</th>
                    <td><?= $model['order_no'];?></td>
                    <th></th>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>
<!------------------------付燕飞 2017年3月27日17:36:18增加，如果此订单有二维码id的话，就显示一下信息---------------------->
<?php
/*if(intval($model->qrcode_id)!=0){
*/?>
<!--<div class="row save" style="margin-top: 20px;">-->
    <!--<div class="col-xs-12">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th width="319px;">来源活动</th>
                    <td width="330px;"><?/*= \backend\models\Qrcode::getActiveTheme()[$model->theme_type]; */?></td>
                    <th width="330px;">来源城市【二维码】</th>
                    <td ><?/*= \backend\models\Qrcode::getCity()[$qrcode_info['city_code']]; */?></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>是否首单</th>
                    <td><?/*= Yii::$app->params['is_status'][$model->is_first]*/?></td>
                    <th>优惠金额</th>
                    <td><?/*= $model->is_first == 1 ? "20.00" : "0.00";*/?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>-->
    <!-- /.col -->
<!--</div>-->
<?php /*}*/?>
<!------------------------付燕飞 2017年3月27日17:36:18增加   结束---------------------->

<div class="row save" style="margin-top: 20px;">
    <div class="col-xs-12">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <div class="search-item">
                    <div class="input-group" style="width: 200px;margin-right: 5px;">
                        <?php
                        if ($model['refund_stauts'] == 0) {//交易流程
                            switch ($model['state'])
                            {
                                case 11://待支付
                                    echo "-";
                                    break;
                                case 21://已支付
                                    echo "<input type='button' name='". $model['state'] ."' class='btn btn-sm btn-primary operation_status' id='". $model['id'] ."-y' value='确认'>";
                                    echo "<input style='margin-left: 10px;' type='button' name='". $model['state'] ."' class='btn btn-sm btn-primary operation_status' id='". $model['id'] ."-n' value='取消'>";
                                    break;
                                case 31://待支付
                                    echo "<input type='button' name='". $model['state'] ."' class='btn btn-sm btn-primary operation_status' id='". $model['id'] ."-y' value='确认'>";
                                    echo "<input style='margin-left: 10px;' type='button' name='". $model['state'] ."' class='btn btn-sm btn-primary operation_status' id='". $model['id'] ."-n' value='取消'>";
                                    break;
                                default:
                                    break;
                            }
                        } else {//退款流程
                            switch ($model['refund_stauts'])
                            {
                                case 51://待退款
                                    echo "<input type='button' name='". $model['refund_stauts'] ."' class='btn btn-sm btn-primary operation_status' id='". $model['id'] ."-y' value='确认退款'>";
                                    echo "<input style='margin-left: 10px;' type='button' name='". $model['refund_stauts'] ."' class='btn btn-sm btn-primary operation_status' id='". $model['id'] ."-n' value='退款驳回'>";
                                    break;
                                default:
                                    break;
                            }
                        }
                        ?>
                    </div>

                    <script>
                        $(function () {
                            $(".operation_status").click(function () {
                                var id = $(this).attr("id");//订单ID + 选择
                                var name = $(this).attr("name");//当前状态
                                console.log(id);
                                console.log(name);
                                $.post("<?= Url::to(['travel-order/operation'])?>", {
                                    "PHPSESSID": "<?php echo session_id();?>",
                                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                                    data: {"id":id, "status":name}
                                }, function (data) {
                                    if (data == 'success') {
                                        window.location.reload();
                                    } else {
                                        layer.alert('修改失败');
                                    }
                                });
                            });
                        })
                    </script>
                </div>
            </table>
        </div>
    </div>
    <!-- /.col -->
</div>






