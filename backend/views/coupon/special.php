<?php
use yii\helpers\Html;
use common\tools\Helper;
use backend\controllers\CouponController;
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/6/5
 * Time: 上午11:19
 */

$this->title = '指定产品';
$this->params['breadcrumbs'][] = ['label' => '批次列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\VueAsset::register($this);
?>
<?= \backend\widgets\CheckIEWidget::widget() ?>
<style>
    .el-row {
        margin-bottom: 20px;
    }
    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }
    .el-row:last-child {
         margin-bottom: 0;
     }
    .el-col {
        border-radius: 4px;
    }
    .bg-purple-dark {
        background: #324057;
    }
    .p-color {
        color: #F9FAFC;
        line-height: 36px;
        height: 36px;
        display: inline-block;
        margin:0px;
    }

</style>

<div id="special_page">
    <el-row class="bg-purple-dark grid-content"  v-if="permission">
        <el-col :span="12" :offset="1">
            <p class="p-color" style="color: white;">*默认所有产品可用</p>
        </el-col>
    </el-row>
    <el-row v-if="permission">
        <el-col :span="24">
            <el-form :inline="true" :model="form" class="demo-form-inline">

                <el-form-item label="">
                    <el-select v-model="form.tname" v-if="disable_select" @change="changeTname()" disabled placeholder="产品范围">
                        <el-option v-for="item in tname_list" :value="item.value" :label="item.label"></el-option>
                    </el-select>
                    <el-select v-model="form.tname" v-else @change="changeTname()" placeholder="产品范围">
                        <el-option v-for="item in tname_list" :value="item.value" :label="item.label"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="">
                    <el-radio-group v-model="form.mode">
                        <el-radio label="0">不包含</el-radio>
                        <el-radio label="1">包含</el-radio>
                    </el-radio-group>
                </el-form-item>

                <el-form-item label="" label-width="120px">
                    <el-input v-model="form.record_id" @keyup.enter.native="onCreate()"  placeholder="产品ID,多个请用英文逗号 , 隔开" style="width: 500px;"></el-input>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" v-if="loading">添加<i class="el-icon-loading"></i></el-button>
                    <el-button type="primary" v-else @click="onCreate()">添加</el-button>
                    <el-button @click="location.href='/coupon/index'">返回</el-button>
                </el-form-item>

            </el-form>
        </el-col>


    </el-row>





    <!--对话框-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">搜索结果:</h4>
<!--                    <blockquote >-->
                        <p class="bg-purple-dark grid-content" style="color: white;line-height: 36px;margin-top: 10px;text-indent: 2em;">如果选项是灰色的说明该产品已经进行过筛选操作</p>
<!--                    </blockquote>-->
                </div>
                <div class="modal-body">


                    <el-transfer
                        v-model="form.ids"
                        :data="data"
                        :titles="['备选项','已选项']"
                        :button-texts="['移除','添加']"
                    ></el-transfer>


                </div>
                <div class="modal-footer">
<!--                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>-->
<!--                    <button type="button" class="btn btn-primary" @click="onSave()">保存</button>-->
                    <el-button data-dismiss="modal">取消</el-button>
                    <el-button type="primary" v-if="loading">保存<i class="el-icon-loading"></i></el-button>
                    <el-button type="primary" v-else @click="onSave()">保存</el-button>
                </div>
            </div>
        </div>
    </div>




<!--    展示列表-->
    <el-row class="grid-content">
        <el-col :span="22" :offset="1">
            <el-table
                ref="multipleTable"
                :data="special_list"
                border
                tooltip-effect="dark"
                style="width: 100%"
                min-height="250"
                max-height="800"
                @selection-change="selectedAction"
                v-loading="flashing"
                element-loading-text="刷新一下~"

            >
                <el-table-column
                    type="selection"
                    width="55">
                </el-table-column>
                <el-table-column
                    prop="product_id"
                    label="产品编号"
                    width="120"
                    show-overflow-tooltip>
                </el-table-column>
                <el-table-column
                    prop="title"
                    label="产品名称">
                </el-table-column>
                <el-table-column
                    prop="ctype"
                    label="产品类型">
                </el-table-column>
                <el-table-column
                    prop="cmode"
                    label="包含关系">
                </el-table-column>
            </el-table>
            <div style="margin-top: 20px" v-if="permission">
                <el-button type="primary" v-if="on_del">删除<i class="el-icon-loading"></i></el-button>
                <el-button type="primary" v-else @click="batchDel()">删除</el-button>
            </div>
        </el-col>
    </el-row>
</div>

<script>
    //检测权限
    var permission = '<?= Helper::checkPermission(CouponController::$admin_role) ?>';
    //产品类型列表
    var tname_list = <?= json_encode($tname_list); ?>;
    var csrf_token = "<?= Yii::$app->request->csrfToken ?>";
    //所属批次 id
    var model_id = "<?= $model->id ?>";
    //产品类型列表
    var special_type_list = <?= json_encode(Yii::$app->params['coupon_tname_type']) ?>;

    var special_page = new Vue({
        el: '#special_page',
        data: {
            //是否是管理权限
            permission: permission,
            //对应的展示列表
            special_list: [],
            //被复选中的 id 列表
            multiple_selection: [],
            //可用展示内容的下拉框
            tname_list: [],
            //如果列表太短就禁止选择
            disable_select: false,
            //是否是异步请求状态
            loading: false,
            //是否在刷新列表状态
            flashing: false,
            //是否在删除状态
            on_del: false,

            form: {
                tname: "",
                mode: "0",
                record_id: "",
                ids: [],
                type: 0
            },
            //穿梭框左侧备选菜单
            data : [
                {key:1,label:'备选项1'}
            ],
            value1: [],
            //类型列表
            type_list: {
                'house_details' : 0,
                'travel_activity' : 1,
                'travel_higo' : 2,
                'hotel' :3
            }

        },
        mounted: function () {
            //加载范围列表
            for(item in tname_list){
               this.tname_list.push({
                   value: item,
                   label: tname_list[item]
               })
            }
            this.form.tname = this.tname_list[0].value || "";

            if(this.tname_list.length <= 1){
                this.disable_select = true;
            }

            this.flashTable();

        },
        methods: {
            //显示添加内容的模态框
            onCreate: function(){
                this.searchByIds(this.form.record_id,this.form.tname)
            },
            openDialog: function(){
                this.form.ids = [];
                $("#myModal").modal('show')
            },
            closeDialog: function(){
                $("#myModal").modal('hide')
            },
            //批量删除指定产品
            batchDel: function(){
                var _self = this;

                this.$confirm('此操作将永久删除所选内容, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                })
                    .then(function(){
                        _self.postDel();
                    })
                    .catch(function(){
//                        _self.alertInfo("已取消操作",'info')
                        console.log("已取消操作")
                    })

            },
            postDel: function(){
                var _self = this;
                var form_data = new FormData();
                form_data.append('_csrf-backend',csrf_token);
                //根据 tname 分组获取 id
                this.multiple_selection.map(function(item){
                    var key = "tname[" + item.tname + "][]";
                    form_data.append(key,item.product_id)
                });

                var url = "/coupon/special-del?id=" + model_id;
                _self.on_del = true;
                axios.post(url,form_data)
                    .then(function(res){
                        _self.on_del = false;
                        if(res.data.code == 200){
                            _self.alertInfo('已删除','success');
                            _self.flashTable();
                        }else{
                            _self.alertInfo(res.data.error,'error');
                        }
                    })
                    .catch(function(res){
                        _self.on_del = false;
                        console.log(res)
                        _self.alertInfo('权限不足','warning');
                    });

            },
            //表单选择事件,将以选中的条目同步到一个数组中待用
            selectedAction: function(row){
                this.multiple_selection = row;
            },
            //刷新 table 内容
            flashTable: function(){
                var _self = this;
                var url = '/coupon/special-list?id=' + model_id;
                _self.flashing = true;
                axios.get(url)
                    .then(function(res){

                        _self.flashing = false;
                        if(res.data.code == 200){
                            _self.special_list = _self.generateSpecialList(res.data.body);
                        }else{
                            _self.alertInfo('发生未知错误','error')
                        }
//                        console.log(res,_self.special_list)

                    })
                    .catch(function (error) {
                        _self.flashing = false;
                        console.log('error',error)
                    })

            },
            onSave: function(){
                var _self = this;
                _self.loading = true;
                var form_data = new FormData();
                form_data.append('_csrf-backend',csrf_token);
                for(key in this.form){
                    if(key == 'ids'){
                        this.form.ids.map(function(item){
                            item = parseInt(item);
                            form_data.append('ids[]',item)
                        })
                    }else{
                        form_data.append(key,this.form[key])
                    }
                }


                var url = '/coupon/special-store?id=' + model_id;
                axios.post(url,form_data)
                    .then(function(res){
                        _self.loading = false;
                        if(res.data.code == 200){
                            _self.closeDialog();
                            _self.flashTable();
                            _self.alertInfo('已保存','success');
                        }else{
                            _self.alertInfo(res.data.error,'error');
                        }
                    })
                    .catch(function (error) {
                        _self.loading = false;
                        console.log('error',error)
                        _self.alertInfo('权限不足','warning');
                    })


            },
            //构建 table 的内容展示
            generateSpecialList: function(data){
                var contain_type = ['不包含','包含'];
                //special_type_list 取自外部变量
                data.map(function(item){
                    item.cmode = contain_type[item.mode];
                    item.ctype = special_type_list[item.type];
                    return item
                });
                return data
            },
            //根据请求到的数据生成可选产品列表
            generateData: function(body){
                var data = [];
                data = body.map(function(item){
                    //如果是重复的选项则禁掉
                    if(item.is_exist == 1){
                        var exist = true
                    }else{
                        var exist = false;
                    }
                    return {
                        key: item.id,
                        label: item.title,
                        disabled: exist
                    };
                });
                this.data = data;
            },
            //筛选条件的方法,暂不开放
            filterMethod: function(query, item){
//                console.log(query,item)
//                return true;
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
            searchByIds: function(ids,tname){
                if(ids == "" || tname == ""){
                    this.alertInfo("请输入产品 id","warning");
                    return false;
                }
                var form_data = new FormData();
                form_data.append('_csrf-backend',csrf_token);
                form_data.append('ids',ids);
                form_data.append('tname',tname);
                var _self = this;

                _self.loading = true;
                var curl = '/coupon/search-ids?id=' + model_id;
                axios.post(curl,form_data)
                    .then(function(res){
                        _self.loading = false;
//                        console.log(res)
                        if(res.data.code == 200){
                            _self.generateData(res.data.body);
                            _self.openDialog();
                        }else{
                            _self.alertInfo(res.data.error,'error')
                        }
                    })
                    .catch(function (error) {
                        _self.loading = false;
                        console.log('error',error)
                        _self.alertInfo('权限不足','warning');
                    })

            },
            //当tname 发生改变的时候对应的 type 也会发生变化
            changeTname: function(){
                this.form.type = this.type_list[this.form.tname];
            }

        }
    })
</script>