<?php

use yii\helpers\Html;

\backend\assets\VueAsset::register($this);
$this->title = 'banner添加';


$default_goods = \backend\controllers\ShopBannerController::getGoods(2);

$default_goods = json_encode($default_goods);


/* @var $this yii\web\View */
/* @var $model backend\models\ShopGoods */
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<!--<el-form :inline="true" ref="ruleForm" class="demo-form-inline" label-width="100px">-->
<el-form :model="ruleForm" :label-position="labelPosition" :inline="true" :rules="rules" ref="ruleForm"
         label-width="100px" class="demo-ruleForm">
    <!--是否为首页-->
    <el-form-item label="发布位置" prop="is_index">
        <el-select v-model="ruleForm.is_index">
            <el-option
                    v-for="item in is_indexOptions"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
            </el-option>

        </el-select>
    </el-form-item>
    <br>


    <el-form-item label="商品名称" prop="goods_id" >

        <el-select
                v-model="ruleForm.goods_id"
                filterable
                remote
                placeholder="请输入"
                :remote-method="remoteMethod"
                :loading="loading">
            <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
            </el-option>
        </el-select>
    </el-form-item>

    <br>
    <el-form-item label=" ">
        <el-button type="primary" @click="submitForm('ruleForm')">提交</el-button>
    </el-form-item>


</el-form>


<script>


    var options = <?= $default_goods ?>;
    var data = {

        labelPosition: 'left',
        options: [],

        is_indexOptions:[

            {value: '0', label: '内页'},
            {value: '1', label: '首页'},


        ],
        type_Options:[

            {value: '1', label: '商品'},
            {value: '2', label: '列表'},


        ],

        ruleForm: {

            name: '',
            pic: '',
            is_index: '',
            type: '',
            category: '',
            goods_id: '',
        },


        list: [],
        loading: false,
        states: options,




        rules: {
            name: [
                {required: true, message: '请输入活动名称', trigger: 'blur'},
            ],

            pic: [
                {required: true, message: '图片信息不能为空', trigger: 'change'},
            ],

            is_index: [
                {required: true, message: '发布位置不能为空', trigger: 'change'},
            ],

            type: [
                {required: true, message: '类型不能为空', trigger: 'change'},
            ],


            goods_id: [
                {required: true, message: '商品名称不能为空', trigger: 'change'},
            ],

            category: [
                {required: true, message: '类型不能为空', trigger: 'change'},
            ],
        }


    };


    var app = new Vue({
        el: '.demo-ruleForm',
        data: data,

        mounted: function () {
            this.loadDefaultgoods();
        },


        methods: {
            submitForm: function (formName) {
                _self = this;
                this.$refs[formName].validate(function (valid) {
                    if (valid) {

                        var postUrl = '/shop-banner/add';
                        var postData = new FormData();
                        postData.append('name', _self.ruleForm.name);
                        postData.append('pic', _self.ruleForm.pic);
                        postData.append('is_index', _self.ruleForm.is_index);
                        postData.append('type', _self.ruleForm.type);
                        postData.append('category', _self.ruleForm.category);
                        postData.append('goods_id', _self.ruleForm.goods_id);
                        postData.append('_csrf_token', '<?= Yii::$app->request->csrfToken ?>');
                        axios.post(postUrl, postData).then(function (res) {
                          if(res.data==1)
                          {
                              layer.alert('操作成功');
                              window.location.href = '<?php echo  \yii\helpers\Url::to(['shop-banner/index'])?>';
                          }
                        }).catch(function (error) {

                        })

                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },

            remoteMethod: function (query) {
                var _self = this;
                if (query !== '') {
                    this.loading = true;
                    setTimeout(function () {
                        var postUrl = '/shop-banner/search-goods';
                        var postData = new FormData();
                        postData.append('goods_name', query);
                        postData.append('_csrf_token', '<?= Yii::$app->request->csrfToken ?>');
                        axios.post(postUrl, postData).then(function (res) {
                            _self.options = res.data.map(function (item) {
                                return {value: item.id, label: item.title};
                            });
                            _self.loading = false;

                        }).catch(function (error) {
                            _self.loadDefaultgoods();
                            _self.loading = false;
                        })
                    }, 200);
                } else {
                    this.loading = false;
                    this.loadDefaultgoods();
                }
            },
            loadDefaultgoods: function () {
                this.options = this.states.map(function (item) {
                    return {value: item.id, label: item.title};
                });
            }


        },


    })
</script>
<style>
    input[type="file"] {
        display: none;
    }
</style>