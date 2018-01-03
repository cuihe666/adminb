                                                                                                                                                                                                                            <?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\HotelOrder */

$this->title = 'Create Hotel Order';
$this->params['breadcrumbs'][] = ['label' => 'Hotel Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
