<?php

use yii\helpers\Html;
use backend\assets\HotelAsset;


//
$this->title = '酒店供应商';
$this->params['breadcrumbs'][] = $this->title;
HotelAsset::register($this);
\backend\assets\ScrollAsset::register($this);
?>


<!-- Main content -->

<?= \backend\widgets\ElementAlertWidget::widget() ?>

<section class="content">
    <div class="rummery_top">
<!--        公共头部-->
        <?= \backend\widgets\HotelSupplierListWidget::widget([
            'current_url' => Yii::$app->controller->action->id,
            'body' => Yii::$app->params['hotel_supplier_nav'],
            'query' => Yii::$app->getRequest()->queryString,
        ]) ?>

        <div class="rummery_con">
            <input type="hidden" id="top_account_type_val" value="1">
            <?= Html::beginForm(['hotel-supplier/account?id='.$supplier_id], 'post', ['class' => 'form-horizontal', 'id' => 'account-form']) ?>
            <div class="rummery_item rummery_policy">
                <div class="xhh_conent">
                    <?= Html::activeHiddenInput($model,'supplier_id',['value' => $supplier_id]) ?>
                    <ul class="conent-message">
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>财务联系人：</span>
                            <?= Html::activeInput('text',$model,'user_name',[
                                'id' => 'hinese'
                            ]) ?>
                            <i class="hinese_b"></i>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>联系人手机：</span>
                            <?= Html::activeInput('text',$model,'mobile',[
                                'id' => 'cellNumber',
                            ]) ?>
                            <i class="cellNumber_b"></i>
                        </li>
                        <li>
                            <i>&nbsp;&nbsp;&nbsp;</i>
                            <span>联系人邮箱：</span>
                            <?= Html::activeInput('text',$model,'email',[
                                'id' => 'checkMail',
                            ]) ?>
                            <i class="checkMail_b"></i>
                        </li>
                        <li class="bank-name">
                            <i>*&nbsp;&nbsp;</i>
                            <span>银行名称：</span>
                            <?= Html::activeInput('text',$model,'bank_name',[
                                'id' => 'bankname',
                            ]) ?>
                            <i class="bankname_b" style="color:#999;">请确保开户银行名称填写正确，否则无法正常打款</i>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>开户支行名称：</span>
                            <?= Html::activeInput('text',$model,'bank_detail',[
                                'id' => 'openingbank',
                            ]) ?>
                            <i class="openingbank_b" style="color:#999;">请确保支行名称填写正确，否则无法正常打款</i>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>户名：</span>
                            <?= Html::activeInput('text',$model,'account_name',[
                                'id' => 'username',
                            ]) ?>
                            <i class="username"></i>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>银行账号：</span>
                            <?= Html::activeInput('text',$model,'account_number',[
                                'id' => 'account_number',
                            ]) ?>
                            <i class="account_number_b"></i>
                        </li>
                        <li>
                            <i>&nbsp;&nbsp;&nbsp;</i>
                            <span>支付宝账号：</span>
                            <?= Html::activeInput('text',$model,'alipay_number') ?>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>账户类型：</span>
                            <?= Html::activeDropDownList($model,'type',Yii::$app->params['hotel_supplier_account_type_insert']) ?>
                        </li>
                    </ul>

                    <div class="message-footer">
                        <?= Html::submitButton('保存并继续',['class' => 'message-footer-save']) ?>
                    </div>
                </div>
            </div>

            <?= Html::endForm() ?>
        </div>
    </div>


</section>