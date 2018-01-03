/**
 * Created by gpf on 2017/7/3.
 */
//检测电话号码格式
var checkPhone = function(rule,value,callback){
    if (value == ''){
        callback(new Error('请输入系统管理员手机号码'));
    }else{
        var pattern = /^1[34578]\d{9}$/;
        if(pattern.test(value)){
             callback();
        }else{
            callback(new Error('请输入正确的手机号码'));
        }
    }
};
//检测密码是否一致(仅用于注册)
var confirmPwd = function(rule,value,callback) {
    if (value == ''){
        callback(new Error('请确认密码'));
        return;
    }

    if(register.ruleForm.password == ''){
        callback(new Error('请输入密码'));
        return;
    }

    if(register.ruleForm.password != value){
        callback(new Error('两次输入的登录密码不一致'));
    }
    callback();
};

var checkPrice = function(rule,value,callback){
    price = parseFloat(value);
    if(price > 0){
        callback();
    }else{
        callback(new Error('价格最低不能为0'));
    }
}

//验证数字,浮点数不多余两位
var checkNumber = function(rule,value,callback){
    if(!value){
        callback();
        return;
    }

    var pattern = /^[0-9]+(.[0-9]{1})?$/;
    if(pattern.test(value)){
        callback();
    }else{
        callback(new Error('需要是数字格式,小数点最多后一位'));
    }
}

//验证数字,浮点数不多余两位
var checkNumberType = function(rule,value,callback){
    if(!value){
        callback();
        return;
    }

    var pattern = /^[0-9]+$/;
    if(pattern.test(value)){
        callback();
    }else{
        callback(new Error('需要是数字格式'));
    }
}


//规定只能字符数字下划线
var usernameRule = function(rule,value,callback){
    if(!value){
        callback();
        return;
    }

    var pattern = /^[0-9a-zA-Z]{1,}$/;
    if(pattern.test(value)){
        callback();
    }else{
        callback(new Error('仅可用字母和数字'));
    }
};

//验证 ASCII 码的正则
var checkASCII = function(rule,value,callback){
    if(!value){
        callback();
        return;
    }

    var pattern = /^[\x00-\xff]+$/;
    if(pattern.test(value)){
        callback();
    }else{
        callback(new Error('仅可用字母,数字和常用符号'));
    }
};

//验证空数组json的方法
var emptyArrayJson = function(rule,value,callback){
    var array = JSON.parse(value);
    if(array.length == 0){
        callback(new Error('不可为空'));
    }else{
        callback();
    }
};

//检测数据大小值
var checkNumRange = function(rule,value,callback){
    if(value.length == 0){
        callback();
        return;
    }
    var val1 = parseInt(value[0]);
    var val2 = parseInt(value[1]);

    if(isNaN(val1) || isNaN(val2)){
        callback(new Error('请填入数字范围'));
    }

    if(val1 > val2){
        callback(new Error('前者值不可大于后者'));
    }else{
        callback();
    }
};