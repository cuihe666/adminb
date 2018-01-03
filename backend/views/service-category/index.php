<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '当地服务类型管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/yulan/js/jquery-1.9.1.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>


<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <p>
                            <?= Html::a('创建类型', ['create'], ['class' => 'btn btn-success']) ?>
                        </p>
                    </div>
                </div>
                <?php
                use kartik\export\ExportMenu;

                $gridColumns = [
                    'name',
                    'desc',


                    ['class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {update}
                                    {delete}
                                 
                                </div> ',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('编辑', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                            },

                            'delete' => function ($url, $model, $key) {
//                                return Html::a('删除', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                                return Html::a('删除', "javascript:alt($key)", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
                            },

                        ],],


                ];

                // You can choose to render your own GridView separately
                // You can choose to render your own GridView separately
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'pager' => [
                        'firstPageLabel' => '首页',
                        'lastPageLabel' => '尾页',
                    ],
                ]);
                ?>

            </div>
        </div>
    </div>
</div>
<style>
    tr, th {
        text-align: center;
    }

    .pagination {
        float: right;
    }

</style>
<script>
    function alt(id) {
        layer.confirm('确认要执行此操作吗？', {icon: 3, title: '友情提示'}, function (index) {
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['service-category/delete']) ?>",
                data: {id: id},
                success: function (data) {
                    if (data == 1) {
                        layer.alert('删除成功', {icon: 1});
                        location.reload();
                    } else {
                        layer.alert('确认退款成功', {icon: 2});
                    }
                }
            })
//            layer.close(index);
        });
    }
</script>

