<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\LocalServe */

$this->title = 'Create Local Serve';
$this->params['breadcrumbs'][] = ['label' => 'Local Serves', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="local-serve-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
