<?php
namespace backend\components;

/**
 * 借贷宝消息常量定义类
 *
 * @author hongcq
 *
 */
class JdbConsts
{

    /** @var int 0:正常 */
    const INFO_OK = 0;

    /** @var int 1:错误 */
    const INFO_ERROR = 1;

    /** @var int 3:没有更多数据 用于上拉 */
    const INFO_NOFIND = 102;

    //域名
    const DOMSIN_NAME = 'http://114.215.118.74';

    //图片前缀地址
    const DOMAIN_FACE = 'http://img.tgljweb.com/';
    const QINIU_ACCESS_KEY='7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
    const QINIU_SECRET_KEY='XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';

    //------订单状态常量------
    const ORDER_STATUS_NOPAY = 0; //未支付
    const ORDER_STATUS_NOUSE = 1; //待入住，支付成功
    const ORDER_STATUS_USE = 2; //待离店，已入住
    const ORDER_STATUS_OK = 3; //订单已经完成
    const ORDER_STATUS_CANCEL = 4; //订单失败,待退款
    const ORDER_STATUS_FAIL = 5; //订单失效

    //-------房源状态常量-----
    const HOUSE_STATUS_NONE = 0; //未审核
    const HOUSE_STATUS_OK = 1; //正常
    const HOUSE_STATUS_FAIL = 2; //冻结
    const HOUSE_STATUS_USE = 3; //使用中

    /** @var string redis用户登陆 */
    const REDIS_USER_LOGIN_TOKEN = 'User:Logined:%s'; //用户登陆token拼装
    const REDIS_USER_LOGIN = 'Userloined'; //用户登陆token集合key
    //------房源筛选条件------
    //商圈
    const BUSINESS_CENTER = 0;
    //景点
    const SPOT = 1;
    //区域
    const AREA = 2;
    //------活动状态------
//    未开始
    const ACTIVITY_NOSTART = 0;
    //已开始
    const ACTIVITY_ING = 1;
    //已结束
    const ACTIVITY_END = 2;

//    排序方式
//    价格低到高
    const PRICE_ASC = 0;
//    价格高到底
    const PRICE_DESC = 1;
//    销量优先
    const SALES = 2;
    //按评价
    const COMMIT_NUM = 3;

    //------提现方式------
    const PROFIT_WEIXIN = 0;
    const PROFIT_ALIPAY = 1;

//business_center
//
//    ////////redis key定义列表////////////////////
//    /** @var int 悬赏详情key+topic_uuid */
//    const REDIS_KEY_TOPIC_INFO = 's:topic:info:';
//    /** @var int 悬赏红包详情key+bonus_uuid */
//    const REDIS_KEY_BONUS_REWARD_INFO = 's:bonus:reward:info:';
//    /** @var int P2P红包详情key+bonus_uuid */
//    const REDIS_KEY_BONUS_P2P_INFO = 's:bonus:p2p:info:';
//    /** @var int 悬赏红包详情key+reply_uuid */
//    const REDIS_KEY_REPLY_INFO = 's:reply:info:';
//    /** @var int 悬赏飘新key+topic_uuid */
//    const REDIS_KEY_REWARD_TIP = 's:topic:tip:';
//    /** @var int 系统概要统计key+#key_idx#+user_uuid */
//    const REDIS_KEY_PROFILE_TIP = 's:profile:#key#:';
//    /** @var int 悬赏详情信息key+topic_uuid */
//    const REDIS_KEY_TOPIC_DETAIL = 's:topic:detail:';
//    /** @var int 红包抵扣券信息key+bonus_uuid */
//    const REDIS_KEY_COUPON_INFO = 's:bonus:coupon:info:';
//
//    //举报分类
//    const REPORT_CATEGORY_SEX = '色情低俗';
//    const REPORT_CATEGORY_AD = '广告骚扰';
//    const REPORT_CATEGORY_POLITICS = '政治敏感';
//    const REPORT_CATEGORY_ILLEGAL = '违法（暴力恐怖、违禁品等）';
//    const REPORT_CATEGORY_OTHER = '不能不选';
}
