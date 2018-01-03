<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\ShopGoods */

$this->title = '商品详情';

?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>


<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">基本信息</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <td>商品类型：</td>
                        <td><?= $model->category_name ?></td>
                        <td>商品价格：</td>
                        <td><?= $model->price ?></td>
                        <td>商品审核人：</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>商品状态：</td>
                        <td><?= Yii::$app->params['shop']['goods_status'][$model->status] ?></td>
                        <td>商品上传时间：</td>
                        <td><?= $model->created_at ?></td>
                        <td>卖家账号：</td>
                        <td><?= $supplier['admin_username'] ?></td>
                    </tr>
                    <tr>
                        <td>商品名称：</td>
                        <td><?= $model->title ?></td>
                        <td>商品审核时间：</td>
                        <td><?= $check_date ?></td>
                        <td>卖家手机：</td>
                        <td><?= $info['principal_phone'] ?></td>

                    </tr>
                    <tr>
                        <td>商家编码：</td>
                        <td></td>
                        <td>商品上架时间：</td>
                        <td><?= $online_date ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">商品规格</h3>

            </div>


            <!-- /.box-header -->

            <?php $attr = json_decode($model->attributes);
            ?>

            <table id="example2" class="table table-bordered table-hover">

                <tbody>
                <?php if ($attr):
                    foreach ($attr as $k => $v):
                        ?>
                        <tr>
                            <td width="250"><?php echo $v->label ?>:</td>
                            <td colspan="3"><?= $v->value ?></td>
                            <!--                            <td></td>-->
                            <!--                            <td></td>-->

                        </tr>
                        <?php
                    endforeach;
                endif ?>

            </table>

            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">说明</h3>

            </div>
            <!-- /.box-header -->
            <table id="example2" class="table table-bordered table-hover">

                <tbody>
                <tr>
                    <td><?= $model->description ?></td>
                </tr>


            </table>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">包装清单</h3>

            </div>
            <!-- /.box-header -->
            <table id="example2" class="table table-bordered table-hover">

                <tbody>
                <tr>
                    <td>
                        <?= $model->packing_list ?>
                    </td>
                </tr>


            </table>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">商品图片</h3>

            </div>
            <!-- /.box-header -->
            <table id="example2" class="table table-bordered table-hover">

                <tbody>
                <?php
                $imgs = json_decode($model->images);

                ?>
                <tr>
                    <td>
                        <?php if ($imgs):
                            foreach ($imgs as $k => $v):
                                ?>
                                <img src="<?= $v->url ?>" style="width: 200px;">

                            <?php endforeach; endif ?>

                    </td>
                </tr>


            </table>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">发布位置</h3>

            </div>
            <!-- /.box-header -->
            <table id="example2" class="table table-bordered table-hover">

                <tbody>
                <tr>
                    <td>
                        <div class="form-group">
                            <label>运营位分类选择</label>
                            <input type="hidden" id="goods_id" value="<?= $model->id ?>">

                            <label>分类</label>
                            <select class="form-control1" style="width: 200px;" id="category">
                                <option value="1">旅行</option>
                                <option value="2">特产</option>
                                <option value="3">科技</option>
                                <option value="4">家居</option>

                            </select>


                            <button type="submit" class="btn btn-primary order_submit">提交</button>

                        </div>

                    </td>
                </tr>


            </table>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
<style>
    .form-control1 {
        display: inline-block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border-radius: 0;
        box-shadow: none;
        border-color: #d2d6de;
        margin-left: 10px;
    }

</style>


<div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-primary" onclick="rejected(<?= $model->id ?>,11)">提交</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row" style="padding-top: 0;margin-top: 10px;position: fixed;left:580px;
        bottom:0;">
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <?php if ($model->status == 10): ?>
        <button class="btn  btn-info check_house" onclick="check(<?= $model->id ?>,20)">通过</button>
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <button class="btn  btn-info  sort" onclick="check(<?= $model->id ?>,11)">驳回</button>

    <?php endif ?>



    <?php if ($model->status == 12): ?>
        <button class="btn  btn-info check_house" onclick="check(<?= $model->id ?>,20)">上架</button>
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

    <?php endif ?>

    <?php if ($model->status == 20): ?>
        <button class="btn  btn-info check_house" onclick="check(<?= $model->id ?>,30)">下架</button>
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;


    <?php endif ?>

    <?php if ($model->status == 30): ?>
        <button class="btn  btn-info check_house" onclick="check(<?= $model->id ?>,20)">上架</button>
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;


    <?php endif ?>


    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <button class="btn  btn-info  comment" onclick="goback()">返回</button>
</div>


<script>


    function check($id, $status) {
        if ($status == 11) {
            $('#comment').modal();
            return;
        }
        layer.confirm('确定要进行些操作吗', {icon: 3, title: '友情提示'}, function (index) {

            $.post("<?=Url::to(["check"])?>", {
                "PHPSESSID": "<?php echo session_id();?>",
                "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                data: {id: $id, status: $status, reason: ''},
            }, function (data) {
                console.log(data);
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
            console.log(data);
            return;
            if (data == 1) {
                layer.alert('操作成功');

                window.location.href = '<?php echo $url ?>';

            }


        });


    }
    function goback() {
        window.location.href = '<?php echo $url ?>';
    }


    //排序
    $('.order_submit').click(function () {
        var goods_id = $('#goods_id').val();
//        var position = $('#position').val();
        var category = $('#category').val();
//        var sort = $('#sort').val();

        $.post("<?=Url::to(["set_category"])?>", {
            "PHPSESSID": "<?php echo session_id();?>",
            "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
            data: {goods_id: goods_id, position: position, category: category, sort: sort},
        }, function (data) {
            if (data == -2) {
                layer.alert('此商品已在此位置存在', {
                    skin: 'layui-layer-molv' //样式类名
                    , closeBtn: 0
                })

            }
            if (data == -1) {

                layer.confirm('此位置上已存在商品，是否继续', {icon: 3, btn: ['替换', '取消'], title: '友情提示'}, function (index) {

                    $.post("<?=Url::to(["true_sort"])?>", {
                        "PHPSESSID": "<?php echo session_id();?>",
                        "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                        data: {goods_id: goods_id, position: position, category: category, sort: sort},
                    }, function (data) {
                        if (data == 1) {
                            layer.alert('操作成功');


                        }


                    });
                });

            }
            if (data == 1) {
                layer.alert('操作成功', {
                    skin: 'layui-layer-molv' //样式类名
                    , closeBtn: 0
                })
            }


        })

    })

</script>