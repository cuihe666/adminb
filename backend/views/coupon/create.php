<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CouponBatch */

$this->title = '基础信息';
$this->params['breadcrumbs'][] = ['label' => '批次列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\VueAsset::register($this);
?>
<div class="coupon-batch-create animated fadeIn" id="coupon" v-cloak>

    <el-row>
        <el-col>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </el-col>
    </el-row>


</div>

<script>

    var coupon = new Vue({
        el: "#coupon",
        data: {
            form: {
                create_name: "",
                title: "",
                rule: 0,
                amount: 1,
                is_forever: "",
                start_time: "",
                end_time: "",
                type: "0",
                num: 1,
                mode: "0",
                max_num: 1,
                batch_code: "",
                platform: "0",
                description: ""
            },
            //起止时间
            start_end: [],
            //是否禁止输入供应商内容(如果复用已有的优惠券批次则禁止填写新的优惠券批次)
            is_disable_name: false,
            //是否是远程获取数据的状态
            loading: false,
            //默认的优惠券批次列表
            batch_list:[],
            //是否已经点击提交
            on_submit: false,
            //新增批次文本
            new_batch_text: '新增批次'
        },
        watch: {
            //监听时间改变状态
            start_end: function(){
                this.form.start_time = this.timeFomate(this.start_end[0]);
                this.form.end_time = this.timeFomate(this.start_end[1]);
//                console.log(this.start_end);
//                console.log(this.form.start_time,this.form.end_time);
            }
//            form: {
//                deep: true,
//                handler: function(val,oldVal){
//                    if(val.title != ""){
//                        var title = val.title;
//                        var checkTitle = false;
//                        this.batch_list.map(function(item){
//                            if(item.title == title){
//                                checkTitle = true;
//                            }
//                        });
//
//                        if(!checkTitle){
//                            this.form.batch_code = "";
//                        }
//                    }
//                }
//            }
        },
        computed: {
            //预算计算
            budget: function(){
                var money = parseInt(this.form.amount);
                var num = parseInt(this.form.num);
                var res = money * num;
                return res || 0;
            }
        },
        methods: {
            //提交按钮
            onSubmit:function(formName){
                var _self = this;
                this.$refs[formName].validate(function(valid){
                    if (valid) {
                        var post_url = '/coupon/store';
                        _self.postMethod(post_url,_self.form);
                    } else {
                        _self.alertInfo('提交内容不规范,请完善.','warning');
                    }
                });
            },
            //提交到远程服务器的方法
            postMethod: function(url,formData){
                var _self = this;
                _self.on_submit = true;
                var form_data = new FormData();
                for(key_name in formData){
                    form_data.append(key_name,this.form[key_name]);
//                    console.log(key_name,this.form[key_name])
                }
                //判断是否是新增批次
                if(_self.new_batch_text == this.form.batch_code){
                    form_data.append('batch_code','');
                }

                form_data.append('_csrf-backend', '<?= Yii::$app->request->csrfToken ?>');

                axios.post(url,form_data).then(function(res){
                    _self.on_submit = false;
                    var result = res.data;
                    if(result.code == 200){
                        _self.alertInfo('保存成功,即将跳转到列表页','success');
                        console.log('此处应该跳转');
                        location.href = '/coupon/index';
                    }else{
                        _self.alertInfo(result.error,'error');

                    }
                })
                .catch(function (error) {
                    _self.on_submit = false;
                    console.log('error',error)
                    _self.alertInfo('权限不足','warning');
                })

            },
            //异步请求批次列表的内容
            getMethod: function(url,query){
                var _self = this;
                this.loading = true;
                axios.get(url).then(function(res){
                    _self.loading = false;
                    _self.batch_list = res.data;

                    var in_list = false;
                    _self.batch_list.map(function(item){
                        if(item.title == query){
                            in_list = true
                        }
                    });
                    //如果没在列表里将新增一个批次(7.7日将新增批次选为固定选项)
//                    if(!in_list){
                        var item = {title:query,batch_code:_self.new_batch_text};
                        _self.batch_list.unshift(item);
//                    }
                })
            },
            //远程获取已有批次的方法
            remoteMethod: function(query){
                query = query.replace(/^\s+|\s+$/g,"");
                if(query == '') return false;
                var _self = this;

                //检测是否已经存在列表当中
                if(this.optionExist(query)){
                    return false;
                }

                setTimeout(function(){
//                    console.log(query);
                    var url = '/coupon/batch-list?key=' + query;
                    _self.getMethod(url,query);
                },200);

            },
            //优惠券批次发生更改时触发事件
            changeSome: function(){
                var batch_code = this.form.batch_code;
                if(batch_code == "") return false;
                var title = '';
                var res = this.batch_list.map(function(item){
                    if(item.batch_code == batch_code){
                        title = item.title;
                    }
                })
                this.form.title = title;
            },
            changeTitle: function(){
                var val = this.form;
                if(val.title != ""){
                    var title = val.title;
                    var checkTitle = false;
                    this.batch_list.map(function(item){
                        if(item.title == title){
                            checkTitle = true;
                        }
                    });

                    if(!checkTitle){
                        val.batch_code = "";
                    }
                }
            },
            //时间格式化
            timeFomate: function(date){
                if(!date) return '';
                var year = date.getYear() + 1900;
                var month = date.getMonth() + 1;
                var day = date.getDate();
                var str =  year + '-' + month + '-' + day;
                return str;
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

            },
            //检测是否选择的是已存在的列表内容,为了减少远程请求
            optionExist: function(title){
                var res = false;
                this.batch_list.map(function(item){
                    if(item.title == title){
                        res = true;
                    }
                });
                return res;
            }
        }
    });
</script>
