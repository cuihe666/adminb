/**
 * 匹配中文
 * @param str string    要匹配的字符串
 * @param length number|object  数字最大长度值或对象的范围长度值
 * @demo
        var res = regexpChineseStringNum('中文',{
            min:100,
            max:100
        });
        console.log(res);//false

        var res = regexpChineseStringNum('中文111',10);
        console.log(res);//true
 */
function regexpChineseStringNum(str,length){
    var min = 0;
    var max = 0;
    switch(typeof length){
        case 'number':
            min = 1;
            max = length;
        break;
        case 'object':
            min = length.min || 0;
            max = length.max || 0;
        break;
    }
    if( min<=0 || max<=0 ){
        throw '匹配中文:min或max的值不存在';
    }

    var regStr  = '^[\u4e00-\u9fa50-9a-zA-Z]{'+min+','+max+'}$';
    var reg     = new RegExp(regStr);
    return reg.test(str);
}