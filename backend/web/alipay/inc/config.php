<?php
//====数据库配置=====
$lp_db_ver = "5.0"; //数据库版本
$lp_db_server = "rm-m5etai2t5ja87h16u.mysql.rds.aliyuncs.com"; //数据库登陆地址
$lp_db_port = "3306"; //端口，不填为按默认
$lp_db_username = "tangguoabc"; //数据库用户名
$lp_db_password = "Tg#2016#abc123567"; //数据库密码
$lp_db_dbname = "tangguo"; //数据库名
$lp_db_char = "utf8"; //数据库默认编码
$dbtbpre = ""; //数据表前缀

//====异常信息=====
$errormsg = array(
    202       => 'empty',
    203       => 'curl error',
    204       => 'not curl extension',
    205       => 'sql error',
    208       => 'query sql is wrong',
    302       => 'no permission',
    304       => 'not connect to the database',
    501       => 'API collection is empty',
    502       => 'The database can not write',
    600       => 'orderno not found',
    601       => 'house not time',
    602       => 'update db warring',
    603       => 'params is req',
    606       => 'sign error',
    607       => 'function params is req',
    608       => 'DB routine is error'
);

$smsconfig = array(
    100 => '【棠果APP】尊敬的%s: 您预定的%s已支付成功。入住时间：%s至%s，%s之前为退款时间。房东联系电话：%s。祝您入住愉快！http://www.xywykj.com/',
    200 => '【棠果APP】尊敬的%s:联系方式为%s的用户预定了您的%s。预定时间为%s至%s，详情请登录棠果APP查看！http://www.xywykj.com/',
    300 => '【棠果旅居】预订成功：%s %s入住 棠果旅居 （%s）%s 总计%s天，总价%s元，订单在%s号后不能取消修改。特别提示：房源地址%s，房东电话：%s，请登陆棠果APP查询详情，客服电话：400 024 2711',
    400 => '【棠果旅居】您有一个订单“%s”的用户将于%s-%s入住（%s）请保持手机畅通。特别提醒：房客手机号：%s，客服电话：400 024 2711',
    500=>'【棠果旅行】您购买的产品（%s） 已支付成功。如对产品有疑问，请按照产品页面提供的联系方式，及时确认相关行程。'
);

$sms_return_msg=array(
    101=>'参数错误',
    102=>'号码错误',
    103=>'当日余量不足',
    104=>'请求超时',
    105=>'用户余量不足',
    106=>'非法用户',
    107=>'提交号码超限',
    111=>'签名不合法',
    120=>'内容长度超长，请不要超过500个字',
    121=>'内容中有屏蔽词',
    131=>'IP非法'
);


?>
