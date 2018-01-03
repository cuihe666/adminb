/**
 * Created by gpf on 2017/7/6.
 */
var commonMethod = {
    data: {
        //图片上传表单
        uploadForm: {
            key: '',
            token: '',
            file: 'test.jpg'
        },
        //展示图片用的 dialog 显隐开关
        imageDialogVisible: false,
        //所展示图片地址
        dialogImageUrl: '',
        //图片在图片数组中所处的下标
        dialogImageIndex: 0,
        //图片上传后的 host 名
        img_host: '',
        //图片要锁参数
        image_indent: 'imageView2/1/w/640/h/640/q/75|imageslim'

    },
    watch: {},
    methods: {
        //时间格式化
        cTimeFormat: function (date) {
            if (!date) return '';
            var year = date.getYear() + 1900;
            var month = date.getMonth() + 1;
            var day = date.getDate();
            var str = year + '-' + month + '-' + day;
            return str;
        },
        //将远程数据初始化到页面
        initPageResource: function (data) {
            for (key in data) {
                this.$data[key] = data[key]
            }
        },

        getImageToken: function () {
            var _self = this;
            var form_data = new FormData();
            form_data.append('_csrf', csrf_token);

            return axios.post('/goods/token', form_data).then(function (response) {
                _self.uploadForm.token = response.data.token;
                _self.img_host = response.data.host;
                // console.log('getImageToken success>>>token => ' + response.data.token);
                // console.log(response,_self.uploadForm);
            })
        },


        //批量弹出错误信息
        batchError: function (errors) {
            if (typeof errors == 'string') {
                errors = [errors];
            }
            if (errors instanceof Array) {
                var error_list = errors;
                var _self = this;
                //由于同时打印的时候会导致弹窗重叠起来,添加了一个计时器
                var timer = setInterval(function () {
                    if (error_list.length > 0) {
                        var error = error_list.shift();
                        _self.alertInfo(error, 'error');
                    } else {
                        clearInterval(timer)
                    }
                }, 200)
            } else {
                this.alertInfo('debug', 'warning');
            }

        },
        //点击密码显隐
        showPassword: function (key) {
            if (this.$data[key] == 'password') {
                this.$data[key] = 'text';
            } else {
                this.$data[key] = 'password';
            }

        },
        //生成提示的方法
        alertInfo: function (msg, type, action) {
            if (action == 'alert') {
                this.$alert(msg, '提示', {
                    closeOnPressEscape: true
                })
            } else {
                this.$notify({
                    title: '提示',
                    message: msg,
                    type: type
                });
            }

        },
        //检测字段信息
        checkField: function (formName, field, callback) {
            this.$refs[formName].validateField(field, callback);
        },
        //消息提示发放
        message: function (msg, type) {
            this.$message({
                type: type,
                message: msg
            });
        },
        /**
         *
         * @param url       请求地址
         * @param form      请求表单内容
         * @param callback  回调函数
         * @param loading   存储加载状态的key
         */
        postMethod: function (url, form, callback, loading) {
            var _self = this;
            var form_data = new FormData();
            for (key in form) {
                form_data.append(key, form[key])
            }
            form_data.append('_csrf', csrf_token);

            _self.$data[loading] = true;
            axios.post(url, form_data)
                .then(function (res) {
                    _self.$data[loading] = false;
                    if (res.data.code != 200) {
                        _self.batchError(res.data.error);
                    }
                    callback(res);
                })
                .catch(function (error) {
                    _self.$data[loading] = false;
                    _self.alertInfo('系统繁忙,请稍候');
                    console.log(error);
                })
        },
        getMethod: function (url, params, callback, loading) {
            var _self = this;
            _self.$data[loading] = true;
            axios.get(url, {params: params})
                .then(function (res) {
                    _self.$data[loading] = false;
                    if (res.data.code != 200) {
                        _self.batchError(res.data.error);
                    }
                    // console.log('get 方法返回内容',res);
                    callback(res);

                })
                .catch(function (error) {
                    _self.$data[loading] = false;
                    _self.alertInfo('系统繁忙,请稍候');
                    console.log(error);
                })
        },
        /**
         * 重置表单
         * @param formName
         */
        resetForm: function (formName) {
            this.$refs[formName].resetFields();
        },

        /**
         * 执行需要确认时的函数
         * @param message           提示信息
         * @param successCallback   成功时的回调
         * @param errorCallback     失败时的回调
         */
        confirmHandle: function (message, successCallback, errorCallback) {
            var _self = this;
            _self.$confirm(message, '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(function () {
                successCallback();
                _self.$message({
                    type: 'info',
                    message: '已执行'
                });
            }).catch(function () {
                if (errorCallback) {
                    errorCallback();
                }

                _self.$message({
                    type: 'info',
                    message: '已取消'
                });
            });
        },
        /**
         * 基于 sessionStorage 的本地存储
         * @param key
         * @param value
         */
        setCache: function (key, value) {
            if (window.sessionStorage) {
                sessionStorage.setItem(key, JSON.stringify(value));
                return true;
            } else {
                return false;
            }
        },
        getCache: function (key) {
            if (window.sessionStorage) {
                var value = sessionStorage.getItem(key);
                return JSON.parse(value) || [];
            } else {
                return false;
            }
        },
        lazySetCache: _.debounce(function (key, value) {
            this.setCache(key, value);
        }, 500),
        clearCache: function (key) {
            if (window.sessionStorage) {
                if (key) {
                    return window.sessionStorage.removeItem(key);
                } else {
                    return window.sessionStorage.clear();
                }
            } else {
                return false;
            }

        }
    }
};
// <el-row :gutter="20">
//     <el-col :span="12" :md="8" :sm="8" :xs="24">
//     <el-form-item label="运费模板" prop="logistics_tpl_id">
//     <el-select v-model="params_fix_block.logistics_tpl_id"  placeholder="请选择运费模板">
//     <el-option v-for="item in post_tpl_list"  :value="item.value" :label="item.label"></el-option>
//     </el-select>
//     </el-form-item>
//     </el-col>
//
//     <el-col :span="12" :md="6" :sm="6" :xs="24" style="text-align: center">
//     <el-button type="text">刷新</el-button>
//     <span style="margin: 0px 10px;">|</span>
//     <el-button type="text">+新增运费模板</el-button>
//     </el-col>
//     </el-row>