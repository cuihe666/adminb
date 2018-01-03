<?php
$this->title = '房源详情';
use backend\config\Consts;

?>
<script src="<?= Yii::$app->request->baseUrl ?>/yulan/js/jquery-1.9.1.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/yulan/dist/zoomify.min.css">
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">房源信息</h3>
                    <input type="hidden" id="house_id" value="<?= $data['house_id'] ?>">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td style="width: 180px;">标题</td>
                            <td><?= $data['title'] ?></td>
                        </tr>

                        <tr>
                            <td>介绍</td>
                            <td><?= $data['introduce'] ?></td>

                        </tr>
                        <tr>
                            <td>类型</td>
                            <td><?php echo Yii::$app->params['room_type'][$data['roomtype']]; ?></td>
                        </tr>
                        <tr>
                            <td>电话</td>
                            <td><?= $num ?></td>
                        </tr>
                        <tr>
                            <td>出租方式</td>
                            <td><?php echo Yii::$app->params['roommode'][$data['roommode']]; ?></td>
                        </tr>


                        <tr>
                            <td>房源地址</td>
                            <td><?php echo $data['vague_addr'] ?></td>
                        </tr>

                        <tr>
                            <td>价格</td>
                            <td><?php echo $data['price'] ?></td>
                        </tr>
                        <tr>
                            <td>上传时间:</td>
                            <td><?php echo substr($data['create_time'], 0, 10) ?></td>
                        </tr>


                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">房源操作</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-condensed">
                        <tr>
                            <td>
                                <button class="btn btn-block btn-danger btn-lg check_house">审核房源</button>
                            </td>
                            <td>
                                <button class="btn btn-block btn-warning btn-lg sort">排序</button>
                            </td>
                            <td>
                                <button class="btn btn-block btn-success btn-lg comment">添加评论</button>
                            </td>

                        </tr>

                    </table>
                </div>
                <!-- /.box-body -->
            </div>


            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">房源图片管理</h3>
                    <table class="table table-condensed">
                        <tr>
                            <td>
                                <?php
                                if (is_array($img) && !empty($img)) {
                                    foreach ($img as $v) {

                                        ?>
                                        <img class="example img-rounded" src="<?php echo Consts::DOMAIN_FACE . $v ?> "
                                             style="width:120px;height:100px;margin: 8px;float: left;">

                                        <?php
                                    }

                                }
                                ?>
                            </td>

                        </tr>
                    </table>


                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->


            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>

    <script src="<?= Yii::$app->request->baseUrl ?>/yulan/dist/zoomify.min.js"></script>
    <script type="text/javascript">
        $('.example').zoomify();
    </script>
</section>

<!-- 审核房源 -->
<div class="modal fade" id="check_house" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">请选择房源状态</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>请选择</label>
                    <select class="form-control se" id="house_status">
                        <option selected="selected" value="1" <?php if ($data['status'] == 1) echo 'selected'; ?>>通过
                        </option>
                        <option value="3" <?php if ($data['status'] == 3) echo 'selected'; ?>>未通过</option>

                        <option value="4">下架</option>
                    </select>
                    <textarea class="reason" placeholder="驳回原因" id="tse" cols="30" rows="10"
                              style="width:100%;height:150px;margin-top:20px;"></textarea>
                </div>
                <script>
                    $(document).ready(function () {
                        $("#tse").hide();
                        var aa = $(".se option:selected");
                        var aaval = aa.val();
                        if (aaval === "3") {
                            $("#tse").show();
                        } else if (aaval === "1") {
                            $("#tse").hide();
                        }
                        $(".se").change(function () {
                            var aa = $(".se option:selected");
                            var aaval = aa.val();
                            if (aaval === "3") {
                                $("#tse").show();
                            } else if (aaval === "1") {
                                $("#tse").hide();
                            }
                        });
                    });
                </script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary status_save">保存</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

            </div>
        </div>
    </div>
</div>
<!-- 排序 -->

<div class="modal fade" id="sort" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">输入排序值</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="inputSuccess"
                           onkeyup="value=value.replace(/[^1234567890-]+/g,'')">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary sort_save">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- 添加评论 -->

<div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">输入排序值</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <textarea class="form-control" cols="4" rows="4" id='comment_inner'></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary comment_save">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    td {
        text-align: center;
    }
</style>
<script>
    $('.check_house').click(function () {
        $('#check_house').modal();

    })

    $('.status_save').click(function () {
        var house_status = $("#house_status").find("option:selected").val();
        var house_id = $("#house_id").val();
        var reason = $('.reason').val();
        $.ajax({
            type: 'post',
            url: "<?php echo \yii\helpers\Url::to(['status']) ?>",
            data: {house_status: house_status, house_id: house_id, reason: reason},
            success: function (data) {
                if (data == 1) {
                    $('#check_house').modal('hide')
                    layer.alert('操作成功', {icon: 1});
                    location.href = '<?php echo \yii\helpers\Url::to(['house-details/index']) ?>';
                }

            }
        })
    })

    $('.sort').click(function () {
        $('#sort').modal();


    })

    $('.sort_save').click(function () {
        var house_id = $("#house_id").val();
        var sort_num = parseInt($("#inputSuccess").val());
        $.ajax({
            type: 'post',
            url: "<?php echo \yii\helpers\Url::to(['sort']) ?>",
            data: {sort_num: sort_num, house_id: house_id},
            success: function (data) {
                if (data == 1) {
                    $('#sort').modal('hide')
                    layer.alert('操作成功', {icon: 1});
                }

            }
        })
    })

    $('.comment').click(function () {
        $('#comment').modal();


    })

    $('.comment_save').click(function () {
        var house_id = $("#house_id").val();
        var comment_inner = $('#comment_inner').val();
        $.ajax({
            type: 'post',
            url: "<?php echo \yii\helpers\Url::to(['comment']) ?>",
            data: {comment_inner: comment_inner, house_id: house_id},
            success: function (data) {
                if (data == 1) {
                    $('#comment').modal('hide')
                    layer.alert('操作成功', {icon: 1});
                }

            }
        })
    })


</script>