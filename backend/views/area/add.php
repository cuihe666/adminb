<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;

$this->title = '新增区域';
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<div class="booking-index">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="search-box clearfix">
                            <div class="search-item">
                                <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                    <select class="form-control province" name="province" onchange="city(this)">
                                        <option value="0">请选择省</option>
                                        <?php foreach ($province as $k => $v): ?>
                                            <option value="<?php echo $v['code']; ?>"
                                                    code="<?php echo $v['code']; ?>"><?php echo $v['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="search-item">
                                <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                    <select class="form-control city" name="city" id="bank_city">
                                        <option value="0">请选择城市</option>
                                    </select>
                                </div>
                            </div>
                            <div class="search-item">
                                <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                    <input class="form-control area" value="" type="text" name="area"
                                           placeholder="请输入区域名">
                                </div>
                            </div>
                            <div class="search-item">
                                <div class="input-group" style="width: 120px; float: left;margin-right: 18px;">
                                    <button type="button" class="btn btn-primary area-add">提交</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function city(obj) {
        $.get("<?=\yii\helpers\Url::to(["house-details/getcity"])?>" + "&id=" + $(obj).val(), function (data) {
            $("#bank_city").html(data);
        });

    }

    $(function () {
        $('.area-add').click(function () {
            var province = $('.province option:selected').val();
            var city = $('.city option:selected').val();
            var area = $('.area').val();
            if (province == 0 || city == 0 || area == '') {
                layer.alert('信息不完整', {icon: 2});
                return;
            }
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['add']) ?>",
                data: {city: city, area: area},
                success: function (data) {
                    if (data == -1) {
                        layer.alert('该城市下已经有该区域', {icon: 2});
                    }
                    if (data == 0) {
                        layer.alert('添加失败', {icon: 2});
                    }
                    if (data == 1) {
                        layer.alert('添加成功', {icon: 1});
                    }
                }
            })
        })
    })
</script>
