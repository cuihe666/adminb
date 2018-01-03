<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/4/20
 * Time: 下午2:43
 */

?>


<section v-cloak id="supplier-contact">
<p class="btn btn-primary add_person" @click="addItem()">添加联系人</p>
    <i style="color: #f53e3e;display: none;" id="contact_error">请添加联系人</i>
    <input type="hidden" v-model="contact_num" id="contact_num">
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
    <ul class="content_item content_con clearfix" v-for="(item,index) in contant_list">
        <li class="li_item">
            <span v-if="item.status == 'show'">{{ item.type }}</span>
            <input style="display: block;" type="text" placeholder="请输入联系人" v-if="item.status == 'add' || item.status == 'edit'" v-model="contant_list[index].type">
        </li>
        <li class="li_item">
            <span v-if="item.status == 'show'">{{ item.name }}</span>
            <input style="display: block;" type="text" placeholder="请输入姓名" v-if="item.status == 'add' || item.status == 'edit'" v-model="contant_list[index].name">
        </li>
        <li class="li_item">
            <span v-if="item.status == 'show'">{{ item.job }}</span>
            <input style="display: block;" type="text" placeholder="请输入职务" v-if="item.status == 'add' || item.status == 'edit'"  v-model="contant_list[index].job">
        </li>
        <li class="li_item">
            <span v-if="item.status == 'show'">{{ item.mobile }}</span>
            <input style="display: block;" type="text" placeholder="请输入手机号码" maxlength="11" v-if="item.status == 'add' || item.status == 'edit'" v-model="contant_list[index].mobile">
        </li>
        <li class="li_item">
            <span v-if="item.status == 'show'">{{ item.email }}</span>
            <input style="display: block;" type="text" placeholder="请输入E-mail" v-if="item.status == 'add' || item.status == 'edit'" v-model="contant_list[index].email">
        </li>
        <li class="li_item">
            <span v-if="item.status == 'show'">{{ item.landline }}</span>
            <input style="display: block;" type="text" placeholder="请输入电话" v-if="item.status == 'add' || item.status == 'edit'" v-model="contant_list[index].landline">
        </li>
        <li class="li_item">
            <div class="op_eds">
                <p class="edit" v-if="item.status == 'show'" @click="editItem(index)">编辑</p>
                <p style="display: block" class="save" v-else @click="storeItem(index)">
                    <i class="el-icon-loading" v-if="item.on_store"></i>
                    <i v-else>保存</i>

                </p>
            </div>
            <p class="delete"  @click="delConfirm(index)">
                <i class="el-icon-loading" v-if="item.on_del"></i>
                <i v-else>删除</i>
            </p>
        </li>
    </ul>
</div>
</section>


