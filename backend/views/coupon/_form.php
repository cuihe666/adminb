<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CouponBatch */
/* @var $form yii\widgets\ActiveForm */
?>

<el-form ref="form" :model="form" label-width="80px">

    <el-row :gutter="20">
        <el-col :lg="8" :sm="12">
            <el-form-item
                label="资源供给方"
                label-width="120px"
                prop="create_name"
                :rules="[
                    { required: true, message: '供给方不能为空'},
                ]">

                <el-input v-model="form.create_name"></el-input>

            </el-form-item>
        </el-col>

        <el-col :lg="6"  :sm="12" :xs="{offset:4}">
            <div class="el-form-item">
                <label class="el-form-item__label"   label-width="120px" style="color: #99A9BF;">*多个供应方请用英文半角逗号隔开</label>
            </div>
        </el-col>
    </el-row>

    <el-row :gutter="20">
        <el-col :lg="8" :sm="12">
            <el-form-item
                label="优惠券名称"
                label-width="120px"
                prop="batch_code"
                :rules="[
                    { required: true, message: '优惠券名称不能为空',trigger: 'onBlur'},
                ]">
                <el-select
                    v-model="form.batch_code"
                    filterable
                    remote
                    placeholder="输入优惠券名称"
                    :remote-method="remoteMethod"
                    @change="changeSome()"
                    loading-text="加载中"
                    :loading="loading">
                    <el-option
                        v-for="item in batch_list"
                        :key="item.batch_code"
                        :label="item.title"
                        :value="item.batch_code">
                        <span style="float: left">{{ item.title }}</span>
                        <span style="float: right; color: #8492a6; font-size: 13px">{{ item.batch_code }}</span>
                    </el-option>
                </el-select>
            </el-form-item>
        </el-col>

        <el-col :lg="6" :sm="12" :xs="{offset:4}">
            <div class="el-form-item">
                <label class="el-form-item__label" style="color: #99A9BF;">*必填,优惠券名称唯一</label>
            </div>
        </el-col>
    </el-row>


    <el-row :gutter="20" v-if="false">
        <el-col :lg="8" :sm="12">
            <el-form-item
                label="优惠券名称"
                label-width="120px"
                prop="title"
                :rules="[
                    { required: true, message: '优惠券名称不能为空'},
                ]">

                <el-input v-model="form.title" @blur="changeTitle()"></el-input>

            </el-form-item>
        </el-col>

        <el-col :lg="6" :sm="12" :xs="{offset:4}">
            <div class="el-form-item">
                <label class="el-form-item__label" style="color: #99A9BF;">*必填</label>
            </div>
        </el-col>
    </el-row>


    <el-row :gutter="20">
        <el-col :lg="8" :sm="12">
            <el-form-item
                label="订单满减"
                label-width="120px"
                prop="rule"
                :rules="[
                  { type: 'number', message: '必须为数字值'}
                ]"
            >
                <el-input v-model.number="form.rule"></el-input>
            </el-form-item>
        </el-col>

        <el-col :lg="6" :sm="12" :xs="{offset:4}">
            <div class="el-form-item">
                <label class="el-form-item__label" style="color: #99A9BF;">*默认为0,表示不限制使用金额</label>
            </div>
        </el-col>
    </el-row>


    <el-row :gutter="20">
        <el-col :lg="8" :sm="12">
            <el-form-item
                label="优惠券金额"
                label-width="120px"
                prop="amount"
                :rules="[
                     { required: true, message: '不能为空'},
                     { type: 'number',min: 1, message: '必须为数字值且最小值为1'}
                ]"
            >
                <el-input v-model.number="form.amount"></el-input>
            </el-form-item>
        </el-col>

        <el-col :lg="6" :sm="12" :xs="{offset:4}">
            <div class="el-form-item">
                <label class="el-form-item__label" style="color: #99A9BF;">*必填项,设置可扣金额,最小为1</label>
            </div>
        </el-col>
    </el-row>


    <el-row :gutter="20">
        <el-col :lg="8" :sm="12">
            <el-form-item
                label="优惠券有效期"
                label-width="120px"
                prop="is_forever"
                :rules="[
                     { required: true, message: '不能为空'},
                     { type: 'enum',enum: ['0','1'], message: '超出允许范围'}
                ]"
            >
                <el-radio-group v-model="form.is_forever">
                    <el-radio label="1">永久有效</el-radio>
                    <el-radio label="0">区间内有效</el-radio>
                </el-radio-group>
            </el-form-item>
        </el-col>
        <el-col :lg="4" :sm="6" :xs="{offset:4}" v-if="form.is_forever == '0'">
            <el-date-picker
                v-model="start_end"
                type="daterange"
                format="yyyy-MM-dd"
                placeholder="选择日期范围">
            </el-date-picker>
        </el-col>

        <el-col :lg="{span:6,offset:1}" :sm="{span:4,offset:2}" :xs="{offset:4}">
            <div class="el-form-item">
                <label class="el-form-item__label" style="color: #99A9BF;margin-left: 20px">*必填</label>
            </div>
        </el-col>
    </el-row>


    <el-row :gutter="20">
        <el-col :lg="24" :sm="24">
            <el-form-item
                label="优惠券类型"
                label-width="120px"
                prop="type"
                :rules="[
                     { type: 'enum',enum: ['0','1','2','3'], message: '超出允许范围'}
                ]"
            >
                <el-radio-group v-model="form.type">
                    <el-radio label="0">通用</el-radio>
                    <el-radio label="1">民宿</el-radio>
                    <el-radio label="2">旅行</el-radio>
                    <el-radio label="3">酒店</el-radio>
                </el-radio-group>
            </el-form-item>
        </el-col>

    </el-row>

    <el-row :gutter="20">
        <el-col :lg="24" :sm="24">
            <el-form-item label="使用平台" label-width="120px">
                <el-radio-group v-model="form.platform">
                    <el-radio label="0">通用</el-radio>
                    <el-radio label="1">APP专享</el-radio>
                    <el-radio label="2">H5专享</el-radio>
                </el-radio-group>
            </el-form-item>
        </el-col>
    </el-row>


    <el-row :gutter="20">
        <el-col :lg="8" :sm="12">
            <el-form-item
                label="发放总量(张)"
                label-width="120px"
                prop="num"
                :rules="[
                      { type: 'number',min: 1, message: '必须为数字值且最小值为1'}
                ]"
            >
                <el-input v-model.number="form.num"></el-input>
            </el-form-item>
        </el-col>

        <el-col :lg="12" :sm="12" :xs="{offset:4}">
            <div class="el-form-item">
                <label class="el-form-item__label" style="color: #99A9BF;">*优惠券的总数量(当设置为<可导出>时,数量请在1万以内)</label>
            </div>
        </el-col>
    </el-row>

    <el-row :gutter="20">
        <el-col :lg="8" :md="12">
            <el-form-item label="预算总额(元)" label-width="120px">
                <el-input :disabled="true" v-model="budget"></el-input>
            </el-form-item>
        </el-col>

        <el-col :lg="8" :sm="12" :xs="{offset:4}">
            <div class="el-form-item">
                <label class="el-form-item__label" style="color: #99A9BF;">*营销预算 (发放张数*优惠券金额)</label>
            </div>
        </el-col>
    </el-row>


    <el-row :gutter="20">
        <el-col :lg="12" :sm="12">
            <el-form-item label="是否支持导出" label-width="120px">
                <el-switch on-text="是" off-text="否" on-value="1" off-value="0" v-model="form.mode"></el-switch>
            </el-form-item>
        </el-col>
    </el-row>

    <el-row :gutter="20">
        <el-col :lg="8" :sm="12">
            <el-form-item
                label="用户最多领取(张)"
                label-width="120px"
                prop="max_num"
                :rules="[
                      { type: 'number',min: 1,max:100, message: '必须为数字值且1-100之间'}
                ]"
            >
                <el-input v-model.number="form.max_num"></el-input>
            </el-form-item>
        </el-col>

        <el-col :lg="8" :sm="12" :xs="{offset:4}">
            <div class="el-form-item">
                <label class="el-form-item__label" style="color: #99A9BF;">*用户领取优惠券的上限,默认是1张</label>
            </div>
        </el-col>
    </el-row>

    <el-row :gutter="20">
        <el-col :lg="12" :sm="12">
            <el-form-item
                label="描述"
                label-width="120px"
                prop="description"
                :rules="[
                    { max: 255, message: '上限255个字'},
                ]">

                <el-input
                    type="textarea"
                    v-model="form.description"
                    :autosize="{ minRows: 3, maxRows: 6}"
                    placeholder="请输入内容"
                ></el-input>

            </el-form-item>
        </el-col>

    </el-row>





    <el-form-item>
        <el-button type="primary" v-if="on_submit">保存信息 <i class="el-icon-loading"></i></el-button>
        <el-button type="primary" @click="onSubmit('form')" v-else>保存信息</el-button>
        <el-button @click="location.href='/coupon/index'">返回列表</el-button>
    </el-form-item>
</el-form>
