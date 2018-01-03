<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '专题活动列表';
$this->params['breadcrumbs'][] = $this->title;

?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<style>
    #w5-success {
        display: none;
    }

    .btn-group, .btn-group-vertical {
        margin-top: 10px;
    }

    .name_a {
        cursor: pointer
    }
</style>
<?php
if (Yii::$app->session->hasFlash('success')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('success')?>")</script>
<?php } ?>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <?php
                        use kartik\export\ExportMenu;

                        $gridColumns = [
                            'id',
                            [
                                'label' => '城市',
                                'attribute' => 'code',
                                'value' => function ($model) {
                                    return \backend\service\CommonService::get_city_name($model->code);
                                },],

                            [
                                'label' => '公司名称',
                                'value' => function ($model) {
                                    if ($model->bank['company_name']) {
                                        return $model->bank['company_name'];
                                    }
                                    return '暂未设置';

                                },],
                            'true_name',
                            [
                                'label' => '联系电话',
                                'value' => function ($model) {
                                    if ($model->bank['company_mobile']) {
                                        return $model->bank['company_mobile'];
                                    }
                                    return '暂未设置';

                                },],

                            [
                                'label' => '状态',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $arr = [1 => '已启用', 0 => '已禁用'];

                                    if ($model->status == 1) {//交易流程
                                        return $arr[$model->status];
                                    } else {//退款流程
                                        return "<fond style='color: red;'>" . $arr[$model->status] . "</fond>";
                                    }

                                },],

                            ['class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '<div class="dropdown profile-element group-btn-edit">
                                  {changestatus}  {view} 

                                </div> ',
                                'buttons' => [

                                    'changestatus' => function ($url, $model, $key) {

                                        return Html::a("" . $model->status == 1 ? '禁用' : '启用' . "", "javascript:changestatus($key);", ['id' => $key]);
                                    },
                                    'view' => function ($url, $model, $key) {

                                        return Html::a('查看', "$url", ['class' => '','target'=>'_blank']);
                                    },


                                ],],


                        ];
                        echo ExportMenu::widget([
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
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .modal-content {
        width: 700px;
        left: 20%;
    }

    .modal-body p {
        line-height: 32px;
        margin-bottom: 10px;
    }

    .modal-body p label {
        width: 140px;
        display: inline-block;
        text-align: right;
        font-weight: normal;
        padding-right: 5px;
    }

    .modal_text {
        width: 400px;
        height: 30px;
        line-height: 30px;
        border: 1px solid #ccc;
        padding: 0 4px;
    }

    .modal-footer {
        text-align: center;
    }

    .close_1 {
        margin: 0 auto;
        display: inline-block;
        width: 120px;
    }

    .t_name {
        text-align: center;
        margin-bottom: 30px;
    }

    .modal_i {
        display: block;
        font-style: normal;
        font-size: 12px;
        color: #FF0000;
    }

    .clear {
        clear: both;
    }
</style>

<script>


    function changestatus($key) {
        layer.confirm('确认要进行此操作吗?', {icon: 3, title: '友情提示'}, function (index) {
            $.post("<?=Url::to(["agent/changestatus"])?>", {
                "PHPSESSID": "<?php echo session_id();?>",
                "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                data: {id: $key},
            }, function (data) {
                if (data == 1) {
                    layer.alert('操作成功');
                    window.location.reload();


                }


            });
        });
    }


</script>



