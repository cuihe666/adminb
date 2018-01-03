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
        app\assets\AppAsset::register($this);
    }
    \backend\assets\SocketAsset::register($this);
    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="edge"/>
        <?= Html::csrfMetaTags() ?>
        <title>后台管理系统</title>
        <?php $this->head() ?>
        <script>
            var csrf_token =  '<?= Yii::$app->request->csrfToken ?>';
        </script>
        <style>
            [v-cloak] {
                display: none;
            }
        </style>
    </head>
    <body class="hold-transition <?= \dmstr\helpers\AdminLteHelper::skinClass() ?> sidebar-mini">
    <?php $this->beginBody() ?>

    <div class="wrapper">
        <div class="notification1 sticky hide">
            <p id="content"></p>
            <a class="close" href="javascript:"> <img
                        src="<?= Yii::$app->request->baseUrl ?>/socket/icon-close.png"/></a>
        </div>
        <script>
            $(document).ready(function () {
                // 连接服务端
                uid = 1;
                if (document.domain == '106.14.16.252' || document.domain == 'admin.tgljweb.com') {
                    var socket = io('http://' + document.domain + ':2120');
                    // 连接后登录
                    socket.on('connect', function () {
                        socket.emit('login', uid);
                    });
                    // 后端推送来消息时
                    socket.on('new_msg', function (msg) {
                        var audioElementHovertree = document.createElement('audio');
                        audioElementHovertree.setAttribute('src', 'http://kf.workerman.net/static/layui/css/modules/layim/voice/default.wav');
                        audioElementHovertree.setAttribute('autoplay', 'autoplay'); //打开自动播放
                        $('#content').html('收到消息：' + msg);
                        $('.notification1.sticky').notify();
                    });
                }
            });
        </script>
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
