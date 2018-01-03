<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use backend\assets\HotelAsset;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\HotelSupplierQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '酒店供应商';
$this->params['breadcrumbs'][] = $this->title;
HotelAsset::register($this);
\backend\assets\VueAsset::register($this);
\backend\assets\ScrollAsset::register($this);

?>
<style>
    [v-cloak]{
        display: none;
    }
    .suppy_box>li>label{
        text-align: left;
    }
    .address_box{
        margin-left:3px;
    }
    .address_con>select{
        border:0;
        border:1px solid #ccc;
    }
</style>


<!-- Main content -->
<?= \backend\widgets\ElementAlertWidget::widget() ?>


<section class="content" id="supplier-info" v-cloak>
    <div class="rummery_top">
<!--        公共头部-->
        <?= \backend\widgets\HotelSupplierListWidget::widget([
            'current_url' => Yii::$app->controller->action->id,
            'body' =>Yii::$app->params['hotel_supplier_nav'],
            'query' => Yii::$app->getRequest()->queryString,
        ]) ?>

        <div class="rummery_con">

            <?= Html::beginForm(['hotel-supplier/add?id='.$searchModel->id], 'post', ['class' => 'form-horizontal', 'id' => 'addForm']) ?>
            <div class="rummery_item suppy_detail">
                <ul class="suppy_box" style="padding-left:52px;">
                    <li>
                        <label for="">
                            <span>*</span>供应商名称：
                        </label>
                        <?= Html::activeInput('text', $searchModel, 'name', ['id' => 'suppy_name','@blur' => 'suppy_name()','v-model'=>'name']) ?>
                        <i >请输入完整供应商名称</i>
                    </li>
                    <li class="address clearfix">
                        <label for="" class="fl"><span>*</span>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：</label>
                        <div class="address_box fl">
                            <div class="address_con">
                                <?= Html::activeDropDownList($searchModel,'country',\yii\helpers\ArrayHelper::map(\backend\controllers\HotelSupplierController::getcountry(), 'code', 'name'), [ 'prompt' => '请选择国家', '@change' => "postInfo('country')", "v-model"=>"info.country"]) ?>

                                <select  v-model="info.province" @change="postInfo('province')" >
                                    <option value="" selected>请选择省份</option>
                                    <?php  if(isset($searchModel->province)):  ?>
                                        <option value="<?= $searchModel->province ?>" selected class="select_options"><?= $addressCode[$searchModel->province] ?></option>
                                    <?php  endif ?>
                                    <option v-for="(item,index) in province_list" :value="item.code"  v-html="item.name"></option>
                                </select>

                                <select v-model="info.city">
                                    <option value="">请选择城市</option>
                                    <?php  if(isset($searchModel->city)):  ?>
                                        <option value="<?= $searchModel->city ?>" selected class="select_options"><?= $addressCode[$searchModel->city] ?></option>
                                    <?php  endif ?>
                                    <option v-for="(item,index) in city_list" :value="item.code"  v-html="item.name"></option>
                                </select>

                                <?= Html::activeHiddenInput($searchModel,'province', ["v-model"=>"info.province"]) ?>
                                <?= Html::activeHiddenInput($searchModel,'city', ["v-model"=>"info.city"]) ?>
                            </div>
                            <?= Html::activeInput('test',$searchModel,'address',['class'=>'add_detail','id'=>"add_detail",'@blur' => 'add_detail()','v-model'=>'address','placeholder'=>'请输入详细地址']) ?>
                        </div>
                        <i >请填写地址</i>
                    </li>
                    <li>
                        <label for="">
                            <span>&nbsp;</span>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;编：
                        </label>
                        <?= Html::activeInput('text', $searchModel, 'postcode') ?>
                    <li>
                        <label for="">
                            <span>*</span>供应商类型：
                        </label>
                        <?= Html::activeDropDownList($searchModel,'type',Yii::$app->params['hotel_supplier_type'],['value'=>$searchModel->type]) ?>
                    </li>
                    <li>
                        <label for="">
                            <span></span>供应商品牌：
                        </label>
                        <?= Html::activeInput('text', $searchModel, 'brand',['value'=>$searchModel->brand]) ?>
                    </li>
                    <li>
                        <label for="">
                            <span>*</span>&nbsp;&nbsp;结算周期：
                        </label>
                        <?= Html::activeDropDownList($searchModel,'settle_type',Yii::$app->params['hotel_supplier_settle_type'],['value'=>$searchModel->settle_type]) ?>
                    </li>
                </ul>
                <!--<p class="btn btn-primary add_person">添加联系人</p>
                <div class="contact_box">
                    <dl class="contact_title content_item clearfix">
                        <dd class="type">联系人</dd>
                        <dd class="name">姓名</dd>
                        <dd class="job">职务</dd>
                        <dd class="mobile">手机号码</dd>
                        <dd class="email">E-mail</dd>
                        <dd class="phone">电话</dd>
                        <dd class="operate">操作</dd>
                    </dl>
                    <ul class="content_item content_con clearfix">
                        <li class="li_item"><span>业务联系人</span><input type="text" placeholder="请输入联系人"></li>
                        <li class="li_item"><span>王小毛</span><input type="text" placeholder="请输入姓名"></li>
                        <li class="li_item"><span>店长</span><input type="text" placeholder="请输入职务"></li>
                        <li class="li_item"><span>18888888888</span><input type="text" placeholder="请输入手机号码" maxlength="11"></li>
                        <li class="li_item"><span>asd@qq.com</span><input type="text" placeholder="请输入E-mail"></li>
                        <li class="li_item"><span>010-12345678</span><input type="text" placeholder="请输入电话"></li>
                        <li class="li_item"><div class="op_eds"><p class="edit">编辑</p><p class="save">保存</p></div><p class="delete">删除</p></li>
                    </ul>
                </div>-->
                <?= $this->render('contact.php') ?>
                <div class="suppy_btn">
                    <button class="btn btn-primary suppy_detail_btn">保存并继续</button>
                </div>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>

    <!-- Your Page Content Here -->

</section>


<script type="text/javascript">
    var hotel_supplier = new Vue({
        el: '#supplier-info',
        data: {

            info:{
                country: '<?= $searchModel->country ?>',
                province: '<?= $searchModel->province ?>',
                city: '<?= $searchModel->city ?>'
            },
            province_list: [],
            city_list: [],
            name: '<?= $searchModel->name ?>',
            address: '<?= $searchModel->address ?>',
            name_error: false,
            address_error: false,
            contact_num : 0,

            //下半部分添加联系人
            contant_list : [],
            contant_template : {'id':0,"name":"","type":"","mobile":"","job":"","email":"","landline":"","status":"add"},
            //提交锁问题,防止重复提交
            on_store : false,
            //删除锁,防止无效点击
            on_del : false,
            //防止多次添加多个空数据框
            add_lock : false,
            //定时器
            add_timer: null
        },
        methods: {
            reverseMessage: function () {
                this.message = this.message.split('').reverse().join('')
            },
            postInfo: function(position){
                var _self = this;
                this.$http.post("/hotel-supplier/ajax",{"position": position,'info':this.info},{emulateJSON:true}).then(
                    function (res) {
//                        console.log(res.body);
                        // 处理成功的结果
                        if(res.body.code != 200){
//                            console.log('发送请求内容错误,请联系管理员');
                        }

                        if(res.body.target == 'province'){
                            //--admin:ys time:2017/11/20 content:修复城市选择时，下拉列表出现的bug---
                            $(".select_options").remove();//去除修改原值（省 + 市）
                            _self.province_list = res.body.list;
                            _self.city_list = [];
                            hotel_supplier.info.province = '';//清空vue内存储的省原数据
                            hotel_supplier.info.city = '';//清空vue内存储的市原数据
//                            console.log(_self.province_list);
                        }

                        if(res.body.target == 'city'){
                            //--admin:ys time:2017/11/20 content:修复城市选择时，下拉列表出现的bug---
                            $(".select_options").remove();//去除修改原值（省 + 市）
                            _self.city_list = res.body.list;
                            hotel_supplier.info.city = '';//清空vue内存储的市原数据
//                            console.log(hotel_supplier.info.province);
                        }


                    },function (res) {
                        // 处理失败的结果
                    }
                );

            },
            suppy_name: function () {
                suppy_name();
            },
            add_detail: function(){
                add_detail();
            },

            delConfirm: function(index){
                var _self = this;
                this.$confirm("此操作将永久删除联系人,是否删除?", '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(function () {
                    _self.delItem(index)
                });
            },
            //删除元素
            delItem: function(index){
                if(this.contant_list[index].on_del){
                    console.log('deling wait');
                    return
                }

                var _self = this;
                this.contant_list[index].on_del = true;
                var id = this.contant_list[index].id;
                var url = '/hotel-contact/del';
                this.requestBody(url,{id:id,index:index},function(res){
                    console.log(res);
                    _self.contant_list[index].on_del = false;
                    if(res.data.code == 200){
                        _self.contant_list.splice(index,1);
                        _self.$notify({
                            message: '已删除',
                            type: 'success'
                        })
                    }
                });
            },
            //添加元素
            addItem: function(){
                var arr = this.contant_list;
                var new_arr = {'id':0,"name":"","type":"","mobile":"","job":"","email":"","landline":"","status":"add","on_del":false,"on_store":false};
                if(this.add_lock){
                    return
                }
                res = arr.push(new_arr);
                this.add_lock = true;
                this.contant_list = arr
            },
            //修改元素
            editItem: function(index){
//                console.log('edit')
                this.contant_list[index].status = 'edit'


            },
            //保存添加或者修改
            storeItem: function(index){

                const postData = {
                    body : this.contant_list[index],
                    index : index
                };
                const postUrl = '/hotel-contact/store?theme_id=<?= Yii::$app->request->get('id') ?>&theme=1';
                var _self = this;

                if(this.contant_list[index].on_store){
                    console.log('wait');
                    return ;
                }

                _self.contant_list[index].on_store = true;
                console.log('store');

                //防止重复提交
                _self.add_timer = setTimeout(function(){
                    _self.contant_list[index].on_store = false;
                },1000);
                axios.post(postUrl,postData)
                    .then(function(res){
                        if(res.data.code == 200){
                            //先将当前状态改成 show,防止 loading 和 保存 状态的闪烁
                            _self.contant_list[index].status = "show";
                            _self.$notify({
                                message: '操作成功',
                                type: 'success'
                            })
                            _self.flashList();
                        }else{
                            _self.$notify({
                                message: res.data.message,
                                type: 'warning'
                            })

                        }
                    })
                    .catch(function (error) {
//                        console.log(error)
                    })
            },
            //更新列表
            flashList: function(){
                var _self = this;
                axios.get('/hotel-contact/list?theme_id=<?= Yii::$app->request->get('id') ?>&theme=1').then(function (response) {
                    _self.addStatus(response.data);
                    _self.contant_list = response.data;
                    _self.contact_num = response.data.length;
                    _self.add_lock = false;
                    if(response.data.length == 0){
                        _self.addItem();
                    }
                })
                    .catch(function (error) {
//                        console.log(error);
                    });
            },
            //使用的 http 请求方法
            requestBody: function (url,params,callback) {
                var _self = this;
                axios.post(url,params)
                    .then(function(res){
//                        console.log(res);
                        _self.flashList();
                        callback(res)
                    })
                    .catch(function (error) {
//                        console.log(error)
                    })
            },
            //向列表添加相关的状态
            addStatus: function (data) {
                return data.map(function(item){
                    item.on_store = false;
                    item.on_del = false;
                    return item;
                });
            }

        },
        mounted: function() {
            this.flashList();
        }
    })
</script>