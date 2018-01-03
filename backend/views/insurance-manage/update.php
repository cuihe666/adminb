<?php

\backend\assets\VueAsset::register($this);
$this->title = '修改保险产品';

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
    <el-form-item label="供应商名称" prop="supplier_id">
        <el-select v-model="ruleForm.supplier_id">
            <el-option
                    v-for="item in insuranceOptions"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
            </el-option>
        </el-select>
    </el-form-item>
    <br>
    <el-form-item label="产品类型" prop="type">
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
    <el-form-item label="产品ID" prop="goods_id">
        <el-input v-model.number="ruleForm.goods_id" type="number"></el-input>
    </el-form-item>
    <span style="color: #7a869d">* 第三方保险产品ID</span>
    <br>
    <el-form-item label="保费" prop="price">
        <el-input v-model.number="ruleForm.price" type="number"></el-input>
    </el-form-item>
    <span>元</span>
    <br>
    <el-form-item label="保额" prop="insurance_fee">
        <el-input v-model.number="ruleForm.insurance_fee" type="number"></el-input>
    </el-form-item>
    <span>元</span>
    <br>
    <el-form-item label="佣金方式" prop="collection_method" id="method_select">
        <el-radio v-model="ruleForm.collection_method" label="0" @change.native="methodSelect(ruleForm.collection_method)">固定佣金</el-radio>
        <el-radio v-model="ruleForm.collection_method" label="1" @change.native="methodSelect(ruleForm.collection_method)">佣金比例</el-radio>
    </el-form-item>

    <br v-if="ruleForm.commission_note">
    <el-form-item label="固定佣金" prop="commission" v-if="ruleForm.commission_note">
        <el-input v-model.number="ruleForm.commission" type="number"></el-input>
    </el-form-item>
    <span v-if="ruleForm.commission_note">元</span>
    <br v-if="ruleForm.ratio_note">
    <el-form-item label="佣金比例" prop="ratio" v-if="ruleForm.ratio_note">
        <el-input v-model.number="ruleForm.ratio" type="number"></el-input>
    </el-form-item>
    <span v-if="ruleForm.ratio_note">%</span>
    <br>
    <el-form-item prop="pic" label="产品文档">

        <el-upload
                action="http://upload.qiniu.com"
                list-type="text"
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
    <el-input v-model="ruleForm.id" type="hidden"></el-input>
    <br>
    <el-form-item label=" ">
        <el-button type="primary" @click="submitForm('ruleForm')">保存</el-button>
        <el-button @click="resetForm('ruleForm')">取消</el-button>
    </el-form-item>


</el-form>


<script>
    //验证固定佣金
    var checkCommission = function(rule,value,callback){
        if (value == ''){
            callback(new Error('请输入佣金值'));
        }else{
            var pattern = /^[1-9]\d*(\.\d+)?$/;//大于0数（包含小数）
            if(pattern.test(value)){
                callback();
            }else{
                callback(new Error('佣金值为大于0的正数！'));
            }
        }
    };
    //验证佣金比例
    var checkRatio = function(rule,value,callback){
        if (value == ''){
            callback(new Error('请输入佣金比例'));
        }else{
            var pattern = /(^[1-9]?\d(\.\d+)?$)/;//大于0小于100的整数（包含小数）
            if(pattern.test(value)){
                callback();
            }else{
                callback(new Error('佣金比例大于0小于100！'));
            }
        }
    };
    //验证保费和保额
    var checkInsurancePrice = function (rule,value,callback) {
        if (value == ''){
            callback(new Error('请输入佣金比例'));
        }else{
            var pattern = /^[0-9]*[1-9][0-9]*$/;//正整数（不包含0）
            if(pattern.test(value)){
                callback();
            }else{
                callback(new Error('佣金比例为正整数！'));
            }
        }
    };
    var data = {
        img_list: [],
        labelPosition: 'left',
        insuranceOptions:[],
        typeOptions: [
            {value:'1', label:'航意险'}
        ],
        upload_config: {
            disabled_upload: false,
            accepts: '.doc', //允许的文件类型
            max_size: 1048576, //最大体积1mb
            max_num: 1, //最大个数5
        },

        ruleForm: {
            id:'<?= isset($supplier_info['id'])?$supplier_info['id']:''?>',
            supplier_id: '<?= isset($supplier_info['supplier_id'])?$supplier_info['supplier_id']:''?>',
            type:'<?= isset($supplier_info['type'])?$supplier_info['type']:''?>',
            price:<?= isset($supplier_info['price'])?$supplier_info['price']:''?>,
            insurance_fee:<?= isset($supplier_info['insurance_fee'])?$supplier_info['insurance_fee']:''?>,
            ratio:'<?= $supplier_info['collection_method'] == 1 ? (isset($supplier_info['ratio'])?$supplier_info['ratio']:'') : '' ?>',
            pic: '',
            commission: '<?= $supplier_info['collection_method'] == 1 ? '' : (isset($supplier_info['commission'])?$supplier_info['commission']:'') ?>',//固定佣金
            collection_method: '<?= isset($supplier_info["collection_method"]) ? $supplier_info["collection_method"] : ''?>',//佣金收取方式（0.固定佣金 1.佣金比例）
            goods_id:<?= isset($supplier_info['goods_id'])?$supplier_info['goods_id']:''?>,//产品ID
            commission_note: '<?= $supplier_info['collection_method'] == 1 ? false : true ?>',//固定佣金显示标记
            ratio_note: '<?= $supplier_info['collection_method'] == 1 ? true : false ?>'//佣金比例显示标记
        },

        img_list_desc:[],
        pic_num: <?= count($img_info['img_info'])?>,
        pic_name:'',

        loading: false,

        dialogImageUrl: '',
        dialogVisible: false,
        form: {
            key: '',
            token: '<?php echo $token ?>'
        },


        rules: {
            supplier_id: [
                {required: true, message: '请选择供应商', trigger: 'change'},
            ],
            type:[
                {required: true, message: '请选择产品类型', trigger: 'change'}
            ],
            price:[
                {required: true, trigger: 'blur', type:'number', validator:checkInsurancePrice}
            ],
            insurance_fee:[
                {required: true, trigger: 'blur', type:'number', validator:checkInsurancePrice}
            ],
            ratio:[
                {required: false, trigger: 'blur', type:'number', validator:checkRatio}
            ],
            //固定佣金
            commission:[
                {required: false, trigger: 'blur', type:'number', validator:checkCommission}
            ],
            //佣金收取方式：
            collection_method:[
                {required: true}
            ],
            //产品ID
            goods_id:[
                {required: true, trigger: 'blur', type:'number', message: '请填写保险产品ID'}
            ]
        }


    };


    var app = new Vue({
        el: '.demo-ruleForm',
        data: data,

        mounted: function(){
            //供应商下拉加载
            <?php if (!empty($list_info)) {?>
                <?php foreach ($list_info as $value) {?>
                    this.insuranceOptions.push({value:"<?= $value['id']?>", label:"<?= $value['name']?>"});
                <?php }?>
            <?php }?>
            //图片加载
            <?php if (!empty($img_info['img_info'])) {?>
                <?php foreach ($img_info['img_info'] as $k => $value) {?>
                    this.img_list_desc.push({name:'<?= $value['file_name']?>',url:"<?= $value['file_url'] ?>"});
                <?php }?>
            this.ruleForm.pic = "<?= $img_info['img_str']?>";
            this.pic_name = "<?= $img_info['name_str']?>";
            <?php }?>
        },

        methods: {
            submitForm: function (formName) {
                _self = this;
                this.$refs[formName].validate(function (valid) {
                    if (valid) {
                        var postUrl = '/insurance-manage/reset';
                        var postData = new FormData();
                        postData.append('id', _self.ruleForm.id);
                        postData.append('supplier_id', _self.ruleForm.supplier_id);
                        postData.append('type', _self.ruleForm.type);
                        postData.append('price', _self.ruleForm.price);
                        postData.append('insurance_fee', _self.ruleForm.insurance_fee);
                        postData.append('pic', _self.ruleForm.pic);
                        postData.append('pic_name', _self.pic_name);
                        postData.append('ratio', _self.ruleForm.ratio);
                        postData.append('goods_id', _self.ruleForm.goods_id);//保险商品ID（保险公司提供的）
                        postData.append('collection_method', _self.ruleForm.collection_method);//佣金收取方式（0.固定佣金 1.佣金比例）
                        postData.append('commission', _self.ruleForm.commission);//固定佣金金额
                        postData.append('<?= Yii::$app->request->csrfParam?>', '<?= Yii::$app->request->csrfToken ?>');
                        axios.post(postUrl, postData).then(function (res) {
//                            console.log(res.data);return;
                            if (res.data == 'success') {
                                layer.alert('操作成功');
                                window.location.href = '<?php echo \yii\helpers\Url::to(['insurance-manage/index'])?>';
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
                this.$refs[formName].resetFields();
            },

            handleAvatarSuccess: function (res, file, fileList) {   //上传成功后在图片框显示图片
                this.img_list = fileList;
                if (this.pic_num < 3) {
                    this.ruleForm.pic = '';
                    this.pic_name = '';
                    for (var js=0; js<fileList.length; js++) {
                        if (fileList[js].response) {
                            var url = 'http://img.tgljweb.com/'+ fileList[js].response.key;
                        } else {
                            var url = fileList[js].url;
                        }
                        this.pic_name = this.pic_name + ',' + fileList[js].name;
                        this.ruleForm.pic = this.ruleForm.pic + ',' + url;
                    }
                }
                this.pic_num = fileList.length;
            },
            handleRemove: function (file, fileList) {
                console.log(fileList);
                if (fileList.length > 0) {
                    this.ruleForm.pic = '';
                    this.pic_name = '';
                    for (var i=0; i < fileList.length; i++) {
                        if (fileList[i].response) {
                            var url = 'http://img.tgljweb.com/' + fileList[i].response.key;
                        } else {
                            var url = fileList[i].url;
                        }
                        this.pic_name = this.pic_name + ',' + fileList[i].name;
                        this.ruleForm.pic = this.ruleForm.pic + ',' + url;
                    }
                } else {
                    this.ruleForm.pic = '';
                    this.pic_name = '';
                }
                this.pic_num = fileList.length;
            },
            handlePictureCardPreview: function (file) {
//                this.dialogImageUrl = file.url;
                this.dialogVisible = false;
                if (file.response) {
                    var url = 'http://img.tgljweb.com/' + file.response.key;
                } else {
                    var url = file.url;
                }
                location.href = url;
            },

            beforeAvatarUpload: function (file) {
//                console.log('judge:'+this.pic_num);
                if (this.pic_num >= 3) {
                    layer.alert('最多只能上传三份文档');
                    return false
                }
                const isDOC = file.type === 'application/msword';
//                const isPNG = file.type === 'image/png';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isDOC ) {
                    layer.msg('上传文档只上传.doc格式的Word文档!', {time:2000});
                    return false;
                }
                if (!isLt2M) {
                    this.$message.error('上传文档大小不能超过 2MB!');
                    return false;
                }
                var curr = moment().format('YYYMMDDHHmmss').toString();
                var suffix = file.name.substring(file.name.lastIndexOf('.'));
                var url = 'plane_insurance_' + curr + suffix;
                this.form.key = url;
            },
            //佣金收取方式
            methodSelect: function (note) {
                if (note == 0) {//用户选择了固定佣金
                    app.ruleForm.commission_note = true;//显示固定佣金框
                    app.ruleForm.ratio_note = false;//隐藏佣金比例框
                    app.rules.commission.required = true;//标记为必填
                    app.rules.ratio.required = false;//标记为非必填
                    app.ruleForm.ratio = '';//清空佣金比例内容
                } else {//用户选择了佣金比例
                    app.ruleForm.commission_note = false;//隐藏固定佣金框
                    app.ruleForm.ratio_note = true;//显示佣金比例框
                    app.rules.commission.required = false;//标记为非必填
                    app.rules.ratio.required = true;//标记为必填
                    app.ruleForm.commission = '';//清空固定佣金内容
                }
            }

        }

    })
</script>
<style>
    input[type="file"] {
        display: none;
    }
</style>