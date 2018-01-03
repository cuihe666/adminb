<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HotelSettleDetailQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '结算单详情';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/common/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl?>/layer/layer.js"></script>
<div class="hotel-settle-detail-index">

    <p>
        <?= Html::a('返回', 'javascript:history.go(-1);', ['class' => 'btn btn-success']) ?>
        <span style="padding-left: 50px;">结算周期：<?= date('Y-m-d', strtotime($date_settle['start_time']))?>至<?= date('Y-m-d', strtotime($date_settle['end_time']))?></span>
        <span style="padding-left: 150px;">账单总计：<?= $date_settle['total']?></span>
    </p>
    <div class="row">
        <?= Html::beginForm([\yii\helpers\Url::to(['hotel-settle-detail/index'])], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
        <div class="col-sm-12">
            <div class="search-item">
                <div class="search-item">
                    <input type="hidden" name="settle_id" value="<?= isset($settle_id)?$settle_id:''?>" id="settle_id">
                    <div class="search-item" style="display:inline-block;">
                        <div class="input-group">
                            <?= Html::activeInput('text', $searchModel, 'order_num', ['class' => 'form-control input', 'placeholder' => '请输入订单号']) ?>
                        </div>
                    </div>
                    <div class="search-item" style="display:inline-block;margin-left:20px;margin-top:3px;">
                        <div class="input-group" style="width:140px;">
                            <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= Html::endForm() ?>
    </div>
    <?php if ($date_settle['status'] != 1) :?>
        <p>
            <?= Html::a('结算', '#', ['class' => 'btn btn-primary', 'id' => 'settle_handle']) ?>
        </p>
    <?php endif;?>
    <style>
        /*.sxh-table{*/
            /*background-color:#f3f3f3;*/
            /*width:120px;*/
            /*text-align: center;*/
        /*}*/
        /*.sxh-table_line{*/
            /*width:150px;*/
            /*text-align: center;*/
        /*}*/
        .table-bordered>tbody>tr>td{
            border-color:#ccc;
        }
        table td{
            text-align: center;
        }
        table .sxh-table{
            background-color:#f3f3f3;
        }
    </style>
    <?php if ($date_settle['status'] == 1) :?>
        <div>
            <table class="table table-bordered" style="width:800px;border-color:#000">
                <caption>收款信息</caption>
                <tbody>
                <tr>
                    <td class="sxh-table">收款账户</td>
                    <td><?= isset($settle_info['account_number'])?$settle_info['account_number']:''?></td>
                    <td class="sxh-table">开户行</td>
                    <td><?= isset($settle_info['bank_detail'])?$settle_info['bank_detail']:''?></td>
                </tr>
                <tr>
                    <td class="sxh-table">户名</td>
                    <td><?= isset($settle_info['account_name'])?$settle_info['account_name']:''?></td>
                    <td class="sxh-table">联系人手机号</td>
                    <td><?= isset($settle_info['mobile'])?$settle_info['mobile']:''?></td>
                </tr>
                </tbody>
            </table>
        </div>
    <?php else :?>
        <p>
            <b>此账单未打款！</b>
        </p>
    <?php endif;?>
    <?php $gridColumns = [
        ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
        [
            'label' => '订单ID',
            'value' => function($model){
                return $model->order_num;
            }
        ],
        [
            'label' => '预定日期',
            'value' => function($model){
                return isset($model->order->create_time)?date('Y-m-d', strtotime($model->order->create_time)):'';
            }
        ],
        [
            'label' => '入住日期',
            'value' => function($model){
                return isset($model->order->in_time)?date('Y-m-d', strtotime($model->order->in_time)):'';
            }
        ],
        [
            'label' => '离店日期',
            'value' => function($model){
                return isset($model->order->out_time)?date('Y-m-d', strtotime($model->order->out_time)):'';
            }
        ],
        [
            'label' => '入住人',
            'value' => function($model){
                return \backend\controllers\HotelSettleDetailController::GuestsStr($model->order_id);
            }
        ],
        [
            'label' => '售出房型',
            'value' => function($model){
                return $model->order->hotel_house_name;
            }
        ],
        [
            'label' => '来源酒店',
            'value' => function($model){
                return $model->order->hotel_name;
            }
        ],
        [
            'label' => '间数',
            'value' => function($model){
                return $model->order->house_num;
            }
        ],
        [
            'label' => '晚数',
            'value' => function($model){
                return $model->order->day_num;
            }
        ],
        [
            'label' => '底价',
            'value' => function($model){
                return \backend\controllers\HotelSettleDetailController::SalePrice($model->order_id, $model->order->house_num);
            }
        ],
    ]; ?>
    <?php
    echo \kartik\export\ExportMenu::widget([
        'dataProvider' => $dataProvider
        , 'columns' => $gridColumns
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'pager' => [
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
        ],
    ]);
    ?>
</div>
<script>
    $("#settle_handle").click(function () {
        var settle_id = $("#settle_id").val();
        layer.confirm("您确定要结算吗？",{
            btn:['确定', '取消']
        }, function () {
            $.post("<?= \yii\helpers\Url::to(['hotel-settle-detail/settle-handle'])?>", {
                "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
                data: {settle_id:settle_id}
            }, function (data) {
                location.reload();
            });
        });

    });
</script>
