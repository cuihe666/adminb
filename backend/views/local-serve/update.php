<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\LocalServe */

$this->title = 'Update Local Serve: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Local Serves', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="local-serve-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
