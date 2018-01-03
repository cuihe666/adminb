<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaneTicketOrderQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '机票订单详情页';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- 页面css -->
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/cobber.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/amaze/css/amazeui.css">

<script src="<?= Yii::$app->request->baseUrl ?>/common/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/dist/js/app.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>

<style>
    .content > .row > span {
        border: 1px solid #666;
        padding: 5px 10px;
        margin-right: 10px;
    }

    .table td {
        padding-top: 10px !important;
    }

    .table td label {
        margin-right: 20px;
        font-weight: normal;
    }

    .table td label input {
        float: left;
        margin-right: 5px;
    }

    .table td label em {
        margin-top: 2px;
        display: inline-block;
        font-style: normal;
        color: #666;
    }

    .table .acreage label input {
        width: 10%;
        float: inherit;
        text-align: center;
        font-weight: normal;
    }

    .table .acreage label em {
        margin-right: 10px;
    }

    .table .acreage2 label {
        margin-top: 10px;
        display: block;
    }

    .table .acreage2 label input {
        width: 50px;
        text-align: center;
    }

    .table .acreage2 label img {
        width: 25px;
        margin-left: 15px;
    }

    .table .acreage2 label img.shanchu {
        width: 20px;
        margin-left: 20px;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /*地图样式*/

    .left {
        float: left;
    }

    .right {
        float: right;
    }

    .clearfix {
        clear: both;
    }

    .hide {
        display: none;
    }

    /*地图标注文本样式*/
    #tip2 {
        background-color: #fff;
        padding-left: 10px;
        padding-right: 2px;
        font-size: 12px;
        border-radius: 3px;
        overflow: hidden;
        width: 66.67%;
        position: absolute;
        left: 10px;
        top: 10px;
        z-index: 999;
    }

    #tip2 select {
        height: 30px;
        margin-bottom: 10px;
    }

    #tip2 input[type="button"] {
        background-color: #0D9BF2;
        height: 25px;
        text-align: center;
        line-height: 25px;
        color: #fff;
        font-size: 12px;
        padding: 0 10px;
        border-radius: 3px;
        outline: none;
        border: 0;
        cursor: pointer;
    }

    #tip2 input[type="text"] {
        height: 25px;
        border: 1px solid #eee;
        padding-left: 5px;
        border-radius: 3px;
        outline: none;
        width: 100% !important;
        height: 34px;
    }

    #pos {
        background-color: #fff;
        padding-left: 10px;
        padding-right: 10px;
        font-size: 12px;
        border-radius: 3px;
        position: absolute;
        left: 0;
        top: 85px;
    }

    #pos input {
        border: 1px solid #ddd;
        height: 23px;
        border-radius: 3px;
        outline: none;
    }

    #result1 {
        max-height: 300px;
    }

    .amap-info-content {
        text-align: center;
        width: 250px !important;
        padding-left: 0;
        padding-right: 0;
    }

    .amap-logo {
        display: none;
    }

    .amap-copyright {
        display: none !important;
    }

    .cha {
        position: absolute;
        right: 20px;
        top: 20px;
        width: 20px;
    }

    .change_price span {
        background-color: #ccc;
        padding: 5px 10px;
        border-radius: 5px;
        color: #fff;
        margin-bottom: 10px;
        display: inline-block;
        margin-right: 10px;
    }

    .week_label {
        padding-left: 25px;
    }

    .week_label label {
        margin-right: 15px;
        display: inline-block;
    }

    .week_label input {
        float: left;
    }

    .week_label em {
        font-style: normal;
        font-weight: normal;
        display: inline-block;
        margin-left: 5px;
        margin-top: 3px;
    }

    textarea {
        outline: none;
        padding: 5px 0 0 5px;
    }

    /*#myModal6 label {*/
    /*display: inline-block;*/
    /*margin-right: 15px;*/
    /*}*/

    /*#myModal6 label input {*/
    /*float: left;*/
    /*}*/

    /*#myModal6 .row {*/
    /*margin-top: 5px*/
    /*}*/

    /*#myModal6 label em {*/
    /*font-style: normal;*/
    /*color: #999;*/
    /*font-weight: normal;*/
    /*display: inline-block;*/
    /*margin-top: 0px;*/
    /*margin-left: 3px;*/
    /*font-size: 14px;*/
    /*}*/

    /*#myModal6 span {*/
    /*display: inline-block;*/
    /*font-size: 14px;*/
    /*}*/

    .table-responsive > .table td {
        text-align: left !important;
    }

    .gmnoprint {
        display: none;
    }

    #detail_title {
        position: fixed;
        left: 260px;
        top: 130px;
        background-color: #ccc;
        width: 100%;
        padding-top: 0px;
        height: 26px;
        padding-left: 15px;
        box-sizing: border-box;
        z-index: 999;
    }

    #detail_title a {
        color: #fff;
    }

    #detail_title span {
        padding-top: 0;
        margin-right: 5px;
        display: inline-block;
        padding: 0 10px;
        font-size: 14px;
    }

    #detail_title .current_link {
        background-color: #3c8dbc;
        border: none;
    }

    #detail_title .current_link a {
        color: #fff;
    }

    /*后台管理系统实拍图片*/
    .introduce {
        width: 980px;
        margin: 0 auto;
    }

    .lay_03 {
        width: 100%;
    }

    .right_3 {
        width: 767px;
        float: left;
    }

    .caselist_1 {
        clear: both;
        margin-top: 20px;
    }

    .caselist_1 li {
        width: 181px;
        height: 173px;
        float: left;
        padding: 0px 10px;
        text-align: center;
        background: url(<?= Yii::$app->request->baseUrl ?>/images/case_li_bg.png) no-repeat center bottom;
        line-height: 20px;
    }

    .caselist_1 li img {
        margin-bottom: 10px;
    }

    #content {
        margin: 0 auto;
    }

    #tse .clearfix1 div {
        float: left;
        padding: 0 17px;
    }

    .fl {
        float: left;
        padding-left: 10px;
        font-size: 13px;
    }

    .fl2 {
        padding-left: 15px;
        font-size: 13px;
    }

    .checkbox_box > input, .checkbox_box2 > input {
        margin: 4px 5px 0 0;
    }

    ul {
        padding-left: 0;
    }

    .cause_box {
        margin-top: 20px;
    }

    .lable_title {
        display: block;
        font-size: 13px;
        font-weight: normal;
        text-indent: 6px;
        margin-top: 10px;
    }

    .checkbox_box {
        padding-left: 22px;
    }
</style>

<section class="content" id="content" style="width:80%;">
    <div class="form-group" style="padding-top:30px;" id="base_message">
        <input type="hidden" id="house_id" value="<?= $data['house_id'] ?>">
        <div class="row" id="base">
            <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">基本信息</span>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td style="text-align: right!important;width:130px;">订单状态:</td>
                    <td>
                        <b><?= isset($order_info['process_status'])?(Yii::$app->params['plane_ticket_backend_show_status'][$order_info['process_status']]):''?></b>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">订单状态描述:</td>
                    <td>
                        <b><?= isset($order_info['process_status'])?(Yii::$app->params['plane_ticket_order_status_describe'][$order_info['process_status']]):''?></b>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">订单保险状态:</td>
                    <td>
                        <b><?= isset($order_info['id'])?(\backend\controllers\PlaneTicketOrderController::JudgeOrderInsuranceStatus($order_info['id'])):''?></b>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px; color: #00a0e9; cursor:pointer;" class="order_price">订单总价:</td>
                    <td>
                        <span class="order_price" style="color: #00a0e9;cursor:pointer;"><?= isset($order_info['total_amount'])?$order_info['total_amount']:0.00?></span>
                        <span style="color:#ccc; margin-left: 10px;">*点击查看费用明细</span>
                    </td>
                </tr>
                <script>
                    $(".order_price").click(function () {
                        layer.open({
                            type: 1,
                            skin: 'layui-layer-rim', //加上边框
                            area: ['420px', '240px'], //宽高
                            content: '<div style="margin-left:80px;padding-top:30px;">' +
                            '<div>成人</div>' +
                            '<div><span>票价 -------------------- ￥ <?= $emplane_info[0]['pre_price']?> * <?= $order_info['guest_num']?>人</span></div>' +
                            '<div><span>机建+ 燃油--------------￥ <?= ($emplane_info[0]['mb_airport'] + $emplane_info[0]['mb_fuel'])?> * <?= $order_info['guest_num']?>人</span></div>' +
                            '<div><span>行程单-------------------￥ <?= $order_info['express_money']?></span></div>' +
                            '</div>'
                        });
                    });
                </script>
                <tr>
                    <td style="text-align: right!important;width:130px;">订单号:</td>
                    <td>
                        <?= isset($order_info['order_no'])?$order_info['order_no']:''?>
                    </td>
                </tr>
                <tr class="acreage">
                    <td style="text-align: right!important;width:130px;">下单时间:</td>
                    <td>
                        <?= isset($order_info['create_time'])?$order_info['create_time']:''?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group" style="padding-top:30px;" id="price_rule">
        <div class="row">
            <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">航班信息</span>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td style="text-align: right!important; width: 130px;">航空公司:</td>
                    <td>
                        <?= isset($order_info['airline_company_code'])?(\backend\models\PlaneTicketOrder::CompanyName($order_info['airline_company_code'])):''?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">出发城市:</td>
                    <td>
                        <?= isset($order_info['city_start_code'])?(\backend\models\PlaneTicketOrder::CityName($order_info['city_start_code'])):''?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">到达城市:</td>
                    <td>
                        <?= isset($order_info['city_end_code'])?(\backend\models\PlaneTicketOrder::CityName($order_info['city_end_code'])):''?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">起飞机场:</td>
                    <td>
                        <?= isset($order_info['fly_start_airport'])?$order_info['fly_start_airport']:''?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">降落机场:</td>
                    <td>
                        <?= isset($order_info['fly_end_airport'])?$order_info['fly_end_airport']:''?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right!important;width:130px;">起飞时间:</td>
                    <td>
                        <?= isset($order_info['fly_start_time'])?$order_info['fly_start_time']:''?>
                    </td>
                </tr>
                <tr class="acreage acreage2 acreage3 ">
                    <td style="text-align: right!important;width:130px;">到达时间:</td>
                    <td>
                        <?= isset($order_info['fly_end_time'])?$order_info['fly_end_time']:''?>
                    </td>
                </tr>
                <tr class="acreage acreage2 acreage3 ">
                    <td style="text-align: right!important;width:130px;">飞行时长:</td>
                    <td>
                        <?= isset($order_info['fly_start_time'])?(\backend\models\PlaneTicketOrder::TimeLength($order_info['fly_start_time'], $order_info['fly_end_time'])):''?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group" id="ruzhu_note" style="padding-top: 30px;">
        <div class="row">
            <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">乘机人信息</span>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed">
                <tbody>
                <?php if (!empty($emplane_info)) {?>
                    <?php foreach ($emplane_info as $value) {?>
                    <tr>
                        <?php if ($action != 'post') {?>
                            <?php if (!empty($handle_note['refund_insurance_service']) && isset($handle_note['refund_insurance_service'])) {?>
                                <td style="text-align: center!important;width:30px;">
                                    <input type="checkbox" name="refund_insurance_emplane" value="<?= isset($value['id'])?$value['id']:''?>" <?= isset($value['refund_note'])?'':'disabled="disabled"'?>>
                                </td>
                            <?php }?>
                        <?php }?>
                        <td style="text-align: right!important;width:70px;">姓名:</td>
                        <td>
                            <?= isset($value['name'])?$value['name']:''?>
                        </td>
                        <td style="text-align: right!important;width:70px;">类型:</td>
                        <td>
                            <?= empty($value['ticket_type'])?'':Yii::$app->params['emplane_ticket_type'][$value['ticket_type']]?>
                        </td>
                        <td style="text-align: right!important;width:70px;">
                            <?= isset($value['card_type'])?Yii::$app->params['plane_card_type'][$value['card_type']]:''?>:
                        </td>
                        <td>
                            <?= isset($value['card_no'])?$value['card_no']:''?>
                        </td>
                        <?php if (isset($handle_note['reset_ticket_note']) || !empty($handle_note['reset_ticket_note'])) {?>
                            <td style="text-align: right!important;width:70px;">票号:</td>
                            <td>
                                <input type="text" style="width:80px;" MyAttr="<?= $value['id']?>" value="<?= isset($value['ticket_no'])?$value['ticket_no']:''?>">
                                <span style="padding-left: 5px;">
                                    <input type="button" value="回贴票号" class="ticket_code">
                                </span>
                            </td>
                        <?php } else {?>
                            <td style="text-align: right!important;width:70px;">票号:</td>
                            <td>
                                <?= isset($value['ticket_no'])?$value['ticket_no']:''?>
                            </td>
                        <?php }?>
                        <!-- 大交通2.0 添加保险模块 -->
                        <?php if (isset($handle_note['reset_insurance_note']) || !empty($handle_note['reset_insurance_note'])) {?>
                            <td style="text-align: right!important;width:70px;">保单号:</td>
                            <td>
                                <input type="text" style="width:80px;" MyAttr="<?= $value['id']?>" value="<?= isset($value['insurance_no'])?$value['insurance_no']:''?>">
                                <span style="padding-left: 5px;">
                                    <input type="button" value="回贴保号" class="insurance_code">
                                </span>
                            </td>
                        <?php } else {?>
                            <td style="text-align: right!important;width:70px;">保单号:</td>
                            <td>
                                <?= isset($value['insurance_no']) ? $value['insurance_no'] : ''?>
                            </td>
                        <?php }?>
                    </tr>
                    <?php }?>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        //回贴票号
        $(".ticket_code").click(function () {
            var code = $(this).parent().parent().children("input:first-child").val();
            var id = $(this).parent().parent().children("input:first-child").attr("MyAttr");
            layer.confirm('请与研发人员核实后在执行此操作！',{
                btn:['继续执行', '取消']
            },function () {
                $.post("<?= \yii\helpers\Url::to(['plane-ticket-order/reset-ticket-code'])?>",{
                    "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
                    data:{code:code, id:id}
                }, function (data) {
                    if (data == 'success') {
                        location.reload();
                    } else {
                        layer.alert(data);
                    }
                });
                layer.closeAll();
            });
        });
        //回帖保单号
        $(".insurance_code").click(function () {
            var code = $(this).parent().parent().children("input:first-child").val();
            var id = $(this).parent().parent().children("input:first-child").attr("MyAttr");
            layer.confirm('您确定执行此操作吗？',{
                btn:['确定', '取消']
            },function () {
                $.post("<?= \yii\helpers\Url::to(['plane-ticket-order/reset-insurance-code'])?>",{
                    "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
                    data:{code:code, id:id}
                }, function (data) {
                    if (data == 'success') {
                        location.reload();
                    } else {
                        layer.alert(data);
                    }
                });
                layer.closeAll();
            });
        });
    </script>
    <div class="form-group" id="ruzhu_note">
        <div class="table-responsive">
            <table class="table table-condensed">
                <tbody>
                    <tr>
                        <td style="text-align: right!important;width:130px;color: red">联系人:</td>
                        <td>
                            <span style="color: red"><?= isset($order_info['contacts'])?$order_info['contacts']:''?></span>
                        </td>
                        <td style="text-align: right!important;width:130px;color: red">联系电话:</td>
                        <td>
                            <span style="color: red"><?= isset($order_info['contacts_phone'])?$order_info['contacts_phone']:''?></span>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right!important;width:130px;">行程单邮寄地址:</td>
                        <td>
                            <?php if (isset($handle_note['post_reset_note']) && !empty($handle_note['post_reset_note'])) {?>
                                <input type="text" disabled="disabled" style="width:400px;" id="post_address" value="<?= isset($order_info['express_addressee_address'])?$order_info['express_addressee_address']:''?>">
                            <?php } else {?>
                                <?= isset($order_info['express_addressee_address'])?$order_info['express_addressee_address']:''?>
                            <?php }?>
                        </td>
                        <td>
                            <span style="margin-left: 35px;">
                                <input type="hidden" id="order_id" value="<?= isset($order_info['id'])?$order_info['id']:''?>">
                                <input type="button" value="保存" id="reset_post" style="display: none;">
                                <input type="button" value="修改" id="xiugai" <?= (isset($handle_note['post_reset_note']) && !empty($handle_note['post_reset_note']))?'':'style="display:none"'?>>
                            </span>
                        </td>
                        <td>

                        </td>
                    </tr>

                    <!-- 回贴邮寄单号/公司 ↓-->
                    <?php if ($action == 'post') {?>
                    <tr>
                        <td style="text-align: right!important;width:130px;">快递公司:</td>
                        <td colspan="3">
                            <span>
                                <select id="express_list" style="width: 170px;">
                                    <option value="">请选择快递公司</option>
                                    <?php if (!empty($express_list)) {?>
                                        <?php foreach ($express_list as $k => $val) {?>
                                            <?php if ($k == $order_info['express_id']) {?>
                                                <option value="<?= $k?>" selected="selected"><?= $val?></option>
                                            <?php } else {?>
                                                <option value="<?= $k?>"><?= $val?></option>
                                            <?php }?>
                                        <?php }?>
                                    <?php }?>
                                </select>
                            </span>
                        </td>
                    </tr>
                        <tr>
                            <td style="text-align: right!important;width:130px;">快递单号:</td>
                            <td colspan="3">
                            <span>
                                <input type="text" id="express_code" style="width: 400px;" <?= (isset($handle_note['post_reset_note']) && !empty($handle_note['post_reset_note']))?'':'disabled=disabled'?> value="<?= isset($order_info['express_code'])?$order_info['express_code']:'';?>">
                            </span>
                            </td>
                        </tr>
                    <?php }?>
                    <!-- ↑ -->

                </tbody>
            </table>
        </div>
    </div>
    <script>
        $("#xiugai").click(function () {
            $('#post_address').removeAttr("disabled");
            $("#reset_post").show();
            $("#xiugai").hide();
        });
        $("#reset_post").click(function () {
            var address = $("#post_address").val();
            var id = $("#order_id").val();
            layer.confirm('您确定修改邮寄地址吗？',{
                btn:['确定', '取消']
            },function () {
                $.post("<?= \yii\helpers\Url::to(['plane-ticket-order/reset-address'])?>",{
                    "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
                    data:{id:id, address:address}
                },function (data) {
                    if (data == 'success') {
                        location.reload();
                    } else {
                        layer.alert('修改失败！');
                    }
                });
                layer.closeAll();
            },function () {
                $('#post_address').attr("disabled","disabled");
                var address = "<?= isset($order_info['express_addressee_address'])?$order_info['express_addressee_address']:''?>";
                $('#post_address').val(address);
                $("#reset_post").hide();
                $("#xiugai").show();
            });
        });
    </script>
    <div class="form-group" id="ruzhu_note" style="padding-top: 30px;">
        <div class="row">
            <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">退款历史记录</span>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed">
                <tbody>
                <?php if (!empty($emplane_info)) {?>
                    <?php foreach ($emplane_info as $value) {?>
                        <?php if ($value['refund_ticket_status'] != 0) {?>
                        <tr>
                            <td style="text-align: right!important;width:45px;">姓名:</td>
                            <td>
                                <?= isset($value['name'])?$value['name']:''?>
                            </td>
                            <td style="text-align: right!important;width:45px;">类型:</td>
                            <td>
                                <?= empty($value['ticket_type'])?'':Yii::$app->params['emplane_ticket_type'][$value['ticket_type']]?>
                            </td>
                            <td style="text-align: right!important;width:70px;">
                                <?= isset($value['card_type'])?Yii::$app->params['plane_card_type'][$value['card_type']]:''?>:
                            </td>
                            <td>
                                <?= isset($value['card_no'])?$value['card_no']:''?>
                            </td>
                            <td style="text-align: right!important;width:45px;">票号:</td>
                            <td>
                                <?= isset($value['ticket_no'])?$value['ticket_no']:''?>
                            </td>
                            <td style="text-align: right!important;width:100px;">申请退票时间:</td>
                            <td>
                                <?= isset($value['refund_ticket_id'])?(\backend\controllers\PlaneTicketOrderController::ApplyPlaneTicketRefundTime($value['refund_ticket_id'])):''?>
                            </td>
                            <td style="text-align: right!important;width:100px;">退款完成时间:</td>
                            <td>
                                <?= isset($value['refund_ticket_id'])?(\backend\controllers\PlaneTicketOrderController::PlaneTicketRefundSuccessTime($value['refund_ticket_id'])):''?>
                            </td>
                        </tr>
                        <?php }?>
                    <?php }?>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group" id="ruzhu_note" style="padding-top: 30px;">
        <div class="row">
            <span style="background-color:#3c8dbc;color:#fff;padding: 5px 10px;">支付交易记录</span>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed">
                <tbody>
                <?php if (!empty($plane_order_pay_note)) {?>
                    <?php foreach ($plane_order_pay_note as $value) {?>
                        <tr>
                            <td style="text-align: right!important;width:90px;">交易流水号:</td>
                            <td>
                                <?= isset($value['trade_no'])?$value['trade_no']:''?>
                            </td>
                            <td style="text-align: right!important;width:90px;">支付通道:</td>
                            <td>
                                <?= isset($order_info['pay_platform'])?Yii::$app->params['plane_pay_platform'][$order_info['pay_platform']]:''?>
                            </td>
                            <td style="text-align: right!important;width:50px;">
                                类型:
                            </td>
                            <td>
                                <?= isset($value['type'])?$value['type']:''?>
                            </td>
                            <td style="text-align: right!important;width:50px;">金额:</td>
                            <td>
                                <?= isset($value['price'])?$value['price']:''?>
                            </td>
                            <td style="text-align: right!important;width:90px;">交易时间:</td>
                            <td>
                                <?= isset($value['time'])?$value['time']:''?>
                            </td>
                            <td style="text-align: right!important;width:50px;">商家:</td>
                            <td>
                                <?= isset($value['supplier_name'])?$value['supplier_name']:''?>
                            </td>
                            <td style="text-align: right!important;width:50px;">状态:</td>
                            <td>
                                <?= isset($value['status'])?$value['status']:''?>
                            </td>
                        </tr>
                    <?php }?>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group" id="ruzhu_note" style="padding-top: 30px;">
        <div class="row">
            <span>
                <input type="hidden" id="action" value="<?= isset($action)?$action:''?>">
                <a href="javascript:history.go(-1)"><input type="button" value="返回" style="width:80px; height:35px;" id="go_back" class="btn btn-sm btn-primary"></a>
            </span>
            <?php if (!empty($handle_note['refund_ticket_note']) && isset($handle_note['refund_ticket_note'])) {?>
                <span style="margin-left: 15px;">
                    <input type="button" value="人工退款" style="width:80px; height:35px;" id="refund_price" class="btn btn-sm btn-primary">
                </span>
            <?php }?>
            <?php if (!empty($handle_note['artificial_ticket_note']) && isset($handle_note['artificial_ticket_note'])) {?>
                <span style="margin-left: 15px;">
                    <input type="button" value="人工补票" style="width:80px; height:35px;" id="person_add_ticket" class="btn btn-sm btn-primary">
                </span>
            <?php }?>
            <!-- 酒店1.1 人工退保 -->
            <?php if ($action != 'post') {?>
                <?php if (!empty($handle_note['refund_insurance_service']) && isset($handle_note['refund_insurance_service'])) {?>
                    <span style="margin-left: 15px;">
                        <input type="button" value="人工退保" style="width:80px; height:35px;" id="refund_insurance" class="btn btn-sm btn-primary">
                    </span>
                <?php }?>
            <?php }?>
            <?php if ($action == 'post') {?>

                <span style="margin-left: 15px; <?= (isset($handle_note['post_reset_note']) && !empty($handle_note['post_reset_note']))?'':'display:none'?>">
                    <input type="button" value="贴快递单号" style="width:80px; height:35px;" id="reset_post_code" class="btn btn-sm btn-primary">
                </span>
            <?php }?>
            <!-- 酒店1.1 补出保 -->
            <?php if (!empty($handle_note['add_insurance_code']) && isset($handle_note['add_insurance_code'])) {?>
                <span style="margin-left: 15px;">
                    <input type="button" value="补出保" style="width:80px; height:35px;" id="add_insurance_service" class="btn btn-sm btn-primary">
                </span>
            <?php }?>
            <!-- 酒店1.1 人工退保 -->
<!--            --><?php //if (!empty($handle_note['refund_insurance_service']) && isset($handle_note['refund_insurance_service'])) {?>
<!--                <span style="margin-left: 15px;">-->
<!--                    <input type="button" value="人工退保" style="width:80px; height:35px;" id="refund_insurance" class="btn btn-sm btn-primary">-->
<!--                </span>-->
<!--            --><?php //}?>
        </div>
    </div>
</section>
<!-- 退保确认弹窗 -->
<div class="modal fade" id="refund_comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">确认对以下用户执行退保操作吗：</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <div class="form-group" id="ruzhu_note">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <tbody id="add_model"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary confirm_save">确认</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //唤起模态框< 酒店2.0 --人工退保部分 >
    $("#refund_insurance").click(function () {
        var id_array = new Array();
        $('input[name="refund_insurance_emplane"]:checked').each(function(){
            id_array.push($(this).val());//向数组中添加元素
        });
        if (id_array.length <= 0) {//未选取投保人
            layer.alert('请选勾选退保人！');
            return false;
        }
        var id_str = id_array.join(',');//将数组元素连接起来以构建一个字符串
        $.post("<?= \yii\helpers\Url::to(['plane-ticket-order/refund-person-list'])?>",{
            "<?= Yii::$app->request->csrfParam?>":"<?= Yii::$app->request->getCsrfToken()?>",
            data:{id_str:id_str},
            dataType:'json'
        },function (data) {
            var info = jQuery.parseJSON(data);
            $("#add_model").html('');
            for (var i = 0; i < info.length; i++) {
                $("#add_model").append('<tr><td style="text-align: right!important;width:70px;">姓名:</td>' +
                    '<td>'+ info[i].name +'</td>' +
                    '<td style="text-align: right!important;width:70px;">票号:</td>' +
                    '<td>'+ info[i].ticket_no +'</td>' +
                    '<td style="text-align: right!important;width:70px;">保单号:</td>' +
                    '<td>'+ info[i].insurance_no +'</td></tr>');
            }
            $('#refund_comment').modal();
        });
    });
    //人工补票
    $("#person_add_ticket").click(function () {
        var id = $("#order_id").val();
        layer.confirm("您确认人工补票吗？",{
            btn:['确定', '取消']
        },function () {
            $('#person_add_ticket').attr("disabled",true);
            layer.closeAll();
            $.post("<?= \yii\helpers\Url::to(['plane-ticket-order/person-ticket'])?>", {
                "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
                data:{id:id},
                dataType:'json'
            }, function (data) {
                $('#person_add_ticket').attr("disabled",false);
                var info = jQuery.parseJSON(data);
                if (info.code == 0) {
                    layer.alert('操作成功!', {
                        icon: 1,
                        skin: 'layer-ext-moon'
                    }, function () {
                        location.reload();
                    });
                } else {
                    layer.alert(info.msg);
                }
            });
        });
    });
    <!-- 调用退保 酒店2.0启用 -->
    $(".confirm_save").click(function (){
        var id = $("#order_id").val();
        var id_array = new Array();
        $('input[name="refund_insurance_emplane"]:checked').each(function(){
            id_array.push($(this).val());//向数组中添加元素（乘机人ID）
        });
        if (id_array.length <= 0) {
            layer.alert('请选择投保人！');
            return false;
        }
        var id_str = id_array.join(',');//将数组元素连接起来以构建一个字符串
        console.log(id_str);
        $('.confirm_save').attr("disabled",true);//锁死确定按钮
        $.post("<?= \yii\helpers\Url::to(['plane-ticket-order/refund-insurance-service'])?>",{
            "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
            data:{id:id, id_str:id_str},
            dataType:'json'
        },function (data) {
            $('.confirm_save').attr("disabled",false);//打开确定按钮
            var info = jQuery.parseJSON(data);
            if (info.code == 0) {
//                    console.log(info.data);
                layer.alert(info.msg, {
                    icon: 1,
                    skin: 'layer-ext-moon'
                }, function () {
                    location.reload();
                });
            } else {
                layer.alert(info.msg);
            }
        });
    });
    //退款操作
    $("#refund_price").click(function () {
        var id = $("#order_id").val();
        layer.confirm('您确定要退款吗？',{
            btn:['确定', '取消']
        },function () {
            $('#refund_price').attr("disabled",true);
            layer.closeAll();
            $.post("<?=\yii\helpers\Url::to(['plane-ticket-order/refund-order-handle'])?>", {
                "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
                data:{id:id},
                dataType:'json'
            },function (data) {
                $('#refund_price').attr("disabled",false);
                var info = jQuery.parseJSON(data);
                if (info.code == 0) {
                    layer.alert('操作成功!', {
                        icon: 1,
                        skin: 'layer-ext-moon'
                    }, function () {
                        location.reload();
                    });
                } else {
                    layer.alert(info.msg);
                }
            });
        });
    });
    //贴快递单号
    $("#reset_post_code").click(function () {
        var id = $("#order_id").val();
        var company = $("#express_list").val();
        var code = $("#express_code").val();
        if (company == '') {
            layer.alert('请选择快递公司！');
            return false;
        }
        if (code == '') {
            layer.alert('请填写快递单号！');
            return false;
        }
        layer.confirm('确认贴快递单号，邮寄行程单？',{
            btn:['确认', '取消']
        }, function () {
            layer.closeAll();
            $.post("<?= \yii\helpers\Url::to(['plane-ticket-order/reset-post'])?>", {
                "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
                data:{id:id, company:company, code:code},
                dataType:'json'
            }, function (data) {
                if (data == 'success') {
                    layer.alert('修改成功');
                    location.href = '<?= \yii\helpers\Url::to(['plane-ticket-order/post'])?>';
                } else {
                    layer.alert(data);
                }
            });
        });
    });
    <!-- 大交通2.0 人工补出保 -->
    $("#add_insurance_service").click(function () {
        var id = $("#order_id").val();
        layer.confirm("您确认人工补出保吗？",{
            btn:['确定', '取消']
        },function () {
            $('#add_insurance_service').attr("disabled",true);
            layer.closeAll();
            $.post("<?= \yii\helpers\Url::to(['plane-ticket-order/add-insurance-service'])?>", {
                "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
                data:{id:id},
                dataType:'json'
            }, function (data) {
                $('#add_insurance_service').attr("disabled",false);
                var info = jQuery.parseJSON(data);
                if (info.code == 0) {
//                    console.log(info.data);
                    layer.alert(info.msg, {
                        icon: 1,
                        skin: 'layer-ext-moon'
                    }, function () {
                        location.reload();
                    });
                } else {
                    layer.alert(info.msg);
                }
            });
        });
    });
</script>


