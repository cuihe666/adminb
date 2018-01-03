<?php
$this->title = '修改首页图片';
use backend\config\Consts;

?>
<script src="<?= Yii::$app->request->baseUrl ?>/yulan/js/jquery-1.9.1.min.js"></script>

<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/yulan/dist/zoomify.min.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">


            </div>
            <!-- /.box-header -->

                <table class="table table-hover">

                    <tr>
                        <td>
                            <?php foreach ($pics as $k => $v): ?>
                                <div class="col-sm-8 col-md-2">
                                    <div class="thumbnail">
                                        <img class="example img-rounded" style="height:160px;margin-bottom: 20px"
                                             src="<?php echo Consts::DOMAIN_FACE . $v ?>">
                                        <input type="button" class="btn btn-block btn-info btn-sm img_btn"
                                               value="设置为首面图片" attr_img="<?php echo $v ?>">

                                    </div>
                                </div>
                            <?php endforeach; ?>


                        </td>
                    </tr>

                </table>
            </div>
            <!-- /.box-body -->

        <!-- /.box -->
    </div>
</div>

<script src="<?= Yii::$app->request->baseUrl ?>/yulan/dist/zoomify.min.js"></script>
<script type="text/javascript">
    $('.example').zoomify();
</script>
<!-- ./wrapper -->
<script>
    $('.img_btn').click(function () {
        var img = $(this).attr('attr_img');
        var house_id = <?php echo @$_GET['id'];?> ;
        $.ajax({
            type: 'post',
            url: "<?php echo \yii\helpers\Url::to(['changepic']) ?>",
            data: {img: img, house_id: house_id},
            success: function (data) {
                if (data == 1) {
                    $('#comment').modal('hide')
                    layer.alert('操作成功', {icon: 1});
                }

            }
        })
    })

</script>
