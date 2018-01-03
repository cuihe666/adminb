<?php

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
    <el-form-item label="标题" prop="name">
        <el-input v-model="ruleForm.name"></el-input>
    </el-form-item>

    <br>
    <el-form-item prop="pic" label="标题图片">

        <el-upload
                action="http://upload.qiniu.com"
                list-type="picture-card"
                :accept="upload_config.accepts"
                :on-preview="handlePictureCardPreview"
                :on-success="handleAvatarSuccess"
                :before-upload="beforeAvatarUpload"
                :disabled="upload_config.disabled_upload"
                :on-remove="handleRemove"
                :data="form">
            <i class="el-icon-plus"></i>
        </el-upload>
        <el-dialog v-model="dialogVisible" size="tiny">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>

    </el-form-item>


    <el-input v-model="ruleForm.pic" type="hidden"></el-input>

    <br>
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


    <el-form-item label="商品名称" prop="goods_id">

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
    <el-form-item label="排序值" prop="sort">
        <el-input v-model.number="ruleForm.sort"></el-input>
    </el-form-item>


    <br>
    <el-form-item label=" ">
        <el-button type="primary" @click="submitForm('ruleForm')">提交</el-button>
    </el-form-item>


</el-form>


<script>


    var options = <?= $default_goods ?>;
    var data = {
        img_list: [],
        labelPosition: 'left',
        options: [],
        is_indexOptions: [

            {value: '0', label: '内页'},
            {value: '1', label: '首页'},


        ],
        category_Options: [

            {value: '1', label: '旅游'},
            {value: '2', label: '特产'},
            {value: '3', label: '科技'},
            {value: '4', label: '家居'},


        ],
        upload_config: {
            disabled_upload: false,
            accepts: 'image/jpeg, image/jpg, image/png, image/gif', //允许的文件类型
            max_size: 1048576, //最大体积1mb
            max_num: 1, //最大个数5
        },

        ruleForm: {

            name: '',
            pic: '',
            is_index: '',
            type: '',
            category: '',
            goods_id: '',
            sort: 0,
        },


        list: [],
        loading: false,
        states: options,


        dialogImageUrl: '',
        dialogVisible: false,
        form: {
            key: '',
            token: '<?php echo $token ?>'
        },


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

            goods_id: [
                {required: true, message: '商品名称不能为空', trigger: 'change'},
            ],

            category: [
                {required: true, message: '类型不能为空', trigger: 'change'},
            ],
            sort: [
                {type: 'number', message: '排序值必须为数字类型', trigger: 'blur'}
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
                        postData.append('category', _self.ruleForm.category);
                        postData.append('goods_id', _self.ruleForm.goods_id);
                        postData.append('sort', _self.ruleForm.sort);
                        postData.append('_csrf_token', '<?= Yii::$app->request->csrfToken ?>');
                        axios.post(postUrl, postData).then(function (res) {
                            if (res.data == 1) {
                                layer.alert('操作成功');
                                window.location.href = '<?php echo \yii\helpers\Url::to(['shop-banner/index'])?>';
                            }
                        }).catch(function (error) {

                        })

                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },

            handleAvatarSuccess: function (res, file, fileList) {   //上传成功后在图片框显示图片
                this.img_list = fileList;
//                if (this.img_list.length >= 1) {
//                    this.upload_config.disabled_upload = true
//                }
                console.log(res.key)
            },
            handleRemove: function (file, fileList) {
                this.ruleForm.pic = '';
                console.log(file, fileList);
            },
            handlePictureCardPreview: function (file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },

            beforeAvatarUpload: function (file) {

                if (this.ruleForm.pic != '') {
                    layer.alert('只能上传一张图片');
                    return;
                }


                const isJPG = file.type === 'image/jpeg'
                const isPNG = file.type === 'image/png'
                const isLt2M = file.size / 1024 / 1024 < 2

//                if (!isJPG ) {
//                    this.$message.error('上传头像图片只能是 JPG/PNG 格式!')
//                    return false;
//                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!')
                    return false;
                }
                var curr = moment().format('YYYMMDDHHmmss').toString();
                var suffix = file.name.substring(file.name.lastIndexOf('.'));
                var url = 'banner_' + curr + suffix;
                this.form.key = url;
                this.ruleForm.pic = 'http://img.tgljweb.com/' + url;
                sessionStorage.setItem("key", url);
                var value = sessionStorage.getItem("key");


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