<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Banner管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">


                <div class="ibox">

                    <a href="<?php echo \yii\helpers\Url::to(['shop-banner/create']) ?>"
                       class="btn btn-primary ">新增</a>
                    <div class="ibox-content" style="margin-bottom: 20px;">

                        <?php
                        use kartik\export\ExportMenu;

                        $gridColumns = [['class' => 'yii\grid\SerialColumn',
                            'header' => '序号'],
                            'title',
                            [
                                // 看这里
                                'attribute' => 'banner图',
                                'format' => 'html',
                                'value' => function ($model, $key, $index, $column) {
                                    return ' <a href="' . Url::to(['shop-goods/view', 'id' => $model->goods_id]) . '" >   <img   width ="84" height ="84"  src="' . $model->img_url . '"></a>';
                                }
                            ],
                            ['header' => '所在位置',
                                'value' => function ($model) {
                                    $position = [
                                        0 => '分类页',
                                        1 => '首页'
                                    ];
                                    if (array_key_exists($model->is_home, $position)) {
                                        return $position[$model->is_home];

                                    }

                                    return '空';


                                }],

                            ['header' => '是否显示',
                                'value' => function ($model) {
                                    $shows = [
                                        0 => '否',
                                        1 => '是'

                                    ];
                                    if (array_key_exists($model->is_show, $shows)) {
                                        return $shows[$model->type];

                                    }

                                    return '空';


                                }],

                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div class="dropdown profile-element group-btn-edit">
                                     {update}{delete}
                                </div> ',
                                'buttons' => [

                                    'update' => function ($url, $model, $key) {
                                        return Html::a('修改', "$url") . '&nbsp;&nbsp;&nbsp;&nbsp;';
                                    },

                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('删除', "javascript:del($key);");

                                    },


                                ],],];

                        echo GridView::widget(['dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'pager' => ['firstPageLabel' => '首页',
                                'lastPageLabel' => '尾页',],]);
                        ?>

                    </div>
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
        function del(id) {
            layer.confirm('确认要执行此操作吗？', {icon: 3, title: '友情提示'}, function (index) {
                $.ajax({
                    type: 'post',
                    url: "<?php echo \yii\helpers\Url::to(['shop-banner/delete']) ?>",
                    data: {id: id},
                    success: function (data) {
                        if (data == 1) {
                            layer.alert('操作成功', {icon: 3});
                            location.reload();
                        }
                    }
                })
//            layer.close(index);
            });
        }
    </script>


