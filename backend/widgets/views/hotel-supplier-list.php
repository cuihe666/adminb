<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/4/18
 * Time: 下午4:04
 */
use yii\helpers\Url;
?>


<ul class="rummery_tab clearfix rummery_tab_li">

<!--    <li>关联酒店</li>-->
<!--    <li class="col-sm-8">财务结算</li>-->

    <?php foreach ($body as $item): ?>
        <li <?php if($current_url == $item['route']): ?> class="current" <?php endif ?>  onclick="location.href='<?= Url::toRoute($item['route']).$query ?>'"> <?= $item['value'] ?></li>
    <?php endforeach  ?>
</ul>
