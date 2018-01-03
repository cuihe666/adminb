<?php

\backend\assets\VueAsset::register($this);
$this->title = '修改供应商基础信息';

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
    <el-form-item label="供应商名称" prop="name">
        <el-input v-model="ruleForm.name"></el-input>
    </el-form-item>
    <br>
    <el-form-item label="供应商类别" prop="type">
        <el-select v-model="ruleForm.type">
            <el-option
                    v-for="item in typeOptions"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
            </el-option>
        </el-select>
    </el-form-item>
    <br>
    <el-form-item label="供应商地址" prop="address">
        <el-input v-model="ruleForm.address"></el-input>
    </el-form-item>
    <br>
    <el-form-item prop="pic" label="供应商资质">

        <el-upload
                action="http://upload.qiniu.com"
                list-type="picture-card"
                :accept="upload_config.accepts"
                :on-preview="handlePictureCardPreview"
                :on-success="handleAvatarSuccess"
                :before-upload="beforeAvatarUpload"
                :disabled="upload_config.disabled_upload"
                :file-list="img_list_desc"
                :on-remove="handleRemove"
                :multiple="false"
                :data="form">
            <i class="el-icon-plus"></i>
        </el-upload>
        <el-dialog v-model="dialogVisible" size="tiny">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>

    </el-form-item>
    <el-input v-model="ruleForm.pic" type="hidden"></el-input>
    <br>

    <el-form-item label="联系人" prop="contacts">
        <el-input v-model="ruleForm.contacts"></el-input>
    </el-form-item>
    <br>

    <el-form-item label="联系电话" prop="contacts_phone">
        <el-input v-model.number="ruleForm.contacts_phone" type="number"></el-input>
    </el-form-item>
    <br>
    <el-form-item label=" ">
        <el-button type="primary" @click="submitForm('ruleForm')">保存</el-button>
        <el-button @click="resetForm('ruleForm')">取消</el-button>
    </el-form-item>


</el-form>


<script>
    var checkPhones = function(rule,value,callback){
        if (value == ''){
            callback(new Error('请输入手机号码'));
        }else{
            var pattern = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
            if(pattern.test(value)){
                callback();
            }else{
                callback(new Error('手机号码格式错误'));
            }
        }
    };
    var data = {
        img_list: [],
        labelPosition: 'left',
        typeOptions: [
            {value:'1', label:'机票供应商'},
            {value:'2', label:'航空公司'}
        ],
        upload_config: {
            disabled_upload: false,
            accepts: 'image/jpeg, image/jpg, image/png, image/gif', //允许的文件类型
            max_size: 1048576, //最大体积1mb
            max_num: 1 //最大个数5
        },

        ruleForm: {
            id:'<?= isset($supplier_info["id"])?$supplier_info["id"]:""?>',
            name: '<?= isset($supplier_info["name"])?$supplier_info["name"]:""?>',
            address:'<?= isset($supplier_info["address"])?$supplier_info["address"]:""?>',
            pic: '',
            type:'<?= isset($supplier_info["ticket_genre"])?$supplier_info["ticket_genre"]:"1"?>',
            contacts:'<?= isset($supplier_info["contacts"])?$supplier_info["contacts"]:""?>',
            contacts_phone:'<?= isset($supplier_info["contacts_phone"])?$supplier_info["contacts_phone"]:""?>'

        },
        img_list_desc:[],
        pic_num: <?= count($img_info['img_info'])?>,

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
            address:[
                {required: true, message: '请输入地址信息', trigger: 'blur'}
            ],
            contacts:[
                {required: true, message: '请输入联系人姓名', trigger: 'blur'}
            ],
            contacts_phone:[
                {type: 'number', required: true, trigger: 'blur', validator:checkPhones}
            ]
        }


    };


    var app = new Vue({
        el: '.demo-ruleForm',
        data: data,
        mounted:function () {
            <?php if (!empty($img_info['img_info'])) {?>
                <?php foreach ($img_info['img_info'] as $value) {?>
                    this.img_list_desc.push({name:'food.png',url:"<?= $value['file_url'] ?>"});
                <?php }?>
            this.ruleForm.pic = "<?= $img_info['img_str']?>";
            <?php }?>
        },
        methods: {
            submitForm: function (formName) {
                _self = this;
                this.$refs[formName].validate(function (valid) {
                    if (valid) {
                        var postUrl = '/plane-supplier/reset';
                        var postData = new FormData();
                        postData.append('id', _self.ruleForm.id);
                        postData.append('name', _self.ruleForm.name);
                        postData.append('type', _self.ruleForm.type);
                        postData.append('address', _self.ruleForm.address);
                        postData.append('pic', _self.ruleForm.pic);
                        postData.append('contacts', _self.ruleForm.contacts);
                        postData.append('contacts_phone', _self.ruleForm.contacts_phone);
                        postData.append('<?= Yii::$app->request->csrfParam?>', '<?= Yii::$app->request->csrfToken ?>');
                        axios.post(postUrl, postData).then(function (res) {
//                            console.log(res.data);return;
                            if (res.data == 'success') {
                                layer.alert('操作成功');
                                window.location.href = '<?php echo \yii\helpers\Url::to(['plane-supplier/index'])?>';
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
            resetForm: function(formName) {
                window.history.go(-1);
            },

            handleAvatarSuccess: function (res, file, fileList) {   //上传成功后在图片框显示图片
                this.img_list = fileList;
                if (this.pic_num < 10) {
                    var url = 'http://img.tgljweb.com/'+ res.key;
                    console.log(url);
                    this.ruleForm.pic = this.ruleForm.pic + ',' + url;
                }
                this.pic_num = fileList.length;
                console.log(this.ruleForm.pic);
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
                        this.ruleForm.pic = this.ruleForm.pic + ',' + url;
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

                if (this.pic_num >= 10) {
                    layer.alert('最多只能上传十张图片');
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
            }

        }

    })
</script>
<style>
    input[type="file"] {
        display: none;
    }
</style>