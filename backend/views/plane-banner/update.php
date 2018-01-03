<?php

\backend\assets\VueAsset::register($this);
$this->title = '机票banner修改';

/* @var $this yii\web\View */
/* @var $model backend\models\ShopGoods */
?>
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<!--<el-form :inline="true" ref="ruleForm" class="demo-form-inline" label-width="100px">-->
<el-form :model="ruleForm" :label-position="labelPosition" :inline="true" :rules="rules" ref="ruleForm"
         label-width="100px" class="demo-ruleForm">
    <el-input v-model="ruleForm.id" type="hidden"></el-input>
    <el-form-item label="活动名称" prop="name">
        <el-input v-model="ruleForm.name"></el-input>
    </el-form-item>

    <br>
    <el-form-item prop="pic" label="banner图">

        <el-upload
                action="http://upload.qiniu.com"
                list-type="picture-card"
                :accept="upload_config.accepts"
                :on-preview="handlePictureCardPreview"
                :on-success="handleAvatarSuccess"
                :file-list="img_list_desc"
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


    <el-form-item label="链接地址" prop="goods_url">
        <el-input v-model="ruleForm.goods_url" placeholder="空值默认banner不跳转"></el-input>
    </el-form-item>
    <br>
    <el-form-item label="广告排序值" prop="sort">
        <el-input v-model.number="ruleForm.sort" type="number"></el-input>
    </el-form-item>
    <br>
    <el-form-item label="状态" prop="status">
        <el-radio v-model="ruleForm.status" label="1">在线</el-radio>
        <el-radio v-model="ruleForm.status" label="2">下线</el-radio>
    </el-form-item>

    <br>
    <el-form-item label=" ">
        <el-button type="primary" @click="submitForm('ruleForm')">提交</el-button>
    </el-form-item>


</el-form>


<script>

    var data = {
        img_list: [],
        labelPosition: 'left',
        options: [],
        upload_config: {
            disabled_upload: false,
            accepts: 'image/jpeg, image/jpg, image/png, image/gif', //允许的文件类型
            max_size: 1048576, //最大体积1mb
            max_num: 1, //最大个数5
        },
        img_list_desc: [],
        ruleForm: {
            id:'<?= isset($banner_info['id'])?$banner_info['id']:"";?>',
            name: '<?= isset($banner_info['desc'])?$banner_info['desc']:"";?>',
            pic: '<?= isset($banner_info['img_url'])?$banner_info['img_url']:"";?>',
            goods_url: '<?= isset($banner_info['turn_data'])?$banner_info['turn_data']:"";?>',
            sort:<?= isset($banner_info['sort'])?$banner_info['sort']:""?>,
            status:"<?= isset($banner_info['status'])?$banner_info['status']:""?>"
        },

        pic_num: <?= $img_info['img_info']?>,
        list: [],
        loading: false,


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

            sort: [
                {required: true, type: 'number', message: '排序值必须为数字类型', trigger: 'blur'}
            ]

        }


    };


    var app = new Vue({
        el: '.demo-ruleForm',
        data: data,

        mounted: function () {
            this.img_list_desc.push({name:'food.png',url:"<?= $img_info['img_str'] ?>"});
            this.ruleForm.pic = "<?= $img_info['img_str']?>";
            console.log(this.img_list_desc);
        },
        methods: {
            submitForm: function (formName) {
                _self = this;
                this.$refs[formName].validate(function (valid) {
                    if (valid) {

                        var postUrl = '/plane-banner/reset';
                        var postData = new FormData();
                        postData.append('name', _self.ruleForm.name);
                        postData.append('id', _self.ruleForm.id);
                        postData.append('pic', _self.ruleForm.pic);
                        postData.append('goods_url', _self.ruleForm.goods_url);
                        postData.append('sort', _self.ruleForm.sort);
                        postData.append('status', _self.ruleForm.status);
                        postData.append('_csrf_token', '<?= Yii::$app->request->csrfToken ?>');
                        axios.post(postUrl, postData).then(function (res) {
                            if (res.data == 'success') {
                                layer.alert('操作成功');
                                window.location.href = '<?php echo \yii\helpers\Url::to(['plane-banner/index'])?>';
                            } else {
                                layer.alert(res.data);
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
                if (this.pic_num < 1) {
                    var url = 'http://img.tgljweb.com/'+ res.key;
//                    console.log(url);
                    this.ruleForm.pic = url;
                }
                this.pic_num = fileList.length;
//                console.log(this.ruleForm.pic);
            },
            handleRemove: function (file, fileList) {
                console.log(fileList.length);
                console.log(fileList);
                if (fileList.length > 0) {
                    this.ruleForm.pic = '';
                    for (var i=0; i < fileList.length; i++) {
                        if (fileList[i].response) {
                            var url = 'http://img.tgljweb.com/'+ fileList[i].response.key;
                        } else {
                            var url = fileList[i].url;
                        }
                        this.ruleForm.pic = url;
                    }
                } else {
                    this.ruleForm.pic = '';
                }
                this.pic_num = fileList.length;
            },
            handlePictureCardPreview: function (file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },

            beforeAvatarUpload: function (file) {

                if (this.pic_num >= 1) {
                    layer.alert('最多只能上传一张图片');
                    return false
                }


                const isJUDGE = (file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'image/gif');
                const isLt2M = file.size / 1024 / 1024 < 2;
                if (!isJUDGE ) {
                    layer.alert('上传头像图片只能是 jpg/png/gif 格式!')
                    return false;
                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!')
                    return false;
                }
                var curr = moment().format('YYYMMDDHHmmss').toString();
                var suffix = file.name.substring(file.name.lastIndexOf('.'));
                var url = 'plane_banner_' + curr + suffix;
                this.form.key = url;


            },
        },


    })
</script>
<style>
    input[type="file"] {
        display: none;
    }
</style>