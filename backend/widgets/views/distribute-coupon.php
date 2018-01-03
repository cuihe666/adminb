<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/6/8
 * Time: 下午5:50
 */
//已经调用过基础文件包了 这里是使用它的模态框,element 的模态框样式有太多的问题不稳定
//\backend\assets\AppAsset::register($this);
\backend\assets\VueAsset::register($this);
?>


<a class="btn btn-success vm_<?= $vue_id ?>" href="###" id="vm_<?= $vue_id ?>" data-toggle="modal" data-target="#vm_<?= $vue_id ?>_modal"><?= $title ?></a>
<!-- Modal -->
<div class="modal fade vm_<?= $vue_id ?>" tabindex="-1" role="dialog" id="vm_<?= $vue_id ?>_modal" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 5px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= $title ?></h4>
            </div>
            <div class="modal-body">
                <el-row>
                    <el-col :span="24">
                        <el-form :model="form" label-width="80px" ref="form_<?= $vue_id ?>">
                            <!--用户 id 输入框-->
                            <el-row :gutter="10">
                                <el-col :offser="2" :span="16">
                                    <el-form-item
                                        label="用户信息"
                                        prop="user"
                                        :rules="ruler.user"
                                    >
                                        <el-input v-model.number="form.user" placeholder="用户ID或手机号"></el-input>
                                    </el-form-item>
                                </el-col>

                                <el-col :span="4" >
                                    <el-button type="primary" v-if="loading">
                                        <i class="el-icon-loading"></i>
                                    </el-button>

                                    <el-button type="primary" v-else @click="searchUser()">
                                        <i class="el-icon-search"></i>
                                    </el-button>

                                </el-col>
                            </el-row>


                            <!--信息展示部分-->
                            <el-row v-loading="loading" v-if="show_content">
                                <el-col :span="8">
                                    <el-form-item label="昵称:">
                                        {{ form.info.nickname }}
                                    </el-form-item>
                                </el-col>
                                <el-col :span="12">
                                    <el-form-item label="姓名:">
                                        {{ form.info.name }}
                                    </el-form-item>
                                </el-col>

                                <el-col :span="8">
                                    <el-form-item label="性别:">
                                        {{ form.info.sex }}
                                    </el-form-item>
                                </el-col>
                                <el-col :span="12">
                                    <el-form-item label="最新预订:">
                                        {{ form.info.order.order_num }}
                                    </el-form-item>
                                    <el-form-item label="订单时间:">
                                        {{ form.info.order.create_time }}
                                    </el-form-item>
                                </el-col>
                            </el-row>


                            <!--优惠券输入框-->
                            <el-row :gutter="10" v-if="show_content">
                                <el-col :offser="2" :span="16">
                                    <el-form-item
                                        label="优惠券"
                                        prop="ticket"
                                        :rules="ruler.ticket"
                                    >
                                        <el-input v-model="form.ticket"  placeholder="输入优惠券兑换码"></el-input>
                                    </el-form-item>
                                </el-col>

                            </el-row>

                        </el-form>
                    </el-col>
                </el-row>

            </div>
            <div class="modal-footer">
                <el-button type="primary"  v-if="show_content && binding">绑定优惠券<i class="el-icon-loading"></i></el-button>
                <el-button type="primary" @click="bindTicket()" v-if="show_content && !binding">绑定优惠券</el-button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<script>
    var csrf_token = '<?= Yii::$app->request->csrfToken ?>';
    var form_name = "form_<?= $vue_id ?>";
    var vm_<?= $vue_id ?> = new Vue({
        el : '#vm_<?= $vue_id ?>_modal',
        data: {
            msg : 'hello',
            //显示信息内容
            show_content: false,
            //加载信息
            loading: false,
            //绑定优惠券
            binding: false,
            form: {
                user: 0,
                info: {
                    nickname: "--",
                    name: "--",
                    sex: "--",
                    order: {
                        order_num: "--"
                    }
                },
                ticket: ""
            },
            ruler: {
                user: [
                    { required: true, message: '不能为空'},
                    { type: 'number', message: '必须为数字值'}
                ],
                ticket: [
                    { required: true, message: '不能为空',trigger:'blur'}
                ]
            }
        },
        methods: {
            openModal: function(){
                $('#vm_<?= $vue_id ?>_modal').modal('show')
            },
            searchUser: function(){
                var _self = this;
                this.$refs[form_name].validate(function(valid){
                    if (valid) {
                        _self.postUser(_self.form.user);
                        return true;
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                })

            },
            postUser: function(id_phone){
                var _self = this;
                _self.loading = true;

                var form_data = new FormData();
                form_data.append('_csrf-backend', csrf_token);
                form_data.append('id_phone',id_phone);

                var url = "/coupon/search-user";
                axios.post(url,form_data)
                    .then(function(res){
                        _self.loading = false;
                        console.log(res,'get result');
                        if(res.data.code == 200){
                            _self.show_content = true;
                            _self.form.info = res.data.body
                        }else{
                            _self.alertInfo(res.data.error,'error');
                            _self.show_content = false;
                        }
                    })
                    .catch(function(error){
                        _self.loading = false;
                        _self.show_content = false;
                        console.log(error);
                    })

            },
            bindTicket: function(){
                var _self = this;
                this.$refs[form_name].validate(function(valid){
                    console.log(valid)
                    if (valid) {
                        _self.postTicket(_self.form);
                        return true;
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                })
            },
            //绑定优惠券
            postTicket: function(form){
                var _self = this;
                _self.binding = true;

                var form_data = new FormData();
                form_data.append('_csrf-backend', csrf_token);
                form_data.append('id_phone',form.user);
                form_data.append('ticket',form.ticket);

                var url = "/coupon/bind-ticket";
                axios.post(url,form_data)
                    .then(function(res){
                        _self.binding = false;
                        console.log(res)
                        if(res.data.code == 200){
                            _self.alertInfo('发放成功,' + res.data.msg,'success');
                        }else{
                            _self.alertInfo(res.data.error,'error');
                        }
                        _self.form.ticket = ""
                    })
                    .catch(function(error){
                        _self.binding = false;
                        _self.alertInfo("发生错误,请联系管理员","error");
                        console.log(error);
                    })

            },
            //生成提示的方法
            alertInfo: function(msg,type,action){
                if(action == 'alert'){
                    this.$alert( msg,'提示',{
                        closeOnPressEscape: true
                    })
                }else{
                    this.$notify({
                        title: '提示',
                        message: msg,
                        type: type
                    });
                }

            }

        }
    })
</script>