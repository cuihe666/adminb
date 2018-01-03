<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '首页推荐展示';
$this->params['breadcrumbs'][] = $this->title;

?>
<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<div class="booking-index">

    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content" style="margin-bottom: 20px;">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header">
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <table id="example2" class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>序号</th>
                                                    <th>标题</th>
                                                    <th>分类</th>
                                                    <th>排序</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $cateArr = [1 => '旅行', 2 => '特产', 3 => '科技', 4 => '家居'];
                                                $sortArr = [100 => '排序一', 99 => '排序二', 98 => '排序三', 97 => '排序四', 96 => '排序五', 95 => '排序六'];
                                                if ($data):
                                                    foreach ($data as $k => $v):
                                                        ?>
                                                        <tr>
                                                            <td><?= $k + 1 ?></td>
                                                            <td><?= $v['title'] ?></td>
                                                            <td><?php
                                                                if (array_key_exists($v['cid'], $cateArr)) {
                                                                    echo $cateArr[$v['cid']];
                                                                } else {
                                                                    echo '无';
                                                                }

                                                                ?></td>
                                                            <td><?php
                                                                if (array_key_exists($v['sort'], $sortArr)) {
                                                                    echo $sortArr[$v['sort']];
                                                                } else {
                                                                    echo '无';
                                                                }

                                                                ?></td>

                                                        </tr>
                                                    <?php endforeach;
                                                endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>