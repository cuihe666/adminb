<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\bootstrap\ActiveForm;
use common\tools\Helper;
use backend\controllers\CouponController;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CouponQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '优惠券列表';
$this->params['breadcrumbs'][] = $this->title;

$status_list = Yii::$app->params['coupon_status'];
$type_list = Yii::$app->params['coupon_tname_type'];

$gridColumns = [
    'id',
    'redeem_code',
    [
        'label' => '领取时间',
        'value' => function($model){
            if(empty($model->uid)){
                return '--';
            }else{
                return substr($model->receive->created_at,0,16);
            }
        }
    ],
    [
        'label' => '用户账号',
        'value' => function($model){
            if(is_null($model->users)){
                return '--';
            }else{
                return $model->users->mobile;
            }
        }
    ],
    [
        'label' => '使用情况',
        'value' => function($model) use($status_list){
             return $status_list[$model->status];
        }
    ],
    [
        'label' => '订单编号',
        'value' => function($model){
            if(is_null($model->used) || $model->status != 3){
                return '--';
            }else{

                switch ($model->used->type){
                    case "0":
                        $order = \backend\models\OrderDetailStatic::find()->where(['id' => $model->used->order_id])->select(['id','order_num'])->one();

                        break;
                    case "1":
                        $order = \backend\models\TravelOrder::find()->where(['id' => $model->used->order_id])->select(['id','order_no as order_num'])->one();
                        break;
                    case "2":
                        $order = \backend\models\TravelOrder::find()->where(['id' => $model->used->order_id])->select(['id','order_no as order_num'])->one();
                        break;
                    case "3":
                        $order = \backend\models\HotelOrder::find()->where(['id' => $model->used->order_id])->select(['id','order_num'])->one();
                        break;
                    case "4":
                        $order = \backend\models\TravelOrder::find()->where(['id' => $model->used->order_id])->select(['id','order_no as order_num'])->one();
                        break;
                    default:
                        $order = null;
                }
                $order_num = is_null($order) ?  "找不到对应订单编号" : $order->order_num;

//                return $model->used->order_id;
                return $order_num;
            }
        }
    ],
    [
        'label' => '订单类型',
        'value' => function($model) use($type_list){
            if(is_null($model->used) || $model->status != 3){
                return '--';
            }else{
                return $type_list[$model->used->type].'订单';
            }
        }
    ],
];

$output_columns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'label' => '优惠券名称',
        'value' => function($model){
            return $model->title;
        }
    ],
    [
        'label' => '批次码',
        'value' => function($model){
            return $model->batch_code . ':' . $model->id;
        }
    ],
    [
        'label' => '激活码',
        'value' => function($model){
            return $model->redeem_code;
        }
    ],
    [
        'label' => '有效时间',
        'value' => function($model) use($batchModel){
            if(empty($batchModel->start_time)) return '永久有效';
            return $batchModel->start_time . ' 至 ' . $batchModel->end_time;
        }
    ],
    [
        'label' => '是否被领用',
        'value' => function($model) use ($status_list){
            return $status_list[$model->status];
        }
    ],
];

?>
<div class="coupon-index">

    <div class="row">
        <?= Html::beginForm(['list?id='.$id], 'get', ['class' => 'form-horizontal', 'id' => 'searchForm']) ?>
        <div class="col-sm-2">
            <?= Html::activeInput('text', $searchModel, 'redeem_code', ['class' => 'form-control input', 'placeholder' => '激活码']) ?>
        </div>
        <div class="col-sm-2">
            <?= Html::activeInput('text', $searchModel, 'mobile', ['class' => 'form-control input', 'placeholder' => ' 手机号']) ?>
        </div>
        <div class="col-sm-2">
            <?= Html::activeInput('text', $searchModel, 'order_id', ['class' => 'form-control input', 'placeholder' => ' 订单ID']) ?>
        </div>

        <div class="col-sm-2">
            <?= Html::activeDropDownList($searchModel, 'status',['3' => '已使用' , '2' => '占用中'],  ['class' => 'form-control', 'prompt' => '全部状态']) ?>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('重置', ['list?id='.$id]  , ['class' => 'btn btn-default']) ?>
                <?= Html::a('返回', ['index']  , ['class' => 'btn btn-default']) ?>
            </div>
        </div>

        <?= Html::endForm() ?>

    </div>

    <?php if(Helper::checkPermission(CouponController::$admin_role)): ?>
    <div class="row">
        <div class="col-sm-2">
            <?= ExportMenu::widget([
                'dataProvider' => $outputProvider,
                'columns' => $output_columns,
                'filename' => '优惠券:' . $batchModel->title . '_' . substr($batchModel->create_time,2,8)
            ]);
            ?>
        </div>
    </div>
    <?php endif ?>
    <div class="row" style="margin: 10px 0;">
        <div class="col-sm-2">
            已领取: <?= $count['bind'] ?>
        </div>
        <div class="col-sm-2">
            已使用: <?= $count['used'] ?>
        </div>
        <div class="col-sm-2">
            剩余数量: <?= $count['last'] ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => $gridColumns,
            ]); ?>
        </div>
    </div>



</div>