<?php


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\SignupForm */


use yii\helpers\Html;
use yii\helpers\Url;


$this->title = '分类管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= Yii::$app->request->baseUrl ?>/yulan/js/jquery-1.9.1.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<p>
    <?= Html::a('创建分类', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>分类名称</th>
                        <th>费率</th>
                        <th>操作</th>
                    </tr>
                    <?php foreach ($cates as $cate): ?>
                        <tr class="first">
                            <td>
                                <?php echo $cate['id'] ?>
                            </td>
                            <td>
                                <?php echo $cate['title']; ?>
                            </td>
                            <td>
                                <?php echo $cate['rate'] ?>
                            </td>
                            <td class="align-right">

                                <a href="<?php echo yii\helpers\Url::to(['shop-category/create', 'pid' => $cate['id']]); ?>">添加子分类</a>
                                &nbsp; &nbsp; &nbsp; &nbsp;

                                <a href="<?php echo yii\helpers\Url::to(['shop-category/update', 'id' => $cate['id']]); ?>">编辑</a>
                                &nbsp; &nbsp; &nbsp; &nbsp;
                                <?php echo Html::a('删除', "javascript:del($cate[id]);") ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
<script>
    function del(id) {
        layer.confirm('确认要删除吗？', {icon: 2, title: '警告'}, function (index) {
            $.post("<?=Url::to(["shop-category/delete"])?>", {
                "PHPSESSID": "<?php echo session_id();?>",
                "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                data: {id: id},
            }, function (data) {
                if (data == 1) {
                    location.reload();

                }
                if (data == -1) {
                    location.reload();

                }


            })

        });
    }
</script>
