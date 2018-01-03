<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '拉新统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<?php if (Yii::$app->session->hasFlash('succ')) { ?>
    <script>layer.alert("<?=Yii::$app->session->getFlash('succ')?>", {time: 0,})</script>
<?php } ?>
<style>
    .tit{
        height: 42px;
        border-bottom: 2px solid #1888F8;
        width: 100%;
        margin: 10px auto;
    }
    .tit a{
        display: inline-block;
        width: 120px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        background: #efefef;
        color: black;
    }
    .tit a:hover{
        cursor: pointer;
    }
    .sty{
        background: #1888F8!important;
        color: white!important;
    }
</style>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="tit">
                            <a href="pull-new-count" class="sty" style="margin-right: 30px;">拉新统计</a>
                            <a href="page-view-count">浏览量</a>
                        </div>
                        <div class="search-box clearfix">
                            <div class="search-item">
                                <?= Html::beginForm(['travel-talent-count/pull-new-count'], 'get', ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'addForm']) ?>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 10px;">
                                        <?php
                                        echo DateRangePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'stime',
                                            'convertFormat' => true,
                                            'language' => 'zh-CN',
                                            'options' => [
                                                'placeholder' => '请选择注册时间',
                                                'class' => 'form-control',
                                                'readonly' => true,
                                            ],
                                            'pluginOptions' => [
                                                'timePicker' => false,
                                                'timePickerIncrement' => 30,
                                                'locale' => [
                                                    'format' => 'Y-m-d'
                                                ]
                                            ]
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'identity',Yii::$app->params['impress_identity'], ['class' => 'form-control', 'prompt' => '按性质']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeDropDownList($searchModel, 'pstatus',Yii::$app->params['person_status'], ['class' => 'form-control', 'prompt' => '按状态']) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'mobile', ['class' => 'form-control input', 'placeholder' => '按账号','maxlength' => 50]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 200px; float: left;margin-right: 10px;">
                                        <?= Html::activeInput('text', $searchModel, 'invite_mobile', ['class' => 'form-control input', 'placeholder' => '按邀请人账号','maxlength' => 50]) ?>
                                    </div>
                                </div>
                                <div class="search-item">
                                    <div class="input-group" style="width: 120px; float: left;margin-right: 10px;">
                                        <?= Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>&nbsp;
                                        <?= Html::a("清空",$url = ['travel-talent-count/pull-new-count'],$options = ['class' => 'btn btn-sm btn-primary']) ?>
                                    </div>
                                </div>
                                <?= Html::endForm() ?>
                            </div>
                        </div>
                        <?php
                        use kartik\export\ExportMenu;
                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn',
                                'header' => '编号'],
                            ['attribute' => 'create_time',
                                'value' => function ($model) {
                                    return $model->create_time;
                                }
                            ],
                            ['attribute' => 'account',
                                'header' => '帐号',
                                'format' => 'html',
                                'value' => function ($model) {
                                    $info = \backend\models\User::getInviteMobile($model->id);
                                    if($info['auth']==0){
                                        return $info['mobile'];
                                    }else{
                                        if($model->pid && $model->pstatus==3)
                                            return $info['mobile'];
                                        elseif($model->cid && $model->cstatus==3)
                                            return $info['mobile'];
                                        else{
                                            if($info['auth']==1)
                                                return Html::a($info['mobile'],["travel-person/view",'id'=>$info['id']],['target'=>'_blank']);
                                            if($info['auth']==2)
                                                return Html::a($info['mobile'],["travel-company/view",'id'=>$info['id']],['target'=>'_blank']);
                                        }
                                    }
                                }
                            ],
                            [   'header' => '性质',
                                'value' => function ($model) {
                                    $identity = \backend\models\TravelActivity::getidentity($model->id);
                                    return $identity;
                                }
                            ],
                            [   'header' => '资质审核状态',
                                'value' => function ($model) {
                                    if($model->pid)
                                        return Yii::$app->params['person_status'][$model->pstatus];
                                    elseif($model->cid)
                                        return Yii::$app->params['person_status'][$model->cstatus];
                                    else
                                        return "--";
                                }
                            ],
                            [   'header' => '是否有已审核通过的商品',
                                'value' => function ($model) {
                                    $total = \backend\models\User::getTravelGoods($model->id);
                                    if($total>0)
                                        return "是";
                                    else
                                        return "否";
                                    //return $total;
                                }
                            ],
                            [   'header' => '邀请人账号',
                                'format' => 'html',
                                'value' => function ($model) {
                                    $info = \backend\models\User::getInviteMobile($model->invite_uid);
                                    if($info['auth']==0){
                                        return $info['mobile'];
                                    }else{
                                        if($info['auth']==0 || $info['status']==3)
                                            return $info['mobile'];
                                        else{
                                            if($info['auth']==1)
                                                return Html::a($info['mobile'],["travel-person/view",'id'=>$info['id']],['target'=>'_blank']);
                                            if($info['auth']==2)
                                                return Html::a($info['mobile'],["travel-company/view",'id'=>$info['id']],['target'=>'_blank']);
                                        }
                                    }
                                }
                            ],

                        ];
                        // Renders a export dropdown menu
                        echo ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns
                        ]);
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
    </div>
</div>


