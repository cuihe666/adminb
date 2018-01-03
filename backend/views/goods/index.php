<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/7/7
 * Time: 下午6:03
 */
$this->title = '商品库';
$this->params['breadcrumbs'][] = '商品库';
?>
<div id="goods-list" v-cloak>

    <!--筛选表单部分-->
    <el-row>
        <el-col :span="24">
            这里是筛选表单
        </el-col>
    </el-row>


    <!--列表展示部分-->
    <el-row>
        <el-col :span="24">
            <el-button type="primary" size="mini">创建商品</el-button>
        </el-col>
        <el-col :span="24">
<!--            tab切换页-->
            <el-tabs v-model="tab_status" @tab-click="handleClick" >

                <!--全部商品列表-->
                <el-tab-pane label="全部" name="all">

                    <el-row>
                        <el-col span="24">

                            <el-table
                                :data="all_table.data"
                                v-loading.body="all_table.loading"
                                @sort-change="sortMethod"
                                border
                                style="width: 100%">
                                <el-table-column
                                    label="商品图片"
                                    prop="post_image"
                                    width="150">
                                    <template scope="scope">
                                        <img :src="scope.row.post_image + '?imageView2/1/w/100/h/100/q/75|imageslim'" alt="" width="100">
                                    </template>
                                </el-table-column>
                                <el-table-column label="商品名称" >
                                    <template scope="scope">
                                        {{ scope.row.title }}
                                    </template>
                                </el-table-column>

                                <el-table-column label="商品分类">
                                    <template scope="scope">
                                        {{ scope.row.category_breadcrumbs }}
                                    </template>
                                </el-table-column>


                                <el-table-column label="商品价格" width="100">
                                    <template scope="scope">
                                        {{ scope.row.price }}
                                    </template>
                                </el-table-column>

                                <el-table-column label="商品库存" width="100">
                                    <template scope="scope">
                                        {{ scope.row.stocks }}
                                    </template>
                                </el-table-column>

                                <el-table-column label="创建时间" width="160">
                                    <template scope="scope">
                                        {{ scope.row.created_at }}
                                    </template>
                                </el-table-column>

                                <el-table-column label="商品状态" width="100">
                                    <template scope="scope">
                                        {{ scope.row.status }}
                                    </template>
                                </el-table-column>

<!--                                <el-table-column label="操作">-->
<!--                                    <template scope="scope">-->
<!--                                       -->
<!--                                    </template>-->
<!--                                </el-table-column>-->
                            </el-table>
                        </el-col>

                        <el-col :lg="6" :md="6" :sm="24" :xs="24" class="col-top-5">
<!--                            <el-button type="primary" size="small">批量上架</el-button>-->
                        </el-col>

                        <el-col :lg="18" :md="18" :sm="24" :xs="24" style="text-align: right" class="col-top-5">
                            <el-pagination
                                @current-change="currentPageChange"
                                :current-page.sync="all_table.pagination.current_page"
                                :page-size="all_table.pagination.page_size"
                                layout="prev, pager, next, jumper"
                                :total="all_table.pagination.total">
                            </el-pagination>
                        </el-col>
                    </el-row>

                </el-tab-pane>

                <el-tab-pane label="在售中" name="on_sell">在售中</el-tab-pane>
                <el-tab-pane label="仓库中" name="in_store">仓库中</el-tab-pane>
                <el-tab-pane label="审核中" name="auditing">审核中</el-tab-pane>
                <el-tab-pane label="审核未通过" name="refuse">审核未通过</el-tab-pane>
            </el-tabs>
        </el-col>
    </el-row>


</div>
<script>

    //商品状态列表
    var goods_status_list = <?= $status_list ?>;
    var data = {
        //当前tab的 name
        tab_status: 'all',

        tableData: [{
            date: '2016-05-02',
            name: '王小虎',
            address: '上海市普陀区金沙江路 1518 弄',
            tag: '家'
        }, {
            date: '2016-05-04',
            name: '王小虎',
            address: '上海市普陀区金沙江路 1517 弄',
            tag: '公司'
        }, {
            date: '2016-05-01',
            name: '王小虎',
            address: '上海市普陀区金沙江路 1519 弄',
            tag: '家'
        }, {
            date: '2016-05-03',
            name: '王小虎',
            address: '上海市普陀区金沙江路 1516 弄',
            tag: '公司'
        }],
        currentPage3: 5,
        //全部列表状态
        all_table:{
            loading: false,
            data: [],
            pagination: {
                current_page: 1,
                page_size: 0,
                total: 0
            }
        }

    };
    var goods_list = new Vue({
        el: '#goods-list',
        mixins: [commonMethod],
        data: data,
        methods: {
            handleClick: function(tab,event){
                console.log(tab,event)
            },
            filterTag: function(value,row){
                console.log(value,row);
                return row.tag === value
            },
            sortMethod: function(column, prop,order){
                console.log(column, prop, order)
            },
            testMethod: function(a,b){
                console.log('test',a,b);
            },
            //当前页数发生改变
            currentPageChange: function(val){
                var table_name = this.getTableName();
                if(val != parseInt(this.$data[table_name].pagination.current_page)){
                    console.log('不是同一页内容');
                    this.getGoodsList(val);
                }
            },
            //将远程接受的参数构建成前端可显示的
            buildTable: function(data,table_name){
//                console.log('表名:',table_name,'表内容:',data);
                var arr = data.data.map(function(item){
                    //转换分类内容
                    if(item.category_breadcrumbs != ''){
                        var category = JSON.parse(item.category_breadcrumbs);
                        item.category_breadcrumbs = category[0].label + '>' + category[1].label + '>' + category[2].label;
                    }else{
                        item.category_breadcrumbs = '暂无';
                    }
                    //转换商品状态
                    item.status = goods_status_list[item.status];
                    return item
                });
                data.data = arr;
                this.$data[table_name] = data;
            },
            //获取当前激活的表名
            getTableName: function(){
                return this.tab_status + '_table';
            },
            //构建请求地址信息
            buildUrl: function(url,params){
                url += '?';
                for(key in params.params){
                    url += key + "=" + params.params[key] + "&";
                }
                return url;
            },
            //获取商品列表
            getGoodsList: function(page){
                page = page || 1;
                //请求的数据将要赋给的表
                var table_name = this.getTableName();
                //基本 url 地址
                var url = '/goods/goods-list';
                //请求的参数
                var params = {
                    params: {
                        page: page,
                        status: this.tab_status
                    }
                };
                var _self = this;
                _self.$data[table_name].loading = true;
                axios.get(url,params)
                    .then(function(res){
                        console.log(res,_self.tab_status);
                        _self.$data[table_name].loading = false;
                        if(res.data.code == 200){
//                            _self.$data[table_name] = res.data.message;
                            _self.buildTable(res.data.message,table_name)

                        }
                    })
                    .catch(function(error){
                        _self.$data[table_name].loading = false;
                        _self.alertInfo('系统繁忙,请稍候');
                        console.log(error);
                    })
            }
        },
        mounted: function(){
            //初始化时显示的默认页面
            this.getGoodsList();
        },
        watch: {
            'tab_status': function(val){
                console.log('当前状态',val);
            }
        }
    });
</script>
