/**
 * Created by cuihe on 2017/9/18.
 */
function serveUrl() {
    var obj={
        '106.14.239.108':'https://test-javaapis.tgljweb.com',//测试

        '139.196.252.26':'https://pre-javaapis.tgljweb.com',//预发布

        'admin.tgljweb.com':'https://javaapis.tgljweb.com',//生产
        'testadmin.tgljweb.com':'https://test-restru-javaapis.tgljweb.com' // 重构的服务器

    };
    var head=window.location.hostname;
    return obj[head]||'https://test-javaapis.tgljweb.com';
}