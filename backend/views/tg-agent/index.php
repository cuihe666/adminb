<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TgAgentQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tg Agents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-agent-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tg Agent', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'password',
            'code',
            'type',
            // 'status',
            // 'true_name',
            // 'invite_code',
            // 'create_time:datetime',
            // 'email:email',
            // 'last_ip',
            // 'this_ip',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
