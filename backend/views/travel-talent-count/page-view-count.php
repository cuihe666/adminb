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
    .pv_tabel{ width:600px; border:1px solid #CCCCCC; margin: 50px auto auto 150px;}
    .pv_tabel th,.pv_tabel td{ border:1px solid #CCCCCC; height: 36px; line-height: 36px; text-align: center; font-size:16px;}
</style>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="tit">
                            <a href="pull-new-count" style="margin-right: 30px;">拉新统计</a>
                            <a href="page-view-count" class="sty">浏览量</a>
                        </div>
                        <table class="pv_tabel">
                            <tr>
                                <th>新用户注册量</th>
                                <th>浏览量（pv）</th>
                            </tr>
                            <tr>
                                <td><?=$userCount;?></td>
                                <td><?=$info['page_view']?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


