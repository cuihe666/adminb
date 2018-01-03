<?php

$this->title = '';
/*$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nofind">
    <div class="img_status">
        <img src="<?= Yii::$app->request->baseUrl ?>/dist/images/tg_fail.png"/>
    </div>
    <h1>页面找不到了</h1>
    <p>非常抱歉</p>
    <p>您所访问的页面不存在，或者已经被删除 </p>
</div>

<style>
    .nofind {}
    .img_status {width: 230px;height: 220px;margin: 0 auto;}
    .img_status>img {width: 100%;}
    .nofind>p {text-align: center;font-size: 16px;line-height: 30px;}
    .nofind>h1 {text-align: center;font-size: 16px;line-height: 20px;}
</style>