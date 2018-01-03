<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <div style="background:white">
        <section class="content-header">
            <?php if (isset($this->blocks['content-header'])) { ?>
                <h1><?= $this->blocks['content-header'] ?></h1>
            <?php } else { ?>
                <h1>
                    <?php
                    if ($this->title !== null) {
                        echo \yii\helpers\Html::encode($this->title);
                    } else {
                        echo \yii\helpers\Inflector::camel2words(
                            \yii\helpers\Inflector::id2camel($this->context->module->id)
                        );
                        echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                    } ?>
                </h1>
            <?php } ?>

            <?=
            Breadcrumbs::widget(
                [
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]
            ) ?>
        </section>

        <section class="content">
            <?= Alert::widget() ?>

            <?= $content ?>


        </section>
    </div>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 3.0
    </div>
    <strong>Copyright &copy; 2015-2017 棠果旅居.</strong> All rights
    reserved.
</footer>

