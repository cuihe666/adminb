<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/7/7
 * Time: 下午6:03
 */
$this->title = '创建商品';
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\LoadshAsset::register($this);
?>
<style>
    .row-top-10 {
        margin-top: 10px;
    }

    .row-top-20 {
        margin-top: 20px;
    }

    .row-top-40 {
        margin-top: 40px;
    }

    .col-top-5 {
        margin-top: 5px;
    }

    input[type="file"] {
        display: none;
    }

</style>

<div id="create-page" v-cloak>
    <el-form ref="base_form" :rules="rules" :model="base_form" label-width="110px">
        <!--基本信息-->
        <el-row>
            <!--            提示居中的版本-->
            <!--        <el-row align="middle" type="flex">-->
            <el-col :span="3" :md="3" :xs="24">
                <blockquote style="height: 100%">
                    <h4>基本信息</h4>
                </blockquote>
            </el-col>

            <el-col :span="21" :md="21" :xs="24">
                <el-row>
                    <el-col :span="12" :md="12" :xs="24">
                        <el-form-item label="商品分类" prop="category_breadcrumbs">
                            <!--                            <el-input v-model="base_form.category_breadcrumbs"></el-input>-->
                            <el-cascader
                                    :options="category_list"
                                    @active-item-change="handleItemChange"
                                    @change="categoryChange"
                                    v-model="default_category"
                                    size="large"
                                    style="width: 100%;"
                                    popper-class="custom_popper"
                            ></el-cascader>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col :span="12" :md="12" :xs="24">
                        <el-form-item label="商品名" prop="title">
                            <el-input v-model="base_form.title"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>


                <el-row>
                    <el-col :span="8" :md="8" :xs="24">
                        <el-form-item label="商品编码">
                            <el-input v-model="base_form.code"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col :span="8" :md="8" :xs="24">
                        <el-form-item label="商品条码">
                            <el-input v-model="base_form.barcode"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-col>
        </el-row>

        <hr>
        <!--库存/售价-->
        <el-row>
            <el-col :span="3" :md="3" :xs="24">
                <blockquote style="height: 100%">
                    <h4>库存/售价</h4>
                </blockquote>
            </el-col>

            <el-col :span="21" :md="21" :xs="24">

                <!--规格开关-->
                <el-row>
                    <el-col :span="24">
                        <el-form-item label="规格开关">
                            <el-switch v-model="base_form.is_more" on-value="1" off-value="0"></el-switch>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-collapse-transition>

                    <el-row v-if="base_form.is_more == 1">
                        <el-col :span="3" :md="3" :xs="3">
                            <el-form-item label="规格"></el-form-item>
                        </el-col>

                        <el-col :span="21" :md="21" :xs="21">


                            <!--一个完整的规格模块-->
                            <el-row v-for="(attr,pid) in attr_block" :class="[ pid==0 ? '' : 'row-top-40']">
                                <el-row :gutter="10">
                                    <el-col :span="4" :lg="6" :md="8" :sm="10" :xs="12" class="col-top-5">
                                        <el-select v-model="attr_block[pid].value" @change="changeAttrValue(pid)"
                                                   placeholder="请选择规格">
                                            <el-option v-for="item in spec_list" :key="item.value" :label="item.label"
                                                       :value="item.value"></el-option>
                                        </el-select>
                                    </el-col>

                                    <!--新加规格输入框-->
                                    <el-col :span="4" :lg="4" :md="6" :sm="8" :xs="10" class="col-top-5">
                                        <el-input v-model="attr_block[pid].child_new_value"
                                                  @keyup.native.enter="addAttrChild(pid)"
                                                  placeholder="请添加规格值"></el-input>
                                    </el-col>


                                    <!--规格操作栏-->
                                    <el-col :span="4" :lg="6" :md="8" :sm="10" :xs="12" class="col-top-5">
                                        <!--添加属性值-->
                                        <el-tooltip class="item" effect="dark" content="添加规格值" placement="top-start">
                                            <el-button type="primary" icon="plus"
                                                       @click="addAttrChild(pid)"></el-button>
                                        </el-tooltip>
                                        <!--删除规格-->
                                        <el-tooltip class="item" effect="dark" content="删除规格" placement="top-start">
                                            <el-button type="danger" icon="delete"
                                                       @click="delAttrValue(pid)"></el-button>
                                        </el-tooltip>
                                    </el-col>
                                </el-row>

                                <!--规格值列表栏-->
                                <el-row class="row-top-10">
                                    <el-col
                                            :lg="3" :md="3" :sm="4" :xs="6"
                                            class="row-top-10"
                                            v-for="(child,id) in attr_block[pid].children">
                                        <el-button type="default" size="small">
                                            {{ child.label }}<i class="el-icon-close el-icon--right"
                                                                @click="delAttrChild(pid,id)"></i>
                                        </el-button>
                                    </el-col>
                                </el-row>
                            </el-row>


                            <!--添加规格-->
                            <el-row class="row-top-40">
                                <el-col :span="4">
                                    <el-button type="primary" icon="plus" v-if="attr_block.length < 3"
                                               @click="addAttrValue()">添加规格
                                    </el-button>
                                </el-col>

                                <el-col :span="4">
                                    <el-button type="primary" icon="plus" @click="generateTable()">生成表格</el-button>
                                </el-col>
                                <el-col :span="4">
                                    <el-button type="primary" icon="plus" @click="console()">打印结果</el-button>
                                </el-col>
                            </el-row>

                            <!--规格表单-->
                            <el-row class="row-top-40">
                                <el-col :span="24">


                                    <div style="margin-bottom: 20px" v-if="table_form.length != 0">
                                        <span>批量设置:</span>
                                        <el-button @click="openDialog('cost_price','价格')">价格</el-button>
                                        <el-button @click="openDialog('stocks','库存')">库存</el-button>
                                        <el-button @click="openDialog('code','商家编码')">商家编码</el-button>
                                    </div>
                                    <el-table
                                            :data="table_form"
                                            border
                                            style="width: 100%">
                                        <el-table-column :label="table_column_title">
                                            <template scope="scope">
                                                <span style="margin-left: 10px" v-for="item in scope.row.columns">{{ item.label }}</span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column
                                                label="价格"
                                        >
                                            <template scope="scope">
                                                <el-form-item class="row-top-20" label-width="0">
                                                    <el-input v-model.number="scope.row.cost_price"
                                                              placeholder="价格"></el-input>
                                                </el-form-item>
                                            </template>
                                        </el-table-column>

                                        <el-table-column
                                                label="库存"
                                        >
                                            <template scope="scope">
                                                <el-form-item class="row-top-20" label-width="0">
                                                    <el-input v-model.number="scope.row.stocks"
                                                              placeholder="库存"></el-input>
                                                </el-form-item>
                                            </template>
                                        </el-table-column>

                                        <el-table-column
                                                label="商家编码"
                                        >
                                            <template scope="scope">
                                                <el-form-item class="row-top-20" label-width="0">
                                                    <el-input v-model="scope.row.code" placeholder="商家编码"></el-input>
                                                </el-form-item>
                                            </template>
                                        </el-table-column>

                                    </el-table>


                                </el-col>
                            </el-row>
                        </el-col>
                    </el-row>

                </el-collapse-transition>


                <!--库存,价格和图片部分-->
                <el-row class="row-top-40">
                    <el-col :span="8" :md="8" :xs="24">
                        <el-form-item label="商品库存(件)" prop="stocks">
                            <el-input v-model="base_form.stocks" :disabled="base_form.is_more == '1'"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col :span="8" :md="8" :xs="24">
                        <el-form-item label="商品价格(元)" prop="cost_price">
                            <el-input v-model="base_form.cost_price" :disabled="base_form.is_more == '1'"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>


                <el-row>
                    <el-col :span="24" :lg="24" :md="24" :xs="24">

                        <el-form-item label="商品图片" prop="images">
                            <!--                                <el-input v-model="base_form.cost_price"></el-input>-->
                            <el-upload
                                    list-type="picture-card"
                                    action="http://upload.qiniu.com"
                                    :accept="upload_config.accepts"
                                    :on-success="handleSuccess"
                                    :on-preview="handlePreview"
                                    :on-remove="handleRemove"
                                    :before-upload="beforeUpload"
                                    :file-list="img_list"
                                    :disabled="upload_config.disabled_upload"
                                    :show-file-list="true"
                                    :data="uploadForm">
                                <div slot="tip" class="el-upload__tip">图片尺寸640*640，且不超过1mb,最多5张</div>
                                <i class="el-icon-plus"></i>
                            </el-upload>
                        </el-form-item>

                    </el-col>


                    <el-col :span="20" :lg="20" :md="20" :xs="24">


                        <el-dialog v-model="imageDialogVisible" size="large">
                            <img width="100%" :src="dialogImageUrl" :alt="dialogImageIndex">
                        </el-dialog>
                    </el-col>
                </el-row>

            </el-col>
        </el-row>
    </el-form>


    <hr>


    <!--详细介绍-->
    <el-row>
        <el-col :span="3" :md="3" :xs="24">
            <blockquote style="height: 100%">
                <h4>详细介绍</h4>
            </blockquote>
        </el-col>

        <el-col :span="21" :md="21" :xs="24">
            <el-form ref="paramsForm" :rules="rules" :model="params_fix_block" label-width="110px">
                <!--属性参数-->
                <el-row>
                    <el-col :span="3" :md="3" :xs="3">
                        <el-form-item label="属性参数"></el-form-item>
                    </el-col>
                    <el-col :span="21" :md="21" :xs="21" style="background: #EFF2F7;padding-bottom: 20px">
                        <el-row style="padding-top: 20px;">
                            <!--固定存在的参数-->
                            <el-col :span="12" :md="12" :xs="24">
                                <el-form-item label="货号" prop="product_code">
                                    <el-input v-model="params_fix_block.product_code"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12" :md="12" :xs="24">
                                <el-form-item label="商品品牌">
                                    <el-select v-model="params_fix_block.brand" placeholder="请选择商品品牌">
                                        <el-option v-for="item in brand_list" :label="item.label"
                                                   :value="item.value"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12" :md="12" :xs="24">
                                <el-form-item label="上市时间">
                                    <el-select v-model="params_fix_block.up_time" placeholder="请选择上市时间">
                                        <el-option v-for="item in up_time_list" :label="item.label"
                                                   :value="item.value"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12" :md="12" :xs="24">
                                <el-form-item label="产地">
                                    <el-select v-model="params_fix_block.location" placeholder="请选择产地">
                                        <el-option v-for="item in local_list" :label="item.label"
                                                   :value="item.value"></el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            <!--                            <el-col :span="12" :md="12" :xs="24" >-->
                            <!--                                <el-form-item label="产地" >-->
                            <!--                                    <el-input v-model="item.value"></el-input>-->
                            <!--                                </el-form-item>-->
                            <!--                            </el-col>-->
                            <!--添加按钮-->
                            <el-col offset="3" :md="24" :xs="24">
                                <el-row :gutter="10">
                                    <el-col :md="3" :xs="7" class="col-top-5">
                                        <el-form-item label-width="0" prop="extra_label">
                                            <el-input v-model="params_fix_block.extra_label"
                                                      placeholder="参数名"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="5" :xs="12" class="col-top-5">
                                        <el-form-item label-width="0" prop="extra_value">
                                            <el-input v-model="params_fix_block.extra_value"
                                                      @keyup.native.enter="addParams()" placeholder="参数值"></el-input>
                                        </el-form-item>
                                    </el-col>

                                    <el-col :md="5" :xs="12" class="col-top-5">
                                        <el-button type="primary" @click="addParams()">添加参数</el-button>
                                    </el-col>
                                </el-row>
                            </el-col>


                            <!--自己添加的参数-->
                            <el-col :span="12" :md="12" :xs="24" v-for="(item,index) in params_block">
                                <el-form-item :label="item.label">
                                    <el-input v-model="item.value">
                                        <el-button slot="append" icon="delete" @click="deleteParam(index)"></el-button>
                                    </el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>

                    </el-col>
                </el-row>
            </el-form>

            <el-form ref="infoForm" :rules="rules" :model="base_form" label-width="110px">
                <el-row class="row-top-20">
                    <el-col :span="24" :md="24" :xs="24">
                        <el-form-item label="商品简介">
                            <el-input v-model="base_form.introduction"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row class="row-top-20">
                    <el-col :span="24" :md="24" :xs="24">
                        <el-form-item label="商品详情" prop="description">
                            <!--                            <el-input v-model="base_form.description"></el-input>-->

                            <el-upload
                                    list-type="picture-card"
                                    action="http://upload.qiniu.com"
                                    :accept="upload_config_desc.accepts"
                                    :on-success="handleSuccessDesc"
                                    :on-preview="handlePreviewDesc"
                                    :on-remove="handleRemoveDesc"
                                    :before-upload="beforeUploadDesc"
                                    :file-list="img_list_desc"
                                    :disabled="upload_config_desc.disabled_upload"
                                    :show-file-list="true"
                                    :data="uploadForm">
                                <div slot="tip" class="el-upload__tip">不超过5mb,仅一张</div>
                                <i class="el-icon-plus"></i>
                            </el-upload>

                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row class="row-top-20">
                    <el-col :span="24" :md="24" :xs="24">
                        <el-form-item label="包装清单" prop="packing_list">
                            <el-input type="textarea" v-model="base_form.packing_list"
                                      :autosize="{ minRows: 2, maxRows: 4}"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>

        </el-col>

    </el-row>


    <hr>
    <el-form ref="otherForm" :rules="rules" :model="base_form" label-width="110px">
        <!--物流/其他-->
        <el-row>
            <el-col :span="3" :md="3" :xs="24">
                <blockquote style="height: 100%">
                    <h4>物流/其他</h4>
                </blockquote>
            </el-col>

            <el-col :span="21" :md="21" :xs="24">
                <el-row :gutter="20">
                    <el-col :span="12" :md="8" :sm="8" :xs="24">
                        <el-form-item label="运费模板" prop="logistics_tpl_id">
                            <el-select v-model="base_form.logistics_tpl_id" placeholder="请选择运费模板">
                                <el-option v-for="item in post_tpl_list" :value="item.value"
                                           :label="item.label"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>

                    <el-col :span="12" :md="6" :sm="6" :xs="24" style="text-align: center">
                        <el-button type="text">刷新</el-button>
                        <span style="margin: 0px 10px;">|</span>
                        <el-button type="text">+新增运费模板</el-button>
                    </el-col>
                </el-row>

                <el-row class="row-top-20">
                    <el-col :span="12" :md="8" :xs="24">
                        <el-form-item label="保修服务">
                            <el-select v-model="base_form.warranty" placeholder="请选择">
                                <el-option v-for="item in warranty_list" :label="item.label"
                                           :value="item.value"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

            </el-col>
        </el-row>
    </el-form>

    <!--上架审核按钮-->
    <el-row>
        <el-col span="24" style="text-align: center">
            <el-button type="primary" size="large" @click="submitGoods()" :loading="is_submit">申请上架</el-button>
        </el-col>
    </el-row>


    <el-dialog title="批量修改" v-model="dialogFormVisible" size="tiny" close-on-press-escape="true"
               style="border-radius: 5px;">
        <el-form :model="batch_form" label-position="left" :label-width="formLabelWidth">
            <el-form-item :label="batch_form.label">
                <el-input v-model="batch_form.value" auto-complete="off"></el-input>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisible = false">取 消</el-button>
            <el-button type="primary" @click="batchChange()">修 改</el-button>
        </div>
    </el-dialog>


</div>


<script>
    //属性列表
    var spec_list = [
        {label: '风格', value: 1},
        {label: '口味', value: 2},
        {label: '颜色', value: 3},
        {label: '商品重量', value: 4},
        {label: '使用性别', value: 5}
    ];
    //运费模板
    var post_tpl_list = [
        {label: '模板一', value: '1'},
        {label: '模板二', value: '2'}
    ];

    //品牌列表
    var brand_list = [
        {label: '迪士尼', value: '迪士尼'}
    ];
    //产地列表
    var local_list = [
        {label: '北京', value: '北京'}
    ];
    //上市时间列表
    var up_time_list = [];
    for (var i = 2007; i < 2018; i++) {
        var item = {
            label: i + '年',
            value: i + '年'
        }
        up_time_list.push(item);
    }
    //保修服务
    var warranty_list = [
        {label: '6 个月', value: '6个月'},
        {label: '12 个月', value: '12个月'},
        {label: '18 个月', value: '18个月'},
        {label: '2 年', value: '2年'},
        {label: '3 年', value: '3年'}
    ];

    //上传文件配置
    var upload_config = {
        disabled_upload: false,
        accepts: 'image/jpeg, image/jpg, image/png, image/gif', //允许的文件类型
        max_size: 1048576, //最大体积1mb
        max_num: 5, //最大个数5
    };


    //商品分类列表
    var category_list = [
        {
            label: '科技数码',
            value: 1,
            children: []
        },
        {
            label: '家用电器',
            value: 2,
            children: []
        },
        {
            label: '办公用品',
            value: 3,
            children: []
        },
        {
            label: '家居家纺',
            value: 4,
            children: []
        }
    ];

    var data = {
        //分类列表
        category_list: [],
        //分类默认显示的数组
        default_category: [],
        //基本信息
        base_form: {
            category_breadcrumbs: "",
            title: "",
            code: "",
            barcode: "",
            is_more: "0",
            stocks: 0,
            cost_price: 0,
            images: "",
            //包装清单
            packing_list: "",
            //商品详情
            description: "",
            //运费模板
            logistics_tpl_id: "",
            //保修服务
            warranty: "",
            //规格配置
            config: "",
            //商品简介
            introduction: ""
        },
        //添加规格部分
        attr_block: [],
        //添加参数部分
        params_block: [],

        //详细介绍
        params_fix_block: {
            //基本属性内容
            product_code: '',
            brand: '',
            up_time: '',
            location: '',
            //额外属性内容
            extra_label: '',
            extra_value: ''
        },
        //详细介绍的中文对照
        params_fix_label: {
            product_code: '货号',
            brand: '商品品牌',
            up_time: '上市时间',
            location: '产地'
        },

        dialogFormVisible: false,
        formLabelWidth: '80px',

        //表单字段规则
        rules: {
            category_breadcrumbs: [
                {required: true, message: '请选择分类', trigger: 'change'}
            ],
            title: [
                {required: true, message: '请输入商品名', trigger: 'blur'}
            ],
            stocks: [
                {required: true, message: '请输入库存', trigger: 'blur'},
                {validator: checkNumber, trigger: 'change'},
            ],
            cost_price: [
                {required: true, message: '请输入价格', trigger: 'blur'},
                {validator: checkNumber, trigger: 'change'},
            ],
            product_code: [
                {max: 20, message: '长度不超过20', trigger: 'blur'}
            ],
            extra_label: [
                {required: true, message: '请输入参数', trigger: 'blur'},
                {max: 6, message: '上限 6 个字符', trigger: 'change'}
            ],
            extra_value: [
                {required: true, message: '请输入参数值', trigger: 'blur'},
                {max: 20, message: '上限 20 个字符', trigger: 'change'}
            ],
            images: [
                {required: true, message: '商品图片不能为空', trigger: 'change'},
                {validator: emptyArrayJson, trigger: 'change'}
            ],

            logistics_tpl_id: [
                {required: true, message: '请选择运费模板', trigger: 'change'}
            ],
            description: [
                {required: true, message: '请完善商品详情', trigger: 'change'}
            ]
        },
        //品牌列表
        brand_list: brand_list,
        //产地列表
        local_list: local_list,
        //上市时间列表
        up_time_list: up_time_list,
        //运费模板
        post_tpl_list: post_tpl_list,
        //保修服务列表
        warranty_list: warranty_list,

        //属性名列表
        spec_list: spec_list,
        //笛卡尔积处理的结果
        descartes_result: [],
        //生成笛卡尔积的需要组的条件
        data: [],

        //规格表单列表
        table_form: [],
        table_column_title: "规格",
        table_rules: {
            cost_price: [
                {required: true, message: '请输入价格', trigger: 'blur'}
            ],
            stocks: [
                {required: true, message: '请输入库存', trigger: 'blur'}
            ]
        },

        //批量修改
        batch_form: {
            key: "",
            value: "",
            label: ""
        },


        //所偶表单的验证状态
        confirm_all_form: false,
        //表单提交状态
        is_submit: false,


        //图片上传部分
        //上传图片列表
        img_list: [
            // {
            //     name: 'food.jpeg',
            //     url : 'http://ogew07qik.bkt.clouddn.com/1720170712172004_221104ChMkJ1YgmrqINnjWAAJNuXWyC8UAADvFwOY3rYAAk3R899.jpg',
            // },
        ],
        upload_config: {
            disabled_upload: false,
            accepts: 'image/jpeg, image/jpg, image/png, image/gif', //允许的文件类型
            max_size: 1048576, //最大体积1mb
            max_num: 5, //最大个数5
        },
        //商品详情列表
        img_list_desc: [],
        //商品详情图片上传
        upload_config_desc: {
            disabled_upload: false,
            accepts: 'image/jpeg, image/jpg, image/png, image/gif', //允许的文件类型
            max_size: 5048576, //最大体积5mb
            max_num: 1 //最大个数1
        }
    };
    var good_create = new Vue({
        el: '#create-page',
        mixins: [commonMethod],
        data: data,
        methods: {
            //所选分类变化的时候
            categoryChange: function (val) {
                var res = this.buildCategoryParams(val);
                console.log('当前被选分类', val, res);
                if (res.is_complete) {
                    this.base_form.category_breadcrumbs = JSON.stringify(res.body_pro);
                }
            },
            //分类 id 变化
            handleItemChange: function (val) {
                var res = this.buildCategoryParams(val);
//                console.log('所选分类',val,'category_list',this.category_list,'传入远程的条件',res);
                if (res.need_remote) {
                    var _self = this;
                    //显示加载动画
                    var loading = this.$loading({target: '.custom_popper', body: true});
                    var url = '/goods/category-list';
                    var params = {
                        params: {
                            category: res.body
                        }
                    };
                    axios.get(url, params)
                        .then(function (res) {
                            loading.close();
                            if (res.data.code == 200) {
                                _self.buildCategoryList(val, res.data.category_list);
                            } else {
                                _self.alertInfo(res.data.error);
                            }
                        })
                        .catch(function (error) {
                            loading.close();
                            _self.alertInfo('系统繁忙,请稍候');
                            console.log(error);
                        })
                }


            },
            //将 category_item 选择的参数转换成实际的 id
            buildCategoryParams: function (val) {
                //是否需要请求远程数据
                var need_remote = false;
                //是否是已经是三级数据
                var is_complete = false;
                var list = this.category_list;
                //转义后的 category_list
                var arr = [];
                //带上分类名的 category_list
                var arr_pro = [];

                for (index in val) {
                    var i = val[index];
                    arr.push(list[i].id);
                    arr_pro.push({
                        value: list[i].id,
                        label: list[i].label
                    });
                    if (list[i].children) {
                        //这里判定 <= 1 是为了编辑时好回溯路径
                        if (list[i].children.length <= 1) {
                            need_remote = true;
                        }
                        list = list[i].children;
                    } else {
                        is_complete = true;
                    }
                }
                var res = {
                    need_remote: need_remote,
                    is_complete: is_complete,
                    body: arr,
                    body_pro: arr_pro
                };
                return res;
            },
            /**
             * 补充分类列表树
             * @param val               分类列表的下标位置
             * @param children          准备添加的内容
             * @return category_list    返回分类列表
             */
            buildCategoryList: function (val, children) {
                if (val.length == 1) {
                    this.category_list[val[0]].children = children;
                } else if (val.length == 2) {
                    this.category_list[val[0]].children[val[1]].children = children;
                }

                return this.category_list;
            },
            //获取category列表,如果缓存中没有将从远程获取
            getCategoryList: function () {
                var category_list = this.getCache('category_list');
                if (category_list.length <= 1) {
                    var _self = this;
                    var url = '/goods/category-list';
                    axios.get(url).then(function (res) {
                        if (res.data.code == 200) {
                            _self.category_list = res.data.category_list;
                            //存入本地缓存
                            _self.lazySetCache('category_list', _self.category_list);
                            //重新初始化一下,规避异步带来的问题
                            _self.initCategorySelected();
                        }
                    })
                } else {
                    this.category_list = category_list;
                }
            },
            //初始化的时候将默认显示的分类给显示出来
            //思路是先查找到一级分类所在的索引,然后对这个选项下的子集进行构建,这是伪多级,一旦选项发生变动将更新成真实的 category_list
            initCategorySelected: function () {
                if (this.base_form.category_breadcrumbs == "") return;
                var selected_category = JSON.parse(this.base_form.category_breadcrumbs);
                //首先获取第一级分类所在的索引
                var first = selected_category[0];
                var index = null;
                for (i in this.category_list) {
                    if (this.category_list[i].id == first.value) {
                        index = parseInt(i);
                    }
                }
                if (index === null) return;

                //组建二三级的选项(都放在第一个选项上,如果有新的将会更新他们)
                var children = [
                    {
                        id: selected_category[1].value,
                        label: selected_category[1].label,
                        value: 0,
                        children: [
                            {
                                id: selected_category[2].value,
                                label: selected_category[2].label,
                                value: 0,
                            }
                        ]
                    }
                ];
                this.category_list[index].children = children;
                this.default_category = [index, 0, 0];
            },
            // 七牛上传一系列的方法
            //上传七牛前的处理
            beforeUpload: function (file) {
                console.log('上传前的准备', file, file.size);
                if (file.size > this.upload_config.max_size) {
                    this.alertInfo('图片大小不能超过1mb', 'warning');
                    return {};
                }

                var curr = moment().format('YYYMMDDHHmmss').toString();
                // var suffix = file.name;
                var suffix = 'tango_img';
                var uri = curr + '_' + suffix;
                key = encodeURI(uri);
                console.log('file_key is ' + key);
                this.uploadForm.key = key;

                return this.uploadForm;
            },
            handleSuccess: function (response, file, fileList) {
                var _self = this;
                //处理图片列表内容
                for (index in fileList) {
                    if (fileList[index].response.key) {
                        fileList[index].key = fileList[index].response.key;
                        fileList[index].host = _self.img_host;
                        fileList[index].indent = _self.image_indent;
                        fileList[index].url = _self.img_host + fileList[index].response.key + '?' + _self.image_indent;
                    }
                }
                // console.log('图片上传成功回调>>>>',response,file,fileList);

                this.img_list = fileList;

                // console.log('图片数量:',this.img_list.length);
                if (this.img_list.length >= this.upload_config.max_num) {
                    this.upload_config.disabled_upload = true
                }
            },
            //图片预览方法
            handlePreview: function (file) {
                console.log('图片预览', file);
                this.dialogImageUrl = file.url;
                this.imageDialogVisible = true;

                //获取展示图片的数组下标
                for (index in this.img_list) {
                    if (file.url == this.img_list[index].url) {
                        this.dialogImageIndex = index;
                    }
                }

            },
            //删除图片的方法
            handleRemove: function (file, fileList) {
                console.log('删除图片执行函数>>>>', file, fileList);
                this.img_list = fileList;

                console.log('图片数量:', this.img_list.length);
                if (this.img_list.length < this.upload_config.max_num) {
                    this.upload_config.disabled_upload = false
                }
            },

            //上传七牛前的处理
            beforeUploadDesc: function (file) {
                console.log('上传前的准备', file, file.size);
                if (file.size > this.upload_config_desc.max_size) {
                    this.alertInfo('图片大小不能超过5mb', 'warning');
                    return {};
                }

                var curr = moment().format('YYYMMDDHHmmss').toString();
                // var suffix = file.name;
                var suffix = 'tango_img';
                var uri = curr + '_' + suffix;
                key = encodeURI(uri);
                console.log('file_key is ' + key);
                this.uploadForm.key = key;

                return this.uploadForm;
            },
            //上传商品详情图片
            handleSuccessDesc: function (response, file, fileList) {
                var _self = this;
                //处理图片列表内容
                for (index in fileList) {
                    if (fileList[index].response.key) {
                        fileList[index].key = fileList[index].response.key;
                        fileList[index].host = _self.img_host;
                        fileList[index].indent = '';
                        fileList[index].url = _self.img_host + fileList[index].response.key + '?' + _self.image_indent;
                    }
                }
                console.log('商品详情上传成功回调>>>>', response, file, fileList);

                this.img_list_desc = fileList;

                // console.log('图片数量:',this.img_list.length);
                if (this.img_list_desc.length >= this.upload_config_desc.max_num) {
                    this.upload_config_desc.disabled_upload = true
                }
            },
            //商品详情预览方法
            handlePreviewDesc: function (file) {
                console.log('商品详情图片预览', file);
                this.dialogImageUrl = file.url;
                this.imageDialogVisible = true;

                //获取展示图片的数组下标
                for (index in this.img_list_desc) {
                    if (file.url == this.img_list_desc[index].url) {
                        this.dialogImageIndex = index;
                    }
                }
            },
            //删除商品详情的方法
            handleRemoveDesc: function (file, fileList) {
                console.log('删除商品详情执行函数>>>>', file, fileList);
                this.img_list_desc = fileList;

                console.log('商品详情数量:', this.img_list_desc.length);
                if (this.img_list_desc.length < this.upload_config_desc.max_num) {
                    this.upload_config_desc.disabled_upload = false
                }
            },


            //添加规格
            addAttrValue: function () {
//                console.log('添加属性值');
                //新增属性模板
                var tpl = {
                    //规格名
                    'label': "",
                    //规格名代表的 value
                    'value': "",
                    //属性值已选的值
                    'children': [],
                    //属性值备选的值
                    'child_value_list': [],
                    //新增规格值
                    'child_new_value': ""
                };
                this.attr_block.push(tpl);

            },

            /**
             * 更改规格值事件
             * @param pid
             */
            changeAttrValue: function (pid) {
                var _self = this;
                //清空子选项
                _self.attr_block[pid].children = [];
                var value = _self.attr_block[pid].value;
                var label = '';

                //找到规格对应的 label;
                _self.spec_list.map(function (item) {
                    if (item.value == value) {
                        label = item.label;
                    }
                });

                _self.attr_block[pid].label = label;
            },
            /**
             * 删除规格
             * @param pid
             */
            delAttrValue: function (pid) {
                var _self = this;


                _self.confirmHandle('此操作将删除规格及其下的值,是否继续?', function () {
                    //因为删除第二个元素导致后面的元素渲染错误,因此非最后一个元素只清空不移除
                    if (pid == _self.attr_block.length - 1) {
                        _self.attr_block.splice(pid, 1);
                    } else {
                        var tpl = {
                            //规格名
                            'label': "",
                            //规格名代表的 value
                            'value': "",
                            //属性值已选的值
                            'children': [],
                            //属性值备选的值
                            'child_value_list': [],
                            //新增规格值
                            'child_new_value': ""
                        };
                        _self.attr_block.splice(pid, 1, tpl)
                    }
                })
            },
            /**
             * 添加规格值
             * @param pid   规格名的数组索引
             */
            addAttrChild: function (pid) {
                var attr = this.attr_block[pid].value;
                var new_value = this.attr_block[pid].child_new_value;
//                console.log(pid,attr,new_value);
                if (attr == "") {
                    this.alertInfo('请先选择规格', 'warning');
                    return;
                }
                if (new_value == "") {
                    this.alertInfo('请先输入规格值', 'warning');
                    return;
                }

                if (this.attr_block[pid].children.length >= 30) {
                    this.alertInfo('最多输入 30 个属性值', 'warning');
                    return;
                }

                //组一个新的属性值内容
                var item = {label: new_value, value: ""};
                this.attr_block[pid].children.push(item);
                this.attr_block[pid].child_new_value = "";
            },
            /**
             * 删除规格值
             * @param pid   规格名的数组索引
             * @param id    规格值的数组索引(attr_block[pid].child[id])
             */
            delAttrChild: function (pid, id) {
                this.attr_block[pid].children.splice(id, 1);
            },
            //构建 config 内容
            buildConfig: function () {
                var config = [];
                var data = this.attr_block;
                var i = 1;
                for (index in data) {
                    if (data[index].children.length == 0) {
                        continue;
                    }
                    var key = 'attr' + i;
                    i++;
                    var tpl = {
                        name: key,
                        value: data[index].value,
                        label: data[index].label
                    };
                    config.push(tpl)
                }
                return config;
            },
            //构建完整的规格值table 内容
            buildTable: _.debounce(function () {
                var data = this.attr_block;
//                var config = this.buildConfig();
//                console.log('config',config);

                //将所有的规格和其下的属性集中起来
                var tpl = [];
                var i = 0;
                for (pid in data) {
                    if (data[pid].children.length != 0) {
                        tpl[i] = data[pid].children;
                        i++;
                    }
                }
                this.data = tpl;


                //根据集中起来的规格生成笛卡尔积
                this.descartes_result = [];
                this.descartes(0, []);
//                console.log('descartes',this.descartes_result);

            }, 1000),
            //生成笛卡尔积函数
            descartes: function (arrIndex, aresult) {
                if (arrIndex >= this.data.length) {
                    this.descartes_result.push(aresult);
                    return;
                }
                var aArr = this.data[arrIndex];
                for (var i = 0; i < aArr.length; ++i) {
                    var theResult = aresult.slice(0, aresult.length);
                    theResult.push(aArr[i]);
                    this.descartes(arrIndex + 1, theResult);
                }
            },
            //生成规格列表模板
            generateTable: function () {
                console.log('生成规格列表', this.descartes_result);

                var table_data = this.descartes_result.map(function (item) {
                    var str = "";
                    for (index in item) {
                        str += item[index].label;
                    }

                    var tpl = {
                        //字段属性
                        columns: item,
                        cost_price: 0,
                        code: "",
                        stocks: 0,
                        title: str,
                        id: ""
                    };
                    return tpl;
                });

                this.table_form = table_data;


                //更新规格字段信息
                var config = this.buildConfig();
                var title = "";
                for (index in config) {
                    if (index != 0) {
                        title += ' - ';
                    }
                    title += config[index].label;
                }

                this.table_column_title = title;
//                console.log(table_data,title);
            },
            //计算库存和价格
            //打印table 内容
            console: function () {
                console.log('table_form 结构:', this.table_form, this.dialogFormVisible);
                console.log('attr_block 结构', this.attr_block);
            },
            //打开批量修改模态框
            openDialog: function (key, label) {
                this.dialogFormVisible = true;
                this.batch_form.key = key;
                this.batch_form.label = label;
            },
            //关闭模态框
            closeDialog: function () {
                this.dialogFormVisible = false;
                this.batch_form = {key: "", value: ""}
            },
            //批量修改内容
            batchChange: function () {
                var title = this.batch_form.key;
//                console.log(title,this.table_form)
                for (index in this.table_form) {
                    this.table_form[index][title] = this.batch_form.value;
                }
                this.closeDialog();
            },
            //添加参数
            addParams: function () {
//                console.log('添加参数',this.params_fix_block);
                var _self = this;
                this.$refs['paramsForm'].validate(function (valid) {
                    if (valid) {
                        var tpl = {
                            label: _self.params_fix_block.extra_label,
                            value: _self.params_fix_block.extra_value
                        };
                        _self.params_block.push(tpl);
                        _self.params_fix_block.extra_label = '';
                        _self.params_fix_block.extra_value = '';
//                        console.log('显示参数列表',_self.params_block)
                    }
                })
            },
            //删除参数
            deleteParam: function (index, item) {
                this.params_block.splice(index, 1);
            },
            //提交商品表单
            submitGoods: function () {
//                var res = this.validateAllForms();
//                console.log('验证表单',res);
                if (!this.validateAllForms()) return;

                if (this.base_form.is_more == '1') {
                    var config = this.buildConfig();
                    this.base_form.config = JSON.stringify(config);
                }
                //将配置表添加到基础信息当中
//                console.log('通过验证')
//                console.log('基础表单',this.base_form);
//                console.log('固定参数',this.params_fix_block);
//                console.log('新增参数',this.params_block);
//                console.log('规格信息',this.attr_block);
//                console.log('规格列表',this.table_form);

                //将固定参数和新增参数组合
                var params = [];
                for (key in this.params_fix_block) {
//                    console.log('参数:'+key,'值:'+this.params_fix_block[key]);
                    if (key == 'extra_label' || key == 'extra_value') continue;
                    if (this.params_fix_block[key] != '') {
                        var tpl = {
                            label: this.params_fix_label[key],
                            value: this.params_fix_block[key]
                        };
                        params.push(tpl);
                    }
                }
                var params_block = this.params_block;
                for (index in this.params_block) {
                    if (params_block[index].label != '' && params_block[index].value != '') {
                        params.push(params_block[index])
                    }
                }
                this.base_form.attributes = JSON.stringify(params);


                //获取规格信息
                this.base_form.spec_info = JSON.stringify(this.attr_block);
                //获取规格列表
                this.base_form.sku_list = JSON.stringify(this.table_form);


                var _self = this;
                this.postMethod('/goods/store', this.base_form, function (res) {
                    if (res.data.code == 200) {
                        _self.alertInfo('已申请上架', 'success');
                        _self.clearCache();
                        console.log('此处可能有跳转,商品 id=' + res.data.goods_id);
                        setTimeout(function () {
                            location.href = '/goods/create';
                        }, 1000);
                    }
                }, 'is_submit');


            },
            //验证所有表单
            validateAllForms: function () {
                var _self = this;

                var pass = 0;
                //验证 基本信息 部分
                this.$refs['base_form'].validate(function (valid) {
                    if (valid) {
                        console.log('base_form 验证正常');
                        pass++;
                    } else {
                        console.log('base_form 验证失败')
                    }
                });

                //验证 详细介绍 部分
                this.$refs['infoForm'].validate(function (valid) {
                    if (valid) {
                        console.log('infoForm 验证正常')
                        pass++
                    } else {
                        console.log('infoForm 验证失败')
                    }
                });

                //验证 其他/物流 部分
                this.$refs['otherForm'].validate(function (valid) {
                    if (valid) {
                        console.log('otherForm 验证正常')
                        pass++
                    } else {
                        console.log('otherForm 验证失败')
                    }
                });

                console.log('验证结果', pass);

                if (pass == 3) {
                    return true;
                } else {
                    this.alertInfo('请完善表单信息', 'warning');
                    return false;
                }

            },
            //获取添加商品时需要用到的资源
            getResource: function () {
                var type = ['brand_list', 'local_list', 'spec_list', 'post_tpl_list'];
                var params = {
                    params: {
                        type: type
                    }
                };
                var url = '/goods/resource';
                var _self = this;
                axios.get(url, params)
                    .then(function (res) {
                        if (res.data.code == 200) {
                            var resource = res.data.resource;
                            for (key in resource) {
                                _self.$data[key] = resource[key]
                            }
                        } else {
                            _self.batchError(res.data.error);
                        }
                    })
                    .catch(function (error) {
                        _self.$data[loading] = false;
                        _self.alertInfo('系统繁忙,请稍候');
                        console.log(error);
                    })

            },
            //从缓存中获取整个表单内容
            getFormCache: function () {
                //获取缓存中的内容
                this.attr_block = this.getCache('attr_block');
                this.img_list = this.getCache('img_list');
                this.table_form = this.getCache('table_form');
                this.params_block = this.getCache('params_block');
                this.img_list_desc = this.getCache('img_list_desc');

                var base_form = this.getCache('base_form');
                if (base_form.category_breadcrumbs !== undefined) {
                    this.base_form = base_form;
                }

                var params_fix_block = this.getCache('params_fix_block');
                if (params_fix_block.brand !== undefined) {
                    this.params_fix_block = params_fix_block;
                }
            }

        },
        mounted: function () {
            this.getFormCache();
            //获取七牛云上传 token
            this.getImageToken();
            //获取分类列表
            this.getCategoryList();
            //初始化三级分类的选择情况
            this.initCategorySelected();
            this.upload_config = upload_config;


            //获取添加商品时需要用到的资源
//            this.getResource();
        },
        //监听属性名变化
        watch: {
            "base_form": {
                deep: true,
                handler: function (val) {
                    this.lazySetCache('base_form', val);
                }
            },
            "params_fix_block": {
                deep: true,
                handler: function (val) {
                    this.lazySetCache('params_fix_block', val);
                }
            },

            "attr_block": {
                deep: true,
                handler: function (val) {
//                    console.log('watch',val);
                    this.lazySetCache('attr_block', val);
                    this.buildTable();
                }
            },
            "params_block": {
                deep: true,
                handler: function (val) {
                    this.lazySetCache('params_block', val);
                }
            },
            "table_form": {
                deep: true,
                handler: function (val) {
//                    console.log('计算 table_form');

//                    this.lazySetCache('table_form',val);
                    if (this.base_form.is_more == '1') {
                        //获得最大库存
                        var total_stocks = 0;
                        //获得最小价格
                        var lowest_cost_price = 0;

                        for (index in val) {
                            total_stocks += parseInt(val[index].stocks);

                            if (index == 0) {
                                lowest_cost_price = parseInt(val[index].cost_price);
                            } else {
                                if (val[index].cost_price < lowest_cost_price) {
                                    lowest_cost_price = val[index].cost_price
                                }
                            }
                        }
//                        console.log('库存:'+ total_stocks,'价格:'+lowest_cost_price);
                        this.base_form.cost_price = lowest_cost_price.toString();
                        this.base_form.stocks = total_stocks.toString();
                        this.setCache('table_form', val);
                    }
                }
            },
            'img_list': {
                deep: true,
                handler: function (val) {
                    // console.log('存入缓存',val);
                    this.setCache('img_list', val);
                    var images = [];
                    for (index in this.img_list) {
                        var url = this.img_list[index].host + this.img_list[index].key;
                        var tpl = {
                            host: this.img_list[index].host,
                            key: this.img_list[index].key,
                            url: url,
                            name: this.img_list[index].key
                        }
                        images.push(tpl);
                    }
                    this.base_form.images = JSON.stringify(images);
                }
            },
            'img_list_desc': {
                deep: true,
                handler: function (val) {
                    this.setCache('img_list_desc', val);
                    var image = '';
                    if (this.img_list_desc.length >= 1) {
                        image = this.img_list_desc[0].host + this.img_list_desc[0].key
                    }
                    this.base_form.description = image;
                }
            }

        }
    });
</script>