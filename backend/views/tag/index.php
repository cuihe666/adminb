<?php
use yii\widgets\LinkPager;

?>

<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
<!-- 页面css -->
<link rel="stylesheet" href="/css/cobber.css">

<script src="/common/js/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/bootstrap/dist/js/app.min.js"></script>


<style>
    .content_wrapper {
        margin: 0;
    }

    .content .footer {
        background-color: transparent;
        border: none;
    }
</style>
<body class="hold-transition skin-blue sidebar-mini">

<section class="content-header">
    <h5>
        当前位置:首页 > 房源配置 > 配套设施列表
    </h5>
    <hr>
</section>
<section class="content">
    <div class="form-group" style="margin-top:30px;">
        <div class="row row_add">
            <a href="<?php echo \yii\helpers\Url::to(['tag/add']) ?>" class="btn btn-default btn_add">+新增</a>
        </div>
        <div class="table-responsive" style="overflow-x:inherit">
            <table class="table table-bordered table_line">
                <tbody>
                <tr class="active">
                    <td>名称</td>
                    <td>设施名称</td>
                    <td>描述</td>
                    <td>排序</td>
                    <td>状态</td>
                    <td>操作</td>
                </tr>
                <?php foreach ($models as $k => $v): ?>
                    <tr>
                        <td><?php echo $v->name ?></td>
                        <td>
                            <span><?php echo \backend\controllers\TagController::Getname($v->id) ?></span>
                        </td>
                        <td><?php echo $v->desc ?></td>
                        <td><?php echo $v->sort ?></td>
                        <td>
                            <?php echo $v->status == 1 ? '禁用' : '正常'; ?>
                        </td>
                        <td>
                            <a href="<?php echo \yii\helpers\Url::to(['edit', 'id' => $v->id]) ?>">修改</a>
                            <a href="javascript:;" cid="<?php echo $v->id ?>"
                               class="chstatus"><?php echo $v->status ? '启用' : '禁用' ?></a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>

            </table>
            <?php
            echo LinkPager::widget([
                'pagination' => $pages,
            ])
            ?>

        </div>
    </div>
</section>
<script>

    $(function () {
        $('.chstatus').click(function () {
            id = $(this).attr('cid');
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['changestatus']) ?>",
                data: {id: id},
                success: function (data) {
                    if (data == 1) {
                        window.location.reload();
                    }
                }
            })
        })
    })

</script>
