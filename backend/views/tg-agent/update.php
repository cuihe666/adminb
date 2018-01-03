<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TgAgent */

$this->title = 'Update Tg Agent: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tg Agents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tg-agent-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
