<?php
use yii\helpers\Url;

$this->title = '卖家审核';

?>

<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th><span style="color:red;">*</span> 店铺名称：</th>
                        <th><?= $model->info->name ?></th>

                        <th><span style="color:red;">*</span>退货联系人：</th>
                        <th><?= $model->info->returns ?></th>

                        <th><span style="color:red;">*</span>公司名称：</th>
                        <th><?= $model->company_name ?></th>

                    </tr>
                    <tr>
                        <th><span style="color:red;">*</span> 店铺负责人：</th>
                        <th><?= $model->info->principal ?></th>

                        <th><span style="color:red;">*</span>退货联系人手机号：</th>
                        <th><?= $model->info->returns_phone ?></th>

                        <th><span style="color:red;">*</span>银行账号：</th>
                        <th><?= $model->bank_num ?></th>

                    </tr>

                    <tr>
                        <th><span style="color:red;">*</span> 负责人手机号：</th>
                        <th><?= $model->info->principal_phone ?></th>

                        <th><span style="color:red;">*</span>退货地址：</th>
                        <th><?= \backend\service\CommonService::getCityName($model->info->province) . '&nbsp;&nbsp;' . \backend\service\CommonService::getCityName($model->info->city) . '&nbsp;&nbsp;' . \backend\service\CommonService::getCityName($model->info->area) . '&nbsp;&nbsp;' . $model->info->detail ?></th>

                        <th><span style="color:red;">*</span>银行名称：</th>
                        <th><?= $model->bank_name ?></th>

                    </tr>

                    <tr>
                        <th><span style="color:red;">*</span>法人姓名：</th>
                        <th><?= $model->legal ?></th>

                        <th><span style="color:red;">*</span>营业期限：</th>
                        <th><?= $model->long_time == 0 ? '短期' : '长期' ?></th>

                        <th><span style="color:red;">*</span>支行名称：</th>
                        <th><?= $model->bank_branch_name ?></th>

                    </tr>

                    <tr>
                        <th><span style="color:red;">*</span>法人身份证号码：</th>
                        <th><?= $model->legal_id_code ?></th>

                        <th>时间</th>
                        <?php if ($model->long_time == 0): ?>
                            <th>开始时间:<?= substr($model->start_time, 0, 10) ?>
                                结束时间<?= substr($model->end_time, 0, 10) ?></th>
                        <?php else: ?>
                            <th>开始时间:<?= substr($model->start_time, 0, 10) ?></th>

                        <?php endif; ?>

                        <th><span style="color:red;">*</span>收款人姓名：</th>
                        <th><?= $model->account_name ?></th>

                    </tr>

                    <tr>
                        <?php
                        if ($model->is_combine == 1):
                            ?>
                            <th><span style="color:red;">*</span>统一社会信用代码：</th>
                        <?php else: ?>

                            <th><span style="color:red;">*</span>营业执照注册号：</th>
                        <?php endif ?>

                        <th><?= $model->uscc_code ?></th>


                        <?php
                        if ($model->is_combine == 0):
                            ?>
                            <th><span style="color:red;">*</span>组织机构代码证号：</th>
                            <th><?= $model->occ_code ?></th>
                        <?php else: ?>
                            <th></th>

                            <th></th>


                        <?php endif ?>
                        <th></th>
                        <th></th>

                    </tr>


                    <tr>


                        <th align="middle"><span style="color:red;">*</span>营业执照：</th>
                        <th><img src="<?php echo json_decode($model->images)->uscc_code_image->url ?>"
                                 style="width:154px;height: 128px;"></th>

                        <?php
                        if ($model->is_combine == 0):
                            ?>
                            <th><span style="color:red;">*</span>组织机构代码证：</th>

                            <th><img src="<?php echo json_decode($model->images)->occ_code_image->url ?>"
                                     style="width:154px;height: 128px;"></th>

                        <?php else: ?>
                            <th></th>

                            <th></th>

                        <?php endif ?>

                        <th></th>
                        <th></th>


                    </tr>


                    <tr>

                        <?php
                        if ($model->is_combine == 0):
                            ?>
                            <th><span style="color:red;">*</span>税务登记号：</th>
                            <th><?= $model->tax_id ?></th>

                            <th><span style="color:red;">*</span>税务登记证：</th>

                            <th><img src="<?php echo json_decode($model->images)->tax_id_image->url ?>"
                                     style="width:154px;height: 128px;"></th>

                        <?php else: ?>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>

                        <?php endif ?>


                        <th></th>
                        <th></th>


                    </tr>

                    <tr>
                        <th><span style="color:red;">*</span>法人身份证：（正面）：</th>
                        <th><img src="<?php echo json_decode($model->images)->id_face->url ?>"
                                 style="width:154px;height: 128px;"></th>

                        <th><span style="color:red;">*</span>法人身份证：（反面）：</th>
                        <th><img src="<?php echo json_decode($model->images)->id_back->url ?>"
                                 style="width:154px;height: 128px;"></th>

                        <th></th>

                        <th></th>
                    </tr>
                    <?php vard ?>

                    <?php if (isset(json_decode($model->images)->other_image)):
                        $others = json_decode($model->images)->other_image;

                        ?>
                        <tr>
                            <th>其它:</th>
                            <td colspan="5">
                                <?php foreach ($others as $k => $v): ?>
                                    <img src="<?php echo $v->url ?>"
                                         style="width:154px;height: 128px; float: left;margin-right: 5px">
                                <?php endforeach; ?>
                            </td>

                        </tr>

                        <?php
                    endif ?>


                </table>
            </div>
            <!-- /.box-body -->
        </div>

        <style>
            th {
                vertical-align: middle;
                text-align: center;
            }
        </style>


        <div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                    aria-hidden="true">&times;</span><span
                                    class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">驳回原因</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">

                            <textarea class="form-control" cols="3" rows="3" id='reason_inner'></textarea>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="rejected(<?= $model->id ?>,10)">提交
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row" style="padding-top: 0;margin-top: 10px;position: fixed;left:580px;
        bottom:0;">
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            <?php if ($model->status == 1): ?>
                <button class="btn  btn-info check_house" onclick="check(<?= $model->id ?>,2)">通过</button>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <button class="btn  btn-info  sort" onclick="check(<?= $model->id ?>,10)">驳回</button>

            <?php endif ?>

            <?php if ($model->status == 2): ?>

            <?php endif ?>
            <?php if ($model->status == 3): ?>


            <?php endif ?>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            <button class="btn  btn-info  comment" onclick="goback()">返回</button>
        </div>

        <script>

            function goback() {
                window.location.href = '<?php echo $url ?>';
            }


            function check($id, $status) {
                if ($status == 10) {
                    $('#comment').modal();
                    return;
                }
                layer.confirm('确定要进行些操作吗', {icon: 3, title: '友情提示'}, function (index) {

                    $.post("<?=Url::to(["check"])?>", {
                        "PHPSESSID": "<?php echo session_id();?>",
                        "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                        data: {id: $id, status: $status, reason: ''},
                    }, function (data) {
                        if (data == 1) {
                            layer.alert('操作成功');
                            window.location.href = '<?php echo $url ?>';


                        }


                    });
                });
            }


            //驳回操作
            function rejected($id, $status) {
                var reason = $('#reason_inner').val();
                if (reason == '') {
                    layer.alert('驳回原因不能为空！', {icon: 1});
                    return false;
                }
                $.post("<?=Url::to(["check"])?>", {
                    "PHPSESSID": "<?php echo session_id();?>",
                    "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                    data: {id: $id, status: $status, reason: reason},
                }, function (data) {
                    if (data == 1) {
                        layer.alert('操作成功');

                        window.location.href = '<?php echo $url ?>';

                    }


                });


            }


        </script>