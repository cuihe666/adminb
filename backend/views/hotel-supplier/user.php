<?php
/**
 * Created by PhpStorm.
 * User: ys
 * Date: 2017/7/24
 * Time: 下午15:45
 */
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = '用户管理';
\backend\assets\ScrollAsset::register($this);

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn', 'header' => '序号'],
    'mobile',//'账号（手机号码）'
    'name',//姓名
    'job',//职务
    'email',//E-mail
    'last_time',//最后登录时间
    [
        'label' => '状态',
        'value' => function($model){
            return Yii::$app->params['hotel_login_status'][$model->status];
        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => '操作',
        'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {edit} {delete} {reset}
                                </div> ',
        'buttons' => [
            'edit' => function ($url, $model, $key) {
                return Html::a('编辑', "#", ['class' => 'delnode btn btn-primary btn-sm edit_user', 'style' => 'color:white', 'MyAttr'=> $model->id]);
            },
            'delete' => function ($url, $model, $key) {
                return Html::a('删除', "#", ['class' => 'delnode btn btn-primary btn-sm delete_user', 'style' => 'color:white', 'MyAttr'=> $model->id]);
            },
            'reset' => function ($url, $model, $key) {
                return Html::a('重置密码', "#", ['class' => 'delnode btn btn-primary btn-sm reset_pwd', 'style' => 'color:white', 'MyAttr'=> $model->id]);
            },
        ]
    ],
];


\backend\assets\HotelAsset::register($this);
?>
<?= \backend\widgets\ElementAlertWidget::widget() ?>
<script src="<?= Yii::$app->request->baseUrl ?>/common/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl?>/layer/layer.js"></script>
<style>
    #user_add{
        background-color: #00aa00;
        color: white;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
        margin: 0;
    }
    input[type="number"]{-moz-appearance:textfield;}
</style>
<section class="content" >
    <div class="rummery_top">
        <?= \backend\widgets\HotelSupplierListWidget::widget([
            'current_url' => Yii::$app->controller->action->id,
            'body' =>Yii::$app->params['hotel_supplier_nav'],
            'query' => Yii::$app->getRequest()->queryString,
        ]) ?>
    </div>


    <div class="hotel-supplier-index">

        <div class="wrapper-content animated fadeInRight">
            <div class="row">
                <input type="hidden" name="" id="supplier_id" value="<?= isset($supplier_id)?$supplier_id:''?>">
                <div class="col-sm-12">

                </div>
            </div>
        </div>

        <?php
        echo Html::a('添加Ebooking管理账号', '#', ['class' => 'btn user_add_model', 'id' => 'user_add'])
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'pager' => [
                'firstPageLabel' => '首页',
                'lastPageLabel' => '尾页',
            ],
        ]); ?>
    </div>
</section>
<!-- 添加用户 -->

<div class="modal fade" id="user_add_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">请输入用户信息</h4>
            </div>
            <div class="modal-body">

                <div class="form-group" style="margin-left: 70px;">
                    <input type="number" id="mobile" class='form-control input' style="width:400px" placeholder='请输入账号（手机号）'><br>
                    <input type="text" id="username" class='form-control input' style="width:400px" placeholder='请输入姓名'><br>
                    <input type="text" id="job" class='form-control input' style="width:400px" placeholder='请输入职务'><br>
                    <input type="email" id="email" class='form-control input' style="width:400px" placeholder='请输入邮箱'><br>
                    <select name="" id="status" class='form-control' style="width:400px">
                        <option value="0" selected="selected">开启</option>
                        <option value="1">关闭</option>
                        </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary user_add">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- 编辑用户 -->
<div class="modal fade" id="user_edit_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">请编辑用户信息</h4>
            </div>
            <div class="modal-body">

                <div class="form-group" style="margin-left: 70px;">
                    <input type="hidden" id="edit_id" name="">
                    <input type="number" id="edit_mobile" class='form-control input' style="width:400px" placeholder='请输入账号（手机号）'><br>
                    <input type="text" id="edit_username" class='form-control input' style="width:400px" placeholder='请输入姓名'><br>
                    <input type="text" id="edit_job" class='form-control input' style="width:400px" placeholder='请输入职务'><br>
                    <input type="email" id="edit_email" class='form-control input' style="width:400px" placeholder='请输入邮箱'><br>
                    <select name="" id="edit_status" class='form-control' style="width:400px">
                        <option value="0" selected="selected">开启</option>
                        <option value="1">关闭</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary user_edit">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //添加model
    $('#user_add').click(function () {
        $('#user_add_model').modal();
    });
    //编辑model
    $(".edit_user").click(function () {
        var id = $(this).attr("MyAttr");
        edit_data(id);
    });
    var mobilereg =  /^(1)[0-9]{10}$/; //手机号
    var emailreg =  /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/; //邮箱
    var namereg = /^[\u4E00-\u9FA5]{1,6}$/;//姓名
    //添加用户
    $(".user_add").click(function(){
        if (!mobilereg.test($("#mobile").val())) {
            layer.alert('手机号格式错误');
            return false;
        } else if (!namereg.test($("#username").val())) {
            layer.alert('姓名由1~6位中文组成');
            return false;
        } else if ($("#job").val() == '') {
            layer.alert('职务不能为空');
            return false;
        } else if(!emailreg.test($("#email").val())) {
            layer.alert('邮箱格式错误');
            return false;
        }
        data_submit();
    });
    //添加-用户
    function data_submit()
    {
        var mobile = $("#mobile").val();
        var name = $("#username").val();
        var job = $("#job").val();
        var email = $("#email").val();
        var status = $("#status").val();
        var supplier_id = $("#supplier_id").val();
        $.post("<?= \yii\helpers\Url::to(['hotel-supplier/user-add'])?>",{
            "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
            data:{mobile:mobile, job:job, name:name, email:email, status:status, supplier_id:supplier_id},
        }, function (data) {
            if (data == 'success') {
                location.reload();
            } else {
                layer.msg(data, {time:2000});
            }
        });
    }
    //删除
    $(".delete_user").click(function () {
        var id = $(this).attr("MyAttr");
        layer.confirm('您确定要删除用户吗？', {
            btn:['确定', '取消']
        }, function () {
            $.post("<?= \yii\helpers\Url::to(['hotel-supplier/del-user'])?>", {
                "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
                data: {id:id}
            }, function (data) {
                if (data == 'success') {
                    location.reload();
                } else {
                    layer.msg(data, {time:2000});
                }
            });
        });
    });
    //重置密码
    $(".reset_pwd").click(function () {
        var id = $(this).attr("MyAttr");
        layer.confirm('您确定要重置密码吗？', {
            btn: ['确定', '取消']
        }, function () {
            $.post("<?= \yii\helpers\Url::to(['hotel-supplier/reset-pwd'])?>", {
                "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
                data: {id:id}
            }, function (data) {
                if (data == 'success') {
                    layer.msg('修改成功！', {time:2000});
                } else {
                    layer.msg(data, {time:2000});
                }
            });
        });
    });
    //编辑用户，获取数据
    function edit_data(id) {
        $.post("<?= \yii\helpers\Url::to(['hotel-supplier/edit-data'])?>", {
            "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
            dataType: 'json',
            data: {id: id}
        }, function (data) {
            var info = jQuery.parseJSON(data);
            if (info.code == 'success') {
                $("#edit_mobile").val(info.mobile);
                $("#edit_username").val(info.name);
                $("#edit_job").val(info.job);
                $("#edit_email").val(info.email);
                $("#edit_status").val(info.status);
                $("#edit_id").val(id);
                $('#user_edit_model').modal();
            } else {
                layer.msg(info, {time:2000});
            }
        });
    };
    //编辑-用户
    $(".user_edit").click(function () {
        var id = $("#edit_id").val();
        var mobile = $("#edit_mobile").val();
        var name = $("#edit_username").val();
        var job = $("#edit_job").val();
        var email = $("#edit_email").val();
        var status = $("#edit_status").val();

        if (!mobilereg.test(mobile)) {
            layer.alert('手机号格式错误');
            return false;
        } else if (!namereg.test(name)) {
            layer.alert('姓名由1~6位中文组成');
            return false;
        } else if ($("#edit_job").val() == '') {
            layer.alert('职务不能为空');
            return false;
        } else if(!emailreg.test(email)) {
            layer.alert('邮箱格式错误');
            return false;
        }
        $.post("<?= \yii\helpers\Url::to(['hotel-supplier/edit-user'])?>", {
            "<?= Yii::$app->request->csrfParam?>": "<?= Yii::$app->request->getCsrfToken()?>",
            data:{mobile:mobile, job:job, name:name, email:email, status:status, id:id}
        }, function (data) {
            if (data == 'success') {
                location.reload();
            } else {
                layer.msg(data, {time:2000});
            }
        });
    });
</script>