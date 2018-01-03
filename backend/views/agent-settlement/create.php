<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AgentSettlement */

$this->title = 'Create Agent Settlement';
$this->params['breadcrumbs'][] = ['label' => 'Agent Settlements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-settlement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
