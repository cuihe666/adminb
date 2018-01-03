<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') {
    /**
     * Do not use this code in your template. Remove it.
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        backend\assets\AppAsset::register($this);
    }
    //注册 vue-element ui 组件
    \backend\assets\VueAsset::register($this);

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <link rel="shortcut icon" href="/images/favicon.ico" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script>
            var csrf_token =  '<?= Yii::$app->request->csrfToken ?>';
        </script>
        <style>
            [v-cloak]{
                display: none;
            }
            .row-top-10{
                margin-top: 10px;
            }
            .row-top-20{
                margin-top: 20px;
            }
            .row-top-40{
                margin-top: 40px;
            }
            .col-top-5{
                margin-top: 5px;
            }
            input[type="file"]{
                display: none;
            }
            .table-background{
                background: #EFF2F7;
                padding: 0px 10px 5px 5px;
            }
            .text-label {
                text-align: right;
                vertical-align: middle;
                /*float: left;*/
                font-size: 14px;
                color: #48576a;
                line-height: 1;
                padding: 10px 6px 5px 0;
                box-sizing: border-box;
            }
            .text-content{
                text-align: left;
                vertical-align: middle;
                /*float: left;*/
                font-size: 14px;
                color: #48576a;
                line-height: 1;
                padding: 10px 6px 5px 0;
                box-sizing: border-box;
            }
            .invisible{ visibility: hidden}
            .content-padding{
                padding: 10px 6px 5px 0;
            }
            /*提示文本*/
            .tip-text{
                font-size: 0.8em;
                color: #8492A6;
            }
            /*状态文本*/
            .status-text{
                color: #FF4949;
            }
            .table-block{
                margin-bottom: 30px;
                text-align: center;
            }
        </style>
    </head>
    <body class="hold-transition <?= \dmstr\helpers\AdminLteHelper::skinClass() ?> sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
