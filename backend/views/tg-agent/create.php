<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TgAgent */

$this->title = 'Create Tg Agent';
$this->params['breadcrumbs'][] = ['label' => 'Tg Agents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-agent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
