<!DOCTYPE html>
<html lang="en">
<head>
    <title>订单管理-旅行-订单详情</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/webcaiwu/css/settlement.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/webcaiwu/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/My97DatePicker/WdatePicker.js"></script>

</head>
<body>
<!--开始-->
    <div style="margin-bottom: 20px">
        <strong style="font-size:22px;">订单详情</strong>
        <a href="<?php echo \yii\helpers\Url::to(['settlement/dd_lx_abnormal_ycl']) ?>">返回</a>
    </div>
    <div class="form_group">
        <table class="table table-bordered">
            <tr>
                <td>支付方式</td>
                <td>微信支付</td>
                <td>支付状态</td>
                <td>已支付</td>
            </tr>
            <tr>
                <td>售价</td>
                <td><b>¥99.00</b></td>
                <td>优惠券抵扣</td>
                <td><b>-¥10.00</b></td>
            </tr>
            <tr>
                <td>实付金额</td>
                <td>
                    <span style="color:red">¥89.00</span>
                </td>
                <td>订单类型</td>
                <td>即时确认</td>
            </tr>
        </table>
        <table class="table table-bordered">
            <tr>
                <td>棠果收入</td>
                <td>-¥0.10</td>
                <td>达人收入</td>
                <td>¥89.10</td>
            </tr>
        </table>
        <table class="table table-bordered">
            <tr>
                <td>联系人姓名</td>
                <td>玩大锤</td>
                <td>联系人手机</td>
                <td>44444454444</td>
            </tr>
            <tr>
                <td>出行人1</td>
                <td>张三</td>
                <td>证件号1</td>
                <td>777454415512254874</td>
            </tr>
        </table>
        <table class="table table-bordered">
            <tr>
                <td>商品ID</td>
                <td>12345</td>
                <td>商品名称</td>
                <td>一次解密老北京文化的行走</td>
            </tr>
            <tr>
                <td>商品品类</td>
                <td>当地向导</td>
                <td>服务城市</td>
                <td>北京</td>
            </tr>
            <tr>
                <td>主题标签</td>
                <td>人文历史 世界遗产</td>
                <td>达人姓名</td>
                <td>黎明</td>
            </tr>
            <tr>
                <td>达人手机号</td>
                <td>4545441</td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table class="table table-bordered">
            <tr>
                <td>订单状态</td>
                <td>退款中</td>
                <td>下单时间</td>
                <td>2017-02-15 23:15:00</td>
            </tr>
            <tr>
                <td>订单号</td>
                <td>4545447878</td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <button class="btn btn-primary">返回</button>
    </div>
<!--结束-->
</body>
</html>