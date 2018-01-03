<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '中奖信息管理';
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

    /*中奖列表*/
    .award_list{ overflow: hidden; width: 901px; margin: 30px auto; border-left:1px solid #333; border-top:1px solid #333; padding:0;}
    .award_list li{ width: 150px; float: left; list-style: none; height: 32px; line-height: 32px; text-align: center; margin: 0; padding: 0; border-bottom:1px solid #333; border-right:1px solid #333;}
    .award_list li.li_one{ background-color: #ccc;}
</style>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <div class="tit">
                            <a href="index" style="margin-right: 30px;">中奖明细</a>
                            <a href="info" class="sty">中奖概述</a>
                        </div>
                        <ul class="award_list">
                            <li class="li_one">PV</li><li class="li_two"><?=$activityInfo['pv']?></li>
                            <li class="li_one">总奖品发放</li><li class="li_two"><?=$sendNum?></li>
                            <li class="li_one">总奖品剩余</li><li class="li_two"><?=$surplusNum?></li>
                            <li class="li_one">点击抽奖次数</li><li class="li_two"><?=$drawNum?></li>
                            <li class="li_one">200元优惠券发放</li><li class="li_two"><?=$awardList[1]['award_stock']-$awardList[1]['residue_stock']?></li>
                            <li class="li_one">200元优惠券剩余</li><li class="li_two"><?=$awardList[1]['residue_stock']?></li>
                            <li class="li_one">新注册用户</li><li class="li_two"><?=$newUserNum?></li>
                            <li class="li_one">100元优惠券发放</li><li class="li_two"><?=$awardList[3]['award_stock']-$awardList[3]['residue_stock']?></li>
                            <li class="li_one">100元优惠券剩余</li><li class="li_two"><?=$awardList[3]['residue_stock']?></li>
                            <li class="li_one">老用户</li><li class="li_two"><?=$drawNum-$newUserNum?></li>
                            <li class="li_one">30元优惠券发放</li><li class="li_two"><?=$awardList[4]['award_stock']-$awardList[4]['residue_stock']?></li>
                            <li class="li_one">30元优惠券剩余</li><li class="li_two"><?=$awardList[4]['residue_stock']?></li>
                            <li class="li_one"></li><li class="li_two"></li>
                            <li class="li_one">15元优惠券发放</li><li class="li_two"><?=$awardList[2]['award_stock']-$awardList[2]['residue_stock']?></li>
                            <li class="li_one">15元优惠券剩余</li><li class="li_two"><?=$awardList[2]['residue_stock']?></li>
                            <li class="li_one"></li><li class="li_two"></li>
                            <li class="li_one">iphone发放</li><li class="li_two"><?=$awardList[0]['award_stock']-$awardList[0]['residue_stock']?></li>
                            <li class="li_one">iphone剩余</li><li class="li_two"><?=$awardList[0]['residue_stock']?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


