<?php

use yii\helpers\Html;

\backend\assets\VueAsset::register($this);
$this->title = '商品添加';

/* @var $this yii\web\View */
/* @var $model backend\models\ShopGoods */
?>
<el-form :inline="true" :model="formInline" ref="ruleForm" class="demo-form-inline" label-width="100px">
    <el-form-item label="商品分类">
        <el-select v-model="formInline.one" placeholder="一级分类" @change="ajax1">

            <?php foreach ($category as $k => $v): ?>
                <el-option label="<?php echo $v['title'] ?>" value="<?php echo $v['id'] ?>"></el-option>
            <?php endforeach ?>
        </el-select>

        <el-select v-model="formInline.two" placeholder="二级分类" @change="ajax2">

            <el-option v-for="(item,index) in  two" :label="item.title" :value="item.id"></el-option>

        </el-select>

        <el-select v-model="formInline.three" placeholder="三级分类">
            <el-option v-for="(item,index) in  three" :label="item.title" :value="item.id"></el-option>
        </el-select>
    </el-form-item>

    <br>
    <el-form-item
            prop="name"
            label="商品名称"
            :rules="[
      { required: true, message: '商品名称不能为空', trigger: 'blur' },
    ]"
    >
        <el-input v-model="formInline.name"></el-input>
    </el-form-item>

    <br>
    <el-form-item prop="name" label="商品条形码">
        <el-input v-model="formInline.bar_code"></el-input>
    </el-form-item>
    <br>

    <el-form-item label="规格开关">
        <el-switch on-text="" off-text="" v-model="formInline.spec">
        </el-switch>
    </el-form-item>

    <br>
    <div v-if="formInline.spec">


        <el-form-item prop="name" label="商品规格">

            <el-select v-for="(domain, index) in formInline.specs" >
                <el-option label="区域一" v-model="domain.value"></el-option>
            </el-select>
            <br>

        </el-form-item>
        <br>

        <el-button type="info" @click="addDomain">添加规格值</el-button>


    </div>


    <br>
    <el-form-item label="">
        <el-button type="primary" @click="onSubmit('ruleForm')">提交</el-button>
    </el-form-item>


</el-form>
<script>


    var data = {
        two: '',
        three: '',
        formInline: {
            one: '',
            two: '',
            three: '',
            name: '',
            spec: false,
            spec_attr: '',
            specs: [{
                value: ''
            }],
        },
        input: '',

    };


    var app = new Vue({
        el: '.demo-form-inline',
        data: data,

        methods: {
            onSubmit: function (formName) {
                this.$refs[formName].validate(function (valid) {
                    if (valid) {
                        alert('submit!');
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            ajax1: function (val) {

                var _self = this;
                this.formInline.two = '';
                this.formInline.three = '';
                $.post("<?php echo \yii\helpers\Url::to(["shop-goods/getson"]) ?>", {
                        "PHPSESSID": "<?php echo session_id();?>",
                        "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                        data: {id: val},
                    },
                    function (data) {
                        var data = JSON.parse(data);
                        _self.two = data;


                    }
                )
            },
            ajax2: function (val) {

                var _self = this;
                this.formInline.three = '';
                $.post("<?php echo \yii\helpers\Url::to(["shop-goods/getson"]) ?>", {
                        "PHPSESSID": "<?php echo session_id();?>",
                        "<?=Yii::$app->request->csrfParam?>": "<?=Yii::$app->request->getCsrfToken()?>",
                        data: {id: val},
                    },
                    function (data) {
                        var data = JSON.parse(data);
                        _self.three = data;


                    }
                )
            },
            add_spec: function () {
                alert(app.formInline.spec_attr);
            },

            addDomain: function () {
                var _self = this;
                _self.formInline.specs.push({
                    value: '',
                    key: Date.now()
                });
            }


        }
    })
</script>