<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\models\Comment */

$this->title = '造点评';
$this->params['breadcrumbs'][] = ['label' => '点评', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.js"></script>
<script src="http://cdn.staticfile.org/Plupload/2.1.1/plupload.full.min.js"></script>
<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>

<script>
    var token = '<?php echo $token;?>'
</script>
<style>
    .form-group{
        width:300px
    }
    .img-list{
        float:left; /* 向左漂移，将竖排变为横排 */
        list-style:none; /* 去掉ul前面的符号 */

    }
    .img{
        height: 200px;
    }
    #file-list li{
        margin: 5px;
    }
</style>

<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>