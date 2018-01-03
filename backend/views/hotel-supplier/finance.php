<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/5/9
 * Time: 下午2:29
 */
$this->title = '酒店供应商';
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\HotelAsset::register($this);

\backend\assets\VueAsset::register($this);
?>
<?= \backend\widgets\ElementAlertWidget::widget() ?>
<section class="content">
    <div class="rummery_top">
<!--        通用的导航头-->
<?= \backend\widgets\HotelSupplierListWidget::widget([
    'current_url' => Yii::$app->controller->action->id,
    'body' => Yii::$app->params['hotel_supplier_nav'],
    'query' => Yii::$app->getRequest()->queryString,
]) ?>
    </div>

<div class="rummery_item rummery_price" id="finance">
    <div class="cont">
        <div class="financial_header">
            <ul>
                <li class="bac">
                    供应商结算
                </li>
                <li >
                    账户信息
                </li>
            </ul>
        </div>
        <div class="active">
            <!--供应商结算-->
            <div class="active_one">
                <ul class="active_one_close">
                    <li>
                        <span>结算周期:</span>
                        <?php if($settle_type == 'month'):
                            echo implode(' -- ',\common\tools\Helper::lastMonth(true));
                        else:
                            echo implode(' -- ',\common\tools\Helper::lastWeek(true));
                        endif
                        ?>

                    </li>
                    <li>
                        <span>
											已出账单：
										</span>
                        <p class="price">
                            ￥<?= $doneCount['hotel_income'] ?>
                        </p>
                        <input type="button" name="" id="" onclick="location.href='/hotel-supplier/finance?id=<?= $supplierModel->id ?>&show_type=done'" value="查看" />

                        <!--结算状态-->
                        <?php if($doneCount->status): ?>
                            <input type="button" name="" id="" value="已结算" />
                        <?php else: ?>
                            <input type="button" name="" id="" value="未结算" @click="settleBill()" />
                        <?php endif  ?>


                        <!--开票状态-->
                        <?php if($doneCount->invoice): ?>
                            <input type="button" name="" id="" value="已开票" />
                        <?php else: ?>
                            <input type="button" name="" id="" value="未开票"  @click="setInvoice()" />
                        <?php endif  ?>
                    </li>
                    <li>
                        <span>
											未出账单：
										</span>
                        <p class="price price_size">
                            ￥<?= $waitCount['hotel_income'] ?>
                            <i>
                                <?php if($settle_type == 'month'):
                                    echo  implode(' -- ',\common\tools\Helper::thisMonth(true));
                                else:
                                    echo implode(' -- ',\common\tools\Helper::thisWeek(true));
                                endif
                                ?>
                            </i>
                        </p>
                        <input type="button" name="" id="" value="查看" onclick="location.href='/hotel-supplier/finance?id=<?= $supplierModel->id ?>&show_type=wait'" />
                    </li>
                </ul>
                <?php if(Yii::$app->request->get('show_type',false)):  ?>
                    <div class="suppy_list">
                        <!--                    这里显示订单列表-->
                        <?= $this->render('finance_list',compact('searchModel','dataProvider','supplierModel','countInfo')) ?>
                    </div>

                <?php endif ?>
            </div>

            <div class="active_one">
                <ul class="bank_information">
                    <li>
                        <span>
											户名：
										</span> <?= $accountModel->account_name?: '--' ?>
                    </li>
                    <li>
                        <span>
											开户银行：
										</span> <?= $accountModel->bank_name?: '--' ?><?= $accountModel->bank_detail?: '--' ?>
                    </li>
                    <li>
                        <span>
											银行账号：
										</span> <?= $accountModel->account_number?: '--' ?>
                    </li>
                    <li>
                        <span>
											账户类型：
										</span> <?= Yii::$app->params['hotel_supplier_account_type'][$accountModel->type] ?>
                    </li>
                    <div style="clear: both;"></div>
                </ul>
                <ul class="bank_information bank_accunt">
                    <li>
                        <span>
											支付宝账号：
										</span> <?= $accountModel->alipay_number?: '--' ?>
                    </li>

                    <div style="clear: both;"></div>
                </ul>
                <ul class="bank_information bank_accunt">
                    <li>
                        <span>
											财务联系人：
										</span> <?= $accountModel->user_name?: '--' ?>
                    </li>
                    <li>
                        <span>
											联系人邮箱：
										</span> <?= $accountModel->email?: '--' ?>
                    </li>
                    <li>
                        <span>
											联系人手机：
										</span> <?= $accountModel->mobile?: '--' ?>
                    </li>
                    <li>
<!--                        <span>-->
<!--											账户类型：-->
<!--										</span> 对公账户-->
                    </li>
                    <div style="clear: both;"></div>
                </ul>
            </div>

        </div>
    </div>

</div>

</section>

<script>
    var finance = new Vue({
        el: '#finance',
        data: {
            role: '<?= \common\tools\Helper::checkPermission('酒店供应商(财务)')? 1 : 0 ?>'
        },
        methods: {
            //结算账单
            settleBill: function(){
                if(this.role == 1){
                    location.href = '/hotel-supplier/settle-bill?id=<?= $supplierModel->id ?>';
                }else{
                    this.$notify({
                        title: '警告',
                        message: '需要财务权限,请联系管理员',
                        type: 'warning'
                    });
                }
            },
            //开票
            setInvoice: function(){
                if(this.role == 1){
                    location.href = '/hotel-supplier/invoice?id=<?= $supplierModel->id ?>';
                }else{
                    this.$notify({
                        title: '警告',
                        message: '需要财务权限,请联系管理员',
                        type: 'warning'
                    });
                }

            }
        }
    });
</script>